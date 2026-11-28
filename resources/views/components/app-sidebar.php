<aside class="sidebar">
    <a href="index.php?page=candidate-dashboard" class="logo" style="padding: 10px 6px;">
        <span class="logo-mark">JH</span>
        <span>JobHunt</span>
    </a>
    <div class="sidebar-nav">
        <a class="nav-item active" href="index.php?page=candidate-dashboard">Overview</a>
        <a class="nav-item" href="index.php?page=candidate-jobs">Find Jobs</a>
        <a class="nav-item" href="index.php?page=candidate-saved">Saved Jobs</a>
        <a class="nav-item" href="index.php?page=candidate-applications">My Applications</a>
        <a class="nav-item" href="index.php?page=candidate-profile">My Profile</a>
        <a class="nav-item" href="index.php?page=candidate-resumes">My Resumes</a>
    </div>
    <div style="margin-top:auto; padding-top: 18px; border-top:1px solid var(--border);">
        <div class="company-badge"><strong><?php echo h($_SESSION['user']['name'] ?? 'Candidate'); ?></strong></div>
        <div class="help-text">Candidate Workspace</div>
    </div>
</aside>
