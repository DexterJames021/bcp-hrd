<!-- home -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCP HRD</title>

    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">BCP: <span class="text-warning">HRD</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto float-end">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./pages/jobs.php">Job Opportunities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./pages/about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./auth/index.php">Sign in</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center bg-primary text-white">
                <div class="m-5 ">
                    <h1>
                        <span>Be</span> <br>
                        <span>Part of our</span> <br>
                        <span class="">Team</span>
                    </h1>
                </div>
            </div>
            <div class="col-md-6 p-0">
                <!-- Placeholder for carousel -->
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://via.placeholder.com/800x400" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/800x400" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/800x400" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Opportunities Section -->
    <section class="container my-5">
        <h2 class="text-center mb-4">Job Opportunities</h2>
        <div class="row">
            <div class="card col-md-3 p-2 mx-1 text-center">
                <div class="card-body">
                    <p>Job Position 1</p>
                </div>
            </div>
            <div class="card col-md-3 p-2 mx-1 text-center">
                <div class="card-body">
                    <p>Job Position 2</p>
                </div>
            </div>
            <div class="card col-md-3 p-2 mx-1 text-center">
                <div class="card-body">
                    <p>Job Position 3</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Us Section -->
    <div class="container-fluid bg-primary text-white p-5">
        <div class="row">
            <div class="col-12 text-center">
                <h3>Contact Us</h3>
                <p>For more information, reach out to us at: <a href="mailto:info@bcp.com" class="text-white">info@bcp.com</a></p>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start">
        <div class="container p-4">
            <div class="row">
                <!-- Company Information -->
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">About BCP HRD</h5>
                    <p>
                        BCP HRD is dedicated to providing top-notch human resource development services. We connect talent with opportunities, ensuring mutual growth and success.
                    </p>
                </div>
                <!-- Links -->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Quick Links</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="#" class="text-dark">Home</a></li>
                        <li><a href="#" class="text-dark">Job Opportunities</a></li>
                        <li><a href="#" class="text-dark">Application</a></li>
                        <li><a href="#" class="text-dark">About Us</a></li>
                    </ul>
                </div>
                <!-- Social Media -->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Follow Us</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-dark">Facebook</a></li>
                        <li><a href="#" class="text-dark">Twitter</a></li>
                        <li><a href="#" class="text-dark">LinkedIn</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Copyright -->
        <div class="text-center p-3 bg-dark text-white">
            © 2024 BCP HRD. All rights reserved.
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>