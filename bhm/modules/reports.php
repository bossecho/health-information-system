<?php
include '../config/db.php'; // adjust path if needed

// === Handle Filters === //
$month = $_GET['month'] ?? '';
$program = $_GET['program'] ?? 'All Programs';
$gender = $_GET['gender'] ?? 'All';

// Build dynamic WHERE conditions
$where = "1=1";
if (!empty($month)) {
    $where .= " AND DATE_FORMAT(sr.date_provided, '%Y-%m') = '$month'";
}
if ($program !== 'All Programs') {
    $where .= " AND s.service_name = '$program'";
}
if ($gender !== 'All') {
    $where .= " AND p.sex = '$gender'";
}

// === Summary Counts === //
$totalPatients = $conn->query("SELECT COUNT(DISTINCT p.patient_id) AS total FROM patients p")->fetch_assoc()['total'];
$totalConsultations = $conn->query("SELECT COUNT(*) AS total FROM service_records WHERE service_id = 1")->fetch_assoc()['total'];
$totalImmunizations = $conn->query("SELECT COUNT(*) AS total FROM service_records WHERE service_id = 3")->fetch_assoc()['total'];
$totalPrenatal = $conn->query("SELECT COUNT(*) AS total FROM service_records WHERE service_id = 2")->fetch_assoc()['total'];

// === Report Data === //
$query = "
    SELECT 
        sr.date_provided,
        p.fullname,
        s.service_name,
        sr.attending_bhw,
        sr.remarks
    FROM service_records sr
    JOIN patients p ON sr.patient_id = p.patient_id
    JOIN services s ON sr.service_id = s.id
    WHERE $where
    ORDER BY sr.date_provided DESC
";
$result = $conn->query($query);

// ✅ Get filter values
$month   = isset($_GET['month']) ? $_GET['month'] : '';
$program = isset($_GET['program']) ? $_GET['program'] : 'All Programs';
$gender  = isset($_GET['gender']) ? $_GET['gender'] : 'All';

// ✅ Base query
$query2 = "
    SELECT sr.date_provided, p.fullname, s.service_name, sr.attending_bhw, sr.remarks, p.sex
    FROM service_records sr
    JOIN patients p ON sr.patient_id = p.patient_id
    JOIN services s ON sr.service_id = s.id
    WHERE 1
";

// ✅ Apply filters
if (!empty($month)) {
    // match YYYY-MM
    $query2 .= " AND DATE_FORMAT(sr.date_provided, '%Y-%m') = '" . $conn->real_escape_string($month) . "'";
}

if ($program !== 'All Programs') {
    $query2 .= " AND s.service_name = '" . $conn->real_escape_string($program) . "'";
}

if ($gender !== 'All') {
    $query2 .= " AND p.sex = '" . $conn->real_escape_string($gender) . "'";
}

$query2 .= " ORDER BY sr.date_provided DESC";

$result = $conn->query($query2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../includes/head.php'; ?>
    <title>Document</title>
    <style>
/* === Light Blue DataTables Fix === */

/* Table background and rows */
#reportTable {
  background-color: #ffffff !important;
}

#reportTable thead {
  background-color: #eff6ff !important; /* blue-50 */
  color: #1e3a8a !important; /* blue-900 */
}

#reportTable tbody tr:nth-child(even) {
  background-color: #f9fafb !important; /* gray-50 */
}

#reportTable tbody tr:nth-child(odd) {
  background-color: #ffffff !important;
}

#reportTable tbody tr:hover {
  background-color: #dbeafe !important; /* blue-100 hover */
}

/* Text color fix */
#reportTable td, 
#reportTable th {
  color: #1e3a8a !important;
}

/* Pagination buttons */
.dataTables_wrapper .dataTables_paginate .paginate_button {
  background-color: #eff6ff !important; /* blue-50 */
  color: #1e3a8a !important;
  border: 1px solid #bfdbfe !important; /* blue-200 */
  border-radius: 0.5rem !important;
  padding: 5px 10px !important;
  margin: 0 3px !important;
  transition: all 0.2s ease-in-out;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background-color: #dbeafe !important; /* blue-100 */
  color: #1e40af !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background-color: #2563eb !important; /* blue-600 */
  color: white !important;
  border: 1px solid #2563eb !important;
}

/* Dropdown & Search Box */
.dataTables_wrapper select,
.dataTables_wrapper input[type="search"] {
  background-color: #ffffff !important;
  color: #1e3a8a !important;
  border: 1px solid #cbd5e1 !important; /* gray-300 */
  border-radius: 0.5rem !important;
  padding: 6px 10px !important;
  font-size: 0.875rem !important;
}

