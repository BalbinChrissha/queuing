<?php
require 'config.php';

if (isset($_SESSION['user'])) {
    header('Location: staffhome.php');
    exit;
} else if (isset($_SESSION['admin'])) {
    header('location: admin/adminpage.php');
    exit;
} else if(isset($_SESSION['client'])){
    header('location: clienthome.php');
    exit;
}


?>
<?php include('inc/header.php');
?>
<link rel="stylesheet" href="css/indexstyle.css">
<title>Queuing System - Midterm Requirement</title>

<?php include('inc/container.php'); ?>


<div class="logo">
    <center>
        <img src="images/citylogo.png" alt="">
    </center>
    <br>
    <center>
        <h1><b>CITY TREASURER'S OFFICE QUEUING SYSTEM</b></h1>
    </center>
</div>














</body>

</html>