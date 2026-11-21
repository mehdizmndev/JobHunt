<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Choose a New Password</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
    <div class="auth-shell">
        <div class="auth-card">
            <div class="kicker">Account recovery</div>
            <h1>Choose a new password</h1>
            <form class="form-stack" method="post" action="index.php?page=reset-password">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>" />
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>" />
                <label>New password<input class="input" type="password" name="password" autocomplete="new-password" minlength="10" required /></label>
                <label>Confirm new password<input class="input" type="password" name="password_confirmation" autocomplete="new-password" minlength="10" required /></label>
                <button class="btn btn-primary" type="submit">Reset password</button>
                <div class="help-text"><a href="index.php?page=signin" class="inline-link">Back to sign in</a></div>
            </form>
        </div>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
