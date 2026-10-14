<?php require APPROOT . '/views/layouts/seller_header.php'; ?>

<!-- Page Hero -->
<div class="page-hero">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
        <div>
            <h1 class="hero-title">
                <?php
                    $hour = (int)date('H');
                    if ($hour < 12) echo 'Good morning';
                    elseif ($hour < 17) echo 'Good afternoon';
                    else echo 'Good evening';
                ?>, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
            </h1>
            <p class="hero-sub"><?php echo date('l, F j, Y'); ?> — Here is what's happening in your store today.</p>
        </div>
        <a href="<?php echo URLROOT; ?>/products/add" class="btn-brand">
            <i class="bi bi-plus-lg"></i> List New Product
        </a>
    </div>
</div>

<?php flash('product_message'); ?>

<!-- Stats Grid -->
<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px,1fr)); gap:1.5rem; margin-bottom:2.5rem;">
    <div class="stat-grid-card">
        <div class="icon-wrap" style="background:rgba(99,102,241,0.15);">
            <i class="bi bi-box-seam text-primary"></i>
        </div>
        <div class="stat-val"><?php echo $data['total_products']; ?></div>
        <div class="stat-label">Active Listings</div>
    </div>
    <div class="stat-grid-card">
        <div class="icon-wrap" style="background:rgba(16,185,129,0.15);">
            <i class="bi bi-receipt text-emerald"></i>
        </div>
        <div class="stat-val"><?php echo $data['total_orders']; ?></div>
        <div class="stat-label">Total Orders</div>
    </div>
    <div class="stat-grid-card">
        <div class="icon-wrap" style="background:rgba(245,158,11,0.15);">
            <i class="bi bi-cash-coin text-warning"></i>
        </div>
        <div class="stat-val">ZMW <?php echo number_format($data['total_revenue'], 0); ?></div>
        <div class="stat-label">Total Revenue</div>
    </div>
    <div class="stat-grid-card">
        <div class="icon-wrap" style="background:rgba(139,92,246,0.15);">
            <i class="bi bi-star" style="color:#a78bfa;"></i>
        </div>
        <div class="stat-val"><?php echo $data['trust_score']; ?></div>
        <div class="stat-label">Trust Score</div>
    </div>
</div>

<!-- Trust Score Bar -->
<div class="premium-card" style="margin-bottom:2rem;">
    <div class="premium-card-header">
        <h5 class="premium-card-title"><i class="bi bi-graph-up-arrow me-2 text-primary"></i>Your Trust Score</h5>
        <a href="<?php echo URLROOT; ?>/seller/trustscore" class="btn-glass" style="font-size:0.8rem; padding:0.4rem 0.9rem;">Details</a>
    </div>
    <div style="padding:1.5rem 2rem;">
        <div style="display:flex; justify-content:space-between; margin-bottom:0.75rem;">
            <span style="color:var(--text-muted); font-size:0.875rem;">Overall Score</span>
            <span style="color:#fff; font-weight:700;"><?php echo $data['trust_score']; ?> / 100</span>
        </div>
        <div class="trust-bar-wrap">
            <div class="trust-bar" style="width:<?php echo $data['trust_score']; ?>%;"></div>
        </div>
        <div style="display:grid; grid-template-columns: repeat(3,1fr); gap:1rem; margin-top:1.5rem; font-size:0.8rem; color:var(--text-muted);">
            <div>Response Time <strong style="color:#fff; display:block;"><?php echo $data['response_score']; ?>%</strong></div>
            <div>Completion Rate <strong style="color:#fff; display:block;"><?php echo $data['completion_rate']; ?>%</strong></div>
            <div>Dispute Rate <strong style="color:#ef4444; display:block;"><?php echo $data['dispute_rate']; ?>%</strong></div>
        </div>
    </div>
</div>

<!-- Recent Products Table -->
<div class="premium-card">
    <div class="premium-card-header">
        <h5 class="premium-card-title"><i class="bi bi-box-seam me-2 text-primary"></i>My Product Listings</h5>
        <a href="<?php echo URLROOT; ?>/products/add" class="btn-brand" style="font-size:0.8rem; padding:0.4rem 0.9rem;">
            <i class="bi bi-plus"></i> Add Product
        </a>
    </div>
    <div style="overflow-x:auto;">
        <?php if(empty($data['products'])): ?>
        <div style="text-align:center; padding:3rem; opacity:0.5;">
            <i class="bi bi-box-open" style="font-size:3rem; display:block; margin-bottom:1rem;"></i>
            <p>No products listed yet.</p>
            <a href="<?php echo URLROOT; ?>/products/add" class="btn-brand" style="margin-top:1rem;">List Your First Product</a>
        </div>
        <?php else: ?>
        <table class="table-premium">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price (ZMW)</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['products'] as $p): ?>
                <tr>
                    <td style="color:var(--text-dim);">#<?php echo $p->id; ?></td>
                    <td><strong><?php echo htmlspecialchars($p->title); ?></strong></td>
                    <td style="color:var(--brand-primary);"><?php echo $p->category; ?></td>
                    <td class="text-emerald fw-800"><?php echo number_format($p->price, 2); ?></td>
                    <td style="color:<?php echo $p->stock < 3 ? '#f59e0b' : 'var(--text-muted)'; ?>;"><?php echo $p->stock; ?></td>
                    <td><span class="status-badge badge-active"><?php echo $p->status; ?></span></td>
                    <td>
                        <div class="gap-btn">
                            <a href="<?php echo URLROOT; ?>/products/edit/<?php echo $p->id; ?>" class="btn-glass" style="font-size:0.75rem; padding:0.3rem 0.7rem;">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<?php require APPROOT . '/views/layouts/panel_footer.php'; ?>
