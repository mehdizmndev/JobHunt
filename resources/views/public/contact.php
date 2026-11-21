<?php require __DIR__ . '/../components/public-header.php'; ?>
<main class="section">
    <div class="container two-col">
        <div class="card">
            <div class="kicker">Contact</div>
            <h1>Send us a message</h1>
            <p class="muted">Questions or need help? Send a message and our JobHunt administrators will see it in their dashboard.</p>
            <form class="form-stack" method="post" action="index.php?page=contact">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>" />
                <label>Your name<input class="input" name="full_name" autocomplete="name" required /></label>
                <label>Email address<input class="input" type="email" name="email" autocomplete="email" required /></label>
                <label>How can we help?<textarea class="textarea" name="message" rows="5" required></textarea></label>
                <button class="btn btn-primary" type="submit">Send message</button>
            </form>
        </div>
        <div class="card">
            <h3>What happens next?</h3>
            <p class="muted">Your name, email, and message are saved so an administrator can review and respond to your request.</p>
            <p class="help-text">Please do not include passwords or sensitive personal information in your message.</p>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../components/public-footer.php'; ?>
