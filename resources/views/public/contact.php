<?php require __DIR__ . '/../components/public-header.php'; ?>
<main class="section">
    <div class="container two-col">
        <div class="card">
            <div class="kicker">Contact</div>
            <h1>We’d love to hear from you</h1>
            <form class="form-stack" method="post" action="index.php?page=contact">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>" />
                <label>Your name<input class="input" name="full_name" autocomplete="name" required /></label>
                <label>Email address<input class="input" type="email" name="email" autocomplete="email" required /></label>
                <label>How can we help?<textarea class="textarea" name="message" rows="5" required></textarea></label>
                <button class="btn btn-primary" type="submit">Send message</button>
            </form>
        </div>
        <div class="card">
            <h3>Support</h3>
            <p class="muted">hello@jobhunt.io</p>
            <p class="muted">+1 (415) 555-0130</p>
            <p class="muted">San Francisco, CA</p>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../components/public-footer.php'; ?>
