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


if (!isset($_GET['windowid'])) {
    header('Location: admin_manage_window.php');
}

$windowID = $_GET['windowid'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../inc/header.php'); ?>

    <link rel="stylesheet" href="../css/AdminStyle.css">
    <title>Window Management</title>

</head>

<body>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table_id').DataTable();

            $(".delete").click(function() {
                var id = $(this).data('id');

                swal({
                    title: "Are you sure you want to delete this service in this window?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        //ajax call for delete
                        $.ajax({
                            url: "../ajax/function_class.php?function=delete_servicewindow",
                            method: 'post',
                            data: {
                                idno: id,
                            },
                            success: function(result) {

                                location.reload();

                            }
                        });

                    } else {}
                });

            });


            $(document).on("click", "#update", function() {
                var id = $(this).data("id");
                var s_id = $(this).data("serviceid");
                var w_id = $(this).data("windowid");

                $("#modalID").val(id);
                $("#m_service").val(s_id);
                $("#m_phidden").val(w_id);
                $("#myModal").modal("show");
            });

        });
    </script>


    <script>
        function validateForm1() {


            var serviceId = document.getElementById("m_service").value;
            var windowId = "<?php echo $windowID; ?>";


            $.ajax({
                url: "../ajax/function_class.php?function=check_servicewindow",
                type: "POST",
                data: {
                    s_id: serviceId,
                    w_id: windowId,
                },
                success: function(result) {
                    if (result == 1) {
                        $('#m_service').css("border", "1px solid red");
                        $('#errorService1').html("The service is already assigned to this window. (Duplication is prohibited)");

                    } else {
                        $('#m_service').css("border", "1px solid grey");
                        $('#errorService1').html("");
                        submitqueue1();


                    }
                },
                error: function() {
                    alert("Error occurred");
                }
            });

        }






        function submitqueue1() {
     


            var id = $('#modalID').val();
           
            var serviceId = document.getElementById("m_service").value;
            $.ajax({
                url: '../ajax/function_class.php?function=edit_servicewindow',
                type: 'POST',
                data: {
                    id: id,
                    s_id: serviceId,
                },
                success: function(result) {
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
                                    <input type="hidden" id="m_phidden" readonly class="form-control form-control-md">

                                    <input type="text" id="modalID" readonly class="form-control form-control-md">
                                </div>
                                <div class="col mb-2">
                                    <label class="form-label">Service</label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorService1"></span>
                                    <?php if ($connect) {
                                        $result =  $connect->query("SELECT * FROM service") or die("Error Query");
                                        if ($result) {
                                            if ($result->num_rows >= 1) {
                                                echo "<select  id='m_service' class='form-select mb-3' required >";
                                                while ($rows = $result->fetch_array()) {
                                                    echo "<option value='$rows[0]'>$rows[1]</option>";
                                                }
                                            }
                                        }
                                    }

                                    echo "</select>";

                                    ?>


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



                    <?php
                    $sql = "select * FROM window WHERE window_id=$windowID";
                    $dataset = $connect->query($sql) or die("Error query");
                    $window_stat = '';
                    if (mysqli_num_rows($dataset) > 0) {
                        while ($data = $dataset->fetch_array()) {
                            if ($data[4] == 1) {
                                $window_stat = 'Active';
                            } else {
                                $window_stat = 'Inactive';
                            }

                            $window_name = $data[1];

                    ?>

                            <center>

                                <h3><b><?php echo strtoupper($window_name); ?> SERVICE MANAGEMENT</h3></b>
                            </center>
                            <br>
                            <div id="notif"></div>

                            <div class="row mx-auto">
                                <div class="col-sm-6 mb-2">
                                </div>

                                <div class="col-sm-6 mb-2" align="right">

                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add Service</button>


                                </div>
                            </div>


                    <?php $query = "select transaction_windows.*, service.service_name FROM service, transaction_windows WHERE transaction_windows.service_id=service.service_id AND window_id= $windowID";
                            $dataset1 = $connect->query($query) or die("Error query");
                            echo ' <div class="col-11 mx-auto"> ';

                            if (mysqli_num_rows($dataset1) > 0) {
                                while ($row = $dataset1->fetch_array()) {

                                    echo '<div class="alert alert-dark row">
                                    <div class="col-8"><i style="font-size:10px;"class="fa-solid fa-circle"></i>&nbsp;&nbsp;' . $row[3] . '</div>';
                                    echo "<div class=\"col-4\"><div style=\"text-align: right;\">  <button type='button' id='update' class='eme'  style=' border: none; background-color: none;' data-id='$row[0]' data-serviceid='$row[1]' data-windowid='$row[2]'class='btn btn-success'><i  input type=\"edit\" class=\"fa-solid fa-pen-to-square\" style=\"font-size:20px;color:#2f9158;\"></i></button>
                                    &nbsp; <button type='button' class='delete' data-id='$row[0]'> <i  input type=\"submit\"  class=\"fas fa-trash-alt\" style=\"color:red;\"></i> </button>
                                    </div></div>";
                                    echo '</div>';
                                }
                            } else {
                                echo "<center><b>No Service Assigned Yet</b></center>";
                            }

                            echo '</div></div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">
                   <center>No Record of the Window from the database</center>
                      </div>';
                        header('Location: admin_manage_window.php');
                    }
                    ?>

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
                                <label class="control-label">Service: </label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorService"></span>
                                <?php if ($connect) {
                                    $result =  $connect->query("SELECT * FROM service") or die("Error Query");
                                    if ($result) {
                                        if ($result->num_rows >= 1) {
                                            echo "<select id='service_id' class='form-select mb-3' required>";
                                            while ($rows = $result->fetch_array()) {
                                                echo "<option value='$rows[0]'>$rows[1]</option>";
                                            }
                                        }
                                    }
                                }

                                echo "</select>";

                                ?>
                            </div>
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
        function validateForm() {


            var serviceId = document.getElementById("service_id").value;
            var windowId = "<?php echo $windowID; ?>";


            $.ajax({
                url: "../ajax/function_class.php?function=check_servicewindow",
                type: "POST",
                data: {
                    s_id: serviceId,
                    w_id: windowId,
                },
                success: function(result) {
                    if (result == 1) {
                        $('#service_id').css("border", "1px solid red");
                        $('#errorService').html("The service is already assigned to this window. (Duplication is prohibited)");

                    } else {
                        $('#service_id').css("border", "1px solid grey");
                        $('#errorService').html("");
                        submitqueue();


                    }
                },
                error: function() {
                    alert("Error occurred");
                }
            });

        }




        function submitqueue() {
            var serviceId = document.getElementById("service_id").value;
            var windowId = "<?php echo $windowID; ?>";


            $.ajax({
                url: '../ajax/function_class.php?function=add_servicewindow',
                type: 'POST',
                data: {
                    s_id: serviceId,
                    w_id: windowId,
                },
                success: function(result) {


                    $('#registration_form').off('submit').submit();
                    location.reload();
                }
            });




        }
    </script>





</body>

</html>