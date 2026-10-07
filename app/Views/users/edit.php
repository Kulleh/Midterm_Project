<!DOCTYPE html>
<html>
<head>
    <title>Edit Staff Account</title>
</head>
<body>
    <?= view('partials/navigation') ?>

    <h1>Edit Staff Account</h1>

    <?php if (! empty($error)): ?>
        <p style="color: red;"><?= esc($error) ?></p>
    <?php endif; ?>

    <?php if (isset($validation)): ?>
        <?= $validation->listErrors() ?>
    <?php endif; ?>

    <form action="<?= base_url('users/update/' . $user['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <p>
            <label for="username">Username:</label><br>
            <input id="username" type="text" name="username"
                   value="<?= esc($user['username'] ?? '') ?>" maxlength="50" required>
        </p>
        <p>
            <label for="full_name">Full Name:</label><br>
            <input id="full_name" type="text" name="full_name"
                   value="<?= esc($user['full_name'] ?? '') ?>" maxlength="100" required>
        </p>
        <p>
            <label for="password">New Password (leave blank to keep current password):</label><br>
            <input id="password" type="password" name="password" minlength="8">
        </p>
        <p>
            <label for="avatar">Replace Avatar (JPG, PNG, or WebP, up to 2 MB):</label><br>
            <input id="avatar" type="file" name="avatar" accept="image/jpeg,image/png,image/webp">
        </p>
        <button type="submit">Update Staff Account</button>
    </form>

    <p><a href="<?= base_url('users') ?>">Back to Staff Account List</a></p>
</body>
</html>
