<?php
include('config.php');
include('inc/header.php');

?>
<title>Login Page</title>
<link rel="stylesheet" href="css/indexstyle.css">
</head>

<body>

<?php include('inc/container.php'); ?>

    <div class="container" style="margin-top: 2%; margin-bottom: 5%;">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 col-xl-4">
                <div class="card mb-5">
                    <div class="card-body flex-column align-items-center">
                        <!-- <br> -->
                       <center> <div class="iconn"> <a class="navbar-brand" href="index.php">&nbsp;&nbsp;<img src="images/citylogo.png" width="130" height="70" alt=""></a></div>
                        <span class="sign" style="color: black">Log in to your account</span></center> <br><br>
                        <div class="col-11 mx-auto">
                        <form class="text-center" id="mayform" name="my-form" action="" method="POST">
                            <?php echo display_error();
                            ?>
                            <div class="mb-2" align="left" ;><label style="color: black" class="form-label">Email</label>&nbsp;<span style="color:red;  font-size: 13px;" id="errorEmail2"></span><input class="form-control" onkeyup="emailValidate2()" name="email2" id="email2" placeholder="Username or Email" required /></div>
                            <div class="mb-2" align="left" ;><label style="color: black" class="form-label">Password</label>&nbsp;<span style="color:red;  font-size: 13px;" id="errorPassword2"></span><input class="form-control" type="password" onkeyup="passwordValidate2()" name="password2" id="password2" placeholder="Password" minlength="6" required />
                            </div><br>
                            <div class="col-6 mb-3 mx-auto"><input type="submit" name="submit" class="btn btn-primary d-block w-100" value="LOGIN"></div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php


    ?>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function passwordValidate2() {
            let password = $("#password2").val();
            var flag = 0;

            if (password == "") {
                $("#password2").css("border", "1px solid red");
                $('#errorPassword2').html("Password is required");
                flag = 1;
            } else if (password.length < 6) {
                $("#password2").css("border", "1px solid red");
                $('#errorPassword2').html("Password  must be more than 6 characters");
                flag = 1;
            } else if (!password.match(/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{6,20}$/)) {
                $("#password2").css("border", "1px solid red");
                $('#errorPassword2').html("Password not strong nough. Must have [!@#$%^&*-], [0-9], [A-Z]");
                flag = 1;
            } else {
                $("#password2").css("border", "1px solid grey");
                $('#errorPassword2').html("");
                flag = 0;
            }

            return flag;
            alert('eme');

        }


        function emailValidate2() {

            let email = $('#email2').val();
            let re = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
            var emailFormat = re.test(email); // This return result in Boolean type
            var flag = 0;

            if (email == "") {
                $('#email2').css("border", "1px solid red");
                $('#errorEmail2').html("Email is required");
                flag = 1;
            } else if (!emailFormat) {
                $('#email2').css("border", "1px solid red");
                $('#errorEmail2').html("Email is invalid");
                flag = 1;
            } else {
                $('#email2').css("border", "1px solid grey");
                $('#errorEmail2').html("");
                flag = 0;
            }
            return flag;
        }




        function validateForm() {
            event.preventDefault();
            var flag = 0;

            var emailval = $('#email2').val();
            var passwordval = $('#password').val();

            if (emailval == "") {
                $('#email2').css("border", "1px solid red");
                $('#errorEmail2').html("Email is required");
                flag = 1;
            } else {
                $('#email2').css("border", "1px solid grey");
                $('#errorEmail2').html("");
            }

            if (passwordval == "") {
                $("#password2").css("border", "1px solid red");
                $('#errorPassword2').html("Password is required");
                flag = 1;
            } else {
                $("#password2").css("border", "1px solid grey");
                $('#errorPassword2').html("");
            }


            if (emailValidate2(emailval) + passwordValidat2(passwordval) + flag == 0) {
                var form = document.getElementById('mayform');
                document.getElementById('mayform').submit();

            }
        }
    </script>

</body>

</html>