<?php require APPROOT . '/views/layouts/buyer_header.php'; ?>

<div class="page-hero">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
        <div>
            <h1 class="hero-title">Order Details</h1>
            <p class="hero-sub">Review the order contents, payment status, and fulfillment progress.</p>
        </div>
        <a href="<?php echo URLROOT; ?>/buyer/orders" class="btn-glass">Back to Orders</a>
    </div>
</div>

<?php $order = $data['order']; ?>
<div class="premium-card" style="margin-bottom:2rem;">
    <div style="padding:2rem;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:1rem; margin-bottom:1.5rem;">
            <div>
                <div style="font-size:0.75rem; letter-spacing:0.08em; text-transform:uppercase; color:var(--brand-primary); font-weight:800;">Order #<?php echo (int)$order->id; ?></div>
                <h2 style="margin:0.35rem 0 0; color:#fff; font-weight:800;">ZMW <?php echo number_format((float)$order->total, 2); ?></h2>
            </div>
            <span class="status-badge badge-<?php echo strtolower($order->status); ?>"><?php echo ucfirst(str_replace('_', ' ', $order->status ?? 'created')); ?></span>
        </div>

        <div style="display:grid; grid-template-columns: repeat(auto-fit,minmax(220px,1fr)); gap:1rem; margin-bottom:2rem;">
            <div class="glass-panel">
                <div class="muted-label">Seller</div>
                <div style="font-weight:700; color:#fff; margin-top:0.4rem;"><?php echo htmlspecialchars($order->seller_name ?? 'Seller'); ?></div>
            </div>
            <div class="glass-panel">
                <div class="muted-label">Escrow</div>
                <div style="font-weight:700; color:#fff; margin-top:0.4rem;"><?php echo ucfirst($order->escrow_status ?? 'held'); ?></div>
            </div>
            <div class="glass-panel">
                <div class="muted-label">Date</div>
                <div style="font-weight:700; color:#fff; margin-top:0.4rem;"><?php echo date('M d, Y', strtotime($order->created_at)); ?></div>
            </div>
        </div>

        <div class="glass-panel" style="padding:1.25rem; margin-bottom:1.5rem;">
            <div class="muted-label" style="margin-bottom:0.75rem;">Items</div>
            <?php $items = json_decode($order->items ?? '[]', true); ?>
            <?php if (!empty($items)): ?>
                <ul style="margin:0; padding-left:1.25rem; color:var(--text-dim); line-height:1.8;">
                    <?php foreach ($items as $item): ?>
                        <li>
                            Product ID: <?php echo (int)($item['product_id'] ?? 0); ?>
                            &nbsp;| Qty: <?php echo (int)($item['qty'] ?? 1); ?>
                            &nbsp;| Price: ZMW <?php echo number_format((float)($item['price'] ?? 0), 2); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p style="margin:0; color:var(--text-dim);">No items recorded for this order.</p>
            <?php endif; ?>
        </div>

        <?php if (in_array($order->status, ['funds_held','shipped','delivered'])): ?>
            <div style="display:flex; flex-wrap:wrap; gap:1rem;">
                <a href="<?php echo URLROOT; ?>/buyer/opendispute/<?php echo (int)$order->id; ?>" class="btn-danger-glass">
                    <i class="bi bi-exclamation-triangle"></i> Open Dispute
                </a>
                <?php if ($order->status === 'delivered'): ?>
                    <form method="POST" action="<?php echo URLROOT; ?>/buyer/confirmreceipt" style="display:inline;">
                        <input type="hidden" name="order_id" value="<?php echo (int)$order->id; ?>">
                        <button type="submit" class="btn-brand"><i class="bi bi-check-circle"></i> Confirm Receipt</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require APPROOT . '/views/layouts/panel_footer.php'; ?>
