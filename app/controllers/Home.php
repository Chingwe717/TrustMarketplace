<?php
class Home extends Controller {
    public function __construct() {
        // Initialize any models if needed here
    }

    public function index() {
        $data = [
            'title' => 'TrustMarket | Secure, Smart, Reliable',
            'description' => 'The leading AI-powered multi-vendor marketplace built on trust. Shop safely with smart escrow and verified sellers.'
        ];
        
        $this->view('home/index', $data);
    }
}
