<?php
$conn=mysqli_connect('localhost','root','mysql','ecommerce');
if(!$conn){
    die('Database connection failed:'. mysqli_connect_error());
}

?>