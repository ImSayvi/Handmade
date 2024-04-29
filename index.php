<?php
session_start();
require_once "db.php";




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
            <div class="card container-sm">
                <img src="images/category/forest.jpg" class="card-img-top" alt="...">

                <div class="card-body">
                    <h5 class="card-title">kategoria 1</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="categories.php?id_category=1" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="card container-sm">
                <img src="images/category/card.jpg" class="card-img-top" alt="...">

                <div class="card-body">
                    <h5 class="card-title">kategoria 2</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>

                    <a href="categories.php?id_category=2" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="card container-sm">
                <img src="images/category/man.jpg" class="card-img-top" alt="...">

                <div class="card-body">
                    <h5 class="card-title">kateogria 3</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>

                    <a href="categories.php?id_category=3" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="card container-sm">
                <img src="images/category/mobile.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">kategoria 4</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="categories.php?id_category=4" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>


</body>

</html>