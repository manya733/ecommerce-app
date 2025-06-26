<?php
function getAllProducts($conn, $search = '', $status = '') {

    $query = "SELECT * FROM products WHERE is_deleted = 0";


    if (!empty($search)) {
        $search = mysqli_real_escape_string($conn, $search);
        $query .= " AND name LIKE '%$search%'";
    }


    if (!empty($status)) {
        $status = mysqli_real_escape_string($conn, $status);
        $query .= " AND status = '$status'";
    }


    $query .= " ORDER BY id DESC";

 
    return mysqli_query($conn, $query);
}
?>
