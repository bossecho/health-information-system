<?php
include '../config/db.php'; // adjust path if needed

// === DASHBOARD COUNTS === //
$totalPatients = $conn->query("SELECT COUNT(*) AS total FROM patients")->fetch_assoc()['total'];

$totalConsultations = $conn->query("
    SELECT COUNT(*) AS total 
    FROM service_records 
    WHERE service_id = 1
")->fetch_assoc()['total'];

$totalImmunizations = $conn->query("
    SELECT COUNT(*) AS total 
    FROM service_records 
    WHERE service_id = 3
")->fetch_assoc()['total'];

$totalPrenatal = $conn->query("
    SELECT COUNT(*) AS total 
    FROM service_records 
    WHERE service_id = 2
")->fetch_assoc()['total'];

// === RECENT ACTIVITIES === //
$recentActivities = $conn->query("
    SELECT sr.*, p.fullname, s.service_name 
    FROM service_records sr
    JOIN patients p ON sr.patient_id = p.patient_id
    JOIN services s ON sr.service_id = s.id
    ORDER BY sr.date_provided DESC
    LIMIT 5
");

// === MONTHLY SUMMARY DATA FOR CHART === //
$monthlyDataQuery = $conn->query("
    SELECT 
        MONTH(date_provided) AS month,
        COUNT(*) AS total
    FROM service_records
    WHERE YEAR(date_provided) = YEAR(CURDATE())
    GROUP BY MONTH(date_provided)
    ORDER BY MONTH(date_provided)
");

$months = [];
$totals = [];

while ($row = $monthlyDataQuery->fetch_assoc()) {
    $months[] = date("M", mktime(0, 0, 0, $row['month'], 1));
    $totals[] = $row['total'];
}
?>

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
  <!-- Header -->
  <div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
      <i class="fa-solid fa-gauge-high text-blue-600"></i>
      Dashboard Overview
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

  <!-- Charts and Activity -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Chart Section -->
    <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-md border border-gray-100">
      <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <i class="fa-solid fa-chart-column text-blue-600"></i>
        Monthly Health Service Summary
      </h2>
      <canvas id="serviceChart" class="h-64"></canvas>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
      <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <i class="fa-solid fa-bell text-blue-600"></i>
        Recent Activities
      </h2>
      <ul class="space-y-4 text-gray-700">
        <?php while ($act = $recentActivities->fetch_assoc()): ?>
        <li class="flex items-start gap-3">
          <i class="fa-solid fa-notes-medical text-blue-600 mt-1"></i>
          <div>
            <p class="font-semibold"><?= htmlspecialchars($act['fullname']) ?></p>
            <p class="text-sm text-gray-500">
              <?= htmlspecialchars($act['service_name']) ?> — <?= htmlspecialchars($act['status']) ?>
            </p>
          </div>
        </li>
        <?php endwhile; ?>
      </ul>
    </div>
  </div>

  <!-- Alerts or Reminders -->
  <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
      <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
      Important Alerts
    </h2>
    <ul class="space-y-3 text-gray-700">
      <li class="flex items-center gap-3 bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
        <i class="fa-solid fa-circle-exclamation text-red-600"></i>
        <span>Backup reminder: Last backup was 7 days ago.</span>
      </li>
      <li class="flex items-center gap-3 bg-yellow-50 border-l-4 border-yellow-500 p-3 rounded-lg">
        <i class="fa-solid fa-calendar-day text-yellow-500"></i>
        <span>3 prenatal checkups scheduled for tomorrow.</span>
      </li>
    </ul>
  </div>

  <script>
    // === Chart.js setup === //
    const ctx = document.getElementById('serviceChart').getContext('2d');
    const serviceChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?= json_encode($months) ?>,
        datasets: [{
          label: 'Total Services',
          data: <?= json_encode($totals) ?>,
          backgroundColor: 'rgba(37, 99, 235, 0.6)',
          borderColor: 'rgba(37, 99, 235, 1)',
          borderWidth: 1,
          borderRadius: 8
        }]
      },
      options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
      }
    });
  </script>
</main>

   
<script src="../js/sidebar.js"></script>
</body>
</html>