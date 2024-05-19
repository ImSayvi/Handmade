<?php
include 'db.php';
        if (isset($_GET['deleteid'])) {
            $categoryId = $_GET['deleteid'];
            $deleteQuery = "DELETE FROM categories WHERE id = $categoryId";
            $statement = $conn->prepare($deleteQuery);
           
            if ($statement->execute()) {
                header('location: index.php');
                exit();
            } else {
                echo "Wystąpił błąd podczas usuwania kategorii.";
            };


            $statement->close();
            $conn->close();
        }
        ?>

        