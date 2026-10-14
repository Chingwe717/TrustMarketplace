<?php require APPROOT . '/views/layouts/header.php'; ?>
<div style="padding:2rem 5%; max-width:800px; margin:0 auto;">
	<h2>Confirm Purchase</h2>
	<div class="card" style="padding:1.5rem; margin-top:1rem;">
		<h3><?php echo htmlspecialchars($data['product']->title); ?></h3>
		<p><?php echo htmlspecialchars($data['product']->description); ?></p>
		<p><strong>Price:</strong> ZMW <?php echo number_format($data['product']->price,2); ?></p>
		<form method="POST" action="">
			<button class="btn-brand" type="submit">Buy Now — Hold funds in escrow</button>
			<a href="<?php echo URLROOT; ?>/explore/index" class="btn-glass" style="margin-left:1rem;">Cancel</a>
		</form>
	</div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
