<?php
require '../config.php';

if (!isset($_SESSION['processor'])) {
    header('Location: ../index.php');
    exit;
}

$username = $_SESSION['processor']['username'];

$get_user = mysqli_query($connect, "SELECT * FROM users WHERE username='$username'");
if (mysqli_num_rows($get_user) > 0) {
    $processor = mysqli_fetch_assoc($get_user);
    $processorID = $processor['id'];
} else {
    header('Location: ../logout.php');
    exit;
}

date_default_timezone_set('Asia/Manila');
date('D jS F Y');

$current_date = date('Y-m-d');
$date = date('D jS F Y');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../inc/header.php'); ?>

    <link rel="stylesheet" href="../css/ProcessorStyle.css">
    <title>Processor Dashboard</title>
</head>

<body>
    <?php include('../inc/processor_navbar.php');
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {


            $('#table_id').DataTable();



            $("#accept_queue").click(function() {


                var id = $(this).data('id');
                var p_id = "<?php echo  $processorID; ?>";


                $.ajax({
                    url: "../ajax/function_class.php?function=update_queue_addtrans",
                    method: 'post',
                    data: {
                        queue_id: id,
                        p_id: p_id,
                    },
                    success: function(result) {
                        // alert(result);
                        location.reload();

                    },
                    error: function() {
                        alert("Error occurred");
                    }
                });



            });

            $("#finish_queue").click(function() {


                var id = $(this).data('id');
                var trans_id = $(this).data('transid');
                var stat = $(this).data('stat');

                queueFinishTrans(id, trans_id, stat);


            });

            $("#missing_queue").click(function() {


                var id = $(this).data('id');
                var trans_id = $(this).data('transid');
                var stat = $(this).data('stat');

                queueFinishTrans(id, trans_id, stat);


            });




            function queueFinishTrans(id, trans_id, stat) {

                // alert(id + " hhe " + trans_id + " " + stat);


                $.ajax({
                    url: "../ajax/function_class.php?function=update_finish_trans",
                    method: 'post',
                    data: {
                        queue_id: id,
                        trans_id: trans_id,
                        stat: stat,
                    },
                    success: function(result) {
                        // alert(result);
                        location.reload();

                    },
                    error: function() {
                        alert("Error occurred");
                    }
                });

            }



        });
    </script>

    <section class="home">

        <div class="cont">


            <?php include('processor_bar.php');
            ?>





            <div class="container">
                <br>
                <h3><b>Dashboard</b></h3>
                <div class="row row-cols-1 row-cols-lg-3 g-1 g-lg-1">
                    <div class="col">
                        <div class="p-3 border bg-light" id="box1">
                            <span class="dash1"> No. of Pending Request Today, <?php echo $date;

                                                                                ?></span>

                            <div class="row">

                                <div class="col-9">

                                    <h4><b><?php

                                            $get_count = mysqli_query($connect, "SELECT COUNT(*) AS count FROM ( SELECT u_name, service_name, queue_id, MIN(window.window_id) AS window_id, status FROM users, queue_list, service, window, transaction_windows WHERE service.service_id = queue_list.service_id AND status = 0 AND date_created = '$current_date' AND w_status = 1 AND users.id=queue_list.user_id AND transaction_windows.window_id = window.window_id AND service.service_id = transaction_windows.service_id AND window.processor_id = $processorID GROUP BY queue_id, service.service_id ) AS subquery;");

                                            if (mysqli_num_rows($get_count) > 0) {
                                                $row = mysqli_fetch_assoc($get_count);
                                                $result = $row['count'];
                                            } else {
                                                $result = 0;
                                            }

                                            echo  $result;


                                            ?></b> Booking/s</h4>
                                    <a href="view_pending.php?count=<?php echo $result; ?>" id="view">VIEW LIST OF PENDING REQUEST</a>
                                </div>
                                <div class="col-3">
                                    <h4><i id="userr" class="fa-regular fa-calendar"></i></h4>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 border bg-light" id="box1">

                            <span class="dash1">No. of Resolved Request Today: </span>

                            <div class="row">
                                <div class="col-9">
                                    <h4><b>

                                            <?php


                                            $result = mysqli_query($connect, "SELECT queue_transaction.*, u_name, service_name, window.window_id FROM users, queue_list, service, window, queue_transaction WHERE trans_status = 2 and trans_date = '$current_date' AND queue_transaction.processor_id =$processorID AND queue_list.queue_id=queue_transaction.queue_id AND users.id =queue_list.user_id AND window.processor_id= queue_transaction.processor_id AND service.service_id=queue_list.service_id ORDER BY queue_transaction.trans_id ASC");

                                            // Get the number of rows returned
                                            $num_rows = mysqli_num_rows($result);

                                            echo $num_rows;


                                            ?></b> Booking/s</h4>
                                    <a href="view_finished.php?count=<?php echo  $num_rows; ?>" id="view">VIEW LIST OF FINISHED REQUEST</a>


                                </div>
                                <div class="col-3">
                                    <h4><i id="userr1" class="fa-regular fa-calendar-check"></i></i></h4>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 border bg-light" id="box1">
                            <span class="dash1">Report of Resolved Request</span>


                            <div class="row">
                                <div class="col-9">
                                <h4><b>
                                    <?php $get_count = mysqli_query($connect, "SELECT COUNT(*) AS count FROM (SELECT queue_transaction.*, u_name, service_name, window.window_id FROM users, queue_list, service, window, queue_transaction WHERE trans_status = 2 AND queue_list.queue_id=queue_transaction.queue_id AND users.id =queue_list.user_id AND window.processor_id= queue_transaction.processor_id AND service.service_id=queue_list.service_id ORDER BY queue_transaction.trans_id ASC) AS subquery;
");

                                    if (mysqli_num_rows($get_count) > 0) {
                                        $row = mysqli_fetch_assoc($get_count);
                                        $result = $row['count'];
                                    } else {
                                        $result = 0;
                                    }

                                    echo  $result;


                                    ?></b> Booking/s</h4>
                                    <a href="view_report_daily.php" id="view">DAY</a> &nbsp; <b>|</b>  &nbsp;
                                    <a href="view_report.php" id="view">MONTH</a> &nbsp; <b>|</b>  &nbsp;
                                    <a href="check_report_year.php" id="view">YEAR</a>

                                </div>
                                <div class="col-3">
                                    <h4><i id="userr2" class="fa-regular fa-eye"></i></h4>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>


            <div class="col-10 mx-auto my-5  bg-light rounded">
                <div class="col-sm-12 mx-auto p-5">





                    <?php


                    $get_user = mysqli_query($connect, "SELECT queue_transaction.*,  u_name, countdown, service_name, window.window_id, window_name FROM users, queue_list, service, window, queue_transaction WHERE trans_status = 1 and trans_date = '$current_date' AND queue_transaction.processor_id =$processorID AND queue_list.queue_id=queue_transaction.queue_id AND users.id =queue_list.user_id AND window.processor_id= queue_transaction.processor_id AND service.service_id=queue_list.service_id ORDER BY queue_transaction.trans_id ASC LIMIT 1;");
                    if (mysqli_num_rows($get_user) > 0) {

                        $rows = mysqli_fetch_assoc($get_user);
                        $name = $rows['u_name'];
                        $service_name = $rows['service_name'];
                        $queue_id = $rows['queue_id'];
                        $window_id = $rows['window_id'];
                        $status = $rows['trans_status'];
                        $window_name = $rows['window_name'];
                        $trans_id =  $rows['trans_id'];
                        $countdown =  $rows['countdown'];

                        echo '<input type="hidden" id="next_queue_id" value="' . $queue_id . '"> <input type="hidden" id="next_trans_id" value="' . $trans_id . '">';


                        echo '<div class="row"> <div class="col-sm-5 alert alert-dark">

                                <center>NOW SERVING<br>' .  $window_name . '
                                    <hr>

                                    <h4><b> # &nbsp;' . $queue_id . '</b></h4>
                                </center>';


                        echo '   Client : <b>' . ucwords($name) . '</b> <br>
                                Service : <b>' . ucwords($service_name) . '</b>

                                <div id="myDiv"></div>

                            </div>';

                        echo ' <div class="col-sm-7" style="display: flex; justify-content: center;align-items: center;">

                                <center>
                               
                                <button type="button"  class="btn btn-info" id="finish_queue" data-id="' . $queue_id . '" data-transid="' . $trans_id . '" data-stat="2" style="padding: 10px  40px 10px 40px; color:white;" >
                                        <h3 style="color: white;"> <i class="fa-solid fa-circle-check"></i> <span id="accept"><b>Next</b></span> </h3>
                                    </button><br><br>
                                    <button type="button" class="btn btn-danger" id="missing_queue" data-id="' . $queue_id . '" data-transid="' . $trans_id . '" data-stat="3" style="padding: 10px  40px 10px 40px;" >
                                    <h3 style="color: white;"> <i class="fa-solid fa-circle-xmark"></i> <span id="accept"><b>Missing</b></span></h3>
                                </button>
                                </center>


                            </div>  </div>';
                    } else {

                        $get_count = mysqli_query($connect, " SELECT u_name, service_name, queue_id, MIN(window.window_id) AS window_id, status FROM users, queue_list, service, window, transaction_windows WHERE service.service_id = queue_list.service_id AND status = 0 AND date_created = '$current_date' AND w_status = 1 AND users.id=queue_list.user_id AND transaction_windows.window_id = window.window_id AND service.service_id = transaction_windows.service_id AND processor_id = $processorID GROUP BY queue_id, service.service_id ORDER BY queue_id ASC LIMIT 1");
                        if (mysqli_num_rows($get_count) > 0) {
                            $row = mysqli_fetch_assoc($get_count);
                            $name = $row['u_name'];
                            $service_name = $row['service_name'];
                            $queue_id = $row['queue_id'];
                            $window_id = $row['window_id'];
                            $status = $row['status'];



                            echo ' <div class="row"> <div class="col-sm-5 alert alert-dark"><center>PENDING<hr>

            <h4><b> # &nbsp;' . $queue_id . '</b></h4>
        </center>';


                            echo '   Client : <b>' . ucwords($name) . '</b> <br>
        Service : <b>' . ucwords($service_name) . '</b>

    </div>';

                            echo ' <div class="col-sm-7" style="display: flex; justify-content: center;align-items: center;">

        <center>
       
        <button type="button" class="btn btn-info" id="accept_queue" data-id="' . $queue_id . '" style="padding: 10px  40px 10px 40px;" >
                <h3 style="color: white;"> <i class="fa-solid fa-circle-check"></i> <span id="accept"><b>Accept</b></span> </h3>
            </button>
        </center>


    </div>      </div>';
                        } else {
                            echo '<div class="alert alert-warning" role="alert">
                          <center>  There are no requests pending at the moment. </center>  
                          </div>';
                        }
                    }



                    ?>





                </div>
            </div>










        </div>
    </section>


    <!-- modal -->
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
                var queueID = $("#next_queue_id").val();
                var transID = $("#next_trans_id").val();

                var currentTime = Date.now();

                var remainingTime = Math.floor((endTime - currentTime) / 1000);

                if (remainingTime <= 0) {
                    clearInterval(intervalId);
                    $('#myDiv').text("Time's up!");
                    swal({
                        title: "The time is up do you want to go on to the next queue?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {

                            swal({
                                title: "Did the Client Show Up?",
                                text: "If the Cliend did not show up, the record will be recorded as (VOID)!",
                                icon: "warning",
                                buttons: {
                                    cancel: "Cancel",
                                    yes: {
                                        text: "Yes",
                                        value: "yes",
                                    },
                                    no: {
                                        text: "No",
                                        value: "no",
                                        dangerMode: true,
                                    },
                                },
                            }).then((value) => {
                                if (value === "yes") {
                                    queueNextFinishTrans(queueID, transID, 2);

                                } else if (value === "no") {
                                    queueNextFinishTrans(queueID, transID, 3);
                                } else {

                                }
                            });



                        } else {}
                    });
                } else {
                    var minutes = Math.floor(remainingTime / 60);
                    var seconds = remainingTime % 60;
                    var timeString = "Time remaining: ";
                    if (minutes > 0) {
                        timeString += minutes + " minute" + (minutes > 1 ? "s" : "") + " ";
                    }
                    timeString += seconds + " second" + (seconds > 1 ? "s" : "");
                    $('#myDiv').text(timeString);
                    //$('#myDiv').text("Time remaining: " + remainingTime + " seconds");

                }
            }





            var intervalId = setInterval(updateCountdown, 1000);



            function queueNextFinishTrans(queueID, transID, stat) {
                $.ajax({
                    url: "../ajax/function_class.php?function=update_finish_trans",
                    method: 'post',
                    data: {
                        queue_id: queueID,
                        trans_id: transID,
                        stat: stat,
                    },
                    success: function(result) {
                        // alert(result);
                        location.reload();

                    },
                    error: function() {
                        alert("Error occurred");
                    }
                });

            }

        });
    </script>




</body>

</html>