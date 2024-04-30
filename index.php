<?php
session_start();
require_once "db.php";

$max_id_query = "SELECT MAX(id) AS max_id FROM categories";
$max_id_result = $conn->query($max_id_query);
$max_id_row = $max_id_result->fetch_assoc();
$max_id = $max_id_row['max_id'];

for ($i = 0; $i <= $max_id; $i++) {
$sql = "SELECT category_name, description FROM categories WHERE id = $i";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$category_name = $row["category_name"];
$description = $row["description"];
}


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

        echo
            '<div class="card container-sm">
                <img src="images/category/forest.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">'. $category_name .'</h5>
                    <p class="card-text">'. $description .'</p>
                    <a href="categories.php?id_category='.$i.'" class="btn btn-primary">Go somewhere</a>
                </div>  
            </div>';

        ?>


        </div>


</body>

</html>