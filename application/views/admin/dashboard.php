<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/apple-icon.png"); ?>" />
    <link rel="icon" type="image/png" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/favicon.png"); ?>" />
    <title></title>
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />
    <!--  Social tags      -->
    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/bootstrap.min.css"); ?>" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/material-dashboard.css"); ?>" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/demo.css"); ?>" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/font-awesome.css"); ?>" rel="stylesheet" />
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/google-roboto-300-700.css"); ?>" rel="stylesheet" />
    
    
    
    
    
</head>

<body>
    <div class="wrapper">
        <!-- side -->
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel" <?php if($this->session->userdata('language') == "arabic"){ echo 'style="float:left"'; } ?>>
            <!-- head-->
            <?php  $this->load->view("admin/common/header"); ?>
            <!-- content -->
            <div class="content">
                <div class="container-fluid">
                    <?php if(isset($message) && $message!=""){
                            echo $message;
                        } ?>
                    <div class="row" style="margin-top: 50px;">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="orange">
                                    <i class="material-icons">weekend</i>
                                </div>
                                <div class="card-content">
                                    <p class="category"><?php echo $this->lang->line("Daily Orders");?></p>
                                    <?php 
                                        $date=date("Y-m-d");
                                        $a = $this->db->query("SELECT * FROM sale WHERE status = 0 AND at >= CURDATE()"); 
                                        
                                    ?>
                                    <h3 class="card-title"><?php echo $a->num_rows(); ?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <?php 
                                        $b = $this->db->query("SELECT * FROM sale WHERE status = 4"); ?>
                                        <i class="material-icons">weekend</i><?php echo $this->lang->line("Total Order Till Date");?><span style="margin-right:0px !important">&emsp;&emsp;&emsp;&emsp;<?php echo $b->num_rows(); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="rose">
                                    <i class="material-icons">group</i>
                                </div>
                                <div class="card-content">
                                    <p class="category"><?php echo $this->lang->line("Active Users");?></p>
                                    <?php 
                                        $c = $this->db->query("SELECT * FROM customer WHERE status = 'active' "); ?>
                                    <h3 class="card-title"><?php echo $c->num_rows(); ?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">group</i> <?php echo $this->lang->line("Tracked from Database Analytics");?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="green">
                                    <i class="material-icons">money</i>
                                </div>
                                <div class="card-content">
                                    <p class="category"><?php echo $this->lang->line("Today Revenue");?></p>
                                    <?php 
                                        $d = $this->db->query("SELECT SUM(total_amount) as total FROM sale WHERE status = 4 AND at >= CURDATE()");
                                        $row=$d->row_array();?>
                                    <h3 class="card-title"><?php if(empty($row['total'])){ echo 0;} else{echo $row['total'];} ?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <?php 
                                        $e = $this->db->query("SELECT SUM(total_amount) as total FROM sale WHERE status=4"); 
                                        $row= $e->row_array();?>
                                        <i class="material-icons">money</i><?php echo $this->lang->line("Total Revenue Till Date");?><span style="margin-right:0px !important">&emsp;&emsp;<?php echo $row['total'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="blue">
                                    <i class="material-icons">star</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">Today Reviews</p>
                                    <?php 
                                        $f = $this->db->query("SELECT COUNT(review_id) as total FROM review WHERE status = 'new' AND at >= CURDATE()");
                                        $row=$f->row_array();?>
                                    <h3 class="card-title"><?php if(empty($row['total'])){ echo 0;} else{echo $row['total'];} ?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <?php 
                                        $g = $this->db->query("SELECT SUM(review_id) as total FROM review WHERE status = 'active' "); 
                                        $row= $g->row_array();?>
                                        <i class="material-icons">star</i>Total Reviews Till Date<span style="margin-right:0px !important">&emsp;&emsp;&emsp;<?php echo $row['total'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Today Order");?>:</h4>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="example" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"><?php echo $this->lang->line("Order");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Name");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Socity");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Phone");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Date");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Order Amount");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center"><?php echo $this->lang->line("Order");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Name");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Socity");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Customer Phone");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Date");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Order Amount");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach($today_orders as $order ){ ?>
                                                <tr>
                                                    <th class="text-center"><?php echo $order->sale_id; ?></th>
                                                    <th class="text-center"><?php echo $order->fname.' '.$order->lname; ?></th>
                                                    <th class="text-center"><?php echo $order->socity_name; ?></th>
                                                    <th class="text-center"><?php echo $order->phone; ?></th>
                                                    <th class="text-center"><?php echo $order->at; ?></th>
                                                    <th class="text-center"><?php echo $order->total_amount; ?></th>
                                                    <th class="text-center">
                                                        <?php if($order->status == 0){
                                                            echo "<span class='label label-default'>Pending</span>";
                                                        }else if($order->status == 1){
                                                            echo "<span class='label label-success'>Confirm</span>";
                                                        }else if($order->status == 2){
                                                            echo "<span class='label label-info'>Out</span>";
                                                        }else if($order->status == 3){
                                                            echo "<span class='label label-danger'>Cancel</span>";
                                                        }else if($order->status == 4){
                                                            echo "<span class='label label-info'>complete</span>";
                                                        } ?>
                                                    </th>

                                                    <td class="td-actions text-center"><div class="btn-group">
                                                            <?php echo anchor('admin/orderdetails/'.$order->sale_id, '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                            <i class="material-icons">assignment</i>
                                                        </button>', array("class"=>"")); ?>
                                                            
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>


                    <?php if (1==2): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="purple">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title"><?php echo $this->lang->line("Next Day Orders :");?></h4>
                                        <div class="toolbar">
                                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                                        </div>
                                        <div class="material-datatables">
                                            <table id="example" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center"><?php echo $this->lang->line("Order");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Customer Name");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Socity");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Customer Phone");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Date");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Time");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Order Amount");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Status");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Action");?></th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-center"><?php echo $this->lang->line("Order");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Customer Name");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Socity");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Customer Phone");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Date");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Time");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Order Amount");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Status");?></th>
                                                        <th class="text-center"><?php echo $this->lang->line("Action");?></th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php foreach($nextday_orders as $order){ ?>
                                                    <tr>
                                                        <th class="text-center"><?php echo $order->sale_id; ?></th>
                                                        <th class="text-center"><?php echo $order->user_fullname; ?></th>
                                                        <th class="text-center"><?php echo $order->socity_name; ?></th>
                                                        <th class="text-center"><?php echo $order->user_phone; ?></th>
                                                        <th class="text-center"><?php echo $order->on_date; ?></th>
                                                        <th class="text-center"><?php echo date("H:i A", strtotime($order->delivery_time_from))." - ".date("H:i A", strtotime($order->delivery_time_to)); ?></th>
                                                        <th class="text-center"><?php echo $order->total_amount; ?></th>
                                                        <th class="text-center">
                                                            <?php if($order->status == 0){
                                                                echo "<span class='label label-default'>Pending</span>";
                                                            }else if($order->status == 1){
                                                                echo "<span class='label label-success'>Confirm</span>";
                                                            }else if($order->status == 2){
                                                                echo "<span class='label label-info'>Delivered</span>";
                                                            }else if($order->status == 3){
                                                                echo "<span class='label label-danger'>cancel</span>";
                                                            }  ?>
                                                        </th>

                                                        <td class="td-actions text-center"><div class="btn-group">
                                                                <?php echo anchor('admin/orderdetails/'.$order->sale_id, '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                                <i class="material-icons">assignment</i>
                                                            </button>', array("class"=>"")); ?>
                                                                
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- end content-->
                                </div>
                                <!--  end card  -->
                            </div>
                            <!-- end col-md-12 -->
                        </div>
                    <?php endif ?>


                </div>
            </div>
            <!-- Foot -->
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
    <!--fixed -->
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>
<!--   Core JS Files   -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery-3.1.1.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery-ui.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/bootstrap.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/material.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/perfect-scrollbar.jquery.min.js"); ?>" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery.validate.min.js"); ?>"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/moment.min.js"); ?>"></script>
<!--  Charts Plugin -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/chartist.min.js"); ?>"></script>
<!--  Plugin for the Wizard -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery.bootstrap-wizard.js"); ?>"></script>
<!--  Notifications Plugin    -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/bootstrap-notify.js"); ?>"></script>
<!--   Sharrre Library    -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery.sharrre.js"); ?>"></script>
<!-- DateTimePicker Plugin -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/bootstrap-datetimepicker.js"); ?>"></script>
<!-- Vector Map plugin -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery-jvectormap.js"); ?>"></script>
<!-- Sliders Plugin -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/nouislider.min.js"); ?>"></script>
<!--  Google Maps Plugin    -->
<!--<script src="https://maps.googleapis.com/maps/api/js"></script>-->
<!-- Select Plugin -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery.select-bootstrap.js"); ?>"></script>
<!--  DataTables.net Plugin    -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery.datatables.js"); ?>"></script>
<!-- Sweet Alert 2 plugin -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/sweetalert2.js"); ?>"></script>
<!--    Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jasny-bootstrap.min.js"); ?>"></script>
<!--  Full Calendar Plugin    -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/fullcalendar.min.js"); ?>"></script>
<!-- TagsInput Plugin -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery.tagsinput.js"); ?>"></script>
<!-- Material Dashboard javascript methods -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/material-dashboard.js"); ?>"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/demo.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });


        var table = $('#datatables').DataTable();

        // Edit record
        table.on('click', '.edit', function() {
            $tr = $(this).closest('tr');

            var data = table.row($tr).data();
            alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        });

        // Delete a record
        table.on('click', '.remove', function(e) {
            $tr = $(this).closest('tr');
            table.row($tr).remove().draw();
            e.preventDefault();
        });

        //Like record
        table.on('click', '.like', function() {
            alert('You clicked on Like button');
        });

        $('.card .material-datatables label').addClass('form-group');
    });
</script>
<script>
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                order: [[0, 'desc']]
            } );
        } );
    </script>

</html>