<?php
session_start();
require_once "db.php";

if (isset($_POST['save_data'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $categoryName = ucfirst($_POST['name']);
        $categoryDescription = ucfirst($_POST['description']);
        $categoriesPath = 'images/category';
        $newDir = $categoriesPath . '/' . $categoryName;
        $isChecked = isset($_POST['addFileCheck']); // isset używamy do checkboxów

        
        $file_name = $isChecked ?  $_FILES['file']['name']: 'default.png';  // z pierwotnego sposobu zostawiam - jesli nie dodano zdjecia, dodaje sie domyslne (teraz rozwiazane przez svg)
        $file_tmp = $isChecked ?  $_FILES['file']['tmp_name']: ''; 

        
        if (file_exists($newDir)) {
            echo 'Taka kategoria już istnieje';
            header('location: index.php');
            return;
        } else {
            // mkdir robi nowy folder z uprawnieniami 0777 czyli wszystkmi
            mkdir($newDir, 0777, true);

            
            $sql = "INSERT INTO handmade.categories (category_name, description, file) VALUES ('$categoryName', '$categoryDescription', '$file_name')";
            if ($conn->query($sql) === TRUE) {
                if ($isChecked) {
                    //jezeli zaznaczono ze chce sie swoje zdjecie to przenosi fote ktora jest pod tymczasowym tmp do lokalizacji - nowego folderu
                    move_uploaded_file($file_tmp, $newDir . '/' . $file_name); 
                        echo 'Kategorie dodano pomyślnie';
                }
            } else {
                echo 'Błąd: ' . $conn->error;
            }

            $conn->close();
            header('location: index.php');
        }
    }
}
?>
