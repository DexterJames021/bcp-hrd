<?php 
session_start();
require "../config/Database.php";

$err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if($err == ""){
        $query = "SELECT * FROM users WHERE username = :username && password = :password LIMIT 1";
        $stmt = $conn->prepare($query);
        $check = $stmt->execute(['username'=> $username,'password'=>$password]);

        if ($check) {
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            if($user){
                if($user->usertype == 'admin'){
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['username'] = $user->username;
                    $_SESSION['usertype'] = $user->usertype;

                    header("Location:../admin/index.php");

                } elseif($user->usertype == 'employee'){
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['username'] = $user->username;
                    $_SESSION['usertype'] = $user->usertype;

                    header("Location:../portal/index.php");
                }

                echo "<script>confirm('405 no permission')</script>";
            } else {
                echo "<script>confirm('Something Wrong in email or password')</script>";
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link rel="shortcut icon" href="../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background-image: url('../assets/images/bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        .splash-container {
            z-index: 2;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
    <!-- Login Page -->
    <div class="splash-container">
        <?php 
            if(isset($err) && $err != ""){
                echo $err;
            }
        ?>
        <div class="card">
            <div class="card-header text-center">
                <a href="../index.php">
                    <img class="logo-img" src="../assets/images/bcp-hrd-logo.jpg" alt="logo" style="height:10rem;width:auto;">
                </a>
            </div>
            <div class="card-body">
                <form action="index.php" method="POST">
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="username" id="username" type="text" placeholder="Username" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="password" id="password" type="password" placeholder="Password">
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary btn-lg btn-block" value="Sign in">
                </form>
            </div>
            <div class="card-footer bg-white p-0">
                <div class="card-footer-item card-footer-item-bordered">
                    <!-- Optional footer link -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>