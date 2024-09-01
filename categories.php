<?php
session_start();
require('db.php');

if (isset($_GET['id_category'])) {
    $id_category = $_GET['id_category'];

   
    $stmt = $conn->prepare("SELECT * FROM handmade.handicrafts WHERE id_category = ?");
    $stmt->bind_param("i", $id_category);
    $stmt->execute();
    $result = $stmt->get_result();

   
    $stmt_category = $conn->prepare("SELECT category_name FROM categories WHERE id = ?");
    $stmt_category->bind_param("i", $id_category);
    $stmt_category->execute();
    $categoryNameResult = $stmt_category->get_result();
    $categoryNameRow = $categoryNameResult->fetch_assoc();
    $categoryName = $categoryNameRow['category_name'];
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/indexStyle.css">
    <title>Kategoria - <?php echo $categoryName; ?></title>
</head>

<body class="d-flex flex-column min-vh-100">
<header>
    <div class="navbar navbar-dark bg-dark shadow-sm sticky-top">
        <div class="container">
            <a href="index.php" class="navbar-brand d-flex align-items-center">
                <strong>Handmade</strong>
            </a>
            <div>
                <a class="btn btn-secondary" href="logout.php">Wyloguj</a>
            </div>
        </div>
    </div>
</header>

<main>
    <section class="py-5 text-center container">
        <div class="row">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light"><?php echo htmlspecialchars($categoryName); ?></h1>
                <p>
                    <a href="addNewProduct.php" class="btn btn-primary my-2">Dodaj nowy produkt</a>
                    <a href="index.php" class="btn btn-secondary my-2">Powrót</a>
                </p>
            </div>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php
                while ($row = $result->fetch_assoc()) {
                    $modalId = "deleteModal" . $row['id'];
                    echo '
                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="card-img-top img-fluid" src="images/category/' . $row['file'] . '" alt="' .$row['file'] . '" style="height: 200px; object-fit: cover;">

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">' . $row['name'] . '</h5>
                                <p class="card-text flex-grow-1">' . $row['description'] . '</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="categories.php?id_category=' . $row['id'] . '" class="btn btn-sm btn-outline-secondary">Przejdź</a>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-description="' .$row['description']. '"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#' . $modalId . '"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                    <small class="text-body-secondary">9 mins</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="' .$modalId . '" tabindex="-1" aria-labelledby="exampleModalLabel' .$row['id'] . '" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel' .$row['id']. '">Usuwasz produkt!</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Czy na pewno chcesz usunąć produkt ' . $row['name'] . '?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                                    <button type="button" class="btn btn-danger"><a href="delete.php?deleteid=' . $row['id'] . '" class="text-light">Tak, usuń!</a></button>
                                </div>
                            </div>
                        </div>
                    </div>';
                };
                ?>
            </div>
        </div>
    </div>
</main>

<footer class="text-muted py-5 mt-auto">
    <div class="container">
        <p class="float-end mb-1">
            <a class="link-secondary link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="#">Powrót do góry</a>
        </p>
        <p class="mb-1">Album example is &copy; Bootstrap</p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/988d321f51.js" crossorigin="anonymous"></script>

</body>
</html>
