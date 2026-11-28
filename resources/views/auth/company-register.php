<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Company Registration</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
    <div class="auth-shell">
        <div class="auth-card">
            <div class="kicker">Company</div>
            <h1>Register your team</h1>
            <form class="form-stack" method="post" action="index.php?page=register-company">
                <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>" />
                <label>Company name<input class="input" name="company_name" autocomplete="organization" placeholder="Your company name" required /></label>
                <label>Work email<input class="input" type="email" name="email" autocomplete="email" placeholder="you@company.com" required /></label>
                <div class="form-row">
                    <label>Industry<input class="input" name="industry" placeholder="e.g. Technology" /></label>
                    <label>Location<input class="input" name="location" placeholder="City, country" /></label>
                </div>
                <label>Company website<input class="input" type="url" name="website" placeholder="https://" /></label>
                <label>Password<input class="input" type="password" name="password" autocomplete="new-password" minlength="10" required /></label>
                <label>Confirm password<input class="input" type="password" name="password_confirmation" autocomplete="new-password" minlength="10" required /></label>
                <label class="checkbox-row"><input type="checkbox" name="accept_terms" value="1" required /> <span>I accept the <a href="index.php?page=terms" class="inline-link">terms</a> and <a href="index.php?page=privacy" class="inline-link">privacy policy</a>.</span></label>
                <button class="btn btn-primary" type="submit">Create company profile</button>
            </form>
            <p class="help-text">Already registered? <a href="index.php?page=signin" class="inline-link">Sign in</a></p>
        </div>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
