<!DOCTYPE html>
<html>

<head>
    <title>Customer Management</title>
</head>

<body>
    <?= view('partials/navigation') ?>

    <h1>Customer Management</h1>
    <p><a href="<?= base_url('customers/create') ?>">Add Customer</a></p>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($customers === []): ?>
                <tr>
                    <td colspan="6">No customers found.</td>
                </tr>
            <?php endif; ?>

            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?= esc($customer['id']) ?></td>
                    <td><?= esc($customer['full_name']) ?></td>
                    <td><?= esc($customer['email']) ?></td>
                    <td><?= esc($customer['phone'] ?? '') ?></td>
                    <td><?= esc($customer['created_at']) ?></td>
                    <td>
                        <a href="<?= base_url('customers/edit/' . $customer['id']) ?>">Edit</a> |
                        <a href="<?= base_url('customers/delete/' . $customer['id']) ?>"
                            onclick="return confirm('Delete this customer?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>