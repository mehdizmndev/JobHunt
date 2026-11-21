<?php require __DIR__ . '/../components/public-header.php'; ?>
<main>
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <div class="kicker">JobHunt</div>
                <h1>Find Your Next Opportunity. Build Your Future.</h1>
                <p class="lead">Discover opportunities, improve your resume with AI, and connect with companies looking for talent.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="index.php?page=jobs">Find Jobs</a>
                    <a class="btn btn-secondary" href="index.php?page=signin">Post a Job</a>
                </div>
                <div class="mini-stats">
                    <div><strong>120k+</strong><br>Active job seekers</div>
                    <div><strong>15k+</strong><br>Hiring teams</div>
                    <div><strong>92%</strong><br>Resume score uplift</div>
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
                        <div class="field-row">
                            <input class="input" placeholder="Job title or skill" value="Product Designer" />
                            <input class="input" placeholder="Location" value="Remote" />
                            <button class="btn btn-primary" type="button">Search</button>
                        </div>
                        <div class="search-results">
                            <div class="result-item">
                                <div>
                                    <strong>Senior Product Designer</strong><br>
                                    <span class="muted">Northstar Labs</span>
                                </div>
                                <span class="badge badge-primary">Remote</span>
                            </div>
                            <div class="result-item">
                                <div>
                                    <strong>Frontend Engineer</strong><br>
                                    <span class="muted">Asteria Cloud</span>
                                </div>
                                <span class="badge badge-success">Hybrid</span>
                            </div>
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
                    <p class="muted">Build a strong employer-ready profile with experience, skills, and preferences.</p>
                </div>
                <div class="card feature-card">
                    <div class="icon-box">2</div>
                    <h3>Discover opportunities</h3>
                    <p class="muted">Find relevant jobs, compare roles, and save the ones that match your goals.</p>
                </div>
                <div class="card feature-card">
                    <div class="icon-box">3</div>
                    <h3>Apply and track</h3>
                    <p class="muted">Use Easy Apply, optimize your CV, and monitor every stage with confidence.</p>
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
                    <div class="icon-box">AI</div>
                    <h3>Smart Job Search</h3>
                    <p class="muted">Search by role, skills, location, salary, and match preferences.</p>
                </div>
                <div class="card feature-card">
                    <div class="icon-box">CV</div>
                    <h3>AI CV Optimizer</h3>
                    <p class="muted">Improve keyword alignment, clarity, and recruiter-readiness instantly.</p>
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
                    <span class="kicker">AI at work</span>
                    <h2>Human decisions supported by transparent AI insights</h2>
                </div>
            </div>
            <div class="grid-2" style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                <div class="card">
                    <span class="badge badge-purple">Candidate Tools</span>
                    <h3 style="margin-top:18px;">CV optimization and role matching</h3>
                    <p class="muted">Get guidance on skills, resume structure, and how a profile aligns to a given role without losing human control.</p>
                </div>
                <div class="card">
                    <span class="badge badge-primary">Company Tools</span>
                    <h3 style="margin-top:18px;">AI CV screening and shortlisting</h3>
                    <p class="muted">Review candidate fit using job-related criteria, not automated decisions alone, with recruiter oversight.</p>
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
                            <div class="company-badge"><span class="company-logo" style="width:42px;height:42px;">N</span><?php echo htmlspecialchars($job['company']); ?></div>
                            <span class="badge badge-primary"><?php echo htmlspecialchars($job['type']); ?></span>
                        </div>
                        <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                        <div class="job-meta">
                            <span><?php echo htmlspecialchars($job['location']); ?></span>
                            <span>•</span>
                            <span><?php echo htmlspecialchars($job['salary']); ?></span>
                        </div>
                        <div class="skill-list">
                            <?php foreach (array_slice($job['skills'], 0, 3) as $skill): ?>
                                <span class="skill-tag"><?php echo htmlspecialchars($skill); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="card-footer">
                            <span class="muted"><?php echo htmlspecialchars($job['posted']); ?></span>
                            <a class="btn btn-primary" href="index.php?page=job-details">View Job</a>
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
                        <div class="company-logo"><?php echo strtoupper(substr($company['name'], 0, 2)); ?></div>
                        <h3><?php echo htmlspecialchars($company['name']); ?></h3>
                        <p class="muted"><?php echo htmlspecialchars($company['industry']); ?></p>
                        <span class="badge badge-secondary" style="background:var(--surface-muted); color:var(--text-primary); margin-top:6px;"><?php echo htmlspecialchars($company['location']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section" style="background:#fff;">
        <div class="container">
            <div class="section-header">
                <div>
                    <span class="kicker">Testimonials</span>
                    <h2>Job seekers and companies love the experience</h2>
                </div>
            </div>
            <div class="grid-3">
                <div class="card quote-card">“The guided workflow made it easy to move from profile building to interview requests.”</div>
                <div class="card quote-card">“Our hiring team cut review time dramatically while keeping the final decision in human hands.”</div>
                <div class="card quote-card">“The AI CV feedback helped me tailor applications without losing my voice.”</div>
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
