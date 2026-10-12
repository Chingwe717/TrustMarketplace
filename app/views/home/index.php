<?php require APPROOT . '/views/layouts/header.php'; ?>

<section class="hero animate-up">
    <h1>Buy and Sell with <span class="text-gradient">Absolute Confidence</span></h1>
    <p><?php echo $data['description']; ?></p>
    <div class="hero-actions">
        <a href="<?php echo URLROOT; ?>/products" class="btn btn-primary"><i class="fa-solid fa-compass me-2"></i> Explore Products</a>
        <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-outline">Become a Seller</a>
    </div>
</section>

<section class="features">
    <div class="feature-card glass animate-up" style="animation-delay: 0.2s;">
        <i class="fa-solid fa-lock feature-icon"></i>
        <h3>Smart Escrow</h3>
        <p>Your funds are held securely until you confirm delivery. No more risk of paying for items you don't receive. Perfect for mobile money transactions.</p>
    </div>

    <div class="feature-card glass animate-up" style="animation-delay: 0.4s;">
        <i class="fa-solid fa-star feature-icon"></i>
        <h3>Dynamic Trust Score</h3>
        <p>Sellers are rated not just by stars, but by actual performance metrics like response time, refund rate, and dispute history.</p>
    </div>

    <div class="feature-card glass animate-up" style="animation-delay: 0.6s;">
        <i class="fa-solid fa-robot feature-icon"></i>
        <h3>AI Dispute Resolution</h3>
        <p>If something goes wrong, our AI instantly analyzes your complaint and suggests fair resolutions to platform administrators.</p>
    </div>
</section>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
