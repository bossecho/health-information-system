document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.getElementById("sidebar");
  const sidebarToggle = document.getElementById("sidebarToggle");
  const overlay = document.getElementById("sidebarOverlay");
  const links = document.querySelectorAll(".sidebar-link");
  const currentPage = window.location.pathname.split("/").pop();
  const query = window.location.search;

  // Highlight active link
  links.forEach(link => {
    const href = link.getAttribute("href");
    if (currentPage === href || query.includes(href.split("=")[1])) {
      link.classList.add("bg-blue-700", "text-white", "shadow-lg");
      link.classList.remove("text-gray-300");
    } else {
      link.classList.remove("bg-blue-700", "text-white", "shadow-lg");
      link.classList.add("text-gray-300");
    }
  });

  // Initial state
  let isDesktop = window.innerWidth >= 768;
  let isOpen = isDesktop;

  if (!isDesktop) {
    sidebar.classList.add("-translate-x-full");
  }

  // Toggle Sidebar
  sidebarToggle.addEventListener("click", () => {
    sidebar.classList.toggle("-translate-x-full");
    overlay.classList.toggle("hidden");
    isOpen = !isOpen;

    // Update button icon
    sidebarToggle.innerHTML = isOpen
      ? '<i class="fas fa-chevron-left text-sm"></i>'
      : '<i class="fas fa-chevron-right text-sm"></i>';
  });

  // Close sidebar when clicking overlay (mobile)
  overlay.addEventListener("click", () => {
    sidebar.classList.add("-translate-x-full");
    overlay.classList.add("hidden");
    sidebarToggle.innerHTML = '<i class="fas fa-chevron-right text-sm"></i>';
    isOpen = false;
  });

  // Handle window resize (responsive fix)
  window.addEventListener("resize", () => {
    isDesktop = window.innerWidth >= 768;
    if (isDesktop) {
      sidebar.classList.remove("-translate-x-full");
      overlay.classList.add("hidden");
      sidebarToggle.innerHTML = '<i class="fas fa-chevron-left text-sm"></i>';
      isOpen = true;
    } else if (!isOpen) {
      sidebar.classList.add("-translate-x-full");
      sidebarToggle.innerHTML = '<i class="fas fa-chevron-right text-sm"></i>';
    }
  });
});
