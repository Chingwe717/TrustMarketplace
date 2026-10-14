<?php
class Admin extends Controller {
    public function __construct() {
        if(!isLoggedIn() || $_SESSION['user_role'] != 'admin'){
            header('location: ' . URLROOT . '/users/login');
            exit;
        }
    }

    public function dashboard() {
        $db = new Database();
        // totals
        $db->query('SELECT COUNT(*) AS c FROM users'); $total_users = $db->single()->c ?? 0;
        $db->query('SELECT COUNT(*) AS c FROM products'); $total_products = $db->single()->c ?? 0;
        $db->query('SELECT COUNT(*) AS c FROM orders'); $total_orders = $db->single()->c ?? 0;
        $db->query("SELECT COALESCE(SUM(amount),0) AS s FROM escrows WHERE status IN ('held','frozen')"); $funds = $db->single()->s ?? 0;
        $db->query("SELECT COUNT(*) AS c FROM disputes WHERE status = 'open'"); $open_disputes = $db->single()->c ?? 0;

        // recent disputes
        $db->query('SELECT d.*, ub.name AS buyer_name, us.name AS seller_name FROM disputes d LEFT JOIN users ub ON d.buyer_id = ub.id LEFT JOIN users us ON d.seller_id = us.id ORDER BY d.opened_at DESC LIMIT 10');
        $disputes = $db->resultSet();

        $data = [
            'title'           => 'Admin Dashboard',
            'total_users'     => $total_users,
            'total_products'  => $total_products,
            'total_orders'    => $total_orders,
            'open_disputes'   => $open_disputes,
            'funds_in_escrow' => $funds,
            'disputes'        => $disputes,
        ];
        $this->view('admin/dashboard', $data);
    }

    public function disputes() {
        $data = ['title' => 'All Disputes', 'disputes' => []];
        $this->view('admin/disputes', $data);
    }

    public function users() {
        $data = ['title' => 'Manage Users', 'users' => []];
        $this->view('admin/users', $data);
    }

    public function sellers() {
        $data = ['title' => 'Verify Sellers', 'sellers' => []];
        $this->view('admin/sellers', $data);
    }

    public function analytics() {
        $data = ['title' => 'Analytics'];
        $this->view('admin/analytics', $data);
    }
}
