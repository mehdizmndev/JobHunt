<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Create Job Offer</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
    <div class="app-shell">
        <?php require __DIR__ . '/../components/company-sidebar.php'; ?>
        <main class="app-main">
            <?php require __DIR__ . '/../components/topbar.php'; ?>
            <div class="page-header">
                <div class="kicker">Recruitment</div>
                <h1>Create Job Offer</h1>
            </div>
            <form class="card form-stack" method="post" action="index.php?page=company-job-create">
                <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>" />
                <label>Job title<input class="input" name="title" placeholder="e.g. Senior Product Designer" required /></label>
                <div class="form-row">
                    <label>Category<select class="select" name="category" required>
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo h($category['name']); ?>"><?php echo h($category['name']); ?></option>
                        <?php endforeach; ?>
                    </select></label>
                    <label>Location<input class="input" name="location" placeholder="Remote or city" required /></label>
                </div>
                <div class="form-row">
                    <label>Employment type<select class="select" name="employment_type"><option>Full-time</option><option>Part-time</option><option>Contract</option><option>Internship</option></select></label>
                    <label>Workplace<select class="select" name="workplace_type"><option>Remote</option><option>Hybrid</option><option>On-site</option></select></label>
                </div>
                <div class="form-row">
                    <label>Experience level<select class="select" name="experience_level"><option>Entry</option><option>Mid-level</option><option>Senior</option><option>Lead</option></select></label>
                    <div class="form-row">
                        <label>Salary min<input class="input" type="number" min="0" name="salary_min" placeholder="60000" /></label>
                        <label>Salary max<input class="input" type="number" min="0" name="salary_max" placeholder="90000" /></label>
                    </div>
                </div>
                <label>Job description<textarea class="textarea" name="summary" rows="5" placeholder="Describe the role and what makes it meaningful." required></textarea></label>
                <label>Responsibilities<textarea class="textarea" name="responsibilities" rows="4" placeholder="List the key responsibilities"></textarea></label>
                <label>Requirements<textarea class="textarea" name="requirements" rows="4" placeholder="List the required qualifications"></textarea></label>
                <button class="btn btn-primary" type="submit">Publish job</button>
            </form>
        </main>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
