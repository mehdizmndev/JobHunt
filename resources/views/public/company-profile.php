<?php require __DIR__ . '/../components/public-header.php'; ?>
<main class="section">
    <div class="container two-col">
        <div class="card">
            <div class="company-badge"><span class="company-logo" style="width:52px;height:52px;">N</span><strong><?php echo htmlspecialchars($company['name']); ?></strong></div>
            <h1 style="margin-top:18px;">About Northstar Labs</h1>
            <p class="muted">We help teams grow by building software that simplifies hiring, coaching, and people operations.</p>
            <div class="list-stack">
                <div><strong>Industry:</strong> <?php echo htmlspecialchars($company['industry']); ?></div>
                <div><strong>Location:</strong> <?php echo htmlspecialchars($company['location']); ?></div>
                <div><strong>Employees:</strong> <?php echo htmlspecialchars($company['size']); ?></div>
            </div>
        </div>
        <div class="card">
            <h3>Open roles</h3>
            <div class="list-stack">
                <div>Senior Product Designer</div>
                <div>Frontend Engineer</div>
                <div>Recruitment Operations Lead</div>
            </div>
            <a class="btn btn-primary" style="margin-top:18px;" href="index.php?page=jobs">See jobs</a>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../components/public-footer.php'; ?>
