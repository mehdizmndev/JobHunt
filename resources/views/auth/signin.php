<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Sign In</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
    <div class="auth-shell">
        <div class="auth-card">
            <div class="kicker">Welcome back</div>
            <h1>Sign in to JobHunt</h1>
            <form class="form-stack">
                <input class="input" type="email" placeholder="Email address" value="alex@jobhunt.test" />
                <input class="input" type="password" placeholder="Password" value="password123" />
                <div class="checkbox-row"><input type="checkbox" checked /> <span>Keep me signed in</span></div>
                <button class="btn btn-primary" type="submit">Sign in</button>
                <div class="help-text">Forgot password? <a href="index.php?page=forgot-password" class="inline-link">Reset it</a></div>
                <div class="help-text">Not a member yet? <a href="index.php?page=account-type" class="inline-link">Create account</a></div>
            </form>
        </div>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
