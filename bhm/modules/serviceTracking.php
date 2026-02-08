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
  <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
    <i class="fa-solid fa-stethoscope text-blue-600"></i>
    Health Services Tracking
  </h1>


  <div class="bg-white p-6 rounded-lg shadow-md">

  

    <!-- Patient Search -->
<div class="mb-6">
  <label class="block font-semibold text-gray-700 mb-1">Search Patient</label>
  <div class="flex gap-2">
    <input type="text" id="searchPatient" placeholder="Enter Patient ID or Name"
           class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
    <button type="button" id="searchBtn"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold flex items-center gap-2">
      <i class="fa-solid fa-search"></i> Search
    </button>
  </div>
  <p class="text-sm text-gray-500 mt-1">Search to auto-fill patient details.</p>
</div>



    <!-- Service Form -->
    <form action="../php/healthTrackingCrud.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">

     <!-- Patient Info (Auto-filled) -->
  <div>
    <label class="block font-semibold text-gray-700 mb-1">Patient ID</label>
    <input type="text" id="patientIdField" name="patient_id" readonly
           class="w-full border border-gray-200 bg-gray-100 rounded-lg p-2 text-gray-600">
  </div>

  <div>
    <label class="block font-semibold text-gray-700 mb-1">Patient Name</label>
    <input type="text" id="patientNameField" name="patient_name" readonly
           class="w-full border border-gray-200 bg-gray-100 rounded-lg p-2 text-gray-600">
  </div>

      <div>
        <label class="block font-semibold text-gray-700 mb-1">Date of Service</label>
        <input type="date" name="service_date" required 
               class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">

        <label class="block font-semibold text-gray-700 mb-1 mt-4">Attending Health Worker</label>
        <input type="text" name="attending_staff" 
               placeholder="Name of attending staff" 
               class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
      </div>

      <div>
        <label class="block font-semibold text-gray-700 mb-1">Type of Service</label>
<select name="service_type" required 
        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
    <option value="">Select Service...</option>
    <?php
    include_once("../config/db.php"); // DB connection
    // Fetch services from DB
    $services = $conn->query("SELECT id, service_name FROM services ORDER BY service_name ASC");
    while ($row = $services->fetch_assoc()) {
        echo '<option value="'.$row['id'].'">'.htmlspecialchars($row['service_name']).'</option>';
    }
    ?>
</select>


        <label class="block font-semibold text-gray-700 mb-1 mt-4">Diagnosis / Notes</label>
        <textarea name="diagnosis" rows="3" 
                  class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" 
                  placeholder="Enter diagnosis or remarks"></textarea>
      </div>

      <div class="md:col-span-2">
        <label class="block font-semibold text-gray-700 mb-1">Medicine / Treatment Given</label>
        <textarea name="treatment" rows="3" 
                  class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" 
                  placeholder="Enter treatment details or medicine dispensed"></textarea>
      </div>

      <div class="md:col-span-2">
  <label class="block font-semibold text-gray-700 mb-1 mt-4">Service Status</label>
  <select name="status" required 
          class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
    <option value="">Select status...</option>
    <option value="Ongoing">Ongoing</option>
    <option value="Completed">Completed</option>
    <option value="Follow-up Needed">Follow-up Needed</option>
  </select>
