<html>
<head>


    <script type="text/javascript">
        $(document).ready(function () {
            $("#signup-username").blur(function () {
                var vrednost = $("#signup-username").val();
                if (vrednost.length < 3) {
                    $("#info").html("Username too short!");
                    $("#signup-username").focus();
                } else if (vrednost.length > 18) {
                    $("#info").html("Username too long!");
                    $("#signup-username").focus();
                } else {
                    $.get("signup_validation.php", {create_username: vrednost},
                        function (data) {
                            if (data == 0) {
                                $("#info").html("Username not available");
                                $("#signup-username").focus();
                            }
                            if (data == 1) {
                                $("#info").html("Username available");
                            }
                        });
                }
            });
        });
    </script>


    <script type="text/javascript">
        function valid_login() {
            var login_username = $('#signin-username').val();
            var login_password = $('#signin-password').val();

            if (login_username.length < 3 || login_password.length < 5) {
                $("#failed-login").html("Username or password is/are too short!");
                return;
            } else {

                $.ajax({
                    type: "POST",
                    url: "login_validation.php",
                    data: {
                        username: login_username,
                        password: login_password
                    },
                    success: function (result) {
                        if (result) {
                            $("#failed-login").html("Redirecting to reviews page...");
                            setTimeout(' window.location.href = "bookly.php"; ', 3000);
                        } else {
                            $("#failed-login").html("Wrong credentials!");

                        }
                    }
                });
            }
        }

    </script>

    <script type="text/javascript">
        function password_reset() {

            var email_reset = $('#reset-email').val();


            $.ajax({
                type: "POST",
                url: "password_reset.php",
                data: {
                    email: email_reset
                },
                success: function (result) {
                    if (result == 1) {

                        $("#failed-reset").html("Check out your mail!");

                    } else {
                        $("#failed-reset").html("Wrong email given!");

                    }
                }
            });
        }

    </script>

    <script>

        function show_form() {
            $("#registration").click();
        }

    </script>

<style>

    .cd-form input {
        margin: 0;
        padding: 0;
        border-radius: 0.25em;
    }

    .cd-form input.has-border:focus {
        border-color: #343642;
        box-shadow: 0 0 5px rgba(52, 54, 66, 0.1);
        outline: none;

    .cd-form input.has-border {
        border: 1px solid #d2d8d8;
        -webkit-appearance: none;
        -moz-appearance: none;
        -ms-appearance: none;
        -o-appearance: none;
        appearance: none;
    }

</style>



</head>

<body>

<div class="cd-user-modal">
    <div class="cd-user-modal-container">
        <ul class="cd-switcher">
            <li style="list-style: none; text-align: center; margin-left: -20px "
            "><a href="#0">Sign in</a></li>
            <li style="list-style: none"><a href="#0">New account</a></li>
        </ul>


        <div id="cd-login"> <!-- log in form -->
            <form class="cd-form" id="login-form" method="post">

                <div id="failed-login"></div>

                <p class="fieldset">
                    <label class="image-replace cd-username" for="signin-username">Username</label>
                    <input class="full-width has-padding has-border" id="signin-username" minlength="3"
                           name="login_username" type="text" placeholder="Username" required>
                    <span class="cd-error-message">Wrong username!</span>
                </p>

                <p class="fieldset">
                    <label class="image-replace cd-password" for="signin-password">Password</label>
                    <input class="full-width has-padding has-border" name="login_password" id="signin-password"
                           minlength="5" type="password" placeholder="Password" required>
                    <a href="#0" class="hide-password">Show</a>
                    <span class="cd-error-message">Password must be at least 5 chars long.</span>
                </p>


                <p class="fieldset">
                    <input class="full-width-button" id="login-submit" type="button" name="login_submit"
                           onclick="valid_login()" value="Login">
                </p>

                <div class="cd-form-bottom-message"><a href="#0">Forgot your password?</a></div>

            </form>


        </div> <!-- end of login form -->


        <div id="cd-signup"> <!-- sign up form -->
            <form class="cd-form" id="create_form" method="post" action="signup.php">
                <p class="fieldset">
                    <label class="image-replace cd-username" for="signup-username">Username</label>
                    <input class="full-width has-padding has-border" name="create_username" id="signup-username"
                           minlength="3" maxlength="17" type="text" required placeholder="Username">
                <div id="info"></div>

                </p>

                <p class="fieldset">
                    <label class="image-replace cd-email" for="signup-email">E-mail</label>
                    <input class="full-width has-padding has-border" name="create_email" id="signup-email" type="email"
                           minlength="10" required placeholder="E-mail"
                           oninvalid="this.setCustomValidity('Enter your e-mail Here')"
                           oninput="setCustomValidity('')">
                    <span class="cd-error-message">Wrong e-mail format!</span>
                </p>

                <p class="fieldset">
                    <label class="image-replace cd-password" for="signup-password">Password</label>
                    <input class="full-width has-padding has-border" name="create_password" id="signup-password"
                           minlength="5" type="password" required placeholder="Password">
                    <a href="#0" class="hide-password">Show</a>
                    <span class="cd-error-message">Password must be at least 5 chars long!</span>
                </p>

                <p class="fieldset">
                    <input type="checkbox" id="accept-terms" name="create_checkbox" required>
                    <label for="accept-terms">I agree to the <a href="#0">Terms</a></label>
                </p>

                <p class="fieldset">
                    <input class="full-width-button has-padding" name="create_submit" type="submit"
                           value="Create account">
                </p>
            </form>


        </div> <!-- end of signup form-->

        <div id="cd-reset-password"> <!-- reset password form -->
            <p class="cd-form-message">Lost your password? Please enter your email address. You will receive your
                password.</p>

            <form class="cd-form" method="post" action="password_reset.php">
                <p class="fieldset">
                    <label class="image-replace cd-email" for="reset-email">E-mail</label>
                    <input class="full-width has-padding has-border" id="reset-email" name="email_reset" required
                           type="email" placeholder="E-mail">
                <div id="failed-reset"></div>
                <span class="cd-error-message">Error message here!</span>
                </p>

                <p class="fieldset">
                    <input class="full-width-button has-padding" id="reset-button" type="button" name="reset_pass"
                           onclick="password_reset()" value="Reset password">
                </p>
                <div class="cd-form-bottom-message"><a href="#0">Back to log-in</a></div>

            </form>

        </div> <!-- end of reset password form -->
        <a href="#0" class="cd-close-form">Close</a>
    </div>
</div>


</body>
</html>