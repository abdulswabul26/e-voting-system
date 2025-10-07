<?php
// import_voters.php

// Include database connection
// include '../includes/dbconnect.php';

$servername = "localhost";  
$username = "root";
$password = "";
$dbname = "evotingdb";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    // echo "Connected successfully";
} 

// Check if a file was uploaded
if (isset($_FILES['voters_csv']) && $_FILES['voters_csv']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['voters_csv']['tmp_name'];
    $fileName = $_FILES['voters_csv']['name'];
    $fileSize = $_FILES['voters_csv']['size'];
    $fileType = $_FILES['voters_csv']['type'];
    
    // Open the CSV file
    if (($handle = fopen($fileTmpPath, 'r')) !== false) {
        $rowCount = 0;
        $inserted = 0;

        // Skip the header row
        $header = fgetcsv($handle, 1000, ",");

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $rowCount++;
            // Assuming CSV columns: full_name, reg_no, email, department, status
            $full_name  = mysqli_real_escape_string($conn, $data[0]);
            $reg_no     = mysqli_real_escape_string($conn, $data[1]);
            $email      = mysqli_real_escape_string($conn, $data[2]);
            $department = mysqli_real_escape_string($conn, $data[3]);

            // Insert into database
            $sql = "INSERT INTO users (full_name, reg_no, email, department)
                    VALUES ('$full_name', '$reg_no', '$email', '$department')";

            try {
                // Assuming $sql is already defined
                if (mysqli_query($conn, $sql)) {
                    $inserted++;
                }
            } catch (mysqli_sql_exception $e) {
                // Handle error
                echo "Error inserting record: " . $e->getMessage();
            }
        }

        fclose($handle);

        echo "<script>alert('CSV Imported: $inserted/$rowCount voters added.'); window.location='index.php#voters';</script>";
    } else {
        echo "<script>alert('Error opening CSV file.'); window.location='index.php#voters';</script>";
    }
} else {
    echo "<script>alert('No file uploaded or upload error.'); window.location='index.php#voters';</script>";
}
?>
