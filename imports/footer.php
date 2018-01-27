<html>
<head>
<!--    <link rel="stylesheet" href="../css/style.css">-->

    <style>
        #question_email, #question_text {
            background-color: lightgray;
            border: none;
            padding-left: 2px;
            border-radius: 6px;
            outline: 0;
            margin-right: 120px;
            height: 1.9rem;
            font-size: 1rem;
            box-shadow: none;
            box-sizing: content-box;
            -webkit-transition: all .3s;
            transition: all .3s;
            width: 70%;

        }

        #question_button {
            font-size: .8rem;
            padding: .55rem 1.33rem;
            margin: 6px;
            margin-left: 2px;
            border-radius: 2px;
            border: 0;
            -webkit-transition: .2s ease-out;
            transition: .2s ease-out;
            white-space: normal !important;
            cursor: pointer;
            float: left;
        }

        #question_text {
            border-radius: 6px;
            height: 3rem;
            background-color: lightgray;
            width: 100%;
        }
    </style>

    <script>


    </script>

    <script type="text/javascript">
        function sendQuestion() {
            var email = $('#question_email').val();
            var question = $('#question_text').val();
            var form = document.getElementById("question_form");
            var inpObj = document.getElementById("question_email");
            var inpObj1 = document.getElementById("question_text");
            var valid = true;

            if (!inpObj.checkValidity()) {
                document.getElementById("error-msg").innerHTML = inpObj.validationMessage;
                inpObj.style.border = "2px solid red";
                valid = false;
            }

            if (!inpObj1.checkValidity()) {
                document.getElementById("error-msg1").innerHTML = inpObj1.validationMessage;
                inpObj1.style.border = "2px solid red";

                valid = false;
            }

            if(valid){

            $.ajax({
                type: "POST",
                url: "question_process.php",
                data: {
                    email: email,
                    question: question
                },
                success: function (result) {
                    if (result === "1") {

                        form.reset();
                        alert("Dodato");

                    } else {
                        alert("Greska");
                    }
                }
            });
            }

        }

    </script>

</head>
<body>

<footer class="page-footer center-on-small-only mt-0">

    <!--Footer links-->
    <div class="container-fluid">
        <div class="row">
            <!--First column-->
            <div class="col-md-3 ml-auto" style="text-align: justify">
                <h5 class="title mb-3"><strong>O bookly portalu</strong></h5><br>
                <p style="line-height: 110%">Bookly je portal namenjen svima koji citaju i voljni su da podele svoje
                    utiske.</p>
                <p style="line-height: 110%">Na taj nacin pomazete drugima da se opredele za naredni naslov, a takodje
                    ih motivisete da i oni
                    podele njihove utiske.</p>
            </div>
            <!--/.First column-->
            <hr class="w-100 clearfix d-sm-none">
            <!--Second column-->
            <div class="col-md-3" style="margin-left: 60px;text-align: justify">
                <h5 class="title mb-3"><strong>Kontakt</strong></h5><br>
                <p style="line-height: 110%">Za sva pitanja, kritike i sugestije mozete nas kontaktirati putem telefona,
                    mejla ili popunjavanjem
                    forme desno.</p>
                <ul>
                    <li>
                        <div><i class="fa fa-phone" aria-hidden="true"></i> 0800/854-356</div>
                    </li>
                    <li>
                        <div><i class="fa fa-envelope" aria-hidden="true"></i> booklyoffice@gmail.com</div>
                    </li>
                </ul>
            </div>
            <!--/.Second column-->
            <!--Third column-->
            <div class="col-md-3  ml-auto">
                <form id="question_form" method="post">
                    <div class="form-group">
                        <label for="question_email">Email address:</label>
                        <input type="email" class="form-control-footer" id="question_email" required/>
                        <span id="error-msg"></span>
                    </div>
                    <div class="form-group">
                        <label for="question_text">Question:</label>
                        <textarea rows="6" cols="30" minlength="15" maxlength="1000"
                                  class="form-control-footer" id="question_text" required></textarea>
                        <span id="error-msg1"></span>

                    </div>

                    <button type="button" id="question_button" onclick="sendQuestion()" class="btn btn-default">Send</button>
                </form>
            </div>
            <div class="col-md-1"></div>


        </div>
    </div>

    <hr>


    <!--Copyright-->
    <div class="footer-copyright">
        <div class="container-fluid">© 2017 Made by Bookly Team, Design used: <a href="https://www.MDBootstrap.com">
                MDBootstrap.com </a>

        </div>
    </div>
    <!--/.Copyright-->

</footer>

</body>
</html>