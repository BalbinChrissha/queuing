<script>
    function updateTime() {
        var options = {
            timeZone: 'Asia/Manila',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric'
        };

        var formatter = new Intl.DateTimeFormat('en-PH', options);
        var currentTime = formatter.format(new Date());

        document.getElementById("current-time").innerHTML = currentTime;
    }

    setInterval(updateTime, 1000);
</script>


<div style="width: 100%; background-color: #89BBEA; position: sticky; top: 0; z-index: 1;" class="sticky-top p-0">

    <nav class="navbar navbar-light bg-light navbar-expand-md">
        <div class="container-fluid"><a class="navbar-brand" href="clienthome.php">&nbsp;&nbsp;<img src="images/citylogo.png" width="85" height="45" alt=""></a><button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div id="navcol-1" class="collapse navbar-collapse text-center">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="clienthome.php">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="client_view_windowServing.php">WINDOWS NOW SERVING</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">REGISTER QUEUE</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">LOGOUT</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div style=" background-color: #89BBEA; height: 40px; padding: 8px;" class="col-11 mx-auto">
        <div class="row">

            <div class="col-8">
                <i class="fa-solid fa-user"></i> Client &nbsp; <b>|</b>&nbsp; <b>&nbsp;&nbsp;<?php echo $_SESSION['client']['u_name']; ?></b>
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="col-2">
                    </div>
                    <div class="col-6" align="right">
                        <?php
                        $desc = '';
                        date_default_timezone_set('Asia/Manila');
                        echo date('D jS F Y'); ?>
                    </div>
                    <div class="col-4" align="left">
                    <div id="current-time"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<!-- modal -->

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" style="color: black;" id="staticBackdropLabel">Register Service Requested</h5><br>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="color: black;">
                <center>Secure your slot now and register for LGU services.</center>


                <center>For this Day : <span style="color: #679ED7;"><?php echo date('D jS F Y'); ?></span></center>
                <br>
                <div class="col-11 mx-auto">



                    <?php

                    $get_count = mysqli_query($connect, "SELECT * FROM limit_tb WHERE limit_date = '$current_date'");

                    if (mysqli_num_rows($get_count) > 0) {
                        $row = mysqli_fetch_assoc($get_count);
                        $limit_no = $row['limit_no'];
                        $limit_id = $row['limit_id'];
                    } else {
                        $limit_no = -1;
                    }




                    $query = mysqli_query($connect, "SELECT COUNT(*) as count FROM queue_list WHERE date_created = '$current_date'");

                    if (mysqli_num_rows($query) > 0) {
                        $data = mysqli_fetch_assoc($query);
                        $count_request = $data['count'];
                    } else {
                        $count_request = 0;
                    }




                    if ($limit_no <= 0 || ($count_request < $limit_no) || $limit_no == -1) {


                    ?>


                        <form action="" id="new_queue">




                            <div class="col mb-2">
                                <label class="control-label">Service: </label><span class="asterisk"> * </span> <span style="color:red;  font-size: 13px;" id="errorService"></span>
                                <?php if ($connect) {
                                    $result =  $connect->query("SELECT * FROM service order by service_name asc ") or die("Error Query");
                                    if ($result) {
                                        if ($result->num_rows >= 1) {
                                            echo "<select name='service_id' id='service_id' class='form-select mb-3' required onchange='onServiceSelect(this.value)'>";
                                            while ($rows = $result->fetch_array()) {
                                                echo "<option value='$rows[0]'>$rows[1]</option>";
                                            }
                                        }
                                    }
                                }

                                echo "</select>";

                                ?>
                            </div>

                            <div class="col mb-2">

                                <label class="control-label">Description: </label><br>
                                <div id="service_desc">
                                    <?php if ($connect) {
                                        $result =  $connect->query("SELECT * FROM service order by service_name asc LIMIT 1") or die("Error Query");
                                        if ($result) {
                                            if ($result->num_rows >= 1) {

                                                while ($rows = $result->fetch_array()) {
                                                    echo $rows[2];
                                                }
                                            }
                                        }
                                    }

                                    ?></div>
                            </div>

                            <br>
                            <div class="col-12">
                                <button type="button" style="width: 100%;" onclick="validateForm();" name="submitform" class="btn btn-primary"> Register </button>
                            </div>
                        </form>




                    <?php
                    } else {
                        echo "<br><center>
                      <span style='color: #be2f2f'>You cannot request a service at the moment because either the system is fully booked or it has reached the maximum limit of requests for today.</center><br></span>";
                    }

                    ?>





                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var userid = "<?php echo $userid; ?>";
    var date = "<?php echo $current_date; ?>";

    function validateForm() {


        var serviceId = document.getElementById("service_id").value;

        $.ajax({
            url: "ajax/function_class.php?function=check_service",
            type: "POST",
            data: {
                currentdate: date,
                id: userid,
                serviceId: serviceId
            },
            success: function(result) {
                if (result == 1) {
                    $('#service_id').css("border", "1px solid red");
                    $('#errorService').html("You already have a booking for this service today. (Duplication is prohibited)");
                } else {
                    $('#service_id').css("border", "1px solid grey");
                    $('#errorService').html("");
                    submitqueue();


                }
            },
            error: function() {
                alert("Error occurred");
            }
        });

    }


    function submitqueue() {

        var serviceId = document.getElementById("service_id").value;
        $.ajax({
            url: 'ajax/function_class.php?function=save_queue',
            method: 'POST',
            data: {
                userid: userid,
                serviceId: serviceId
            },
            success: function(res) {
                if (res > 0) {

                    var nw = window.open("queue_print.php?id=" + res, "_blank", "height=500,width=800");
                    nw.print();
                    setTimeout(function() {
                        nw.close();
                    }, 200);
                    location.reload();


                }
            }
        })





    }
</script>


<script>
    $(document).ready(function() {
        $('#service_id').change(function() {
            var selectedValue = $(this).val();


            if (selectedValue) {
                // Perform AJAX action here
                $.ajax({
                    url: 'ajax/function_class.php?function=fetch_desc',
                    method: 'POST',
                    data: {
                        id: selectedValue
                    },
                    success: function(response) {
                        $('#service_desc').html(response);

                    },
                    error: function(xhr, status, error) {

                    }
                });
            }
        });
    });
</script>