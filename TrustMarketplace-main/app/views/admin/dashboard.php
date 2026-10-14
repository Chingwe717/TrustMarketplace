<?php require APPROOT . '/views/layouts/admin_header.php'; ?>

<div class="page-hero">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
        <div>
            <h1 class="hero-title">Admin Control Centre</h1>
            <p class="hero-sub"><?php echo date('l, F j, Y'); ?> — Platform overview and dispute management.</p>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px,1fr)); gap:1.5rem; margin-bottom:2.5rem;">
    <div class="stat-grid-card">
        <div class="icon-wrap" style="background:rgba(99,102,241,0.15);">
            <i class="bi bi-people text-primary"></i>
        </div>
        <div class="stat-val"><?php echo $data['total_users']; ?></div>
        <div class="stat-label">Total Users</div>
    </div>
    <div class="stat-grid-card">
        <div class="icon-wrap" style="background:rgba(16,185,129,0.15);">
            <i class="bi bi-receipt text-emerald"></i>
        </div>
        <div class="stat-val"><?php echo $data['total_orders']; ?></div>
        <div class="stat-label">Total Orders</div>
    </div>
    <div class="stat-grid-card">
        <div class="icon-wrap" style="background:rgba(239,68,68,0.15);">
            <i class="bi bi-exclamation-triangle" style="color:#ef4444;"></i>
        </div>
        <div class="stat-val"><?php echo $data['open_disputes']; ?></div>
        <div class="stat-label">Open Disputes</div>
    </div>
    <div class="stat-grid-card">
        <div class="icon-wrap" style="background:rgba(245,158,11,0.15);">
            <i class="bi bi-lock text-warning"></i>
        </div>
        <div class="stat-val">ZMW <?php echo number_format($data['funds_in_escrow'], 0); ?></div>
        <div class="stat-label">Funds in Escrow</div>
    </div>
</div>

<!-- Open Disputes Table -->
<div class="premium-card">
    <div class="premium-card-header">
        <h5 class="premium-card-title"><i class="bi bi-exclamation-triangle me-2" style="color:#ef4444;"></i>Open Dispute Queue</h5>
        <a href="<?php echo URLROOT; ?>/admin/disputes" class="btn-glass" style="font-size:0.8rem; padding:0.4rem 0.9rem;">View All</a>
    </div>
    <div style="overflow-x:auto;">
        <?php if(empty($data['disputes'])): ?>
        <div style="text-align:center; padding:3rem; opacity:0.5;">
            <i class="bi bi-check-circle" style="font-size:3rem; display:block; margin-bottom:1rem; color:#10b981;"></i>
            <p>No open disputes. The platform is running smoothly!</p>
        </div>
        <?php else: ?>
        <table class="table-premium">
            <thead>
                <tr>
                    <th>Dispute ID</th>
                    <th>Order #</th>
                    <th>Buyer</th>
                    <th>Seller</th>
                    <th>AI Category</th>
                    <th>AI Confidence</th>
                    <th>Status</th>
                    <th>Opened</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['disputes'] as $d): ?>
                <tr>
                    <td style="color:var(--text-dim); font-weight:700;">#<?php echo $d->id; ?></td>
                    <td>#<?php echo $d->order_id; ?></td>
                    <td><?php echo htmlspecialchars($d->buyer_name); ?></td>
                    <td><?php echo htmlspecialchars($d->seller_name); ?></td>
                    <td style="color:var(--brand-primary);"><?php echo $d->ai_category ? ucwords(str_replace('_',' ',$d->ai_category)) : '<em style="color:var(--text-dim)">Pending AI</em>'; ?></td>
                    <td><?php echo $d->ai_confidence ? round($d->ai_confidence * 100).'%' : '—'; ?></td>
                    <td><span class="status-badge badge-<?php echo $d->status; ?>"><?php echo ucfirst($d->status); ?></span></td>
                    <td style="color:var(--text-dim); font-size:0.85rem;"><?php echo date('M d, Y', strtotime($d->opened_at)); ?></td>
                    <td>
                        <a href="<?php echo URLROOT; ?>/admin/reviewdispute/<?php echo $d->id; ?>" class="btn-brand" style="font-size:0.75rem; padding:0.35rem 0.8rem;">
                            <i class="bi bi-gavel"></i> Review
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<?php require APPROOT . '/views/layouts/panel_footer.php'; ?>
