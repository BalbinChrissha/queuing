<?php

require '../config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ../index.php');
    exit;
}

$username = $_SESSION['admin']['username'];

$get_user = mysqli_query($connect, "SELECT * FROM users WHERE username='$username'");
if (mysqli_num_rows($get_user) > 0) {
    $admin = mysqli_fetch_assoc($get_user);
} else {
    header('Location: ../logout.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../inc/header.php'); ?>

    <link rel="stylesheet" href="../css/AdminStyle.css">
    <title>User Admin Management</title>

</head>

<body>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table_id').DataTable();

            $(".delete").click(function() {
                var id = $(this).data('id');

                var tr = $(this).closest('tr');
                swal({
                    title: "Are you sure you want to delete this account?",
                    text: "Once deleted, you will not be able to recover this account!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        //ajax call for delete
                        $.ajax({
                            url: "../ajax/function_class.php?function=delete_account",
                            method: 'post',
                            data: {
                                idno: id,
                            },
                            success: function(result) {
                                $("#notif").html(result).delay(3000).fadeToggle(5000);
                            }
                        });
                        tr.remove();
                    } else {}
                });

            });


            $(document).on("click", "#update", function() {
                var id = $(this).data("id");
                var name = $(this).data("name");
                var u_name = $(this).data("uname");
                var pass = $(this).data("pass");

                $("#modalID").val(id);
                $("#m_name").val(name);
                $("#m_uname").val(u_name);
                $("#m_pass").val(pass);
                $("#m_phidden").val(u_name);

                // Show the modal
                $("#myModal").modal("show");
            });

        });
    </script>


    <script>
        function nameValidate1() {
            let name = $("#m_name").val();
            var flag1 = 0;

            if (name == "") {
                $("#m_name").css("border", "1px solid red");
                $('#errorName1').html("Name is required");
                flag1 = 1;
            } else if (name.length < 6) {
                $("#m_name").css("border", "1px solid red");
                $('#errorName1').html("Name  must be more than 6 characters");
                flag1 = 1;
            } else {
                $("#m_name").css("border", "1px solid grey");
                $('#errorName1').html("");

            }

            return flag1;

        }


        function passwordValidate1() {
            let password = $("#m_pass").val();
            var flag1 = 0;


            if (password == "") {
                $("#m_pass").css("border", "1px solid red");
                $('#errorPassword1').html("Password is required");
                flag1 = 1;
            } else if (password.length < 6) {
                $("#m_pass").css("border", "1px solid red");
                $('#errorPassword1').html("Password  must be more than 6 characters");
                flag1 = 1;
            } else {
                $("#m_pass").css("border", "1px solid grey");
                $('#errorPassword1').html("");

            }

            return flag1;

        }


        function confpasswordValidate1() {
            let confpassword = $("#m_confirmpass").val();
            let password = $("#m_pass").val();
            var flag1 = 0;

            if (confpassword == "") {
                $("#m_confirmpass").css("border", "1px solid red");
                $('#errorConfirmPassword1').html("Confirm Password is required");
                flag1 = 1;
            } else if (confpassword != password) {
                $("#m_confirmpass").css("border", "1px solid red");
                $('#errorConfirmPassword1').html("Password  doesnt match");
                flag1 = 1;

            } else {
                $("#m_confirmpass").css("border", "1px solid grey");
                $('#errorConfirmPassword1').html("");

            }

            return flag1;

        }


        function emailValidate1() {
            let email = $('#m_uname').val();
            let re = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
            var emailFormat = re.test(email);
            var flag1 = 0;


            if (!emailFormat) {
                $('#m_uname').css("border", "1px solid red");
                $('#errorEmail1').html("Email is invalid");
                flag1 = 1;
            } else {
                $('#m_uname').css("border", "1px solid grey");
                $('#errorEmail1').html("");
                flag1 = 0;
            }

            return flag1;


        }

        function validateForm1() {
            var flag1 = 0;

            var nameval = $('#m_name').val();
            var emailval = $('#m_uname').val();
            var passwordval = $('#m_pass').val();
            var confpasswordval = $('#m_confirmpass').val();
            var old = $('#m_phidden').val();


            if (emailval == "") {
                $('#m_uname').css("border", "1px solid red");
                $('#errorEmail1').html("Email is required");
                flag1 = 1;
            } else {
                $('#m_uname').css("border", "1px solid grey");
                $('#errorEmail1').html("");
                flag1 = 0;
            }

            if (passwordval == "") {
                $("#m_pass").css("border", "1px solid red");
                $('#errorPassword1').html("Password is required");
                flag1 = 1;
            } else {
                $("#m_pass").css("border", "1px solid grey");
                $('#errorPassword1').html("");
                flag1 = 0;
            }

            if (confpasswordval == "") {
                $("#m_confirmpass").css("border", "1px solid red");
                $('#errorConfirmPassword1').html("Password is required");
                flag1 = 1;
            } else {
                $("#m_confirmpass").css("border", "1px solid grey");
                $('#errorConfirmPassword1').html("");
                flag1 = 0;
            }



            if ((nameValidate1(nameval)) + (emailValidate1(emailval)) + (passwordValidate1(passwordval)) + (confpasswordValidate1(confpasswordval)) + flag1 == 0) {
                
                
                if (emailval == old) {
                    submitEdit();

                } else {

                    $.ajax({
                        url: "../check_email.php",
                        type: "POST",
                        data: {
                            email: emailval
                        },
                        success: function(result, result1) {
                            if (result == 1) {
                                $('#m_uname').css("border", "1px solid red");
                                $('#errorEmail1').html("Email already exists");

                            } else {
                                $('#m_uname').css("border", "1px solid grey");
                                $('#errorEmail1').html("");

                                var nameval = $('#m_name').val();
                                var emailval = $('#m_uname').val();
                                var passwordval = $('#m_pass').val();
                                var id = $('#modalID').val();
                                submitEdit();

                            }
                        },
                        error: function() {
                            alert("Error occurred");
                        }
                    });
                }


            }



        }




        function submitEdit() {
            var nameval = $('#m_name').val();
            var emailval = $('#m_uname').val();
            var passwordval = $('#m_pass').val();
            var id = $('#modalID').val();

            $.ajax({
                url: '../ajax/function_class.php?function=edit_user',
                type: 'POST',
                data: {
                    id: id,
                    name: nameval,
                    email: emailval,
                    password: passwordval,

                },
                success: function() {
                    $('#registration_form1').off('submit').submit();
                    location.reload();
                }
            });

        }
    </script>



    <?php include('../inc/admin_navbar.php');
    ?>



    <!-- Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Record</h5>
                    </div>
                    <div class="modal-body">
                        <div class="col-11 mx-auto">

                            <form action="" id="registration_form1" method="post">
                                <div class="col mb-2">
                                    <label class="form-label">ID</label>
                                    <input type="hidden" id="m_phidden" class="form-control form-control-md">
                                    <input type="text" id="modalID" readonly class="form-control form-control-md">
                                </div>
                                <div class="col mb-2">
                                    <label class="form-label">Fullname</label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorName1"></span>
                                    <input type="text" id="m_name" onkeyup="nameValidate1()" class="form-control form-control-md">
                                </div>
                                <div class="col mb-2">
                                    <label class="form-label">Email</label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorEmail1"></span>
                                    <input type="text" id="m_uname" onkeyup="emailValidate1()" class="form-control form-control-md">
                                </div>
                                <div class="col mb-2">
                                    <label class="form-label">Password</label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorPassword1"></span>
                                    <input type="password" id="m_pass" onkeyup="passwordValidate1()" class="form-control form-control-md">
                                </div>
                                <div class="col mb-2">
                                    <label class="form-label">Confirm Password</label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorConfirmPassword1"></span>
                                    <input type="password" id="m_confirmpass" onkeyup="confpasswordValidate1()" class="form-control form-control-md">
                                </div>

                                <br>
                                <div class="col-12">
                                    <button type="button" style="width: 100%;" onclick="validateForm1();" name="submitform" class="btn btn-primary"> Save Changes </button>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
            </div>
            </form>
        </div>
    </div>






    <section class="home">
        <div class="cont">


            <?php include('admin_bar.php'); ?>



            <div class="col-10 mx-auto my-5 bg-light rounded">

                <div class="col-sm-12 mx-auto p-5">
                    <center>
                        <h3><b>USER ADMIN MANAGEMENT</b></h3>
                    </center><br>
                    <div id="notif"></div><br />
                    <div class="row">
                        <div class="col-sm-2 mb-2">
                        </div>

                        <div class="col-sm-10 mb-2" align="right">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add Admin</button>

                        </div>

                    </div>

                    <div style="overflow-x:auto;">
                        <table id="table_id" class="display">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Password</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sql = "select * from users where type = 1";
                                $dataset = $connect->query($sql) or die("Error query");

                                if (mysqli_num_rows($dataset) > 0) {
                                    while ($data = $dataset->fetch_array()) {

                                        echo "<tr>   
      <td> $data[0]</td>
      <td>$data[1]</td>
      <td>$data[3]</td>
      <td>$data[4]</td>

      <td>  <button type='button' id='update' class='eme'  style=' border: none; background-color: none;' data-id='$data[0]' data-name='$data[1]' data-uname='$data[3]' data-pass='$data[4]' class='btn btn-success'><i  input type=\"edit\"  class=\"fa-solid fa-pen-to-square\" style=\"color:blue;\"></i></button>       
      &nbsp; <button type='button' class='delete' data-id='$data[0]'> <i  input type=\"submit\"  class=\"fas fa-trash-alt\" style=\"color:red;\"></i> </button></td>
              </tr>";
                                    }
                                } else {
                                    echo "Empty resultset";
                                }
                                echo "</tbody>
