<?php
class Trust {
	private $db;
	public function __construct(){ $this->db = new Database(); }
	// Compute trust score using ProjectX-inspired algorithm
	// Algorithm weights (0-100): avg_rating 25%, completion rate 25%, account age 20%, verification 20%, response rate 10%
	public function computeForSeller($seller_id){
		// default values
		$score = 0;
		$avgRating = 0.0;
		$completionRate = 0.0;
		$months = 0;
		$verPoints = 0;
		$responseRate = 0.0;

		try {
			// 1) avg seller rating from reviews (try reviews table)
			$this->db->query("SELECT AVG(COALESCE(seller_rating, rating)) AS avg_rating FROM reviews WHERE seller_id = :sid AND status = 'approved'");
			$this->db->bind(':sid', $seller_id);
			$row = $this->db->single();
			$avgRating = (float)($row->avg_rating ?? 0);
			$score += ($avgRating / 5.0) * 25.0;

			// 2) completion rate
			$this->db->query("SELECT COUNT(*) AS total, SUM(CASE WHEN status='delivered' THEN 1 ELSE 0 END) AS delivered, SUM(CASE WHEN status='cancelled' THEN 1 ELSE 0 END) AS cancelled FROM orders WHERE seller_id = :sid");
			$this->db->bind(':sid', $seller_id);
			$row = $this->db->single();
			$total = (int)($row->total ?? 0);
			$delivered = (int)($row->delivered ?? 0);
			$cancelled = (int)($row->cancelled ?? 0);
			$eligible = max(1, $total - $cancelled);
			$completionRate = $eligible > 0 ? ($delivered / $eligible) : 0;
			$score += $completionRate * 25.0;

			// 3) account age in months (cap 24 months)
			$this->db->query("SELECT TIMESTAMPDIFF(MONTH, created_at, NOW()) AS months FROM users WHERE id = :sid");
			$this->db->bind(':sid', $seller_id);
			$row = $this->db->single();
			$months = min(24, (int)($row->months ?? 0));
			$score += ($months / 24.0) * 20.0;

			// 4) verification status
			// prefer seller_verifications.status if exists, otherwise users.is_verified
			$verStatus = null;
			try {
				$this->db->query('SELECT status FROM seller_verifications WHERE user_id = :sid');
				$this->db->bind(':sid', $seller_id);
				$r = $this->db->single();
				$verStatus = $r->status ?? null;
			} catch (Exception $e) {
				// fallback
			}
			if (!$verStatus) {
				$this->db->query('SELECT is_verified FROM users WHERE id = :sid');
				$this->db->bind(':sid', $seller_id);
				$r = $this->db->single();
				$verStatus = (isset($r->is_verified) && $r->is_verified) ? 'verified' : 'unverified';
			}
			$verPoints = ($verStatus === 'verified') ? 20 : (($verStatus === 'pending') ? 5 : 0);
			$score += $verPoints;

			// 5) response rate (messages last 30 days) — best-effort if messages table exists
			try {
				$this->db->query("SELECT COUNT(*) AS received FROM messages WHERE receiver_id = :sid AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
				$this->db->bind(':sid', $seller_id);
				$r = $this->db->single();
				$received = (int)($r->received ?? 0);
				if ($received > 0) {
					$this->db->query("SELECT COUNT(*) AS sent FROM messages WHERE sender_id = :sid AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
					$this->db->bind(':sid', $seller_id);
					$s2 = $this->db->single();
					$sent = (int)($s2->sent ?? 0);
					$responseRate = min(1.0, $sent / $received);
					$score += $responseRate * 10.0;
				}
			} catch (Exception $e) { /* ignore if messages not present */ }

		} catch (Exception $e) {
			// on any failure, keep partial score
		}

		$score = round(min(100, $score), 2);

		// determine level
		$level = 'new';
		if ($score >= 85) $level = 'platinum';
		elseif ($score >= 70) $level = 'gold';
		elseif ($score >= 55) $level = 'silver';
		elseif ($score >= 35) $level = 'bronze';

		// persist into trust_scores table (best-effort)
		try {
			$this->db->query('INSERT INTO trust_scores (seller_id, score, response_time_score, refund_rate, dispute_rate, completion_rate, calculated_at) VALUES (:sid, :score, NULL, NULL, NULL, :cr, NOW()) ON DUPLICATE KEY UPDATE score=:score, completion_rate=:cr, calculated_at=NOW()');
			$this->db->bind(':sid', $seller_id);
			$this->db->bind(':score', $score);
			$this->db->bind(':cr', round($completionRate * 100, 2));
			$this->db->execute();
		} catch (Exception $e) { /* ignore persistence failure */ }

		return ['score'=>$score, 'level'=>$level, 'completion_rate'=>round($completionRate * 100, 2), 'avg_rating'=>$avgRating];
	}
}