.dataTables_wrapper select:focus,
.dataTables_wrapper input[type="search"]:focus {
  border-color: #2563eb !important;
  box-shadow: 0 0 0 2px rgba(37,99,235,0.25);
}

/* Labels and info text */
.dataTables_wrapper .dataTables_length label,
.dataTables_wrapper .dataTables_filter label,
.dataTables_wrapper .dataTables_info {
  color: #1e3a8a !important;
  font-weight: 500;
}

/* Remove any dark theme remnants */
.dataTables_wrapper .dataTables_paginate,
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info {
  background: transparent !important;

  /* === DataTables Light Theme Overrides === */

/* General table colors */
table.dataTable {
  background-color: white !important;
  color: #1e3a8a !important; /* blue-800 */
}

/* Header */
table.dataTable thead th {
  background-color: #eff6ff !important; /* blue-50 */
  color: #1d4ed8 !important; /* blue-700 */
  font-weight: 600;
  text-transform: uppercase;
  border-bottom: 2px solid #dbeafe;
}

/* Rows */
table.dataTable tbody tr {
  background-color: white !important;
  color: #1e3a8a !important;
}
table.dataTable tbody tr:nth-child(even) {
  background-color: #f9fafb !important; /* gray-50 */
}
table.dataTable tbody tr:hover {
  background-color: #e0f2fe !important; /* blue-100 */
}

/* Search and dropdown controls */
.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select {
  background-color: white !important;
  color: #1e3a8a !important;
  border: 1px solid #d1d5db !important;
  border-radius: 0.5rem;
  padding: 0.4rem 0.6rem;
}
.dataTables_wrapper .dataTables_filter label,
.dataTables_wrapper .dataTables_length label {
  color: #1e3a8a !important;
}

/* === Pagination === */
.dataTables_wrapper .dataTables_paginate .paginate_button {
  background: white !important;
  color: #1e3a8a !important;
  border: 1px solid #93c5fd !important; /* blue-300 */
  border-radius: 0.375rem;
  margin: 0 2px;
  padding: 4px 10px;
  transition: all 0.2s;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background: #bfdbfe !important; /* blue-200 */
  color: #1e40af !important; /* blue-800 */
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background: #3b82f6 !important; /* blue-500 */
  color: white !important;
  border: 1px solid #2563eb !important; /* blue-600 */
}
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
  background: #f3f4f6 !important; /* gray-100 */
  color: #9ca3af !important; /* gray-400 */
  border: 1px solid #e5e7eb !important;
  cursor: not-allowed;
}
}
</style>

</head>
<body>

<?php include '../includes/navbar.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<main class="mt-16 md:ml-64 p-6 bg-gray-50 min-h-screen">
  
  <!-- Header -->
  <div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
      <i class="fa-solid fa-chart-line text-blue-600"></i>
      Reports & Analytics
    </h1>
    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold flex items-center gap-2 shadow-md">
      <i class="fa-solid fa-circle-info"></i>
      Help
    </button>
  </div>

