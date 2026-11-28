<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Find Jobs</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
    <div class="app-shell">
        <?php require __DIR__ . '/../components/app-sidebar.php'; ?>
        <main class="app-main">
            <?php require __DIR__ . '/../components/topbar.php'; ?>
            <div class="page-header">
                <div class="kicker">Find jobs</div>
                <h1>Find Your Next Opportunity</h1>
            </div>
            <div class="card" style="margin-bottom:18px;">
                <form class="field-row" method="get" action="index.php">
                    <input type="hidden" name="page" value="candidate-jobs" />
                    <input class="input" name="keyword" placeholder="Keyword" />
                    <input class="input" name="location" placeholder="Location" />
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
            </div>
            <div class="job-grid">
                <?php foreach ($jobs as $job): ?>
                    <article class="job-card">
                        <div class="job-top">
                            <div class="company-badge"><span class="company-logo" style="width:40px;height:40px;">C</span><?php echo h($job['company']); ?></div>
                            <span class="badge badge-primary"><?php echo h($job['workplace']); ?></span>
                        </div>
                        <h3><?php echo h($job['title']); ?></h3>
                        <p class="muted"><?php echo h($job['tagline']); ?></p>
                        <div class="job-meta">
                            <span><?php echo h($job['location']); ?></span>
                            <span><?php echo h($job['salary']); ?></span>
                        </div>
                        <div class="skill-list">
                            <?php foreach ($job['skills'] as $skill): ?>
                                <span class="skill-tag"><?php echo h($skill); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="card-footer">
                            <span class="muted"><?php echo h($job['posted']); ?></span>
                            <a class="btn btn-primary" href="index.php?page=job-details&amp;id=<?php echo (int) $job['id']; ?>">View job</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
