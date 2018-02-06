//validacija username-a prilikom registracije
$(document).ready(function () {
    $("#signup-username").blur(function () {
        var vrednost = $("#signup-username").val();
        var action = "signup_validation";
        if (vrednost.length < 3) {
            $("#info").html("Username too short!");
            $("#signup-username").focus();
        } else if (vrednost.length > 18) {
            $("#info").html("Username too long!");
            $("#signup-username").focus();
        }else if(!isNaN(vrednost)){
            $("#info").html("Username can't be a number.");
            $("#signup-username").focus();
        } else {
            $.get("controllers/controller.php", {create_username: vrednost, action : action},
                function (data) {
                    if (data === "0") {
                        $("#info").html("Username not available");
                        $("#signup-username").focus();
                    }else{
                        $("#info").html("Username available");
                    }
                });
        }
    });
});

//validacija prilikom logovanja
function valid_login() {
    var login_username = $('#signin-username').val();
    var login_password = $('#signin-password').val();

    if (login_username.length < 3 || login_password.length < 5) {
        $("#failed-login").html("Username or password is/are too short!");
    } else {
        $.ajax({
            type: "POST",
            url: "controllers/controller.php",
            data: {
                username: login_username,
                password: login_password,
                action : "login_validation"
            },
            success: function (result) {
                if (result === "1") {
                    $("#failed-login").html("Redirecting to reviews page...");
                    $("#loader").show();
                    setTimeout(' window.location.href = "bookly.php"; ', 3000);
                } else {
                    $("#failed-login").html("Wrong credentials!");

                }
            }
        });
    }
}

//resetovanje password-a
function password_reset() {
    var email_reset = $('#reset-email').val();
    var action = "send_mail";
    $.ajax({
        type: "POST",
        url: "controllers/controller.php",
        data: {
            email: email_reset,
            action:action
        },
        beforeSend: function () {
            $("#loader-password-reset").show();
            $("#reset-info").html(" Processing...");
        },
        success: function (result) {
            if (result === "1") {
                $("#reset-info").html("Check out your mail!");
                $("#loader-password-reset").hide();

            } else {
                $("#reset-info").html(result);
                $("#loader-password-reset").hide();
            }
        }
    });
}

//prikazi formu kad se klikne na 'registruj se' post
function show_form() {
    $("#registration").click();
}

