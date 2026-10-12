<?php require APPROOT . '/views/layouts/seller_header.php'; ?>

<div class="page-hero">
	<h1 class="hero-title">My Profile</h1>
	<p class="hero-sub">Overview of your listings, orders and trust score.</p>
</div>

<div style="display:grid; grid-template-columns: 1fr 320px; gap:1.5rem;">
	<div>
		<div class="premium-card" style="padding:1.25rem;">
			<h4>Listings</h4>
			<?php if(empty($data['products'])): ?>
				<p>No listings yet. <a href="<?php echo URLROOT; ?>/products/add">List a product</a></p>
			<?php else: ?>
				<ul>
					<?php foreach($data['products'] as $p): ?>
						<li><?php echo htmlspecialchars($p->title); ?> — ZMW <?php echo number_format($p->price,2); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<div class="premium-card" style="padding:1.25rem; margin-top:1rem;">
			<h4>Recent Orders</h4>
			<?php if(empty($data['orders'])): ?>
				<p>No orders yet.</p>
			<?php else: ?>
				<table class="table-premium">
					<thead><tr><th>Order</th><th>Total</th><th>Status</th></tr></thead>
					<tbody>
						<?php foreach($data['orders'] as $o): ?>
						<tr>
							<td>#<?php echo $o->id; ?></td>
							<td>ZMW <?php echo number_format($o->total,2); ?></td>
							<td><?php echo htmlspecialchars($o->status); ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
	</div>

	<aside>
		<div class="stat-grid-card">
			<div class="icon-wrap" style="background:rgba(99,102,241,0.12);"><i class="bi bi-star"></i></div>
			<div class="stat-val"><?php echo $data['trust']['score'] ?? 0; ?></div>
			<div class="stat-label">Trust Score</div>
		</div>

		<div class="stat-grid-card" style="margin-top:1rem;">
			<div class="icon-wrap" style="background:rgba(16,185,129,0.12);"><i class="bi bi-award"></i></div>
			<div class="stat-val"><?php echo ucfirst($data['trust']['level'] ?? 'new'); ?></div>
			<div class="stat-label">Trust Level</div>
		</div>

		<a href="<?php echo URLROOT; ?>/seller/verification" class="btn-glass" style="display:block; margin-top:1rem; text-align:center;">Verification</a>
	</aside>
</div>

<?php require APPROOT . '/views/layouts/panel_footer.php'; ?>
