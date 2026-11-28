<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Job Offers</title>
    <link rel="stylesheet" href="assets/css/styles.css?v=auth-bg-1" />
</head>
<body>
    <div class="app-shell">
        <?php require __DIR__ . '/../components/company-sidebar.php'; ?>
        <main class="app-main">
            <?php require __DIR__ . '/../components/topbar.php'; ?>
            <div class="page-header">
                <div class="kicker">Offers</div>
                <h1>My Job Offers</h1>
            </div>
            <div class="card">
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>Title</th><th>Location</th><th>Applicants</th><th>Status</th><th>Manage</th></tr></thead>
                        <tbody>
                            <?php foreach ($jobs as $job): ?>
                                <tr>
                                    <td><?php echo h($job['title']); ?></td>
                                    <td><?php echo h($job['location']); ?></td>
                                    <td><?php echo (int) $job['applicant_count']; ?></td>
                                    <td><span class="status-pill status-<?php echo h($job['status']); ?>"><?php echo h(ucwords(str_replace('_', ' ', $job['status']))); ?></span></td>
                                    <td>
                                        <form method="post" action="index.php?page=company-jobs" class="inline-form">
                                            <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>" />
                                            <input type="hidden" name="job_id" value="<?php echo (int) $job['id']; ?>" />
                                            <select class="select" name="status" aria-label="Job status">
                                                <?php foreach (['active', 'paused', 'closed'] as $status): ?>
                                                    <option value="<?php echo $status; ?>" <?php echo $job['status'] === $status ? 'selected' : ''; ?>><?php echo ucfirst($status); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button class="btn btn-secondary" type="submit">Save</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if (!$jobs): ?><p class="muted" style="padding:16px;">You have no job offers yet. <a class="inline-link" href="index.php?page=company-job-create">Create your first offer</a>.</p><?php endif; ?>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/app.js?v=theme-top-2"></script>
</body>
</html>
