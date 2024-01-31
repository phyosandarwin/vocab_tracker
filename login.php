<?php // Do not put any HTML above this line
session_start();
$stored_hash = password_hash('phyo1812', PASSWORD_DEFAULT);

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['user']) && isset($_POST['password']) ) {
    if ( strlen($_POST['user']) < 1 || strlen($_POST['password']) < 1 ) {
        $_SESSION['error'] = "User name and password are required";
        header("Location: login.php");
        return;
    } else {
        $check = password_verify($_POST['password'], $stored_hash);
        if ( $check ) {
            // Redirect the browser to index.php
            $_SESSION['name'] = $_POST['user']; //set name key of session variable -> check again in index.php
            header("Location: index.php");
            return;
        }
        else {
            $_SESSION['error'] = "Incorrect password";
            header("Location: login.php");
            return;
        }
    }
}

// Fall through into the View
?>

<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="styles/login.css" rel ="stylesheet">
<title>Vocab Tracker Login</title>
</head>
<body>
    <div class="card text-center" 
    style="position: absolute; transform: translate(-50%, -50%); top: 50%; left: 50%; height:auto;">
    <div class="card-header" style="font-weight:600; font-size:30px">Login Form</div><br/>
    <div class="card-body">
    <?php
        if ( isset($_SESSION['error']) ) {
            echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }
    ?>
    <form method="POST">
        Username:  <input type="text" name="user" size="30"><br/> 
        <br/>
        Password:  <input type="password" name="password" size="30"><br/>
        <br/>
        <button class="btn btn-info" type="submit">Log In</button>
        <a class="btn btn-secondary" href="index.php" role="button">Cancel</a>
    </form>
    <br/>
    <p style='font-size: 14px; color:gray;'>Password hint: Name (All in lowercase) + 1812</p>
    </div>
    
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
