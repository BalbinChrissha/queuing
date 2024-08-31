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
                    title: "Are you sure you want to delete this Window?",
                    text: "Once deleted, you will not be able to recover window's records!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        //ajax call for delete
                        $.ajax({
                            url: "../ajax/function_class.php?function=delete_window",
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
                var processor = $(this).data("processor");
                var stat = $(this).data("status");

                $("#modalID").val(id);
                $("#m_name").val(name);
                $("#m_desc").val(desc);
                $("#m_processor").val(processor);
                $("#m_status").val(stat);

                $("#m_phidden").val(processor);

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


            var processorId = document.getElementById("m_processor").value;
            var old = document.getElementById("m_phidden").value;

            alert(old + " " + processorId);

            if (processorId == old) {

                submitqueue1();
            } else {



                $.ajax({
                    url: "../ajax/function_class.php?function=check_processor",
                    type: "POST",
                    data: {
                        id: processorId,
                    },
                    success: function(result) {
                        if (result == 1) {
                            $('#m_processor').css("border", "1px solid red");
                            $('#errorService1').html("The processor is already assigned to a window. (Duplication is prohibited)");

                        } else {
                            $('#m_processor').css("border", "1px solid grey");
                            $('#errorService1').html("");
                            submitqueue1();




                        }
                    },
                    error: function() {
                        alert("Error occurred");
                    }
                });

            }

        }



        function submitqueue1() {


            var flag1 = 0;

            var nameval = $('#m_name').val();
            let desc = $("#m_desc").val();
            var id = $('#modalID').val();
            var processorId = document.getElementById("m_processor").value;
            var stat = document.getElementById("m_status").value;

            alert(stat);

            if ((nameValidate1(nameval)) + (descValidate1(desc)) + flag1 == 0) {

                $.ajax({
                    url: '../ajax/function_class.php?function=edit_window',
                    type: 'POST',
                    data: {
                        id: id,
                        name: nameval,
                        desc: desc,
                        processorId: processorId,
                        stat: stat,
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
                                <input type="hidden" id="m_phidden" class="form-control form-control-md">

                                <div class="col mb-2">
                                    <label class="form-label">ID</label>
                                    <input type="text" id="modalID" readonly class="form-control form-control-md">
                                </div>
                                <div class="col mb-2">
                                    <label class="form-label">Fullname</label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorName1"></span>
                                    <input type="text" id="m_name" onkeyup="nameValidate1()" class="form-control form-control-md">
                                </div>
                                <div class="col mb-2">
                                    <label class="form-label">Description</label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorDesc1"></span>
                                    <textarea class="form-control form-control-md" name="description" id="m_desc" onkeyup="descValidate1()" rows="3" required></textarea>
                                </div>

                                <div class="col mb-2">
                                    <label class="control-label">Processor: </label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorService1"></span>
                                    <?php if ($connect) {
                                        $result =  $connect->query("SELECT * FROM users WHERE type = 2 ") or die("Error Query");
                                        if ($result) {
                                            if ($result->num_rows >= 1) {
                                                echo "<select id='m_processor' class='form-select mb-3' required onchange='onServiceSelect(this.value)'>";
                                                while ($rows = $result->fetch_array()) {
                                                    echo "<option value='$rows[0]'>$rows[1]</option>";
                                                }
                                            }
                                        }
                                    }

                                    echo "</select>";

                                    ?>
                                </div>


                                <div class="col mb-2">
                                    <label class="control-label">Status: </label>
                                    <select id="m_status" class='form-select mb-3' required>
                                        <option value="0">Inactive</option>
                                        <option value="1">Active</option>
                                    </select>
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
                    <center>
                        <h3><b>WINDOW MANAGEMENT</b></h3>
                    </center><br>
                    <div id="notif"></div><br />
                    <div class="row">
                        <div class="col-sm-2 mb-2">
                        </div>

                        <div class="col-sm-10 mb-2" align="right">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add Windows</button>

                        </div>

                    </div>

                    <div style="overflow-x:auto;">
                        <table id="table_id" class="display">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Window</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Processor</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sql = "select window.*, users.u_name FROM window, users WHERE window.processor_id=users.id";
                                $dataset = $connect->query($sql) or die("Error query");
                                $window_stat = '';
                                if (mysqli_num_rows($dataset) > 0) {
                                    while ($data = $dataset->fetch_array()) {
                                        if ($data[4] == 1) {
                                            $window_stat = 'Active';
                                        } else {
                                            $window_stat = 'Inactive';
                                        }


                                        echo "<tr>   
      <td> $data[0]</td>
      <td>$data[1]</td>
      <td>$data[2]</td>
      <td>$data[5]</td>
      <td>$window_stat</td>
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





                <div class="col-10 mx-auto my-5 bg-light rounded">
                    <div class="col-sm-12 mx-auto p-5">

                        <h4><b>WINDOW SERVICES MANAGEMENT</h4></b>

                        <?php
                        $sql = "select * FROM window";
                        $dataset = $connect->query($sql) or die("Error query");
                        $window_stat = '';
                        if (mysqli_num_rows($dataset) > 0) {
                            while ($data = $dataset->fetch_array()) {
                                if ($data[4] == 1) {
                                    $window_stat = 'Active';
                                } else {
                                    $window_stat = 'Inactive';
                                }

                                $windowID = $data[0];


                                echo '<div class="col-sm-11 mx-auto" id= "window_service">';
                                echo '<div class="row">';
                                echo '<div class="col-10"><i id="window" class="fa-solid fa-window-restore"></i>&nbsp;&nbsp;<b>' . $data[1] . '</b> &nbsp; <span style="color: #c66161;">(' . $window_stat . ')</span></div>';

                                echo "<div class=\"col-2\"><a href=\"window_service.php?windowid=$data[0]\"><div style=\"text-align: right;\"><i  input type=\"edit\"  class=\"fa-solid fa-pen-to-square\" style=\"font-size:20px;color:#2f9158;\"></i></a></div></div>";
                                echo '</div>';

                                $query = "select transaction_windows.*, service.service_name FROM service, transaction_windows WHERE transaction_windows.service_id=service.service_id AND window_id= $windowID";
                                $dataset1 = $connect->query($query) or die("Error query");
                                echo ' <div class="col-11 mx-auto"> <div class="row">';

                                if (mysqli_num_rows($dataset1) > 0) {
                                    while ($row = $dataset1->fetch_array()) {

                                        echo '<div class="col-sm-6"><i style="font-size:10px;"class="fa-solid fa-circle"></i>&nbsp;&nbsp;' . $row[3];
                                        echo '</div>';
                                    }
                                } else {
                                    echo "<center><b>No Service Assigned Yet</b></center>";
                                }

                                echo '</div></div></div>';
                            }
                        } else {
                            echo "No Windows Yet";
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

                    <h5 class="modal-title" style="color: black;" id="staticBackdropLabel">Add Window</h5><br>

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

                            <div class="col mb-2">
                                <label class="control-label">Processor: </label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorService"></span>
                                <?php if ($connect) {
                                    $result =  $connect->query("SELECT * FROM users WHERE type = 2 ") or die("Error Query");
                                    if ($result) {
                                        if ($result->num_rows >= 1) {
                                            echo "<select name='processor_id' id='processor_id' class='form-select mb-3' required onchange='onServiceSelect(this.value)'>";
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


            var processorId = document.getElementById("processor_id").value;



            $.ajax({
                url: "../ajax/function_class.php?function=check_processor",
                type: "POST",
                data: {
                    id: processorId,
                },
                success: function(result) {
                    if (result == 1) {
                        $('#processor_id').css("border", "1px solid red");
                        $('#errorService').html("The processor is already assigned to a window. (Duplication is prohibited)");

                    } else {
                        $('#processor_id').css("border", "1px solid grey");
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
            var flag = 0;

            var nameval = $('#name').val();
            let desc = $("#description").val();
            var processorId = document.getElementById("processor_id").value;



            if ((nameValidate(nameval)) + (descValidate(desc)) + flag == 0) {

                $.ajax({
                    url: '../ajax/function_class.php?function=add_window',
                    type: 'POST',
                    data: {
                        name: nameval,
                        desc: desc,
                        id: processorId,
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



</body>

</html>