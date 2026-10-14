<?php
$currentPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $currentPath);
$ctrl   = strtolower($segments[count($segments)-2] ?? '');
$method = strtolower($segments[count($segments)-1] ?? '');

function sidebarLinkAdmin($ctrl, $method, $targetCtrl, $targetMethod, $label, $icon) {
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
                <span class="brand-sub">Admin Panel</span>
            </div>
        </div>
        <div class="user-brief">
            <div class="user-avatar-sm"><?php echo strtoupper(mb_substr($_SESSION['user_name'], 0, 1)); ?></div>
            <div class="user-info-sm">
                <div class="user-name-sm"><?php echo htmlspecialchars($_SESSION['user_name']); ?></div>
                <div class="user-role-sm">Administrator</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <?php sidebarLinkAdmin($ctrl, $method, 'admin', 'dashboard', 'Dashboard', 'bi bi-speedometer2'); ?>
        <?php sidebarLinkAdmin($ctrl, $method, 'admin', 'disputes', 'Dispute Queue', 'bi bi-exclamation-triangle'); ?>
        <?php sidebarLinkAdmin($ctrl, $method, 'admin', 'users', 'Manage Users', 'bi bi-people'); ?>
        <?php sidebarLinkAdmin($ctrl, $method, 'admin', 'sellers', 'Verify Sellers', 'bi bi-patch-check'); ?>
        <?php sidebarLinkAdmin($ctrl, $method, 'admin', 'analytics', 'Analytics', 'bi bi-graph-up'); ?>
        <div class="sidebar-divider"></div>
        <a href="<?php echo URLROOT; ?>/users/logout" class="sidebar-item logout-link">
            <i class="bi bi-box-arrow-right"></i><span>Logout</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        &copy; <?php echo date('Y'); ?> TrustMarket
    </div>
</div>
