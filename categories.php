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
    <link rel="stylesheet" href="style/style.css">
    <title>Document</title>
</head>

<body>
    <a href="index.php"><button type="button" class="btn btn-dark">wroc do strony glownej</button></a>
    <a href="addNewProduct.php"><button type="button" class="btn btn-dark">dodaj produkt</button></a>

    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="card" style="width: 18rem;">';
            echo '<img src="..." class="card-img-top" alt="...">';
            echo '<div class="card-body">';
            echo '<p class="card-text">' . $row["name"] . ': ' . $row["description"] . '</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "0 results";
    }

    // Zamknij połączenie
    $conn->close();
    ?>
</body>

</html>