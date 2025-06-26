<?php
include 'config/db.php';

$name = $price = $stock = $status = "";
$image = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = trim($_POST['name']);
    $price  = $_POST['price'];
    $stock  = $_POST['stock'];
    $status = $_POST['status'];


    if (empty($name)) $errors[] = "Product name is required";
    if (!is_numeric($price)) $errors[] = "Valid price is required";
    if (!is_numeric($stock)) $errors[] = "Valid stock is required";


    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $uploadDir = "images/";
        $uploadPath = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            $image = $imageName;
        } else {
            $errors[] = "Failed to upload image.";
        }
    }


    if (empty($errors)) {
       
        $name   = mysqli_real_escape_string($conn, $name);
        $image  = mysqli_real_escape_string($conn, $image);
        $status = mysqli_real_escape_string($conn, $status);
        $price  = (float)$price;
        $stock  = (int)$stock;

        $query = "INSERT INTO products (name, image, price, stock, status,is_deleted)
                  VALUES ('$name', '$image', $price, $stock, '$status',0)";

        if (mysqli_query($conn, $query)) {
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Insert failed: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Add New Product</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Price (₹)</label>
            <input type="text" name="price" value="<?= htmlspecialchars($price) ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Stock</label>
            <input type="number" name="stock" value="<?= htmlspecialchars($stock) ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active" <?= ($status == 'active') ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= ($status == 'inactive') ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Product</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>