<?php

require_once __DIR__ . '/classes/Products.php';

session_start();

try {
    $products = (new Products())->getAll();
} catch (Exception $e) {
    $products = [];
    $dbError = "Сервис временно недоступен";
}

function formatPrice($price)
{
    return number_format($price / 100, 2, '.', ' ') . ' руб.';
}
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Тестовое задание</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script type="module" src="public/index.js"></script>
    </head>
    <body>
        <button class="btn btn-dark mb-3" data-bs-toggle="offcanvas" data-bs-target="#cart">
            Корзина
        </button>

        <div class="container py-5">
            <?php if (isset($dbError)): ?>
                <div class="alert alert-danger">
                    <?= $dbError ?>
                </div>
            <?php else: ?>
                <h1 class="mb-4">Каталог товаров</h1>
                <div class="row">
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card p-3 h-100">
                                <h4>
                                    <?= htmlspecialchars($product['title']) ?>
                                </h4>
                                <p>
                                    <?= formatPrice($product['price']) ?>
                                </p>
                                <button class="btn btn-primary" onclick="addProduct(<?= $product['id'] ?>)">
                                    В корзину
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="cart">
            <div class="offcanvas-header">
                <h5>Корзина</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body" id="cart-content"></div>
        </div>

        <div id="alerts" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>
    </body>
</html>
