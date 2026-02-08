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
      <i class="fa-solid fa-database text-blue-600"></i>
      Data Migration & Backup
    </h1>
    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold flex items-center gap-2 shadow-md">
      <i class="fa-solid fa-circle-info"></i>
      Help
    </button>
  </div>

  <!-- Import Section -->
  <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
        <i class="fa-solid fa-file-import text-blue-600"></i>
        Import Old Records
      </h2>
      <span class="text-sm text-gray-500 italic">Migrate previous patient data (CSV, Excel)</span>
    </div>

    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-5">
      <div>
        <label class="block font-semibold text-gray-700 mb-1">Select File to Import</label>
        <input type="file" name="migration_file" accept=".csv, .xls, .xlsx"
               class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all">
        <p class="text-sm text-gray-500 mt-1">Accepted formats: CSV, Excel (.xls, .xlsx)</p>
      </div>

      <div class="flex justify-end">
        <button type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow-md flex items-center gap-2 transition-all">
          <i class="fa-solid fa-upload"></i> Upload & Import
        </button>
      </div>
    </form>
  </div>

  <!-- Divider -->
  <div class="border-t border-gray-200 my-10"></div>

  <!-- Backup & Restore Section -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Backup Card -->
    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
      <h2 class="text-2xl font-semibold text-gray-800 mb-3 flex items-center gap-2">
        <i class="fa-solid fa-shield-halved text-green-600"></i>
        Create System Backup
      </h2>
      <p class="text-gray-600 mb-5 text-sm">
        Generate a secure backup of all system data to prevent information loss.
      </p>
      <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold shadow-md flex items-center gap-2 transition-all">
        <i class="fa-solid fa-database"></i> Backup Now
      </button>
      <p class="text-xs text-gray-500 mt-2">Last backup: October 12, 2025 – 2:45 PM</p>
    </div>

    <!-- Restore Card -->
    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
      <h2 class="text-2xl font-semibold text-gray-800 mb-3 flex items-center gap-2">
        <i class="fa-solid fa-rotate-left text-yellow-500"></i>
        Restore from Backup
      </h2>
      <p class="text-gray-600 mb-5 text-sm">
        Upload a backup file (.sql or .zip) to restore your data from a previous point in time.
      </p>
      <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4">
        <input type="file" name="restore_file" accept=".sql, .zip"
               class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-yellow-400 focus:outline-none transition-all">
        <button type="submit" 
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md flex items-center gap-2 transition-all">
          <i class="fa-solid fa-upload"></i> Restore Data
        </button>
      </form>
    </div>
  </div>
</main>

   
<script src="../js/sidebar.js"></script>
</body>
</html>