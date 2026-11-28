<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Candidates</title>
    <link rel="stylesheet" href="assets/css/styles.css?v=auth-bg-1" />
</head>
<body>
    <div class="app-shell">
        <?php require __DIR__ . '/../components/company-sidebar.php'; ?>
        <main class="app-main">
            <?php require __DIR__ . '/../components/topbar.php'; ?>
            <div class="page-header">
                <div class="kicker">Talent</div>
                <h1>Candidates</h1>
            </div>
            <div class="card">
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>Candidate</th><th>Role</th><th>Status</th><th>Update status</th></tr></thead>
                        <tbody>
                            <?php foreach ($candidates as $candidate): ?>
                                <tr>
                                    <td><?php echo h($candidate['name']); ?></td>
                                    <td><?php echo h($candidate['role']); ?></td>
                                    <td><?php echo h(ucwords(str_replace('_', ' ', $candidate['status']))); ?></td>
                                    <td>
                                        <form method="post" action="index.php?page=company-candidates" class="inline-form">
                                            <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>" />
                                            <input type="hidden" name="application_id" value="<?php echo (int) $candidate['id']; ?>" />
                                            <select class="select" name="status" aria-label="Application status">
                                                <?php foreach (['under_review', 'shortlisted', 'interview', 'accepted', 'rejected'] as $status): ?>
                                                    <option value="<?php echo $status; ?>" <?php echo $candidate['status'] === $status ? 'selected' : ''; ?>><?php echo h(ucwords(str_replace('_', ' ', $status))); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button class="btn btn-secondary" type="submit">Save</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if (!$candidates): ?><p class="muted" style="padding:16px;">No candidates have applied to your offers yet.</p><?php endif; ?>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/app.js?v=theme-top-2"></script>
</body>
</html>
