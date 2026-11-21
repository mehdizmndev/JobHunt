<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Resumes</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
    <div class="app-shell">
        <?php require __DIR__ . '/../components/app-sidebar.php'; ?>
        <main class="app-main">
            <?php require __DIR__ . '/../components/topbar.php'; ?>
            <div class="page-header">
                <div class="kicker">CV tools</div>
                <h1>My Resumes</h1>
            </div>
            <div class="card">
                <div class="list-stack">
                    <div class="notification-item">
                        <div><strong>Product Designer - Main CV</strong><br><span class="muted">Updated 2 weeks ago</span></div>
                        <button class="btn btn-secondary" type="button">View</button>
                    </div>
                    <div class="notification-item">
                        <div><strong>Design Portfolio Pack</strong><br><span class="muted">Uploaded 1 month ago</span></div>
                        <button class="btn btn-secondary" type="button">Upload</button>
                    </div>
                </div>
                <button class="btn btn-primary" type="button" style="margin-top:18px;">Upload new resume</button>
            </div>
        </main>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
