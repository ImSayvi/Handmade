<?php
session_start();
require('db.php');

if (isset($_POST['addNewProduct'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category_id = $_POST['category'];

    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];


    $query = "SELECT category_name FROM categories WHERE id = $category_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $categoryName = $row['category_name'];

    // Ścieżka do folderu kategorii
    $pathToThisCategory = 'images/category/' . $categoryName;
    // Ścieżka do zapisu pliku
    $fullFilePath = $pathToThisCategory . '/' . $file_name;


    if (move_uploaded_file($file_tmp, $fullFilePath)) {
       
        $sqlQueryProduct = "INSERT INTO handicrafts (name, description, id_category, file) VALUES ('$name', '$description', '$category_id', '$file_name')";
        $conn->query($sqlQueryProduct);

       
        header('Location: categories.php?id_category=' . $category_id);
    } 
}
?>
