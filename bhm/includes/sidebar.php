<!-- 🔹 Sidebar -->
<aside id="sidebar"
  class="fixed top-0 left-0 w-64 h-full bg-gray-800 text-white z-20 shadow-xl transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">

  <div class="p-4 space-y-2 mt-16 relative">
    <h3 class="text-xs font-semibold uppercase text-gray-400 mt-2 mb-3 px-3">Main Navigation</h3>

    <!-- 🔹 Sidebar Links -->
    <a href="index.php?page=dashboard"
      class="sidebar-link flex items-center p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-150">
      <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
      <span class="font-semibold">Dashboard</span>
    </a>

    <a href="patientRecord.php"
      class="sidebar-link flex items-center p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-150">
      <i class="fas fa-user-injured w-5 h-5 mr-3"></i>
      <span>Patient Records</span>
    </a>

    <a href="serviceTracking.php?page=serviceTracking"
      class="sidebar-link flex items-center p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-150">
      <i class="fas fa-stethoscope w-5 h-5 mr-3"></i>
      <span>Service Tracking</span>
    </a>

    <a href="dataMigration.php?page=dataMigration"
      class="sidebar-link flex items-center p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-150">
      <i class="fas fa-database w-5 h-5 mr-3"></i>
      <span>Data Migration & Backup</span>
    </a>

    <a href="reports.php?page=reports"
      class="sidebar-link flex items-center p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-150">
      <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
      <span>Reports & Analytics</span>
    </a>

    <a href="userManagement.php?page=users"
      class="sidebar-link flex items-center p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition duration-150">
      <i class="fas fa-users-cog w-5 h-5 mr-3"></i>
      <span>User Management</span>
    </a>

   <!-- 🔹 Toggle Button -->
<button id="sidebarToggle"
  class="absolute -right-4 top-1/2 transform -translate-y-1/2 bg-blue-700 hover:bg-blue-800 text-white p-2 rounded-r-lg shadow-lg transition duration-200 focus:outline-none z-30 flex items-center space-x-1 group">
  
  <!-- Icon -->
  <i id="toggleIcon" class="fa-solid fa-chevron-left text-sm"></i>

  <!-- Optional text label -->
  <span class="text-xs font-semibold hidden group-hover:inline">Menu</span>

  <!-- Click indicator (pulse ring) -->
  <span class="absolute inset-0 rounded-r-lg ring-2 ring-blue-400 opacity-0 group-hover:opacity-100 animate-pulse pointer-events-none"></span>
</button>



  </div>
</aside>

<!-- 🔹 Overlay (for mobile background dim when sidebar open) -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/40 hidden z-10 md:hidden"></div>