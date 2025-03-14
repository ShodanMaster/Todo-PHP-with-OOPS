$(document).ready(function () {
    $('#show-signup-form').click(function() {
        $('#login-form').hide();
        $('#signup-form').show();
        $('#form-title').text('Signup');
    });

    // Show login form when the "Login" link in the signup form is clicked
    $('#show-login-form').click(function() {
        $('#signup-form').hide();
        $('#login-form').show();
        $('#form-title').text('Login');
    });

    // Toggle password visibility for login form
    $('#show-password').change(function() {
        var passwordField = $('#password');
        if ($(this).prop('checked')) {
            passwordField.attr('type', 'text');
        } else {
            passwordField.attr('type', 'password');
        }
    });

    // Toggle password visibility for signup form (password)
    $('#show-signup-password').change(function() {
        var signupPasswordField = $('#signup-password');
        if ($(this).prop('checked')) {
            signupPasswordField.attr('type', 'text');
        } else {
            signupPasswordField.attr('type', 'password');
        }
    });

    $(document).on('submit', '#login-form', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        
        $.ajax({
            type: "POST",
            url: "actions/login.php?action=login",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                if (response.status === 200) {
                
                    swal({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        button: "OK",
                    }).then(() => {
                        window.location.href = response.url;
                    });
                } else {
                    swal({
                        title: "Error!",
                        text: response.message,
                        icon: "error",
                        button: "OK",
                    });
                }                    
            }
        });
    });

    $(document).on("submit", "#signup-form", function (e) {
        e.preventDefault();

        if (!validateForm()) {
            return;
        }

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "actions/login.php?action=signup",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json", // Ensure JSON response
            success: function (response) {
                if (response.status === 200) {
                    swal({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        button: "OK",
                    }).then(() => {
                        window.location.href = response.url || "index.php"; // Redirect after signup
                    });
                } else {
                    swal({
                        title: "Error!",
                        text: response.message,
                        icon: "error",
                        button: "OK",
                    });
                }
            },
            error: function () {
                swal({
                    title: "Error!",
                    text: "Something went wrong. Please try again!",
                    icon: "error",
                    button: "OK",
                });
            }
        });
    });

    function validateForm() {
        let username = $("#signup-username").val().trim();
        let password = $("#signup-password").val().trim();
        let confirmPassword = $("#signup-password-confirmation").val().trim();

        if (username === "" || password === "" || confirmPassword === "") {
            swal({
                title: "Error!",
                text: "All fields are required!",
                icon: "error",
                button: "OK",
            });
            return false;
        }

        if (password.length < 6) {
            swal({
                title: "Error!",
                text: "Password must be at least 6 characters long!",
                icon: "error",
                button: "OK",
            });
            return false;
        }

        if (password !== confirmPassword) {
            swal({
                title: "Error!",
                text: "Passwords do not match!",
                icon: "error",
                button: "OK",
            });
            return false;
        }

        return true;
    }
    
});