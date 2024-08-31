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

date_default_timezone_set('Asia/Manila');
date('D jS F Y');

$current_date = date('Y-m-d');
$date = date('D jS F Y');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../inc/header.php'); ?>

    <link rel="stylesheet" href="../css/AdminStyle.css">
    <title>Admin Dashboard</title>
</head>

<body>
    <?php include('../inc/admin_navbar.php');
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        setInterval(function() {
            $('#reload').load('admin_reload.php');
        }, 30000);
    </script>

    <script>
        $(document).ready(function() {
            $('#table_id').DataTable();

            $("#setlimit").click(function(e) {
                e.preventDefault(); // prevent the default form submission

                // validate the input
                var limit = $("#n_limit").val();
                var date = "<?php echo $current_date; ?> ";
                if (isNaN(limit) || limit <= 0) {
                    swal("Invalid input", "Please enter a valid positive number.", "error");
                    return;
                }


                swal({
                    title: "Are you sure you want to set this maximum limit?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        //ajax call for delete
                        $.ajax({
                            url: "../ajax/function_class.php?function=add_maximumlimit",
                            method: 'post',
                            data: {
                                limit: limit,
                                date: date,
                            },
                            success: function(result) {
                                $('#registration_form').off('submit').submit();
                                location.reload();
                            }
                        });
                        tr.remove();
                    } else {}
                });
            });


            $("#editlimit").click(function(e) {
                e.preventDefault(); // prevent the default form submission

                // validate the input
                var limit = $("#limit_no_input").val();
                var id = $("#limit_id_input").val();
                if (isNaN(limit) || limit < 0) {
                    swal("Invalid input", "Please enter a valid positive number.", "error");
                    return;
                }


                swal({
                    title: "Are you sure you want to set this maximum limit?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        //ajax call for delete
                        $.ajax({
                            url: "../ajax/function_class.php?function=edit_maximumlimit",
                            method: 'post',
                            data: {
                                limit: limit,
                                id: id,
                            },
                            success: function(result) {
                                $('#limit_form').off('submit').submit();
                                location.reload();
                            }
                        });
                        tr.remove();
                    } else {}
                });
            });


            $('a[data-bs-target="#staticBackdrop1"]').click(function() {
                var limitNo = $(this).data('limit-no');
                var limitId = $(this).data('limit-id');

                $('#limit_no_input').val(limitNo);
                $('#limit_id_input').val(limitId);
            });



        });
    </script>

    <section class="home">

        <div class="cont">


            <?php include('admin_bar.php');
            ?>

            <!-- modal for edit -->
            <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h5 class="modal-title" style="color: black;" id="staticBackdropLabel">Set Maximum Limit for this Day : <span style="color: #679ED7;"><?php echo date('D jS F Y'); ?></span></h5><br>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="color: black;">
                            <br>
                            <div class="col-11 mx-auto">

                                <form action="" id="limit_form" method="post">
                                    <input type="hidden" id="limit_id_input" required class="form-control form-control-md">

                                    <div class="col mb-2">

                                        <label class="form-label">No. of Maximum Limit: </label><span class="asterisk"> *
                                            <input type="number" id="limit_no_input" required class="form-control form-control-md">
                                    </div>
                                    <br>
                                    <div class="col-12">
                                        <button type="submit" style="width: 100%;" id="editlimit" name="submitform" class="btn btn-primary"> Register </button>
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



            <div class="container">
                <br>
                <h3><b>Dashboard</b></h3>
                <div class="row row-cols-1 row-cols-lg-3 g-1 g-lg-1">
                    <div class="col">
                        <div class="p-3 border bg-light" id="box1">
                            <span class="dash1"> No. of Appointment Request Today, <?php echo $date;

                                                                                    ?></span>

                            <div class="row">

                                <div class="col-9">

                                    <h4><b><?php

                                            $get_count = mysqli_query($connect, "SELECT COUNT(*) as count FROM queue_list WHERE date_created = '$current_date'");

                                            if (mysqli_num_rows($get_count) > 0) {
                                                $row = mysqli_fetch_assoc($get_count);
                                                $result = $row['count'];
                                            } else {
                                                $result = 0;
                                            }

                                            echo  $result;


                                            ?></b> Bookings</h4>
                                </div>
                                <div class="col-3">
                                    <h4><i id="userr" class="fa-regular fa-calendar"></i></h4>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 border bg-light" id="box1">

                            <span class="dash1">No. of Maximum Request Today: </span>

                            <div class="row">
                                <div class="col-9">

                                    <?php


                                    $get_count = mysqli_query($connect, "SELECT * FROM limit_tb WHERE limit_date = '$current_date'");

                                    if (mysqli_num_rows($get_count) > 0) {
                                        $row = mysqli_fetch_assoc($get_count);
                                        $limit_no = $row['limit_no'];
                                        $limit_id = $row['limit_id'];
                                    } else {
                                        $limit_no = -1;
                                    }

                                    if ($limit_no == -1) {
                                        echo "<h4><b>No</b> Maximum Limit Set</h4> ";
                                        echo "<a class='nav-link' href='#' data-bs-toggle='modal' data-bs-target='#staticBackdrop'>SET MAXIMUM</a>";
                                    } else {
                                        echo "<h4><b>$limit_no</b> Request/s</h4>";
                                        echo "<a class='nav-link' href='#' data-bs-toggle='modal' data-bs-target='#staticBackdrop1' data-limit-no='$limit_no' data-limit-id='$limit_id'>EDIT MAXIMUM</a>";
                                    }


                                    ?>

                                </div>
                                <div class="col-3">
                                    <h4><i id="userr1" class="fa-solid fa-calendar-xmark"></i></h4>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 border bg-light" id="box1">
                            <span class="dash1">RESOLVED REQUEST FOR TODAY </span>


                            <div class="row">
                                <div class="col-9">

                                    <h4><b>

                                            <?php


                                            $result = mysqli_query($connect, "SELECT queue_transaction.*, u_name, service_name, window.window_id FROM users, queue_list, service, window, queue_transaction WHERE trans_status = 2 and trans_date = '$current_date' AND queue_list.queue_id=queue_transaction.queue_id AND users.id =queue_list.user_id AND window.processor_id= queue_transaction.processor_id AND service.service_id=queue_list.service_id ORDER BY queue_transaction.trans_id ASC");

                                            // Get the number of rows returned
                                            $num_rows = mysqli_num_rows($result);

                                            echo $num_rows;


                                            ?></b> Booking/s</h4><br>
                                </div>
                                <div class="col-3">
                                    <h4><i id="userr2" class="fa-regular fa-eye"></i></h4>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>




            <?php

            $result1 = mysqli_query($connect, "SELECT queue_transaction.*, u_name, service_name, window.window_id FROM users, queue_list, service, window, queue_transaction WHERE trans_status = 1 and trans_date = '$current_date' AND queue_list.queue_id=queue_transaction.queue_id AND users.id =queue_list.user_id AND window.processor_id= queue_transaction.processor_id AND service.service_id=queue_list.service_id ORDER BY queue_transaction.trans_id ASC");
            $processing = mysqli_num_rows($result1);





            $result2 = mysqli_query($connect, "SELECT queue_transaction.*, u_name, service_name, window.window_id FROM users, queue_list, service, window, queue_transaction WHERE trans_status = 2 and trans_date = '$current_date' AND queue_list.queue_id=queue_transaction.queue_id AND users.id =queue_list.user_id AND window.processor_id= queue_transaction.processor_id AND service.service_id=queue_list.service_id ORDER BY queue_transaction.trans_id ASC");
            $finished = mysqli_num_rows($result2);

            $result3 = mysqli_query($connect, "SELECT queue_transaction.*, u_name, service_name, window.window_id FROM users, queue_list, service, window, queue_transaction WHERE trans_status = 3 and trans_date = '$current_date' AND queue_list.queue_id=queue_transaction.queue_id AND users.id =queue_list.user_id AND window.processor_id= queue_transaction.processor_id AND service.service_id=queue_list.service_id ORDER BY queue_transaction.trans_id ASC");
            $void = mysqli_num_rows($result3);

            $result4 = mysqli_query($connect, "SELECT * FROM queue_list WHERE status = 0 and date_created = '$current_date' ");
            $pending = mysqli_num_rows($result4);




            $sqlservices = "SELECT s.service_id, s.service_name, COUNT(q.service_id) AS count FROM service s LEFT JOIN queue_list q ON s.service_id = q.service_id AND q.date_created = '$current_date' GROUP BY s.service_id, s.service_name";

            $resultchart = $connect->query($sqlservices);

            // Initialize arrays to store data for the chart
            $serviceIds = array();
            $serviceNames = array();
            $serviceCounts = array();

            // Fetch the data from the query result
            while ($row = $resultchart->fetch_assoc()) {
                $serviceIds[] = $row['service_id'];
                $serviceNames[] = $row['service_name'];
                $serviceCounts[] = $row['count'];
            }




            ?>




            <div class="container my-5">
                <div class="row row-cols-1 row-cols-lg-2 g-1 g-lg-4 ">
                    <div class="col">
                        <div class="p-3 border bg-light" id="box1">
                            <center>
                                <h5><b>STATUS SUMMARY</h4></H5>
                            </center>
                            <?php

                            if ($processing == 0 &&  $finished == 0 &&   $void == 0 && $pending == 0) {
                                echo " <center>There is no summary available for today yet, as there have been no transactions.</center>";
                            } else {
                                echo '<center><canvas id="myChart" style="width:100%;max-width:700px"></canvas></center>';
                            }

                            ?>

                        </div>
                    </div>

                    <div class="col">
                        <div class="p-3 border bg-light" id="box1">
                        <center>
                                <h5><b>SUMMARY OF REQUESTED SERVICES TODAY</h5></b>
                            </center>

                        <canvas id="myChartBar" style="width:100%;max-width:700px"></canvas>

                        </div>
                    </div>

                </div>
            </div>



            <div id="reload">
                <div class="col-11 mx-auto my-5 bg-light rounded">
                    <div class="col-sm-12 mx-auto p-5">

                        <h4><b>WINDOW NOW SERVING</h4></b>

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
                                echo '<div class="col-10"><i id="window" class="fa-solid fa-window-restore"></i>&nbsp;&nbsp;<b>' . $data[1] . '</b> &nbsp; <span style="color: #c66161;">(' . $window_stat . ')</span></div>';

                        ?>


                                <?php
                                $sql = "SELECT queue_transaction.*, u_name, countdown, service_name, window.window_id, window_name FROM users, queue_list, service, window, queue_transaction WHERE trans_status = 1 and trans_date = '$current_date' AND queue_list.queue_id=queue_transaction.queue_id AND users.id =queue_list.user_id AND window.processor_id= queue_transaction.processor_id AND service.service_id=queue_list.service_id AND window.window_id=$windowID ORDER BY queue_transaction.trans_id ASC";
                                $dataset2 = $connect->query($sql) or die("Error query");
                                $window_stat = '';
                                if (mysqli_num_rows($dataset2) > 0) {
                                    echo '<div class="col-10 mx-auto bg-light rounded">
<div class="col-sm-12 mx-auto ">';
                                    while ($data = $dataset2->fetch_assoc()) {
                                        $window_name = $data['window_name'];
                                        $queue_id = $data['queue_id'];
                                        $countdown =  $data['countdown'];
                                        $div_id = "myDiv_" . $queue_id; // Generate unique ID for the countdown timer
                                        echo '<div class="alert alert-warning col-sm-11 mx-auto" id="window_service' . $div_id . '">';
                                        echo ' <center>
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

                                    echo '<CENter>NO QUEUE</CENter>';
                                }


                                ?>









                        <?php



                                echo '</div>';
                            }
                        } else {
                            echo "No Windows Yet";
                        }


                        ?>



                    </div>
                </div>
            </div>




        </div>
    </section>





















    <!-- modal -->

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" style="color: black;" id="staticBackdropLabel">Set Maximum Limit for this Day : <span style="color: #679ED7;"><?php echo date('D jS F Y'); ?></span></h5><br>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: black;">
                    <br>
                    <div class="col-11 mx-auto">

                        <form action="" id="registration_form" method="post">

                            <div class="col mb-2">

                                <label class="form-label">No. of Maximum Limit: </label><span class="asterisk"> *
                                    <input type="number" id="n_limit" required class="form-control form-control-md">
                            </div>
                            <br>
                            <div class="col-12">
                                <button type="submit" style="width: 100%;" id="setlimit" name="submitform" class="btn btn-primary"> Register </button>
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



    <script>
        var pending = <?php echo $pending; ?>;
        var processing = <?php echo $processing; ?>;
        var finished = <?php echo $finished; ?>;
        var voidval = <?php echo $void; ?>;

        var xValues = ["Pending", "Processing", "Finished", "Void"];
        var yValues = [pending, processing, finished, voidval];
        //var yValues = [1, 2, 3, 4];

        var barColors = [
            "#2F5F98",
            "#2D8BBB",
            "#2D8BBA",
            "#41B8D5"
        ];

        new Chart("myChart", {
            type: "doughnut",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },

        });
    </script>



    <script>
        // Retrieve the data from PHP variables
        var serviceIds = <?php echo json_encode($serviceNames); ?>;
        var serviceCounts = <?php echo json_encode($serviceCounts); ?>;

        // Create the chart using Chart.js
        var ctx = document.getElementById('myChartBar').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: serviceIds,
                datasets: [{
                    label: 'Service Counts',
                    data: serviceCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });
    </script>


</body>

</html>