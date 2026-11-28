<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Candidate Registration</title>
    <link rel="stylesheet" href="assets/css/styles.css?v=auth-bg-1" />
</head>
<body>
    <div class="auth-shell">
        <div class="auth-card">
            <div class="kicker">Candidate</div>
            <h1>Create your account</h1>
            <form class="form-stack" method="post" action="index.php?page=register-candidate">
                <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>" />
                <label>Full name<input class="input" name="full_name" autocomplete="name" placeholder="Your full name" required /></label>
                <label>Email address<input class="input" type="email" name="email" autocomplete="email" placeholder="you@example.com" required /></label>
                <label>Password<input class="input" type="password" name="password" autocomplete="new-password" minlength="10" required /></label>
                <label>Confirm password<input class="input" type="password" name="password_confirmation" autocomplete="new-password" minlength="10" required /></label>
                <label class="checkbox-row"><input type="checkbox" name="accept_terms" value="1" required /> <span>I accept the <a href="index.php?page=terms" class="inline-link">terms</a> and <a href="index.php?page=privacy" class="inline-link">privacy policy</a>.</span></label>
                <button class="btn btn-primary" type="submit">Create account</button>
            </form>
            <p class="help-text">Already registered? <a href="index.php?page=signin" class="inline-link">Sign in</a></p>
        </div>
    </div>
    <script src="assets/js/app.js?v=theme-top-2"></script>
</body>
</html>
