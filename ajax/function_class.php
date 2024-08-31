<?php
require '../config.php';
class MyClass
{
    function save_queue()
    {

        global $connect;
        $userid = $_POST['userid'];
        $serviceId = $_POST['serviceId'];

        $insert = mysqli_query($connect, "INSERT INTO queue_list (user_id, service_id) values ($userid, $serviceId)");
        if (!$insert) {
            echo  die(mysqli_error($connect));
        } else {
            $insert_id = $connect->insert_id;
            return $insert_id;
        }
    }

    function add_userclient()
    {

        global $connect;
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];

        $insert = mysqli_query($connect, "INSERT INTO `users` (`u_name`, `username`, `password`,`phone` ) VALUES ('$name',  '$email', '$password', '$phone')");

        if (!$insert) {
            die(mysqli_error($connect));
        }
    }

    function check_service()
    {
        global $connect;
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
    }

    function delete_queue()
    {

        global $connect;
        $id = $_POST['idno'];
        // echo $id;
        $delete = mysqli_query($connect, "delete from queue_list where queue_id=$id");
        if ($delete) {
            echo '<center><div class="alert alert-success" role="alert">
            The record has been successfully deleted!
          </div></center>';
        }
    }
    function update_queue()
    {

        global $connect;
        $id = $_POST['idno'];
        $serviceId = $_POST['serviceId'];
        $delete = mysqli_query($connect, "UPDATE queue_list SET service_id=$serviceId where queue_id=$id");
        if ($delete) {
            return $id;
        }
    }
    function delete_account()
    {

        global $connect;
        $id = $_POST['idno'];
        // echo $id;
        $delete = mysqli_query($connect, "delete from users where id=$id");
        if ($delete) {
            echo '<center><div class="alert alert-success" role="alert">
            The account has been successfully deleted!
          </div></center><br>';
        }
    }
    function add_useradmin()
    {

        global $connect;
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $insert = mysqli_query($connect, "INSERT INTO `users` (`u_name`, `type`, `username`, `password`) VALUES ('$name', 1, '$email', '$password')");
        if (!$insert) {
            die(mysqli_error($connect));
        }
    }



    function edit_user()
    {

        global $connect;
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $insert = mysqli_query($connect, "UPDATE users SET u_name = '$name', username= '$email', password = '$password' WHERE id= $id");

        if (!$insert) {
            die(mysqli_error($connect));
        }
    }
    function fetch_desc()
    {

        global $connect;
        $id = $_POST['id'];

        $result =  $connect->query("SELECT * FROM service WHERE service_id= $id") or die("Error Query");
        if ($result) {
            if ($result->num_rows >= 1) {

                while ($rows = $result->fetch_array()) {
                    $response = $rows[2];
                }
            }
        }

        echo  $response;
    }


    function add_userprocessor()
    {
        global $connect;
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $insert = mysqli_query($connect, "INSERT INTO `users` (`u_name`, `type`, `username`, `password`) VALUES ('$name', 2, '$email', '$password')");
        if (!$insert) {
            die(mysqli_error($connect));
        }
    }

    function delete_service()
    {

        global $connect;
        $id = $_POST['idno'];
        // echo $id;
        $delete = mysqli_query($connect, "delete from service where service_id=$id");
        if ($delete) {
            echo '<center><div class="alert alert-success" role="alert">
            The service has been successfully deleted!
          </div></center><br>';
        }
    }


    function add_services()
    {
        global $connect;
        $name = $_POST['name'];
        $desc = $_POST['desc'];

        $insert = mysqli_query($connect, "INSERT INTO `service` (`service_name`, `service_desc`) VALUES ('$name', '$desc')");
        if (!$insert) {
            die(mysqli_error($connect));
        }
    }


    function edit_service()
    {

        global $connect;
        $id = $_POST['id'];
        $name = $_POST['name'];
        $desc = $_POST['desc'];

        $insert = mysqli_query($connect, "UPDATE service SET service_name = '$name', service_desc= '$desc' WHERE service_id= $id");

        if (!$insert) {
            die(mysqli_error($connect));
        }
    }

    function add_maximumlimit()
    {
        global $connect;
        $limit = $_POST['limit'];
        $date = $_POST['date'];

        $insert = mysqli_query($connect, "INSERT INTO `limit_tb` (`limit_no`, `limit_date`) VALUES ($limit, '$date')");
        if (!$insert) {
            die(mysqli_error($connect));
        }
    }

    function edit_maximumlimit()
    {

        global $connect;
        $id = $_POST['id'];
        $limit = $_POST['limit'];

        $insert = mysqli_query($connect, "UPDATE limit_tb SET limit_no = $limit WHERE limit_id= $id");
        if (!$insert) {
            die(mysqli_error($connect));
        }
    }
    function delete_window()
    {

        global $connect;
        $id = $_POST['idno'];
        $delete = mysqli_query($connect, "delete from window where window_id=$id");
        if ($delete) {
            echo '<center><div class="alert alert-success" role="alert">
            The window has been successfully deleted!
          </div></center><br>';
        }
    }


    function add_window()
    {
        global $connect;
        $name = $_POST['name'];
        $desc = $_POST['desc'];
        $id = $_POST['id'];

        $insert = mysqli_query($connect, "INSERT INTO `window` (`window_name`, `window_desc`, `processor_id` ) VALUES ('$name', '$desc', $id)");
        if (!$insert) {
            die(mysqli_error($connect));
        }
    }

    function edit_window()
    {

        global $connect;
        $id = $_POST['id'];
        $name = $_POST['name'];
        $desc = $_POST['desc'];
        $processorId = $_POST['processorId'];
        $stat = $_POST['stat'];


        $insert = mysqli_query($connect, "UPDATE window SET window_name = '$name', window_desc= '$desc', processor_id=$processorId, w_status=$stat WHERE window_id= $id");

        if (!$insert) {
            die(mysqli_error($connect));
        }
    }

    function check_processor()
    {
        global $connect;

        $userid = $_POST['id'];

        $get_user = mysqli_query($connect, "SELECT * FROM window WHERE processor_id= $userid AND w_status=1");
        if (mysqli_num_rows($get_user) > 0) {
            $result = 1;
        } else {
            $result = 0;
        }
        echo  $result;
    }


    function check_servicewindow()
    {
        global $connect;

        $s_id = $_POST['s_id'];
        $w_id = $_POST['w_id'];


        $get_user = mysqli_query($connect, "SELECT * FROM transaction_windows WHERE service_id= $s_id AND window_id= $w_id");
        if (mysqli_num_rows($get_user) > 0) {
            $result = 1;
        } else {
            $result = 0;
        }
        echo  $result;
    }

    function add_servicewindow()
    {
        global $connect;

        $s_id = $_POST['s_id'];
        $w_id = $_POST['w_id'];


        $insert = mysqli_query($connect, "INSERT INTO `transaction_windows` (`service_id`, `window_id`) VALUES ($s_id,  $w_id)");
        if (!$insert) {
            echo die(mysqli_error($connect));
        }
    }
    function delete_servicewindow()
    {

        global $connect;
        $id = $_POST['idno'];
        $delete = mysqli_query($connect, "delete from transaction_windows where transwindow_id=$id");

        if (!$delete) {
            echo die(mysqli_error($connect));
        }
    }


    function edit_servicewindow()
    {
        global $connect;

        $s_id = $_POST['s_id'];
        $id = $_POST['id'];

        $query = mysqli_query($connect, "UPDATE transaction_windows SET service_id = $s_id WHERE transwindow_id=$id");
        if (!$query) {
            echo die(mysqli_error($connect));
        }
    }


    function update_queue_addtrans()
    {
        global $connect;

        $queue_id = $_POST['queue_id'];
        $processor_id = $_POST['p_id'];

        //  echo ($queue_id + " " +  $processor_id);

        $query = mysqli_query($connect, "UPDATE queue_list SET status=1 WHERE queue_id=$queue_id");
        if (!$query) {
            echo die(mysqli_error($connect));
        } else {
            $query1 = mysqli_query($connect, "INSERT INTO `queue_transaction` (`processor_id`, `queue_id`) VALUES ( $processor_id, $queue_id)");
            if (!$query1) {
                echo die(mysqli_error($connect));
            }
        }
    }


    function  update_finish_trans()
    {
        global $connect;

        $queue_id = $_POST['queue_id'];
        $trans_id = $_POST['trans_id'];
        $stat = $_POST['stat'];


        $query = mysqli_query($connect, "UPDATE queue_list SET status=$stat WHERE queue_id=$queue_id");
        if (!$query) {
            echo die(mysqli_error($connect));
        } else {
            $query1 = mysqli_query($connect, "UPDATE queue_transaction SET trans_status=$stat WHERE trans_id =$trans_id");
            if (!$query1) {
                echo die(mysqli_error($connect));
            }
        }
    }



}


