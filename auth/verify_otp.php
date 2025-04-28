<?php
session_start();

if (!isset($_SESSION['temp_user'])) {
    header("Location: index.php");
    exit;
}

$err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = trim($_POST['otp']);

    if ($entered_otp == $_SESSION['temp_user']['otp'] && (time() - $_SESSION['temp_user']['otp_created']) <= 300) {
        // Move temp to real session
        $_SESSION['user_id'] = $_SESSION['temp_user']['user_id'];
        $_SESSION['username'] = $_SESSION['temp_user']['username'];
        $_SESSION['usertype'] = $_SESSION['temp_user']['usertype'];
        $_SESSION['applicant_id'] = $_SESSION['temp_user']['applicant_id'];
        $_SESSION['onboarding_step'] = $_SESSION['temp_user']['onboarding_step'];

        unset($_SESSION['temp_user']);

        // Redirect based on user role
        if ($_SESSION['onboarding_step'] < 4) {
            header("Location: ../admin/talent/onboarding/new_hire/step1.php");
            exit;
        } else {
            switch ($_SESSION['usertype']) {
                case 'admin':
                case 'operator':
                case 'superadmin':
                    header("Location: ../admin/index.php");
                    exit;
                case 'manager':
                case 'officer':
                case 'maintenance':
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
        $err = "Invalid OTP or expired. Please try again.";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
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
    <div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
        <div class="card" style="width: 400px;">
            <div class="card-header text-center">
                <h1>OTP Verification</h1>
            </div>
            <div class="card-body">
                <?php if (!empty($err)): ?>
                    <div class="alert alert-danger"><?= $err ?></div>
                <?php endif; ?>
                <form method="POST" action="verify_otp.php">
                    <div class="form-group">
                        <input type="text" name="otp" maxlength="6" pattern="\d{6}" title="Enter the 6-digit OTP"
                            class="form-control" placeholder="Enter OTP" required autofocus>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Verify OTP</button>
                </form>

                <div class="text-center mt-2">
                    <a href="resend_otp.php" class="btn btn-link">Resend OTP</a>
                </div>
            </div>
            <div class="card-footer text-center">
                <small>Check your email for the OTP code.</small>
            </div>
        </div>
    </div>
</body>

</html>