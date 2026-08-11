(function () {
  // Restore saved theme on page load
  var saved = localStorage.getItem("jobhub_theme") || "noon";
  document.documentElement.setAttribute("data-theme", saved);
})();

function setTheme(name) {
  localStorage.setItem("jobhub_theme", name);
  document.documentElement.setAttribute("data-theme", name);

  // Update active state on theme cards if they exist
  document.querySelectorAll(".theme-card").forEach(function (card) {
    var theme = card.getAttribute("data-theme-name");
    if (theme === name) {
      card.style.borderColor = "var(--primary)";
      card.style.boxShadow = "0 0 0 2px var(--primary-focus-shadow)";
    } else {
      card.style.borderColor = "var(--border)";
      card.style.boxShadow = "none";
    }
  });
}

function selectTheme(name) {
  setTheme(name);
  highlightActiveTheme();
}

function highlightActiveTheme() {
  var current = localStorage.getItem("jobhub_theme") || "noon";
  document.querySelectorAll(".theme-card").forEach(function (card) {
    if (card.getAttribute("data-theme-name") === current) {
      card.style.borderColor = "var(--primary)";
      card.style.boxShadow = "0 0 0 2px var(--primary-focus-shadow)";
    } else {
      card.style.borderColor = "var(--border)";
      card.style.boxShadow = "none";
    }
  });
}
