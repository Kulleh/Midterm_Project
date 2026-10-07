<?php

use App\Controllers\Customers;
?>
<!DOCTYPE html>
<html>

<head>
    <title>Product Management</title>
</head>

<body>
    <?= view('partials/navigation') ?>
    <h1>Product Management</h1>

    <p>
        <a href="<?= base_url('products/create') ?>">Add Product</a>
    </p>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Stock Quantity</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= esc($product['id']) ?></td>
                <td><?= esc($product['name']) ?></td>
                <td>₱<?= number_format($product['price'], 2) ?></td>
                <td><?= esc($product['stock_quantity']) ?></td>
                <td>
                    <a href="<?= base_url('products/edit/' . $product['id']) ?>">Edit</a> |
                    <a href="<?= base_url('products/delete/' . $product['id']) ?>"
                        onclick="return confirm('Delete this product?')">
                        Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>