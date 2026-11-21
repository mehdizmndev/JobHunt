<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobHunt · All Users</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
    <div class="app-shell">
        <?php require __DIR__ . '/../components/admin-sidebar.php'; ?>
        <main class="app-main">
            <?php require __DIR__ . '/../components/topbar.php'; ?>
            <div class="page-header">
                <div class="kicker">Users</div>
                <h1>All Users</h1>
            </div>
            <div class="card">
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>User</th><th>Email</th><th>Type</th><th>Status</th><th>Manage</th></tr></thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['type']); ?></td>
                                    <td><span class="status-pill"><?php echo htmlspecialchars($user['status']); ?></span></td>
                                    <td>
                                        <?php if ((int) $user['id'] !== (int) $_SESSION['user']['id']): ?>
                                            <form method="post" action="index.php?page=admin-users" class="inline-form">
                                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>" />
                                                <input type="hidden" name="user_id" value="<?php echo (int) $user['id']; ?>" />
                                                <input type="hidden" name="status" value="<?php echo $user['status'] === 'suspended' ? 'active' : 'suspended'; ?>" />
                                                <button class="btn btn-secondary" type="submit"><?php echo $user['status'] === 'suspended' ? 'Reactivate' : 'Suspend'; ?></button>
                                            </form>
                                        <?php else: ?>Current account<?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/app.js"></script>
</body>
</html>
