<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
    <div class="app-shell">
        <?php require __DIR__ . '/../components/admin-sidebar.php'; ?>
        <main class="app-main">
            <?php require __DIR__ . '/../components/topbar.php'; ?>
            <div class="page-header">
                <div class="kicker">Admin workspace</div>
                <h1>Platform Overview</h1>
                <p class="muted">Monitor and manage your JobHunt ecosystem.</p>
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
                    <h3>Recent registrations</h3>
                    <div class="table-wrap">
                        <table>
                            <thead><tr><th>User</th><th>Email</th><th>Type</th></tr></thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['type']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <h3>Moderation queue</h3>
                    <div class="list-stack">
                        <div class="notification-item"><div><strong>Reported job offer</strong><br><span class="muted">Northstar Labs</span></div><span class="badge badge-warning">Pending</span></div>
                        <div class="notification-item"><div><strong>Suspicious account</strong><br><span class="muted">3 flagged users</span></div><span class="badge badge-warning">Review</span></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
