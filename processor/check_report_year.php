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
$month = date('n');
$year = date('Y');

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
                        <h3 id="title"><b>Resolved Request Year: <span style="color: #679ED7;" id="buwan1"><?php echo date('Y'); ?><span></b></h3>
                        <h3><b><span style="color: #679ED7;" id="buwan2"></b></h3>
                    </center><br>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-sm-5"> <label for="">From Year</label>
                                    <input type="hidden" id="processorIDval" value="<?php echo $_SESSION['processor']['id']; ?>" class="form-control mb-3" required>

                                    <select name='month' id="filter1" class='form-select mb-3' name="month" required>
                                        <?php
                                        $currentYear = date('Y');
                                        $startYear = 1990;
                                        for ($i = $currentYear; $i >= $startYear; $i--) {
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-5"> <label for="">To Year</label>
                                    <select name='month' id="filter2" class='form-select mb-3' name="month" required>
                                        <?php
                                        $currentYear = date('Y');
                                        $startYear = 1990;
                                        for ($c = $currentYear; $c >= $startYear; $c--) {
                                            echo '<option value="' . $c . '">' . $c . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-2"><br>
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
                                      AND YEAR(trans_date) = '$year'
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

                $('#buwan1').text('From '+selectedfilter);
                $('#buwan2').text('To '+selectedfilter2);

                $.ajax({
                    url: '../ajax/filter_year.php',
                    type: 'POST',
                    data: {

                        dropdown: selectedfilter,
                        dropdown2: selectedfilter2,

                        processorID: processorID

                    },
                    success: function(html) {
                        $('#filterresult1').html(html);
                    }
                });
            });



        });
    </script>



</body>

</html>