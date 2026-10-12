<?php
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase {
	public function testCreateOrderAndEscrow() {
		// create temp db connection and run a minimal integration-like test
		$orderModel = new Order();
		// create a fake product and users if necessary - we'll assume seed ran earlier
		$buyerId = 2; $sellerId = 1;
		$items = [['product_id'=>1,'qty'=>1,'price'=>100.00]];
		$orderId = $orderModel->createOrder($buyerId, $sellerId, $items, 100.00);
		$this->assertIsNumeric($orderId);
		$res = $orderModel->createEscrow($orderId, 100.00);
		$this->assertTrue($res);
	}
}
