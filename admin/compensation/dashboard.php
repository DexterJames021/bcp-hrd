<!-- training main dashboard -->
 <?php
require "../../config/Database.php";
require '../../auth/accesscontrol.php';

$userData = getUserRoleAndPermissions($_SESSION['user_id'], $conn);
access_log($userData);


// Initialize variables for displaying messages
$message = '';
$success = false;

try {
    // Handle form submission for adding new entry (Create)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['create'])) {
            $date = $_POST['date'];
            $min_salary = $_POST['min_salary'];
            $max_salary = $_POST['max_salary'];
            $position = $_POST['position'];

            // Insert new data into the database
            $stmt = $conn->prepare("INSERT INTO `average_rates` (`date`, `min_salary`, `max_salary`, `position`) VALUES (?, ?, ?, ?)");
            $stmt->execute([$date, $min_salary, $max_salary, $position]);

            $message = "Data added successfully!";
            $success = true;
        }

        // Handle form submission for updating entry (Update)
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $date = $_POST['date'];
            $min_salary = $_POST['min_salary'];
            $max_salary = $_POST['max_salary'];
            $position = $_POST['position'];

            // Update data in the database
            $stmt = $conn->prepare("UPDATE `average_rates` SET `date` = ?, `min_salary` = ?, `max_salary` = ?, `position` = ? WHERE `id` = ?");
            $stmt->execute([$date, $min_salary, $max_salary, $position, $id]);

            $message = "Data updated successfully!";
            $success = true;
        }

        // Handle form submission for deleting entry (Delete)
        if (isset($_POST['delete'])) {
            $id = $_POST['id'];

            // Delete data from the database
            $stmt = $conn->prepare("DELETE FROM `average_rates` WHERE `id` = ?");
            $stmt->execute([$id]);

            $message = "Data deleted successfully!";
            $success = true;
        }
    }

    // Define records per page
    $recordsPerPage = 10;

    // Calculate total number of records
    $stmt = $conn->query("SELECT COUNT(*) FROM `average_rates`");
    $totalRecords = $stmt->fetchColumn();

    // Calculate total pages
    $totalPages = ceil($totalRecords / $recordsPerPage);

    // Get current page from URL (default to page 1)
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // Ensure current page is within valid range
    if ($currentPage < 1) {
        $currentPage = 1;
    } elseif ($currentPage > $totalPages) {
        $currentPage = $totalPages;
    }

    // Calculate offset for the SQL query
    $offset = ($currentPage - 1) * $recordsPerPage;

    // Fetch records for the current page
    $stmt = $conn->prepare("SELECT `id`, `date`, `min_salary`, `max_salary`, `position` FROM `average_rates` LIMIT ?, ?");
    $stmt->bindParam(1, $offset, PDO::PARAM_INT);
    $stmt->bindParam(2, $recordsPerPage, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


//salary data chart
try {
    // Database query to fetch data
    $stmt = $conn->query("SELECT `id`, `date`, `min_salary`, `max_salary`, `position` FROM `average_rates` WHERE 1");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare data for chart
    $dates = [];
    $min_salaries = [];
    $max_salaries = [];
    $positions = [];

    foreach ($data as $row) {
        $dates[] = $row['date'];
        $min_salaries[] = $row['min_salary'];
        $max_salaries[] = $row['max_salary'];
        $positions[] = $row['position']; // Store the position in the array
    }

    // Get unique positions for the dropdown
    $unique_positions = array_unique($positions);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
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
     <script defer src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- jquery -->
    <script defer src="../../node_modules/jquery/dist/jquery.js"></script>

    <!-- global JavaScript -->
    <script defer type="module" src="../../assets/libs/js/global-script.js"></script>

    <!-- main js -->
    <script defer type="module" src="../../assets/libs/js/main-js.js"></script>
    <link rel="stylesheet" href="../../assets/libs/css/style.css">

    <!-- assts csss -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">

    <!-- slimscroll js -->
    <script defer type="module" src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
    <link rel="stylesheet" href="css/dashboard.css">
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
                            <h2 class="pageheader-title">Dashboard</h2>

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
                                <!-- <h5 class="text-muted">Salary Data</h5> -->

                                <!-- <h1 class="mb-1">Schedule</h1> -->

                                <h2>Salary Overview - Min & Max Salary Trends</h2>

                                <div class="form-group">
                                    <label for="positionSelect">Select Position:</label>
                                    <select id="positionSelect" class="form-control">
                                        <option value="">All Positions</option>
                                        <?php foreach ($unique_positions as $position): ?>
                                            <option value="<?= htmlspecialchars($position) ?>">
                                                <?= htmlspecialchars($position) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Chart Container -->
                                <div class="chart-container">
                                    <canvas id="salaryChart"></canvas>
                                </div>

                                <div class="footer">
                                    <p>&copy; 2025 Your Company. All rights reserved.</p>
                                </div>


                                <script>
                                    // Initial Data for the chart
                                    var allData = <?php echo json_encode($data); ?>;

                                    // Function to filter data based on selected position
                                    function filterData(position) {
                                        if (position === '') {
                                            return allData; // If no position is selected, return all data
                                        }
                                        return allData.filter(function (item) {
                                            return item.position === position;
                                        });
                                    }

                                    // Function to update the chart with filtered data
                                    function updateChart(position) {
                                        var filteredData = filterData(position);
                                        var dates = filteredData.map(function (item) { return item.date; });
                                        var minSalaries = filteredData.map(function (item) { return item.min_salary; });
                                        var maxSalaries = filteredData.map(function (item) { return item.max_salary; });

                                        salaryChart.data.labels = dates;
                                        salaryChart.data.datasets[0].data = minSalaries;
                                        salaryChart.data.datasets[1].data = maxSalaries;
                                        salaryChart.update();
                                    }

                                    // Initial chart setup
                                    var ctx = document.getElementById('salaryChart').getContext('2d');
                                    var salaryChart = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: <?php echo json_encode($dates); ?>, // Dates
                                            datasets: [{
                                                label: 'Min Salary',
                                                data: <?php echo json_encode($min_salaries); ?>, // Min Salary Data
                                                borderColor: '#4caf50', // Green for min salary
                                                backgroundColor: 'rgba(76, 175, 80, 0.2)',
                                                fill: true,
                                                tension: 0.4
                                            }, {
                                                label: 'Max Salary',
                                                data: <?php echo json_encode($max_salaries); ?>, // Max Salary Data
                                                borderColor: '#f44336', // Red for max salary
                                                backgroundColor: 'rgba(244, 67, 54, 0.2)',
                                                fill: true,
                                                tension: 0.4
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            interaction: {
                                                mode: 'index',
                                                intersect: false
                                            },
                                            scales: {
                                                x: {
                                                    title: {
                                                        display: true,
                                                        text: 'Date'
                                                    },
                                                    grid: {
                                                        display: false
                                                    }
                                                },
                                                y: {
                                                    title: {
                                                        display: true,
                                                        text: 'Salary (in Pesos)'
                                                    },
                                                    grid: {
                                                        color: '#ddd'
                                                    }
                                                }
                                            },
                                            plugins: {
                                                tooltip: {
                                                    backgroundColor: '#333',
                                                    titleColor: '#fff',
                                                    bodyColor: '#fff',
                                                    borderColor: '#4caf50',
                                                    borderWidth: 1,
                                                    padding: 10
                                                }
                                            }
                                        }
                                    });

                                    // Event listener to update chart when position is selected
                                    document.getElementById('positionSelect').addEventListener('change', function () {
                                        var selectedPosition = this.value;
                                        updateChart(selectedPosition);
                                    });
                                </script>

                                <!-- Bootstrap JS and dependencies -->
                                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                                <script
                                    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
                                <script
                                    src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>



                            </div>
                            <div id="sparkline-revenue"></div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                   
                                    
                                   
        <h2>Manage Average Rates</h2>

        <!-- Display messages (Success/Error) -->
        <?php if ($message): ?>
            <div class="alert alert-<?= $success ? 'success' : 'danger' ?>"><?= $message ?></div>
        <?php endif; ?>

        <!-- Form to Create or Update -->
        <form method="POST">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="min_salary">Min Salary</label>
                    <input type="number" id="min_salary" name="min_salary" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="max_salary">Max Salary</label>
                    <input type="number" id="max_salary" name="max_salary" class="form-control" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="position">Position</label>
                    <input type="text" id="position" name="position" class="form-control" required>
                </div>
            </div>

            <!-- Buttons for Create/Update -->
            <button type="submit" name="create" class="btn btn-primary">Add New Entry</button>
        </form>

        <hr>

        <!-- Table to display all records -->
        <h3>Existing Entries</h3>
        <div class="table-responsive">
    <!-- Table to Display Data -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th style="color:black">Date</th>
            <th style="color:black">Min Salary</th>
            <th style="color:black">Max Salary</th>
            <th style="color:black">Position</th>
            <th style="color:black">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['date']) ?></td>
                <td><?= htmlspecialchars($row['min_salary']) ?></td>
                <td><?= htmlspecialchars($row['max_salary']) ?></td>
                <td><?= htmlspecialchars($row['position']) ?></td>
                <td>
                    <!-- Edit Button (Triggers Modal) -->
                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal" 
                            data-id="<?= $row['id'] ?>" data-date="<?= $row['date'] ?>" 
                            data-min_salary="<?= $row['min_salary'] ?>" data-max_salary="<?= $row['max_salary'] ?>" 
                            data-position="<?= $row['position'] ?>">Edit</button>

                    <!-- Delete Form -->
                    <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this?');">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination">
        <li class="page-item <?= ($currentPage == 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=1">First</a>
        </li>
        <li class="page-item <?= ($currentPage == 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $currentPage - 1 ?>">Previous</a>
        </li>

        <!-- Display page numbers -->
        <?php for ($page = 1; $page <= $totalPages; $page++): ?>
            <li class="page-item <?= ($page == $currentPage) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $page ?>"><?= $page ?></a>
            </li>
        <?php endfor; ?>

        <li class="page-item <?= ($currentPage == $totalPages) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Next</a>
        </li>
        <li class="page-item <?= ($currentPage == $totalPages) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $totalPages ?>">Last</a>
        </li>
    </ul>
</nav>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Entry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="updateId">
                        <div class="form-group">
                            <label for="updateDate">Date</label>
                            <input type="date" id="updateDate" name="date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="updateMinSalary">Min Salary</label>
                            <input type="number" id="updateMinSalary" name="min_salary" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="updateMaxSalary">Max Salary</label>
                            <input type="number" id="updateMaxSalary" name="max_salary" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="updatePosition">Position</label>
                            <input type="text" id="updatePosition" name="position" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Fill in modal fields when editing an entry
        $('#updateModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var date = button.data('date');
            var min_salary = button.data('min_salary');
            var max_salary = button.data('max_salary');
            var position = button.data('position');

            $('#updateId').val(id);
            $('#updateDate').val(date);
            $('#updateMinSalary').val(min_salary);
            $('#updateMaxSalary').val(max_salary);
            $('#updatePosition').val(position);
        });
    </script>
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