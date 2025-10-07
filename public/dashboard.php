<?php
include '../includes/db.php';
// voter_dashboard.php
// Single-file demo: PHP + HTML + Tailwind CSS responsive voter dashboard
// NOTE: This is a starting point. For production, connect to a secure backend, DB, and add strong audit logging.
session_start();


// --- Demo user & election data (replace with DB queries in production) ---
// Fetch user info from DB using session user_id

$user = [];

if (!empty($_SESSION['user_id'])) {
    // Prepare statement
    $stmt = $conn->prepare("SELECT user_id, reg_no, full_name, email, department FROM users WHERE user_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();

        // Fetch results
        $stmt->bind_result($user_id, $reg_no, $full_name, $email, $department);
        if ($stmt->fetch()) {
            $user = [
                'user_id' => $user_id,
                'voter_id' => $reg_no,
                'name' => $full_name,
                'email' => $email,
                'department' => $department
            ];
        }

        $stmt->close();
    } else {
        // Handle prepare error
        error_log("MySQLi prepare failed: " . $conn->error);
    }
}


// intentionally left out - PHP label mistake removed
$election = [
    'title' => '2025 Guild Elections',
    'date' => '2025-10-05',
    'status' => 'open', // values: open, closed, upcoming
];

// sample candidates
$candidates = [];
$sql = "SELECT candidate_id, full_name, department, photo_url FROM candidates ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $candidates[] = [
            'id' => $row['candidate_id'],
            'name' => $row['full_name'],
            'department' => $row['department'],
            'photo_url' => $row['photo_url']
        ];
    }
}
// echo "<pre>";
// print_r($candidates);
// echo "</pre>";

$messages = [];


// helper to get candidate by id
function getCandidateById($candidates, $id) {
    foreach ($candidates as $c) if ($c['id'] === $id) return $c;
    return null;
}

$hasVoted = !empty($_SESSION['voted']);
$receipt = $_SESSION['vote_receipt'] ?? null;

