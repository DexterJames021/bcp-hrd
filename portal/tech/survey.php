<?php
require '../../config/Database.php';
require '../../auth/accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);

$hasSurveyResponse = hasSurveyResponse($_SESSION['user_id'], $conn);
echo "<script>console.log('survey user id: " . json_encode($hasSurveyResponse) . "')</script>";

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- icon -->
    <link rel="shortcut icon" href="../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

    <link href="https://unpkg.com/survey-core/survey-core.min.css" type="text/css" rel="stylesheet">

    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script defer src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>


    <!-- icon -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />

    <!-- main js -->
    <link rel="stylesheet" href="../../assets/libs/css/style.css">

    <!-- assts csss -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="../../node_modules/jquery/dist/jquery.min.js"></script>

    <!-- main js -->
    <script src="../notif.js"></script>

    <!-- slimscroll js -->
    <script src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://unpkg.com/survey-core@latest/survey.core.min.js"></script>
    <script src="https://unpkg.com/survey-jquery@latest/survey.jquery.min.js"></script>

    <script src="./includes/survey.js"></script>
    <script src="./includes/constants.js"></script>

    <title>Employee Dashboard</title>
</head>

<body>
    <script>
        var userPermissions = <?= json_encode($userData['permissions']); ?>;
        var user_id = <?= json_encode($_SESSION['user_id']); ?>;
    </script>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">

        <?php include '../sideandnavbar.php'; ?>

        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content ">
                <?php if ($userData && in_array("VIEW", $userData['permissions'])): ?>
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="initial card shadow-sm" he>
                        <div class="card-body text-center p-4">
                            <div class="mb-4">
                                <div class="p-3">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor"
                                        class="bi bi-emoji-smile" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                        <path
                                            d="M4.285 9.567a.5.5 0 0 1 .683.183A3.5 3.5 0 0 0 8 11.5a3.5 3.5 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5m4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5" />
                                    </svg>
                                </div>
                                <h2 class="card-title mb-2"> Help us Improve !</h2>
                                <p class="card-text text-muted small">Your feedback is valuable to us. This short survey will take less than 1 minute.</p>
                            </div>

                            <?php if($hasSurveyResponse && in_array(1,$hasSurveyResponse, true)):?>
                                <h4 class="lead">You have already completed this survey</h4>
                            <?php else: ?>
                                <button  id="startSurveyBtn" class="btn btn-primary btn-lg px-4 py-2">
                                    <i class="bi bi-play-fill me-2"></i> Start Survey
                                </button>
                            <?php endif; ?>


                        </div>
                        <div class="card-footer mt-3 text-muted small text-center">
                            <i class="bi bi-lock-fill me-1"></i> All responses are confidential
                        </div>
                    </div>

                    <div id="surveyContainer" class="mt-4" style="display:none;"></div>
                <?php else: ?>
                    <?php include_once "../../403.php"; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- bs notification -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="added" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body bg-success text-light">
                    Added, Successfully.
                </div>
            </div>
            <div id="status" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body bg-success text-light">
                    Status updated and email sent!
                </div>
            </div>
            <div id="error" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body bg-danger text-light">
                    Something went wrong.
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Move this to the BOTTOM of the body, just before closing </body> tag -->
    <!-- At bottom of body -->

</body>

</html>