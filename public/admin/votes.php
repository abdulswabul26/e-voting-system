<?php
// include '../includes/db.php';
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




// include '../includes/fetch_votes.php';
function getAllVotes($conn) {
    // Prepare SQL query
    $sql = "SELECT v.vote_id, v.user_id, v.candidate_id, v.voted_at, 
                   c.full_name AS full_name, u.full_name AS voter_name
            FROM votes v
            LEFT JOIN candidates c ON v.candidate_id = c.candidate_id
            LEFT JOIN users u ON v.user_id = u.user_id
            ORDER BY v.voted_at DESC";

    // Execute query
    $result = $conn->query($sql);

    // Check if records exist
    if ($result->num_rows > 0) {
    echo '<div class="overflow-x-auto">';
    echo '<table class="min-w-full border border-gray-200 rounded-lg shadow-sm">';
    echo '<thead class="bg-gray-100">';
    echo '<tr>';
    echo '<th class="py-2 px-4 border-b text-left">Vote ID</th>';
    echo '<th class="py-2 px-4 border-b text-left">Voter Name</th>';
    echo '<th class="py-2 px-4 border-b text-left">Candidate</th>';
    echo '<th class="py-2 px-4 border-b text-left">Date/Time</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr class="hover:bg-gray-50">';
        echo "<td class='py-2 px-4 border-b'>{$row['vote_id']}</td>";
        echo "<td class='py-2 px-4 border-b'>{$row['voter_name']}</td>";
        echo "<td class='py-2 px-4 border-b'>{$row['full_name']}</td>";
        echo "<td class='py-2 px-4 border-b'>{$row['voted_at']}</td>";
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}}

// getAllVotes($conn);
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
    <!-- Tailwind CDN (Playground) - for production use a built/tailored CSS file -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Small helper to visually distinguish cards on narrow screens */
    .card { background-color: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.06); }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 w-[100dvw] h-[100dvh] flex flex-col">
  


  <!-- Header -->
  <header class="bg-white shadow-sm sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center gap-4">
          <div class="font-semibold text-lg">E‑Voting System</div>
          <div class="hidden sm:block text-sm text-gray-500">Secure · Accessible · Transparent</div>
        </div>
        <div class="flex items-center gap-3">
          <div class="text-sm text-gray-600">Hello, <span class="font-medium">Admin</span></div>
          <a href="sessiondestory.php" class="px-3 py-1 rounded-md text-sm border border-red-200 text-red-700">Logout</a>
        </div>
      </div>
    </div>
    
  </header>
  <nav class="md:w-[15%] md:hidden flex-col justify-between flex justify-center items-center shadow-sm ">
            <div id="links" class="flex flex-col gap-4 w-max rounded-full m-4 bg-white py-1 px-2">
                <div class="flex flex-row md:flex-col gap-4">
                    <a href="index.php" class="block py-2 px-4 rounded hover:font-medium nav-link">Dashboard</a>
                    <a href="candidates.php" class="block py-2 px-4 rounded font-medium hover:font-medium nav-link">Candidates</a>
                    <a href="voters.php" class="block py-2 px-4 rounded hover:font-medium nav-link">Voters</a>
                    <a href="votes.php" class="block py-2 px-4 rounded hover:font-medium nav-link">Votes</a>

                </div>
            </div>
    </nav>
    <main class="flex flex-col md:flex-row px-4 md:px-10 gap-4 mt-10 overflow-y-auto h-[100vh]">
      <!-- Left sidebar (Profile & Navigation) -->
      <aside class="lg:col-span-1 md:w-[15%] md:block hidden">
        
          <nav class="card mt-4 space-y-2 p-4">
            <a href="index.php" class="block px-3 py-2 rounded-md text-sm hover:bg-gray-50">Dashboard</a>
            <a href="candidates.php" class="block px-3 py-2 rounded-md text-sm hover:bg-gray-50">Candidates</a>
            <a href="voters.php" class="block px-3 py-2 rounded-md text-sm hover:bg-gray-50">Voters</a>
            <a href="votes.php" class="block px-3 py-2 rounded-md text-sm hover:bg-gray-50">Votes</a>
          </nav>
        </div>

      </aside>

      <!-- CANDIDATES SECTION -->
         <section id="voters" class="w-full md:w-[85%] md:p-4">
  <div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Confirmed Votes</h2>
  
  <div class="flex gap-2">
    <!-- Search Input -->
  </div>
</div>


    <!-- Voters Table -->
        <?php getAllVotes($conn);
; ?>
    <br>
   
  </div>

  
</section>
    
  </main>



    

        <footer class="max-w-7xl mx-auto p-4 text-xs text-gray-500">
    <div class="flex justify-between">
      <div>© <?= date('Y') ?> Electoral Commission</div>
      <div>Privacy · Terms · Contact</div>
    </div>
  </footer>
  
</body>
</html>