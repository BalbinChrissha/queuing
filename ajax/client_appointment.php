<?php
// require "config.php";
// $userid = $GET['userid'];
// $sql="SELECT queue_id, service.service_id, service_name, status, date_created, user_id FROM queue_list, service  WHERE queue_list.service_id=service.service_id AND date_created= '$current_date' AND user_id=$userid  ";
// $result=$connect->query($sql) or die ("Error");
// $infos="[";
// if ($result){
// 	while($data=$result->fetch_array()){
// 	$id=$data[0];
// 	$name=$data[2];
// 	$stat=$data[3];

//     $status = '';
//     if ($data[3] == 0) {
//         $status = 'Pending';
//     } else if ($data[3] == 1) {
//         $status = 'Finished';
//     }

// 	$infos.="['$id','$name','$status'],";
// 	}
   
// 	$infos=$infos."]";
	
// 	echo json_encode($infos);
// }


require "config.php";
$userid = $POST['userid'];
$sql="SELECT * FROM queue_list ";
$result=$connect->query($sql) or die ("Error");
$student="[";
if ($result){
	while($data=$result->fetch_array()){
	$id=$data[0];
	$name=$data[1];
	$sex=$data[2];
	$program=$data[3];
	$student.="['$id','$name','$sex','$program'],";
	}
	$student=$student."]";
	
	echo json_encode($student);
}




?>
