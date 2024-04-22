<?php
session_start();
require_once('db.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>Document</title>
</head>

<body>
    <div id="container" class="container-sm">
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label"></label>
                <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp" placeholder="Login">
                
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label"></label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Remember me</label>
                <label for="">|</label>
                
                <label class="form-check-label" for="exampleCheck2">Forgot password</label>
            </div>
            <button type="Sign up" class="btn btn-primary">Log in</button>
        </form>
    </div>
</body>

</html>


<?php

if (isset($_POST['username'])) {
    $_SESSION['username'] = $_POST['username'];
    $username = $_SESSION['username'];
    $_SESSION['password'] = $_POST['password'];
    $password = $_SESSION['password'];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_row($result);

    if ($row[1] == $username && $row[2] == $password) {
        header("Location: index.php");
    } else {
        echo "zly login";
    }
} else {
    echo 'siurekssie';
    echo var_dump($username);
}
