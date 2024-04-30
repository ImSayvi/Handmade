<?php

$showAlert = false;
$showError = false;
$exists = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include 'db.php';

    $username = $_POST["username"];
    $password = $_POST["password"];
    $repeatPass = $_POST["repeatPassword"];


    if (!empty($username) && !empty($password) && !empty($repeatPass)) {

        $sql = "Select * from users where username='$username'";

        $result = mysqli_query($conn, $sql);

        $num = mysqli_num_rows($result);

        if ($num == 0) {

            if ($password == $repeatPass  && $exists == false) {

                $hash = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO `users` (`username`, `password`) VALUES ('$username','$hash')";

                $result = mysqli_query($conn, $sql);

                if ($result) {
                    $showAlert = true;
                }
            } else {
                $showError = "Passwords do not match";
            }
        }

        if ($num > 0) {
            $exists = "Username not available";
        }
    } else {

        $showError = "Fill all the fields";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>register</title>
</head>

<body>



    <div id="container" class="container-sm">
    <img src="img/createAcc.png" alt="Welcome" height="200px" >
    <?php

if ($showAlert) {
    echo ' <div class="alert alert-success  
    alert-dismissible fade show" role="alert"> 
    <strong>Success!</strong> Your account is  
    now created and you can login.  
    </div> ';
}

if ($showError) {
    echo ' <div class="alert alert-danger  
    alert-dismissible fade show" role="alert">  
    <strong>Error!</strong> ' . $showError . '  
    </div> ';
}

if ($exists) {
    echo ' <div class="alert alert-danger  
    alert-dismissible fade show" role="alert"> 
    <strong>Error!</strong> ' . $exists . '
    </div> ';
}

?>
        <form method="POST" action="register.php">

            <div class="mb-3">
                <label for="username" class="form-label"></label>
                <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp" placeholder="Login">
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label"></label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>

            <div class="mb-3">
                <label for="repeatPassword" class="form-label"></label>
                <input type="password" name="repeatPassword" class="form-control" id="repeatPassword" placeholder="Repeat password">
            </div>
            <p class="form-check">You already have account? <a href="login.php"> Log in.</a></p>
            <button type="Sign up" class="btn btn-primary">sign up</button>

        </form>
    </div>


</body>

</html>