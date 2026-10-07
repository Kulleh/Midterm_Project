<!DOCTYPE html>
<html>

<head>
    <title>Add Customer</title>
</head>

<body>
    <?= view('partials/navigation') ?>

    <h1>Add Customer</h1>

    <?php if (isset($validation)): ?>
        <?= $validation->listErrors() ?>
    <?php endif; ?>

    <form action="<?= base_url('customers/store') ?>" method="post">
        <?= csrf_field() ?>
        <p>
            <label for="full_name">Full Name:</label><br>
            <input id="full_name" type="text" name="full_name"
                value="<?= esc($customer['full_name'] ?? '') ?>" maxlength="100" required>
        </p>
        <p>
            <label for="email">Email:</label><br>
            <input id="email" type="email" name="email"
                value="<?= esc($customer['email'] ?? '') ?>" maxlength="100" required>
        </p>
        <p>
            <label for="phone">Phone:</label><br>
            <input id="phone" type="text" name="phone"
                value="<?= esc($customer['phone'] ?? '') ?>" maxlength="20">
        </p>
        <button type="submit">Save Customer</button>
    </form>

    <p><a href="<?= base_url('customers') ?>">Back to Customer List</a></p>
</body>

</html>