<?php
class Orders extends Controller {
	public function __construct() {
		if(!isLoggedIn()){
			header('location: ' . URLROOT . '/users/login'); exit;
		}
		$this->productModel = $this->model('Product');
		$this->orderModel   = $this->model('Order');
	}

	// Show buy confirmation and create order
	public function buy($id = 0) {
		$product = $this->productModel->getProductById((int)$id);
		if(!$product){
			$this->view('errors/404', ['title'=>'Product not found']);
			return;
		}

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			// For now single quantity 1
			$qty = 1;
			$total = $product->price * $qty;
			$items = [['product_id' => $product->id, 'qty' => $qty, 'price' => $product->price]];

			$orderId = $this->orderModel->createOrder($_SESSION['user_id'], $product->seller_id, $items, $total);
			if($orderId){
				// create escrow
				$this->orderModel->createEscrow($orderId, $total);
				// reduce stock if applicable
				if(property_exists($product, 'stock')){
					$newStock = max(0, $product->stock - $qty);
					$this->productModel->updateProduct(['id'=>$product->id,'seller_id'=>$product->seller_id,'title'=>$product->title,'description'=>$product->description,'price'=>$product->price,'category'=>$product->category,'stock'=>$newStock,'status'=>$product->status]);
				}
				flash('order_message', 'Order placed and funds held in escrow.');
				header('location: ' . URLROOT . '/buyer/orders'); exit;
			} else {
				flash('order_message', 'Could not place order. Try again.', 'alert-danger');
				header('location: ' . URLROOT . '/explore'); exit;
			}
		}

		$data = ['title'=>'Buy Product','product'=>$product];
		$this->view('orders/buy', $data);
	}

	// Buyer orders list
	public function index() {
		$orders = $this->orderModel->getOrdersByBuyer($_SESSION['user_id']);
		$data = ['title'=>'My Orders','orders'=>$orders];
		$this->view('buyer/orders', $data);
	}

	// confirm receipt
	public function confirm($order_id = 0){
		if(isLoggedIn() && $_SESSION['user_role'] == 'buyer'){
			$this->orderModel->confirmReceipt((int)$order_id, $_SESSION['user_id']);
			flash('order_message', 'Order confirmed and escrow released.');
		}
		header('location: ' . URLROOT . '/buyer/orders'); exit;
	}
}
