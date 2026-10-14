<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="page-hero">
    <div>
        <h1 class="hero-title">Open a Dispute</h1>
        <p class="hero-sub">Let us know what went wrong with this order so we can review it fairly.</p>
    </div>
</div>

<div class="premium-card" style="max-width: 900px; margin: 0 auto 2rem;">
    <div class="premium-card-header">
        <h5 class="premium-card-title"><i class="bi bi-exclamation-triangle me-2" style="color:#ef4444;"></i>Dispute for Order #<?php echo (int)$data['order_id']; ?></h5>
    </div>

    <form action="<?php echo URLROOT; ?>/buyer/opendispute/<?php echo (int)$data['order_id']; ?>" method="POST">
        <div class="form-group">
            <label class="form-label">Describe the issue</label>
            <textarea name="description" rows="6" class="form-input <?php echo !empty($data['desc_err']) ? 'error' : ''; ?>" placeholder="Tell us what happened, what you expected, and any evidence you have."><?php echo htmlspecialchars($data['description'] ?? ''); ?></textarea>
            <?php if(!empty($data['desc_err'])): ?><span class="field-error"><?php echo $data['desc_err']; ?></span><?php endif; ?>
        </div>

        <div style="display:flex; gap:1rem; flex-wrap:wrap; margin-top:1.5rem;">
            <button type="submit" class="btn-brand"><i class="bi bi-send"></i> Submit Dispute</button>
            <a href="<?php echo URLROOT; ?>/buyer/orders" class="btn-glass">Back to Orders</a>
        </div>
    </form>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
