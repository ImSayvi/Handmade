<?php
$showError = false;
session_start();
require_once('db.php');

 if (isset($_POST['username']) && isset($_POST['password'])) {
     
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt->execute();
    $stmt->store_result();

    if(($username!="") && ($password!="")){
    if ($stmt->num_rows > 0) {

        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit;
        } else {
            $showError = " Incorrect password!";
        }
    } else {
        $showError = " User not found!";
    }

    $stmt->close();
    $conn->close();
 }else{
     $showError= "Fill all the fields";
    }
 }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/988d321f51.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    
    <title>Document</title>
</head>

<body>
    <div id="container" class="container-sm">
    <img src="img/welcome2.png" alt="Welcome" height="200px" >
            <?php
            if ($showError) {
                echo ' <div class="alert alert-danger  
                alert-dismissible fade show" role="alert">  
                <strong>Error!</strong> ' . $showError . '  
                </div> ';
            }
            ?>
        <form method="POST" action="login.php">
          
        
            <div class="mb-3">


                <label for="username" class="form-label"></label>
                <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp" placeholder="Login">
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label"></label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">

            </div>
            <div class="mb-3 form-check">
            
                <label class="form-check-label" for="exampleCheck1"><a href="register.php">Sign Up</a></label>
                <label for="">|</label>
                <label class="form-check-label" for="exampleCheck1">Forgot password</label>
            </div>
            <button type="submit" class="btn btn-primary">Log in</i></button>
        </form>
    </div>
    <script src="https://kit.fontawesome.com/988d321f51.js" crossorigin="anonymous"></script>
</body>

</html>






<div class="mb-3">
                            <label for="icon">Ikonka</label>
                            <select class="form-select" id="icon" name="icon">
                                <option selected>wybierz ikonke</option>
                                <option value='<i class="fa-solid fa-gas-pump"></i>'><i class="fa-solid fa-gas-pump"></i></option>
                                <option value='<i class="fa-solid fa-umbrella-beach"></i>'><i class="fa-solid fa-umbrella-beach"></i></option>
                                <option value='<i class="fa-solid fa-horse-head"></i>'><i class="fa-solid fa-horse-head"></i></option>
                                <option value='<i class="fa-solid fa-graduation-cap"></i>'><i class="fa-solid fa-graduation-cap"></i></option>
                                <option value='<i class="fa-solid fa-user-ninja"></i>'><i class="fa-solid fa-user-ninja"></i></option>
                                <option value='<i class="fa-solid fa-poo"></i>'><i class="fa-solid fa-poo"></i></option>
                                <option value='<i class="fa-solid fa-bolt"></i>'><i class="fa-solid fa-bolt"></i></option>
                                <option value='<i class="fa-solid fa-money-bill-1"></i>'><i class="fa-solid fa-money-bill-1"></i></option>
                                
                            </select>
                        </div>