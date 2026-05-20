import { clearCartAPI, addProductAPI, deleteProductAPI } from "./api.js"
import { showAlert } from "./ui.js";

window.buy = () => {
    window.location = "cart.php"
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