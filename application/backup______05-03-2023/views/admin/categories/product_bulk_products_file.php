<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/apple-icon.png"); ?>" />
    <link rel="icon" type="image/png" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/favicon.png"); ?>" />
    <title>Admin | Dashboard</title>
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
</head>

<body>
    <div class="wrapper">
        <?php  $this->load->view("admin/common/sidebar"); ?>
        <div class="main-panel">
            <?php  $this->load->view("admin/common/header"); ?>
            <div class="content">
                <div class="container-fluid">
                    <?php  if(isset($error)){ echo $error; }
                        if(!empty($success)) { echo $success; }
                    ?>
                    <div class="row">
                        <form action="<?php echo site_url();?>/admin/create_bulk_products_csv_file" method="post" enctype="multipart/form-data" name="form1" id="form1" class="form-horizontal" >
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Products Bulk File</h4>
                                        

                                        <div class="row">
                                            <label class="col-md-3 label-on-left">Category: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select class="text-input form-control parent-category category-select-tag" data-id="category-1" required="required">
                                                        <option value="">Select Category</option>
                                                        <?php foreach ($parents as $key => $parent): ?>
                                                            <?php
                                                            $filters = explode(',', $d->filters);
                                                            if (in_array('size', $filters)) {
                                                                $SizesFilter = 'true';
                                                            }
                                                            else{
                                                                $SizesFilter = 'false';
                                                            }
                                                            if (in_array('color', $filters)) {
                                                                $ColorsFilter = 'true';
                                                            }
                                                            else{
                                                                $ColorsFilter = 'false';
                                                            }
                                                            ?>
                                                            <option value="<?=$parent['id']?>"><?=$parent['title']?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="child-cats">

                                        </div><!-- /child-cats -->


                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <button  type="submit" class="btn btn-fill btn-rose" name="submit">Create </button>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        </form>
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
        //md.initSliders()
        //demo.initFormExtendedDatetimepickers();




        $(document).on('change', '.parent-category', function(event) {
            event.preventDefault();
            $this = $(this);
            $(".child-cats").html('');
            $this.removeAttr('name');
            $id = $this.val();
            $.post('<?=site_url("admin/get_child_cats")?>', {id: $id}, function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == true) {
                    $(".child-cats").append(resp.html);
                }
                else{
                    $this.prop('name','category_id');
                }
            });
        });

        $(document).on('change', '.category-select-tag-dynamic', function(event) {
            event.preventDefault();
            $this = $(this);
            $this.parent('div').parent('div').parent('div').next('div.row').remove();
            $this.removeAttr('name');
            $id = $this.val();
            $.post('<?=site_url("admin/get_child_cats")?>', {id: $id}, function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == true) {
                    $(".child-cats").append(resp.html);
                }
                else{
                    $this.prop('name','category_id');
                }
            });
        });



    });
</script>
</html>