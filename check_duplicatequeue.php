<?php
require "config.php";



$connect;
$date = $_POST['currentdate'];
$userid = $_POST['id'];
$serviceId = $_POST['serviceId'];
$get_user = mysqli_query($connect, "SELECT * FROM queue_list WHERE user_id=$userid AND service_id=$serviceId AND date_created='$date'");
if (mysqli_num_rows($get_user) > 0) {
    $result = 1;
} else {
    $result = 0;
}

echo  $result;

// echo 'hahha';


mysqli_close($connect);
?>