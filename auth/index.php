<?php  
session_start();
require "../config/Database.php";

$err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($err == "") {
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->execute(['username' => $username]);

        $user = $stmt->fetch(PDO::FETCH_OBJ);
        
        // For production: use password_verify($password, $user->password)
        if ($user && $user->password === $password) {
            // Set session variables
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['usertype'] = $user->usertype;
            $_SESSION['applicant_id'] = $user->applicant_id;

            // Custom redirect logic based on username
            if ($user->username === 'nonteaching') {
                header("Location: ../portal/nonteach_db.php");
                exit();
            }

            // Optional: special case for 'teaching'
            if ($user->username === 'teaching') {
                header("Location: ../portal/employee_dashboard.php");
                exit();
            }

            // Default behavior for employees
            if ($user->usertype === 'employee') {
                header("Location: ../portal/employee_dashboard.php");
                exit();
            }

            // Admins
            if ($user->usertype === 'admin') {
                header("Location: ../admin/performance/index.php");
                exit();
            }

            // You can add other usertypes here if needed
        } else {
            $err = "<div class='alert alert-danger text-center'>Invalid username or password.</div>";
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
        }
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }
    </style>
</head>

<body>
    <div class="splash-container">
        <?php 
            if(isset($err) && $err != "") {
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
                        <input class="form-control form-control-lg" name="username" id="username" type="text" placeholder="Username" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="password" id="password" type="password" placeholder="Password" required>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary btn-lg btn-block" value="Sign in">
                </form>
            </div>
            <div class="card-footer bg-white p-0">
                <div class="card-footer-item card-footer-item-bordered">
                    <!-- Optional Footer Link -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>
