function updateChildCheckboxes(parentCheckbox) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function(checkbox) {
        if (checkbox.getAttribute('parent') === parentCheckbox.value) {
            checkbox.checked = parentCheckbox.checked;
        }
    });
}
