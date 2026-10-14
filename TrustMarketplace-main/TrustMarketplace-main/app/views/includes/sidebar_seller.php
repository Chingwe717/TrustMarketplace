<?php
// Build current URL path for active link detection
$currentPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $currentPath);
// e.g. TrustMarketplace/public/seller/dashboard → ['TrustMarketplace','public','seller','dashboard']
$ctrl   = strtolower($segments[count($segments)-2] ?? '');
$method = strtolower($segments[count($segments)-1] ?? '');

function sidebarLink($ctrl, $method, $targetCtrl, $targetMethod, $label, $icon) {
    $active = ($ctrl === strtolower($targetCtrl) && $method === strtolower($targetMethod)) ? 'active' : '';
    $url = URLROOT . '/' . $targetCtrl . '/' . $targetMethod;
    echo "<a href=\"$url\" class=\"sidebar-item $active\"><i class=\"$icon\"></i><span>$label</span></a>";
}
?>
<div class="sidebar-modern">
    <div class="sidebar-header">
        <div class="brand-box">
            <div class="brand-icon"><i class="bi bi-shield-check"></i></div>
            <div>
                <span class="brand-main">TrustMarket</span>
                <span class="brand-sub">Seller Panel</span>
            </div>
        </div>
        <div class="user-brief">
            <div class="user-avatar-sm"><?php echo strtoupper(mb_substr($_SESSION['user_name'], 0, 1)); ?></div>
            <div class="user-info-sm">
                <div class="user-name-sm"><?php echo htmlspecialchars($_SESSION['user_name']); ?></div>
                <div class="user-role-sm">Seller Account</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <?php sidebarLink($ctrl, $method, 'seller', 'dashboard', 'Dashboard', 'bi bi-speedometer2'); ?>
        <?php sidebarLink($ctrl, $method, 'seller', 'products', 'My Products', 'bi bi-box-seam'); ?>
        <?php sidebarLink($ctrl, $method, 'products', 'add', 'List Product', 'bi bi-plus-circle'); ?>
        <?php sidebarLink($ctrl, $method, 'seller', 'orders', 'Incoming Orders', 'bi bi-cart3'); ?>
        <?php sidebarLink($ctrl, $method, 'seller', 'disputes', 'Disputes', 'bi bi-exclamation-triangle'); ?>
        <?php sidebarLink($ctrl, $method, 'seller', 'trustscore', 'My Trust Score', 'bi bi-star'); ?>
        <?php sidebarLink($ctrl, $method, 'seller', 'browse', 'Browse Market', 'bi bi-shop-window'); ?>
        <div class="sidebar-divider"></div>
        <a href="<?php echo URLROOT; ?>/users/logout" class="sidebar-item logout-link">
            <i class="bi bi-box-arrow-right"></i><span>Logout</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        &copy; <?php echo date('Y'); ?> TrustMarket
    </div>
</div>
