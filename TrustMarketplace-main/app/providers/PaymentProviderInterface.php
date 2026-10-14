<?php
interface PaymentProviderInterface {
	// hold funds for order, return provider reference or false
	// $meta is optional provider-specific metadata (phone, card token, etc.)
	public function holdFunds($orderId, $amount, $meta = []);

	// release held funds
	public function releaseFunds($providerReference);

	// refund funds
	public function refundFunds($providerReference, $amount = null);
}
