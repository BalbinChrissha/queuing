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


if (!isset($_GET['processorID'])) {
    header('Location: admin_manage_processor.php');
}

$processorID = $_GET['processorID'];



date_default_timezone_set('Asia/Manila');
date('D jS F Y');

$current_date = date('Y-m-d');
$date = date('D jS F Y');
$month = date('n');
$year = date('Y');


$title_date = date('M j, Y', strtotime($current_date));


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
        });
    </script>

    <?php include('../inc/admin_navbar.php');
    ?>



    <section class="home">
        <div class="cont">



            <?php include('admin_bar.php'); ?>





            <div class="col-10 mx-auto my-5 bg-light rounded">

                <div class="col-sm-11 mx-auto p-5">
                    <center>
                        <h3 id="title"><b><span id="title2">Resolved Request</span> <br><span style="color: #679ED7;" id="buwan1"><?php echo $title_date; ?><span>
                            </b></h3>
                        <h3> <b><span style="color: #679ED7;" id="buwan2"></span></b></h3>
                    </center><br>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-sm-5"> <label for="">From Day: </label>
                                    <input type="date" name="year" id="filter1" value="<?php echo $current_date; ?>" class="form-control mb-3" required>
                                </div>
                                <div class="col-sm-5">
                                    <label for="">To Day: </label>
                                    <input type="date" name="year" id="filter2" value="<?php echo $current_date; ?>" class="form-control mb-3" required>
                                    <input type="hidden" id="processorIDval" value="<?php echo $processorID; ?>" class="form-control mb-3" required>

                                </div>
                                <div class="col-sm-2">
                                    <label for=""></label>
                                    <button type="button" id="daterange" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div style="overflow-x:auto;" id="filterresult1">
                            <table id="table_id" class="table table-striped">
                                <thead>
                                    <tr>

                                        <th scope="col">Queue No.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Service</th>
                                        <th scope="col">Date</th>



                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $sql = "SELECT queue_transaction.*, u_name, service_name, window.window_id , window_name
                    FROM users, queue_list, service, window, queue_transaction 
                    WHERE trans_status = 2 
                      AND queue_list.queue_id=queue_transaction.queue_id 
                      AND users.id =queue_list.user_id 
                      AND window.processor_id= queue_transaction.processor_id 
                      AND service.service_id=queue_list.service_id 
                      AND trans_date BETWEEN '$current_date' AND '$current_date'
                      AND window.processor_id = $processorID
                    ORDER BY queue_transaction.trans_id ASC;";
                                    $dataset = $connect->query($sql) or die("Error query");

                                    if (mysqli_num_rows($dataset) > 0) {
                                        while ($rows = $dataset->fetch_array()) {
                                            $formatted_date = date('M j, Y', strtotime($rows[4]));



                                            echo "<tr>

<td> $rows[2] </td>
<td> $rows[6]</td>
<td>  $rows[7]</td>
<td> $formatted_date</td>




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








    <script>
        $(document).ready(function() {


            $('#daterange').click(function() {
                var selectedDate = $('#filter1').val();
                var selectedDate2 = $('#filter2').val();
                var processorID = $('#processorIDval').val();

                //alert(processorID);


                let monthNames = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];

                let dateStr = selectedDate;
                let dateStr2 = selectedDate2;

                let dateObj = new Date(dateStr);
                let dateObj2 = new Date(dateStr2);

                let monthIndex = dateObj.getMonth();
                let monthIndex2 = dateObj2.getMonth();

                let monthName = monthNames[monthIndex];
                let monthName2 = monthNames[monthIndex2];

                let day = dateObj.getDate();
                let day2 = dateObj2.getDate();

                let year = dateObj.getFullYear();
                let year2 = dateObj2.getFullYear();

                let formattedDate = monthName + " " + day.toString().padStart(2, '0') + ", " + year;
                let formattedDate2 = monthName2 + " " + day2.toString().padStart(2, '0') + ", " + year2;

                $('#buwan1').text(formattedDate + ' & ');
                $('#buwan2').text(formattedDate2);
                $('#title2').text('Resolved Request Range Between');


                $.ajax({
                    url: '../ajax/filter_daily.php',
                    type: 'POST',
                    data: {
                        dropdown: selectedDate,
                        dropdown2: selectedDate2,
                        processorID: processorID
                    },
                    success: function(html) {
                        $('#filterresult1').html(html); // Update the content of the div
                    }
                });
            });



        });
    </script>






</body>

</html>