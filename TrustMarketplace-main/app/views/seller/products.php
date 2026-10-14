<?php require APPROOT . '/views/layouts/seller_header.php'; ?>

<!-- Header -->
<div class="page-hero">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
        <div>
            <h1 class="hero-title"><i class="bi bi-boxes me-2"></i>Product Listings</h1>
            <p class="hero-sub">Manage your inventory, edit prices and stock levels.</p>
        </div>
        <a href="<?php echo URLROOT; ?>/products/add" class="btn-brand">
            <i class="bi bi-plus-lg"></i> Add New Product
        </a>
    </div>
</div>

<?php flash('product_message'); ?>

<!-- Stats -->
<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:1.25rem; margin-bottom:2rem;">
    <div class="stat-grid-card">
        <div class="icon-wrap" style="background:rgba(99,102,241,0.15);"><i class="bi bi-box-seam text-primary"></i></div>
        <div class="stat-val"><?php echo $data['total_products']; ?></div>
        <div class="stat-label">Total Listed</div>
    </div>
    <div class="stat-grid-card">
        <div class="icon-wrap" style="background:rgba(16,185,129,0.15);"><i class="bi bi-check-circle text-emerald"></i></div>
        <div class="stat-val"><?php echo $data['active_count']; ?></div>
        <div class="stat-label">Active</div>
    </div>
    <div class="stat-grid-card">
        <div class="icon-wrap" style="background:rgba(245,158,11,0.15);"><i class="bi bi-cash-coin text-warning"></i></div>
        <div class="stat-val">ZMW <?php echo number_format($data['inventory_value'], 0); ?></div>
        <div class="stat-label">Inventory Value</div>
    </div>
</div>

<!-- Search/Filter -->
<div class="premium-card" style="margin-bottom:2rem;">
    <div style="padding:1.25rem 1.5rem;">
        <form method="GET" action="<?php echo URLROOT; ?>/seller/products" style="display:flex; gap:1rem; flex-wrap:wrap; align-items:flex-end;">
            <div style="flex:1; min-width:200px;">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-input" placeholder="Search your products..." value="<?php echo htmlspecialchars($data['search']); ?>">
            </div>
            <div style="min-width:150px;">
                <label class="form-label">Status</label>
                <select name="status" class="form-input">
                    <option value="">All</option>
                    <option value="active"   <?php echo $data['status_filter']==='active'  ? 'selected':'' ?>>Active</option>
                    <option value="inactive" <?php echo $data['status_filter']==='inactive'? 'selected':'' ?>>Inactive</option>
                </select>
            </div>
            <div style="display:flex; gap:0.5rem;">
                <button type="submit" class="btn-brand"><i class="bi bi-search"></i></button>
                <a href="<?php echo URLROOT; ?>/seller/products" class="btn-glass"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </form>
    </div>
</div>

<!-- Product Cards Grid — ProjectX style -->
<?php if(empty($data['products'])): ?>
<div class="premium-card" style="text-align:center; padding:4rem;">
    <i class="bi bi-box-seam" style="font-size:3.5rem; color:var(--text-dim); display:block; margin-bottom:1rem; opacity:0.3;"></i>
    <h5 style="color:#fff; font-weight:700;"><?php echo $data['search'] ? 'No products found' : 'No products yet'; ?></h5>
    <p style="color:var(--text-dim);"><?php echo $data['search'] ? 'Try adjusting your search.' : 'Start by adding your first product.'; ?></p>
    <a href="<?php echo URLROOT; ?>/products/add" class="btn-brand" style="margin-top:1rem; display:inline-flex;">Add First Product</a>
