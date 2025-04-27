$(document).ready(function() {
        $("#toggleCurrentPassword").click(function() {
            let passwordField = $("#current_password");
            let passwordFieldType = passwordField.attr("type");

            if (passwordFieldType == "password") {
                passwordField.attr("type", "text");
                $(this).find("i").removeClass("fa-eye").addClass("fa-eye-slash");
            } else {
                passwordField.attr("type", "password");
                $(this).find("i").removeClass("fa-eye-slash").addClass("fa-eye");
            }
        });

        $("#toggleNewPassword").click(function() {
            let passwordField = $("#new_password");
            let passwordFieldType = passwordField.attr("type");

            if (passwordFieldType == "password") {
                passwordField.attr("type", "text");
                $(this).find("i").removeClass("fa-eye").addClass("fa-eye-slash");
            } else {
                passwordField.attr("type", "password");
                $(this).find("i").removeClass("fa-eye-slash").addClass("fa-eye");
            }
        });

        $("#toggleConfirmPassword").click(function() {
            let passwordField = $("#confirm_password");
            let passwordFieldType = passwordField.attr("type");

            if (passwordFieldType == "password") {
                passwordField.attr("type", "text");
                $(this).find("i").removeClass("fa-eye").addClass("fa-eye-slash");
            } else {
                passwordField.attr("type", "password");
                $(this).find("i").removeClass("fa-eye-slash").addClass("fa-eye");
            }
        });
    });
