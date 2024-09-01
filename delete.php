<?php
include 'db.php';

if (isset($_GET['deleteid'])) {
    $categoryId = $_GET['deleteid'];


    $pathQuery = "SELECT category_name FROM categories WHERE id = ?";
    $stmt = $conn->prepare($pathQuery);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();
    $categoryName = $result->fetch_assoc()['category_name'];  // Poprawny sposób pobrania nazwy kategorii

    $stmt->close();

    $folderPath = 'images/category/' . $categoryName;
    $files = glob($folderPath . '/*');


    foreach ($files as $file) {
        unlink($file);
    }

 
    rmdir($folderPath);

  
    $deleteQuery = "DELETE FROM categories WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $categoryId);

    if ($stmt->execute()) {
        header('location: index.php');
        exit();
    } else {
        echo "Wystąpił błąd podczas usuwania kategorii.";
    }

    $stmt->close();
    $conn->close();
}
?>
