<?php require APPROOT . '/views/layouts/admin_header.php'; ?>

<div class="page-hero">
    <h1 class="hero-title">Verify Sellers</h1>
    <p class="hero-sub">Review seller accounts and their verification status.</p>
</div>

<div class="premium-card">
    <div class="premium-card-header">
        <h5 class="premium-card-title"><i class="bi bi-patch-check me-2"></i>Seller Accounts</h5>
    </div>
    <div style="overflow-x:auto;">
        <?php if (empty($data['sellers'])): ?>
            <div style="text-align:center; padding:3rem; opacity:0.6;">No sellers are waiting for review.</div>
        <?php else: ?>
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Verification</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['sellers'] as $seller): ?>
                        <tr>
                            <td>#<?php echo (int) ($seller->id ?? 0); ?></td>
                            <td><?php echo htmlspecialchars((string) ($seller->name ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars((string) ($seller->email ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo !empty($seller->verified) ? 'Verified' : 'Pending'; ?></td>
                            <td><?php echo !empty($seller->created_at) ? htmlspecialchars(date('M d, Y', strtotime($seller->created_at)), ENT_QUOTES, 'UTF-8') : '—'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require APPROOT . '/views/layouts/panel_footer.php'; ?>