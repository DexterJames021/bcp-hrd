<?php
session_start();
require "../config/Database.php";

$err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($err == "") {
        // Prepare the query to select the user by username only
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->execute(['username' => $username]);

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if ($user) {
            // Verify the hashed password
            if (password_verify($password, $user->password)) {
                // Start the session with user details
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                $_SESSION['usertype'] = $user->usertype;

                // Redirect based on user type
                switch ($user->usertype) {
                    case 'admin':
                        header("Location: ../admin/index.php");
                        exit;
                    case 'superadmin':
                        header("Location: ../admin/index.php");
                        exit;
                    case 'employee':
                        header("Location: ../portal/index.php");
                        exit;
                    case 'New Hire':
                        header("Location: ../admin/talent/onboarding/new_hire/step1.php");
                        exit;
                    default:
                        $err = '405 No permission to access this portal.';
                }
            } else {
                $err = 'Incorrect password.';
            }
        } else {
            $err = 'Username not found.';
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
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            min-height: 100vh;
            overflow: hidden;
            background: url('../assets/images/bcp1.jpg') no-repeat center center/cover;
        }
    </style>
</head>

<body>
    <div class="splash-container">
        <div class="card">
            <div class="card-header text-center">
                <a href="../index.php">
                    <img class="logo-img" src="../assets/images/bcp-hrd-logo.jpg" alt="logo"
                        style="height:10rem;width:auto;">
                </a>
            </div>
            <div class="card-body">
                <?php if (!empty($err)): ?>
                    <div class="alert alert-danger"><?= $err ?></div>
                <?php endif; ?>
                <form action="index.php" method="POST">
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="username" id="username" type="text"
                            placeholder="Username" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="password" id="password" type="password"
                            placeholder="Password" required>
                    </div>
                    <input type="submit" name="submit" id="submit" class="btn btn-primary btn-lg btn-block"
                        value="Sign in">
                </form>
            </div>
            <div class="card-footer bg-white p-0">
                <div class="card-footer-item card-footer-item-bordered">
                    <!-- Additional links can be added here -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>