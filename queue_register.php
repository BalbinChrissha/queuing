<?php
require 'config.php';

include('inc/header.php');

?>
<title>Queue Registration</title>
</head>

<body>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <form action="" id="new_queue">
                        <div class="form-group">
                            <label for="name" class="control-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="transaction_id" class="control-label">Service: </label>
                            <?php if ($connect) {
                                $result =  $connect->query("SELECT * FROM service order by service_name asc ") or die("Error Query");
                                if ($result) {
                                    if ($result->num_rows >= 1) {
                                        echo "<select name='service_id' id='service_id' class='custom-select browser-default select2' required>";
                                        while ($rows = $result->fetch_array()) {
                                            echo "<option value='$rows[0]'>$rows[1]</option>";
                                        }
                                    }
                                }
                            }

                            echo "</select>";

                            ?>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-sm btn-primary col-md-3 float-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $('#new_queue').submit(function(e) {
            alert ($(this).serialize());
            e.preventDefault();
            // start_load()
            // console.log($(this).serialize())

            $.ajax({
                url: 'ajax/function_class.php?function=save_queue',
                method: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    // if (resp > 0) {
                    //     alert(resp);
                    // }
                   // alert(html);

                   if(res > 0){
						
						var nw = window.open("queue_print.php?id="+res,"_blank","height=500,width=800")
						nw.print()
						setTimeout(function(){
							nw.close()
						},1000)
						end_load()
					alert_toast("Queue Registed Successfully",'success');
					}
                }
            })

        })
    </script>
</body>

</html>