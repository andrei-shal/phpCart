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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>phpCart</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script type="module" src="public/index.js"></script>

        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f4f6f9;
                color: #1a1a1a;
            }

            .product-card {
                border: none;
                border-radius: 16px;
                overflow: hidden;
                background: #ffffff;
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
            }

            .product-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08) !important;
            }

            .product-img-wrapper {
                background-color: #f8f9fa;
                padding: 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 240px;
                position: relative;
            }

            .product-img {
                max-height: 100%;
                max-width: 100%;
                object-fit: contain;
                transition: transform 0.5s ease;
            }

            .product-card:hover .product-img {
                transform: scale(1.04);
            }

            .product-title {
                font-size: 1.1rem;
                font-weight: 600;
                line-height: 1.4;
                height: 48px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                margin-bottom: 8px;
                color: #212529;
            }

            .product-price {
                font-size: 1.25rem;
                font-weight: 700;
                color: #0d6efd;
                margin-bottom: 0;
            }

            .btn-add-cart {
                border-radius: 10px;
                padding: 10px 20px;
                font-weight: 600;
                transition: all 0.2s ease;
            }

            .floating-cart-btn {
                position: fixed;
                bottom: 30px;
                right: 30px;
                z-index: 1030;
                padding: 15px 25px;
                border-radius: 50px;
                box-shadow: 0 8px 24px rgba(13, 110, 253, 0.3);
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .no-photo-placeholder {
                background: linear-gradient(45deg, #e9ecef, #f8f9fa);
                height: 240px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                color: #6c757d;
            }
        </style>
    </head>
    <body>
        <button class="btn btn-primary floating-cart-btn" data-bs-toggle="offcanvas" data-bs-target="#cart">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bag-dash-fill" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0M6 9.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1z"/>
            </svg>
            <span>Корзина</span>
            <span id="cart-badge-count"></span>
        </button>

        <div class="container py-5">
            <?php if (isset($dbError)): ?>
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center py-5">
                        <div class="alert alert-custom p-4 bg-white rounded-4 shadow-sm border-start border-danger border-4">
                            <h4 class="text-danger mb-2">Упс! Что-то пошло не так</h4>
                            <p class="text-muted mb-0"><?= $dbError ?></p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="d-flex align-items-center justify-content-between mb-5">
                    <div>
                        <h1 class="fw-bold tracking-tight mb-1">Каталог товаров</h1>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
                    <?php foreach ($products as $product): ?>
                        <div class="col">
                            <div class="card product-card h-100 shadow-sm">

                                <div class="product-img-wrapper">
                                    <?php if (!empty($product['image_path'])): ?>
                                        <img
                                                src="<?= htmlspecialchars($product['image_path']) ?>"
                                                class="product-img"
                                                alt="<?= htmlspecialchars($product['title']) ?>"
                                                loading="lazy"
                                        >
                                    <?php else: ?>
                                        <div class="no-photo-placeholder w-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-image text-muted mb-2" viewBox="0 0 16 16">
                                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                                            </svg>
                                            <small class="text-muted fw-medium">Фото временно отсутствует</small>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="card-body p-4 d-flex flex-column justify-content-between">
                                    <div class="mb-4">
                                        <h4 class="product-title" title="<?= htmlspecialchars($product['title']) ?>">
                                            <?= htmlspecialchars($product['title']) ?>
                                        </h4>
                                        <p class="product-price">
                                            <?= formatPrice($product['price']) ?>
                                        </p>
                                    </div>

                                    <button class="btn btn-primary btn-add-cart w-100 d-flex align-items-center justify-content-center gap-2" onclick="addProduct(<?= (int)$product['id'] ?>)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi py-0" viewBox="0 0 16 16">
                                            <path d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z"/>
                                            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                                        </svg>
                                        В корзину
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="offcanvas offcanvas-end border-0 shadow" tabindex="-1" id="cart" style="border-radius: 24px 0 0 24px;">
            <div class="offcanvas-header p-4 border-bottom">
                <h5 class="fw-bold mb-0">Ваша корзина</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body p-4" id="cart-content">
            </div>
        </div>

        <div id="alerts" class="position-fixed bottom-0 start-0 p-3" style="z-index: 9999;"></div>
    </body>
</html>