<?php
include 'config/db.php';

$id = $_GET['id'] ?? 0;
$id = (int)$id;

if ($id > 0) {
  
    $result = mysqli_query($conn, "SELECT status FROM products WHERE id = $id AND is_deleted = 0");

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $currentStatus = $row['status'];

     
        $newStatus = ($currentStatus === 'active') ? 'inactive' : 'active';

    
        $update = "UPDATE products SET status = '$newStatus' WHERE id = $id";
        if (mysqli_query($conn, $update)) {
            header("Location: index.php");
            exit;
        } else {
            echo "Failed to update status: " . mysqli_error($conn);
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid ID.";
}
?>
