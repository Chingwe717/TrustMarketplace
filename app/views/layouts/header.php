<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title'] ?? SITENAME; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
</head>
<body>

<!-- Public top nav -->
<header class="pub-header">
    <a href="<?php echo URLROOT; ?>" style="display:flex; align-items:center; gap:0.6rem; font-size:1.2rem; font-weight:800; color:#fff;">
        <div style="width:32px;height:32px;background:linear-gradient(135deg,#6366f1,#ec4899);border-radius:8px;display:flex;align-items:center;justify-content:center;">
            <i class="bi bi-shield-check" style="color:#fff;font-size:1rem;"></i>
        </div>
        TrustMarket
    </a>
    <ul class="pub-nav">
        <li><a href="<?php echo URLROOT; ?>/explore/index">Explore</a></li>
        <?php if(isset($_SESSION['user_id'])): ?>
            <?php if($_SESSION['user_role'] == 'seller'): ?>
                <li><a href="<?php echo URLROOT; ?>/seller/dashboard" style="color:var(--brand-primary);">My Dashboard</a></li>
            <?php elseif($_SESSION['user_role'] == 'buyer'): ?>
                <li><a href="<?php echo URLROOT; ?>/buyer/dashboard" style="color:var(--brand-primary);">My Dashboard</a></li>
            <?php else: ?>
                <li><a href="<?php echo URLROOT; ?>/admin/dashboard" style="color:var(--brand-primary);">Admin Panel</a></li>
            <?php endif; ?>
            <li><a href="<?php echo URLROOT; ?>/users/logout" class="btn-glass" style="padding:0.5rem 1rem;">Logout</a></li>
        <?php else: ?>
            <li><a href="<?php echo URLROOT; ?>/users/login">Sign In</a></li>
            <li><a href="<?php echo URLROOT; ?>/users/register" class="btn-brand" style="padding:0.5rem 1.25rem;">Join Now</a></li>
        <?php endif; ?>
    </ul>
</header>

<main style="max-width:1400px;margin:0 auto;padding:0;">
    <div style="margin:0;padding:0;">
        <?php
        // Global flash messages
        if(function_exists('flash')){
            flash('register_success');
            flash('register_fail');
            flash('product_message');
        }
        ?>
    </div>
