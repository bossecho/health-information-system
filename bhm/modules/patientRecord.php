<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../includes/head.php'; ?>
    <title>Document</title>
</head>
<body>

<?php include '../includes/navbar.php'; ?>
<?php include '../includes/sidebar.php'; ?>



<main class="mt-16 md:ml-64 p-6 bg-gray-50 min-h-screen">

<style>
  .subnav-link {
    @apply px-4 py-2 text-sm font-medium rounded-lg transition duration-200 
           text-gray-700 bg-white hover:bg-blue-100 border border-gray-300;
  }
  .subnav-link.active {
    @apply bg-blue-700 text-white border-blue-700;
  }
</style>


<!-- 🔹 Submodule Navbar -->
<section class="bg-gray-100 border border-gray-300 rounded-xl shadow-sm mb-6">
  <div class="flex flex-wrap items-center justify-between px-4 py-3">

    <!-- 🔸 Submodule Title -->
    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
      <i class="fas fa-layer-group text-blue-700 mr-2"></i>
      Module Navigation
    </h2>

    <!-- 🔸 Submodule Links -->
    <div class="flex flex-wrap gap-2">
      <button class="subnav-link active" data-section="users">
        <i class="fas fa-users mr-2"></i> Users
      </button>
      <button class="subnav-link" data-section="patients">
        <i class="fas fa-notes-medical mr-2"></i> Patients
      </button>
      <button class="subnav-link" data-section="reports">
        <i class="fas fa-chart-bar mr-2"></i> Reports
      </button>
      <button class="subnav-link" data-section="settings">
        <i class="fas fa-cogs mr-2"></i> Settings
      </button>
    </div>
  </div>
</section>

<!-- 🔹 Submodule Content Sections -->
<section id="submodule-content" class="space-y-6">
  
  <!-- 🧩 Users Section ------------------------------------------------------->
  <div id="users" class="submodule-section">
    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
      <h3 class="text-xl font-semibold text-gray-800 mb-3">
        <i class="fas fa-user mr-2 text-blue-700"></i> Manage Users
      </h3>
      <p class="text-gray-600">This is where your user management module will go.</p>
    </div>
  </div>

  <!-- 🧩 Patients Section --------------------------------------------------->
  <div id="patients" class="submodule-section hidden">
    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
      <h3 class="text-xl font-semibold text-gray-800 mb-3">
        <i class="fas fa-user-injured mr-2 text-blue-700"></i> Manage Patients
      </h3>
      <p class="text-gray-600">This section is for patient tracking and records.</p>
    </div>
  </div>

  <!-- 🧩 Reports Section --------------------------------------------------->
  <div id="reports" class="submodule-section hidden">
    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
      <h3 class="text-xl font-semibold text-gray-800 mb-3">
        <i class="fas fa-chart-line mr-2 text-blue-700"></i> Reports
      </h3>
      <p class="text-gray-600">Generate and view system reports here.</p>
    </div>
  </div>

  <!-- 🧩 Settings Section --------------------------------------------------->
  <div id="settings" class="submodule-section hidden">
    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
      <h3 class="text-xl font-semibold text-gray-800 mb-3">
        <i class="fas fa-sliders-h mr-2 text-blue-700"></i> Settings
      </h3>
      <p class="text-gray-600">Adjust configurations for this module.</p>
    </div>
  </div>

</section>

<script>
  document.querySelectorAll('.subnav-link').forEach(btn => {
    btn.addEventListener('click', () => {
      // Switch active button
      document.querySelectorAll('.subnav-link').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      // Show the selected section only
      const target = btn.getAttribute('data-section');
      document.querySelectorAll('.submodule-section').forEach(sec => sec.classList.add('hidden'));
      document.getElementById(target).classList.remove('hidden');
    });
  });
