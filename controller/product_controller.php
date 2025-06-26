<?php
include('config/db.php');
include('models/Product.php');


$products=getAllProducts($conn,$search,$status);

?>