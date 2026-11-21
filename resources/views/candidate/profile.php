<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Profile</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
    <div class="app-shell">
        <?php require __DIR__ . '/../components/app-sidebar.php'; ?>
        <main class="app-main">
            <?php require __DIR__ . '/../components/topbar.php'; ?>
            <div class="page-header">
                <div class="kicker">Profile</div>
                <h1>My Profile</h1>
            </div>
            <div class="card form-stack">
                <div class="form-row">
                    <input class="input" placeholder="Full name" value="Alex Morgan" />
                    <input class="input" placeholder="Professional headline" value="Senior Product Designer" />
                </div>
                <textarea class="textarea" rows="4" placeholder="Professional summary">Product designer with 6 years in SaaS, UX research, and design systems.</textarea>
                <div class="form-row">
                    <input class="input" placeholder="Email" value="alex@jobhunt.test" />
                    <input class="input" placeholder="Phone" value="+1 (415) 555-0123" />
                </div>
                <button class="btn btn-primary" type="button">Save profile</button>
            </div>
        </main>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
