<?php
require "../config.php";
include('../inc/header.php');
?>
<style>
  body {
    font-family: 'Poppins';
    width: 100%;
    height: auto;
    /* background-image: url('images/banner.jpg'); */
    background-attachment: fixed;
    background-size: cover;
  }
</style>


<?php


$date1 = $_POST['dropdown'];
$date2 = $_POST['dropdown2'];
$processorID = $_POST['processorID'];

$html = '';
$html .= '<table id="table_id3" class="display">';
$html .= '<thead>';
$html .= ' <tr>';
$html .= '<th scope="col">Queue No.</th>
<th scope="col">Name</th>
<th scope="col">Service</th>
<th scope="col">Date</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';


$sql = "SELECT queue_transaction.*, u_name, service_name, window.window_id , window_name
FROM users, queue_list, service, window, queue_transaction 
WHERE trans_status = 2 
  AND queue_list.queue_id=queue_transaction.queue_id 
  AND users.id =queue_list.user_id 
  AND window.processor_id= queue_transaction.processor_id 
  AND service.service_id=queue_list.service_id 
  AND trans_date BETWEEN '$date1' AND '$date2'
  AND window.processor_id = $processorID
ORDER BY queue_transaction.trans_id ASC;";
$dataset = $connect->query($sql) or die("Error query");

if (mysqli_num_rows($dataset) > 0) {
  while ($data = $dataset->fetch_array()) {
    $formatted_date = date('M j, Y', strtotime($data[4]));


    $html .= '<tr>';
    $html .= '<td>' . $data['2'] . '</td>';
    $html .= '<td>' . $data['6'] . '</td>';
    $html .= '<td>' . $data['7'] . '</td>';
    $html .= '<td>' .  $formatted_date . '</td>';
    $html .= '</tr>';
  }
} else {
  $html .= 'Empty resultset';
}
$html .= '</tbody></table>';






echo $html;

?>

<script>
  $(document).ready(function() {
    $('#table_id3').DataTable();
    // $('#table_id1').DataTable();
    //$('#table_id2').DataTable();
  });
</script>