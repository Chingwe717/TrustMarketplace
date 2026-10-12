<?php require APPROOT . '/views/layouts/header.php'; ?>
<div style="padding: 4rem 5%;">
    <h1 class="text-gradient">Explore Products</h1>
    <p class="text-muted mb-4">Discover high-quality items from verified sellers, protected by Smart Escrow.</p>

    <div class="product-grid">
        <?php if(empty($data['products'])) : ?>
            <p>No products available right now.</p>
        <?php else : ?>
            <?php foreach($data['products'] as $product) : ?>
                <?php
                    $productImages = json_decode($product->images ?? '[]', true) ?: [];
                    $productImage = $productImages[0] ?? '';
                ?>
                <div class="product-card glass animate-up">
                    <div class="product-image">
                        <?php if ($productImage !== '') : ?>
                            <img src="<?php echo URLROOT . '/' . htmlspecialchars(ltrim($productImage, '/'), ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($product->title, ENT_QUOTES, 'UTF-8'); ?>" style="width:100%; height:200px; object-fit:cover;">
                        <?php else : ?>
                            <div class="product-img-placeholder"><i class="bi bi-box-seam"></i></div>
                        <?php endif; ?>
                    </div>
                    <div class="product-info" style="padding: 1.5rem;">
                        <span style="font-size: 0.8rem; color: var(--brand-primary); text-transform: uppercase; font-weight: bold;"><?php echo htmlspecialchars($product->category, ENT_QUOTES, 'UTF-8'); ?></span>
                        <h3 style="margin: 0.5rem 0;"><?php echo htmlspecialchars($product->title, ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1rem;"><?php echo htmlspecialchars(mb_strimwidth($product->description, 0, 80, '...'), ENT_QUOTES, 'UTF-8'); ?></p>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <strong style="font-size: 1.25rem; color: var(--brand-emerald);">ZMW <?php echo number_format($product->price, 2); ?></strong>
                            <div style="display:flex; gap:0.5rem;">
                                <a href="<?php echo URLROOT; ?>/orders/buy/<?php echo (int) $product->id; ?>" class="btn btn-primary" style="padding: 0.5rem 1rem;">Buy Now</a>
                                <a href="<?php echo URLROOT; ?>/cart/add/<?php echo (int) $product->id; ?>" class="btn btn-glass" style="padding:0.45rem 0.9rem;">Add to Cart</a>
                            </div>
                        </div>
                        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--glass-border); font-size: 0.8rem; color: var(--text-muted);">
                            <i class="bi bi-shop"></i> Sold by: <?php echo htmlspecialchars($product->seller_name); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
