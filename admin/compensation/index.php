<!-- training main dashboard -->
<!-- <?php
require "../../config/Database.php";
require '../../auth/accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);

// $dsn = 'mysql:host=localhost;port=3308;dbname=bcp-hrd;charset=utf8mb4'; // Change port if needed
// $username = 'root';  // Your MySQL username
// $password = '';  // Your MySQL password

// Include the database configuration
require('../../config/Database.php');

//insert holiday
if (isset($_POST['add'])) {
    $holiday = $_POST['holiday'];
    $type = $_POST['type'];
    $date = $_POST['date'];

    // Insert the new holiday into the database
    $stmt = $conn->prepare("INSERT INTO holiday (holiday, type, date) VALUES (:holiday, :type, :date)");
    $stmt->bindParam(':holiday', $holiday, PDO::PARAM_STR);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Holiday added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to add holiday. Please try again.</div>";
    }
}

try {
    // Pagination settings
    $recordsPerPage = 5;
    $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $offset = ($currentPage - 1) * $recordsPerPage;

    // Get total number of records
    $totalStmt = $conn->query("SELECT COUNT(*) FROM holiday");
    $totalRecords = $totalStmt->fetchColumn();
    $totalPages = ceil($totalRecords / $recordsPerPage);

    // Fetch paginated holidays
    $stmt = $conn->prepare("SELECT * FROM holiday ORDER BY date ASC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $recordsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $holidays = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM holiday WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        header("Location: index.php?deleted=1");
        exit();
    }
}

// Handle update action
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $holiday = $_POST['holiday'];
    $type = $_POST['type'];
    $date = $_POST['date'];

    $stmt = $conn->prepare("UPDATE holiday SET holiday = :holiday, type = :type, date = :date WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':holiday', $holiday, PDO::PARAM_STR);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);

    if ($stmt->execute()) {
        header("Location: index.php?updated=1");
        exit();
    }
}

?> -->
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- icon -->
    <link rel="shortcut icon" href="../../assets/images/bcp-hrd-logo.jpg" type="image/x-icon">

    <script defer src="../../node_modules/jquery/dist/jquery.min.js"></script>

    <!-- bs -->
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script defer src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- jquery -->
    <script defer src="../../node_modules/jquery/dist/jquery.js"></script>

    <!-- global JavaScript -->
    <script defer type="module" src="../../assets/libs/js/global-script.js"></script>

    <!-- main js -->
    <script defer type="module" src="../../assets/libs/js/main-js.js"></script>
    <link rel="stylesheet" href="../../assets/libs/css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- assts csss -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">

    <!-- slimscroll js -->
    <script defer type="module" src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <title>Admin Dashboard</title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <?php include '../sideandnavbar.php'; ?>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
      
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <!-- <div class="dashboard-ecommerce"> -->
            <div class="container-fluid dashboard-content ">
                <!-- ============================================================== -->
                <!-- pageheader  -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
 
                            <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel
                                mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                        </li>
                                        <!-- <li class="breadcrumb-item active" aria-current="page">Dashboard</li> -->
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader  -->
                <!-- ============================================================== -->
                <!-- <div class="ecommerce-widget"> -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h2 class="text-center">📅 Philippine Holidays 2025</h2>

                                <!-- Success/Error Messages -->
                                <?php if (isset($_GET['deleted'])): ?>
                                    <div class="alert alert-success">Holiday deleted successfully!</div>
                                <?php elseif (isset($_GET['updated'])): ?>
                                    <div class="alert alert-success">Holiday updated successfully!</div>
                                <?php endif; ?>
<div class="table-responsive">
                                <!-- Table to display holidays -->
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="color: black;">ID</th>
                                            <th style="color: black;">Holiday</th>
                                            <th style="color: black;">Type</th>
                                            <th style="color: black;">Date</th>
                                            <th style="color: black;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($holidays)): ?>
                                            <tr>
                                                <td colspan="5">No holidays found.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($holidays as $holiday): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($holiday['id']) ?></td>
                                                    <td><?= htmlspecialchars($holiday['holiday']) ?></td>
                                                    <td><?= htmlspecialchars($holiday['type']) ?></td>
                                                    <td><?= htmlspecialchars($holiday['date']) ?></td>
                                                    <td>
                                                        <!-- Edit button -->
                                                        <button type="button" class="btn btn-sm btn-warning"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal<?= $holiday['id'] ?>">Edit</button>

                                                        <!-- Delete button -->
                                                        <a href="index.php?delete_id=<?= $holiday['id'] ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this holiday?');">Delete</a>
                                                    </td>
                                                </tr>

                                                <!-- Modal for editing holiday -->
                                                <div class="modal fade" id="editModal<?= $holiday['id'] ?>" tabindex="-1"
                                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editModalLabel">Edit Holiday</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post">
                                                                    <input type="hidden" name="id"
                                                                        value="<?= $holiday['id'] ?>">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Holiday Name</label>
                                                                        <input type="text" name="holiday" class="form-control"
                                                                            value="<?= htmlspecialchars($holiday['holiday']) ?>"
                                                                            required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Type</label>
                                                                        <select name="type" class="form-control" required>
                                                                            <option value="Regular"
                                                                                <?= $holiday['type'] === 'Regular' ? 'selected' : '' ?>>Regular</option>
                                                                            <option value="Non-Working"
                                                                                <?= $holiday['type'] === 'Non-Working' ? 'selected' : '' ?>>Non-Working</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Date</label>
                                                                        <input type="date" name="date" class="form-control"
                                                                            value="<?= $holiday['date'] ?>" required>
                                                                    </div>
                                                                    <button type="submit" name="update"
                                                                        class="btn btn-primary">Update Holiday</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                </div>

                                <!-- Pagination Links -->
                                <?php if ($totalPages > 1): ?>
                                    <div class="pagination-container mt-4">
                                        <ul class="pagination justify-content-center">

                                            <!-- Previous Button -->
                                            <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                                <a class="page-link"
                                                    href="?page=<?= max(1, $currentPage - 1) ?>">Previous</a>
                                            </li>

                                            <!-- Page Number Links -->
                                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                <li class="page-item <?= $currentPage == $i ? 'active' : '' ?>">
                                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>

                                            <!-- Next Button -->
                                            <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                                                <a class="page-link"
                                                    href="?page=<?= min($totalPages, $currentPage + 1) ?>">Next</a>
                                            </li>

                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="index.php">
                                    <div class="mb-3">
                                        <label class="form-label">Holiday Name</label>
                                        <input type="text" name="holiday" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Type</label>
                                        <select name="type" class="form-control" required>
                                            <option value="Regular">Regular</option>
                                            <option value="Non-Working">Non-Working</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Date</label>
                                        <input type="date" name="date" class="form-control" required>
                                    </div>
                                    <button type="submit" name="add" class="btn btn-primary">Add Holiday</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>



        <!-- </div> -->
    </div>
    <!-- </div> -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <!-- <div class="footer mx-2">
                <div class="container-fluid mx-2">
                    <div class="row">
                        <div class="col-xl-7 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
    <!-- ============================================================== -->
    <!-- end footer -->
    <!-- ============================================================== -->
    
    <!-- ============================================================== -->
    <!-- end wrapper  -->
    <!-- ============================================================== -->
    
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
</body>

</html>