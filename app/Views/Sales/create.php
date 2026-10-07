<!DOCTYPE html>
<html>
<head>
    <title>Record Sale</title>
</head>
<body>
    <?= view('partials/navigation') ?>

    <h1>Record Sale</h1>

    <?php if ($products === []): ?>
        <p>No products are currently in stock.</p>
    <?php else: ?>
        <form action="<?= base_url('sales/store') ?>" method="post">
            <?= csrf_field() ?>

            <p>
                <label for="product_id">Product:</label><br>
                <select id="product_id" name="product_id" required>
                    <option value="">Choose a product</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= esc($product['id']) ?>">
                            <?= esc($product['name']) ?>
                            — ₱<?= number_format((float) $product['price'], 2) ?>
                            (stock: <?= esc($product['stock_quantity']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>

            <p>
                <label for="customer_id">Customer (optional):</label><br>
                <select id="customer_id" name="customer_id">
                    <option value="">Walk-in customer</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?= esc($customer['id']) ?>">
                            <?= esc($customer['full_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>

            <p>
                <label for="quantity">Quantity:</label><br>
                <input id="quantity" name="quantity" type="number" min="1" step="1" required>
            </p>

            <button type="submit">Record Sale</button>
        </form>
    <?php endif; ?>
</body>
</html>