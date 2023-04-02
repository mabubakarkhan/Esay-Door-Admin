<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url($this->config->item("theme_admin")."/assets/img/apple-icon.png"); ?>" />
    <link rel="icon" type="image/png" href="<?php echo base_url($this->config->item("theme_admin")."/assets/img/favicon.png"); ?>" />
    <title></title>
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />
    <!--  Social tags      -->
    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url($this->config->item("theme_admin")."/assets/css/bootstrap.min.css"); ?>" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?php echo base_url($this->config->item("theme_admin")."/assets/css/material-dashboard.css"); ?>" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo base_url($this->config->item("theme_admin")."/assets/css/demo.css"); ?>" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="<?php echo base_url($this->config->item("theme_admin")."/assets/css/font-awesome.css"); ?>" rel="stylesheet" />
    <link href="<?php echo base_url($this->config->item("theme_admin")."/assets/css/font-awesome.min.css"); ?>" rel="stylesheet" />

  <link href="<?php echo base_url($this->config->item("theme_admin")."/assets/css/google-roboto-300-700.css"); ?>" rel="stylesheet" />
    
    
    
    
    
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
													<th><?php echo $this->lang->line('Order ID')?></th>
													<th><?php echo $this->lang->line('Customer Name')?></th>
													<th><?php echo $this->lang->line('Socity')?></th>
													<th><?php echo $this->lang->line('Customer Phone')?></th>
													<th><?php echo $this->lang->line('Date')?></th>
													<th><?php echo $this->lang->line('Time')?></th>
													<th><?php echo $this->lang->line('Order Amount')?></th>
													<th><?php echo $this->lang->line('Status')?></th>
													<th><?php echo $this->lang->line('Action')?></th>
												</tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
													<th><?php echo $this->lang->line('Order ID')?></th>
													<th><?php echo $this->lang->line('Customer Name')?></th>
													<th><?php echo $this->lang->line('Socity')?></th>
													<th><?php echo $this->lang->line('Customer Phone')?></th>
													<th><?php echo $this->lang->line('Date')?></th>
													<th><?php echo $this->lang->line('Time')?></th>
													<th><?php echo $this->lang->line('Order Amount')?></th>
													<th><?php echo $this->lang->line('Status')?></th>
													<th><?php echo $this->lang->line('Action')?></th>
												</tr>
                                            </tfoot>
                                            <tbody>
												  <?php
													  foreach($today_orders as $order)
													  {
														?>
														
															<tr>
																<td><?php echo $order->sale_id; ?></td>
																<td><?php echo $order->user_fullname; ?></td>
																<td><?php echo $order->socity_name; ?></td>
																<td><?php echo $order->user_phone; ?></td>
																<td><?php echo $order->on_date; ?></td>
																<td><?php echo date("H:i A", strtotime($order->delivery_time_from))." - ".date("H:i A", strtotime($order->delivery_time_to)); ?></td>
																<td><?php echo $order->total_amount; ?></td>
																<td><?php if($order->status == 0){
																	echo "<span class='label label-default'>Pending</span>";
																}else if($order->status == 1){
																	echo "<span class='label label-success'>Confirm</span>";
																}else if($order->status == 2){
																	echo "<span class='label label-info'>Delivered</span>";
																}else if($order->status == 3){
																	echo "<span class='label label-danger'>cancel</span>";
																}  ?></td>
																<td><a href="<?php echo site_url("admin/orderdetails/".$order->sale_id); ?>" class="btn btn-sm btn-default">Details</a></td>
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
													<th><?php echo $this->lang->line('Order ID')?></th>
													<th><?php echo $this->lang->line('Customer Name')?></th>
													<th><?php echo $this->lang->line('Socity')?></th>
													<th><?php echo $this->lang->line('Customer Phone')?></th>
													<th><?php echo $this->lang->line('Date')?></th>
													<th><?php echo $this->lang->line('Time')?></th>
													<th><?php echo $this->lang->line('Order Amount')?></th>
													<th><?php echo $this->lang->line('Status')?></th>
													<th><?php echo $this->lang->line('Action')?></th>
												</tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <tr>
														<th><?php echo $this->lang->line('Order ID')?></th>
														<th><?php echo $this->lang->line('Customer Name')?></th>
														<th><?php echo $this->lang->line('Socity')?></th>
														<th><?php echo $this->lang->line('Customer Phone')?></th>
														<th><?php echo $this->lang->line('Date')?></th>
														<th><?php echo $this->lang->line('Time')?></th>
														<th><?php echo $this->lang->line('Order Amount')?></th>
														<th><?php echo $this->lang->line('Status')?></th>
														<th><?php echo $this->lang->line('Action')?></th>
													</tr>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                 <?php
													  foreach($nextday_orders as $order)
													  {
														?>
															<tr>
																<td><?php echo $order->sale_id; ?></td>
																<td><?php echo $order->user_fullname; ?></td>
																<td><?php echo $order->socity_name; ?></td>
																<td><?php echo $order->user_phone; ?></td>
																<td><?php echo $order->on_date; ?></td>
																<td><?php echo date("H:i A", strtotime($order->delivery_time_from))." - ".date("H:i A", strtotime($order->delivery_time_to)); ?></td>
																<td><?php echo $order->total_amount; ?></td>
																<td><?php if($order->status == 0){
																	echo "<span class='label label-default'>Pending</span>";
																}else if($order->status == 1){
																	echo "<span class='label label-success'>Confirm</span>";
																}else if($order->status == 2){
																	echo "<span class='label label-info'>Delivered</span>";
																}else if($order->status == 3){
																	echo "<span class='label label-danger'>cancel</span>";
																}  ?></td>
																<td><a href="<?php echo site_url("admin/orderdetails/".$order->sale_id); ?>" class="btn btn-sm btn-default"><?php echo $this->lang->line('Details')?></a></td>
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
                </div>
            </div>
            <!-- Foot -->
            <?php  $this->load->view("admin/common/common_footer") ?>
        </div>
    </div>
    <!-- content -->
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>
<!--   Core JS Files   -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery-3.1.1.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery-ui.min.js" ); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/bootstrap.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/material.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/perfect-scrollbar.jquery.min.js"); ?>" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery.validate.min.js"); ?>"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/moment.min.js"); ?>"></script>
<!--  Charts Plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/chartist.min.js"); ?>"></script>
<!--  Plugin for the Wizard -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery.bootstrap-wizard.js"); ?>"></script>
<!--  Notifications Plugin    -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/bootstrap-notify.js"); ?>"></script>
<!--   Sharrre Library    -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery.sharrre.js"); ?>"></script>
<!-- DateTimePicker Plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/bootstrap-datetimepicker.js"); ?>"></script>
<!-- Vector Map plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery-jvectormap.js"); ?>"></script>
<!-- Sliders Plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/nouislider.min.js"); ?>"></script>
<!--  Google Maps Plugin    -->
<!--<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery.select-bootstrap.js"); ?>"></script>-->
<!-- Select Plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery.select-bootstrap.js"); ?>"></script>
<!--  DataTables.net Plugin    -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery.datatables.js"); ?>"></script>
<!-- Sweet Alert 2 plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/sweetalert2.js"); ?>"></script>
<!--    Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jasny-bootstrap.min.js"); ?>"></script>
<!--  Full Calendar Plugin    -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/fullcalendar.min.js"); ?>"></script>
<!-- TagsInput Plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery.tagsinput.js"); ?>"></script>
<!-- Material Dashboard javascript methods -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/material-dashboard.js"); ?>"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/demo.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {

        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

        demo.initVectorMap();
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
                ]
            } );
        } );
    </script>
</html>