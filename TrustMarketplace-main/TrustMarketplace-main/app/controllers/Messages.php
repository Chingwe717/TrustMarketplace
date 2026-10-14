<?php
class Messages extends Controller {
	public function __construct(){
		if(!isLoggedIn()){
			header('location: ' . URLROOT . '/users/login'); exit;
		}
	}

	// simple UI list of threads
	public function index(){
		$msgModel = $this->model('Message');
		$threads = $msgModel->listThreads($_SESSION['user_id']);
		$this->view('messages/index', ['title'=>'Messages','threads'=>$threads]);
	}

	// conversation with a partner
	public function chat(){
		$partner = (int)($_GET['with'] ?? $_GET['partner_id'] ?? 0);
		if(!$partner) { header('location: ' . URLROOT . '/messages'); exit; }
		$msgModel = $this->model('Message');
		$conv = $msgModel->getConversation($_SESSION['user_id'], $partner);
		$this->view('messages/chat', ['title'=>'Chat','conversation'=>$conv,'partner'=>$partner]);
	}

	// API endpoint to send message
	public function send(){
		if($_SERVER['REQUEST_METHOD'] !== 'POST' || !isLoggedIn()){
			http_response_code(400); echo json_encode(['error'=>'invalid']); exit;
		}
		$to = (int)($_POST['to'] ?? 0);
		$text = trim($_POST['message'] ?? '');
		if(!$to || $text === ''){ http_response_code(400); echo json_encode(['error'=>'missing']); exit; }
		$msgModel = $this->model('Message');
		$ok = $msgModel->send($_SESSION['user_id'], $to, $text);
		if($ok) echo json_encode(['success'=>true]); else json_encode(['success'=>false]);
	}
}
