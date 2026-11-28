<?php require __DIR__ . '/../components/public-header.php'; ?>
<main class="section">
    <div class="container">
        <div class="page-header">
            <div class="kicker">Companies</div>
            <h1>Explore hiring teams and workplaces</h1>
        </div>
        <div class="grid-4">
            <?php foreach ($companies as $company): ?>
                <div class="card company-card">
                    <div class="company-logo"><?php echo h(strtoupper(substr($company['name'], 0, 2))); ?></div>
                    <h3><?php echo h($company['name']); ?></h3>
                    <p class="muted"><?php echo h($company['industry']); ?></p>
                    <p class="muted"><?php echo h($company['location']); ?></p>
                    <a class="btn btn-secondary" href="index.php?page=company-profile&amp;id=<?php echo (int) $company['id']; ?>">View profile</a>
                </div>
            <?php endforeach; ?>
            <?php if (!$companies): ?><div class="card empty-state"><h3>No companies listed yet</h3><p class="muted">Company profiles will appear here as teams join JobHunt.</p></div><?php endif; ?>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../components/public-footer.php'; ?>
