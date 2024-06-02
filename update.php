<?php
session_start();
require('db.php');

if (isset($_POST['save_data'])) {
    $categoryId = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    
    $query = "UPDATE categories SET category_name='$name', description='$description' WHERE id='$categoryId'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        echo '<script> alert("Data Updated"); </script>';
        header('Location: index.php');
        exit();
    } else {
        echo '<script> alert("Data not Updated"); </script>';
    }
}
?>
