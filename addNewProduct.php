<?php
session_start();
require('db.php');

$sqlQueryCategories = "SELECT * FROM handmade.categories";
$result = $conn->query($sqlQueryCategories);

var_dump($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/addNewProductStyle.css">
    <title>Document</title>
</head>

<body>
    siurek
    <a href="categories.php"><button type="button" class="btn btn-dark">wróc do kategorii</button></a>
    <form method="POST">
        <div class="form-addNewProduct container-sm">
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
                <input type="text" class="form-control" id="file" name="file">
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
            </div>
            <a href="#"><button type="submit" class="btn btn-dark">Dodaj</button></a>

    </form>
    </div>

</body>

</html>


<?php
if (isset($_POST['name']) && !empty($_POST['description']) && isset($_POST['category'])) {
    $_SESSION['name'] = $_POST['name'];
    $name = $_SESSION['name'];
    $_SESSION['description'] = $_POST['description'];
    $description = $_SESSION['description'];
    $_SESSION['file'] = $_POST['file'];
    $file = $_SESSION['file'];
    
    $category_id = $_POST['category']; 


    $sqlQueryProduct = "INSERT INTO handmade.handicrafts (name, description, id_category) VALUES ('$name', '$description', '$category_id')";
    $result = $conn->query($sqlQueryProduct);

    if ($result) {
        echo "<div class='alert alert-success'>Rekord został pomyślnie dodany.</div>";
    } else {
        echo "<div class='alert alert-danger'>Wystąpił błąd podczas dodawania rekordu: " . $conn->error . "</div>";
    }
}

?>