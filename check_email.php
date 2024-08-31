<?php
require "config.php";
$email = $_POST['email'];


$get_user = mysqli_query($connect, "SELECT * FROM users WHERE username='$email'");
if(mysqli_num_rows($get_user) > 0){
    $result = 1;
}
else{
    $result = 0;
}

echo  $result;
mysqli_close($connect);
?>