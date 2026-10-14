<?php
class Cart extends Controller {
	public function __construct() {
		if(!isset($_SESSION)) session_start();
		// no model needed here; cart stored in session
	}

	public function index() {
		$cart = $_SESSION['cart'] ?? [];
		$data = ['title' => 'Your Cart', 'cart' => $cart];
		$this->view('cart/index', $data);
	}

	public function add($productId = 0) {
		$productId = (int)$productId;
		if(!$productId) { header('location: ' . URLROOT . '/explore'); exit; }

		$cart = $_SESSION['cart'] ?? [];
		if(isset($cart[$productId])) {
			$cart[$productId] += 1;
		} else {
			$cart[$productId] = 1;
		}
		$_SESSION['cart'] = $cart;
		flash('cart_message', 'Added to cart');
		header('location: ' . URLROOT . '/explore'); exit;
	}

	public function remove($productId = 0) {
		$productId = (int)$productId;
		$cart = $_SESSION['cart'] ?? [];
		if(isset($cart[$productId])){
			unset($cart[$productId]);
			$_SESSION['cart'] = $cart;
		}
		header('location: ' . URLROOT . '/cart'); exit;
	}
}
