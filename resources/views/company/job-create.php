<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Create Job Offer</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
    <div class="app-shell">
        <?php require __DIR__ . '/../components/company-sidebar.php'; ?>
        <main class="app-main">
            <?php require __DIR__ . '/../components/topbar.php'; ?>
            <div class="page-header">
                <div class="kicker">Recruitment</div>
                <h1>Create Job Offer</h1>
            </div>
            <div class="card form-stack">
                <div class="form-row">
                    <input class="input" placeholder="Job title" value="Senior Product Designer" />
                    <input class="input" placeholder="Department" value="Design" />
                </div>
                <div class="form-row">
                    <input class="input" placeholder="Location" value="Remote" />
                    <input class="input" placeholder="Employment type" value="Full-time" />
                </div>
                <textarea class="textarea" rows="5" placeholder="Job description">Design award-winning experiences that help hiring teams move faster.</textarea>
                <div class="form-row">
                    <input class="input" placeholder="Salary range" value="$120k-$150k" />
                    <input class="input" placeholder="Application deadline" value="2026-09-30" />
                </div>
                <button class="btn btn-primary" type="button">Publish job</button>
            </div>
        </main>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
