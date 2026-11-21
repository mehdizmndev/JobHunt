<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · Candidates</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
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
                        <thead><tr><th>Candidate</th><th>Role</th><th>AI Match</th><th>Status</th></tr></thead>
                        <tbody>
                            <tr><td>Alex Morgan</td><td>Senior Product Designer</td><td>92%</td><td><span class="status-pill status-shortlisted">Shortlisted</span></td></tr>
                            <tr><td>Priya Nair</td><td>Frontend Engineer</td><td>88%</td><td><span class="status-pill status-under-review">Under Review</span></td></tr>
                            <tr><td>Lucas Martin</td><td>Product Designer</td><td>84%</td><td><span class="status-pill status-interview">Interview</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
