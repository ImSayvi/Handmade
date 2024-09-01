<?php
session_start();
require_once "db.php";

if (isset($_POST['save_data'])) {
    $categoryId = $_POST['id'];
    $categoryName = ucfirst($_POST['name']);
    $categoryDescription = ucfirst($_POST['description']);
    $categoriesPath = 'images/category';
    $currentDirQuery = "SELECT category_name, file FROM handmade.categories WHERE id='$categoryId'";
    $currentDirResult = $conn->query($currentDirQuery);
    $currentCategory = $currentDirResult->fetch_assoc();
    $currentDir = $categoriesPath . '/' . $currentCategory['category_name'];
    $newDir = $categoriesPath . '/' . $categoryName;
    $file_name = null;

    // Sprawdzenie, czy zaznaczono opcję usunięcia zdjęcia
    if (isset($_POST['deleteCategoryImg']) && $_POST['deleteCategoryImg'] == 'on') {
        // Usuń stare zdjęcie, jeśli istnieje
        if ($currentCategory['file']) {
            $oldFilePath = $currentDir . '/' . $currentCategory['file'];
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }
        $file_name = ''; 
    }

    if (isset($_FILES['file']) && $_FILES['file']['size'] > 0) {
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];

        if (empty($errors) == true) {
            
            if ($currentCategory['category_name'] !== $categoryName) {
                if (file_exists($newDir)) {
                    echo 'Kategoria z taką nazwą już istnieje';
                    header('location: index.php');
                    return;
                } else {
                    
                    rename($currentDir, $newDir);
                }
            }

            
            move_uploaded_file($file_tmp, $newDir . '/' . $file_name);
        } else {
            print_r($errors);
        }
    } else {
        // jak nie ma nowego pliku, użyj starego katalogu
        if ($currentCategory['category_name'] !== $categoryName) {
            if (file_exists($newDir)) {
                echo 'Kategoria z taką nazwą już istnieje';
                header('location: index.php');
                return;
            } else {
                
                rename($currentDir, $newDir);
            }
        }
        $file_name = $currentCategory['file']; // Zostawienie starego pliku, jeśli nie dodano nowego
    }

    if (!empty($categoryName) && !empty($categoryDescription)) {
        $sql = "UPDATE handmade.categories SET category_name='$categoryName', description='$categoryDescription'";
        if ($file_name !== null) {
            $sql .= ", file='$file_name'";
        }
        $sql .= " WHERE id='$categoryId'";

        if ($conn->query($sql) === TRUE) {
            echo '<script> alert("Dane zostały zaktualizowane"); </script>';
            header('Location: index.php');
            exit();
        } else {
            echo '<script> alert("Dane nie zostały zaktualizowane"); </script>';
        }
    }
}
?>
