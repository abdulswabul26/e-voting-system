<?php
session_start();
include '../../includes/db.php'; // Adjust path to your DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    // Sanitize inputs
    $candidate_id = !empty($_POST['candidate_id']) ? intval($_POST['candidate_id']) : null;
    $full_name = trim($_POST['full_name']);
    $reg_no = trim($_POST['reg_no']);
    $department = trim($_POST['department']);

    $photo_url = null;

    // If editing, get existing photo URL
    if ($candidate_id) {
        $stmt = $conn->prepare("SELECT photo_url FROM candidates WHERE candidate_id = ?");
        $stmt->bind_param("i", $candidate_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $photo_url = $row['photo_url']; // Keep existing photo if not changed
        $stmt->close();
    }

    // Handle new photo upload
    if (isset($_FILES['photo_url']) && $_FILES['photo_url']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['photo_url']['tmp_name'];
        $fileName = $_FILES['photo_url']['name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];

        if (!in_array($fileExt, $allowed)) {
            die("Invalid file type. Allowed: jpg, jpeg, png, gif");
        }

        $newFileName = uniqid('candidate_', true) . "." . $fileExt;
        $uploadDir = '../../public/assets/uploads/candidates/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $destPath = $uploadDir . $newFileName;
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // Store URL relative to your public folder
            $photo_url = '../public/assets/uploads/candidates/' . $newFileName;
        } else {
            die("Failed to upload photo");
        }
    }

    // Insert new candidate
    if (is_null($candidate_id)) {
        $stmt = $conn->prepare("INSERT INTO candidates (full_name, reg_no, department, photo_url, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $full_name, $reg_no, $department, $photo_url);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Candidate added successfully!";
        } else {
            $_SESSION['error'] = "Failed to add candidate: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Update existing candidate
        $stmt = $conn->prepare("UPDATE candidates SET full_name=?, reg_no=?, department=?, photo_url=? WHERE candidate_id=?");
        $stmt->bind_param("ssssi", $full_name, $reg_no, $department, $photo_url, $candidate_id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Candidate updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update candidate: " . $stmt->error;
        }
        $stmt->close();
    }

    // Redirect back to candidates page
    header("Location: ../admin/candidates.php");
    exit();
} else {
    die("Invalid request");
}
?>
