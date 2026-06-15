<?php
// Kiểm tra xem class đã tồn tại chưa (để tránh lỗi "name is already in use")
if (!class_exists('ProductModel', false)) {

class ProductModel {
    private $conn;
    private $table = 'products';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getById($id) {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  WHERE p.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($category_id, $name, $description, $price, $image, $quantity) {
        $query = "INSERT INTO " . $this->table . " 
                  (category_id, name, description, price, image, quantity) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$category_id, $name, $description, $price, $image, $quantity]);
    }

    public function update($id, $category_id, $name, $description, $price, $image, $quantity) {
        $query = "UPDATE " . $this->table . " 
                  SET category_id = ?, name = ?, description = ?, 
                      price = ?, image = ?, quantity = ? 
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$category_id, $name, $description, $price, $image, $quantity, $id]);
    }

    public function delete($id){
    $stmt = $this->conn->prepare(
        "DELETE FROM order_details WHERE product_id = ?"
    );
    $stmt->execute([$id]);

    $stmt = $this->conn->prepare(
        "DELETE FROM products WHERE id = ?"
    );

    return $stmt->execute([$id]);
    }

    public function getProductsByCategory($category_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE category_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $category_id);
        $stmt->execute();
        return $stmt;
    }

    public function getByCategory($category_id){
    $stmt = $this->conn->prepare(
        "SELECT *
         FROM products
         WHERE category_id=?"
    );

    $stmt->execute([$category_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function sortByPrice($order='ASC'){
    $stmt = $this->conn->prepare(
        "SELECT *
         FROM products
         ORDER BY price $order"
    );

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


} // <-- Đóng class ProductModel

} // <-- ĐÂY LÀ DÒNG QUAN TRỌNG: Đóng lệnh if (!class_exists)
?>