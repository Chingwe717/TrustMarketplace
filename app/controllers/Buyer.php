<?php
class Buyer extends Controller {
    public function __construct() {
        if(!isLoggedIn() || $_SESSION['user_role'] != 'buyer'){
            header('location: ' . URLROOT . '/users/login'); exit;
        }
        $this->orderModel = $this->model('Order');
    }

    // ── Dashboard ────────────────────────────────────────────────────────────
    public function dashboard() {
        $stats  = $this->orderModel->getBuyerStats($_SESSION['user_id']);
        $orders = $this->orderModel->getOrdersByBuyer($_SESSION['user_id']);

        $data = [
            'title'            => 'Buyer Dashboard',
            'total_orders'     => $stats->total_orders     ?? 0,
            'active_escrows'   => $stats->active_escrows   ?? 0,
            'open_disputes'    => $stats->open_disputes     ?? 0,
            'completed_orders' => $stats->completed_orders  ?? 0,
            'orders'           => array_slice($orders, 0, 5), // show 5 most recent
        ];
        $this->view('buyer/dashboard', $data);
    }

    // ── Orders ───────────────────────────────────────────────────────────────
    public function orders() {
        $filter = trim($_GET['filter'] ?? '');
        $orders = $this->orderModel->getOrdersByBuyer($_SESSION['user_id'], $filter);

        $data = [
            'title'  => 'My Orders',
            'orders' => $orders,
            'filter' => $filter,
        ];
        $this->view('buyer/orders', $data);
    }

    // ── Confirm Receipt (releases escrow) ────────────────────────────────────
    public function confirmreceipt() {
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isLoggedIn()){
            $order_id = (int)$_POST['order_id'];
            if($this->orderModel->confirmReceipt($order_id, $_SESSION['user_id'])){
                flash('order_message', 'Receipt confirmed! Escrow funds have been released to the seller.');
            } else {
                flash('order_message', 'Could not confirm receipt. Please try again.', 'alert-danger');
            }
        }
        header('location: ' . URLROOT . '/buyer/orders');
    }

    // ── Browse marketplace ─────────────────────────────────────────────────
    public function browse() {
        $search = trim($_GET['search'] ?? '');
        $category = trim($_GET['category'] ?? '');
        $products = $this->productModel->getProducts($search, $category, $_SESSION['user_id']);

        $data = [
            'title' => 'Browse Market',
            'products' => $products,
            'search' => $search,
            'category' => $category,
        ];
        $this->view('buyer/browse', $data);
    }

    // View one order in detail
    public function orderdetail($order_id = null) {
        $order = $this->orderModel->getOrderById((int)$order_id);
        if (!$order || (int)$order->buyer_id !== (int)$_SESSION['user_id']) {
            header('location: ' . URLROOT . '/buyer/orders');
            exit;
        }

        $data = ['title' => 'Order Details', 'order' => $order];
        $this->view('buyer/orderdetail', $data);
    }

    // ── Open Dispute ─────────────────────────────────────────────────────────
    public function opendispute($order_id = null) {
        $data = ['title' => 'Open a Dispute', 'order_id' => $order_id, 'desc_err' => ''];
        $this->view('buyer/opendispute', $data);
    }

    // ── Disputes ─────────────────────────────────────────────────────────────
    public function disputes() {
        $data = ['title' => 'My Disputes', 'disputes' => []];
        $this->view('buyer/disputes', $data);
    }
}
