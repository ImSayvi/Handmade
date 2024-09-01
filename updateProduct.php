<?php
session_start();
require('db.php');

if (isset($_POST['id'])) {
    
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $tags = $_POST['tags']; 
    $category_id = $_POST['category'];

    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];

        $query = "SELECT category_name FROM categories WHERE id = $category_id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $categoryName = $row['category_name'];

        $pathToThisCategory = 'images/category/' . $categoryName;
        $fullFilePath = $pathToThisCategory . '/' . $file_name;

        if (move_uploaded_file($file_tmp, $fullFilePath)) {
            $sqlQueryProduct = "UPDATE handicrafts SET name = '$name', description = '$description', tags = '$tags', id_category = '$category_id', file = '$file_name' WHERE id = '$id'";
            $conn->query($sqlQueryProduct);
        }
    } else {
        $sqlQueryProduct = "UPDATE handicrafts SET name = '$name', description = '$description', tags = '$tags', id_category = '$category_id' WHERE id = '$id'";
        $conn->query($sqlQueryProduct);
    }
    header('Location: categories.php?id_category=' . $category_id);
}
?>
