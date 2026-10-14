<?php require APPROOT . '/views/layouts/header.php'; ?>

<div style="max-width:1400px;margin:0 auto;padding:2.5rem 2rem;">

<!-- HERO SECTION -->
<section class="hero-modern">
    <div class="hero-content">
        <h1 class="hero-title">Buy & Sell with <span class="gradient-text">Absolute Confidence</span></h1>
        <p class="hero-subtitle"><?php echo $data['description'] ?? 'Zambia\'s Most Trusted Marketplace for Safe Transactions'; ?></p>
        <div class="hero-cta">
            <a href="<?php echo URLROOT; ?>/explore/index" class="btn btn-primary-glow">
                <i class="bi bi-compass-fill"></i>Explore Products
            </a>
            <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-secondary-glow">
                <i class="bi bi-shop"></i>Become a Seller
            </a>
        </div>
    </div>
    <div class="hero-decorative"></div>
</section>

<!-- PAYMENT METHODS HIGHLIGHT -->
<section class="payment-methods-section">
    <div class="section-header">
        <h2 class="section-title">Pay Your Way</h2>
        <p class="section-subtitle">Multiple payment options for your convenience</p>
    </div>
    <div class="payment-cards-grid">
        <div class="payment-method-card">
            <div class="payment-icon-wrapper">
                <i class="bi bi-credit-card-2-back"></i>
            </div>
            <h3>Visa Card</h3>
            <p>Secure credit and debit card payments with instant confirmation</p>
            <ul class="payment-features">
                <li><i class="bi bi-check-circle-fill"></i> Instant Processing</li>
                <li><i class="bi bi-check-circle-fill"></i> Secure & Encrypted</li>
                <li><i class="bi bi-check-circle-fill"></i> International Support</li>
            </ul>
        </div>

        <div class="payment-method-card">
            <div class="payment-icon-wrapper">
                <i class="bi bi-phone-vibrate"></i>
            </div>
            <h3>Mobile Money</h3>
            <p>Pay via Airtel Money, MTN Mobile Money, and other local providers</p>
            <ul class="payment-features">
                <li><i class="bi bi-check-circle-fill"></i> Local Providers</li>
                <li><i class="bi bi-check-circle-fill"></i> No Extra Fees</li>
                <li><i class="bi bi-check-circle-fill"></i> Instant Transfers</li>
            </ul>
        </div>

        <div class="payment-method-card">
            <div class="payment-icon-wrapper">
                <i class="bi bi-shield-check"></i>
            </div>
            <h3>Buyer Protection</h3>
            <p>All payments protected by our Smart Escrow system</p>
            <ul class="payment-features">
                <li><i class="bi bi-check-circle-fill"></i> Money Held Securely</li>
                <li><i class="bi bi-check-circle-fill"></i> Released on Delivery</li>
                <li><i class="bi bi-check-circle-fill"></i> Full Refund Guarantee</li>
            </ul>
        </div>
    </div>
</section>

<!-- KEY FEATURES SECTION -->
<section class="features-section">
    <div class="section-header">
        <h2 class="section-title">Why Choose TrustMarket?</h2>
        <p class="section-subtitle">Built for Zambian traders with security at the core</p>
    </div>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon-box">
                <i class="bi bi-shield-lock"></i>
            </div>
            <h3>Smart Escrow</h3>
            <p>Your funds are held securely until you confirm delivery. No more risk of paying for items you don't receive.</p>
            <div class="feature-badge">
                <i class="bi bi-lightning-fill"></i> Ultra-Safe
            </div>
        </div>

        <div class="feature-card">
            <div class="feature-icon-box">
                <i class="bi bi-star-fill"></i>
            </div>
            <h3>Dynamic Trust Score</h3>
            <p>Sellers are rated by actual performance metrics like response time, refund rate, and dispute resolution history.</p>
            <div class="feature-badge">
                <i class="bi bi-bar-chart-fill"></i> Data-Driven
            </div>
        </div>

        <div class="feature-card">
            <div class="feature-icon-box">
                <i class="bi bi-robot"></i>
            </div>
            <h3>AI Dispute Resolution</h3>
            <p>If something goes wrong, our AI instantly analyzes complaints and suggests fair resolutions.</p>
            <div class="feature-badge">
                <i class="bi bi-cpu"></i> AI-Powered
            </div>
        </div>

        <div class="feature-card">
            <div class="feature-icon-box">
                <i class="bi bi-lightning-charge"></i>
            </div>
            <h3>Fast Transactions</h3>
            <p>Real-time payment processing for both Visa and Mobile Money with minimal wait times.</p>
            <div class="feature-badge">
                <i class="bi bi-hourglass-split"></i> Instant
            </div>
        </div>

        <div class="feature-card">
            <div class="feature-icon-box">
                <i class="bi bi-globe-africa"></i>
            </div>
            <h3>Zambia-Focused</h3>
            <p>Built specifically for the Zambian market with local payment methods and language support.</p>
            <div class="feature-badge">
                <i class="bi bi-geo-fill"></i> Local
            </div>
        </div>

        <div class="feature-card">
            <div class="feature-icon-box">
                <i class="bi bi-chat-left-dots"></i>
            </div>
            <h3>Direct Messaging</h3>
            <p>Communicate directly with buyers and sellers before making purchases. Build trust naturally.</p>
            <div class="feature-badge">
                <i class="bi bi-chat-dots"></i> Connected
            </div>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-it-works-section">
    <div class="section-header">
        <h2 class="section-title">How It Works</h2>
        <p class="section-subtitle">Simple steps to buy or sell with confidence</p>
    </div>
    <div class="steps-container">
        <div class="step-card">
            <div class="step-number">1</div>
            <h3>Create Account</h3>
            <p>Sign up in seconds with your email and phone number</p>
        </div>
        <div class="step-connector"></div>
        
        <div class="step-card">
            <div class="step-number">2</div>
            <h3>Browse or List</h3>
            <p>Find amazing deals or list your products for free</p>
        </div>
        <div class="step-connector"></div>

        <div class="step-card">
            <div class="step-number">3</div>
            <h3>Pay Safely</h3>
            <p>Choose Visa or Mobile Money with built-in buyer protection</p>
        </div>
        <div class="step-connector"></div>

        <div class="step-card">
            <div class="step-number">4</div>
            <h3>Receive & Rate</h3>
            <p>Get your item and rate your experience. Build the community!</p>
        </div>
    </div>
</section>

<!-- STATS SECTION -->
<section class="stats-section">
    <div class="stat-box">
        <div class="stat-number">50K+</div>
        <div class="stat-label">Active Sellers</div>
    </div>
    <div class="stat-box">
        <div class="stat-number">200K+</div>
        <div class="stat-label">Products Listed</div>
    </div>
    <div class="stat-box">
        <div class="stat-number">15M ZMW</div>
        <div class="stat-label">Safe Transactions</div>
    </div>
    <div class="stat-box">
        <div class="stat-number">98%</div>
        <div class="stat-label">Satisfaction Rate</div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="cta-section">
    <h2>Ready to Start Trading?</h2>
    <p>Join thousands of Zambian buyers and sellers already enjoying safe, secure transactions</p>
    <div class="cta-buttons">
        <a href="<?php echo URLROOT; ?>/explore/index" class="btn btn-primary-glow">
            <i class="bi bi-shop"></i>Start Shopping
        </a>
        <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-outline-glow">
            <i class="bi bi-upload"></i>Start Selling
        </a>
    </div>
</section>

</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>
