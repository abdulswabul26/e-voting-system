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

// Total candidates
$totalResult = $conn->query("SELECT COUNT(*) as total FROM candidates");
$totalRow = $totalResult->fetch_assoc();
$totalCandidates = $totalRow['total'];
$totalPages = ceil($totalCandidates / $limit);

// Fetch candidates
$sql = "SELECT * FROM candidates ORDER BY candidate_id DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<div class="overflow-x-auto">
  <table class="min-w-full border border-gray-200">
    <thead class="bg-gray-100">
      <tr>
        <th class="py-2 px-4 border-b">No</th>
        <th class="py-2 px-4 border-b">Photo</th>
        <th class="py-2 px-4 border-b">Full Name</th>
        <th class="py-2 px-4 border-b">Reg No</th>
        <th class="py-2 px-4 border-b">Department</th>
        <th class="py-2 px-4 border-b">Votes</th>
        <th class="py-2 px-4 border-b">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = $offset + 1;
      while ($row = $result->fetch_assoc()) {
          // Get total votes for this candidate
          $votesQuery = $conn->prepare("SELECT COUNT(*) as total_votes FROM votes WHERE candidate_id = ?");
          $votesQuery->bind_param("i", $row['candidate_id']);
          $votesQuery->execute();
          $votesResult = $votesQuery->get_result();
          $votesRow = $votesResult->fetch_assoc();
          $totalVotes = $votesRow['total_votes'] ?? 0;
          $votesQuery->close();

          echo "<tr class='border-b'>
                  <td class='py-2 px-4'>{$i}</td>
                  <td class='py-2 px-4'>
                    <img src='../{$row['photo_url']}' alt='Photo' class='h-12 w-12 object-cover rounded-full'>
                  </td>
                  <td class='py-2 px-4'>{$row['full_name']}</td>
                  <td class='py-2 px-4'>{$row['reg_no']}</td>
                  <td class='py-2 px-4'>{$row['department']}</td>
                  <td class='py-2 px-4 text-green-600 font-medium'>{$totalVotes}</td>
                  <td class='py-2 px-4 text-center'>
                    <button class='viewCandidate text-blue-600 hover:underline'
                      data-name='{$row['full_name']}'
                      data-reg='{$row['reg_no']}'
                      data-department='{$row['department']}'
                      data-photo='{$row['photo_url']}'
                      data-votes='{$totalVotes}'>View</button>
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
