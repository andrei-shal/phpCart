<?php

require_once __DIR__ . '/Database.php';

class Products {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM products");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);

        $product = $stmt->fetch();

        return $product ?: null;
    }
}