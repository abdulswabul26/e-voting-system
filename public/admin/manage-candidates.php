<?php
include '../includes/db.php';

// Create / Update Candidate
if (isset($_POST['save'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $position = $_POST['position'];
  $party = $_POST['party'];

  if ($id) {
    // Update
    $query = "UPDATE candidates SET name='$name', position='$position', party='$party' WHERE id='$id'";
  } else {
    // Insert
    $query = "INSERT INTO candidates (name, position, party) VALUES ('$name', '$position', '$party')";
  }

  mysqli_query($conn, $query);
  header("Location: admin_panel.php#candidates");
  exit();
}

// Delete Candidate
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM candidates WHERE id='$id'");
  header("Location: admin_panel.php#candidates");
  exit();
}
?>
