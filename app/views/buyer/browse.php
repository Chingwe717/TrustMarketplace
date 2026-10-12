<?php require APPROOT . '/views/layouts/buyer_header.php'; ?>
<div class="page-hero">
	<h1 class="hero-title"><i class="bi bi-shop-window me-2"></i>Browse Market</h1>
	<p class="hero-sub">Explore products from sellers across the marketplace.</p>
</div>

<div style="padding:1rem 0;">
	<div class="product-grid">
		<?php if(empty($data['products'])) : ?>
			<p>No products available right now.</p>
		<?php else : ?>
			<?php foreach($data['products'] as $product) : ?>
				<div class="product-card glass animate-up">
					<div class="product-image">
						<div style="height:200px; background: linear-gradient(135deg, #1e293b, #0f172a); border-radius:8px 8px 0 0; display:flex; align-items:center; justify-content:center;">
							<i class="bi bi-box-seam text-muted-c" style="font-size:3rem;"></i>
						</div>
					</div>
					<div class="product-info" style="padding:1.5rem;">
						<span style="font-size:0.8rem; color:var(--brand-primary); text-transform:uppercase; font-weight:bold;"><?php echo htmlspecialchars($product->category); ?></span>
						<h3 style="margin:0.5rem 0;"><?php echo htmlspecialchars($product->title); ?></h3>
						<p style="color:var(--text-muted); font-size:0.9rem; margin-bottom:1rem;"><?php echo htmlspecialchars(substr($product->description,0,80)); ?>...</p>
						<div style="display:flex; justify-content:space-between; align-items:center;">
							<strong style="font-size:1.25rem; color:var(--brand-emerald);">ZMW <?php echo number_format($product->price,2); ?></strong>
							<div style="display:flex; gap:0.5rem;">
								<a href="<?php echo URLROOT; ?>/orders/buy/<?php echo $product->id; ?>" class="btn btn-primary" style="padding:0.5rem 1rem;">Buy Now</a>
								<a href="<?php echo URLROOT; ?>/cart/add/<?php echo $product->id; ?>" class="btn btn-glass" style="padding:0.45rem 0.9rem;">Add to Cart</a>
							</div>
						</div>
						<div style="margin-top:1rem; padding-top:1rem; border-top:1px solid var(--glass-border); font-size:0.8rem; color:var(--text-muted);">
							<i class="bi bi-shop"></i> Sold by: <?php echo htmlspecialchars($product->seller_name); ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>

<?php require APPROOT . '/views/layouts/panel_footer.php'; ?>
