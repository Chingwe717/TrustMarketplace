<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="page-hero">
    <div>
        <h1 class="hero-title">My Disputes</h1>
        <p class="hero-sub">Track disputes raised on your orders and their current status.</p>
    </div>
</div>

<div class="premium-card">
    <div class="premium-card-header">
        <h5 class="premium-card-title"><i class="bi bi-exclamation-triangle me-2" style="color:#ef4444;"></i>Dispute History</h5>
    </div>

    <div style="text-align:center; padding:3rem; opacity:0.7;">
        <i class="bi bi-journal-text" style="font-size:3rem; display:block; margin-bottom:1rem;"></i>
        <p>No disputes yet. When you raise one, it will appear here.</p>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
