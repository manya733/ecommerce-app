<?php
include 'config/db.php';

$id = $_GET['id'] ?? 0;
$id = (int)$id;

if ($id > 0) {
    $query = "UPDATE products SET is_deleted = 1 WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Delete failed: " . mysqli_error($conn);
    }
} else {
    echo "Invalid product ID.";
}
?>
