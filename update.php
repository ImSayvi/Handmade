<?php
session_start();
require('db.php');

if (isset($_POST['save_data'])) {
    $categoryId = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $file_name = null;
    if (isset($_FILES['file']) && $_FILES['file']['size'] > 0) {
        $errors = array();
        $file_name = $_FILES['file']['name'];
        $file_size = $_FILES['file']['size'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_type = $_FILES['file']['type'];

        if (empty($errors) == true) {
            list($width, $height) = getimagesize($file_tmp);
            $newWidth = 360;
            $newHeight = 240;

            $imageResized = imagecreatetruecolor($newWidth, $newHeight);
            $imageTmp = imagecreatefromjpeg($file_tmp);
            imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagejpeg($imageResized, "images/category/" . $file_name);
            imagedestroy($imageResized);
            imagedestroy($imageTmp);
        } else {
            print_r($errors);
        }
    }

    if (!empty($name) && !empty($description)) {
        $sql = "UPDATE handmade.categories SET category_name='$name', description='$description'";
        if ($file_name) {
            $sql .= ", file='$file_name'";
        }
        $sql .= " WHERE id='$categoryId'";

        if ($conn->query($sql) === TRUE) {
            echo '<script> alert("Data Updated"); </script>';
            header('Location: index.php');
            exit();
        } else {
            echo '<script> alert("Data not Updated"); </script>';
        }
    }
}
?>