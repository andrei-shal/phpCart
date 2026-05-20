import { clearCartAPI, addProductAPI, deleteProductAPI, buyAPI } from "./api.js"
import {showAlert} from "./ui.js";

window.buy = () => {
    const modal = new bootstrap.Modal(document.getElementById('buyModal'));
    modal.show();
}

window.clearCart = () => {
    clearCartAPI().then(res => res.json())
    .then(data => {
        if (!data.success) showAlert(data.error);
        reloadCart();
    }).catch(() => {
        showAlert('Ошибка сервера');
    });
}

window.addProduct = (id) => {
    addProductAPI(id).then(res => res.json())
    .then(data => {
        if (!data.success) showAlert(data.error);
        reloadCart();
    }).catch(() => {
        showAlert('Ошибка сервера');
    });
}

window.deleteProduct = (id) => {
    deleteProductAPI(id).then(res => res.json())
    .then(data => {
        if (!data.success) showAlert(data.error);
        reloadCart();
    }).catch(() => {
        showAlert('Ошибка сервера');
    });
}

window.addEventListener('load', () => {
    document.querySelector('#buyForm').addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);

        buyAPI(
            formData.get('name'),
            formData.get('email')
        ).then(res => res.json())
            .then(data => {
                if (!data.success) showAlert(data.error);

                const modal = bootstrap.Modal.getInstance(document.getElementById('buyModal'));
                modal.hide();
                modal.dispose();

                reloadCart();
        }).catch(() => {
            showAlert('Ошибка сервера');
        });
    });

    reloadCart();
});

function reloadCart() {
    fetch('cart-content.php')
        .then(res => res.text())
        .then(html => {
            document.querySelector('#cart-content').innerHTML = html;
        }).catch(() => {
        showAlert('Ошибка сервера');
    });
}