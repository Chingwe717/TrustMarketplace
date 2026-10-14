<?php
class Explore extends Controller {
    public function __construct() {
        $this->productModel = $this->model('Product');
    }

    public function index() {
        $products = $this->productModel->getProducts();
        
        $data = [
            'title' => 'Explore Marketplace',
            'products' => $products
        ];
        
        $this->view('explore/index', $data);
    }
}
