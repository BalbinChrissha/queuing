<link rel="icon" type="image/png" href="images/PSU_logo1.png">
</head>

<body class="">



    <nav class="navbar navbar-light bg-light navbar-expand-md">
        <div class="container-fluid"><a class="navbar-brand" href="index.php">
                <h2 style="color: #679ED7; font-family: 'Raleway';">&nbsp; URDANETA CITY</h2>
            </a><button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div id="navcol-1" class="collapse navbar-collapse text-center">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="images/TREASURY2021.pdf" target="_blank">CITIZEN'S CHARTER</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">LOGIN</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">REGISTER</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!----Navigation ---->






    <!-- modal -->

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" style="color: black;" id="staticBackdropLabel">Sign up</h5><br>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: black;">
                    <center>Register on our queueing system now to get priority access to LGU services in City of Urdaneta.</center>
                    <br>
                    <div class="col-11 mx-auto">

                        <form action="" id="registration_form" method="post">

                            <div class="col mb-2">

                                <label class="form-label">Fullname</label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorName"></span>
                                <input type="text" name="name" id="name" onkeyup="nameValidate()" class="form-control form-control-md">
                            </div>
                            <div class="col mb-2">
                                <label class="form-label">Email</label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorEmail"></span>
                                <input type="text" name="email" id="email" onkeyup="emailValidate()" class="form-control form-control-md">
                            </div>
                            <div class="col mb-2">
                                <label class="form-label">Phone Number</label><span class="asterisk"> * </span><span style="color:red;  font-size: 13px;" id="errorPhone"></span>
                                <input type="tel" name="phone" id="phone" onkeyup="numberValidate()" class="form-control form-control-md" placeholder="####-###-####" name="mobile">
                            </div>
                            <div class="col mb-2">
                                <label class="form-label">Password</label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorPassword"></span>
                                <input type="password" name="password" id="password" onkeyup="passwordValidate()" class="form-control form-control-md">
                            </div>
                            <div class="col mb-2">
                                <label class="form-label">Confirm Password</label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorConfirmPassword"></span>
                                <input type="password" name="confirmpassword" id="confirmpassword" onkeyup="confpasswordValidate()" class="form-control form-control-md">
                            </div>
                            <div class="col mb-2">
                                <br>
                                <span class="agreement" style="font-size:12px;"> I hereby agree to the <a href="#staticBackdrop" id="terms" data-bs-toggle="modal" data-bs-target="#staticBackdrop">terms and conditions</a> set forth in this mutual non-closure agreement.<br></span>
                                <input class="form-check-input" type="checkbox" name="agreecheck" id="flexCheckDefault"> &nbsp; Yes <span style="color:red;  font-size: 13px;" id="errorAgree"></span>
                            </div>
                            <br>
                            <div class="col-12">
                                <button type="button" style="width: 100%;" onclick="validateForm();" name="submitform" class="btn btn-primary"> Register </button>
                            </div>
                        </form>





                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <br><br>
    <br><br>




    <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: black;">Confirm Submit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <span style="color: black;">Before submitting your Registration Form, please ensure that you have provided all of
                        the required information and reviewed the form carefully to ensure that all of the information provided is accurate.
                    </span>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" name="confirm" id="confirmSubmit">Confirm Submit</button>

                </div>
            </div>
        </div>
    </div>




    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function nameValidate() {
            let name = $("#name").val();
            var flag = 0;

            if (name == "") {
                $("#name").css("border", "1px solid red");
                $('#errorName').html("Name is required");
                flag = 1;
            } else if (name.length < 6) {
                $("#name").css("border", "1px solid red");
                $('#errorName').html("Name  must be more than 6 characters");
                flag = 1;
            } else {
                $("#name").css("border", "1px solid grey");
                $('#errorName').html("");

            }

            return flag;

        }


        function passwordValidate() {
            let password = $("#password").val();
            var flag = 0;

    

            if (password == "") {
                $("#password").css("border", "1px solid red");
                $('#errorPassword').html("Password is required");
                flag = 1;
            } else if (password.length < 6) {
                $("#password").css("border", "1px solid red");
                $('#errorPassword').html("Password  must be more than 6 characters");
                flag = 1;
            } else if (!password.match(/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{6,20}$/)) {
                $("#password").css("border", "1px solid red");
                $('#errorPassword').html("Password not strong nough. Must have [!@#$%^&*-], [0-9], [A-Z]");
                flag = 1;
            } else {
                $("#password").css("border", "1px solid grey");
                $('#errorPassword').html("");

            }

            return flag;

        }


        function confpasswordValidate() {
            let confpassword = $("#confirmpassword").val();
            let password = $("#password").val();
            var flag = 0;

            if (confpassword == "") {
                $("#confirmpassword").css("border", "1px solid red");
                $('#errorConfirmPassword').html("Confirm Password is required");
                flag = 1;
            } else if (confpassword != password) {
                $("#confirmpassword").css("border", "1px solid red");
                $('#errorConfirmPassword').html("Password  doesnt match");
                flag = 1;

            } else {
                $("#confirmpassword").css("border", "1px solid grey");
                $('#errorConfirmPassword').html("");

            }

            return flag;

        }


        function emailValidate() {
            let email = $('#email').val();
            let re = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
            var emailFormat = re.test(email);
            var flag = 0;


            if (!emailFormat) {
                $('#email').css("border", "1px solid red");
                $('#errorEmail').html("Email is invalid");
                flag = 1;
            } else {
                $('#email').css("border", "1px solid grey");
                $('#errorEmail').html("");
                flag = 0;
            }

            return flag;
        }



        function numberValidate() {
            let phone = $('#phone').val();
            var flag = 0;
            if (!phone.match(/^[0-9]{4}-[0-9]{3}-[0-9]{4}$/)) {
                $('#errorPhone').html("Invalid Phone Number");
                flag = 1;

            } else {
                $('#errorPhone').html("");
                flag = 0;
            }
            return flag;


        }

        function validateForm() {
          

            var flag = 0;


            var nameval = $('#name').val();
            var emailval = $('#email').val();
            var phoneval = $('#phone').val();
            var passwordval = $('#password').val();
            var confpasswordval = $('#confirmpassword').val();
    




            if (emailval == "") {
                $('#email').css("border", "1px solid red");
                $('#errorEmail').html("Email is required");
                flag = 1;
            } else {
                $('#email').css("border", "1px solid grey");
                $('#errorEmail').html("");
                flag = 0;
            }

            if (phoneval == "") {
                $('#errorPhone').html("Phone Number is required");
                flag = 1;
            } else {
                $('#errorPhone').html("");
                flag = 0;
            }

            if (passwordval == "") {
                $("#password").css("border", "1px solid red");
                $('#errorPassword').html("Password is required");
                flag = 1;
            } else {
                $("#password").css("border", "1px solid grey");
                $('#errorPassword').html("");
                flag = 0;
            }

            if (confpasswordval == "") {
                $("#confirmpassword").css("border", "1px solid red");
                $('#errorConfirmPassword').html("Password is required");
                flag = 1;
            } else {
                $("#confirmpassword").css("border", "1px solid grey");
                $('#errorConfirmPassword').html("");
                flag = 0;
            }



            if (!$("#flexCheckDefault").is(':checked')) {
                $('#errorAgree').html("Please check the checkbox to proceed registration");
                flag = 1;
            } else {
                $('#errorAgree').html("");
            }


            if ((nameValidate(nameval)) + (emailValidate(emailval)) + (passwordValidate(passwordval)) + (confpasswordValidate(confpasswordval)) + (numberValidate(phoneval)) + flag == 0) {



                $.ajax({
                    url: "check_email.php",
                    type: "POST",
                    data: {
                        email: emailval
                    },
                    success: function(result, result1) {
                        if (result == 1) {
                            $('#email').css("border", "1px solid red");
                            $('#errorEmail').html("Email already exists");

                        } else {
                            $('#email').css("border", "1px solid grey");
                            $('#errorEmail').html("");

                            //  submitreg();
                            $('#staticBackdrop2').modal('show');

                        }
                    },
                    error: function() {
                        alert("Error occurred");
                    }
                });



            }





        }

       
    </script>

    <script>
        $(document).ready(function() {






            $('#confirmSubmit').on('click', function() {
                var nameval = $('#name').val();
                var emailval = $('#email').val();
                var passwordval = $('#password').val();
                var phoneval = $('#phone').val();
                $.ajax({
                    url: 'ajax/function_class.php?function=add_userclient',
                    type: 'POST',
                    data: {
                        name: nameval,
                        email: emailval,
                        password: passwordval,
                        phone: phoneval,

                    },
                    success: function() {
                        $('#registration_form').off('submit').submit();
                        window.location.href = "login.php";

                    }
                });



            });
        });
    </script>