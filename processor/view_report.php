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
$currentYear = date('Y');
$date = date('D jS F Y');
$month = date('n');

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
        });
    </script>

    <section class="home">

        <div class="cont">


            <?php include('processor_bar.php');
            ?>



            <div class="col-10 mx-auto my-5 bg-light rounded">

                <div class="col-sm-11 mx-auto p-5">
                    <center>
                        <h3 id="title"><b>Resolved Request: <span style="color: #679ED7;" id="buwan1"><?php echo date('F'); ?><span></b></h3>
                        <h3><b><span style="color: #679ED7;" id="buwan2"></span><span id="taon1"><?php echo date('Y'); ?><span></b></h3>
                    </center><br>
                   
             
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-sm-3"> <label for="">From Month</label>
                                    <input type="hidden" id="processorIDval" value="<?php echo $_SESSION['processor']['id']; ?>" class="form-control mb-3" required>
                                    <select name='month' id="filter1" class='form-select mb-3' name="month" required>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="col-sm-3"> <label for="">To Month</label>
                                    <select id="filter2" class='form-select mb-3' name="month" required>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="col-sm-3"><label for="">Year</label>
                                    <input type="number" name="year" id="year1" value="<?php echo $currentYear  ?>" class="form-control mb-3" required>
                                    <!-- <input type="hidden" name="year" id="facultyID1" value="<?php //echo $_SESSION['faculty_incharge']['facultyID']; 
                                                                                                    ?>" class="form-control mb-3" required> -->
                                </div>
                                <div class="col-sm-3"><br>
                                    <button type="button" id="daterange" class="btn btn-primary">Filter</button>
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
                                      AND window.processor_id = $processorID
                                      AND MONTH(trans_date) = '$month'
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
                var selectedfilter = $('#filter1').val();
                var selectedfilter2 = $('#filter2').val();
                var processorID = $('#processorIDval').val();


                var inputValue = $('#year1').val();

                let newmonth = selectedfilter.toUpperCase();

                var newm = '';
                if (selectedfilter == 1) {
                    newm = 'January';
                } else if (selectedfilter == 2) {
                    newm = 'February';
                } else if (selectedfilter == 3) {
                    newm = 'March';
                } else if (selectedfilter == 4) {
                    newm = 'April';
                } else if (selectedfilter == 5) {
                    newm = 'May';
                } else if (selectedfilter == 6) {
                    newm = 'June';
                } else if (selectedfilter == 7) {
                    newm = 'July';
                } else if (selectedfilter == 8) {
                    newm = 'August';
                } else if (selectedfilter == 9) {
                    newm = 'September';
                } else if (selectedfilter == 10) {
                    newm = 'October';
                } else if (selectedfilter == 11) {
                    newm = 'November';
                } else if (selectedfilter == 12) {
                    newm = 'December';
                }



                var newm2 = '';
                if (selectedfilter2 == 1) {
                    newm2 = 'January';
                } else if (selectedfilter2 == 2) {
                    newm2 = 'February';
                } else if (selectedfilter2 == 3) {
                    newm2 = 'March';
                } else if (selectedfilter2 == 4) {
                    newm2 = 'April';
                } else if (selectedfilter2 == 5) {
                    newm2 = 'May';
                } else if (selectedfilter2 == 6) {
                    newm2 = 'June';
                } else if (selectedfilter2 == 7) {
                    newm2 = 'July';
                } else if (selectedfilter2 == 8) {
                    newm2 = 'August';
                } else if (selectedfilter2 == 9) {
                    newm2 = 'September';
                } else if (selectedfilter2 == 10) {
                    newm2 = 'October';
                } else if (selectedfilter2 == 11) {
                    newm2 = 'November';
                } else if (selectedfilter2 == 12) {
                    newm2 = 'December';
                }


                // $('#buwan').replaceWith('<span id="buwan">' + newmonth + '</span>');
                $('#taon1').text(inputValue);
                $('#buwan1').text('From '+ newm);
                $('#buwan2').text('To '+ newm2+ ' ');

                $.ajax({
                    url: '../ajax/fac_filter_itemstate_report.php', // URL of the server-side script
                    type: 'POST', // Use the POST method
                    data: {
                        dropdown: selectedfilter,
                        dropdown2: selectedfilter2,
                        year: inputValue,
                        processorID: processorID

                    }, // Send any data that you need to the server
                    success: function(html) {
                        $('#filterresult1').html(html); // Update the content of the div
                    }
                });
            });



        });
    </script>



</body>

</html>