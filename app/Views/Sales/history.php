<!DOCTYPE html>
<html>

<head>
    <title>Sales History</title>
</head>

<body>
    <?= view('partials/navigation') ?>

    <h1>Sales History</h1>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Sale ID</th>
                <th>Product</th>
                <th>Customer</th>
                <th>Staff</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($sales === []): ?>
                <tr>
                    <td colspan="7">No sales recorded yet.</td>
                </tr>
            <?php endif; ?>

            <?php foreach ($sales as $sale): ?>
                <tr>
                    <td><?= esc($sale['id']) ?></td>
                    <td><?= esc($sale['product_name'] ?: 'Product #' . $sale['product_id']) ?></td>
                    <td>
                        <?php if ($sale['customer_id'] === null): ?>
                            Walk-in customer
                        <?php else: ?>
                            <?= esc($sale['customer_name'] ?: 'Customer #' . $sale['customer_id']) ?>
                        <?php endif; ?>
                    </td>
                    <td><?= esc($sale['staff_name'] ?: 'Staff #' . $sale['sold_by']) ?></td>
                    <td><?= esc($sale['quantity']) ?></td>
                    <td>₱<?= number_format((float) $sale['total_price'], 2) ?></td>
                    <td><?= esc($sale['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>