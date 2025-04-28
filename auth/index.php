<<<<<<< HEAD
<?php
session_start();
require __DIR__ . "/../config/Database.php";
=======
<?php  
session_start();
require "../config/Database.php";
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04

$err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($err == "") {
<<<<<<< HEAD
        // Prepare the query to select the user by username only
=======
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->execute(['username' => $username]);

        $user = $stmt->fetch(PDO::FETCH_OBJ);
<<<<<<< HEAD

        if ($user) {
            // Verify the hashed password
            if (password_verify($password, $user->password)) {
                // Start the session with user details
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                $_SESSION['usertype'] = $user->usertype;
                $_SESSION['applicant_id'] = $user->applicant_id;
                $_SESSION['onboarding_step'] = $user->onboarding_step; // Store onboarding step in session

                // Check the user's onboarding step status
                if ($user->onboarding_step < 4) {
                    // If onboarding step is not complete, redirect to the appropriate step
                    header("Location: ../admin/talent/onboarding/new_hire/step1.php");
                    exit;
                } else {
                    // If onboarding is complete, proceed based on usertype
                    switch ($user->usertype) {
                        case 'admin':
                        case 'maintenance':
                        case 'superadmin':
                            header("Location: ../admin/index.php");
                            exit;
                        case 'manager':
                        case 'officer':
                            header("Location: ../manager/index.php");
                            exit;
                        case 'employee':
                        case 'nonteaching':
                        case 'teaching':
                        case 'staff':
                            header("Location: ../portal/index.php");
                            exit;
                        default:
                            $err = '405 No permission to access this portal.';
                    }
                }
            } else {
                $err = 'Incorrect password.';
            }
        } else {
            $err = 'Username not found.';
=======
        
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
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
        }
    }
}
?>

<!doctype html>
<html lang="en">
<<<<<<< HEAD

=======
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link rel="shortcut icon" href="../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">
<<<<<<< HEAD
=======
    <!-- Bootstrap CSS -->
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
<<<<<<< HEAD
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
=======
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 40px;
            padding-bottom: 40px;
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
        }
    </style>
</head>

<body>
    <div class="splash-container">
<<<<<<< HEAD
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
=======
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
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
                </form>
            </div>
            <div class="card-footer bg-white p-0">
                <div class="card-footer-item card-footer-item-bordered">
<<<<<<< HEAD
                    <!-- Additional links can be added here -->
=======
                    <!-- Optional Footer Link -->
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
                </div>
            </div>
        </div>
    </div>
</body>
<<<<<<< HEAD

</html>
=======
</html>
>>>>>>> 7e9007b254c7a3b621580d2a7f5ee26253427f04
