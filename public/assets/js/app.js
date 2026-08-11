(function () {
  "use strict";

  // ============================================================
  // TOAST NOTIFICATION SYSTEM
  // ============================================================
  function setupToasts() {
    var container = document.getElementById("toastContainer");
    if (!container) return;

    container.querySelectorAll(".toast").forEach(function (toast) {
      var closeBtn = toast.querySelector(".toast-close");
      if (closeBtn) {
        closeBtn.addEventListener("click", function (e) {
          e.stopPropagation();
          dismissToast(toast);
        });
      }
      toast.addEventListener("click", function () {
        dismissToast(toast);
      });
      setTimeout(function () {
        if (toast.parentNode) dismissToast(toast);
      }, 6000);
    });
  }

  function dismissToast(toast) {
    if (toast.classList.contains("removing")) return;
    toast.classList.add("removing");
    setTimeout(function () {
      if (toast.parentNode) {
        toast.remove();
        var container = document.getElementById("toastContainer");
        if (container && container.children.length === 0) container.remove();
      }
    }, 300);
  }

  window.showToast = function (type, message) {
    var container = document.getElementById("toastContainer");
    if (!container) {
      container = document.createElement("div");
      container.className = "toast-container";
      container.id = "toastContainer";
      document.body.prepend(container);
    }
    var iconMap = {
      success: '<i class="fas fa-check-circle toast-icon"></i>',
      error: '<i class="fas fa-exclamation-circle toast-icon"></i>',
      warning: '<i class="fas fa-exclamation-triangle toast-icon"></i>',
      info: '<i class="fas fa-info-circle toast-icon"></i>',
    };
    var toast = document.createElement("div");
    toast.className = "toast toast-" + type;
    toast.setAttribute("role", "alert");
    toast.innerHTML =
      (iconMap[type] || iconMap.info) +
      '<span class="toast-content">' +
      message +
      "</span>" +
      '<button type="button" class="toast-close" aria-label="Close">&times;</button>';
    container.appendChild(toast);
    var closeBtn = toast.querySelector(".toast-close");
    if (closeBtn) {
      closeBtn.addEventListener("click", function (e) {
        e.stopPropagation();
        dismissToast(toast);
      });
    }
    toast.addEventListener("click", function () {
      dismissToast(toast);
    });
    setTimeout(function () {
      if (toast.parentNode) dismissToast(toast);
    }, 6000);
  };

  // ============================================================
  // BACK TO TOP
  // ============================================================
  function setupBackToTop() {
    var btn = document.getElementById("backToTop");
    if (!btn) return;
    window.addEventListener(
      "scroll",
      function () {
        btn.classList.toggle("visible", window.scrollY > 400);
      },
      { passive: true },
    );
    btn.addEventListener("click", function () {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  // ============================================================
  // INTERSECTION OBSERVER — Animations
  // ============================================================
  function setupAnimations() {
    if ("IntersectionObserver" in window) {
      var observer = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              entry.target.classList.add("visible");
              observer.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.1, rootMargin: "0px 0px -40px 0px" },
      );
      document.querySelectorAll(".fade-in-up").forEach(function (el) {
        observer.observe(el);
      });
    } else {
      document.querySelectorAll(".fade-in-up").forEach(function (el) {
        el.classList.add("visible");
      });
    }
  }

  // ============================================================
  // SETTINGS TABS
  // ============================================================
  function setupTabs() {
    document.querySelectorAll("[data-tabs-id]").forEach(function (tab) {
      tab.addEventListener("click", function (e) {
        e.preventDefault();
        var targetClass = this.getAttribute("data-tabs-id");
        document.querySelectorAll("[data-tabs-id]").forEach(function (t) {
          t.classList.remove("active");
        });
        document.querySelectorAll(".boxinfo").forEach(function (panel) {
          panel.classList.remove("active");
          panel.style.display = "none";
        });
        this.classList.add("active");
        var panel = document.querySelector("." + targetClass);
        if (panel) {
          panel.classList.add("active");
          panel.style.display = "block";
        }
        history.replaceState(null, "", "#" + targetClass);
      });
    });
  }

  // ============================================================
  // FORM SUBMIT SPINNERS
  // ============================================================
  function setupFormSpinners() {
    document.querySelectorAll("form").forEach(function (form) {
      form.addEventListener("submit", function () {
        var btns = this.querySelectorAll('[type="submit"]');
        btns.forEach(function (btn) {
          if (btn.disabled) return;
          btn.disabled = true;
          var originalHtml = btn.innerHTML;
          btn.dataset.originalHtml = originalHtml;
          btn.innerHTML =
            '<i class="fas fa-spinner spin"></i> ' +
            (btn.dataset.loadingText || "Processing...");
          setTimeout(function () {
            if (btn.disabled) {
              btn.disabled = false;
              btn.innerHTML = btn.dataset.originalHtml || originalHtml;
            }
          }, 15000);
        });
      });
    });
  }

  // ============================================================
  // THEME TOGGLE
  // ============================================================
  function setupThemeToggle() {
    document.querySelectorAll("[data-theme-toggle]").forEach(function (btn) {
      btn.addEventListener("click", function () {
        var theme = this.getAttribute("data-theme-toggle");
        if (typeof setTheme === "function") setTheme(theme);
        // Show toast confirming theme change
        var names = {
          dawn: "Dawn Sunrise",
          noon: "Noon Bright",
          dusk: "Dusk Twilight",
          night: "Night Starry",
        };
        window.showToast(
          "success",
          "Theme changed to " + (names[theme] || theme),
        );
      });
    });
  }

  // ============================================================
  // CONFIRM DIALOGS
  // ============================================================
  function setupConfirmDialogs() {
    document.querySelectorAll("[data-confirm]").forEach(function (el) {
      el.addEventListener("click", function (e) {
        if (!confirm(this.getAttribute("data-confirm"))) e.preventDefault();
      });
    });
  }

  // ============================================================
  // SEARCH SUGGESTIONS
  // ============================================================
  function setupSearchSuggest() {
    var searchInputs = document.querySelectorAll('input[name="q"]');
    searchInputs.forEach(function (input) {
      var container = input.closest(".search-bar") || input.parentElement;
      var suggestBox = document.createElement("div");
      suggestBox.className = "search-suggestions";
      suggestBox.style.cssText =
        "display:none;position:absolute;top:100%;left:0;right:0;background:var(--bg-card);border:1px solid var(--border);border-radius:0 0 var(--radius-md) var(--radius-md);box-shadow:0 8px 24px var(--shadow-lg);z-index:100;max-height:320px;overflow-y:auto;";
      container.style.position = "relative";
      container.appendChild(suggestBox);

      var debounceTimer;
      input.addEventListener("input", function () {
        clearTimeout(debounceTimer);
        var q = this.value.trim();
        if (q.length < 2) {
          suggestBox.style.display = "none";
          return;
        }
        debounceTimer = setTimeout(function () {
          fetch(BASE_URL + "/api/search/suggest?q=" + encodeURIComponent(q))
            .then(function (r) {
              return r.json();
            })
            .then(function (data) {
              suggestBox.innerHTML = "";
              if (data.length === 0) {
                suggestBox.style.display = "none";
                return;
              }
              data.forEach(function (item) {
                var a = document.createElement("a");
                a.href =
                  BASE_URL +
                  "/jobs?q=" +
                  encodeURIComponent(item.title || item.name || "");
                a.className = "suggestion-item";
                a.style.cssText =
                  "display:block;padding:0.625rem 0.875rem;font-size:0.875rem;color:var(--text);text-decoration:none;transition:background 0.15s;";
                a.textContent = item.title || item.name || "";
                a.addEventListener("mouseenter", function () {
                  this.style.background = "var(--bg-surface)";
                });
                a.addEventListener("mouseleave", function () {
                  this.style.background = "transparent";
                });
                suggestBox.appendChild(a);
              });
              suggestBox.style.display = "block";
            })
            .catch(function () {
              suggestBox.style.display = "none";
            });
        }, 300);
      });
      input.addEventListener("blur", function () {
        setTimeout(function () {
          suggestBox.style.display = "none";
        }, 200);
      });
      input.addEventListener("focus", function () {
        if (suggestBox.children.length > 0) suggestBox.style.display = "block";
      });
    });
  }

  // ============================================================
  // RESPONSIVE TABLE WRAPPER
  // ============================================================
  function setupTables() {
    document.querySelectorAll(".table").forEach(function (table) {
      if (!table.closest(".table-responsive")) {
        var wrapper = document.createElement("div");
        wrapper.className = "table-responsive";
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
      }
    });
  }

  // ============================================================
  // ANALYTICS COUNTER ANIMATION
  // ============================================================
  function setupCounters() {
    document.querySelectorAll("[data-counter]").forEach(function (el) {
      var target = parseInt(el.getAttribute("data-counter"));
      var current = 0;
      var step = Math.ceil(target / 30);
      var timer = setInterval(function () {
        current += step;
        if (current >= target) {
          current = target;
          clearInterval(timer);
        }
        el.textContent = current.toLocaleString();
      }, 40);
    });
  }

  // ============================================================
  // STAT CARD ANIMATIONS
  // ============================================================
  function setupStatCards() {
    if ("IntersectionObserver" in window) {
      var observer = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              entry.target.style.opacity = "1";
              entry.target.style.transform = "translateY(0)";
              observer.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.2 },
      );
      document.querySelectorAll(".stat-card").forEach(function (card) {
        card.style.opacity = "0";
        card.style.transform = "translateY(20px)";
        card.style.transition = "opacity 0.5s ease, transform 0.5s ease";
        observer.observe(card);
      });
    }
  }

  // ============================================================
  // INIT
  // ============================================================
  function init() {
    setupToasts();
    setupBackToTop();
    setupAnimations();
    setupTabs();
    setupFormSpinners();
    setupThemeToggle();
    setupConfirmDialogs();
    setupSearchSuggest();
    setupTables();
    setupCounters();
    setupStatCards();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }

  window.getCsrfToken = function () {
    var meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute("content") : "";
  };
})();
