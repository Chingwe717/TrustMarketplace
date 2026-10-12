<?php require APPROOT . '/views/layouts/admin_header.php'; ?>
<div class="page-hero">
	<h1 class="hero-title">Dispute Queue</h1>
	<p class="hero-sub">Review and manage open disputes submitted by buyers.</p>
</div>

<div class="premium-card">
	<div class="premium-card-header">
		<h5 class="premium-card-title">Open Disputes</h5>
	</div>
	<div style="overflow-x:auto;">
		<?php if(empty($data['disputes'])): ?>
			<div style="text-align:center; padding:3rem; opacity:0.6;">No disputes to review.</div>
		<?php else: ?>
			<table class="table-premium">
				<thead>
					<tr>
						<th>ID</th>
						<th>Order</th>
						<th>Buyer</th>
						<th>Seller</th>
						<th>Opened</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($data['disputes'] as $d): ?>
					<tr>
						<td>#<?php echo $d->id; ?></td>
						<td>#<?php echo $d->order_id; ?></td>
						<td><?php echo htmlspecialchars($d->buyer_name); ?></td>
						<td><?php echo htmlspecialchars($d->seller_name); ?></td>
						<td><?php echo date('M d, Y', strtotime($d->opened_at)); ?></td>
						<td><?php echo htmlspecialchars($d->status); ?></td>
						<td><a href="<?php echo URLROOT; ?>/admin/reviewdispute/<?php echo $d->id; ?>" class="btn-brand">Review</a></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	</div>
</div>

<?php require APPROOT . '/views/layouts/panel_footer.php'; ?>
