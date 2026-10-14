<?php
class Product {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // ── Public catalogue ────────────────────────────────────────────────────
    public function getProducts($search = '', $category = '', $excludeSellerId = null) {
        $sql = 'SELECT p.*, u.name AS seller_name
                FROM products p
                INNER JOIN users u ON p.seller_id = u.id
                WHERE p.status = "active"';
        if ($excludeSellerId) {
            $sql .= ' AND p.seller_id != :exclude';
        }
        if ($search) {
            $sql .= ' AND (p.title LIKE :search OR p.description LIKE :search OR p.category LIKE :search)';
        }
        if ($category) {
            $sql .= ' AND p.category = :category';
        }
        $sql .= ' ORDER BY p.created_at DESC';

        $this->db->query($sql);
        if ($excludeSellerId) $this->db->bind(':exclude', $excludeSellerId);
        if ($search)          $this->db->bind(':search', '%' . $search . '%');
        if ($category)        $this->db->bind(':category', $category);
        return $this->db->resultSet();
    }

    public function getCategories() {
        $this->db->query("SELECT DISTINCT category FROM products WHERE status='active' ORDER BY category ASC");
        return $this->db->resultSet();
    }

    // ── Seller-specific ─────────────────────────────────────────────────────
    public function getProductsBySeller($seller_id) {
        $this->db->query('SELECT * FROM products WHERE seller_id = :sid ORDER BY created_at DESC');
        $this->db->bind(':sid', $seller_id);
        return $this->db->resultSet();
    }

    public function getSellerStats($seller_id) {
        $this->db->query('
            SELECT
                COUNT(DISTINCT o.id)             AS total_orders,
                COALESCE(SUM(o.total), 0)        AS total_revenue,
                (SELECT COUNT(*) FROM products WHERE seller_id = :sid2 AND status = "active") AS total_products,
                COALESCE(SUM(p.price * p.stock), 0) AS inventory_value
            FROM orders o
            JOIN products p ON p.seller_id = :sid3
            WHERE o.seller_id = :sid AND o.status IN ("completed","confirmed","shipped","delivered")
        ');
        $this->db->bind(':sid', $seller_id);
        $this->db->bind(':sid2', $seller_id);
        $this->db->bind(':sid3', $seller_id);
        return $this->db->single();
    }

    public function getProductById($id) {
        $this->db->query('SELECT * FROM products WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // ── CRUD ─────────────────────────────────────────────────────────────────
    public function addProduct($data) {
        $this->db->query('
            INSERT INTO products (seller_id, title, description, price, category, stock, images)
            VALUES (:sid, :title, :desc, :price, :cat, :stock, :img)
        ');
        $this->db->bind(':sid',   $data['seller_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':desc',  $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':cat',   $data['category']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':img',   $data['image'] ?? null);
        return $this->db->execute();
    }

    public function updateProduct($data) {
        $this->db->query('
            UPDATE products SET title=:title, description=:desc, price=:price,
            category=:cat, stock=:stock, status=:status
            WHERE id=:id AND seller_id=:sid
        ');
        $this->db->bind(':title',  $data['title']);
        $this->db->bind(':desc',   $data['description']);
        $this->db->bind(':price',  $data['price']);
        $this->db->bind(':cat',    $data['category']);
        $this->db->bind(':stock',  $data['stock']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':id',     $data['id']);
        $this->db->bind(':sid',    $data['seller_id']);
        return $this->db->execute();
    }

    public function deleteProduct($id, $seller_id) {
        $this->db->query('DELETE FROM products WHERE id = :id AND seller_id = :sid');
        $this->db->bind(':id',  $id);
        $this->db->bind(':sid', $seller_id);
        return $this->db->execute();
    }
}
