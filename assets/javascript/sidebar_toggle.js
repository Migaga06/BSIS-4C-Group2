document.addEventListener('DOMContentLoaded', function() {
    var wrapper = document.getElementById('wrapper');
    var menuToggle = document.getElementById('menu-toggle');
    var toggleIcon = document.getElementById('toggle-icon');

    menuToggle.addEventListener('click', function(e) {
        e.preventDefault();
        wrapper.classList.toggle('toggled');
        
        if (wrapper.classList.contains('toggled')) {
            toggleIcon.classList.remove('fa-times');
            toggleIcon.classList.add('fa-bars');
        }  else {
            toggleIcon.classList.remove('fa-bars');
            toggleIcon.classList.add('fa-times');
        }
    });
});