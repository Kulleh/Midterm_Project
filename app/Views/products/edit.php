<!DOCTYPE html>
<html>

<head>
    <title>Edit Product</title>
</head>

<body>
    <h1>Edit Product</h1>

    <form action="<?= base_url('products/update/' . $product['id']) ?>" method="post">
        <p>
            <label>Product Name:</label><br>
            <input type="text" name="name" value="<?= esc($product['name']) ?>" required>
        </p>

        <p>
            <label>Price:</label><br>
            <input type="number" name="price" step="0.01"
                value="<?= esc($product['price']) ?>" required>
        </p>

        <p>
            <label>Stock Quantity:</label><br>
            <input type="number" name="stock_quantity"
                value="<?= esc($product['stock_quantity']) ?>" required>
        </p>

        <button type="submit">Update Product</button>
    </form>

    <p><a href="<?= base_url('products') ?>">Back to Product List</a></p>
</body>

</html>