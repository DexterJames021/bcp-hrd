<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
        }
        .bg {
            /* background-color: #f8d7da; */
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            text-align: center;
        }
        .error-code {
            font-size: 5rem;
            /* font-weight: bold; */
        }
        .error-message {
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="bg">
        <div class="container">
            <h1 class="error-code">403</h1>
            <div class="error-message">Forbidden</div>
            <p class="lead">You don't have permission to access this page.</p>
            <a href="http://localhost/bcp-hrd/admin/" class="btn btn-primary">Go to Homepage</a>
        </div>
    </div>
</body>
</html>