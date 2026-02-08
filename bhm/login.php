<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://kit.fontawesome.com/a2e0e6f63c.js" crossorigin="anonymous"></script>
  <title>Login | BBTHIS</title>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">

  <!-- Main Container -->
  <main class="flex flex-col md:flex-row w-full min-h-screen">

    <!-- Left Section: Logo and System Title -->
    <section class="hidden md:flex w-1/2 flex-col justify-center items-center bg-blue-800 text-white p-10">
      <div class="text-center">
        <img src="assets/Logo.jfif" alt="Barangay Bahay Toro Logo" class="h-32 w-32 mx-auto rounded-full border-4 border-blue-300 shadow-lg" />
        <h1 class="text-3xl font-extrabold tracking-wide leading-tight mt-4">
          Barangay Bahay Toro <br>
          <span class="text-blue-200">Health Information System</span>
        </h1>
        <p class="text-sm text-blue-100 mt-3 max-w-sm mx-auto">
          A digital health record system designed for efficiency, accessibility, and community-centered healthcare management.
        </p>
      </div>
    </section>

    <!-- Right Section: Login Form with health-themed background -->
   <section class="flex w-full md:w-1/2 justify-center items-center bg-white relative">

  <div class="relative w-full max-w-md bg-white p-8 rounded-2xl shadow-2xl border-2 border-blue-500/40 z-10 
              hover:border-blue-600/60 transition duration-300 ease-in-out hover:shadow-blue-100">

    <!-- Decorative top accent -->
    <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-32 h-1.5 bg-gradient-to-r from-blue-400 via-blue-600 to-blue-400 rounded-full"></div>

    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
      Login to Your Account
    </h2>

    <form action="dashboard.php" method="POST" class="space-y-5">
      <!-- Username -->
      <div>
        <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden 
                    focus-within:ring-2 focus-within:ring-blue-500">
          <span class="px-3 text-gray-500"><i class="fas fa-user"></i></span>
          <input type="text" id="username" name="username" required 
                 class="w-full px-3 py-2 outline-none text-gray-700 bg-transparent" 
                 placeholder="Enter your username">
        </div>
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden 
                    focus-within:ring-2 focus-within:ring-blue-500">
          <span class="px-3 text-gray-500"><i class="fas fa-lock"></i></span>
          <input type="password" id="password" name="password" required 
                 class="w-full px-3 py-2 outline-none text-gray-700 bg-transparent" 
                 placeholder="Enter your password">
        </div>
      </div>

      <!-- Remember Me + Forgot Password -->
      <div class="flex items-center justify-between">
        <label class="flex items-center text-sm text-gray-600">
          <input type="checkbox" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
          Remember me
        </label>
        <a href="#" class="text-sm text-blue-600 hover:underline">Forgot Password?</a>
      </div>

      <!-- Submit Button -->
      <a href="modules/index.php" 
   class="block text-center w-full py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-semibold rounded-lg shadow-md transition duration-200">
  <i class="fas fa-sign-in-alt mr-2"></i> Sign In
</a>
    </form>

    <div class="text-center text-xs text-gray-500 pt-4 border-t border-gray-200 mt-6">
      © 2025 Barangay Bahay Toro | Health Information System
    </div>
  </div>
</section>

  </main>

</body>
</html>
