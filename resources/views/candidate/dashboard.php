<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Candidate Dashboard</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
    <div class="app-shell">
        <?php require __DIR__ . '/../components/app-sidebar.php'; ?>
        <main class="app-main">
            <?php require __DIR__ . '/../components/topbar.php'; ?>
            <div class="page-header">
                <div class="kicker">Candidate workspace</div>
                <h1>Good morning, Alex.</h1>
                <p class="muted">Here’s an overview of your job search activity.</p>
            </div>
            <div class="metrics-grid">
                <?php foreach ($metrics as $metric): ?>
                    <div class="metric-card">
                        <div class="label"><?php echo htmlspecialchars($metric['label']); ?></div>
                        <div class="value"><?php echo htmlspecialchars($metric['value']); ?></div>
                        <div class="trend"><?php echo htmlspecialchars($metric['trend']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="two-col" style="margin-top:24px;">
                <div class="card">
                    <div class="section-header">
                        <div>
                            <div class="kicker">Recommended jobs</div>
                            <h2>Fresh opportunities</h2>
                        </div>
                    </div>
                    <div class="list-stack">
                        <?php foreach (array_slice($applications, 0, 3) as $entry): ?>
                            <div class="notification-item">
                                <div>
                                    <strong><?php echo htmlspecialchars($entry['position']); ?></strong><br>
                                    <span class="muted"><?php echo htmlspecialchars($entry['company']); ?></span>
                                </div>
                                <a class="btn btn-primary" href="index.php?page=job-details">View</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="card">
                    <div class="section-header">
                        <div>
                            <div class="kicker">AI profile</div>
                            <h2>Resume score</h2>
                        </div>
                    </div>
                    <div class="value">92%</div>
                    <p class="muted">Strong match for product and design roles.</p>
                    <button class="btn btn-ai" type="button">Optimize CV</button>
                </div>
            </div>
            <div class="two-col" style="margin-top:24px;">
                <div class="card">
                    <h3>Recent applications</h3>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr><th>Company</th><th>Position</th><th>Status</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($applications as $app): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($app['company']); ?></td>
                                        <td><?php echo htmlspecialchars($app['position']); ?></td>
                                        <td><span class="status-pill status-under-review"><?php echo htmlspecialchars($app['status']); ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <h3>Notifications</h3>
                    <?php foreach ($notifications as $item): ?>
                        <div class="notification-item">
                            <div>
                                <strong><?php echo htmlspecialchars($item['title']); ?></strong><br>
                                <span class="muted"><?php echo htmlspecialchars($item['detail']); ?></span>
                            </div>
                            <span class="muted"><?php echo htmlspecialchars($item['time']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
