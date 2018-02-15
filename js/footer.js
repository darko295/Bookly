    function sendQuestion() {
        var email = $('#question_email').val();
        var question = $('#question_text').val();
        var form = document.getElementById("question_form");
        var inpObj = document.getElementById("question_email");
        var inpObj1 = document.getElementById("question_text");
        var valid = true;
        var action = "insert_question";
        if (!inpObj.checkValidity()) {
            document.getElementById("error-msg").innerHTML = inpObj.validationMessage;
            inpObj.style.border = "2px solid red";
            $("#error-msg").show();

            valid = false;
        }else{
            $("#error-msg").hide();
            inpObj.style.border = "none";
        }

        if (!inpObj1.checkValidity()) {
            document.getElementById("error-msg1").innerHTML = inpObj1.validationMessage;
            inpObj1.style.border = "2px solid red";
            valid = false;
            $("#error-msg1").show();

        }else{
            $("#error-msg1").hide();
            inpObj1.style.border = "none";
        }

        if(valid){

            $.ajax({
                type: "POST",
                url: "controllers/controller.php",
                data: {
                    action:action,
                    email: email,
                    question: question
                },
                success: function (result) {
                    if (result === "1") {
                        form.reset();
                        swal("Question sent!", "We will reply to you shortly", "success");
                    } else {
                        swal("Error sending question!", "Please try again later", "error");
                    }
                }
            });
        }
    }