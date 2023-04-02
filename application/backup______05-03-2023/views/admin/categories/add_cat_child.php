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
                        echo $this->session->flashdata('message'); 
                    ?>
                            <?php
                                $q = $this->db->query("SELECT * FROM `language_setting`  WHERE `id`=1 " );
                                $rows = $q->row();
                                if($rows->status==1)
                                {
                                    $setting=0;
                                }
                                else
                                {
                                    $setting='style="display:none"';
                                }
                            ?>
                    <div class="row">
                        <form action="<?=site_url('admin/post_cat_child/'.$parent['id'].'/')?>" method="post" enctype="multipart/form-data" class="form-horizontal" >
                            <?php if($this->session->userdata('language') == "arabic"){ ?>
                            <div class="col-md-3">
                            </div>
                            <?php } ?>
                            <input type="hidden" name="parent" value="<?=$parent['id']?>">
                            <input type="hidden" name="leval" value="<?=$parent['leval']+1?>">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add child category to <?=$parent['title']?></h4>
                                    <div class="row" style="margin-top: 50px">
                                        <label class="col-md-3 "><?php echo $this->lang->line("Categories Title");?> *</label>
                                        <div class="col-md-9">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="title" placeholder="Category Title" class="form-control" />
                                            <span class="material-input"></span></div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 50px">
                                        <label class="col-md-3 ">Categories Title Urdu</label>
                                        <div class="col-md-9">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="urdu_title" placeholder="Category Title Urdu" class="form-control" style="text-align: right;" />
                                            <span class="material-input"></span></div>
                                        </div>
                                    </div>
                                    <div class="row" id="chota-parent" style="display: none;">
                                        <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Sub Category");?> *</label>
                                        <div class="col-md-9">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <select class="text-input form-control" name="sub_cat"></select>
                                            <span class="material-input"></span></div>
                                        </div>
                                    </div><!-- /chota-parent -->
                                    <div class="row">
                                        <label class="col-md-3 label-on-left">Category Type</label>
                                        <div class="col-md-9">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <?php
                                                    $cat_type_ = $this->db->query("SELECT * FROM `cat_type` ORDER BY `title`");
                                                    $cat_type = $cat_type_->result();
                                                ?>
                                                <select class="text-input form-control" name="cat_type_id">
                                                    <?php foreach ($cat_type as $CatType): ?>
                                                        <?php if ($CatType->title == 'clothes'): ?>
                                                            <option value="<?=$CatType->cat_type_id?>" selected="selected"><?=$CatType->title?></option>
                                                        <?php endif ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            <span class="material-input"></span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Category Icon");?>:</label>
                                        <div class="col-md-9">
                                            <legend></legend>
                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="" alt="Selected Image">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                    <span class="btn btn-rose btn-round btn-file">
                                                        <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
                                                        <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
                                                        <input type="file" name="cat_img">
                                                    </span>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i><?php echo $this->lang->line("Remove");?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="border-bottom: 1px solid #eee;margin-bottom: 10px;">
                                        <label class="col-md-3 label-on-left">Show In Main Menu</label>
                                        <div class="col-md-9">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="radio" name="main_menu" value="yes" class="col-md-3"/><label class="col-md-6">Yes</label>
                                                <span class="material-input"></span>
                                            </div>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="radio" name="main_menu" value="no" class="col-md-3" checked/><label class="col-md-6">No</label>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="border-bottom: 1px solid #eee;margin-bottom: 10px;">
                                        <label class="col-md-3 label-on-left">Show In Main Right Menu</label>
                                        <div class="col-md-9">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="radio" name="main_right_menu" value="yes" class="col-md-3"/><label class="col-md-6">Yes</label>
                                                <span class="material-input"></span>
                                            </div>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="radio" name="main_right_menu" value="no" class="col-md-3" checked/><label class="col-md-6">No</label>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="border-bottom: 1px solid #eee;margin-bottom: 10px;">
                                        <label class="col-md-3 label-on-left">Show In Main Home Page</label>
                                        <div class="col-md-9">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="radio" name="main_home_page" value="yes" class="col-md-3"/><label class="col-md-6">Yes</label>
                                                <span class="material-input"></span>
                                            </div>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="radio" name="main_home_page" value="no" class="col-md-3" checked/><label class="col-md-6">No</label>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="border-bottom: 1px solid #eee;margin-bottom: 10px;">
                                        <label class="col-md-3 label-on-left">Show Under Parent In Main Home Page</label>
                                        <div class="col-md-9">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="radio" name="main_home_page_under_parent" value="yes" class="col-md-3" checked/><label class="col-md-6">Yes</label>
                                                <span class="material-input"></span>
                                            </div>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="radio" name="main_home_page_under_parent" value="no" class="col-md-3" /><label class="col-md-6">No</label>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 50px">
                                        <label class="col-md-3 ">Tags</label>
                                        <div class="col-md-9">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" name="tags" placeholder="Fashion, Winter, Summer.." class="form-control" />
                                            <span class="material-input"></span></div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <label class="col-md-3 label-on-left">Status</label>
                                        <div class="col-md-9">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="radio" name="status" value="1" class="col-md-3" checked/><label class="col-md-6"><?php echo $this->lang->line("Active");?></label>
                                                <span class="material-input"></span>
                                            </div>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="radio" name="status" value="0" class="col-md-3" /><label class="col-md-6"><?php echo $this->lang->line("Deactive");?></label>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-3"></label>
                                        <div class="col-md-9">
                                            <div class="form-group form-button">
                                                <input type="submit" class="btn btn-fill btn-rose" value="<?php echo $this->lang->line("Add Category");?>">
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
        md.initSliders()
        demo.initFormExtendedDatetimepickers();
    });

    $(function(){
        /*$(document).on('change', "select[name='parent']", function() {
            $("#chota-parent").fadeOut(100);
            $("#chota-parent select").html('');
            $this = $(this);
            $id = $this.val();
            $.post('<?=site_url("admin/bakar_cat")?>', {id: $id}, function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == true) {
                    $("#chota-parent select").html(resp.data);
                    $("#chota-parent").fadeIn(100);
                }
                else{
                    $("#chota-parent").fadeOut(100);
                }
            });

        });*/
    });//onload

</script>
</html>