<?php require APPROOT . '/views/layouts/header.php'; ?>
<div style="padding:2rem; max-width:900px; margin:0 auto;">
	<h2>Checkout</h2>
	<?php if(empty($data['items'])): ?>
		<p>No items to checkout.</p>
	<?php else: ?>
		<ul>
			<?php foreach($data['items'] as $it): ?>
				<li><?php echo htmlspecialchars($it['product_id']) . ' x ' . $it['qty']; ?> — ZMW <?php echo number_format($it['price'] * $it['qty'],2); ?></li>
			<?php endforeach; ?>
		</ul>
		<p><strong>Total:</strong> ZMW <?php echo number_format($data['total'],2); ?></p>
		<form method="POST" action="">
			<div style="margin-bottom:1rem;">
				<label><input type="radio" name="payment_method" value="mobile_money" checked> Mobile Money</label>
				<label style="margin-left:1rem;"><input type="radio" name="payment_method" value="card"> Card / Bank</label>
			</div>
			<div id="mm_fields" style="margin-bottom:1rem;">
				<label class="form-label">Phone Number</label>
				<input type="text" name="mm_phone" class="form-input" placeholder="+260XXXXXXXXX">
			</div>
			<div id="card_fields" style="display:none; margin-bottom:1rem;">
				<label class="form-label">Card token (simulated)</label>
				<input type="text" name="card_token" class="form-input" placeholder="tok_test_visa_4242">
			</div>
			<button class="btn-brand" type="submit">Pay & Hold in Escrow</button>
			<a href="<?php echo URLROOT; ?>/cart" class="btn-glass">Back to cart</a>
		</form>
		<script>
			document.querySelectorAll('input[name="payment_method"]').forEach(function(el){
				el.addEventListener('change', function(){
					var v = this.value;
					document.getElementById('mm_fields').style.display = v === 'mobile_money' ? 'block' : 'none';
					document.getElementById('card_fields').style.display = v === 'card' ? 'block' : 'none';
				});
			});
		</script>
	<?php endif; ?>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
