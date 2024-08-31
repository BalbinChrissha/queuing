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


if (!isset($_GET['count'])) {
    header('Location: processorpage.php');
}

$count = $_GET['count'];

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
        });
    </script>

    <section class="home">

        <div class="cont">


            <?php include('processor_bar.php');
            ?>



            <div class="col-10 mx-auto my-5 bg-light rounded">

                <div class="col-sm-11 mx-auto p-5">
                    <center>
                        <h3><b> (<?php echo $count; ?>) Resolved Request: <span style="color: #679ED7;"><?php echo date('D jS F Y'); ?></span></b></h3>
                        <h4><?php echo  $window_user; ?></h4>
                    </center><br>

                    <div id="notif"></div>

                    <div class="row">
                        <div style="overflow-x:auto;">
                            <table id="table_id" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Queue No.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Service</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $sql = "SELECT queue_transaction.*, u_name, service_name, window.window_id FROM users, queue_list, service, window, queue_transaction WHERE trans_status = 2 and trans_date = '$current_date' AND queue_transaction.processor_id =$processorID AND queue_list.queue_id=queue_transaction.queue_id AND users.id =queue_list.user_id AND window.processor_id= queue_transaction.processor_id AND service.service_id=queue_list.service_id ORDER BY queue_transaction.trans_id ASC;";
                                    $dataset = $connect->query($sql) or die("Error query");

                                    if (mysqli_num_rows($dataset) > 0) {
                                        while ($data = $dataset->fetch_assoc()) {
                                            $queue = $data['queue_id'];
                                            $name = $data['u_name'];
                                            $service = $data['service_name'];

                                            echo "<tr>
          
<td> $queue</td>
<td> $name</td>
<td> $service</td>


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






</body>

</html>