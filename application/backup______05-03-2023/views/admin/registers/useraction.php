<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/apple-icon.png"); ?>" />
    <link rel="icon" type="image/png" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/favicon.png"); ?>" />
    <title></title>
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />
    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/bootstrap.min.css"); ?>" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/material-dashboard.css"); ?>" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/demo.css"); ?>" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/font-awesome.css"); ?>" rel="stylesheet" />
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/google-roboto-300-700.css"); ?>" rel="stylesheet" />
    <style>
        .height{
            margin-bottom:15px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel">
            <?php  $this->load->view("admin/common/header"); ?>
            <?php echo $this->session->flashdata("message"); ?>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                
                                <div class="card-header card-header-tabs" data-background-color="rose">
                                    <div class="nav-tabs-navigation">
                                        <div class="nav-tabs-wrapper">
                                            <!--span class="nav-tabs-title">Tasks:</span-->
                                            <ul class="nav nav-tabs" data-tabs="tabs">
                                                <li class="col-lg-4 col-md-4 profile" style="text-align:center">
                                                    <a href="#profile">
                                                        <i class="material-icons">group</i><?php echo $this->lang->line("Profile");?> 
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </li>
                                                <li class="col-lg-4 col-md-4 message"  style="text-align:center">
                                                    <a href="#messages" >
                                                        <i class="material-icons">stars</i> <?php echo $this->lang->line("Wallet & Rewards");?>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </li>
                                                <li class="col-lg-4 col-md-4 setting" style="text-align:center">
                                                    <a href="#settings">
                                                        <i class="material-icons">cloud</i> <?php echo $this->lang->line("Past Orders");?>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content" >
                                    <div class="tab-content">


                                        <div class="tab-pane profile1">
                                            <div class="col-md-12">
                                                <div class="social text-center">
                                                    <h4> <?php echo $this->lang->line("Profile Detail");?> </h4>
                                                </div>
                                                <form class="form" method="post" action="">
                                                    <?php foreach($user as $user) {?>
                                                    <div class="card-content">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">face</i><span class="height">First Naem</span>
                                                            </span>
                                                            <div class="form-group is-empty"><input name="fname" type="text" style="margin-top: 25px;" class="form-control" placeholder="First Name" value="<?= $user->fname; ?>"><span class="material-input"></span></div>
                                                        </div>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">face</i><span class="height">Last Name</span>
                                                            </span>
                                                            <div class="form-group is-empty"><input name="lname" type="text" style="margin-top: 25px;" class="form-control" placeholder="Last Name" value="<?= $user->lname; ?>"><span class="material-input"></span></div>
                                                        </div>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">email</i> <?php echo $this->lang->line("Email");?>
                                                            </span>
                                                            <div class="form-group is-empty"><input name="email" type="text" style="margin-top: 25px;" class="form-control" placeholder="Email..." value="<?= $user->email; ?>"><span class="material-input"></span></div>
                                                        </div>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">smartphone</i><?php echo $this->lang->line("Phone");?>
                                                            </span>
                                                            <div class="form-group is-empty"><input name="phone" type="number" style="margin-top: 25px;" placeholder="Phone Number" class="form-control"  value="<?= $user->phone; ?>"><span class="material-input"></span></div>
                                                        </div>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">lock_outline</i><?php echo $this->lang->line("Password");?>  &nbsp;
                                                            </span>
                                                            <div class="form-group is-empty"><input name="password" type="password" style="margin-top: 25px;" placeholder="Password..." class="form-control"  value="<?= $user->password; ?>"><span class="material-input"></span></div>
                                                        </div>
                                                        
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">navigation</i><?php echo $this->lang->line("Area");?>  &nbsp;
                                                            </span>
                                                            <div class="form-group is-empty">
                                                                <select class="form-control" name="socity_id" style="margin-top: 25px;">
                                                                    <?php   
                                                                            $qry=$this->db->query("SELECT * FROM `socity`");
                                                                            foreach($qry->result() as $society){
                                                                    ?>
                                                                    <option value="<?= $society->socity_id ?>" <?php if($society->socity_id==$user->socity_id){ echo "selected"; } ?>><?= $society->socity_name ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">home</i><?php echo $this->lang->line("Home");?> 
                                                            </span>
                                                            <div class="form-group is-empty"><input name="house_no" type="text" style="margin-top: 25px;" class="form-control" placeholder="House Number"  value="<?= $user->house_no; ?>"><span class="material-input"></span></div>
                                                        </div>
                                                        
                                                        <!-- If you want to add a checkbox to this form, uncomment this code -->
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">home</i>Status
                                                            </span>
                                                            <div class="form-group is-empty">
                                                                <select name="status" class="form-control" required="required">
                                                                    <option value="active" <?=($user->status == 'active') ? 'selected="selected"' : ''?> >Active</option>
                                                                    <option value="inactive" <?=($user->status == 'inactive') ? 'selected="selected"' : ''?> >Inactive</option>
                                                                    <option value="block" <?=($user->status == 'block') ? 'selected="selected"' : ''?> >Block</option>
                                                                    <option value="mobile pending" <?=($user->status == 'mobile pending') ? 'selected="selected"' : ''?> >Mobile Pending</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons">home</i>Admin Status
                                                            </span>
                                                            <div class="form-group is-empty">
                                                                <select name="admin_status" class="form-control" required="required">
                                                                    <option value="new" <?=($user->admin_status == 'new') ? 'selected="selected"' : ''?> >New</option>
                                                                    <option value="verified" <?=($user->admin_status == 'verified') ? 'selected="selected"' : ''?> >Verifiede</option>
                                                                    <option value="confused" <?=($user->admin_status == 'confused') ? 'selected="selected"' : ''?> >Confused</option>
                                                                    <option value="block" <?=($user->admin_status == 'block') ? 'selected="selected"' : ''?> >Block</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="footer text-center">
                                                        <input type="submit" name="profile" class="btn btn-primary btn-round" value="<?= $this->lang->line('Update Detail'); ?>">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="tab-pane col-md-12 message1">
                                          <form class="form" method="post" action="">
                                            <div class="input-group col-md-6">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">money</i> &nbsp;<span class="height"><?php echo $this->lang->line("Wallet");?></span>
                                                </span>
                                                <div class="form-group is-empty"><input name="wallet" type="text" style="margin-top: 25px;" class="form-control" placeholder="Full Name..." value="<?= $user->wallet; ?>"><span class="material-input"></span></div>
                                            </div>
                                            <div class="input-group col-md-6">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">stars</i> <span class="height"><?php echo $this->lang->line("Rewards");?></span>
                                                </span>
                                                <div class="form-group is-empty"><input name="rewards" type="text" style="margin-top: 25px;" class="form-control" placeholder="Email..." value="<?= $user->rewards; ?>"><span class="material-input"></span></div>
                                            </div>
                                            <div class="footer text-center">
                                                <input type="submit" name="amount" class="btn btn-primary btn-round" value="Update Detail">
                                            </div>
                                          </form>
                                        </div>
                                        <div class="tab-pane setting1">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header card-header-icon" data-background-color="purple">
                                                        <i class="material-icons">assignment</i>
                                                    </div>
                                                    <div class="card-content">
                                                        <h4 class="card-title"><?php echo $this->lang->line("Order Detail");?> </h4>
                                                        <div class="toolbar">
                                                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                                                        </div>
                                                        <div class="material-datatables">
                                                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
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
                                                                    <?php foreach($order as $order ){ ?>
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
                                                                                echo "<span class='label label-info'>Delivered</span>";
                                                                            }else if($order->status == 3){
                                                                                echo "<span class='label label-danger'>cancel</span>";
                                                                            }else if($order->status == 4){
                                                                                echo "<span class='label label-success'>Complete</span>";
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
 </div>
                                </div>

                                        <div class="card-content" style="display:block;">
                                    <div class="tab-content">
                                        <div class="tab-pane col-md-12">
                                          <form class="form" method="post" action="">
                                            <div class="input-group col-md-6">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">money</i> &nbsp;<span class="height"><?php echo $this->lang->line("Wallet");?></span>
                                                </span>
                                                <div class="form-group is-empty"><input name="wallet" type="text" style="margin-top: 25px;" class="form-control" placeholder="Full Name..." value="<?= $user->wallet; ?>"><span class="material-input"></span></div>
                                            </div>
                                            <div class="input-group col-md-6">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">stars</i> <span class="height"><?php echo $this->lang->line("Rewards");?></span>
                                                </span>
                                                <div class="form-group is-empty"><input name="rewards" type="text" style="margin-top: 25px;" class="form-control" placeholder="Email..." value="<?= $user->rewards; ?>"><span class="material-input"></span></div>
                                            </div>
                                            <div class="footer text-center">
                                                <input type="submit" name="amount" class="btn btn-primary btn-round" value="Update Detail">
                                            </div>
                                          </form>
                                        </div>
                                         </div>
                                </div>
                                        <div class="card-content">
                                    <div class="tab-content">
                                        <div class="tab-pane" id="settings">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header card-header-icon" data-background-color="purple">
                                                        <i class="material-icons">assignment</i>
                                                    </div>
                                                    <div class="card-content">
                                                        <h4 class="card-title"><?php echo $this->lang->line("Order Detail");?> </h4>
                                                        <div class="toolbar">
                                                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                                                        </div>
                                                        <div class="material-datatables">
                                                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
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
                                                                    <?php foreach($order as $order ){ ?>
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
                                                                            }else if($order->status == 4){
                                                                                echo "<span class='label label-success'>Complete</span>";
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
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
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
<!--  Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jasny-bootstrap.min.js"); ?>"></script>
<!--  Full Calendar Plugin    -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/fullcalendar.min.js"); ?>"></script>
<!-- TagsInput Plugin -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/jquery.tagsinput.js"); ?>"></script>
<!-- Material Dashboard javascript methods -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/material-dashboard.js"); ?>"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("new_theme")."/assets/js/demo.js"); ?>"></script>

<script>
$(document).ready(function(){
    $(".profile1").show();
    $(".message1").hide();
    $(".setting1").hide();
    
    $(".profile").click(function(){
        $(".profile1").show();
        $(".message1").hide();
        $(".setting1").hide();
    });
    
     $(".message").click(function(){
        $(".profile1").hide();
        $(".message1").show();
        $(".setting1").hide();
    });
    
     $(".setting").click(function(){
        $(".profile1").hide();
        $(".message1").hide();
        $(".setting1").show();
    });
});
</script>
</html>