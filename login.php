<?php 
session_start();

if (isset($_SESSION['email'])) {
    header('Location: pages/dashboard.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dishcovery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="icon" type="image/png" href="assets/img/logo.png">
    <script src ="scripts/google-api.js"></script>
</head>
<body>
<div class="container" id="container">
        <div class="form-container sign-up">
            <form>
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" onclick="GsignIn()" title="Google Sign-in" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                </div>
                <span class="text-center">or</span>
                <input type="text" id="username" placeholder="Username">
                <input type="email" id="email" placeholder="Email">
                <input type="password" id="password" placeholder="Password">
                <button id="btnSignup">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form>
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="#" onclick="GsignIn()" title="Google Sign-in" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                </div>
                <span class="text-center">or</span>
                <input type="username" id="username1" placeholder="Username">
                <input type="password" id="password1" placeholder="Password">
                <button id="btnSignIn">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome back!</h1>
                    <p>We need you again, please login</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>New to Dishcovery?</h1>
                    <p>Register now to browse our community</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script src="scripts/switching.js"></script>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
$(document).ready(function() {
    $("#btnSignIn").click(function(event) {
        event.preventDefault(); // Prevent default form submission behavior
        signIn();
    });

    $("#btnSignup").click(function(event) {
        event.preventDefault(); // Prevent default form submission behavior
        signUp();
    });
});

function signIn() {
    var username = $("#username1").val();
    var password = $("#password1").val();

    var send_data = {
        username: username,
        password: password
    };

    $.ajax({
        url: "api/sign_in.php",
        type: "POST",
        data: send_data,
        dataType: "json", // Expecting JSON response
        beforeSend: function() {
            // You can show a loading spinner or any indication that the request is being processed
        },
        success: function(response) {
            // Handle success response
            console.log(response);
            if (response.hasOwnProperty('error')) {
                // Display error message if 'error' property exists in response
                Swal.fire({
                    icon: 'error',
                    title: 'Sign In Error',
                    text: response.error
                });
            } else if (response.hasOwnProperty('success')) {
                // Display success message if 'success' property exists in response
                Swal.fire({
                    icon: 'success',
                    title: 'Sign In Successful',
                    text: response.success,
                    // Redirect to dashboard if provided in response
                    didClose: () => {
                        if (response.hasOwnProperty('redirect')) {
                            window.location.href = response.redirect;
                        }
                    }
                });
            }
            // Redirect or perform any necessary action upon successful sign-in
        },
        error: function(error) {
            // Handle error
            console.log(error);
        }
    });
}

function signUp() {
    var username = $("#username").val();
    var email = $("#email").val();
    var password = $("#password").val();

    var send_data = {
        username: username,
        email: email,
        password: password
    };

    $.ajax({
        url: "api/sign_up.php",
        type: "POST",
        data: send_data,
        dataType: "json", // Specify the expected data type as JSON
        beforeSend: function() {
            // You can show a loading spinner or any indication that the request is being processed
        },
        success: function(response) {
            // Handle success response
            console.log(response);
            if (response.hasOwnProperty('error')) {
                // Display error message if 'error' property exists in response
                Swal.fire({
                    icon: 'error',
                    title: 'Sign Up Error',
                    text: response.error
                });
            } else {
                // Display success message if 'success' property exists in response
                $("#username").val('');
                $("#email").val('');
                $("#password").val('');

                Swal.fire({
                    icon: 'success',
                    title: 'Sign Up Successful',
                    text: 'New record created successfully!'
                });
            }
            // Redirect or perform any necessary action upon successful sign-up
        },
        error: function(error) {
            // Handle error
            console.log(error);
        }
    });
}

</script>

</html>