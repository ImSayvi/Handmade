<?php
session_start();
require_once "db.php";

$sqlCategory = "SELECT * FROM handmade.categories";
$result = $conn->query($sqlCategory);

if(isset($_POST['save_data'])){

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoryName = $_POST['name'];
    $categoryDescription = $_POST['description'];

    if(isset($_FILES['file'])){
        $errors= array();
        $file_name = $_FILES['file']['name'];
        $file_size =$_FILES['file']['size'];
        $file_tmp =$_FILES['file']['tmp_name'];
        $file_type=$_FILES['file']['type'];

        if(empty($errors)==true){
            list($width, $height) = getimagesize($file_tmp);
            $newWidth = 360;
            $newHeight = 240;

            $imageResized = imagecreatetruecolor($newWidth, $newHeight);
            $imageTmp = imagecreatefromjpeg($file_tmp);
            imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagejpeg($imageResized, "images/category/".$file_name);
            imagedestroy($imageResized);
            imagedestroy($imageTmp);
    
            // move_uploaded_file($file_tmp,"images/category/".$file_name);
        }else{
            print_r($errors);
        }
    }
    if(!empty($categoryName) && !empty($categoryDescription) && !empty($file_name)){
        $sql = "INSERT INTO handmade.categories (category_name, description, file) VALUES ('$categoryName', '$categoryDescription', '$file_name')";
        $conn->query($sql);
        $conn->close();

        header('location: index.php');
    }
}
};

?>

