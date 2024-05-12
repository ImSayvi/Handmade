<?php
session_start();
require_once "db.php";

$max_id_query = "SELECT MAX(id) AS max_id FROM categories";
$max_id_result = $conn->query($max_id_query);
$max_id_row = $max_id_result->fetch_assoc();
$max_id = $max_id_row['max_id'];



$sqlQueryCategories = "SELECT * FROM handmade.categories";
$result = $conn->query($sqlQueryCategories);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style/style.css"> -->
    <link rel="stylesheet" href="style/indexStyle.css">
    <title>Document</title>
</head>

<body>
    <div class="container-lg container ">

        <div class="sideBar_menu">
            <ul>
                <li class="listItem">
                    <a href="addNewProduct.php"><button type="button" class="btn btn-dark">Dodaj nowy produkt</button></a>
                </li>
                <li class="listItem">
                    <a href="addNewCategory.php"><button type="button" class="btn btn-dark">Dodaj nową kategorie</button></a>
                </li>
                <li class="listItem">
                    <a href="logout.php"><button type="button" class="btn btn-dark">wyloguj</button></a>
                </li>
            </ul>
        </div>
        <div class="cards">

        <?php
        while ($row = $result->fetch_assoc()) {
        echo
            '<div class="card container-sm">
                <img src="images/category/'.$row['file'].'" class="card-img-top" alt='. $row['category_name'] .'>
                <div class="card-body">
                    <h5 class="card-title">'. $row['category_name'] .'</h5>
                    <p class="card-text">'. $row['description'] .'</p>
                    <a href="categories.php?id_category='.$row['id'].'" class="btn btn-primary">Przejdź do kategorii</a>
                </div>  
            </div>';}

        ?>


        </div>


</body>

</html>