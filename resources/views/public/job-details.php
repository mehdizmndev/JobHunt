<?php require __DIR__ . '/../components/public-header.php'; ?>
<main class="section">
    <div class="container two-col">
        <article class="card">
            <div class="company-badge"><span class="company-logo" style="width:48px;height:48px;">N</span><strong><?php echo htmlspecialchars($job['company']); ?></strong></div>
            <h1 style="margin-top:18px; margin-bottom:10px; font-size:2rem; "><?php echo htmlspecialchars($job['title']); ?></h1>
            <div class="job-meta">
                <span><?php echo htmlspecialchars($job['location']); ?></span>
                <span>•</span>
                <span><?php echo htmlspecialchars($job['type']); ?></span>
                <span>•</span>
                <span><?php echo htmlspecialchars($job['salary']); ?></span>
            </div>
            <div class="hero-actions" style="margin: 20px 0;">
                <a class="btn btn-primary" href="index.php?page=signin">Easy Apply</a>
                <a class="btn btn-secondary" href="index.php?page=signin">Save Job</a>
            </div>
            <div>
                <h3>Overview</h3>
                <p class="muted"><?php echo htmlspecialchars($job['tagline']); ?></p>
                <h3>Responsibilities</h3>
                <ul>
                    <li>Lead UX concepts from discovery through delivery.</li>
                    <li>Partner closely with engineering and product leaders.</li>
                    <li>Translate customer needs into clear design decisions.</li>
                </ul>
                <h3>Qualifications</h3>
                <ul>
                    <li>5+ years in product design or related field.</li>
                    <li>Experience with hiring, SaaS, and design systems.</li>
                    <li>Strong communication and stakeholder management.</li>
                </ul>
            </div>
        </article>
        <aside class="card">
            <h3>Company</h3>
            <p class="muted">Northstar Labs builds modern recruiting products for growing companies.</p>
            <div class="list-stack">
                <div><strong>Location:</strong> Remote · US</div>
                <div><strong>Employment:</strong> Full-time</div>
                <div><strong>Experience:</strong> Senior</div>
                <div><strong>Deadline:</strong> 12 days</div>
            </div>
            <a class="btn btn-primary" href="index.php?page=signin" style="margin-top:16px; width:100%;">Apply now</a>
        </aside>
    </div>
</main>
<?php require __DIR__ . '/../components/public-footer.php'; ?>
