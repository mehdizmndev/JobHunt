<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Categories & Skills</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
    <div class="app-shell">
        <?php require __DIR__ . '/../components/admin-sidebar.php'; ?>
        <main class="app-main">
            <?php require __DIR__ . '/../components/topbar.php'; ?>
            <div class="page-header">
                <div class="kicker">Platform taxonomy</div>
                <h1>Categories & Skills</h1>
            </div>
            <div class="two-col">
                <div class="card">
                    <h3>Categories</h3>
                    <div class="list-stack">
                        <?php foreach ($categories as $category): ?>
                            <div class="notification-item">
                                <div><strong><?php echo htmlspecialchars($category['name']); ?></strong><br><span class="muted"><?php echo htmlspecialchars($category['count']); ?> listings</span></div>
                                <span class="badge badge-primary">Edit</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="card">
                    <h3>Skills</h3>
                    <div class="skill-list">
                        <?php foreach ($skills as $skill): ?>
                            <span class="skill-tag"><?php echo htmlspecialchars($skill); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
