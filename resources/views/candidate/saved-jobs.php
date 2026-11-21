<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Saved Jobs</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
    <div class="app-shell">
        <?php require __DIR__ . '/../components/app-sidebar.php'; ?>
        <main class="app-main">
            <?php require __DIR__ . '/../components/topbar.php'; ?>
            <div class="page-header">
                <div class="kicker">Your shortlist</div>
                <h1>Saved Jobs</h1>
                <p class="muted">Roles you saved for later.</p>
            </div>
            <div class="job-grid">
                <?php foreach ($jobs as $job): ?>
                    <article class="job-card">
                        <div class="job-top">
                            <strong><?php echo htmlspecialchars($job['company']); ?></strong>
                            <span class="badge badge-primary"><?php echo htmlspecialchars($job['workplace']); ?></span>
                        </div>
                        <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                        <div class="job-meta">
                            <span><?php echo htmlspecialchars($job['location']); ?></span>
                            <span><?php echo htmlspecialchars($job['type']); ?></span>
                            <span><?php echo $job['salary_min'] && $job['salary_max'] ? htmlspecialchars(number_format($job['salary_min']) . ' - ' . number_format($job['salary_max']) . ' ' . $job['currency']) : 'Salary not disclosed'; ?></span>
                        </div>
                        <div class="hero-actions" style="margin-top:16px;">
                            <a class="btn btn-primary" href="index.php?page=job-details&amp;id=<?php echo (int) $job['id']; ?>">View job</a>
                            <form method="post" action="index.php?page=candidate-saved">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>" />
                                <input type="hidden" name="job_id" value="<?php echo (int) $job['id']; ?>" />
                                <button class="btn btn-secondary" type="submit">Remove</button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; ?>
                <?php if (!$jobs): ?><div class="card empty-state"><h3>No saved jobs yet</h3><p class="muted">Explore current openings and save roles you want to revisit.</p><a class="btn btn-primary" href="index.php?page=candidate-jobs">Find jobs</a></div><?php endif; ?>
            </div>
        </main>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