$myClass = new MyClass();

if (isset($_GET['function'])) {

    $function = $_GET['function'];
    if ($function == 'save_queue') {
        echo $myClass->save_queue();
    } else if ($function == 'add_userclient') {
        echo $myClass->add_userclient();
    } else if ($function == 'check_service') {
        echo $myClass->check_service();
    } else if ($function == 'delete_queue') {
        echo $myClass->delete_queue();
    } else if ($function == 'update_queue') {
        echo $myClass->update_queue();
    } else if ($function == 'delete_account') {
        echo $myClass->delete_account();
    } else if ($function == 'add_useradmin') {
        echo $myClass->add_useradmin();
    } else if ($function == 'edit_user') {
        echo $myClass->edit_user();
    } else if ($function == 'fetch_desc') {
        echo $myClass->fetch_desc();
    } else if ($function == 'add_userprocessor') {
        echo $myClass->add_userprocessor();
    } else if ($function == 'delete_service') {
        echo $myClass->delete_service();
    } else if ($function == 'add_services') {
        echo $myClass->add_services();
    } else if ($function == 'edit_service') {
        echo $myClass->edit_service();
    } else if ($function == 'add_maximumlimit') {
        echo $myClass->add_maximumlimit();
    } else if ($function == 'edit_maximumlimit') {
        echo $myClass->edit_maximumlimit();
    } else if ($function == 'delete_window') {
        echo $myClass->delete_window();
    } else if ($function == 'add_window') {
        echo $myClass->add_window();
    } else if ($function == 'edit_window') {
        echo $myClass->edit_window();
    } else if ($function == 'check_processor') {
        echo $myClass->check_processor();
    } else if ($function == 'check_servicewindow') {
        echo $myClass->check_servicewindow();
    } else if ($function == 'add_servicewindow') {
        echo $myClass->add_servicewindow();
    } else if ($function == 'delete_servicewindow') {
        echo $myClass->delete_servicewindow();
    } else if ($function == 'edit_servicewindow') {
        echo $myClass->edit_servicewindow();
    } else if ($function == 'update_queue_addtrans') {
        echo $myClass->update_queue_addtrans();
    } else if ($function == 'update_finish_trans') {
        echo $myClass->update_finish_trans();
    }
}
