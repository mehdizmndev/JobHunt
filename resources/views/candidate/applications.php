<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · My Applications</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
    <div class="app-shell">
        <?php require __DIR__ . '/../components/app-sidebar.php'; ?>
        <main class="app-main">
            <?php require __DIR__ . '/../components/topbar.php'; ?>
            <div class="page-header">
                <div class="kicker">Applications</div>
                <h1>My Applications</h1>
            </div>
            <div class="card">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr><th>Company</th><th>Position</th><th>Applied</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applications as $item): ?>
                                <tr>
                                    <td><?php echo h($item['company']); ?></td>
                                    <td><?php echo h($item['position']); ?></td>
                                    <td><?php echo h($item['date']); ?></td>
                                    <td><span class="status-pill"><?php echo h(ucwords(str_replace('_', ' ', $item['status']))); ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
