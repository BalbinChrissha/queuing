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
    <title>Service Admin Management</title>

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
                    title: "Are you sure you want to delete this service?",
                    text: "Once deleted, you will not be able to recover this service and records!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        //ajax call for delete
                        $.ajax({
                            url: "../ajax/function_class.php?function=delete_service",
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
                var desc = $(this).data("desc");

                $("#modalID").val(id);
                $("#m_name").val(name);
                $("#m_desc").val(desc);


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



        function descValidate1() {
            let name = $("#m_desc").val();
            var flag1 = 0;

            if (name == "") {
                $("#m_desc").css("border", "1px solid red");
                $('#errorDesc1').html("Description is required");
                flag1 = 1;
            } else if (name.length < 6) {
                $("#m_desc").css("border", "1px solid red");
                $('#errorDesc1').html("Description  must be more than 6 characters");
                flag1 = 1;
            } else {
                $("#m_desc").css("border", "1px solid grey");
                $('#errorDesc1').html("");

            }

            return flag1;

        }








        function validateForm1() {
            var flag1 = 0;

            var nameval = $('#m_name').val();
            let desc = $("#m_desc").val();
            var id = $('#modalID').val();

            if ((nameValidate1(nameval)) + (descValidate1(desc)) + flag1 == 0) {

                $.ajax({
                    url: '../ajax/function_class.php?function=edit_service',
                    type: 'POST',
                    data: {
                        id: id,
                        name: nameval,
                        desc: desc,
                    },
                    success: function() {
                        $('#registration_form1').off('submit').submit();
                        location.reload();
                    }
                });


            }

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
                                    <input type="text" id="modalID" readonly class="form-control form-control-md">
                                </div>
                                <div class="col mb-2">
                                    <label class="form-label">Service Name</label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorName1"></span>
                                    <input type="text" id="m_name" onkeyup="nameValidate1()" class="form-control form-control-md">
                                </div>
                                <div class="col mb-2">
                                    <label class="form-label">Description</label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorDesc1"></span>
                                    <textarea class="form-control form-control-md" name="description" id="m_desc" onkeyup="descValidate1()" rows="3" required></textarea>
                                </div>
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
                    <div id="services">
                        <center>
                            <table>
                                <tr>
                                    <td><img src="../images/services.png" alt=""></td>
                                    <td>
                                        <h3><b>Service Management</h3></b>
                                    </td>
                                </tr>
                            </table>
                        </center>
                    </div><br>

                    <div id="notif"></div>

                    <div class="row">
                        <div class="col-sm-2 mb-2">
                        </div>

                        <div class="col-sm-10 mb-2" align="right">

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add Services</button>

                        </div>
                    </div>



                    <div style="overflow-x:auto;">
                        <table id="table_id" class="display">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Service</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sql = "select * from service";
                                $dataset = $connect->query($sql) or die("Error query");

                                if (mysqli_num_rows($dataset) > 0) {
                                    while ($data = $dataset->fetch_array()) {

                                        echo "<tr>   
      <td> $data[0]</td>
      <td>$data[1]</td>
      <td>$data[2]</td>
    

      <td>  <button type='button' id='update' class='eme'  style=' border: none; background-color: none;' data-id='$data[0]' data-name='$data[1]' data-desc='$data[2]'  class='btn btn-success'><i  input type=\"edit\"  class=\"fa-solid fa-pen-to-square\" style=\"color:blue;\"></i></button>       
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

                    <h5 class="modal-title" style="color: black;" id="staticBackdropLabel">Add Service</h5><br>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: black;">
                    <br>
                    <div class="col-11 mx-auto">

                        <form action="" id="registration_form" method="post">

                            <div class="col mb-2">

                                <label class="form-label">Service Name</label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorName"></span>
                                <input type="text" name="name" id="name" onkeyup="nameValidate()" class="form-control form-control-md">
                            </div>
                            <div class="col mb-2">
                                <label class="form-label">Description</label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorDesc"></span>
                                <textarea class="form-control form-control-md" name="description" id="description" onkeyup="descValidate()" rows="3" required></textarea>
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

        function descValidate() {
            let name = $("#description").val();
            var flag = 0;

            if (name == "") {
                $("#description").css("border", "1px solid red");
                $('#errorDesc').html("Description is required");
                flag = 1;
            } else if (name.length < 6) {
                $("#description").css("border", "1px solid red");
                $('#errorDesc').html("Description  must be more than 6 characters");
                flag = 1;
            } else {
                $("#description").css("border", "1px solid grey");
                $('#errorDesc').html("");

            }

            return flag;

        }








        function validateForm() {
            var flag = 0;

            var nameval = $('#name').val();
            let desc = $("#description").val();



            if ((nameValidate(nameval)) + (descValidate(desc)) + flag == 0) {

                $.ajax({
                    url: '../ajax/function_class.php?function=add_services',
                    type: 'POST',
                    data: {
                        name: nameval,
                        desc: desc,
                    },
                    success: function() {
                        $('#registration_form').off('submit').submit();
                        location.reload();
                    }
                });
            }



        }
    </script>





</body>

</html>