</div>
<?php else: ?>
<div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:1.5rem;">
    <?php foreach($data['products'] as $p): ?>
    <div style="background:rgba(30,41,59,0.5); border:1px solid var(--glass-border); border-radius:16px; overflow:hidden; transition:all 0.3s;"
         onmouseover="this.style.borderColor='rgba(99,102,241,0.4)'; this.style.transform='translateY(-3px)';"
         onmouseout="this.style.borderColor='var(--glass-border)'; this.style.transform='none';">
        <!-- Image -->
        <div style="height:190px; background:linear-gradient(135deg,rgba(30,41,59,1),rgba(15,23,42,1)); position:relative; display:flex; align-items:center; justify-content:center;">
            <?php if(!empty($p->images)): ?>
                <img src="<?php echo URLROOT; ?>/uploads/products/<?php echo htmlspecialchars($p->images); ?>" style="width:100%; height:100%; object-fit:cover;">
            <?php else: ?>
                <i class="bi bi-box-seam" style="font-size:3rem; color:var(--text-dim); opacity:0.3;"></i>
            <?php endif; ?>
            <!-- Status badge -->
            <span style="position:absolute; top:12px; right:12px;" class="status-badge badge-<?php echo $p->status === 'active' ? 'active' : 'pending'; ?>">
                <?php echo ucfirst($p->status); ?>
            </span>
        </div>
        <!-- Content -->
        <div style="padding:1.25rem;">
            <div style="color:var(--brand-primary); font-size:0.7rem; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:0.5rem;">
                <?php echo htmlspecialchars($p->category); ?>
            </div>
            <h4 style="color:#fff; font-weight:700; font-size:1rem; margin-bottom:0.5rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                <?php echo htmlspecialchars($p->title); ?>
            </h4>
            <div style="display:flex; align-items:center; gap:1rem; margin-bottom:1rem; font-size:0.8rem; color:var(--text-muted);">
                <span><i class="bi bi-boxes"></i> Stock: <?php echo $p->stock; ?>
                    <?php if($p->stock <= 3 && $p->stock > 0): ?>
                        <span style="color:#f59e0b; font-weight:700; margin-left:4px;"><i class="bi bi-lightning-fill"></i> Low</span>
                    <?php endif; ?>
                </span>
            </div>
            <div style="color:#10b981; font-size:1.25rem; font-weight:800; margin-bottom:1rem;">ZMW <?php echo number_format($p->price, 2); ?></div>
            <!-- Actions -->
            <div style="display:flex; gap:0.5rem;">
                <a href="<?php echo URLROOT; ?>/products/edit/<?php echo $p->id; ?>" class="btn-glass" style="flex:1; justify-content:center;">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <button onclick="confirmDelete(<?php echo $p->id; ?>,'<?php echo htmlspecialchars(addslashes($p->title)); ?>')" class="btn-danger-glass">
                    <i class="bi bi-trash3"></i>
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Delete Confirm Modal -->
<div id="deleteModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:9999; align-items:center; justify-content:center;">
    <div class="premium-card" style="max-width:400px; width:90%; padding:0; text-align:center;">
        <div style="padding:2.5rem;">
            <i class="bi bi-exclamation-triangle-fill" style="font-size:3rem; color:#ef4444; display:block; margin-bottom:1rem;"></i>
            <h5 style="color:#fff; font-weight:700;">Delete Product?</h5>
            <p style="color:var(--text-muted);">Are you sure you want to delete <strong id="delName" style="color:#fff;"></strong>? This cannot be undone.</p>
            <form method="POST" action="<?php echo URLROOT; ?>/products/delete" style="margin-top:1.5rem; display:flex; gap:0.75rem;">
                <input type="hidden" name="product_id" id="delId">
                <button type="submit" class="btn-danger-glass" style="flex:1; justify-content:center; padding:0.75rem;">Delete</button>
                <button type="button" onclick="document.getElementById('deleteModal').style.display='none'" class="btn-glass" style="flex:1; justify-content:center; padding:0.75rem;">Cancel</button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('delId').value = id;
    document.getElementById('delName').textContent = name;
    document.getElementById('deleteModal').style.display = 'flex';
}
</script>

<?php require APPROOT . '/views/layouts/panel_footer.php'; ?>
