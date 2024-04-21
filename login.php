<?php
session_start();
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
                <label for="username" class="form-label">Email address</label>
                <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
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

    if ($username == 123 && $password == 123) {
        header("Location: index.php");
    } else {
        echo "zly login";
    }
} else {
    echo 'siurekssie';
    echo var_dump($username);
}