</script>






    <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
      <i class="fa-solid fa-user-plus text-blue-600"></i>
      Patient Registration
    </h1>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
      <form action="../php/backend.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <input type="hidden" name="action" value="add_patient">

        <!-- Left Column -->
        <div>
          <label class="block font-semibold text-gray-700 mb-1">Full Name</label>
          <input type="text" name="fullname" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="Enter full name" required>

          <label class="block font-semibold text-gray-700 mb-1 mt-4">Age</label>
          <input type="number" name="age" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="Enter age" required>

          <label class="block font-semibold text-gray-700 mb-1 mt-4">Sex</label>
          <select name="sex" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
            <option value="">Select...</option>
            <option>Male</option>
            <option>Female</option>
          </select>

          <label class="block font-semibold text-gray-700 mb-1 mt-4">Address</label>
          <textarea name="address" rows="2" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="Enter complete address"></textarea>
        </div>

        

        <!-- Right Column -->
        <div>
          <label class="block font-semibold text-gray-700 mb-1">Contact Number</label>
          <input type="text" name="contact" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="09XXXXXXXXX">

          <label class="block font-semibold text-gray-700 mb-1 mt-4">Date of Birth</label>
          <input type="date" name="dob" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">

          <label class="block font-semibold text-gray-700 mb-1 mt-4">Health ID / Patient No.</label>
          <input type="text" name="patient_id" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="Auto-generated or manual">

          <label class="block font-semibold text-gray-700 mb-1 mt-4">Remarks / Notes</label>
          <textarea name="notes" rows="2" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="Add remarks or medical history"></textarea>
        </div>

        <div class="md:col-span-2 mt-6 bg-gray-50 border border-gray-200 rounded-lg p-6">
  <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
    <i class="fas fa-ruler-combined text-blue-600 mr-2"></i>
    Physical Measurements
  </h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Height Input -->
    <div>
      <label for="height" class="block font-semibold text-gray-700 mb-1">
        Height (cm)
      </label>
      <input 
        type="number" 
        id="height" 
        name="height" 
        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" 
        placeholder="Enter height in cm" 
        required
      >
    </div>

    <!-- Weight Input -->
    <div>
      <label for="weight" class="block font-semibold text-gray-700 mb-1">
        Weight (kg)
      </label>
      <input 
        type="number" 
        id="weight" 
        name="weight" 
        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" 
        placeholder="Enter weight in kg" 
        required
      >
    </div>
  </div>
</div>



        <!-- Submit Button -->
        <div class="md:col-span-2 flex justify-end mt-4">
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow-md flex items-center gap-2">
            <i class="fa-solid fa-save"></i> Save Patient
          </button>
        </div>

      </form>
    </div>



  
<!-- 🔹 VIEW MODAL -->
<!-- View Modal -->
<div id="viewModal" class="fixed inset-0 hidden justify-center items-center bg-black/40 z-50">
  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative overflow-y-auto max-h-[90vh] border border-gray-100">

    <!-- Header -->
    <div class="flex justify-between items-center border-b border-gray-200 pb-3 mb-4">
      <h2 class="text-2xl font-semibold text-blue-800 flex items-center gap-2">
        👤 Patient Details
      </h2>
      <button onclick="closeModal('viewModal')" class="text-gray-400 hover:text-gray-600 transition">
        <i class="fas fa-times text-lg"></i>
      </button>
    </div>

    <!-- Patient Info -->
    <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
      <p><strong class="text-blue-700">Patient ID:</strong> <span id="view_patient_id"></span></p>
      <p><strong class="text-blue-700">Full Name:</strong> <span id="view_fullname"></span></p>
      <p><strong class="text-blue-700">Age:</strong> <span id="view_age"></span></p>
      <p><strong class="text-blue-700">Sex:</strong> <span id="view_sex"></span></p>
      <p><strong class="text-blue-700">DOB:</strong> <span id="view_dob"></span></p>
      <p><strong class="text-blue-700">Contact:</strong> <span id="view_contact"></span></p>
      <p><strong class="text-blue-700">Height:</strong> <span id="view_height"></span></p>
      <p><strong class="text-blue-700">Weight:</strong> <span id="view_weight"></span></p>
    </div>

    <!-- Address -->
    <div class="mt-5 bg-blue-50 p-4 rounded-lg border border-blue-100">
      <p class="font-semibold text-blue-700 mb-1">Address:</p>
      <p id="view_address" class="text-gray-800"></p>
    </div>

    <!-- Notes -->
    <div class="mt-4 bg-gray-50 p-4 rounded-lg border border-gray-100">
      <p class="font-semibold text-blue-700 mb-1">Notes:</p>
      <p id="view_notes" class="text-gray-800 whitespace-pre-wrap"></p>
    </div>

    <!-- Footer -->
    <div class="flex justify-end mt-6">
      <button onclick="closeModal('viewModal')" class="px-5 py-2 bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-lg shadow-sm transition">
        Close
      </button>
    </div>
  </div>
