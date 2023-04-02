<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/apple-icon.png"); ?>" />
    <link rel="icon" type="image/png" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/favicon.png"); ?>" />
    <title></title>
    <!-- Canonical SEO -->
    <link rel="canonical" href="//www.creative-tim.com/product/material-dashboard-pro" />

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
        <!--sider -->
        <?php  $this->load->view("admin/common/sidebar"); ?>
        
        <div class="main-panel">
            <!--head -->
            <?php  $this->load->view("admin/common/header"); ?>
            <!--content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Orders List");?></h4>
                                    <!--a class="text-right" href="<?php echo site_url("admin/add_products"); ?>">ADD</a-->
                                    <div  class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="example" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"><?php echo $this->lang->line("Order");?></th>
                                                    <th class="text-center">Customer</th>
                                                    <th class="text-center"><?php echo $this->lang->line("Socity");?></th>
                                                    <th class="text-center">Phone</th>
                                                    <th class="text-center"><?php echo $this->lang->line("Date");?></th>
                                                    <th class="text-center">Amount</th>
                                                    <th class="text-center">Payment</th>
                                                    <th class="text-center">Tracking Status</th>
                                                    <th class="text-center"><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center"><?php echo $this->lang->line("Order");?></th>
                                                    <th class="text-center">Customer</th>
                                                    <th class="text-center"><?php echo $this->lang->line("Socity");?></th>
                                                    <th class="text-center">Phone</th>
                                                    <th class="text-center"><?php echo $this->lang->line("Date");?></th>
                                                    <th class="text-center">Amount</th>
                                                    <th class="text-center">Payment</th>
                                                    <th class="text-center">Tracking Status</th>
                                                    <th class="text-center"><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach($today_orders as $order){ ?>
                                                <tr>
                                                    <td><?php echo $order->sale_id; ?></td>
                                                    <td>
                                                        <?php echo $order->fname.' '.$order->lname; ?><br>
                                                        <?php
                                                        if($order->admin_status == 'block'){
                                                            echo "<span class='label label-danger'>block</span>";
                                                        }
                                                        else if($order->admin_status == 'verified'){
                                                            echo "<span class='label label-success'>Verified</span>";
                                                        }
                                                        else if($order->admin_status == 'confused'){
                                                            echo "<span class='label label-warning'>Confused</span>";
                                                        }
                                                        else if($order->admin_status == 'new'){
                                                            echo "<span class='label label-info'>New</span>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $order->socity_name; ?></td>
                                                    <td><?php echo $order->phone; ?></td>
                                                    <td><?php echo date('d-m-Y H:i',strtotime($order->at)) ; ?></td>
                                                    <td><?php echo $order->total_amount; ?></td>
                                                    <td><?php echo $order->payment_method; ?></td>
                                                    <td>
                                                        <?php if ($order->tracking_status == 'pending'): ?>
                                                            <a href="javascript://" class="btn btn-default"><?php echo $order->tracking_status; ?></a>
                                                        <?php elseif ($order->tracking_status == 'in process'): ?>
                                                            <a href="javascript://" class="btn btn-warning"><?php echo $order->tracking_status; ?></a>
                                                        <?php elseif ($order->tracking_status == 'delivered to courier'): ?>
                                                            <a href="javascript://" class="btn btn-info"><?php echo $order->tracking_status; ?></a>
                                                        <?php elseif ($order->tracking_status == 'on way'): ?>
                                                            <a href="javascript://" class="btn btn-primary"><?php echo $order->tracking_status; ?></a>
                                                        <?php elseif ($order->tracking_status == 'delivered'): ?>
                                                            <a href="javascript://" class="btn btn-success"><?php echo $order->tracking_status; ?></a>
                                                        <?php elseif ($order->tracking_status == 'returned'): ?>
                                                            <a href="javascript://" class="btn btn-danger"><?php echo $order->tracking_status; ?></a>
                                                        <?php elseif ($order->tracking_status == 'cancelled'): ?>
                                                            <a href="javascript://" class="btn btn-danger"><?php echo $order->tracking_status; ?></a>
                                                        <?php endif ?>
                                                        <div class="dropdown">
                                                          <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown"> Action
                                                          <span class="caret"></span></button>
                                                          <ul class="dropdown-menu">
                                                            <!-- <li><a href="<?php echo site_url("admin/change_tracking_status/".$order->sale_id."/pending/"); ?>">Pending</a></li> -->
                                                            <?php if ($order->tracking_status == 'pending'): ?>
                                                                <li><a href="<?php echo site_url("admin/change_tracking_status/".$order->sale_id."/in_process/"); ?>">In Process</a></li>
                                                            <?php elseif ($order->tracking_status == 'in process'): ?>
                                                                <li><a href="<?php echo site_url("admin/change_tracking_status/".$order->sale_id."/delivered_to_courier/"); ?>">Delivered To Courier</a></li>
                                                            <?php elseif ($order->tracking_status == 'delivered to courier'): ?>
                                                                <li><a href="<?php echo site_url("admin/change_tracking_status/".$order->sale_id."/on_way/"); ?>">On Way</a></li>
                                                            <?php elseif ($order->tracking_status == 'on way'): ?>
                                                                <li><a href="<?php echo site_url("admin/change_tracking_status/".$order->sale_id."/delivered/"); ?>">Delivered</a></li>
                                                                <li><a href="<?php echo site_url("admin/change_tracking_status/".$order->sale_id."/returned/"); ?>">Returned</a></li>
                                                            <?php elseif ($order->tracking_status == 'cancelled'): ?>
                                                                <li><a href="<?php echo site_url("admin/change_tracking_status/".$order->sale_id."/in_process/"); ?>">In Process</a></li>
                                                            <?php endif ?>
                                                            <li><a href="<?php echo site_url("admin/change_tracking_status/".$order->sale_id."/cancelled/"); ?>">Cancelled</a></li>
                                                          </ul>
                                                        </div><!-- /dropdown -->
                                                    </td>
                                                    <td><?php if($order->status == 0){
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
                                                    </td>
                                                    <td><a href="<?php echo site_url("admin/orderdetails/".$order->sale_id); ?>" class="btn btn-success"> <?php echo $this->lang->line("Details");?></a>
                                                          <a href="javascript://" data-id="<?=$order->sale_id?>" class="btn btn-warning get-order-items">Items</a>
                                                        <div class="dropdown">
                                                          <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"> <?php echo $this->lang->line("Action");?><span class="caret"></span></button>
                                                          <ul class="dropdown-menu">
                                                            <li><a href="<?php echo site_url("admin/cancle_order/".$order->sale_id); ?>"> <?php echo $this->lang->line("Cancel");?></a></li>
                                                                <?php if($order->status == 0){
                                                                    echo "<li><a href='".site_url("admin/confirm_order/".$order->sale_id)."'>Confirm</a></li>";
                                                                }else if($order->status == 1){
                                                                    echo "<li><a href='".site_url("admin/delivered_order/".$order->sale_id)."'>Out</a></li>";
                                                                } 
                                                                else if($order->status == 2){
                                                                    echo "<li><a href='".site_url("admin/delivered_order_complete/".$order->sale_id)."'>Complete</a></li>";
                                                                } ?>
                                                            <li><a href="<?php echo site_url("admin/delete_order/".$order->sale_id); ?>"> <?php echo $this->lang->line("Delete");?></a></li>
                                                          </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php
                                          }
                                          ?>
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
                    <!-- end row -->
                </div>
            </div>
            <!--footer -->
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

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
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


    <script>
    $(function(){
        $(document).on('click', '.get-order-items', function(event) {
            event.preventDefault();
            $this = $(this);
            $("#modal-items-list .msg").html('');
            $("#modal-items-list table tbody").html('');
            $id = $(this).attr('data-id');
            $.post('<?=site_url("admin/get_order_items/")?>', {id: $id}, function(resp) {
                resp = JSON.parse(resp);
                $("#modal-items-list table tbody").html(resp.html);
                $("#modal-items-list").modal('show');
            });
        });

        $(document).on('change', '#modal-items-list select[name="change_item_status"]', function(event) {
            event.preventDefault();
            $this = $(this);
            $id = $this.attr('data-id');
            $status = $this.val();
            $("#modal-items-list .msg").html('');
            if ($status.length > 2) {
                $("#modal-items-list .msg").html('please wait...');
                $.post('<?=site_url("admin/change_order_item_status/")?>', {id: $id, status: $status}, function(resp) {
                    $("#modal-items-list .msg").html('');
                    resp = JSON.parse(resp);
                    if (resp.status == true) {
                        $this.parent('td').parent('tr').children('td.status').html($status);
                    }
                });
            }
        });

    });//onload
    </script>


</html>



<div class="modal fade" id="modal-items-list">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Order Items Change Status</h4>
                <h2 class="msg"></h2>
            </div><!-- /modal-header -->
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>QTY</th>
                        <th>Size/Color</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Product</td>
                            <td>Brand</td>
                            <td>1</td>
                            <td>M/red</td>
                            <td class="status">Status</td>
                            <td>
                                <select name="change_item_status" class="form-control">
                                    <option value="">Change Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="in process">In Process</option>
                                    <option value="delivered to courier">Delivered To Courier</option>
                                    <option value="On Way">On Way</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="returned">Returned</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div><!-- /modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div><!-- /modal-footer -->
        </div><!-- /modal-content -->
    </div><!-- /modal-dialog -->
</div><!-- #modal-items-list -->