// print_r($receipt);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Voter Dashboard — <?= htmlspecialchars($election['title']) ?></title>
  <!-- Tailwind CDN (Playground) - for production use a built/tailored CSS file -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Small helper to visually distinguish cards on narrow screens */
    .card { background-color: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.06); }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Header -->
  <header class="bg-white shadow-sm sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center gap-4">
          <div class="font-semibold text-lg">E‑Voting System</div>
          <div class="hidden sm:block text-sm text-gray-500">Secure · Accessible · Transparent</div>
        </div>
        <div class="flex items-center gap-3">
          <div class="text-sm text-gray-600">Hello, <span class="font-medium"><?php echo $user["name"]?></span></div>
          <a href="../includes/sessiondestory.php" class="px-3 py-1 rounded-md text-sm border border-red-200 text-red-700">Logout</a>
        </div>
      </div>
    </div>
  </header>

  <main class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
      <!-- Left sidebar (Profile & Navigation) -->
      <aside class="lg:col-span-1">
        <div class="card p-4">
          <div class="flex items-center gap-3">
            <div class="h-12 w-12 rounded-full flex items-center justify-center text-indigo-700 font-semibold">A</div>
            <div>
              <div class="font-medium"><?php echo $user["name"]?></div>
              <div class="text-xs text-gray-500">ID: <?php echo $user["voter_id"]?></div>
            </div>
          </div>

          <hr class="my-3">
          <div class="text-sm text-gray-600">
            <div><strong>Department:</strong> <?php echo $user["name"]?></div>
            <div class="mt-2"><strong>Last login:</strong> <?= date('Y-m-d H:i') ?></div>
          </div>

          <nav class="mt-4 space-y-2">
            <a href="#dashboard" class="block px-3 py-2 rounded-md text-sm hover:bg-gray-50">Dashboard</a>
            <a href="#ballot" class="block px-3 py-2 rounded-md text-sm hover:bg-gray-50">Ballot Preview</a>
          </nav>
        </div>

      </aside>

      <!-- Main content area -->
      <section class="lg:col-span-3">
        <!-- Election Info -->
        <div id="dashboard" class="card p-4">
          <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
              <div class="text-lg font-semibold">Election Title</div>
              <div class="text-sm text-gray-500">Election date: xxxx/xx/xx</div>
            </div>
            <div class="flex items-center gap-3">
              <?php if ($election['status'] === 'open') : ?>
                <div class="px-3 py-1 rounded-full text-sm bg-green-50 text-green-700">Open to vote</div>
              <?php elseif ($election['status'] === 'upcoming') : ?>
                <div class="px-3 py-1 rounded-full text-sm bg-yellow-50 text-yellow-700">Upcoming</div>
              <?php else: ?>
                <div class="px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-700">Closed</div>
              <?php endif; ?>

            </div>
          </div>

          <div class="mt-4 border-t pt-4">
            <!-- messages -->
            <?php foreach ($messages as $m) : ?>
              <div class="mb-2 p-2 rounded text-sm <?= $m['type'] === 'error' ? 'bg-red-50 text-red-700' : 'bg-green-50 text-green-700' ?>"><?= htmlspecialchars($m['text']) ?></div>
            <?php endforeach; ?>

            <!-- Voting status -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
              <div class="p-3 bg-indigo-50 rounded">
                <div class="text-xs text-gray-600">Verification</div>
                <div class="font-medium">Voter ID Verified</div>
              </div>
              <div class="p-3 bg-indigo-50 rounded">
                <div class="text-xs text-gray-600">Registration</div>
                <div class="font-medium">Eligible</div>
              </div>
              <div class="p-3 bg-indigo-50 rounded">
                <div class="text-xs text-gray-600">Vote Status</div>
                <div class="font-medium"><?= $hasVoted ? 'Already Voted' : 'Not Voted' ?></div>
              </div>
            </div>

            <!-- Cast vote button -->
            <div class="mt-4">
              <?php if (!$hasVoted) : ?>
                <a href="#ballot" class="inline-block px-4 py-2 rounded-md bg-indigo-600 text-white text-sm">Cast My Vote</a>
              <?php elseif ($hasVoted) : ?>
                <a href="#receipt" class="inline-block px-4 py-2 rounded-md bg-green-600 text-white text-sm">View Receipt</a>
              <?php else: ?>
                <button class="inline-block px-4 py-2 rounded-md bg-gray-300 text-gray-700 text-sm" disabled>Voting Unavailable</button>
              <?php endif; ?>
            </div>

          </div>
        </div>

        <!-- Ballot / Candidate list -->
        <div id="ballot" class="card p-4 mt-4">
          <div class="flex justify-between items-center">
            <div>
              <div class="text-xl font-semibold">Ballot Preview</div>
              <div class="text-xs text-gray-500">Select one candidate and submit your vote. Your choice will be recorded securely.</div>
              <br>
            </div>
          </div>



          <?php
          include '../includes/db.php'; // adjust path to your db connection
          $user_id = $_SESSION['user_id'] ?? null;

          // Check if user has already voted
          $voted_candidate_id = null;
          $voted_time = null;

          if ($user_id) {
              $checkVote = $conn->prepare("SELECT candidate_id, voted_at FROM votes WHERE user_id = ?");
              $checkVote->bind_param("i", $user_id);
              $checkVote->execute();
              $voteResult = $checkVote->get_result();
              if ($voteResult->num_rows > 0) {
                  $voteData = $voteResult->fetch_assoc();
                  $voted_candidate_id = $voteData['candidate_id'];
                  $voted_time = $voteData['voted_at'];
              }
          }

          // Handle new vote submission
          if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['voteChoice']) && $user_id && !$voted_candidate_id) {
              $candidate_id = $_POST['candidate_id'];

              $stmt = $conn->prepare("INSERT INTO votes (user_id, candidate_id, voted_at) VALUES (?, ?, NOW())");
              $stmt->bind_param("ii", $user_id, $candidate_id);
              if ($stmt->execute()) {
                  $voted_candidate_id = $candidate_id;

                  // Fetch actual vote time from DB
                  $voteCheck = $conn->prepare("SELECT voted_at FROM votes WHERE user_id = ?");
                  $voteCheck->bind_param("i", $user_id);
                  $voteCheck->execute();
                  $voted_time = $voteCheck->get_result()->fetch_assoc()['voted_at'];

                  // Update session to reflect voting status
                  $_SESSION['voted'] = true;
                  $_SESSION['vote_receipt'] = [
                      'candidate_id' => $candidate_id,
                      'voted_at' => $voted_time
                  ];
              } else {
                  echo "<div class='text-red-600 mt-4'>Failed to record vote. Please try again.</div>";
                  $_SESSION['voted'] = false;
                  $_SESSION['vote_receipt'] = [
                      'candidate_id' => null,
                      'voted_at' => null
                  ];
              }
          }
          ?>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
              <?php foreach ($candidates as $c) : ?>
                  <?php $isVoted = $voted_candidate_id === (int)$c['id']; ?>
                  <form method="post" action="dashboard.php" class="block border rounded hover:shadow-sm relative h-[200px] <?= $isVoted ? 'opacity-70' : '' ?>">
                      <img src="<?= htmlspecialchars($c['photo_url']) ?>" alt="Candidate Image" class="mb-2 h-full w-full h-32 object-cover rounded">
                      <div class="absolute bottom-0 left-0 flex flex-row w-full justify-between items-center px-5 pb-6 pt-3 h-full bg-[rgba(0,0,0,0.6)]">
                          <div class="absolute bottom-0 left-0 w-full flex justify-between items-center gap-3 px-4 py-2 rounded">
                              <div>
                                  <input type="hidden" name="candidate_id" value="<?= htmlspecialchars($c['id']) ?>">
                                  <p class="text-[13px] text-white font-medium"><?= htmlspecialchars($c['name']) ?></p>
                                  <p class="text-[12px] text-white"><?= htmlspecialchars($c['department']) ?></p>
                              </div>
                              <input type="submit" name="voteChoice" value="<?= $isVoted ? 'Voted' : 'Vote' ?>"
                                  class="h-max w-max px-3 py-1 mt-1 rounded <?= $isVoted ? 'bg-gray-500 cursor-not-allowed' : 'bg-green-600 text-white cursor-pointer' ?>"
                                  <?= $isVoted ? 'disabled' : '' ?>>
                          </div>
                      </div>
                  </form>
              <?php endforeach; ?>
          </div>

          <?php
          // Show receipt if user has voted
          if ($voted_candidate_id) {
              $candStmt = $conn->prepare("SELECT full_name, department FROM candidates WHERE candidate_id = ?");
              $candStmt->bind_param("i", $voted_candidate_id);
              $candStmt->execute();
              $candResult = $candStmt->get_result()->fetch_assoc();

              echo "
              <div id='receipt' class='card p-4 mt-4 bg-white border rounded shadow'>
                  <div class='text-xl font-semibold mb-2'>Voting Receipt</div>
                  <p><strong>Name:</strong> " . htmlspecialchars($candResult['full_name']) . "</p>
                  <p><strong>Department:</strong> " . htmlspecialchars($candResult['department']) . "</p>
                  <p><strong>Time:</strong> " . htmlspecialchars($voted_time) . "</p>
              </div>
              ";
          }else{
            echo "<br>";
            echo "<div class='text-xl font-semibold mb-2'>Voting Receipt</div>";
            echo "<div class='mt-2 text-sm text-gray-500'>No receipt available. Cast your vote to receive a receipt.</div>";
          }
          ?>






      </section>

    </div>
  </main>

  <footer class="max-w-7xl mx-auto p-4 text-xs text-gray-500">
    <div class="flex justify-between">
      <div>© <?= date('Y') ?> Electoral Commission</div>
      <div>Privacy · Terms · Contact</div>
    </div>
  </footer>

</body>
</html>
