<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Company Profile</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
    <div class="app-shell">
        <?php require __DIR__ . '/../components/company-sidebar.php'; ?>
        <main class="app-main">
            <?php require __DIR__ . '/../components/topbar.php'; ?>
            <div class="page-header">
                <div class="kicker">Company workspace</div>
                <h1>Company Profile</h1>
                <p class="muted">Help candidates understand your organization and workplace.</p>
            </div>
            <form class="card form-stack" method="post" action="index.php?page=company-profile-edit">
                <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>" />
                <div class="form-row">
                    <label>Company name<input class="input" name="company_name" value="<?php echo h($profile['company_name'] ?? ''); ?>" required /></label>
                    <label>Industry<input class="input" name="industry" value="<?php echo h($profile['industry'] ?? ''); ?>" /></label>
                </div>
                <div class="form-row">
                    <label>Company size<input class="input" name="company_size" value="<?php echo h($profile['company_size'] ?? ''); ?>" placeholder="e.g. 51-200" /></label>
                    <label>Founded year<input class="input" type="number" name="founded_year" min="1800" max="<?php echo date('Y'); ?>" value="<?php echo h($profile['founded_year'] ?? ''); ?>" /></label>
                </div>
                <div class="form-row">
                    <label>Location<input class="input" name="location" value="<?php echo h($profile['location'] ?? ''); ?>" /></label>
                    <label>Website<input class="input" type="url" name="website" value="<?php echo h($profile['website'] ?? ''); ?>" placeholder="https://" /></label>
                </div>
                <label>About your company<textarea class="textarea" name="description" rows="6"><?php echo h($profile['description'] ?? ''); ?></textarea></label>
                <button class="btn btn-primary" type="submit">Save company profile</button>
            </form>
        </main>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
