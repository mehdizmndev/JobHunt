<?php require __DIR__ . '/../components/public-header.php'; ?>
<main>
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <div class="kicker">JobHunt</div>
                <h1>Find Your Next Opportunity. Build Your Future.</h1>
                <p class="lead">Discover opportunities, build your profile, and connect with companies looking for talent. AI resume tools are coming soon.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="index.php?page=jobs">Find Jobs</a>
                    <a class="btn btn-secondary" href="index.php?page=signin">Post a Job</a>
                </div>
                <div class="mini-stats">
                    <div><strong><?php echo number_format($metrics['candidates']); ?></strong><br>Candidate accounts</div>
                    <div><strong><?php echo number_format($metrics['companies']); ?></strong><br>Hiring teams</div>
                    <div><strong><?php echo number_format($metrics['jobs']); ?></strong><br>Active job offers</div>
                </div>
            </div>
            <div class="hero-preview">
                <div class="preview-window">
                    <div class="preview-header">
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                    </div>
                    <div class="search-panel">
                        <form class="field-row" method="get" action="index.php">
                            <input type="hidden" name="page" value="jobs" />
                            <input class="input" name="keyword" placeholder="Job title or skill" />
                            <input class="input" name="location" placeholder="Location" />
                            <button class="btn btn-primary" type="submit">Search</button>
                        </form>
                        <div class="search-results">
                            <?php foreach (array_slice($jobs, 0, 2) as $job): ?>
                                <a class="result-item" href="index.php?page=job-details&amp;id=<?php echo (int) $job['id']; ?>">
                                    <div><strong><?php echo h($job['title']); ?></strong><br><span class="muted"><?php echo h($job['company']); ?></span></div>
                                    <span class="badge badge-primary"><?php echo h($job['workplace']); ?></span>
                                </a>
                            <?php endforeach; ?>
                            <?php if (!$jobs): ?><div class="result-item"><span class="muted">No jobs posted yet. Be the first team to publish one.</span></div><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-header">
                <div>
                    <span class="kicker">How it works</span>
                    <h2>From discovery to hire—built for both candidates and teams</h2>
                </div>
            </div>
            <div class="grid-3">
                <div class="card feature-card">
                    <div class="icon-box">1</div>
                    <h3>Create your profile</h3>
                    <p class="muted">Build a clear candidate profile with your experience, skills, and preferences.</p>
                </div>
                <div class="card feature-card">
                    <div class="icon-box">2</div>
                    <h3>Discover opportunities</h3>
                    <p class="muted">Find relevant jobs, compare roles, and save the ones that match your goals.</p>
                </div>
                <div class="card feature-card">
                    <div class="icon-box">3</div>
                    <h3>Apply and track</h3>
                    <p class="muted">Apply with your CV and track each application from your dashboard.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section" style="background:#fff;">
        <div class="container">
            <div class="section-header">
                <div>
                    <span class="kicker">Core features</span>
                    <h2>Everything you need to find talent or land the right role</h2>
                </div>
            </div>
            <div class="grid-3">
                <div class="card feature-card">
                    <div class="icon-box">GO</div>
                    <h3>Job Search</h3>
                    <p class="muted">Search by title, category, location, employment type, and workplace.</p>
                </div>
                <div class="card feature-card">
                    <div class="icon-box">CV</div>
                    <h3>AI CV Optimizer <span class="badge badge-purple">Coming soon</span></h3>
                    <p class="muted">Personalized resume feedback will be available soon.</p>
                </div>
                <div class="card feature-card">
                    <div class="icon-box">✓</div>
                    <h3>Easy Apply</h3>
                    <p class="muted">Apply in minutes using a prepared resume, cover letter, and job-specific details.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-header">
                <div>
                    <span class="kicker">Coming soon</span>
                    <h2>AI tools are in development</h2>
                </div>
            </div>
            <div class="grid-2">
                <div class="card">
                    <span class="badge badge-purple">Candidate Tools</span>
                    <h3 style="margin-top:18px;">CV optimization and role matching</h3>
                    <p class="muted">Candidate AI features are being prepared and will be announced when available.</p>
                </div>
                <div class="card">
                    <span class="badge badge-primary">Company Tools</span>
                    <h3 style="margin-top:18px;">AI candidate screening</h3>
                    <p class="muted">Recruiter AI tools are being prepared; hiring decisions remain with people.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section" style="background:#fff;">
        <div class="container">
            <div class="section-header">
                <div>
                    <span class="kicker">Featured jobs</span>
                    <h2>Opportunities worth exploring</h2>
                </div>
                <a class="inline-link" href="index.php?page=jobs">View all jobs</a>
            </div>
            <div class="job-grid">
                <?php foreach (array_slice($jobs, 0, 3) as $job): ?>
                    <article class="job-card">
                        <div class="job-top">
                            <div class="company-badge"><span class="company-logo" style="width:42px;height:42px;"><?php echo h(strtoupper(substr($job['company'], 0, 1))); ?></span><?php echo h($job['company']); ?></div>
                            <span class="badge badge-primary"><?php echo h($job['type']); ?></span>
                        </div>
                        <h3><?php echo h($job['title']); ?></h3>
                        <div class="job-meta">
                            <span><?php echo h($job['location']); ?></span>
                            <span>•</span>
                            <span><?php echo h($job['salary']); ?></span>
                        </div>
                        <div class="skill-list">
                            <?php foreach (array_slice($job['skills'], 0, 3) as $skill): ?>
                                <span class="skill-tag"><?php echo h($skill); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="card-footer">
                            <span class="muted"><?php echo h($job['posted']); ?></span>
                            <a class="btn btn-primary" href="index.php?page=job-details&amp;id=<?php echo (int) $job['id']; ?>">View Job</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-header">
                <div>
                    <span class="kicker">Featured companies</span>
                    <h2>Trusted by hiring teams and growing talent</h2>
                </div>
            </div>
            <div class="grid-4">
                <?php foreach ($companies as $company): ?>
                    <div class="card company-card">
                        <div class="company-logo"><?php echo h(strtoupper(substr($company['name'], 0, 2))); ?></div>
                        <h3><?php echo h($company['name']); ?></h3>
                        <p class="muted"><?php echo h($company['industry']); ?></p>
                        <span class="badge badge-secondary" style="background:var(--surface-muted); color:var(--text-primary); margin-top:6px;"><?php echo h($company['location']); ?></span>
                        <p><a class="inline-link" href="index.php?page=company-profile&amp;id=<?php echo (int) $company['id']; ?>">View company</a></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="cta-box">
                <div>
                    <div class="kicker" style="color:#D9EAFE;">Start today</div>
                    <h2 style="color:white; margin:0;">Your Next Opportunity Starts Here.</h2>
                </div>
                <div class="hero-actions" style="margin:0;">
                    <a class="btn btn-primary" href="index.php?page=jobs">Find Jobs</a>
                    <a class="btn btn-secondary" href="index.php?page=signin">Join as Employer</a>
                </div>
            </div>
        </div>
    </section>
</main>
<?php require __DIR__ . '/../components/public-footer.php'; ?>
