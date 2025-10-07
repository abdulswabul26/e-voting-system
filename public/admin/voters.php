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
                    <a href="candidates.php" class="block py-2 px-4 rounded hover:font-medium nav-link">Candidates</a>
                    <a href="voters.php" class="block py-2 px-4 rounded font-medium hover:font-medium nav-link">Voters</a>
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
    <h2 class="text-2xl font-bold">Eligible Voters</h2>
  
  <div class="flex gap-2">
    <!-- Search Input -->
    <input type="text" id="searchVoter" placeholder="Search voter..."
      class="border p-2 rounded w-60 focus:outline-none focus:ring focus:ring-green-200" />
    
     <!-- CSV Import Form -->
    <form id="importVotersForm" action="import_voters.php" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
      <input type="file" name="voters_csv" accept=".csv"
        class="border p-2 rounded focus:outline-none focus:ring focus:ring-green-200" required>
      <button type="submit"
        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Import CSV
      </button>
    </form>
  </div>
</div>


    <!-- Voter Details Modal -->
    <div id="voterModal" class="fixed inset-0 bg-[rgba(0,0,0,0.6)] flex justify-center items-center hidden">
      <div class="bg-white rounded-lg w-11/12 max-w-md p-6 shadow-lg">
        <h3 class="text-xl font-semibold mb-4">Voter Details</h3>
        <div id="voterDetails" class="space-y-2 text-gray-700 text-sm"></div>
        <div class="flex justify-end mt-4">
          <button id="closeVoterModal" class="px-4 py-2 border rounded hover:bg-gray-100">Close</button>
        </div>
      </div>
    </div>

    <!-- Voters Table -->
        <?php include 'fetch_voters.php'; ?>
    <br>
   
  </div>

  <script>
    // Modal Elements
    const voterModal = document.getElementById("voterModal");
    const closeVoterModal = document.getElementById("closeVoterModal");
    const voterDetails = document.getElementById("voterDetails");

    // Open voter details
    document.querySelectorAll(".viewVoter").forEach(btn => {
      btn.addEventListener("click", () => {
        voterDetails.innerHTML = `
          <p><strong>Name:</strong> ${btn.dataset.name}</p>
          <p><strong>Registration No.:</strong> ${btn.dataset.reg}</p>
          <p><strong>District:</strong> ${btn.dataset.district}</p>
          <p><strong>Status:</strong> ${btn.dataset.status}</p>
          <p><strong>Email:</strong> ${btn.dataset.email}</p>
          <p><strong>Phone:</strong> ${btn.dataset.phone}</p>
        `;
        voterModal.classList.remove("hidden");
      });
    });

    closeVoterModal.addEventListener("click", () => voterModal.classList.add("hidden"));

    // Search Filter
    const searchInput = document.getElementById("searchVoter");
    searchInput.addEventListener("keyup", function () {
      const filter = this.value.toLowerCase();
      const rows = document.querySelectorAll("#voterTable tr");

      rows.forEach(row => {
        const name = row.cells[1].textContent.toLowerCase();
        const reg = row.cells[2].textContent.toLowerCase();
        row.style.display = (name.includes(filter) || reg.includes(filter)) ? "" : "none";
      });
    });
  </script>
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