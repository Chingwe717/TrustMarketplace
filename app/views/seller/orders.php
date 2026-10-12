<?php require APPROOT . '/views/layouts/seller_header.php'; ?>

<?php
// Status filter tabs
$filter = $data['filter'];
$tabs = [''=>'All Orders','funds_held'=>'Awaiting Action','shipped'=>'Shipped','delivered'=>'Delivered','confirmed'=>'Completed','disputed'=>'Disputed'];
?>

<!-- Page Header -->
<div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:2rem;">
    <div>
        <h2 style="font-size:1.75rem; font-weight:800; color:#fff; margin:0;">Incoming Orders</h2>
        <p style="color:var(--text-dim); margin-top:0.25rem;">Manage and fulfil customer escrow orders.</p>
    </div>
    <div style="color:var(--text-dim); font-size:0.875rem;">Total income: <strong style="color:#10b981;">ZMW <?php echo number_format($data['total_income'], 2); ?></strong></div>
</div>

<?php flash('order_message'); ?>

<!-- Filter Tabs -->
<div style="display:flex; gap:0.5rem; margin-bottom:2rem; flex-wrap:wrap;">
    <?php foreach($tabs as $val => $label): ?>
    <a href="<?php echo URLROOT; ?>/seller/orders<?php echo $val ? '?filter='.$val : ''; ?>"
       style="padding:0.5rem 1.1rem; border-radius:30px; font-size:0.8rem; font-weight:700;
              background:<?php echo $filter === $val ? 'var(--brand-primary)' : 'rgba(30,41,59,0.6)'; ?>;
              color:<?php echo $filter === $val ? '#fff' : 'var(--text-muted)'; ?>;
              border:1px solid <?php echo $filter === $val ? 'var(--brand-primary)' : 'var(--glass-border)'; ?>;
              text-decoration:none; transition:all 0.2s;">
        <?php echo $label; ?>
    </a>
    <?php endforeach; ?>
</div>

<!-- Orders List -->
<?php if(empty($data['orders'])): ?>
<div class="premium-card" style="text-align:center; padding:4rem;">
    <i class="bi bi-inbox" style="font-size:3.5rem; color:var(--text-dim); display:block; margin-bottom:1rem; opacity:0.3;"></i>
    <h5 style="color:#fff; font-weight:700;">No orders found</h5>
    <p style="color:var(--text-dim);">New orders will appear here once buyers place them.</p>
</div>
<?php else: foreach($data['orders'] as $o): ?>

<div class="premium-card" style="margin-bottom:1.5rem;">
    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:2rem; padding:2rem;">

        <!-- Col 1: Order Info -->
        <div>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                <span style="color:var(--text-dim); font-size:0.75rem; font-weight:800; text-transform:uppercase;">Order #<?php echo $o->id; ?></span>
                <span class="status-badge badge-<?php echo strtolower(str_replace(' ','_',$o->status)); ?>">
                    <?php echo ucfirst(str_replace('_',' ',$o->status)); ?>
                </span>
            </div>
            <h5 style="color:#fff; font-weight:700; margin-bottom:0.5rem;">
                <?php echo htmlspecialchars($o->items ?? 'Order items'); ?>
            </h5>
            <div style="color:#10b981; font-weight:700; margin-bottom:1rem;">ZMW <?php echo number_format($o->total, 2); ?></div>

            <!-- Buyer info box -->
            <div style="background:rgba(15,23,42,0.5); border:1px solid var(--glass-border); border-radius:12px; padding:1rem;">
                <div style="color:var(--text-dim); font-size:0.7rem; font-weight:800; text-transform:uppercase; margin-bottom:0.5rem;">Buyer Details</div>
                <div style="color:#fff; font-weight:700; font-size:0.875rem;"><?php echo htmlspecialchars($o->buyer_name); ?></div>
                <div style="color:var(--text-dim); font-size:0.8rem; margin-top:0.25rem;">
                    <i class="bi bi-lock"></i> Escrow: <strong style="color:<?php echo $o->escrow_status === 'held' ? '#f59e0b' : '#10b981'; ?>;"><?php echo ucfirst($o->escrow_status ?? 'held'); ?></strong>
                </div>
            </div>
        </div>

        <!-- Col 2: Update Status Form -->
        <div>
            <div style="color:var(--text-dim); font-size:0.75rem; font-weight:800; text-transform:uppercase; margin-bottom:0.75rem;">Payment & Delivery</div>
            <div style="color:#fff; font-size:0.875rem; font-weight:600; margin-bottom:0.5rem;">
                Placed on <?php echo date('M d, Y', strtotime($o->created_at)); ?>
            </div>

            <?php if(!in_array($o->status, ['confirmed','cancelled','disputed'])): ?>
            <form method="POST" action="<?php echo URLROOT; ?>/seller/updateorder" style="margin-top:1rem;">
                <input type="hidden" name="order_id" value="<?php echo $o->id; ?>">
                <div class="form-group">
                    <label class="form-label">Update Status</label>
                    <select name="status" class="form-input">
                        <?php if($o->status === 'funds_held'): ?>
                            <option value="shipped">Mark as Shipped</option>
                        <?php endif; ?>
                        <?php if($o->status === 'shipped'): ?>
                            <option value="delivered">Mark as Delivered</option>
                        <?php endif; ?>
                        <option value="cancelled">Cancel Order</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="tracking_note" class="form-input" placeholder="Tracking note (optional)">
                </div>
                <button type="submit" class="btn-brand" style="width:100%; justify-content:center;">
                    <i class="bi bi-arrow-repeat"></i> Update Order
                </button>
            </form>
            <?php else: ?>
            <div style="text-align:center; padding:2rem; background:rgba(16,185,129,0.05); border-radius:12px; border:1px solid rgba(16,185,129,0.2); margin-top:1rem;">
                <i class="bi bi-check-all" style="font-size:2rem; color:#10b981;"></i>
                <div style="color:var(--text-dim); font-size:0.85rem; margin-top:0.5rem;">Order Finalized</div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Col 3: Totals & Message -->
        <div style="text-align:right;">
            <div style="color:var(--text-dim); font-size:0.75rem; font-weight:800; text-transform:uppercase; margin-bottom:0.5rem;">Order Total</div>
            <h3 style="color:#fff; font-weight:800; margin-bottom:1.5rem;">ZMW <?php echo number_format($o->total, 2); ?></h3>
            <div style="color:var(--text-dim); font-size:0.8rem;">Escrow held: ZMW <?php echo number_format($o->escrow_amount ?? $o->total, 2); ?></div>
        </div>
    </div>
</div>

<?php endforeach; endif; ?>

<?php require APPROOT . '/views/layouts/panel_footer.php'; ?>
