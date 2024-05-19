<?php
session_start();
require_once "db.php";

$sqlQueryCategories = "SELECT * FROM handmade.categories";
$result = $conn->query($sqlQueryCategories);

if (!$result) {
    die("Query failed: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style/categories.css"> -->
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
                    <a href=""><button type="button" class="btn btn-dark">Usuń kategorie</button></a>
                </li>
                <li class="listItem">
                    <a href="logout.php"><button type="button" class="btn btn-dark" onsubmit="confirmDelete()">wyloguj</button></a>
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
                    <div class="cardBtns">
                        <a href="categories.php?id_category='.$row['id'].'" class="btn btn-primary">Przejdź do kategorii</a>
                        <form method="post" onsubmit="confirmDelete();">
                            <input type="hidden" name="category_id" value="'.$row['id'].'">
                            <button type="submit" class="btn btn-primary delete" name="delete_category"><i class="fa-solid fa-trash" style="color: #ffffff;"></i></button>
                        </form>
                    </div>
                </div>  
            </div>';}

        
        ?>
        </div>

<script src="https://kit.fontawesome.com/988d321f51.js" crossorigin="anonymous"></script>


<?php
if (isset($_POST['delete_category'])) {
    require_once "db.php"; 
    $categoryId = $_POST['category_id'];

    $deleteQuery = "DELETE FROM categories WHERE id = ?";
    $statement = $conn->prepare($deleteQuery);
    $statement->bind_param('i', $categoryId);
    
    if ($statement->execute()) {
        exit();
    } else {
        echo "Wystąpił błąd podczas usuwania kategorii.";
    }


    $statement->close();
    $conn->close();
}
?>

<script src="/script/script.js"></script>
</body>

</html>