<?php
session_start();
require('db.php');

if (isset($_GET['id_category'])) {
    $id_category = $_GET['id_category'];
}


$sql = "SELECT * FROM handicrafts WHERE id_category = $id_category";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/categories.css">
    <title>Document</title>
</head>

<body>


    <div class="container">
        <a href="index.php"><button type="button" class="btn btn-dark">wroc do strony glownej</button></a>
        <a href="addNewProduct.php"><button type="button" class="btn btn-dark">dodaj produkt</button></a>
        <div class="row">
            <?php
            while ($row = $result->fetch_assoc()) {
            ?>
                <div class="col">
                    <?php echo $row['name'] ?>
                </div>
                <div class="col">
                <?php echo $row['description'];
            } ?>
                </div>
        </div>
</body>

</html>