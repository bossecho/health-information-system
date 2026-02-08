<header class="bg-blue-800 shadow-xl fixed top-0 left-0 w-full z-30 h-16">
  <div class="flex items-center justify-between h-full px-6">

    <!-- Left Section: Logo + System Name -->
    <a href="#" class="flex items-center space-x-3">
      <img src="../assets/Logo.jfif" alt="BBTHIS Logo" class="h-10 w-10 rounded-full border-2 border-blue-300 object-cover" />
      <div class="flex flex-col leading-tight">
        <div class="flex items-center space-x-2">
          <span class="text-xl font-extrabold text-white tracking-wider">BBTHIS</span>
          <span class="hidden sm:inline text-blue-200 font-medium">| Health Information System</span>
        </div>
        <p class="text-xs text-blue-100 hidden sm:block">Barangay Bahay Toro</p>
      </div>
    </a>

    <!-- Right Section -->
    <div class="flex items-center space-x-4 relative">
      <!-- Notification -->
      <button class="text-blue-100 hover:text-white transition duration-150">
        <i class="fas fa-bell text-lg"></i>
      </button>

      <!-- Profile Dropdown -->
      <div class="relative">
        <!-- Profile Button -->
        <button id="profileDropdownBtn" class="flex items-center bg-blue-700 px-3 py-1.5 rounded-full shadow-sm focus:outline-none hover:bg-blue-600 transition duration-200">
          <div class="h-8 w-8 rounded-full bg-blue-600 text-blue-100 flex items-center justify-center font-semibold text-sm">
            JD
          </div>
          <div class="ml-2 text-left text-sm text-white">
            <p class="font-medium leading-tight">J. Dela Cruz</p>
            <p class="text-xs text-blue-200">Admin / BHW</p>
          </div>
          <i class="fas fa-caret-down ml-2 text-blue-200"></i>
        </button>

        <!-- Dropdown Menu -->
        <div id="profileDropdownMenu" class="hidden absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
          <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">Manage Account</a>
          <div class="border-t border-gray-100"></div>
          <a href="../login.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">Logout</a>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- JS for dropdown toggle -->
<script>
  const dropdownBtn = document.getElementById('profileDropdownBtn');
  const dropdownMenu = document.getElementById('profileDropdownMenu');

  dropdownBtn.addEventListener('click', () => {
    dropdownMenu.classList.toggle('hidden');
  });

  // Close dropdown when clicking outside
  window.addEventListener('click', (e) => {
    if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
      dropdownMenu.classList.add('hidden');
    }
  });
</script>