</table>
</div>"; ?>


                    </div>
                </div>

            </div>
    </section>


    <!-- modal -->

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" style="color: black;" id="staticBackdropLabel">Add Admin</h5><br>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: black;">
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
                                <label class="form-label">Password</label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorPassword"></span>
                                <input type="password" name="password" id="password" onkeyup="passwordValidate()" class="form-control form-control-md">
                            </div>
                            <div class="col mb-2">
                                <label class="form-label">Confirm Password</label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorConfirmPassword"></span>
                                <input type="password" name="confirmpassword" id="confirmpassword" onkeyup="confpasswordValidate()" class="form-control form-control-md">
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

        function validateForm() {
            var flag = 0;

            var nameval = $('#name').val();
            var emailval = $('#email').val();
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



            if ((nameValidate(nameval)) + (emailValidate(emailval)) + (passwordValidate(passwordval)) + (confpasswordValidate(confpasswordval)) + flag == 0) {

                $.ajax({
                    url: "../check_email.php",
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

                            var nameval = $('#name').val();
                            var emailval = $('#email').val();
                            var passwordval = $('#password').val();

                            $.ajax({
                                url: '../ajax/function_class.php?function=add_useradmin',
                                type: 'POST',
                                data: {
                                    name: nameval,
                                    email: emailval,
                                    password: passwordval,

                                },
                                success: function() {
                                    $('#registration_form').off('submit').submit();
                                    location.reload();
                                }
                            });



                        }
                    },
                    error: function() {
                        alert("Error occurred");
                    }
                });



            }



        }
    </script>





</body>

</html>