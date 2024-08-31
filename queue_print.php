<?php
require 'config.php';

include('inc/header.php');
$id = $_GET['id'];
$qry = $connect->query("SELECT u_name, queue_id, service.service_id, service_name FROM queue_list, service, users  WHERE queue_id=$id AND queue_list.service_id=service.service_id AND users.id=queue_list.user_id" );
if ($qry) {
    $row = $qry->fetch_assoc();
	$service = $row['service_name'];
    $name = $row['u_name'];
    $queue_no = $row['queue_id'];
}
?>


<body>
<h4 style="text-align:center"><?php   echo ucwords($service)?></h4>
<h5 style="text-align:center"><b><?php echo ucwords($name) ?></b></h5>
<hr>
<h1 style="text-align:center"><b><?php echo ($queue_no) ?></b></h1>
<style>
	body *{
		margin:unset;
	}
</style>