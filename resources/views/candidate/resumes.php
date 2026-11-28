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
                    <?php foreach ($resumes as $resume): ?>
                        <div class="notification-item">
                            <div><strong><?php echo h($resume['file_name']); ?></strong><br><span class="muted">Uploaded <?php echo h(date('M j, Y', strtotime($resume['created_at']))); ?><?php echo $resume['is_primary'] ? ' · Primary resume' : ''; ?></span></div>
                            <a class="btn btn-secondary" href="index.php?page=resume-download&amp;id=<?php echo (int) $resume['id']; ?>">Download</a>
                        </div>
                    <?php endforeach; ?>
                    <?php if (!$resumes): ?><p class="muted">No resumes uploaded yet.</p><?php endif; ?>
                </div>
                <form class="form-stack" method="post" action="index.php?page=candidate-resumes" enctype="multipart/form-data" style="margin-top:24px;">
                    <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>" />
                    <label>Upload a resume (PDF, DOC, or DOCX; max 5 MB)
                        <input class="input" type="file" name="resume" accept=".pdf,.doc,.docx" required />
                    </label>
                    <button class="btn btn-primary" type="submit">Upload resume</button>
                </form>
                <div class="notice notice-info" style="margin-top:18px;">AI resume optimization — Coming soon.</div>
            </div>
        </main>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
