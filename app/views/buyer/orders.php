<?php require APPROOT . '/views/layouts/buyer_header.php'; ?>

<?php
$filter = $data['filter'];
$tabs = [''=>'All Orders','funds_held'=>'In Escrow','shipped'=>'Shipped','delivered'=>'Delivered','confirmed'=>'Completed','disputed'=>'Disputed'];
?>

<!-- Header -->
<div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:2rem;">
    <div>
        <h2 style="font-size:1.75rem; font-weight:800; color:#fff; margin:0;">My Orders</h2>
        <p style="color:var(--text-dim); margin-top:0.25rem;">Monitor your active shipments and escrow payments.</p>
    </div>
    <a href="<?php echo URLROOT; ?>/explore/index" class="btn-brand">
        <i class="bi bi-shop-window"></i> Continue Shopping
    </a>
</div>

<?php flash('order_message'); ?>

<!-- Filter Tabs -->
<div style="display:flex; gap:0.5rem; margin-bottom:2rem; flex-wrap:wrap;">
    <?php foreach($tabs as $val => $label): ?>
    <a href="<?php echo URLROOT; ?>/buyer/orders<?php echo $val ? '?filter='.$val : ''; ?>"
       style="padding:0.5rem 1.1rem; border-radius:30px; font-size:0.8rem; font-weight:700;
              background:<?php echo $filter === $val ? 'var(--brand-primary)' : 'rgba(30,41,59,0.6)'; ?>;
              color:<?php echo $filter === $val ? '#fff' : 'var(--text-muted)'; ?>;
              border:1px solid <?php echo $filter === $val ? 'var(--brand-primary)' : 'var(--glass-border)'; ?>;
              text-decoration:none; transition:all 0.2s;">
        <?php echo $label; ?>
    </a>
    <?php endforeach; ?>
</div>

<!-- Orders -->
<?php if(empty($data['orders'])): ?>
<div class="premium-card" style="text-align:center; padding:4rem;">
    <i class="bi bi-cart-x" style="font-size:3.5rem; color:var(--text-dim); display:block; margin-bottom:1rem; opacity:0.3;"></i>
    <h5 style="color:#fff; font-weight:700;">No orders yet</h5>
    <p style="color:var(--text-dim);">Start exploring the marketplace to find products.</p>
    <a href="<?php echo URLROOT; ?>/explore/index" class="btn-brand" style="margin-top:1rem; display:inline-flex;">Browse Market</a>
</div>
<?php else: foreach($data['orders'] as $o): ?>

<div class="premium-card" style="margin-bottom:1.5rem;">
    <div style="padding:2rem;">
        <!-- Order Header -->
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem;">
            <div>
                <div style="color:var(--brand-primary); font-size:0.75rem; font-weight:800; text-transform:uppercase; margin-bottom:0.25rem;">
                    Order #<?php echo $o->id; ?> &mdash; <?php echo date('M d, Y', strtotime($o->created_at)); ?>
                </div>
                <h4 style="color:#fff; font-weight:700; margin:0;">
                    ZMW <?php echo number_format($o->total, 2); ?>
                </h4>
            </div>
            <div style="text-align:right;">
                <span class="status-badge badge-<?php echo strtolower($o->status); ?>">
                    <?php echo strtoupper(str_replace('_',' ',$o->status)); ?>
                </span>
                <div style="margin-top:0.5rem; color:var(--text-dim); font-size:0.8rem;">
                    Escrow: <strong style="color:<?php echo $o->escrow_status === 'held' ? '#f59e0b' : ($o->escrow_status === 'released' ? '#10b981' : '#6366f1'); ?>;">
                        <?php echo ucfirst($o->escrow_status ?? 'held'); ?>
                    </strong>
                </div>
            </div>
        </div>

        <?php if($o->status !== 'cancelled'): ?>
        <!-- Tracking Pipeline — ProjectX style -->
        <?php
            $stages    = ['funds_held','shipped','delivered','confirmed'];
            $labels    = ['Payment Secured','Dispatched','Delivered','Confirmed'];
            $curIdx    = array_search($o->status, $stages);
            if($curIdx === false) $curIdx = -1;
        ?>
        <div style="margin-bottom:2rem; padding:0 0.5rem;">
            <div style="display:flex; justify-content:space-between; margin-bottom:0.75rem;">
                <?php foreach($labels as $l): ?>
                <small style="color:var(--text-dim); font-weight:800; font-size:0.65rem; text-transform:uppercase;"><?php echo $l; ?></small>
                <?php endforeach; ?>
            </div>
            <div style="display:flex; align-items:center;">
                <?php foreach($stages as $i => $stage): ?>
                    <div style="width:14px;height:14px;border-radius:50%;flex-shrink:0;
                                background:<?php echo $curIdx >= $i ? '#10b981' : 'var(--glass-border)'; ?>;
                                box-shadow:<?php echo $curIdx >= $i ? '0 0 10px rgba(16,185,129,0.5)' : 'none'; ?>;
                                transition:all 0.3s;"></div>
                    <?php if($i < count($stages)-1): ?>
                    <div style="height:2px; flex-grow:1; margin:0 4px;
                                background:<?php echo $curIdx > $i ? '#10b981' : 'var(--glass-border)'; ?>;
                                transition:all 0.3s;"></div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Seller Info + Actions -->
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
            <div style="display:flex; align-items:center; gap:1rem;">
                <div style="width:44px;height:44px;border-radius:50%;background:rgba(99,102,241,0.15);display:flex;align-items:center;justify-content:center;color:var(--brand-primary);">
                    <i class="bi bi-shop" style="font-size:1.1rem;"></i>
                </div>
                <div>
                    <div style="color:var(--text-dim); font-size:0.75rem;">Sold by</div>
                    <div style="color:#fff; font-weight:700;"><?php echo htmlspecialchars($o->seller_name); ?></div>
                </div>
            </div>
            <div class="gap-btn">
                <?php if($o->status === 'delivered'): ?>
                <form method="POST" action="<?php echo URLROOT; ?>/buyer/confirmreceipt" style="display:inline;">
                    <input type="hidden" name="order_id" value="<?php echo $o->id; ?>">
                    <button type="submit" class="btn-brand">
                        <i class="bi bi-check-circle"></i> Confirm Receipt & Release Escrow
                    </button>
                </form>
                <?php endif; ?>
                <?php if(in_array($o->status, ['funds_held','shipped','delivered'])): ?>
                <a href="<?php echo URLROOT; ?>/buyer/opendispute/<?php echo $o->id; ?>" class="btn-danger-glass">
                    <i class="bi bi-exclamation-triangle"></i> Open Dispute
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php endforeach; endif; ?>

<?php require APPROOT . '/views/layouts/panel_footer.php'; ?>
