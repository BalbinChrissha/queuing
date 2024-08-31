<?php
require 'config.php';

if (!isset($_SESSION['client'])) {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['client']['username'];
date_default_timezone_set('Asia/Manila');
$current_date = date('Y-m-d');

$get_user = mysqli_query($connect, "SELECT * FROM users WHERE username='$username'");
if (mysqli_num_rows($get_user) > 0) {
    $user = mysqli_fetch_assoc($get_user);
    $userid = $user['id'];
} else {
    header('Location: logout.php');
    exit;
}

$desc = '';
?>
<!DOCTYPE html>
<?php include('inc/header.php'); ?>
<link rel="stylesheet" href="css/clientstyle.css">
<title>Client Dashboard</title>


</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        var id = "<?php echo  $userid; ?>";
        setInterval(function() {
            $('#reload').load('reload.php?id=' + id);
        }, 30000);
    </script>

    <script>
        $(document).ready(function() {
            $('#table_id').DataTable();

            $(".delete").click(function() {
                var id = $(this).data('id');

                var tr = $(this).closest('tr');
                swal({
                    title: "Are you sure you want to delete this record?",
                    text: "Once deleted, you will not be able to recover this record!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        //ajax call for delete
                        $.ajax({
                            url: "ajax/function_class.php?function=delete_queue",
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
                var serviceid = $(this).data("serviceid");

                $("#modalID").val(id);
                $("#modalservice").val(serviceid);

                // Show the modal
                $("#myModal").modal("show");
            });
        });
    </script>


    <?php include('inc/client_navbar.php'); ?>



    <!-- Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Record</h5>
                    </div>
                    <div class="modal-body">
                        <div class="col-10 mx-auto">
                            <form action="">
                                <div class="form-group">
                                    <div class="col mb-2">
                                        <label for="modalInput">Queue No.:</label>
                                        <input type="text" class="form-control" id="modalID" readonly>
                                    </div>
                                    <div class="col mb-2">
                                        <label class="control-label">Service: </label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorService1"></span>
                                        <?php if ($connect) {
                                            $result =  $connect->query("SELECT * FROM service order by service_name asc ") or die("Error Query");
                                            if ($result) {
                                                if ($result->num_rows >= 1) {
                                                    echo "<select name='service_id' id='modalservice' class='form-select mb-3' required onchange='onServiceSelect(this.value)'>";
                                                    while ($rows = $result->fetch_array()) {
                                                        echo "<option value='$rows[0]'>$rows[1]</option>";
                                                    }
                                                }
                                            }
                                        }

                                        echo "</select>";

                                        ?>

                                    </div>



                                </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="validateUpdateQueue();">Save changes</button>
                    </div>
            </div>
            </form>
        </div>
    </div>



    <div id="reload">

        <?php
        $sql = "SELECT queue_transaction.*, u_name, countdown, service_name, window.window_id, window_name FROM users, queue_list, service, window, queue_transaction WHERE trans_status = 1 and trans_date = '$current_date' AND queue_list.queue_id=queue_transaction.queue_id AND users.id =queue_list.user_id AND window.processor_id= queue_transaction.processor_id AND service.service_id=queue_list.service_id AND queue_list.user_id = $userid ORDER BY queue_transaction.trans_id ASC;";
        $dataset = $connect->query($sql) or die("Error query");
        $window_stat = '';
        if (mysqli_num_rows($dataset) > 0) {

            echo '<div class="col-10 mx-auto my-5 bg-light rounded">
    <div class="col-sm-12 mx-auto p-5">
    <center> <h3><b> NOW SERVING</h3></b></center>';
            while ($data = $dataset->fetch_assoc()) {
                $window_name = $data['window_name'];
                $queue_id = $data['queue_id'];
                $countdown =  $data['countdown'];
                $div_id = "myDiv_" . $queue_id; // Generate unique ID for the countdown timer
                echo '<div class="alert alert-warning col-sm-11 mx-auto" id="window_service'.$div_id.'">';
                echo ' <center>' .  $window_name . '
        <hr>
        <h2><b> # &nbsp;' . $queue_id . '</b></h2>
        <div class="myDiv" id="' . $div_id . '"></div>
        </center>';
                echo '</div>';
        ?>
                <script>
                    $(document).ready(function() {
                        var countdownDuration = 300;

                        var eme = "<?php echo $countdown; ?>";
                        var targetTime = Date.parse(eme);
                        var startTime = targetTime;

                        // Calculate the end time of the countdown
                        var endTime = startTime + countdownDuration * 1000;

                        // Create a function to update the countdown timer
                        function updateCountdown() {
                            var currentTime = Date.now();

                            var remainingTime = Math.floor((endTime - currentTime) / 1000);
                            var div_id = "<?php echo $div_id; ?>"; // Get the unique ID for this countdown timer

                            if (remainingTime <= 0) {
                                clearInterval(intervalId);
                                $('#' + div_id).text("Time's up!");
                                $('#window_service' + div_id).removeClass('alert-warning').addClass('alert-danger');
                            } else {
                                var minutes = Math.floor(remainingTime / 60);
                                var seconds = remainingTime % 60;
                                var timeString = "Time remaining: ";
                                if (minutes > 0) {
                                    timeString += minutes + " minute" + (minutes > 1 ? "s" : "") + " ";
                                }
                                timeString += seconds + " second" + (seconds > 1 ? "s" : "");
                                $('#' + div_id).text(timeString);
                              
                            }
                        }

                        var intervalId = setInterval(updateCountdown, 1000);
                    });
                </script>
        <?php
            }

            echo '</div></div>';
        } else {
        }


        ?>

    </div>


    <div class="col-10 mx-auto my-5 bg-light rounded">

        <div class="col-sm-11 mx-auto p-5">
            <center>
                <h3><b>Services Booked For this Day : <span style="color: #679ED7;"><?php echo date('D jS F Y'); ?></span></b></h3>
            </center><br>

            <div id="notif"></div>

           
                <div style="overflow-x:auto;">
                    <table id="table_id" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Queue No.</th>
                                <th scope="col">Service</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql = "SELECT queue_id, service.service_id, service_name, status, date_created, user_id FROM queue_list, service  WHERE queue_list.service_id=service.service_id AND date_created= '$current_date' AND user_id=$userid  ";
                            $dataset = $connect->query($sql) or die("Error query");

                            if (mysqli_num_rows($dataset) > 0) {
                                while ($data = $dataset->fetch_array()) {
                                    $status = '';
                                    if ($data[3] == 0) {
                                        $status = 'Pending';
                                    } else if ($data[3] == 1) {
                                        $status = 'Onqueue';
                                    } else if ($data[3] == 2) {
                                        $status = 'Finished';
                                    } else if ($data[3] == 3) {
                                        $status = 'Void';
                                    }

                                    echo "<tr>
                  
      <td> $data[0]</td>
      <td>$data[2]</td>
      <td>$status</td>
      <td>";

                                    if ($status == 'Pending') {
                                        echo " <button type='button' id='update' class='eme'  style=' border: none; background-color: none;' data-id='$data[0]' data-serviceid='$data[1]' class='btn btn-success'><i  input type=\"edit\"  class=\"fa-solid fa-pen-to-square\" style=\"color:blue;\"></i></button>";
                                    } else {
                                        echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                    }
                                    echo " &nbsp;<button type='button' style=' border: none;' class='delete' data-id='$data[0]'> <i  input type=\"submit\"  class=\"fas fa-trash-alt\" style=\"color:red;\"></i> </button>
      </td>
     
      </tr>";
                                }
                            } else {
                                echo "Empty resultset";
                            }
                            echo "</tbody>
</table>"; 

?>

                </div>
            </div>

        </div>




        

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            var userid = "<?php echo $userid; ?>";
            var date = "<?php echo $current_date; ?>";

            function validateUpdateQueue() {


                var serviceId = document.getElementById("modalservice").value;


                $.ajax({
                    url: "check_duplicatequeue.php",
                    type: "POST",
                    data: {
                        currentdate: date,
                        id: userid,
                        serviceId: serviceId
                    },
                    success: function(result) {
                        if (result == 1) {
                            $('#modalservice').css("border", "1px solid red");
                            $('#errorService1').html("You already have a booking for this service today. (Duplication is prohibited)");
                        } else {
                            $('#modalservice').css("border", "1px solid grey");
                            $('#errorService1').html("");
                            submitQueueEdit();

                        }

                    },
                    error: function() {
                        alert("Error occurred");
                    }
                });

            }


            function submitQueueEdit() {

                var q_id = document.getElementById("modalID").value;
                var serviceId = document.getElementById("modalservice").value;

                $.ajax({
                    url: 'ajax/function_class.php?function=save_queue',
                    method: 'POST',
                    data: {
                        userid: userid,
                        serviceId: serviceId
                    },
                    success: function(res) {
                        if (res > 0) {
                            var nw = window.open("queue_print.php?id=" + res, "_blank", "height=500,width=800");
                            nw.print();
                            setTimeout(function() {
                                nw.close();
                            }, 200);
                            location.reload();
                        }
                    }
                })
            }
        </script>






</body>

</html>