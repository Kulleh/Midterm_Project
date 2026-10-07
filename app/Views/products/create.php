<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>
    <h1>Add Product</h1>

    <form action="<?= base_url('products/store') ?>" method="post">
        <p>
            <label>Product Name:</label><br>
            <input type="text" name="name" required>
        </p>

        <p>
            <label>Price:</label><br>
            <input type="number" name="price" step="0.01" required>
        </p>

        <p>
            <label>Stock Quantity:</label><br>
            <input type="number" name="stock_quantity" required>
        </p>

        <button type="submit">Save Product</button>
    </form>

    <p><a href="<?= base_url('products') ?>">Back to Product List</a></p>
</body>
</html>