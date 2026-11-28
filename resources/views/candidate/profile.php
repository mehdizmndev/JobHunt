<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Profile</title>
    <link rel="stylesheet" href="assets/css/styles.css?v=auth-bg-1" />
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
            <form class="card form-stack" method="post" action="index.php?page=candidate-profile">
                <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>" />
                <div class="form-row">
                    <label>Full name<input class="input" name="full_name" value="<?php echo h($profile['full_name'] ?? ''); ?>" required /></label>
                    <label>Professional headline<input class="input" name="headline" value="<?php echo h($profile['headline'] ?? ''); ?>" placeholder="e.g. Senior Product Designer" /></label>
                </div>
                <label>Professional summary<textarea class="textarea" name="professional_summary" rows="5" placeholder="Describe your experience and strengths."><?php echo h($profile['professional_summary'] ?? ''); ?></textarea></label>
                <div class="form-row">
                    <label>Email<input class="input" type="email" value="<?php echo h($profile['email'] ?? ''); ?>" disabled /></label>
                    <label>Phone<input class="input" name="phone" value="<?php echo h($profile['phone'] ?? ''); ?>" /></label>
                </div>
                <label>Location<input class="input" name="location" value="<?php echo h($profile['location'] ?? ''); ?>" /></label>
                <button class="btn btn-primary" type="submit">Save profile</button>
            </form>
        </main>
    </div>
    <script src="assets/js/app.js?v=theme-top-2"></script>
</body>
</html>