</div>



<!-- 🔹 EDIT MODAL -->
<div id="editModal" class="fixed inset-0 bg-black/50 hidden justify-center items-center z-50">
  <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl p-6 relative overflow-y-auto max-h-[90vh]">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Edit Patient</h2>

    <form id="editForm" method="POST" action="../php/backend1.php" class="space-y-3">
      <input type="hidden" name="action" value="edit">
      <input type="hidden" id="edit_id" name="id">

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Patient ID</label>
          <input Readonly type="text" id="edit_patient_id" name="patient_id" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Full Name</label>
          <input type="text" id="edit_fullname" name="fullname" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Age</label>
          <input type="number" id="edit_age" name="age" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Sex</label>
          <select id="edit_sex" name="sex" class="w-full border rounded-lg px-3 py-2" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
          <input type="date" id="edit_dob" name="dob" class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Contact</label>
          <input type="text" id="edit_contact" name="contact" class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Height (cm)</label>
          <input type="number" step="0.01" id="edit_height" name="height" class="w-full border rounded-lg px-3 py-2">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Weight (kg)</label>
          <input type="number" step="0.01" id="edit_weight" name="weight" class="w-full border rounded-lg px-3 py-2">
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Address</label>
        <textarea id="edit_address" name="address" class="w-full border rounded-lg px-3 py-2" rows="2"></textarea>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Notes</label>
        <textarea id="edit_notes" name="notes" class="w-full border rounded-lg px-3 py-2" rows="3"></textarea>
      </div>

      <div class="flex justify-end gap-3 mt-4">
        <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-700">Cancel</button>
        <button type="submit" class="px-4 py-2 rounded-lg bg-blue-700 hover:bg-blue-800 text-white">Save</button>
      </div>
    </form>

    <button class="absolute top-3 right-3 text-gray-500 hover:text-gray-700" onclick="closeModal('editModal')">
      <i class="fas fa-times text-lg"></i>
    </button>
  </div>
</div>




<!-- 🗑️ Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black/50 hidden">
  <div class="bg-white rounded-lg shadow-lg w-80 p-5 text-center">
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Confirm Delete</h2>
    <p class="text-gray-600 mb-2">
      Are you sure you want to delete this patient?
    </p>
    <p id="deleteInfo" class="text-red-600 font-medium mb-4"></p>

    <div class="flex justify-center space-x-3">
      <button id="cancelDelete" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">Cancel</button>
      <button id="confirmDelete" type="button" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
  Delete
</button>

    </div>
  </div>
</div>






<!-- Header ---------------------------------------------------------------------------------------------------->

