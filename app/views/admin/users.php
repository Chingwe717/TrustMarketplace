<?php require APPROOT . '/views/layouts/admin_header.php'; ?>

<div class="page-hero">
    <h1 class="hero-title">Manage Users</h1>
    <p class="hero-sub">Review TrustMarket accounts and their platform roles.</p>
</div>

<div class="premium-card">
    <div class="premium-card-header">
        <h5 class="premium-card-title"><i class="bi bi-people me-2"></i>Platform Users</h5>
    </div>
    <div style="overflow-x:auto;">
        <?php if (empty($data['users'])): ?>
            <div style="text-align:center; padding:3rem; opacity:0.6;">No users found.</div>
        <?php else: ?>
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['users'] as $user): ?>
                        <tr>
                            <td>#<?php echo (int) ($user->id ?? 0); ?></td>
                            <td><?php echo htmlspecialchars((string) ($user->name ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars((string) ($user->email ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars(ucfirst((string) ($user->role ?? '')), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo !empty($user->created_at) ? htmlspecialchars(date('M d, Y', strtotime($user->created_at)), ENT_QUOTES, 'UTF-8') : '—'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require APPROOT . '/views/layouts/panel_footer.php'; ?>