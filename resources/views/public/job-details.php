<?php require __DIR__ . '/../components/public-header.php'; ?>
<main class="section">
    <div class="container two-col">
        <article class="card">
            <div class="company-badge"><span class="company-logo" style="width:48px;height:48px;">N</span><strong><?php echo h($job['company']); ?></strong></div>
            <h1 style="margin-top:18px; margin-bottom:10px; font-size:2rem; "><?php echo h($job['title']); ?></h1>
            <div class="job-meta">
                <span><?php echo h($job['location']); ?></span>
                <span>•</span>
                <span><?php echo h($job['type']); ?></span>
                <span>•</span>
                <span><?php echo h($job['salary']); ?></span>
            </div>
            <div class="hero-actions" style="margin: 20px 0;">
                <?php if (($user['role'] ?? null) === 'candidate'): ?>
                    <form method="post" action="index.php?page=job-details&amp;id=<?php echo (int) $job['id']; ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>" />
                        <input type="hidden" name="action" value="apply" />
                        <input type="hidden" name="job_id" value="<?php echo (int) $job['id']; ?>" />
                        <label>Attach a resume
                            <select class="select" name="resume_id">
                                <option value="">No resume attached</option>
                                <?php foreach ($resumes as $resume): ?>
                                    <option value="<?php echo (int) $resume['id']; ?>"><?php echo h($resume['file_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <label>Cover letter<textarea class="textarea" name="cover_letter" rows="4" placeholder="Optional note for the hiring team"></textarea></label>
                        <button class="btn btn-primary" type="submit">Apply now</button>
                    </form>
                    <form method="post" action="index.php?page=job-details&amp;id=<?php echo (int) $job['id']; ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>" />
                        <input type="hidden" name="action" value="save-job" />
                        <input type="hidden" name="job_id" value="<?php echo (int) $job['id']; ?>" />
                        <button class="btn btn-secondary" type="submit">Save job</button>
                    </form>
                <?php else: ?>
                    <a class="btn btn-primary" href="index.php?page=signin">Sign in to apply</a>
                <?php endif; ?>
            </div>
            <div>
                <h3>Overview</h3>
                <p class="muted"><?php echo h($job['tagline']); ?></p>
                <h3>Responsibilities</h3>
                <p class="muted"><?php echo nl2br(h($job['responsibilities'] ?: 'The hiring team has not added responsibilities yet.')); ?></p>
                <h3>Qualifications</h3>
                <p class="muted"><?php echo nl2br(h($job['requirements'] ?: 'The hiring team has not added requirements yet.')); ?></p>
                <?php if ($job['benefits']): ?><h3>Benefits</h3><p class="muted"><?php echo nl2br(h($job['benefits'])); ?></p><?php endif; ?>
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
            <?php if (($user['role'] ?? null) !== 'candidate'): ?>
                <a class="btn btn-primary" href="index.php?page=signin" style="margin-top:16px; width:100%;">Sign in to apply</a>
            <?php endif; ?>
        </aside>
    </div>
</main>
<?php require __DIR__ . '/../components/public-footer.php'; ?>
