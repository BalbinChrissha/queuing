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


// Retrieve the button value from the request
$dropdown = $_POST['dropdown'];
$dropdown2 = $_POST['dropdown2'];
$year = $_POST['year'];
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


//$sql = "SELECT item_transfer.recordno, item_state.checkedID, stateID, item.itemid, item_name, category_name, available_qty, unavailable1_qty, unavailable2_qty,month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND facultyID = $facultyID AND category.categoryID = 1 AND month='$dropdown' AND year = $year ORDER BY item_state.recordno";
$sql = "SELECT queue_transaction.*, u_name, service_name, window.window_id , window_name
FROM users, queue_list, service, window, queue_transaction 
WHERE trans_status = 2 
  AND queue_list.queue_id=queue_transaction.queue_id 
  AND users.id =queue_list.user_id 
  AND window.processor_id= queue_transaction.processor_id 
  AND service.service_id=queue_list.service_id 
  AND window.processor_id = $processorID
  AND MONTH(trans_date) BETWEEN  '$dropdown' AND '$dropdown2'
  AND YEAR(trans_date) = '$year'
ORDER BY queue_transaction.trans_id ASC;";
//$sql = "SELECT item_transfer.recordno, item_state.checkedID, stateID, item.itemid, item_name, category_name, item_cond, state_quantity, month, year FROM item, category, item_transfer, item_last_checked , item_state, item_condition WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND item_state.conditionID=item_condition.conditionID AND item_condition.categoryID= category.categoryID AND facultyID = $facultyID AND month='$dropdown' AND year =$year ORDER BY item_state.recordno";
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