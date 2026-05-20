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

    if (!preg_match('/^[a-zA-Zа-яА-Я ]+$/u', $name)) {
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

    $message = "Заказ:\n\n";
    $message .= "Имя: $name\n";
    $message .= "Email: $email\n\n";

    foreach ($cart->getItems() as $id => $qty) {
        $product = $products->getById($id);
        if (!$product) continue;

        $title = $product['title'];
        $message .= "Товар: $title | Кол-во: $qty\n";
    }

    mail($email, "Ваш заказ", $message);

    $cart->clear();

    echo json_encode(['success' => true]);
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Неизвестное действие'
    ]);
}