<?php
session_start();
require_once "db.php";

$sqlQueryCategories = "SELECT * FROM handmade.categories";
$result = $conn->query($sqlQueryCategories);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/indexStyle.css">
    <title>Document</title>
</head>

<body>

<div class="container-lg container">
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
            
            $modalId = "exampleModal" . $row['id'];

            echo
            '<div class="card container-sm">
            <img src="images/category/' . $row['file'] . '" class="card-img-top" alt="' . $row['category_name'] . '">
            <div class="card-body">
                <h5 class="card-title">' . $row['category_name'] . '</h5>
                <p class="card-text">' . $row['description'] . '</p>
                <div class="cardBtns">
                    <a href="categories.php?id_category=' . $row['id'] . '" class="btn btn-primary">Przejdź do kategorii</a>
                    
                    <button class="btn btn-primary"><a href="#"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></a></button>    
                    <button class="btn btn-danger delete" data-bs-toggle="modal" data-bs-target="#' . $modalId . '"><i class="fa-solid fa-trash" style="color: #ffffff;"></i></button>
                </div>
            </div>  
        </div>

        <div class="modal fade" id="' . $modalId . '" tabindex="-1" aria-labelledby="exampleModalLabel' . $row['id'] . '" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel' . $row['id'] . '">Usuwasz kategorię!</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             Czy na pewno chcesz usunąć kategorię ' . $row['category_name'] . ' i jej wszystkie produkty?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
              <button type="button" class="btn btn-primary"><a href="delete.php?deleteid=' . $row['id'] . '" class="text-light">Tak, usuń!</a></button>
            </div>
          </div>
        </div>
      </div>';
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/988d321f51.js" crossorigin="anonymous"></script>

</body>

</html>
