<aside class="sidebar">
    <a href="index.php?page=company-dashboard" class="logo" style="padding: 10px 6px;">
        <span class="logo-mark">JH</span>
        <span>JobHunt</span>
    </a>
    <div class="sidebar-nav">
        <a class="nav-item active" href="index.php?page=company-dashboard">Dashboard</a>
        <a class="nav-item" href="index.php?page=company-jobs">My Job Offers</a>
        <a class="nav-item" href="index.php?page=company-candidates">Candidates</a>
        <a class="nav-item" href="index.php?page=company-profile-edit">Company Profile</a>
        <a class="nav-item" href="index.php?page=company-job-create">Create Offer</a>
    </div>
    <div style="margin-top:auto; padding-top: 18px; border-top:1px solid var(--border);">
        <div class="company-badge"><strong><?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'Company'); ?></strong></div>
        <div class="help-text">Company Workspace</div>
    </div>
</aside>
