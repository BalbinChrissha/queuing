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

<?php

// $_SESSION['processor']['u_name']
$get_window = mysqli_query($connect, "SELECT * From window where processor_id=$processorID LIMIT 1");
if (mysqli_num_rows($get_window) > 0) {
    $processor = mysqli_fetch_assoc($get_window);
    $window_user = $processor['window_name'];
} ?>



<div style="width: 100%; background-color: #CDDEEF; position: sticky; top: 0; z-index: 1;" class="sticky-top p-0">

    <div style=" background-color: #CDDEEF; height: 40px; padding: 8px;" class="col-11 mx-auto">
        <div class="row">
            <div class="col-8">
                <i class="fa-solid fa-user"></i> Processor &nbsp; <b>|</b>&nbsp; <b>&nbsp;&nbsp;<?php
                                                                                                echo $_SESSION['processor']['u_name'];
                                                                                                ?></b>&nbsp;&nbsp;<b>|</b>&nbsp; <b>&nbsp;&nbsp;<?php
                                                                                                                                            echo   $window_user;
                                                                                                                                            ?></b>
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