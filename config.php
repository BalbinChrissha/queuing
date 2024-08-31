<?php

session_start();
session_regenerate_id(true);

$connect = new mysqli("localhost", "root", "", "ws2_queuing") or die("Error Connection");


$errors   = array();
$cerrors = array();
$success   = array();



function display_error()
{
    global $errors;

    if (count($errors) > 0) {
        echo '<div class="alert alert-warning"><center>';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</center></div>';
    }
}


function display_success()
{
    global $success;

    if (count($success) > 0) {
        echo '<div class="alert alert-primary"><center>';
        foreach ($success as $succ) {
            echo $succ . '<br>';
        }
        echo '</center></div>';
    }
}

function error_captcha()
{
    global $cerrors;

    if (count($cerrors) > 0) {
        echo '<div class="alert alert-warning"><center>';
        foreach ($cerrors as $error) {
            echo $error . '<br>';
        }
        echo '</center></div>';
    }
}


function a($val)
{
    global $connect;
    return mysqli_real_escape_string($connect, trim($val));
}



if (isset($_POST['submit'])) {
    login();
}


function login()
{

    global $connect, $errors, $cerrors;

    $email = ($_POST['email2']);
    $password = ($_POST['password2']);


    if (count($errors) == 0 && count($cerrors) == 0) {

        $query = "SELECT * FROM users WHERE username='$email' AND password='$password' LIMIT 1";
        $results = mysqli_query($connect, $query);
        if (mysqli_num_rows($results) == 1) {
            $logged_in_user = mysqli_fetch_assoc($results);
            if ($logged_in_user['type'] == 1) {
                $_SESSION['admin'] = $logged_in_user;
                header('location: admin/adminpage.php');
            } else if ($logged_in_user['type'] == 2) {
                $_SESSION['processor'] = $logged_in_user;
                header('location: processor/processorpage.php');
            }

            if ($logged_in_user['type'] == 3) {
                $_SESSION['client'] = $logged_in_user;
                header('location: clienthome.php');
            }
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}
