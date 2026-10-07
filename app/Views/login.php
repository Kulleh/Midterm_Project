<!DOCTYPE html>
<html>
<head>
    <title>POS Login</title>
</head>
<body>
    <h1>Point-of-Sale Login</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;">
            <?= session()->getFlashdata('error') ?>
        </p>
    <?php endif; ?>

    <form action="<?= base_url('login') ?>" method="post">
        <?= csrf_field() ?>
        <p>
            <label>Username:</label><br>
            <input type="text" name="username">
        </p>

        <p>
            <label>Password:</label><br>
            <input type="password" name="password">
        </p>

        <button type="submit">Log In</button>
    </form>
</body>
</html>