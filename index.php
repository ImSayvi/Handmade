<?php
session_start();
require_once "db.php";

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/988d321f51.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/indexStyle.css">
    <title>Handmade</title>
</head>

<body>
    <!-- modal na dodawanie kategorii -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dodaj nową kategorię!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data" action="addNewCategory.php" name="addCategoryForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nazwa</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Opis</label>
                            <input type="text" class="form-control" id="description" name="description">
                        </div>
                        <div class="mb-3 form-switch">
                            <input type="checkbox" class="form-check-input" id="addFileCheck" name="addFileCheck">
                            <label class="form-check-label" for="addFileCheck"> Nie dodawaj tytułowego zdjęcia do kategorii</label>
                            <p class="text-muted small">Dodane zostanie domyślne zdjęcie</p>
                        </div>
                        <div class="mb-3 fileDiv visually-hidden">
                            <label for="file" class="form-label">Załącznik</label>
                            <input type="file" class="form-control" id="file" name="file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                        <button type="submit" class="btn btn-primary" name="save_data">Dodaj</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- modal na edycje kategorii -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edytowanie kategorii</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data" action="update.php" name="editCategoryForm">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nazwa</label>
                            <input type="text" class="form-control" id="edit_name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Opis</label>
                            <input type="text" class="form-control" id="edit_description" name="description">
                        </div>
                        <div class="mb-3 form-checkbox">
                            <input type="checkbox" class="form-check-input" id="deleteCategoryImg" name="deleteCategoryImg">
                            <label class="form-check-label" for="deleteCategoryImg"> Usuń zdjęcie tytułowe kategorii</label>
                            <p class="text-muted small">Dodane zostanie domyślne zdjęcie</p>
                        </div>
                        <div class="mb-3 editDiv">
                            <label for="edit_file" class="form-label">Załącznik</label>
                            <input type="file" class="form-control" id="edit_file" name="file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                        <button type="submit" class="btn btn-primary" name="save_data">Wprowadź zmiany</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                            <label for="tags" class="form-label">Tagi: </label>
                            <input type="text" class="form-control" id="tags" name="tags">
                            <p class="text-muted small">Wprowadź tagi z '#'</p>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Kategoria</label>
                            <select class="form-control" id="category" name="category">
                                <?php
                                $sqlQueryCategories = "SELECT * FROM handmade.categories";
                                $result = $conn->query($sqlQueryCategories);
                                
                                if ($result->num_rows > 0) {
                                    
                                    while ($category = $result->fetch_assoc()) {
                                        echo '<option value="' . $category['id'] . '">' . htmlspecialchars($category['category_name']) . '</option>';
                                    }
                                } else {
                                    echo '<option disabled>Brak dostępnych kategorii</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="productFile" class="form-label">Załącznik</label>
                            <input type="file" class="form-control" id="productFile" name="file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                        <button type="submit" class="btn btn-primary" name="addNewProduct">Dodaj</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <header>
        <div class="navbar navbar-dark bg-dark shadow-sm sticky-top">
            <div class="container">
                <a href="#" class="navbar-brand d-flex align-items-center">
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
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Utrwalaj to co masz w głowie</h1>
                    <p class="lead text-muted">Lepiej bez celu iść naprzód niż bez celu stać w miejscu, a z pewnością o niebo lepiej, niż bez celu się cofać.</p>
                    <p>
                        <a href="#" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Dodaj nową kategorie</a>
                        <a href="addNewProduct.php" class="btn btn-secondary my-2" data-bs-toggle="modal" data-bs-target="#addProductModal">Dodaj nowy produkt</a>
                    </p>
                </div>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php
$sqlQueryCategories = "SELECT * FROM handmade.categories";
$result = $conn->query($sqlQueryCategories);
while ($row = $result->fetch_assoc()) {
    $modalId = "deleteModal" . $row['id'];
    $imagePath = "images/category/" . $row['category_name'] . "/" . $row['file'];

    if (!file_exists($imagePath)) {
        
        $svg = '
            <svg class="bd-placeholder-img card-img-top" width="100%" height="200" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="' . htmlspecialchars($row['category_name']) . '" preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>' . htmlspecialchars($row['category_name']) . '</title>
                <rect width="100%" height="100%" fill="#55595c"/>
                <text x="50%" y="50%" fill="#eceeef" dy=".3em" text-anchor="middle">' . $row['category_name'] . '</text>
            </svg>';
    } else {
        $svg = '<img class="card-img-top img-fluid" src="' . $imagePath . '" alt="' . $row['category_name'] . '" style="height: 200px; object-fit: cover;">';
    }

    echo '
    <div class="col">
      <div class="card shadow-sm">
            ' . $svg . '
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">' . $row['category_name'] . '</h5>
                <p class="card-text flex-grow-1">' . $row['description'] . '</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <a href="categories.php?id_category=' . $row['id'] . '" class="btn btn-sm btn-outline-secondary">Przejdź</a>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editmodal" data-id="' . $row['id'] . '" data-name="' . htmlspecialchars($row['category_name']) . '" data-description="' . htmlspecialchars($row['description']) . '"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#' . $modalId . '"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        <small class="text-body-secondary">Główne tagi: </small>
                    </div>
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
                    Czy na pewno chcesz usunąć kategorię ' . $row['category_name'] . ' i jej wszystkie elementy?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button type="button" class="btn btn-danger"><a href="delete.php?deleteid=' . $row['id'] . '" class="text-light">Tak, usuń!</a></button>
                </div>
            </div>
        </div>
    </div>';
}
?>


                </div>
            </div>
        </div>

    </main>

    <footer class="text-muted py-5">
        <div class="container">
            <p class="float-end mb-1">
                <a class="link-secondary link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="#">Powrót do góry</a>
            </p>
            <p class="mb-1">Album example is &copy; Bootstrap</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
   $(document).ready(function() {
    $('.btn-outline-secondary[data-bs-target="#editmodal"]').on('click', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var description = $(this).data('description');

        console.log(id, name, description); 
        $('#edit_id').val(id);
        $('#edit_name').val(name);
        $('#edit_description').val(description);
    });
});

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/988d321f51.js" crossorigin="anonymous"></script>
    <script src="script/script.js"></script>

</body>

</html>
