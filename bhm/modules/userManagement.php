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
  <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
    <i class="fas fa-users-cog text-blue-700 mr-3"></i> User Management
  </h1>

  <!-- Add User Button -->
  <div class="flex justify-between items-center mb-4">
    <p class="text-gray-600 text-sm">Manage barangay health staff accounts and access levels.</p>
    <button class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow-md text-sm font-semibold flex items-center">
      <i class="fas fa-user-plus mr-2"></i> Add New User
    </button>
  </div>

  <!-- Users Table -->
  <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
    <table class="min-w-full border-collapse">
      <thead class="bg-blue-700 text-white text-sm uppercase tracking-wider">
        <tr>
          <th class="px-6 py-3 text-left">#</th>
          <th class="px-6 py-3 text-left">Full Name</th>
          <th class="px-6 py-3 text-left">Username</th>
          <th class="px-6 py-3 text-left">Role</th>
          <th class="px-6 py-3 text-left">Status</th>
          <th class="px-6 py-3 text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-3">1</td>
          <td class="px-6 py-3">Juan Dela Cruz</td>
          <td class="px-6 py-3">juan.dc</td>
          <td class="px-6 py-3">
            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">Admin</span>
          </td>
          <td class="px-6 py-3">
            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Active</span>
          </td>
          <td class="px-6 py-3 text-center space-x-2">
            <button class="text-blue-600 hover:text-blue-800" title="Edit User">
              <i class="fas fa-edit"></i>
            </button>
            <button class="text-red-600 hover:text-red-800" title="Deactivate">
              <i class="fas fa-user-slash"></i>
            </button>
          </td>
        </tr>
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-3">2</td>
          <td class="px-6 py-3">Maria Santos</td>
          <td class="px-6 py-3">maria.s</td>
          <td class="px-6 py-3">
            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-medium">Health Worker</span>
          </td>
          <td class="px-6 py-3">
            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Active</span>
          </td>
          <td class="px-6 py-3 text-center space-x-2">
            <button class="text-blue-600 hover:text-blue-800" title="Edit User">
              <i class="fas fa-edit"></i>
            </button>
            <button class="text-red-600 hover:text-red-800" title="Deactivate">
              <i class="fas fa-user-slash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Add/Edit User Form (Modal Placeholder) -->
  <div class="mt-8 bg-white p-6 rounded-lg shadow-md border border-gray-200">
    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
      <i class="fas fa-user-edit text-blue-700 mr-2"></i> Add / Edit User
    </h2>
    <form class="grid md:grid-cols-2 gap-4">
      <input type="hidden" name="action" value="add"> 

      <div>
        <label class="text-sm font-medium text-gray-700">Full Name</label>
        <input name="fullname" type="text" placeholder="Enter full name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
      </div>
      
      <div>
        <label class="text-sm font-medium text-gray-700">Username</label>
        <input name="username" type="text" placeholder="Enter username" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
      </div>
      <div>
        <label class="text-sm font-medium text-gray-700">Role</label>
        <select name="role" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
          <option>Admin</option>
          <option>Health Worker</option>
          <option>Encoder</option>
        </select>
      </div>
      <div>
        <label class="text-sm font-medium text-gray-700">Status</label>
        <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
          <option>Active</option>
          <option>Inactive</option>
        </select>
      </div>
      <div>
        <label class="text-sm font-medium text-gray-700">Password</label>
        <input password="password" type="password" placeholder="Enter password" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
      </div>
      <div class="flex items-end">
        <button class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow-md font-semibold">
          <i class="fas fa-save mr-2"></i> Save User
        </button>
      </div>
    </form>
  </div>
</main>


   
<script src="../js/sidebar.js"></script>
</body>
</html>