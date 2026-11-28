<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Sign In</title>
    <link rel="stylesheet" href="assets/css/styles.css?v=auth-bg-1" />
</head>
<body>
    <div class="auth-shell">
        <div class="auth-card">
            <div class="kicker">Welcome back</div>
            <h1>Sign in to JobHunt</h1>
            <form class="form-stack" method="post" action="index.php?page=signin">
                <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>" />
                <label>Email address<input class="input" type="email" name="email" autocomplete="email" placeholder="you@example.com" required /></label>
                <label>Password<input class="input" type="password" name="password" autocomplete="current-password" placeholder="Your password" required /></label>
                <button class="btn btn-primary" type="submit">Sign in</button>
                <div class="help-text">Not a member yet? <a href="index.php?page=account-type" class="inline-link">Create account</a></div>
            </form>
        </div>
    </div>
    <script src="assets/js/app.js?v=theme-top-2"></script>
</body>
</html>
