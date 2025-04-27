document.addEventListener("DOMContentLoaded", function() {
    var password = document.getElementById("password");
    var retype_password = document.getElementById("retype_password");
    var error_message = document.getElementById("error-message");
    var password_pattern = /^(?=.*[@])[A-Za-z\d@]{8,}$/;

    function validatePasswords() {
        error_message.style.display = 'none';

        if (!password_pattern.test(password.value)) {
            error_message.style.display = 'block';
            error_message.textContent = 'Password must be at least 8 characters long and contain at least one special character like @.';
            return false;
        }

        if (password.value !== retype_password.value) {
            error_message.style.display = 'block';
            error_message.textContent = 'Passwords do not match.';
            return false;
        }

        return true;
    }

    password.addEventListener("input", validatePasswords);
    retype_password.addEventListener("input", validatePasswords);
    document.querySelector("form").addEventListener("submit", function(event) {
        if (!validatePasswords()) {
            event.preventDefault();
        }
    });
});


$(document).ready(function() {
    $("#togglePassword").click(function() {
        let passwordField = $("#password");
        let passwordFieldType = passwordField.attr("type");

        if (passwordFieldType === "password") {
            passwordField.attr("type", "text");
            $(this).find("i").removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            passwordField.attr("type", "password");
            $(this).find("i").removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });

    $("#toggleRetypePassword").click(function() {
        let passwordField = $("#retype_password");
        let passwordFieldType = passwordField.attr("type");

        if (passwordFieldType === "password") {
            passwordField.attr("type", "text");
            $(this).find("i").removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            passwordField.attr("type", "password");
            $(this).find("i").removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });
});