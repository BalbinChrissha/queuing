<!DOCTYPE html>
<?php include('inc/header.php'); ?>
<link rel="stylesheet" href="css/clientstyle.css">
<title>Client Dashboard</title>
</head>

<body>

<?php 


require 'config.php';

date_default_timezone_set('Asia/Manila');
date('D jS F Y');
$current_date = date('Y-m-d');

$userid = $_GET['id'];


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
        echo '<div class="alert alert-warning col-sm-11 mx-auto" id="window_service">';
        echo ' <center>' .  $window_name . '
        <hr>
        <h4><b> # &nbsp;' . $queue_id . '</b></h4>
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



<!-- <script>
            $(document).ready(function() {
                var countdownDuration = 200;

                var eme = "<?php //echo $countdown; ?>";
                var targetTime = Date.parse(eme);
                var startTime = targetTime;



                // Calculate the end time of the countdown
                var endTime = startTime + countdownDuration * 1000;

                // Create a function to update the countdown timer
                function updateCountdown() {
                    var currentTime = Date.now();

                    var remainingTime = Math.floor((endTime - currentTime) / 1000);

                    if (remainingTime <= 0) {
                        clearInterval(intervalId);
                        $('.myDiv').text("Time's up!");
                    } else {
                        $('.myDiv').text("Time remaining: " + remainingTime + " seconds");
                    }
                }

                var intervalId = setInterval(updateCountdown, 1000);

            });
        </script> -->
