<?php
session_start();
require "../config/Database.php";

$err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM users WHERE username = :username && password = :password LIMIT 1";
    $stmt = $conn->prepare($query);
    $check = $stmt->execute(['username' => $username, 'password' => $password]);
    $user = $stmt->fetch();

    if ($user) {

        if ($user['usertype'] == 'admin') {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['usertype'] = $user['usertype'];

            header("Location:../admin/index.php");
            exit();
        } elseif ($user['usertype'] == 'employee') {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['usertype'] = $user['usertype'];

            header("Location:../portal/index.php");
            exit();
        }
    } else {
        $err = 'Invalid username or password';
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
        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">

        <div class="card ">
            <div class="card-header text-center">
                <a href="../index.php">
                    <img class="logo-img" src="../assets/images/bcp-hrd-logo.jpg" alt="logo" style="height:10rem;width:auto;">
                </a>
                <!-- <span class="splash-description">For authenticated staffs only.</span> -->
            </div>
            <div class="card-body">
                <?php if (!empty($err)): ?>
                    <div class="alert alert-danger"><?= $err ?></div>
                <?php endif; ?>
                <form action="index.php" method="POST">
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="username" id="username" type="text" placeholder="Username" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="password" id="password" type="password" placeholder="Password" required>
                    </div>
                    <input type="submit" name="submit" id="submit" class="btn btn-primary btn-lg btn-block" value="Sign in">
                </form>
            </div>
            <div class="card-footer bg-white p-0  ">
                <div class="card-footer-item card-footer-item-bordered">
                    <!-- <a href="#" class="footer-link">Forgot Password</a> -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>