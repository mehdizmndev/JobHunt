<div class="topbar">
    <div>
        <div class="kicker">Workspace</div>
        <strong><?php echo h($_SESSION['user']['name'] ?? 'JobHunt workspace'); ?></strong>
    </div>
    <div class="header-actions">
        <a class="btn btn-secondary" href="index.php?page=home">View site</a>
        <form method="post" action="index.php?page=logout">
            <input type="hidden" name="csrf_token" value="<?php echo h($_SESSION['csrf_token'] ?? ''); ?>" />
            <button class="btn btn-secondary" type="submit">Sign out</button>
        </form>
    </div>
</div>
