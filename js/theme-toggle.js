document.addEventListener("DOMContentLoaded", function () {
  const body = document.body;
  const toggle = document.getElementById("themeToggle");

  // Apply saved theme from localStorage
  const savedTheme = localStorage.getItem("theme") || "light";
  body.classList.add(savedTheme + "-theme");

  if (toggle) {
    toggle.addEventListener("click", () => {
      if (body.classList.contains("light-theme")) {
        body.classList.replace("light-theme", "dark-theme");
        localStorage.setItem("theme", "dark");
      } else {
        body.classList.replace("dark-theme", "light-theme");
        localStorage.setItem("theme", "light");
      }
    });
  }
});

