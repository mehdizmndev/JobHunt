<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Company Dashboard</title>
    <link rel="stylesheet" href="assets/css/styles.css?v=auth-bg-1" />
</head>
<body>
    <div class="app-shell">
        <?php require __DIR__ . '/../components/company-sidebar.php'; ?>
        <main class="app-main">
            <?php require __DIR__ . '/../components/topbar.php'; ?>
            <div class="page-header">
                <div class="kicker">Company workspace</div>
                <h1>Welcome back, <?php echo h($_SESSION['user']['name'] ?? 'Company'); ?>.</h1>
                <p class="muted">Here’s what’s happening with your recruitment activity.</p>
            </div>
            <div class="metrics-grid">
                <?php foreach ($metrics as $metric): ?>
                    <div class="metric-card">
                        <div class="label"><?php echo h($metric['label']); ?></div>
                        <div class="value"><?php echo h($metric['value']); ?></div>
                        <div class="trend"><?php echo h($metric['trend']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="two-col" style="margin-top:24px;">
                <div class="card">
                    <h3>Active job offers</h3>
                    <div class="table-wrap">
                        <table>
                            <thead><tr><th>Role</th><th>Applicants</th><th>Status</th></tr></thead>
                            <tbody>
                                <?php foreach (array_slice($jobs, 0, 3) as $job): ?>
                                    <tr>
                                        <td><?php echo h($job['title']); ?></td>
                                        <td><?php echo (int) $job['applicant_count']; ?></td>
                                        <td><span class="status-pill status-<?php echo h($job['status']); ?>"><?php echo h(ucwords(str_replace('_', ' ', $job['status']))); ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <h3>Quick actions</h3>
                    <div class="list-stack">
                        <a class="btn btn-primary" href="index.php?page=company-job-create">Create Job Offer</a>
                        <a class="btn btn-secondary" href="index.php?page=company-candidates">View Candidates</a>
                        <a class="btn btn-secondary" href="index.php?page=company-jobs">Edit Job Offers</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/app.js?v=theme-top-2"></script>
</body>
</html>
