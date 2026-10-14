<div class="container py-4">
	<h3>Chat</h3>
	<div id="chatBody">
		<?php if(empty($data['conversation'])): ?>
			<div class="echat"><i class="bi bi-chat-left-text"></i><h6 class="text-dim fw-bold mt-2">No messages yet</h6></div>
		<?php else: foreach($data['conversation'] as $m): ?>
			<div class="message <?= $m->sender_id==$_SESSION['user_id']? 'me':'them' ?>">
				<div class="meta"><strong><?= htmlspecialchars($m->sender_name) ?></strong> <small class="text-muted"><?= $m->created_at ?></small></div>
				<div class="body"><?= nl2br(htmlspecialchars($m->message)) ?></div>
			</div>
		<?php endforeach; endif; ?>
	</div>
	<form id="mf" method="post" action="<?= URLROOT ?>/messages/send">
		<input type="hidden" name="to" value="<?= $data['partner'] ?>" />
		<div class="input-group mt-3">
			<input type="text" name="message" id="mi" class="form-control" placeholder="Write a message...">
			<button class="btn btn-emerald" type="submit">Send</button>
		</div>
	</form>
</div>
<script>
document.getElementById('mf').addEventListener('submit', function(e){
	e.preventDefault();
	var fd = new FormData(this);
	fetch('<?= URLROOT ?>/messages/send', {method:'POST', body:fd}).then(r=>r.json()).then(d=>{ if(d.success){ location.reload(); } else alert('Send failed'); });
});
</script>