</div>


      <!-- Submit Button -->
      <div class="md:col-span-2 flex justify-end mt-4">
        <button type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow-md flex items-center gap-2">
          <i class="fa-solid fa-clipboard-check"></i> Record Service
        </button>
      </div>
    </form>
  </div>

  <script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchPatient');
    const patientIdField = document.getElementById('patientIdField');
    const patientNameField = document.getElementById('patientNameField');

    searchInput.addEventListener('input', () => {
        const query = searchInput.value.trim();
        if (query.length < 2) { // minimum characters to search
            patientIdField.value = '';
            patientNameField.value = '';
            return;
        }

        fetch(`../php/fetchPatient.php?query=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.patient_id) {
                    patientIdField.value = data.patient_id;
                    patientNameField.value = data.fullname;
                } else {
                    patientIdField.value = '';
                    patientNameField.value = '';
                }
            })
            .catch(err => console.error('Error fetching patient:', err));
    });
});
</script>

<div class="mt-12 space-y-8">

  <!-- 🔹 Header Section -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center mb-4 md:mb-0">
      <i class="fas fa-stethoscope text-blue-700 mr-3"></i>
      Health Services Tracking
    </h1>
  </div>

  <!-- 🔹 Search & Add Buttons Section -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
    <!-- 🔍 Search Bar -->
    <div class="flex items-center w-full md:w-80 bg-white border border-gray-300 rounded-lg overflow-hidden shadow-sm focus-within:ring-2 focus-within:ring-blue-600 transition">
      <span class="px-3 text-gray-500"><i class="fas fa-search"></i></span>
      <input 
        type="text" 
        id="searchService" 
        placeholder="Search by patient name or service..." 
        class="w-full px-3 py-2 text-gray-700 outline-none bg-transparent"
      >
    </div>

    <!-- ➕ Add Button -->
    <button class="mt-3 md:mt-0 flex items-center justify-center gap-2 bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow-md text-sm font-semibold transition">
      <i class="fas fa-plus-circle"></i>
      Add Service Record
    </button>
  </div>

  <!-- 🔹 Table Row -->
  <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
    <table class="min-w-full border-collapse">
      <thead class="bg-blue-700 text-white text-sm uppercase tracking-wider">
        <tr>
          <th class="px-6 py-3 text-left">Patient ID</th>
          <th class="px-6 py-3 text-left">Patient Name</th>
          <th class="px-6 py-3 text-left">Service Type</th>
          <th class="px-6 py-3 text-left">Date Provided</th>
          <th class="px-6 py-3 text-left">Attending BHW</th>
          <th class="px-6 py-3 text-left">Status</th>
          <th class="px-6 py-3 text-center">Actions</th>
        </tr>
      </thead>
      <tbody id="serviceTable" class="text-gray-700 text-sm divide-y divide-gray-200"></tbody>
    </table>
  </div>

  <!-- 🔹 Pagination Row -->
  <div id="pagination" class="flex justify-end items-center mt-4 space-x-1"></div>

</div> <!-- ✅ closes main mt-12 container -->


<!-- 🔹 jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
  let currentPage = 1;
  let limit = 5;

  function loadServices(search = '') {
    $.ajax({
      url: '../php/HealthTrackingPagination.php',
      type: 'GET',
      data: { search: search, page: currentPage, limit: limit },
      dataType: 'json',
      success: function(response) {
        let rows = '';
        if (response.data.length > 0) {
          response.data.forEach(item => {
            rows += `
              <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-3 font-medium text-gray-900">${item.patient_id}</td>
                <td class="px-6 py-3">${item.patient_name ?? 'N/A'}</td>
                <td class="px-6 py-3">${item.service_name ?? 'N/A'}</td>
                <td class="px-6 py-3">${item.date_provided}</td>
                <td class="px-6 py-3">${item.attending_bhw}</td>
                <td class="px-6 py-3">
                  <span class="px-3 py-1 text-xs font-semibold rounded-full 
                    ${item.status === 'Completed' ? 'bg-green-100 text-green-700 border border-green-300' : 
                      item.status === 'In Progress' ? 'bg-yellow-100 text-yellow-700 border border-yellow-300' : 
                      'bg-blue-100 text-blue-700 border border-blue-300'}">
                    ${item.status}
                  </span>
                </td>
                <td class="px-6 py-3 text-center space-x-3">
                  <button class="text-blue-600 hover:text-blue-800"><i class="fas fa-eye"></i></button>
                  <button class="text-yellow-600 hover:text-yellow-700"><i class="fas fa-edit"></i></button>
                  <button class="text-red-600 hover:text-red-700"><i class="fas fa-trash-alt"></i></button>
                </td>
              </tr>
            `;
          });
        } else {
          rows = `<tr><td colspan="7" class="text-center py-4 text-gray-500">No records found</td></tr>`;
        }
        $('#serviceTable').html(rows);

        // 🔹 Pagination
        const totalPages = Math.ceil(response.total / limit);
        let paginationHtml = '';
        for (let i = 1; i <= totalPages; i++) {
          paginationHtml += `<button class="px-3 py-1 text-sm rounded-md ${i === currentPage ? 'bg-blue-700 text-white shadow' : 'bg-gray-100 hover:bg-gray-200 text-gray-700'}" data-page="${i}">${i}</button>`;
        }
        $('#pagination').html(paginationHtml);
      }
    });
  }

  // 🔹 Pagination Click
  $(document).on('click', '#pagination button', function(){
    currentPage = $(this).data('page');
    loadServices($('#searchService').val());
  });

  // 🔹 Live Search
  $('#searchService').on('keyup', function(){
    currentPage = 1;
    loadServices($(this).val());
  });

  // Initial Load
  loadServices();
});
</script>

</main>

   
<script src="../js/sidebar.js"></script>
</body>
</html>