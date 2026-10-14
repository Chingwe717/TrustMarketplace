<?php require APPROOT . '/views/layouts/seller_header.php'; ?>

<div class="page-hero">
    <h1 class="hero-title"><i class="bi bi-plus-circle me-2"></i>List a New Product</h1>
    <p class="hero-sub">Fill in the details below to add your item to the TrustMarket catalogue.</p>
</div>

<div class="form-modern">
    <form action="<?php echo URLROOT; ?>/products/add" method="POST" enctype="multipart/form-data">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">
            <div class="form-group" style="grid-column:1/-1;">
                <label class="form-label">Product Title <sup style="color:#ef4444;">*</sup></label>
                <input type="text" name="title" class="form-input <?php echo !empty($data['title_err']) ? 'error' : ''; ?>"
                       placeholder="e.g. iPhone 14 Pro Max 256GB" value="<?php echo htmlspecialchars($data['title']); ?>">
                <?php if(!empty($data['title_err'])): ?><span class="field-error"><?php echo $data['title_err']; ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label">Category <sup style="color:#ef4444;">*</sup></label>
                <select name="category" class="form-input">
                    <?php
                    $cats = ['Electronics','Computers','Fashion','Home & Garden','Sports','Books','Vehicles','Property','Services','Other'];
                    foreach($cats as $cat):
                    ?>
                    <option value="<?php echo $cat; ?>" <?php echo $data['category'] == $cat ? 'selected' : ''; ?>><?php echo $cat; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Condition</label>
                <select name="condition_state" class="form-input">
                    <option value="New">New</option>
                    <option value="Used - Like New">Used - Like New</option>
                    <option value="Used - Good">Used - Good</option>
                    <option value="Used - Fair">Used - Fair</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Price (ZMW) <sup style="color:#ef4444;">*</sup></label>
                <input type="number" step="0.01" min="1" name="price" class="form-input <?php echo !empty($data['price_err']) ? 'error' : ''; ?>"
                       placeholder="0.00" value="<?php echo htmlspecialchars($data['price']); ?>">
                <?php if(!empty($data['price_err'])): ?><span class="field-error"><?php echo $data['price_err']; ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label">Stock Quantity <sup style="color:#ef4444;">*</sup></label>
                <input type="number" min="1" name="stock" class="form-input"
                       placeholder="1" value="<?php echo htmlspecialchars($data['stock']); ?>">
            </div>

            <div class="form-group" style="grid-column:1/-1;">
                <label class="form-label">Detailed Description <sup style="color:#ef4444;">*</sup></label>
                <textarea name="description" rows="5" class="form-input <?php echo !empty($data['description_err']) ? 'error' : ''; ?>"
                          placeholder="Describe your product in detail — condition, features, included accessories..."><?php echo htmlspecialchars($data['description']); ?></textarea>
                <?php if(!empty($data['description_err'])): ?><span class="field-error"><?php echo $data['description_err']; ?></span><?php endif; ?>
            </div>
            <div class="form-group" style="grid-column:1/-1;">
                <label class="form-label">Product Image (optional)</label>
                <input type="file" name="image" accept="image/*" class="form-input">
            </div>
        </div>

        <div class="gap-btn" style="margin-top:2rem;">
            <button type="submit" class="btn-brand"><i class="bi bi-check-lg"></i> List Product</button>
            <a href="<?php echo URLROOT; ?>/seller/dashboard" class="btn-glass"><i class="bi bi-arrow-left"></i> Cancel</a>
        </div>
    </form>
</div>

<?php require APPROOT . '/views/layouts/panel_footer.php'; ?>
