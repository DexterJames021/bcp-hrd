<?php
  require "../../config/db_talent.php";
// Get applicant ID from the URL
$applicant_id = $_GET['id'];
?>
<input type="hidden" name="applicant_id" value="<?php echo $applicant_id; ?>">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Submission</title>
    <style>
        /* General Styles */

        /* Import Poppins Font */
        @font-face {
            font-family: 'Poppins';
            src: url('../../assets/vendor/fonts/Poppins/Poppins-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('../../assets/vendor/fonts/Poppins/Poppins-Bold.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
    overflow-y: auto;

            background: url('../../assets/images/bcp1.jpg') repeat center center/cover;
        }

        /* Centered Container */
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
        }

        /* Heading */
        h1 {
            color: #007bff;
            font-weight: 600;
            margin-bottom: 20px;
        }

        h2 {
            color: #007bff;
            font-weight: 600;
            margin-top: 20px;
        }

        /* Paragraph */
        p {
            color: #333;
            font-size: 16px;
            font-weight: 400;
            margin-bottom: 20px;
        }

        /* List of Required Documents */
        ul {
            list-style-type: none;
            padding-left: 0;
            text-align: left;
            margin: 10px auto;
            width: 80%;
        }

        ul li {
            font-size: 1em;
            margin: 8px 0;
            color: #333;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        label {
            font-size: 1.1em;
            margin-bottom: 10px;
            color: #333;
        }

        input[type="file"] {
            padding: 10px;
            font-size: 1em;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        /* Button Styling */
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
            display: inline-block;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Table Styling */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        td a {
            color: #007bff;
            text-decoration: none;
        }

        td a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>DOCUMENT SUBMISSION</h1>

        <h2>Required Documents</h2>
        <p>Please ensure that you submit the following documents:</p>
        <ul>
            <li><strong>Valid Government-issued ID</strong> (e.g., Passport, Driver's License, or National ID)</li>
            <li><strong>Updated Resume or Curriculum Vitae (CV)</strong></li>
            <li><strong>Proof of Address</strong> (e.g., Utility Bill, Bank Statement, Lease Agreement)</li>
            <li><strong>Recent Passport-sized Photo</strong></li>
            <li><strong>Any Certifications or Licenses relevant to the position</strong></li>
            <li><strong>Academic Transcripts or Diplomas</strong> (if applicable)</li>
            <li><strong>NBI Clearance</strong> (National Bureau of Investigation Clearance)</li>
        </ul>

        <form action="recruitment/submit_document.php?id=<?php echo $applicant_id; ?>" method="POST" enctype="multipart/form-data">

    <?php
    $applicant_id = $_GET['id'];
    ?>
    <input type="hidden" name="applicant_id" value="<?php echo $applicant_id; ?>">

    <label for="document">Upload Document (PDF, Word, etc.):</label>
    <input type="file" name="document" id="document" required><br><br>

    <input type="submit" class="btn-primary" value="Submit Document">
</form>


        <h2>Previously Uploaded Documents</h2>
        <table>
            <thead>
                <tr>
                    <th>Document Name</th>
                    <th>Upload Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    <!-- Table data will be populated by PHP -->
    <?php
        // Include database connection
        // Fetch uploaded documents for the applicant
        $applicant_id = $_GET['id']; // Assuming the applicant ID is passed in the URL
        $query = "SELECT * FROM document_submissions WHERE applicant_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $applicant_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . basename($row['document']) . "</td>";
            echo "<td>" . date("F d, Y", strtotime($row['submission_date'])) . "</td>";
            echo "<td>";
            // Corrected Delete button with red styling (Bootstrap 'btn-danger')
            echo '<a href="recruitment/delete_document.php?id=' . $row['id'] . '&file=' . urlencode($row['document']) . '" 
                  class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this document?\')">Delete</a>';
            echo "</td>";
            echo "</tr>";
        }
    ?>
</tbody>

        </table>
    </div>
</body>
</html>