<!-- Summary Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-5 rounded-2xl shadow-lg border-l-4 border-blue-600">
      <h3 class="text-gray-500 font-semibold">Total Patients</h3>
      <p class="text-3xl font-bold text-gray-800 mt-1"><?= $totalPatients ?></p>
      <span class="text-sm text-gray-500">+12 new this week</span>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-lg border-l-4 border-green-600">
      <h3 class="text-gray-500 font-semibold">Consultations</h3>
      <p class="text-3xl font-bold text-gray-800 mt-1"><?= $totalConsultations ?></p>
      <span class="text-sm text-gray-500">+5 today</span>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-lg border-l-4 border-yellow-500">
      <h3 class="text-gray-500 font-semibold">Immunizations</h3>
      <p class="text-3xl font-bold text-gray-800 mt-1"><?= $totalImmunizations ?></p>
      <span class="text-sm text-gray-500">+8 this month</span>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-lg border-l-4 border-red-500">
      <h3 class="text-gray-500 font-semibold">Prenatal Visits</h3>
      <p class="text-3xl font-bold text-gray-800 mt-1"><?= $totalPrenatal ?></p>
      <span class="text-sm text-gray-500">+3 this week</span>
    </div>
  </div>


  <!-- Filters Section -->
  <div class="bg-white p-6 rounded-2xl shadow-md mb-8 border border-gray-100">
    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
      <i class="fa-solid fa-filter text-blue-500"></i>
      Filter Reports
    </h2>
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
  <!-- Date Range -->
  <div>
    <label class="block text-gray-700 font-semibold mb-1">Date Range</label>
    <input type="month" name="month" value="<?= htmlspecialchars($month) ?>"
           class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all">
  </div>

  <!-- Health Program -->
  <div>
    <label class="block text-gray-700 font-semibold mb-1">Health Program</label>
    <select name="program"
            class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all">
      <option <?= $program === 'All Programs' ? 'selected' : '' ?>>All Programs</option>
      <option <?= $program === 'Immunization' ? 'selected' : '' ?>>Immunization</option>
      <option <?= $program === 'Prenatal Care' ? 'selected' : '' ?>>Prenatal Care</option>
      <option <?= $program === 'General Checkup' ? 'selected' : '' ?>>General Checkup</option>
      <option <?= $program === 'Other' ? 'selected' : '' ?>>Other</option>
    </select>
  </div>

  <!-- Gender Filter -->
  <div>
    <label class="block text-gray-700 font-semibold mb-1">Gender</label>
    <select name="gender"
            class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all">
      <option <?= $gender === 'All' ? 'selected' : '' ?>>All</option>
      <option <?= $gender === 'Male' ? 'selected' : '' ?>>Male</option>
      <option <?= $gender === 'Female' ? 'selected' : '' ?>>Female</option>
    </select>
  </div>

  <!-- Filter Buttons -->
  <div class="md:col-span-3 flex justify-end mt-2 gap-3">
    <a href="reports.php"
       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg font-semibold shadow-md flex items-center gap-2 transition">
      <i class="fa-solid fa-rotate-left"></i> Clear Filter
    </a>
    <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow-md flex items-center gap-2 transition">
      <i class="fa-solid fa-magnifying-glass"></i> Generate Report
    </button>
  </div>
</form>

  </div>


  <!-- Report Table -->
  <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
        <i class="fa-solid fa-table text-blue-600"></i>
        Health Service Report
      </h2>
      <div class="flex gap-2">
        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold flex items-center gap-2 shadow-sm">
          <i class="fa-solid fa-file-excel"></i> Export Excel
        </button>
        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold flex items-center gap-2 shadow-sm">
          <i class="fa-solid fa-file-pdf"></i> Export PDF
        </button>
      </div>
    </div>

    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>


    <!-- Table Container -->
<div class="overflow-x-auto bg-white rounded-2xl shadow-md p-4 border border-gray-100">
  <table id="reportTable" class="min-w-full table-auto border-collapse text-sm">
    <thead class="bg-blue-50 text-blue-700 uppercase tracking-wide text-xs font-semibold">
      <tr>
        <th class="py-3 px-4 text-left border-b border-gray-200">Date</th>
        <th class="py-3 px-4 text-left border-b border-gray-200">Patient Name</th>
        <th class="py-3 px-4 text-left border-b border-gray-200">Service</th>
        <th class="py-3 px-4 text-left border-b border-gray-200">Health Worker</th>
        <th class="py-3 px-4 text-left border-b border-gray-200">Remarks</th>
      </tr>
    </thead>
    <tbody class="text-blue-900">
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr class="border-b border-gray-100 hover:bg-blue-50 transition-colors">
            <td class="py-3 px-4"><?= htmlspecialchars($row['date_provided']) ?></td>
            <td class="py-3 px-4"><?= htmlspecialchars($row['fullname']) ?></td>
            <td class="py-3 px-4"><?= htmlspecialchars($row['service_name']) ?></td>
            <td class="py-3 px-4"><?= htmlspecialchars($row['attending_bhw']) ?></td>
            <td class="py-3 px-4"><?= htmlspecialchars($row['remarks']) ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="5" class="text-center py-4 text-gray-500">
            No records found for the selected filters.
          </td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- DataTables Setup -->
<script>
$(document).ready(function() {
  $('#reportTable').DataTable({
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50, 100],
    order: [[0, 'desc']],
    language: {
      search: "🔍 Search:",
      lengthMenu: "Show _MENU_ entries per page",
      info: "Showing _START_ to _END_ of _TOTAL_ records",
      paginate: {
        previous: "← Prev",
        next: "Next →"
      },
      zeroRecords: "No matching records found"
    },
    dom: '<"flex justify-between items-center mb-3"lf>tip', // layout control
  });
});
</script>


  </div>
</main>

   
<script src="../js/sidebar.js"></script>
</body>
</html>