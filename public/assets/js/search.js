(function() {
    'use strict';

    var searchInput = document.getElementById('search-keyword');
    var filterForm = document.getElementById('filter-form');
    var suggestBox = document.getElementById('search-suggestions');
    var debounceTimer = null;

    if (searchInput && suggestBox) {
        searchInput.addEventListener('input', function() {
            var val = this.value.trim();
            clearTimeout(debounceTimer);
            if (val.length < 2) {
                suggestBox.style.display = 'none';
                return;
            }
            debounceTimer = setTimeout(function() {
                fetch(BASE_URL + '/api/search/suggest?q=' + encodeURIComponent(val), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (!data.skills || !data.skills.length) {
                        suggestBox.style.display = 'none';
                        return;
                    }
                    var html = '';
                    data.skills.forEach(function(s) {
                        html += '<a class="suggest-item" href="#" data-value="' + s.name + '">' + s.name + '</a>';
                    });
                    suggestBox.innerHTML = html;
                    suggestBox.style.display = 'block';

                    suggestBox.querySelectorAll('.suggest-item').forEach(function(item) {
                        item.addEventListener('click', function(e) {
                            e.preventDefault();
                            searchInput.value = this.getAttribute('data-value');
                            suggestBox.style.display = 'none';
                            if (filterForm) filterForm.submit();
                        });
                    });
                })
                .catch(function() {
                    suggestBox.style.display = 'none';
                });
            }, 300);
        });

        document.addEventListener('click', function(e) {
            if (!suggestBox.contains(e.target) && e.target !== searchInput) {
                suggestBox.style.display = 'none';
            }
        });
    }

    if (filterForm) {
        filterForm.querySelectorAll('select, input[type="checkbox"]').forEach(function(el) {
            el.addEventListener('change', function() {
                filterForm.submit();
            });
        });
    }

    var clearBtn = document.getElementById('clear-filters');
    if (clearBtn) {
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = this.getAttribute('href') || BASE_URL + '/jobs';
        });
    }
})();
