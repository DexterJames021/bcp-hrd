<?php
session_start();
require __DIR__ . "/../config/Database.php";

// Load PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php'; // Adjust path if needed

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

$err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($err == "") {
        // Fetch user
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if ($user) {
            if (password_verify($password, $user->password)) {
                // Fetch applicant email
                $query = "SELECT email FROM applicants WHERE id = :applicant_id LIMIT 1";
                $stmt = $conn->prepare($query);
                $stmt->execute(['applicant_id' => $user->applicant_id]);
                $applicant = $stmt->fetch(PDO::FETCH_OBJ);

                if ($applicant) {
                    $email = $applicant->email;

                    // Generate OTP
                    $otp = rand(100000, 999999);

                    // Save temp session
                    $_SESSION['temp_user'] = [
                        'user_id' => $user->id,
                        'username' => $user->username,
                        'usertype' => $user->usertype,
                        'applicant_id' => $user->applicant_id,
                        'onboarding_step' => $user->onboarding_step,
                        'otp' => $otp,
                        'otp_created' => time()
                    ];

                    // Send OTP email via PHPMailer
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com';
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'fantastiassasin@gmail.com'; // <-- your gmail
                        $mail->Password   = 'ifst tyvw lflb bsfr';   // <-- your generated App Password
                        $mail->SMTPSecure = 'tls';
                        $mail->Port       = 587;

                        $mail->setFrom('fantastiassasin@gmail.com', 'HR Portal');
                        $mail->addAddress($email, $user->username);

                        $mail->isHTML(true);
                        $mail->Subject = 'Your OTP Code';
                        $mail->Body    = "Hello {$user->username},<br><br>Your OTP is: <b>{$otp}</b><br><br>This code will expire in 5 minutes.";

                        $mail->send();

                        // Redirect to OTP page
                        header("Location: verify_otp.php");
                        exit;
                    } catch (Exception $e) {
                        $err = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                } else {
                    $err = 'Applicant email not found.';
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
    <title>Login</title>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
</head>
<body style="background: url('../assets/images/bcp1.jpg') no-repeat center center/cover; height: 100vh;">
    <div class="container d-flex justify-content-center align-items-center" style="height:100%;">
        <div class="card" style="width: 400px;">
            <div class="card-header text-center">
                <img src="../assets/images/bcp-hrd-logo.jpg" alt="logo" style="height:100px;">
            </div>
            <div class="card-body">
                <?php if (!empty($err)): ?>
                    <div class="alert alert-danger"><?= $err ?></div>
                <?php endif; ?>
                <form method="POST" action="index.php">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
