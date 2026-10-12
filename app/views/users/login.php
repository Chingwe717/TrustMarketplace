<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="auth-wrapper">
    <div class="auth-card">
        <div style="text-align:center; margin-bottom:2rem;">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,#6366f1,#ec4899);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                <i class="bi bi-shield-check" style="color:#fff;font-size:1.5rem;"></i>
            </div>
            <h2 style="font-size:1.5rem; font-weight:800; margin-bottom:0.25rem;">Welcome Back</h2>
            <p style="color:var(--text-dim); font-size:0.875rem;">Login to your TrustMarket account</p>
        </div>

        <?php flash('register_success'); ?>

        <form action="<?php echo URLROOT; ?>/users/login" method="POST">
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-input <?php echo !empty($data['email_err']) ? 'error' : ''; ?>"
                       placeholder="you@example.com" value="<?php echo $data['email']; ?>">
                <?php if(!empty($data['email_err'])): ?><span class="field-error"><?php echo $data['email_err']; ?></span><?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input <?php echo !empty($data['password_err']) ? 'error' : ''; ?>"
                       placeholder="••••••••">
                <?php if(!empty($data['password_err'])): ?><span class="field-error"><?php echo $data['password_err']; ?></span><?php endif; ?>
            </div>
            <button type="submit" class="btn-brand" style="width:100%; justify-content:center; padding:0.85rem; margin-top:0.5rem;">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </button>
        </form>

        <p style="text-align:center; margin-top:1.5rem; color:var(--text-dim); font-size:0.875rem;">
            Don't have an account? <a href="<?php echo URLROOT; ?>/users/register" style="color:var(--brand-primary); font-weight:600;">Register here</a>
        </p>

        <div style="margin-top:1.5rem; padding:1rem; background:rgba(99,102,241,0.08); border-radius:10px; border:1px solid rgba(99,102,241,0.2); font-size:0.8rem; color:var(--text-muted);">
            <strong style="color:var(--brand-primary);">Demo Accounts:</strong><br>
            buyer@demo.com &nbsp;|&nbsp; seller@demo.com &nbsp;|&nbsp; admin@demo.com<br>
            Password: <strong>password123</strong>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
