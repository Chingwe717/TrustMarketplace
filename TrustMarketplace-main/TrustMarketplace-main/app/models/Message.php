<?php
class Message {
	private $db;
	public function __construct(){ $this->db = new Database(); }

	public function send($sender_id, $receiver_id, $message){
		$this->db->query('INSERT INTO messages (sender_id, receiver_id, message) VALUES (:s, :r, :m)');
		$this->db->bind(':s', $sender_id);
		$this->db->bind(':r', $receiver_id);
		$this->db->bind(':m', $message);
		return $this->db->execute();
	}

	public function getConversation($a, $b, $limit=200){
		$this->db->query('SELECT m.*, u.username as sender_name FROM messages m JOIN users u ON u.id=m.sender_id WHERE (m.sender_id=:a AND m.receiver_id=:b) OR (m.sender_id=:b AND m.receiver_id=:a) ORDER BY m.created_at ASC LIMIT :lim');
		$this->db->bind(':a', $a);
		$this->db->bind(':b', $b);
		$this->db->bind(':lim', (int)$limit);
		return $this->db->resultSet();
	}

	public function listThreads($user_id){
		$this->db->query('SELECT m.*, u.username, (SELECT COUNT(*) FROM messages WHERE sender_id=u.id AND receiver_id=:uid AND is_read=0) AS unread FROM (SELECT * FROM messages WHERE sender_id=:uid OR receiver_id=:uid ORDER BY created_at DESC) m JOIN users u ON (m.sender_id=u.id OR m.receiver_id=u.id) GROUP BY u.id');
		$this->db->bind(':uid', $user_id);
		return $this->db->resultSet();
	}
}
