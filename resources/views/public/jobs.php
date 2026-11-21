<?php require __DIR__ . '/../components/public-header.php'; ?>
<main class="section">
    <div class="container">
        <div class="page-header">
            <div class="kicker">Discover roles</div>
            <h1>Find the right opportunity</h1>
        </div>
        <form class="card field-row" method="get" action="index.php">
            <input type="hidden" name="page" value="jobs" />
            <input class="input" name="keyword" placeholder="Job title, skill, or keyword" value="<?php echo htmlspecialchars($filters['keyword'] ?? ''); ?>" />
            <input class="input" name="location" placeholder="Location" value="<?php echo htmlspecialchars($filters['location'] ?? ''); ?>" />
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
        <div class="two-col" style="margin-top:20px;">
            <div class="card">
                <div class="job-grid job-grid-results">
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
                                <a class="btn btn-primary" href="index.php?page=job-details&amp;id=<?php echo (int) $job['id']; ?>">View job</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                    <?php if (!$jobs): ?>
                        <div class="card empty-state"><h3>No matching jobs yet</h3><p class="muted">Try another keyword or location, or clear your filters.</p></div>
                    <?php endif; ?>
                </div>
            </div>
            <aside class="card">
                <h3>Filters</h3>
                <form class="form-stack" method="get" action="index.php">
                    <input type="hidden" name="page" value="jobs" />
                    <input type="hidden" name="keyword" value="<?php echo htmlspecialchars($filters['keyword'] ?? ''); ?>" />
                    <input type="hidden" name="location" value="<?php echo htmlspecialchars($filters['location'] ?? ''); ?>" />
                    <label>Employment type
                        <select class="select" name="employment_type">
                            <option value="">All employment types</option>
                            <?php foreach (['Full-time', 'Part-time', 'Contract', 'Internship'] as $type): ?>
                                <option value="<?php echo htmlspecialchars($type); ?>" <?php echo ($filters['employment_type'] ?? '') === $type ? 'selected' : ''; ?>><?php echo htmlspecialchars($type); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label>Workplace
                        <select class="select" name="workplace_type">
                            <option value="">Any workplace</option>
                            <?php foreach (['Remote', 'Hybrid', 'On-site'] as $type): ?>
                                <option value="<?php echo htmlspecialchars($type); ?>" <?php echo ($filters['workplace_type'] ?? '') === $type ? 'selected' : ''; ?>><?php echo htmlspecialchars($type); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <button class="btn btn-primary" type="submit">Apply filters</button>
                    <a class="btn btn-secondary" href="index.php?page=jobs">Reset filters</a>
                </form>
            </aside>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../components/public-footer.php'; ?>
