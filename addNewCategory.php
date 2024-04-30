<?php
session_start();
require_once "db.php";

$sql = "SELECT * FROM handmade.categories";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoryName = $_POST['name'];
    $categoryDescription = $_POST['description'];

    if (!empty($categoryName) && !empty($categoryDescription)) {
        $sql = "INSERT INTO handmade.categories (category_name, description) VALUES ('$categoryName', '$categoryDescription')";
        $conn->query($sql);
        $conn->close();
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style/style.css"> -->
    <link rel="stylesheet" href="style/addNewCategoryStyle.css">
    <title>Document</title>
</head>

<div class="container">
    <h3>Dodaj nową kategorię</h3>
    <div class="form-addNewProduct  container-sm border border-2">
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nazwa</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Opis</label>
                <input type="text" class="form-control" id="description" name="description">
            </div>

            <div class="buttons">
                <a href="#"><button type="submit" class="btn btn-dark">Dodaj</button></a>
                <a href="index.php"><button type="button" class="btn btn-dark">wróc do strony głównej</button></a>
            </div>
        </form>

    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($categoryName) && !empty($categoryDescription)) {
            echo "<div class='alert alert-success'>Kategoria została pomyślnie dodana.</div>";
        } else {
            echo "<div class='alert alert-danger'>Wystąpił błąd podczas dodawania kategorii " . $conn->error . "</div>";
        }
    }
    ?>
</div>

</html>