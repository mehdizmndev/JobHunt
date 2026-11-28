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
                                <div><strong><?php echo h($category['name']); ?></strong><br><span class="muted"><?php echo h($category['count']); ?> listings</span></div>
                                <span class="badge badge-primary"><?php echo (int) $category['count']; ?> jobs</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="card">
                    <h3>Skills</h3>
                    <div class="skill-list">
                        <?php foreach ($skills as $skill): ?>
                            <span class="skill-tag"><?php echo h($skill); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="card">
                    <h3>Add a job category</h3>
                    <form class="form-stack" method="post" action="index.php?page=admin-categories">
                        <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>" />
                        <label>Category name<input class="input" name="name" maxlength="100" required /></label>
                        <label>Description<input class="input" name="description" maxlength="255" /></label>
                        <button class="btn btn-primary" type="submit">Add category</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
