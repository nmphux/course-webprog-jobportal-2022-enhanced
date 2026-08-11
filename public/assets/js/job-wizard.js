(function() {
    'use strict';

    var wizard = document.getElementById('job-wizard');
    if (!wizard) return;

    var steps = wizard.querySelectorAll('.wizard-step');
    var indicators = document.querySelectorAll('.wizard-steps .step');
    var currentStep = 0;
    var STORAGE_KEY = 'job_draft';

    function showStep(index) {
        steps.forEach(function(s, i) {
            s.style.display = i === index ? 'block' : 'none';
        });
        indicators.forEach(function(ind, i) {
            ind.classList.remove('active', 'completed');
            if (i < index) ind.classList.add('completed');
            if (i === index) ind.classList.add('active');
        });
        currentStep = index;

        var prevBtn = wizard.querySelector('[data-wizard="prev"]');
        var nextBtn = wizard.querySelector('[data-wizard="next"]');
        var submitBtn = wizard.querySelector('[data-wizard="submit"]');

        if (prevBtn) prevBtn.style.display = index === 0 ? 'none' : 'inline-block';
        if (nextBtn) nextBtn.style.display = index === steps.length - 1 ? 'none' : 'inline-block';
        if (submitBtn) submitBtn.style.display = index === steps.length - 1 ? 'inline-block' : 'none';
    }

    function validateStep(index) {
        var step = steps[index];
        var required = step.querySelectorAll('[required]');
        var valid = true;
        required.forEach(function(field) {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                valid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        return valid;
    }

    function saveDraft() {
        var formData = {};
        var inputs = wizard.querySelectorAll('input, select, textarea');
        inputs.forEach(function(input) {
            if (input.name && input.type !== 'hidden' && input.type !== 'file') {
                if (input.type === 'checkbox' || input.type === 'radio') {
                    if (input.checked) formData[input.name] = input.value;
                } else if (input.tagName === 'SELECT' && input.multiple) {
                    formData[input.name] = Array.from(input.selectedOptions).map(function(o) { return o.value; });
                } else {
                    formData[input.name] = input.value;
                }
            }
        });
        try { localStorage.setItem(STORAGE_KEY, JSON.stringify(formData)); } catch(e) {}
    }

    function restoreDraft() {
        try {
            var saved = localStorage.getItem(STORAGE_KEY);
            if (!saved) return;
            var data = JSON.parse(saved);
            Object.keys(data).forEach(function(key) {
                var field = wizard.querySelector('[name="' + key + '"]');
                if (!field) return;
                if (field.tagName === 'SELECT' && field.multiple && Array.isArray(data[key])) {
                    Array.from(field.options).forEach(function(opt) {
                        opt.selected = data[key].indexOf(opt.value) !== -1;
                    });
                } else if (field.type === 'checkbox' || field.type === 'radio') {
                    field.checked = field.value === data[key];
                } else {
                    field.value = data[key];
                }
            });
        } catch(e) {}
    }

    wizard.addEventListener('click', function(e) {
        var btn = e.target.closest('[data-wizard]');
        if (!btn) return;

        var action = btn.getAttribute('data-wizard');
        if (action === 'next') {
            if (validateStep(currentStep)) {
                saveDraft();
                showStep(currentStep + 1);
            }
        } else if (action === 'prev') {
            saveDraft();
            showStep(currentStep - 1);
        }
    });

    wizard.querySelectorAll('input, select, textarea').forEach(function(el) {
        el.addEventListener('change', saveDraft);
    });

    var form = wizard.closest('form');
    if (form) {
        form.addEventListener('submit', function() {
            try { localStorage.removeItem(STORAGE_KEY); } catch(e) {}
        });
    }

    restoreDraft();
    showStep(0);
})();
