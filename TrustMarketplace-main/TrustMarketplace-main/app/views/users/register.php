<?php require APPROOT . '/views/layouts/header.php'; ?>
<div class="auth-wrapper">
    <div class="auth-card">
        <div style="text-align:center; margin-bottom:2rem;">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,#6366f1,#ec4899);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                <i class="bi bi-person-plus" style="color:#fff;font-size:1.5rem;"></i>
            </div>
            <h2 style="font-size:1.5rem; font-weight:800; margin-bottom:0.25rem;">Create an Account</h2>
            <p style="color:var(--text-dim); font-size:0.875rem;">Join the trusted marketplace for Zambia</p>
        </div>

        <form action="<?php echo URLROOT; ?>/users/register" method="POST">
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-input <?php echo !empty($data['name_err']) ? 'error' : ''; ?>"
                       placeholder="John Doe" value="<?php echo htmlspecialchars($data['name']); ?>">
                <?php if(!empty($data['name_err'])): ?><span class="field-error"><?php echo $data['name_err']; ?></span><?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-input <?php echo !empty($data['email_err']) ? 'error' : ''; ?>"
                       placeholder="you@example.com" value="<?php echo htmlspecialchars($data['email']); ?>">
                <?php if(!empty($data['email_err'])): ?><span class="field-error"><?php echo $data['email_err']; ?></span><?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">I want to</label>
                <select name="role" class="form-input">
                    <option value="buyer" <?php echo $data['role'] == 'buyer' ? 'selected' : ''; ?>>Buy Products</option>
                    <option value="seller" <?php echo $data['role'] == 'seller' ? 'selected' : ''; ?>>Sell Products</option>
                </select>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input <?php echo !empty($data['password_err']) ? 'error' : ''; ?>" placeholder="Min 6 chars">
                    <?php if(!empty($data['password_err'])): ?><span class="field-error"><?php echo $data['password_err']; ?></span><?php endif; ?>
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-input <?php echo !empty($data['confirm_password_err']) ? 'error' : ''; ?>" placeholder="Repeat password">
                    <?php if(!empty($data['confirm_password_err'])): ?><span class="field-error"><?php echo $data['confirm_password_err']; ?></span><?php endif; ?>
                </div>
            </div>
            <button type="submit" class="btn-brand" style="width:100%; justify-content:center; padding:0.85rem; margin-top:0.5rem;">
                <i class="bi bi-person-check"></i> Create Account
            </button>
        </form>

        <p style="text-align:center; margin-top:1.5rem; color:var(--text-dim); font-size:0.875rem;">
            Already have an account? <a href="<?php echo URLROOT; ?>/users/login" style="color:var(--brand-primary); font-weight:600;">Login here</a>
        </p>
    </div>
</div>
<?php require APPROOT . '/views/layouts/footer.php'; ?>
