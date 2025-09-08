<!-- Admin Panel -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
 
</head>
<body class="bg-green-100 text-gray-900 w-[100dvw] h-[100dvh] flex flex-col">


    <header class="fixed h-16 w-full flex justify-between items-center px-4 py-2 md:px-20">
        <h1 class="text-3xl font-bold">
            Admin Panel
        </h1>
        <div id="account" class="flex items-center gap-4">
            <input type="image" src="../assets/defaults/download.png" alt="" class="rounded-full w-10 h-10" >
        </div>
    </header>


    <main class="flex-1 flex px-4 md:px-20 gap-4 mt-[70px] mb-[50px] overflow-y-auto">
        <nav class="md:w-[15%] hidden md:flex flex-col justify-between">
            <div id="links" class="flex flex-col gap-4 p-4">
                <div>
                    <a href="#dashboard" class="block py-2 px-4 rounded hover:font-medium">Dashboard</a>
                    <a href="#" class="block py-2 px-4 rounded hover:font-medium">Voters</a>
                    <a href="#" class="block py-2 px-4 rounded hover:font-medium">Candidates</a>
                    <a href="#" class="block py-2 px-4 rounded hover:font-medium">Votes</a>
                </div>
            </div>
            <div class="p-4">
                <a href="#" class="block py-2 px-4 rounded hover:font-medium">Logout</a>
            </div>
        </nav>





        <section id="dashboard" class=" w-full md:w-[85%] md:p-2 md:overflow-y-auto">
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded shadow p-6 flex flex-col items-center">
                        <span class="text-lg font-medium mb-2">Total Voters</span>
                        <span class="text-3xl font-bold text-green-600">
                            1200 <!-- Replace with real value from backend -->
                        </span>
                    </div>
                    <div class="bg-white rounded shadow p-6 flex flex-col items-center">
                        <span class="text-lg font-medium mb-2">Total Candidates</span>
                        <span class="text-3xl font-bold text-blue-600">
                            15 <!-- Replace with real value from backend -->
                        </span>
                    </div>
                    <div class="bg-white rounded shadow p-6 flex flex-col items-center">
                        <span class="text-lg font-medium mb-2">Total Votes Cast</span>
                        <span class="text-3xl font-bold text-red-600">
                            950 <!-- Replace with real value from backend -->
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
                    <script>
                        const votesLabels = ['22nd', '23rd', '24th', '25th', '26th', '27th'];
                        const votesData = [120, 150, 180, 200, 170, 220]; // TODO: Replace with backend values
                        new Chart(document.getElementById('votesLineChart'), {
                            type: 'line',
                            data: {
                                labels: votesLabels,
                                datasets: [{
                                    label: 'Votes',
                                    data: votesData,
                                    borderColor: 'rgb(34,197,94)',
                                    backgroundColor: 'rgba(34,197,94,0.2)',
                                    fill: true,
                                    tension: 0.4
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: { display: false }
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
                        const candidatesLabels = ['Alice', 'Bob', 'Charlie', 'Diana', 'Eve'];
                        const candidatesVotes = [300, 250, 180, 120, 100]; // TODO: Replace with backend values
                        new Chart(document.getElementById('candidatesBarChart'), {
                            type: 'bar',
                            data: {
                                labels: candidatesLabels,
                                datasets: [{
                                    label: 'Votes',
                                    data: candidatesVotes,
                                    backgroundColor: [
                                        'rgb(34,197,94)',
                                        'rgb(34,197,94)',
                                        'rgb(34,197,94)',
                                        'rgb(34,197,94)',
                                        'rgb(34,197,94)'
                                    ]
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: { display: false }
                                },
                                scales: {
                                    y: { beginAtZero: true }
                                }
                            }
                        });
                    </script>
                </div>
            </div>




            <div class="mt-10 flex flex-col md:flex-row md:gap-8 flex flex-col justify-center items-center">
                <!-- Voter Participation Donut Chart -->
                <div class="bg-white rounded shadow p-6 max-w-md w-full mb-10 md:mb-0">
                    <h2 class="text-xl font-bold mb-4">Voter Participation</h2>
                    <canvas id="voterParticipationChart" height="100"></canvas>
                    <script>
                        // Example data: 950 voted out of 1200 registered
                        const totalVoters = 1200;
                        const votesCast = 950;
                        const notVoted = totalVoters - votesCast;

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
                                    legend: { position: 'bottom' }
                                }
                            }
                        });
                    </script>
                </div>

                <!-- Candidates Vote Percentage Table -->
                <div class="bg-white rounded shadow p-6 w-full flex flex-col justify-center items-center">
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
                            // Example data, replace with backend query
                            $candidates = [
                                ['name' => 'Alice', 'votes' => 300],
                                ['name' => 'Bob', 'votes' => 250],
                                ['name' => 'Charlie', 'votes' => 180],
                                ['name' => 'Diana', 'votes' => 120],
                                ['name' => 'Eve', 'votes' => 100]
                            ];
                            $totalVotes = 950; // Replace with backend value

                            foreach ($candidates as $candidate) {
                                $percent = $totalVotes > 0 ? round(($candidate['votes'] / $totalVotes) * 100, 2) : 0;
                                echo "<tr>
                                        <td class='py-2 px-4'>{$candidate['name']}</td>
                                        <td class='py-2 px-4'>{$candidate['votes']}</td>
                                        <td class='py-2 px-4'>{$percent}%</td>
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
</body>
</html>