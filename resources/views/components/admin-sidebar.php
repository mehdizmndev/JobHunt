<aside class="sidebar">
    <a href="index.php?page=admin-dashboard" class="logo" style="padding: 10px 6px;">
        <span class="logo-mark">JH</span>
        <span>JobHunt</span>
    </a>
    <div class="sidebar-nav">
        <a class="nav-item active" href="index.php?page=admin-dashboard">Overview</a>
        <a class="nav-item" href="index.php?page=admin-users">All Users</a>
        <a class="nav-item" href="index.php?page=admin-categories">Categories</a>
        <a class="nav-item" href="index.php?page=home">View public site</a>
    </div>
    <div style="margin-top:auto; padding-top: 18px; border-top:1px solid var(--border);">
        <div class="company-badge"><strong><?php echo h($_SESSION['user']['name'] ?? 'System Admin'); ?></strong></div>
        <div class="help-text">Admin Workspace</div>
    </div>
</aside>
