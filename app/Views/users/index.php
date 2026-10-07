<!DOCTYPE html>
<html>
<head>
    <title>Staff Account Management</title>
</head>
<body>
    <?= view('partials/navigation') ?>

    <h1>Staff Account Management</h1>
    <p><a href="<?= base_url('users/create') ?>">Add Staff Account</a></p>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Avatar</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($users === []): ?>
            <tr><td colspan="6">No staff accounts found.</td></tr>
        <?php endif; ?>

        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= esc($user['id']) ?></td>
                <td>
                    <?php if (! empty($user['avatar'])): ?>
                        <img src="<?= base_url('uploads/avatars/' . rawurlencode($user['avatar'])) ?>"
                             alt="Avatar for <?= esc($user['full_name']) ?>" width="50" height="50">
                    <?php else: ?>
                        No avatar
                    <?php endif; ?>
                </td>
                <td><?= esc($user['username']) ?></td>
                <td><?= esc($user['full_name']) ?></td>
                <td><?= esc($user['created_at']) ?></td>
                <td>
                    <a href="<?= base_url('users/edit/' . $user['id']) ?>">Edit</a> |
                    <a href="<?= base_url('users/delete/' . $user['id']) ?>"
                       onclick="return confirm('Delete this staff account?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
