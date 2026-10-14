<?php
class Checkout extends Controller {
	public function __construct(){
		if(!isLoggedIn()) { header('location: ' . URLROOT . '/users/login'); exit; }
		$this->productModel = $this->model('Product');
		$this->orderModel = $this->model('Order');
		// use mock provider by default
		require_once APPROOT . '/providers/MockProvider.php';
		$this->provider = new MockProvider();
	}

	// Show checkout page and process cart checkout
	public function index(){
		$cart = $_SESSION['cart'] ?? [];
		if(empty($cart)) { flash('cart_message', 'Cart is empty'); header('location: ' . URLROOT . '/cart'); exit; }

		// Build items and compute totals (single seller assumption simplified)
		$items = [];
		$total = 0;
		$sellerId = null;
		foreach($cart as $pid => $qty){
			$p = $this->productModel->getProductById($pid);
			if(!$p) continue;
			$items[] = ['product_id'=>$p->id,'qty'=>$qty,'price'=>$p->price,'seller_id'=>$p->seller_id];
			$total += $p->price * $qty;
			$sellerId = $p->seller_id; // last seller overrides; multi-seller carts not fully supported in this simple impl
		}

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$paymentMethod = $_POST['payment_method'] ?? 'mock';
			$paymentMeta = [];
			if($paymentMethod === 'mobile_money'){
				$paymentMeta['phone'] = trim($_POST['mm_phone'] ?? '');
			} elseif($paymentMethod === 'card'){
				// In a real integration we'd collect a token; here we accept a simulated token
				$paymentMeta['card_token'] = trim($_POST['card_token'] ?? 'tok_test');
			}

			// Create order and hold funds via selected provider
			$orderId = $this->orderModel->createOrder($_SESSION['user_id'], $sellerId, $items, $total);
			if($orderId){
				// choose provider implementation
				if($paymentMethod === 'mobile_money'){
					require_once APPROOT . '/providers/MobileMoneyProvider.php';
					$prov = new MobileMoneyProvider();
				} elseif($paymentMethod === 'card'){
					require_once APPROOT . '/providers/CardProvider.php';
					$prov = new CardProvider();
				} else {
					$prov = $this->provider; // mock
				}

				$providerRef = $prov->holdFunds($orderId, $total, $paymentMeta);

				// create escrow record and attach provider reference
				$this->orderModel->createEscrow($orderId, $total);
				$db = new Database();
				$db->query('UPDATE escrows SET provider_reference = :ref WHERE order_id = :oid');
				$db->bind(':ref', $providerRef);
				$db->bind(':oid', $orderId);
				$db->execute();

				// clear cart
				unset($_SESSION['cart']);
				flash('order_message', 'Checkout complete — funds are held in escrow.');
				header('location: ' . URLROOT . '/buyer/orders'); exit;
			}
			flash('order_message', 'Could not create order', 'alert-danger');
			header('location: ' . URLROOT . '/cart'); exit;
		}

		$data = ['title'=>'Checkout','items'=>$items,'total'=>$total];
		$this->view('checkout/index', $data);
	}
}
