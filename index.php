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
<!-- modal na dodawanie kategorii -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dodaj nową kategorię!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data" action="addNewCategory.php">
                    <div class="modal-body">
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
                <h5 class="modal-title" id="editModalLabel">Edytuj kategorię!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data" action="addNewCategory.php">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nazwa</label>
                        <input type="text" class="form-control" id="edit_name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Opis</label>
                        <input type="text" class="form-control" id="edit_description" name="description">
                    </div>
                    <div class="mb-3">
                        <label for="edit_file" class="form-label">Załącznik</label>
                        <input type="file" class="form-control" id="edit_file" name="file">
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

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($categoryName) && !empty($categoryDescription)) {
        echo "<div class='alert alert-success'>Kategoria została pomyślnie dodana.</div>";
    } else {
        echo "<div class='alert alert-danger'>Wystąpił błąd podczas dodawania kategorii " . $conn->error . "</div>";
    }
}
?>

<div class="container-lg container">
    <div class="sideBar_menu">
        <ul>
            <li class="listItem">
                <a href="addNewProduct.php"><button type="button" class="btn btn-dark">Dodaj nowy produkt</button></a>
            </li>
            <li class="listItem">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">Dodaj nową kategorie</button></a>
            </li>
            <li class="listItem">
                <a href="logout.php"><button type="button" class="btn btn-dark">wyloguj</button></a>
            </li>
        </ul>
    </div>
    <div class="cards">
        <?php
        while ($row = $result->fetch_assoc()) {
            $modalId = "deleteModal" . $row['id'];
            echo
            '<div class="card container-sm">
                <img src="images/category/' . $row['file'] . '" class="card-img-top" alt="' . $row['category_name'] . '">
                <div class="card-body">
                    <h5 class="card-title">' . $row['category_name'] . '</h5>
                    <p class="card-text">' . $row['description'] . '</p>
                    <div class="cardBtns">
                        <a href="categories.php?id_category=' . $row['id'] . '" class="btn btn-primary">Przejdź do kategorii</a>
                        <button class="btn btn-primary editbtn" data-id="' . $row['id'] . '" data-name="' . $row['category_name'] . '" data-description="' . $row['description'] . '"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></button>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#' . $modalId . '"><i class="fa-solid fa-trash" style="color: #ffffff;"></i></button>
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
                            <button type="button" class="btn btn-danger"><a href="delete.php?deleteid=' . $row['id'] . '" class="text-light">Tak, usuń!</a></button>
                        </div>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/988d321f51.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('.editbtn').on('click', function(){
            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');

            $('#edit_name').val(name);
            $('#edit_description').val(description);
            $('#editmodal').modal('show');
        });
    });
</script>
</body>

</html>
