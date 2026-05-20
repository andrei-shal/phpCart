<?php

require_once __DIR__ . '/classes/Cart.php';
require_once __DIR__ . '/classes/Products.php';

session_start();

try {
    $products = new Products();
    $cart = new Cart();
} catch (Exception $e) {
    $products = [];
    $dbError = "Сервис временно недоступен";
}
?>

<?php if (isset($dbError)) : ?>
    <div class="alert alert-danger">
        <?= $dbError ?>
    </div>
<?php else: if (empty($cart->getItems())): ?>
    <p>Корзина пуста</p>
<?php else: ?>

    <?php foreach ($cart->getItems() as $id => $qty): ?>

        <?php
        $product = $products->getById($id);
        if (!$product) continue;
        ?>

        <div class="border p-2 mb-2">
            <strong>
                <?= htmlspecialchars($product['title']) ?>
            </strong><br>

            Цена:
            <?= number_format($qty * $product['price'] / 100, 2, '.', ' ') ?> руб.<br>

            Количество:
            <div class="counter-box">
                <button onclick="deleteProduct(<?= $id ?>)">-</button>
                <span id="count"><?= $qty ?></span>
                <button onclick="addProduct(<?= $id ?>)">+</button>
            </div>
        </div>

    <?php endforeach; ?>

    <p>
        Цена: <?= number_format($cart->getTotal() / 100, 2, '.', ' ') ?> руб.
    </p>

    <div>
        <button class="btn btn-primary" onclick="buy()">
            Купить
        </button>
        <button class="btn btn-secondary" onclick="clearCart()">
            Очистить
        </button>
    </div>

<?php endif; ?>
<?php endif; ?>

