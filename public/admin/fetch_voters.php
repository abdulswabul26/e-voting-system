<?php
// Database connection
$servername = "localhost";  
$username = "root";
$password = "";
$dbname = "evotingdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination settings
$limit = 20;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Get total non-admin users
$totalResult = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role != 'admin'");
$totalRow = mysqli_fetch_assoc($totalResult);
$totalUsers = $totalRow['total'];
$totalPages = ceil($totalUsers / $limit);

// Fetch non-admin users for current page
$sql = "SELECT * FROM users WHERE role != 'admin' ORDER BY user_id DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);
?>

<div class="overflow-x-auto">
  <table class="min-w-full border border-gray-200">
    <thead class="bg-gray-100">
      <tr>
        <th class="py-2 px-4 border-b">#</th>
        <th class="py-2 px-4 border-b">Full Name</th>
        <th class="py-2 px-4 border-b">Reg No</th>
        <th class="py-2 px-4 border-b">Email</th>
        <th class="py-2 px-4 border-b">Department</th>
        <th class="py-2 px-4 border-b">Status</th>
        <th class="py-2 px-4 border-b">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = $offset + 1;
      while ($row = mysqli_fetch_assoc($result)) {
          $statusText = ($row['status'] == 1) ? "Submitted" : "Pending";

          echo "<tr class='border-b'>
                  <td class='py-2 px-4'>{$i}</td>
                  <td class='py-2 px-4'>{$row['full_name']}</td>
                  <td class='py-2 px-4'>{$row['reg_no']}</td>
                  <td class='py-2 px-4'>{$row['email']}</td>
                  <td class='py-2 px-4'>{$row['department']}</td>
                  <td class='py-2 px-4 text-green-600 font-medium'>{$statusText}</td>
                  <td class='py-2 px-4 text-center'>
                    <button class='viewVoter text-blue-600 hover:underline'
                      data-name='{$row['full_name']}'
                      data-reg='{$row['reg_no']}'
                      data-district='{$row['department']}'
                      data-status='{$statusText}'
                      data-email='{$row['email']}'>View</button>
                  </td>
                </tr>";
          $i++;
      }
      ?>
    </tbody>
  </table>
</div>

<!-- Pagination -->
<div class="mt-4 flex justify-center space-x-2">
  <?php for ($p = 1; $p <= $totalPages; $p++): ?>
    <a href="?page=<?= $p ?>" 
       class="px-3 py-1 border rounded <?= $p == $page ? 'bg-blue-600 text-white' : 'bg-white text-blue-600' ?>">
      <?= $p ?>
    </a>
  <?php endfor; ?>
</div>
