<?php
session_start();
require('db.php');

$sqlQueryCategories = "SELECT * FROM handmade.categories";
$result = $conn->query($sqlQueryCategories);

if (isset($_POST['name']) && !empty($_POST['description']) && isset($_POST['category'])) {
    $_SESSION['name'] = $_POST['name'];
    $name = $_SESSION['name'];
    $_SESSION['description'] = $_POST['description'];
    $description = $_SESSION['description'];



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
            imagejpeg($imageResized, "images/handicrafts/".$file_name);
            imagedestroy($imageResized);
            imagedestroy($imageTmp);
        }else{
            print_r($errors);
        }
    }



    $category_id = $_POST['category'];


    $sqlQueryProduct = "INSERT INTO handmade.handicrafts (name, description, id_category, file) VALUES ('$name', '$description', '$category_id', '$file_name')";
    $conn->query($sqlQueryProduct);

    $conn->close();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style/style.css"> -->
    <link rel="stylesheet" href="style/addNewProductStyle.css">
    <title>Document</title>
</head>

<body>


    <div class="container">
        <h3>Dodaj nowy produkt</h3>
        <div class="form-addNewProduct  container-sm border border-2">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Nazwa</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Opis</label>
                    <input type="text" class="form-control" id="description" name="description">
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Załącznik</label>
                    <input type="file" class="form-control" id="file" name="file">
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Kategoria</label>
                    <select class="form-control" id="category" name="category">
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['category_name'] . "</option>";
                        }
                        ?>
                    </select>
                    <div class="buttons">
                        <a href="#"><button type="submit" class="btn btn-dark">Dodaj</button></a>
                        <a href="index.php"><button type="button" class="btn btn-dark">wróć do strony głównej</button></a>
                    </div>
            </form>
        </div>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['name']) && !empty($_POST['description']) && isset($_POST['category'])) {
            echo "<div class='alert alert-success'>Rekord został pomyślnie dodany.</div>";
        } else {
            echo "<div class='alert alert-danger'>Wystąpił błąd podczas dodawania rekordu " . $conn->error . "</div>";
        }
    }
    ?>
</body>

</html>