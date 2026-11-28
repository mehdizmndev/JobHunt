<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/styles.css?v=auth-bg-1" />
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
                        <div class="label"><?php echo h($metric['label']); ?></div>
                        <div class="value"><?php echo h($metric['value']); ?></div>
                        <div class="trend"><?php echo h($metric['trend']); ?></div>
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
                                        <td><?php echo h($user['name']); ?></td>
                                        <td><?php echo h($user['email']); ?></td>
                                        <td><?php echo h($user['type']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <h3>Recently published jobs</h3>
                    <div class="list-stack">
                        <?php foreach (array_slice($jobs, 0, 5) as $job): ?>
                            <div class="notification-item"><div><strong><?php echo h($job['title']); ?></strong><br><span class="muted"><?php echo h($job['company']); ?></span></div><a class="inline-link" href="index.php?page=job-details&amp;id=<?php echo (int) $job['id']; ?>">View</a></div>
                        <?php endforeach; ?>
                        <?php if (!$jobs): ?><p class="muted">No active job offers yet.</p><?php endif; ?>
                    </div>
                </div>
            </div>
            <section class="card" style="margin-top:24px;">
                <h2>Contact messages</h2>
                <p class="muted">The 10 most recent messages sent through the public contact form.</p>
                <?php if ($messages): ?>
                    <div class="list-stack">
                        <?php foreach ($messages as $message): ?>
                            <article class="notification-item">
                                <div>
                                    <strong><?php echo h($message['full_name']); ?></strong>
                                    · <a class="inline-link" href="mailto:<?php echo h($message['email']); ?>"><?php echo h($message['email']); ?></a>
                                    <p><?php echo nl2br(h($message['message'])); ?></p>
                                </div>
                                <span class="help-text"><?php echo h(date('M j, Y H:i', strtotime($message['created_at']))); ?></span>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="muted">No contact messages yet.</p>
                <?php endif; ?>
            </section>
        </main>
    </div>
    <script src="assets/js/app.js?v=theme-top-2"></script>
</body>
</html>
