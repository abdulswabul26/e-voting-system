<?php

// Connect to database
include '../../includes/db.php';
session_start();




// Make sure the user is logged in
if (!isset($_SESSION['user_id'])) {
    return; // No user session, nothing to delete
}

$user_id = $_SESSION['user_id'];

// Delete OTP associated with this user
try {
    $stmt = $conn->prepare("DELETE FROM user_otps WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
} catch (Exception $e) {
    error_log("Failed to delete OTP for user $user_id: " . $e->getMessage());
}








// === Functions ===
function getTotalVoters($conn) {
    $sql = "SELECT COUNT(*) AS total FROM users";
    $result = $conn->query($sql);
    return ($result && $row = $result->fetch_assoc()) ? $row['total'] : 0;
}

function getTotalCandidates($conn) {
    $sql = "SELECT COUNT(*) AS total FROM candidates";
    $result = $conn->query($sql);
    return ($result && $row = $result->fetch_assoc()) ? $row['total'] : 0;
}

function getTotalVotes($conn) {
    $sql = "SELECT COUNT(*) AS total FROM votes";
    $result = $conn->query($sql);
    return ($result && $row = $result->fetch_assoc()) ? $row['total'] : 0;
}

// Get live stats
$totalVoters = getTotalVoters($conn);
$totalCandidates = getTotalCandidates($conn);
$totalVotes = getTotalVotes($conn);


$sql = "
    SELECT c.full_name, COUNT(v.vote_id) AS total_votes
    FROM candidates c
    LEFT JOIN votes v ON c.candidate_id = v.candidate_id
    GROUP BY c.candidate_id
    ORDER BY total_votes DESC
";
$result = $conn->query($sql);

$candidateNames = [];
$candidateVotes = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $candidateNames[] = $row['full_name'];
        $candidateVotes[] = (int)$row['total_votes'];
    }
}
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

      <section id="dashboard" class="w-full md:w-[85%] md:px-2 md:overflow-y-auto px-10 pb-10">
            <div class="py-8">
              <h1 class="font-bold text-3xl mb-5">Dashboard</h1>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="card rounded shadow p-6 flex flex-col items-center">
                        <span class="text-lg font-medium mb-2">Total Voters</span>
                        <span class="text-3xl font-bold text-green-600">
                            <?php echo number_format($totalVoters); ?>
                        </span>
                    </div>
                    <div class="card rounded shadow p-6 flex flex-col items-center">
                        <span class="text-lg font-medium mb-2">Total Candidates</span>
                        <span class="text-3xl font-bold text-blue-600">
                            <?php echo number_format($totalCandidates); ?>
                        </span>
                    </div>
                    <div class="card rounded shadow p-6 flex flex-col items-center">
                        <span class="text-lg font-medium mb-2">Total Votes Cast</span>
                        <span class="text-3xl font-bold text-red-600">
                            <?php echo number_format($totalVotes); ?>
                        </span>
                    </div>
                </div>
            </div>


            <div class="mt-10 grid grid-cols-1 md:grid-cols-2 md:gap-8 ">


            
                <!-- Votes Performance Line Graph -->
                <div class="bg-white rounded shadow p-6 mb-10 md:mb-0">
                    <h2 class="text-xl font-bold mb-4">Votes Performance (Line Graph)</h2>
                    <canvas id="votesLineChart" height="200"></canvas>
                    <!-- Replace randomData with real votes data from backend -->
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <?php
                        // Query: count votes grouped by date
                        $query = $conn->query("
                            SELECT DATE(voted_at) AS vote_date, COUNT(*) AS total_votes
                            FROM votes
                            GROUP BY DATE(voted_at)
                            ORDER BY vote_date ASC
                        ");

                        $labels = [];
                        $data = [];

                        while ($row = $query->fetch_assoc()) {
                            $labels[] = date('M j', strtotime($row['vote_date'])); // e.g. "Oct 5"
                            $data[] = (int)$row['total_votes'];
                        }
                        ?>
                        <script>
                        // Pull PHP data into JavaScript
                        
                        const votesLabels = <?php echo json_encode($labels); ?>;
                        const votesData = <?php echo json_encode($data); ?>;

                        new Chart(document.getElementById('votesLineChart'), {
                            type: 'line',
                            data: {
                                labels: votesLabels,
                                datasets: [{
                                    label: 'Votes Over Time',
                                    data: votesData,
                                    borderColor: 'rgb(34,197,94)',
                                    backgroundColor: 'rgba(34,197,94,0.2)',
                                    fill: true,
                                    tension: 0.4,
                                    pointRadius: 5,
                                    pointHoverRadius: 7
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return context.parsed.y + ' votes';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        title: { display: true, text: 'Date' }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        title: { display: true, text: 'Number of Votes' }
                                    }
                                }
                            }
                        });
                    </script>
                </div>






                <!-- Candidates Performance Bar Graph -->
                <div class="bg-white rounded shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Candidates Performance (Bar Graph)</h2>
                    <canvas id="candidatesBarChart" height="200"></canvas>
                    <!-- Replace randomData with real candidates data from backend -->
                    <script>
                        const candidatesLabels = <?php echo json_encode($candidateNames); ?>;
                        const candidatesVotes = <?php echo json_encode($candidateVotes); ?>;

                        new Chart(document.getElementById('candidatesBarChart'), {
                            type: 'bar',
                            data: {
                                labels: candidatesLabels,
                                datasets: [{
                                    label: 'Votes',
                                    data: candidatesVotes,
                                    backgroundColor: candidatesLabels.map(() => 'rgb(34,197,94)')
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: { legend: { display: false } },
                                scales: { y: { beginAtZero: true } }
                            }
                        });
                    </script>

                </div>
            </div>



<?php
// Fetch total registered voters
$totalVotersQuery = $conn->query("SELECT COUNT(*) AS total FROM users");
$totalVotersRow = $totalVotersQuery->fetch_assoc();
$totalVoters = $totalVotersRow['total'] ?? 0;

// Fetch total who voted
$votedQuery = $conn->query("SELECT COUNT(DISTINCT user_id) AS voted FROM votes");
$votedRow = $votedQuery->fetch_assoc();
$votesCast = $votedRow['voted'] ?? 0;

// Calculate those who haven’t voted
$notVoted = $totalVoters - $votesCast;
?>

            <div class="mt-10 flex flex-col md:flex-row md:gap-8 flex flex-col justify-center items-center">
                <!-- Voter Participation Donut Chart -->
                <div class="bg-white rounded shadow p-6 max-w-md w-full mb-10 md:mb-0">
                    <h2 class="text-xl font-bold mb-4">Voter Participation</h2>
                    <canvas id="voterParticipationChart" height="100"></canvas>
                    <script>
    const totalVoters = <?php echo $totalVoters; ?>;
    const votesCast = <?php echo $votesCast; ?>;
    const notVoted = <?php echo $notVoted; ?>;

    new Chart(document.getElementById('voterParticipationChart'), {
        type: 'doughnut',
        data: {
            labels: ['Voted', 'Not Voted'],
            datasets: [{
                data: [votesCast, notVoted],
                backgroundColor: [
                    'rgb(34,197,94)',
                    'rgb(220,38,38)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const percent = totalVoters > 0
                                ? ((value / totalVoters) * 100).toFixed(2)
                                : 0;
                            return `${label}: ${value} (${percent}%)`;
                        }
                    }
                }
            }
        }
    });
</script>

                </div>

                <!-- Candidates Vote Percentage Table -->
                <div class="bg-white rounded shadow p-6 w-full h-full">
                    <h2 class="text-xl font-bold mb-4">Candidates Vote Percentage</h2>
                    <table class="w-full text-left">
                        <thead>
                            <tr>
                                <th class="py-2 px-4">Candidate</th>
                                <th class="py-2 px-4">Votes</th>
                                <th class="py-2 px-4">Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // 1️⃣ Fetch candidates and vote counts
                            $sql = "
                                SELECT c.full_name, COUNT(v.vote_id) AS total_votes
                                FROM candidates c
                                LEFT JOIN votes v ON c.candidate_id = v.candidate_id
                                GROUP BY c.candidate_id
                                ORDER BY total_votes DESC
                            ";
                            $result = $conn->query($sql);

                            // 2️⃣ Calculate total votes (for percentage)
                            $totalVotesQuery = $conn->query("SELECT COUNT(*) AS total FROM votes");
                            $totalVotesRow = $totalVotesQuery->fetch_assoc();
                            $totalVotes = $totalVotesRow['total'];

                            // 3️⃣ Display results dynamically
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $name = htmlspecialchars($row['full_name']);
                                    $votes = (int)$row['total_votes'];
                                    $percent = $totalVotes > 0 ? round(($votes / $totalVotes) * 100, 2) : 0;

                                    echo "
                                    <tr class='border-b hover:bg-gray-50 transition'>
                                        <td class='py-2 px-4 font-medium'>{$name}</td>
                                        <td class='py-2 px-4'>{$votes}</td>
                                        <td class='py-2 px-4 text-green-600 font-semibold'>{$percent}%</td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3' class='py-3 px-4 text-center text-gray-500'>No candidates found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

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