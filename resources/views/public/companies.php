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
                    <div class="company-logo"><?php echo strtoupper(substr($company['name'], 0, 2)); ?></div>
                    <h3><?php echo htmlspecialchars($company['name']); ?></h3>
                    <p class="muted"><?php echo htmlspecialchars($company['industry']); ?></p>
                    <p class="muted"><?php echo htmlspecialchars($company['location']); ?></p>
                    <a class="btn btn-secondary" href="index.php?page=company-profile">View profile</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../components/public-footer.php'; ?>
