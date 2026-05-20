<?php

require_once __DIR__ . '/classes/Cart.php';
require_once __DIR__ . '/classes/Products.php';

header('Content-Type: application/json');

session_start();

$data = json_decode(file_get_contents('php://input'), true);

$action = isset($data['action']) ? $data['action'] : null;
$id = isset($data['id']) ? (int)$data['id'] : -1;

$cart = new Cart();
$products = new Products();

if ($action === 'add') {
    $error = $cart->add($id);

    echo json_encode([
        'success' => !$error,
        'error' => $error
    ]);
} else if ($action === 'delete') {
    $error = $cart->delete($id);

    echo json_encode([
        'success' => !$error,
        'error' => $error
    ]);
} else if ($action === 'clear') {
    $cart->clear();

    echo json_encode([
        'success' => true
    ]);
} else if ($action === 'buy') {

    $name = trim(isset($data['name']) ? $data['name'] : '');
    $email = trim(isset($data['email']) ? $data['email'] : '');

    if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ ]+$/u', $name)) {
        echo json_encode([
            'success' => false,
            'error' => 'Некоректное имя'
        ]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'success' => false,
            'error' => 'Некоректный email'
        ]);
        exit;
    }

    if (empty($cart->getItems())) {
        echo json_encode([
            'success' => false,
            'error' => 'Корзина пуста'
        ]);
        exit;
    }

    $itemsHtml = '';

    foreach ($cart->getItems() as $id => $qty) {
        $product = $products->getById($id);
        if (!$product) continue;

        $title = htmlspecialchars($product['title']);
        $price = $product['price'] / 100;
        $itemTotal = $price * $qty;

        $itemsHtml .= "
        <tr style='border-bottom: 1px solid #eef2f3;'>
            <td style='padding: 12px 0; font-size: 15px; color: #2d3748;'>{$title}</td>
            <td style='padding: 12px 10px; font-size: 15px; color: #718096; text-align: center;'>{$qty} шт.</td>
            <td style='padding: 12px 0; font-size: 15px; font-weight: bold; color: #2d3748; text-align: right; white-space: nowrap;'>" . number_format($itemTotal, 2, '.', ' ') . " руб.</td>
        </tr>
        ";
    }

    $message = "
    <!DOCTYPE html>
    <html lang='ru'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Ваш заказ</title>
        </head>
        <body style='margin: 0; padding: 0; background-color: #f4f6f8; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Helvetica, Arial, sans-serif;'>
            <table width='100%' border='0' cellspacing='0' cellpadding='0' style='background-color: #f4f6f8; padding: 20px 10px;'>
                <tr>
                    <td align='center'>
                        <table width='100%' max-width='600' border='0' cellspacing='0' cellpadding='0' style='max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);'>
                            <tr>
                                <td style='padding: 30px;'>
                                    <h3 style='margin: 0 0 15px 0; color: #2d3748; font-size: 18px; border-bottom: 2px solid #0d6efd; padding-bottom: 8px; display: inline-block;'>Данные покупателя</h3>
                                    <p style='margin: 0 0 8px 0; font-size: 15px; color: #4a5568;'><strong style='color: #718096;'>Имя:</strong> " . htmlspecialchars($name) . "</p>
                                    <p style='margin: 0 0 30px 0; font-size: 15px; color: #4a5568;'><strong style='color: #718096;'>Email:</strong> " . htmlspecialchars($email) . "</p>
        
                                    <h3 style='margin: 0 0 15px 0; color: #2d3748; font-size: 18px; border-bottom: 2px solid #0d6efd; padding-bottom: 8px; display: inline-block;'>Состав заказа</h3>
                                    
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom: 25px;'>
                                        {$itemsHtml}
                                    </table>
        
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='background-color: #f8fafc; border-radius: 12px; padding: 20px;'>
                                        <tr>
                                            <td style='font-size: 16px; font-weight: 600; color: #4a5568;'>Итого к оплате:</td>
                                            <td style='font-size: 22px; font-weight: 700; color: #0d6efd; text-align: right; white-space: nowrap;'>" . number_format($cart->getTotal()/100, 2, '.', ' ') . " руб.</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr
                        </table>
                    </td>
                </tr>
            </table>
        </body>
    </html>
    ";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    mail($email, "Ваш заказ", $message, $headers);

    $cart->clear();

    echo json_encode(['success' => true]);
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Неизвестное действие'
    ]);
}