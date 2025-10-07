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
         <section id="candidates" class="w-full md:w-[85%] md:p-4">
  <div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold">Manage Candidates</h2>
      <button id="addCandidateBtn" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        + Add Candidate
      </button>
    </div>

    <!-- Add/Edit Candidate Modal -->
    <div id="candidateModal" class="fixed inset-0 bg-[rgba(0,0,0,0.6)] flex justify-center items-center hidden">
      <div class="bg-white rounded-lg w-11/12 max-w-md p-6 shadow-lg">
        <h3 id="modalTitle" class="text-xl font-semibold mb-4">Add Candidate</h3>
        <form id="candidateForm" method="POST" action="process_candidate.php" enctype="multipart/form-data" class="space-y-4">
          <input type="hidden" name="candidate_id" id="candidateId">

          <div>
            <label class="block text-sm font-medium mb-1">Full Name</label>
            <input type="text" name="full_name" id="candidateName" required
              class="w-full border rounded p-2 focus:outline-none focus:ring focus:ring-green-200">
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Reg No</label>
            <input type="text" name="reg_no" id="candidateReg" required
              class="w-full border rounded p-2 focus:outline-none focus:ring focus:ring-green-200">
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Department / Position</label>
            <input type="text" name="department" id="candidateDepartment" required
              class="w-full border rounded p-2 focus:outline-none focus:ring focus:ring-green-200">
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Photo</label>
            <input type="file" name="photo_url" id="candidatePhoto" accept="image/*"
              class="w-full border rounded p-2 focus:outline-none focus:ring focus:ring-green-200">
          </div>

          <div class="flex justify-end gap-3 mt-4">
            <button type="button" id="cancelModal"
              class="px-4 py-2 border rounded hover:bg-gray-100">Cancel</button>
            <button type="submit" name="save"
              class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Save</button>
          </div>
        </form>
      </div>
    </div>
</div>

<script>
// Modal JS
const modal = document.getElementById('candidateModal');
const addBtn = document.getElementById('addCandidateBtn');
const cancelBtn = document.getElementById('cancelModal');
const modalTitle = document.getElementById('modalTitle');
const form = document.getElementById('candidateForm');

addBtn.addEventListener('click', () => {
    modal.classList.remove('hidden');
    modalTitle.textContent = 'Add Candidate';
    form.reset();
    document.getElementById('candidateId').value = '';
});

cancelBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
});
</script>


    <!-- Candidate Table -->
    <?php include "../admin/fetch_candidates.php"?>
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