<?php
require_once __DIR__ . '/PaymentProviderInterface.php';

/**
 * Card Payment Provider for Zambian Market
 * Supports Visa and Mastercard transactions
 */
class CardProvider implements PaymentProviderInterface {
	private $storeFile;
	
	public function __construct(){
		$this->storeFile = dirname(__DIR__,1) . '/storage/card_provider.json';
		if(!is_dir(dirname($this->storeFile))) mkdir(dirname($this->storeFile), 0755, true);
		if(!file_exists($this->storeFile)) file_put_contents($this->storeFile, json_encode([]));
	}
	
	private function read(){ 
		return json_decode(file_get_contents($this->storeFile), true) ?: []; 
	}
	
	private function write($d){ 
		file_put_contents($this->storeFile, json_encode($d)); 
	}

	/**
	 * Hold funds via card payment
	 * Meta should contain: card_token, card_last_four, card_type
	 */
	public function holdFunds($orderId, $amount, $meta = []){
		$token = $meta['card_token'] ?? 'tok_test';
		$lastFour = $meta['card_last_four'] ?? '****';
		$cardType = strtolower($meta['card_type'] ?? 'visa');
		
		// Validate card type
		if(!in_array($cardType, ['visa', 'mastercard'])){
			return ['error' => 'Unsupported card type'];
		}

		$data = $this->read();
		$ref = 'card_' . $cardType . '_' . uniqid();
		
		$data[$ref] = [
			'order_id' => $orderId,
			'amount' => $amount,
			'status' => 'held',
			'card_token' => $token,
			'card_last_four' => $lastFour,
			'card_type' => $cardType,
			'created' => time(),
			'currency' => 'ZMW',
			'transaction_id' => $this->generateTransactionId($cardType)
		];
		
		$this->write($data);
		return $ref;
	}

	public function releaseFunds($providerReference){
		$d = $this->read(); 
		
		if(!isset($d[$providerReference])) return false;
		
		$d[$providerReference]['status'] = 'released'; 
		$d[$providerReference]['released_at'] = time(); 
		$this->write($d); 
		
		return true;
	}

	public function refundFunds($providerReference, $amount = null){
		$d = $this->read(); 
		
		if(!isset($d[$providerReference])) return false;
		
		$d[$providerReference]['status'] = 'refunded'; 
		$d[$providerReference]['refunded_at'] = time(); 
		$d[$providerReference]['refund_amount'] = $amount; 
		$this->write($d); 
		
		return true;
	}

	/**
	 * Generate unique transaction ID
	 */
	private function generateTransactionId($cardType){
		$timestamp = date('YmdHis');
		$random = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
		$prefix = strtoupper(substr($cardType, 0, 2));
		
		return "{$prefix}{$timestamp}{$random}";
	}

	/**
	 * Get list of supported card types
	 */
	public function getSupportedCardTypes(){
		return [
			'visa' => 'Visa',
			'mastercard' => 'Mastercard'
		];
	}

	/**
	 * Get transaction details
	 */
	public function getTransactionDetails($providerReference){
		$data = $this->read();
		return $data[$providerReference] ?? null;
	}

	/**
	 * Check transaction status
	 */
	public function checkTransactionStatus($providerReference){
		$transaction = $this->getTransactionDetails($providerReference);
		
		if(!$transaction) return null;
		
		return [
			'reference' => $providerReference,
			'status' => $transaction['status'],
			'amount' => $transaction['amount'],
			'currency' => $transaction['currency'],
			'card_type' => $transaction['card_type'],
			'card_last_four' => $transaction['card_last_four'],
			'created' => $transaction['created'],
			'transaction_id' => $transaction['transaction_id']
		];
	}

	/**
	 * Validate card token format (mock validation)
	 */
	public function validateCardToken($token){
		return !empty($token) && strlen($token) >= 10;
	}

	/**
	 * Get masked card number from last four digits
	 */
	public function getMaskedCard($lastFour){
		return '****-****-****-' . $lastFour;
	}
}