<div class="mt-12 space-y-8 px-6">

  <!-- Header -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center mb-4 md:mb-0">
      <i class="fas fa-notes-medical text-blue-700 mr-3"></i> Patient Records
    </h1>

    <!-- Search + Add -->
    <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
      <div class="flex items-center w-full md:w-72 bg-white border border-gray-300 rounded-lg overflow-hidden shadow-sm">
        <span class="px-3 text-gray-500"><i class="fas fa-search"></i></span>
        <input 
          type="text" id="search" 
          placeholder="Search patient by name or ID..." 
          class="w-full px-3 py-2 text-gray-700 outline-none bg-transparent"
        >
      </div>

      <button class="flex items-center justify-center gap-2 bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow-md text-sm font-semibold transition">
        <i class="fas fa-user-plus"></i> Add New Patient
      </button>
    </div>
  </div>

  <!-- Table -->
  <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-x-auto">

    <table class="min-w-full border-collapse">
      <thead class="bg-blue-700 text-white text-sm uppercase tracking-wider">
        <tr>
          <th class="px-6 py-3 text-left">#</th>
          <th class="px-6 py-3 text-left">Patient ID</th>
          <th class="px-6 py-3 text-left">Full Name</th>
          <th class="px-6 py-3 text-left">Age</th>
          <th class="px-6 py-3 text-left">Sex</th>
          <th class="px-6 py-3 text-left">Address</th>
          <th class="px-6 py-3 text-center">Actions</th>
        </tr>
      </thead>
      <tbody id="patientTable" class="text-gray-700 text-sm divide-y divide-gray-200"></tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="flex flex-col md:flex-row justify-between items-center mt-6 gap-3">
    <p id="recordInfo" class="text-sm text-gray-600"></p>
    <div id="pagination" class="flex space-x-1"></div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
$(document).ready(function () {
  let currentPage = 1;
  let limit = 10;

  function loadPatients(page = 1, search = '') {
    $.ajax({
      url: '../php/fetch_patients.php',
      type: 'GET',
      data: { page: page, limit: limit, search: search },
      dataType: 'json',
      success: function (response) {
        let patients = response.patients;
        let total = response.total;
        let tbody = '';
        if (patients.length > 0) {
          patients.forEach((p, index) => {
            tbody += `
              <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-3">${(page - 1) * limit + index + 1}</td>
                <td class="px-6 py-3 font-medium text-gray-900">${p.patient_id}</td>
                <td class="px-6 py-3">${p.fullname}</td>
                <td class="px-6 py-3">${p.age}</td>
                <td class="px-6 py-3">${p.sex}</td>
                <td class="px-6 py-3">${p.address ?? ''}</td>
                <td class="px-6 py-3 text-center space-x-3">
                  <button class="view-btn text-blue-600 hover:text-blue-800" title="View"><i class="fas fa-eye"></i></button>
            <button class="edit-btn text-yellow-600 hover:text-yellow-700" title="Edit"><i class="fas fa-edit"></i></button>
            <button class="delete-btn text-red-600 hover:text-red-700" title="Delete"><i class="fas fa-trash-alt"></i></button></td>
              </tr>`;
          });
        } else {
          tbody = `<tr><td colspan="7" class="text-center py-4 text-gray-500">No patients found</td></tr>`;
        }

        $('#patientTable').html(tbody);

        // Pagination
        let totalPages = Math.ceil(total / limit);
        let paginationHTML = '';
        if (totalPages > 1) {
          paginationHTML += `<button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-md" data-page="${page - 1}" ${page === 1 ? 'disabled' : ''}>&laquo;</button>`;
          for (let i = 1; i <= totalPages; i++) {
            paginationHTML += `<button class="px-3 py-1 text-sm ${i === page ? 'bg-blue-700 text-white' : 'bg-gray-100 hover:bg-gray-200'} rounded-md" data-page="${i}">${i}</button>`;
          }
          paginationHTML += `<button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-md" data-page="${page + 1}" ${page === totalPages ? 'disabled' : ''}>&raquo;</button>`;
        }
        $('#pagination').html(paginationHTML);

        $('#recordInfo').text(`Showing ${(page - 1) * limit + 1}–${Math.min(page * limit, total)} of ${total} patients`);
      }
    });
  }

  // Initial load
  loadPatients();

  // Pagination click
  $(document).on('click', '#pagination button', function () {
    let page = $(this).data('page');
    if (page && page > 0) {
      currentPage = page;
      loadPatients(currentPage, $('#search').val());
    }
  });

  // Search input
  $('#search').on('keyup', function () {
    let search = $(this).val();
    loadPatients(1, search);
  });
});
</script>




  
</main>


    
<script src="../js/sidebar.js"></script>
<script src="../js/patients.js"></script>
</body>
</html>