<div class="container py-4">
	<h3>Messages</h3>
	<?php if(empty($data['threads'])): ?>
		<p class="text-muted">No messages yet.</p>
	<?php else: ?>
		<ul class="list-group">
		<?php foreach($data['threads'] as $t): ?>
			<li class="list-group-item">
				<a href="<?= URLROOT ?>/messages/chat?with=<?= $t->sender_id == $_SESSION['user_id'] ? $t->receiver_id : $t->sender_id ?>"><?= htmlspecialchars($t->username) ?></a>
			</li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>
