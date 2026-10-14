<?php require APPROOT . '/views/layouts/header.php'; ?>
<div style="padding:2rem; max-width:900px; margin:0 auto;">
	<h2>Your Cart</h2>
	<?php $cart = $data['cart'] ?? []; ?>
	<?php if(empty($cart)): ?>
		<p>Your cart is empty. <a href="<?php echo URLROOT; ?>/explore/index">Continue shopping</a></p>
	<?php else: ?>
		<table class="table-premium" style="width:100%;">
			<thead><tr><th>Product</th><th>Qty</th><th>Action</th></tr></thead>
			<tbody>
			<?php foreach($cart as $pid => $qty):
				$p = (new Product())->getProductById($pid);
				if(!$p) continue;
			?>
			<tr>
				<td><?php echo htmlspecialchars($p->title); ?></td>
				<td><?php echo $qty; ?></td>
				<td><a href="<?php echo URLROOT; ?>/cart/remove/<?php echo $pid; ?>" class="btn-glass">Remove</a></td>
			</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<div style="margin-top:1rem;">
			<a href="<?php echo URLROOT; ?>/checkout" class="btn-brand">Proceed to Checkout</a>
		</div>
	<?php endif; ?>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
