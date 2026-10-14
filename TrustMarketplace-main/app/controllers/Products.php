<?php
class Products extends Controller {
    public function __construct() {
        if(!isLoggedIn()){
            header('location: ' . URLROOT . '/users/login');
            exit;
        }
        $this->productModel = $this->model('Product');
    }

    public function add() {
        if($_SESSION['user_role'] != 'seller'){
            header('location: ' . URLROOT . '/explore'); exit;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'seller_id' => $_SESSION['user_id'],
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'price' => trim($_POST['price']),
                'category' => trim($_POST['category']),
                'stock' => trim($_POST['stock']),
                'title_err' => '',
                'description_err' => '',
                'price_err' => ''
            ];

            if(empty($data['title'])){
                $data['title_err'] = 'Please enter title';
            }
            if(empty($data['description'])){
                $data['description_err'] = 'Please enter description';
            }
            if(empty($data['price'])){
                $data['price_err'] = 'Please enter price';
            }

            if(empty($data['title_err']) && empty($data['description_err']) && empty($data['price_err'])){
                // Handle optional image upload
                if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                    $fileTmp = $_FILES['image']['tmp_name'];
                    $fileName = basename($_FILES['image']['name']);
                    $fileType = mime_content_type($fileTmp);
                    $allowed = ['image/jpeg', 'image/png', 'image/gif'];
                    if (in_array($fileType, $allowed)) {
                        $uploadDir = dirname(__DIR__,2) . '/public/uploads/';
                        if(!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                        $newName = uniqid('img_') . '.' . $ext;
                        $dest = $uploadDir . $newName;
                        if (move_uploaded_file($fileTmp, $dest)) {
                            // store relative path for database
                            $data['image'] = json_encode(['uploads/' . $newName]);
                        }
                    }
                }

                if($this->productModel->addProduct($data)){
                    flash('product_message', 'Product added successfully');
                    header('location: ' . URLROOT . '/seller/dashboard');
                    exit;
                } else {
                    flash('product_message', 'Something went wrong. Please try again.', 'alert-danger');
                    header('location: ' . URLROOT . '/products/add');
                    exit;
                }
            } else {
                $this->view('products/add', $data);
            }
        } else {
            $data = ['title'=>'','description'=>'','price'=>'','category'=>'','stock'=>1,
                     'title_err'=>'','description_err'=>'','price_err'=>''];
            $this->view('products/add', $data);
        }
    }

    public function delete() {
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isLoggedIn() && $_SESSION['user_role'] == 'seller'){
            $product_id = (int)$_POST['product_id'];
            if($this->productModel->deleteProduct($product_id, $_SESSION['user_id'])){
                flash('product_message', 'Product deleted successfully.');
            } else {
                flash('product_message', 'Could not delete product.', 'alert-danger');
            }
        }
        header('location: ' . URLROOT . '/seller/products');
        exit;
    }
}
