<?php
include 'db.php';

if (isset($_POST['product_id']) && isset($_POST['productCategory'])) {
    $productId = $_POST['product_id'];
    $categoryName = $_POST['productCategory'];

    // Pobieranie id_category przed usunięciem produktu
    $query = "SELECT file, id_category FROM handicrafts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $file = $row['file'];
    $id_category = $row['id_category'];  // Przechowywanie id_category

    // Usunięcie pliku z serwera
    $filePath = 'images/category/' . $categoryName . '/' . $file;
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    $stmt->close();

    // Usunięcie produktu z bazy danych
    $deleteQuery = "DELETE FROM handicrafts WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
        // Przekierowanie z powrotem do kategorii
        header('location: categories.php?id_category=' . $id_category);
        exit();
    } else {
        echo "Wystąpił błąd podczas usuwania produktu.";
    }

    $stmt->close();
    $conn->close();
}
