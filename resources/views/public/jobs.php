<?php require __DIR__ . '/../components/public-header.php'; ?>
<main class="section">
    <div class="container">
        <div class="page-header">
            <div class="kicker">Discover roles</div>
            <h1>Find the right opportunity</h1>
        </div>
        <div class="two-col">
            <div class="card">
                <div class="field-row">
                    <input class="input" placeholder="Job title, skill, or keyword" value="Product Designer" />
                    <input class="input" placeholder="Location" value="Remote" />
                    <button class="btn btn-primary" type="button">Search</button>
                </div>
                <div class="skill-list">
                    <span class="skill-tag">Remote</span>
                    <span class="skill-tag">Full-time</span>
                    <span class="skill-tag">Senior</span>
                </div>
                <div class="job-grid">
                    <?php foreach ($jobs as $job): ?>
                        <article class="job-card">
                            <div class="job-top">
                                <div class="company-badge"><span class="company-logo" style="width:38px;height:38px;">A</span><?php echo htmlspecialchars($job['company']); ?></div>
                                <span class="badge badge-primary"><?php echo htmlspecialchars($job['type']); ?></span>
                            </div>
                            <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                            <p class="muted"><?php echo htmlspecialchars($job['tagline']); ?></p>
                            <div class="job-meta">
                                <span><?php echo htmlspecialchars($job['location']); ?></span>
                                <span><?php echo htmlspecialchars($job['salary']); ?></span>
                            </div>
                            <div class="skill-list">
                                <?php foreach ($job['skills'] as $skill): ?>
                                    <span class="skill-tag"><?php echo htmlspecialchars($skill); ?></span>
                                <?php endforeach; ?>
                            </div>
                            <div class="card-footer">
                                <span class="muted"><?php echo htmlspecialchars($job['posted']); ?></span>
                                <a class="btn btn-primary" href="index.php?page=job-details">Apply</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
            <aside class="card">
                <h3>Filters</h3>
                <div class="form-stack">
                    <select class="select"><option>Job Category</option></select>
                    <select class="select"><option>Employment Type</option></select>
                    <select class="select"><option>Experience Level</option></select>
                    <select class="select"><option>Salary Range</option></select>
                    <select class="select"><option>Workplace Type</option></select>
                    <button class="btn btn-secondary" type="button">Reset filters</button>
                </div>
            </aside>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../components/public-footer.php'; ?>
