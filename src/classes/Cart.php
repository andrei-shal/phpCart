<?php

require_once __DIR__ . '/Products.php';

class Cart {
    private $products;

    public function __construct() {
        $this->products = new Products();

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function add($id) {
        if (($id <= 0) or ($this->products->getById($id) == null)) {
            return "Некоректный id";
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]++;
        } else {
            $_SESSION['cart'][$id] = 1;
        }

        return null;
    }

    public function delete($id) {
        if (($id <= 0) or ($this->products->getById($id) == null)) {
            return "Некоректный id";
        }

        if (!isset($_SESSION['cart'][$id])) {
            return "Такого товара в корзине нет";
        }

        $_SESSION['cart'][$id]--;

        if ($_SESSION['cart'][$id] <= 0) {
            unset($_SESSION['cart'][$id]);
        }

        return null;
    }

    public function clear() {
        $_SESSION['cart'] = [];
    }

    public function getItems() {
        return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }

    public function getTotal() {
        $total = 0;

        foreach ($this->getItems() as $id => $qty) {
            $product = $this->products->getById($id);
            if ($product == null) {continue;}
            $total += $qty * $product['price'];
        }

        return $total;
    }
}