<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url($this->config->item("theme_admin")."/assets/img/apple-icon.png"); ?>" />
    <link rel="icon" type="image/png" href="<?php echo base_url($this->config->item("theme_admin")."/assets/img/favicon.png"); ?>" />
    <title></title>
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />
    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url($this->config->item("theme_admin")."/assets/css/bootstrap.min.css"); ?>" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?php echo base_url($this->config->item("theme_admin")."/assets/css/material-dashboard.css"); ?>" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo base_url($this->config->item("theme_admin")."/assets/css/demo.css"); ?>" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="<?php echo base_url($this->config->item("theme_admin")."/assets/css/font-awesome.css"); ?>" rel="stylesheet" />
    <link href="<?php echo base_url($this->config->item("theme_admin")."/assets/css/google-roboto-300-700.css"); ?>" rel="stylesheet" />
</head>

<body>
    <div class="wrapper">
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel">
            <?php  $this->load->view("admin/common/header"); ?>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">home</i>
                                </div>
                                <div class="card-content">
                                    
                                    <h3 class="card-title"><?php echo $this->lang->line("Purchase products");?></h3>
                                
                                <!-- form start -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Product :");?> <span class="text-danger">*</span></label>
                                            <select class="form-control" name="product_id">
                                                <?php foreach($products as $product){
                                                    ?>
                                                    <option value="<?php echo $product->product_id; ?>"><?php echo $product->product_name; ?></option>
                                                    <?php
                                                } ?>
                                            </select>
                                        </div>
                                     <!--    <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Price :");?> <span class="text-danger">*</span></label>
                                            <input type="text" name="price" class="form-control" placeholder="00.00"/>
                                        </div> -->
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Qty :");?> <span class="text-danger">*</span></label>
                                            <input type="text" name="qty" class="form-control" placeholder="00" />
                                        </div>


<div class="form-group" style="display:none;">
                                            <label class=""><?php echo $this->lang->line("Qty :");?> <span class="text-danger">*</span></label>
                                            <input type="text" name="store_id_login" class="form-control" placeholder="00" value="<?=_get_current_user_id($this);?>"/>
                                        </div>



                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Unit :");?><span class="text-danger">*</span></label>
                                             <input type="unit" name="unit" class="form-control" placeholder="KG/ BAG/ NOS/ QTY / etc"/>
                                            
                                        </div>
                                        
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="addcatg" value="Add Purchase" />
                                       
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h3 class="card-title"><?php echo $this->lang->line("List Purchase");?></h3>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                <th><?php echo $this->lang->line("ID"); ?></th>
                                                <th><?php echo $this->lang->line("Product Name");?></th>
                                                <th><?php echo $this->lang->line("Qty");?></th>
                                                <th><?php echo $this->lang->line("Unit");?></th>
                                                <th class="text-center" style="width: 100px;"><?php echo $this->lang->line("Action");?></th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                                 <tr>
                                                <th><?php echo $this->lang->line("ID"); ?></th>
                                                <th><?php echo $this->lang->line("Product Name");?></th>
                                                <th><?php echo $this->lang->line("Qty");?></th>
                                                <th><?php echo $this->lang->line("Unit");?></th>
                                                <th class="text-center" style="width: 100px;"><?php echo $this->lang->line("Action");?></th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                               <?php foreach($purchases as $purchase){ 
                                               if($purchase->store_id_login==_get_current_user_id($this)) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo $purchase->purchase_id; ?></td>
                                                <td><?php echo $purchase->product_name; ?></td>
                                                <td><?php echo $purchase->qty; ?></td>
                                                <td><?php echo $purchase->unit; ?></td>
                                                <td class="text-center"><div class="btn-group">
                                                    <?php echo anchor('admin/edit_purchase/'.$purchase->purchase_id, '<i class="fa fa-edit"></i>', array("class"=>"btn btn-success")); ?>
                                                       
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php }} ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                    </div>
                </div>
            </div>
            <?php  $this->load->view("admin/common/common_footer") ?>
        </div>
    </div>
    <!-- content -->
    <?php  $this->load->view("admin/common/fixed"); ?>
</body>
<!--   Core JS Files   -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery-3.1.1.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery-ui.min.js"); ?>" type="text/javascript"></script>
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
<!--<script src="https://maps.googleapis.com/maps/api/js"></script>-->
<!-- Select Plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery.select-bootstrap.js"); ?>"></script>
<!--  DataTables.net Plugin    -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery.datatables.js"); ?>"></script>
<!-- Sweet Alert 2 plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/sweetalert2.js"); ?>"></script>
<!--	Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jasny-bootstrap.min.js"); ?>"></script>
<!--  Full Calendar Plugin    -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/fullcalendar.min.js"); ?>"></script>
<!-- TagsInput Plugin -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/jquery.tagsinput.js"); ?>"></script>
<!-- Material Dashboard javascript methods -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/material-dashboard.js"); ?>"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url($this->config->item("theme_admin")."/assets/js/demo.js"); ?>"></script>
</html>