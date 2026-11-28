<?php require __DIR__ . '/../components/public-header.php'; ?>
<main class="section">
    <div class="container two-col">
        <div class="card">
            <div class="company-badge"><span class="company-logo" style="width:52px;height:52px;">N</span><strong><?php echo h($company['name']); ?></strong></div>
            <h1 style="margin-top:18px;">About <?php echo h($company['name']); ?></h1>
            <p class="muted"><?php echo h($company['description'] ?: 'Company information has not been added yet.'); ?></p>
            <div class="list-stack">
                <div><strong>Industry:</strong> <?php echo h($company['industry'] ?: 'Not specified'); ?></div>
                <div><strong>Location:</strong> <?php echo h($company['location'] ?: 'Not specified'); ?></div>
                <div><strong>Employees:</strong> <?php echo h($company['size'] ?: 'Not specified'); ?></div>
                <?php if ($company['website']): ?><div><strong>Website:</strong> <a class="inline-link" href="<?php echo h($company['website']); ?>" rel="noopener noreferrer"><?php echo h($company['website']); ?></a></div><?php endif; ?>
            </div>
        </div>
        <div class="card">
            <h3>Open roles</h3>
            <div class="list-stack">
                <?php foreach ($jobs as $job): ?>
                    <a href="index.php?page=job-details&amp;id=<?php echo (int) $job['id']; ?>"><?php echo h($job['title']); ?></a>
                <?php endforeach; ?>
                <?php if (!$jobs): ?><div class="muted">No open roles at the moment.</div><?php endif; ?>
            </div>
            <a class="btn btn-primary" style="margin-top:18px;" href="index.php?page=jobs">See jobs</a>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../components/public-footer.php'; ?>
