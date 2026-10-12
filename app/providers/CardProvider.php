<?php
require_once __DIR__ . '/PaymentProviderInterface.php';
class CardProvider implements PaymentProviderInterface {
	private $storeFile;
	public function __construct(){
		$this->storeFile = dirname(__DIR__,1) . '/storage/card_provider.json';
		if(!is_dir(dirname($this->storeFile))) mkdir(dirname($this->storeFile), 0755, true);
		if(!file_exists($this->storeFile)) file_put_contents($this->storeFile, json_encode([]));
	}
	private function read(){ return json_decode(file_get_contents($this->storeFile), true) ?: []; }
	private function write($d){ file_put_contents($this->storeFile, json_encode($d)); }

	public function holdFunds($orderId, $amount, $meta = []){
		$token = $meta['card_token'] ?? 'tok_test';
		$d = $this->read();
		$ref = 'card_' . uniqid();
		$d[$ref] = ['order_id'=>$orderId,'amount'=>$amount,'status'=>'held','card_token'=>$token,'created'=>time()];
		$this->write($d);
		return $ref;
	}

	public function releaseFunds($providerReference){
		$d = $this->read(); if(!isset($d[$providerReference])) return false;
		$d[$providerReference]['status'] = 'released'; $d[$providerReference]['released_at'] = time(); $this->write($d); return true;
	}

	public function refundFunds($providerReference, $amount = null){
		$d = $this->read(); if(!isset($d[$providerReference])) return false;
		$d[$providerReference]['status'] = 'refunded'; $d[$providerReference]['refunded_at'] = time(); $d[$providerReference]['refund_amount'] = $amount; $this->write($d); return true;
	}
}
