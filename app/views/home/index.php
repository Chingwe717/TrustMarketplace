<?php
$data = $data ?? [];
require APPROOT . '/views/layouts/header.php';
?>

<section class="hero animate-up">
    <h1>Buy and Sell with <span class="text-gradient">Absolute Confidence</span></h1>
    <p><?php echo htmlspecialchars($data['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
    <div class="hero-actions">
        <a href="<?php echo URLROOT; ?>/explore/index" class="btn btn-primary"><i class="bi bi-compass me-2"></i> Explore Products</a>
        <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-outline">Become a Seller</a>
    </div>
</section>

<section class="features">
    <div class="feature-card glass animate-up" style="animation-delay: 0.2s;">
        <i class="bi bi-lock-fill feature-icon"></i>
        <h3>Smart Escrow</h3>
        <p>Your funds are held securely until you confirm delivery. No more risk of paying for items you don't receive. Perfect for mobile money transactions.</p>
    </div>

    <div class="feature-card glass animate-up" style="animation-delay: 0.4s;">
        <i class="bi bi-star-fill feature-icon"></i>
        <h3>Dynamic Trust Score</h3>
        <p>Sellers are rated not just by stars, but by actual performance metrics like response time, refund rate, and dispute history.</p>
    </div>

    <div class="feature-card glass animate-up" style="animation-delay: 0.6s;">
        <i class="bi bi-cpu-fill feature-icon"></i>
        <h3>AI Dispute Resolution</h3>
        <p>If something goes wrong, our AI instantly analyzes your complaint and suggests fair resolutions to platform administrators.</p>
    </div>
</section>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
