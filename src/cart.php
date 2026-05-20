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
        <script type="module" src="public/cart.js"></script>

        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f4f6f9;
                color: #1a1a1a;
            }

            .main-card {
                border: none;
                border-radius: 16px;
                background: #ffffff;
            }

            .form-control {
                border-radius: 10px;
                padding: 12px 16px;
                border: 1px solid #dee2e6;
                transition: all 0.2s ease;
            }

            .form-control:focus {
                border-color: #0d6efd;
                box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
            }

            .modal-content {
                border: none;
                border-radius: 20px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            }

            .modal-header {
                border-bottom: 1px solid #efefef;
                padding: 24px 24px 16px 24px;
            }

            .modal-body {
                padding: 24px;
            }

            .btn-submit-order {
                border-radius: 10px;
                padding: 12px 20px;
                font-weight: 600;
            }

            .btn-catalog-fix {
                position: relative;
                z-index: 1051;
            }
        </style>
    </head>
    <body>
        <div class="container py-5" style="max-width: 800px;">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="/" class="btn btn-outline-secondary btn-sm rounded-3 d-inline-flex align-items-center gap-2 py-2 px-3 fw-medium text-decoration-none btn-catalog-fix">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg>
                    В каталог
                </a>
                <h1 class="fw-bold mb-0">Корзина</h1>
            </div>

            <div class="card main-card shadow-sm p-4">
                <div id="cart-content"></div>
            </div>
        </div>

        <div class="modal fade" id="buyModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold fs-4">Оформление заказа</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="buyForm" autocomplete="on">

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted small text-uppercase tracking-wider">Имя</label>
                                <input type="text" class="form-control" name="name" placeholder="Иван Иванов" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-muted small text-uppercase tracking-wider">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="example@mail.com" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-submit-order shadow-sm">
                                Подтвердить заказ
                            </button>

                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div id="alerts" class="position-fixed bottom-0 start-0 p-3" style="z-index: 9999;"></div>
    </body>
</html>