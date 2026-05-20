<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Тестовое задание</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script type="module" src="public/cart.js"></script>
    </head>
    <body>
        <div class="container py-5">
            <h1 class="mb-4">Корзина</h1>
            <div class="offcanvas-body" id="cart-content"></div>
        </div>

        <div class="modal fade" id="buyModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Оформление заказа</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <form id="buyForm">

                            <div class="mb-3">
                                <label class="form-label">Имя</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Подтвердить заказ
                            </button>

                        </form>

                    </div>

                </div>
            </div>
        </div>

        <div id="alerts" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>
    </body>
</html>
