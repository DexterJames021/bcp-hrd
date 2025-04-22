<?php
require __DIR__ . '../../../config/Database.php';
require __DIR__ . '../../../auth/accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- icon -->
    <link rel="shortcut icon" href="../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

    <!-- <link href="https://unpkg.com/survey-core/survey-core.min.css" type="text/css" rel="stylesheet"> -->

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
    <script src="../../assets/libs/js/main-js.js"></script>

    <!-- slimscroll js -->
    <script src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

    <script src="https://unpkg.com/jquery/dist/jquery.min.js"></script>
    <script src="https://unpkg.com/survey-core@2.0.5/survey.core.min.js"></script>
    <script src="https://unpkg.com/survey-core@2.0.5/survey.i18n.min.js"></script>
    <script src="https://unpkg.com/survey-core@2.0.5/themes/index.min.js"></script>
    <script src="https://unpkg.com/survey-js-ui@2.0.5/survey-js-ui.min.js"></script>
    <script src="https://unpkg.com/plotly.js-dist-min/plotly.min.js"></script>
    <script src="https://unpkg.com/survey-analytics@2.0.5/survey.analytics.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/survey-analytics@2.0.5/survey.analytics.css" />

    <script src="./includes/resource/survey_admin.js"></script>
    <script src="./includes/resource/constants.js"></script>

    <title>Admin Dashboard</title>
</head>

<body>
    <script>
        var userPermissions = <?= json_encode($userData['permissions']); ?>;
    </script>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <?php include '../sideandnavbar.php'; ?>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper" id="dashboardWrapper">
            <?php if ($userData && in_array("VIEW", $userData['permissions'])): ?>
                <!-- Employee list Records Section -->
                <div class="container-fluid dashboard-content" id="employeeListView">
                    <div id="surveyDashboardContainer"></div>

                <?php else: ?>
                    <?php include_once "../403.php"; ?>
                <?php endif; ?>
            </div>

            <!-- ============================================================== -->
            <!-- end wrapper  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end main wrapper  -->
        <!-- ============================================================== -->
</body>

</html>