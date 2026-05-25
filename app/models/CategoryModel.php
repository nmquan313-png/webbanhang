<?php
// ✅ Kiểm tra class tồn tại trước khi khai báo (chống lỗi trùng)
if (!class_exists('CategoryModel', false)) {

class CategoryModel {
    private $conn;
    private $table = 'categories';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name) {
        $query = "INSERT INTO " . $this->table . " (name) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$name]);
    }

    public function update($id, $name) {
        $query = "UPDATE " . $this->table . " SET name = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$name, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
} // ✅ Đóng class CategoryModel

} // ✅ Đóng if (!class_exists) - QUAN TRỌNG: Không được quên dấu này!
?>