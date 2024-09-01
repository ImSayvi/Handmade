<?php
session_start();
require('db.php');

$categoryName = '';  // Zainicjuj zmienną, aby unikać niezdefiniowanych zmiennych

if (isset($_GET['id_category'])) {
    $id_category = $_GET['id_category'];

    // Sprawdzenie czy kategoria istnieje
    $stmt_category = $conn->prepare("SELECT category_name FROM categories WHERE id = ?");
    $stmt_category->bind_param("i", $id_category);
    $stmt_category->execute();
    $categoryNameResult = $stmt_category->get_result();

    if ($categoryNameResult->num_rows > 0) {
        $categoryNameRow = $categoryNameResult->fetch_assoc();
        $categoryName = $categoryNameRow['category_name'];
        
        // Pobieranie produktów z bazy danych
        $stmt = $conn->prepare("SELECT * FROM handmade.handicrafts WHERE id_category = ?");
        $stmt->bind_param("i", $id_category);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        // Obsługa przypadku, gdy kategoria nie istnieje
        echo "Kategoria nie została znaleziona.";
        exit();  // Zakończ dalsze przetwarzanie strony, jeśli kategoria nie istnieje
    }
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/indexStyle.css">
    <title>Kategoria <?php echo $categoryName; ?></title>
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
                <h1 class="fw-light"><?php echo $categoryName; ?></h1>
                <p>
                    <a href="#" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#addProductModal">Dodaj nowy element</a>
                    <a href="#" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#addSubcategoryModal">Dodaj nową podkategorię</a>
                    <a href="index.php" class="btn btn-secondary my-2">Powrót</a>
                </p>
            </div>
        </div>
    </section>

    <!-- Modal dodawania nowego produktu -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Dodaj nowy produkt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data" action="addNewProduct.php">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="productName" class="form-label">Nazwa produktu</label>
                            <input type="text" class="form-control" id="productName" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Opis produktu</label>
                            <input type="text" class="form-control" id="productDescription" name="description">
                        </div>
                        <div class="mb-3">
                            <label for="productFile" class="form-label">Załącznik</label>
                            <input type="file" class="form-control" id="productFile" name="file">
                        </div>
                        <input type="hidden" name="category" value="<?php echo $id_category; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                        <button type="submit" class="btn btn-primary" name="addNewProduct">Dodaj</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal dodawania nowej podkategorii -->
    <div class="modal fade" id="addSubcategoryModal" tabindex="-1" aria-labelledby="addSubcategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubcategoryModalLabel">Dodaj nową podkategorię</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data" action="addNewSubcategory.php">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="subcategoryName" class="form-label">Nazwa podkategorii</label>
                            <input type="text" class="form-control" id="subcategoryName" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="subcategoryDescription" class="form-label">Opis podkategorii</label>
                            <input type="text" class="form-control" id="subcategoryDescription" name="description">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                        <button type="submit" class="btn btn-primary">Dodaj</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
while ($row = $result->fetch_assoc()) {
    $modalId = "deleteModal" . $row['id'];
    echo '
    <div class="col">
        <div class="card shadow-sm">
            <img class="card-img-top img-fluid" src="images/category/' . $categoryName . '/' . $row['file'] . '" alt="' . $row['file'] . '" style="height: 200px; object-fit: cover;">

            <div class="card-body d-flex flex-column">
                <h5 class="card-title">' . $row['name'] . '</h5>
                <p class="card-text flex-grow-1">' . $row['description'] . '</p>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-description="' . $row['description'] . '"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#' . $modalId . '"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <small class="text-body-secondary">Tags</small>
                    <small class="text-body-secondary">Dodano ' . $row['date'] . '</small>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="' . $modalId . '" tabindex="-1" aria-labelledby="exampleModalLabel' . $row['id'] . '" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel' . $row['id'] . '">Usuwasz element: ' . $row['name'] . '</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Czy na pewno chcesz usunąć ten element?
                </div>
                <div class="modal-footer">
                    <form method="POST" action="deleteProduct.php" name="deleteProduct">
                        <input type="hidden" name="product_id" value="' . $row['id'] . '">
                        <input type="hidden" name="productCategory" value="' . $categoryName . '">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                        <button type="submit" class="btn btn-danger">Tak, usuń!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    ';
}
?>

            </div>
        </div>
    </div>
</main>

<footer class="footer mt-auto py-3">
    <div class="container text-center">
        <span class="text-muted">Album example is &copy; Bootstrap</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/988d321f51.js" crossorigin="anonymous"></script>
</body>

</html>
