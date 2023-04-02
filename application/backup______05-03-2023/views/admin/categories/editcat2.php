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
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" >
                            <?php if($this->session->userdata('language') == "arabic"){ ?>
                        <div class="col-md-3">
                        </div>
                        <?php } ?>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("Edit Categories");?></h4>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3"><?php echo $this->lang->line("Categories Title");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="cat_title" class="form-control" value="<?php echo $getcat->title; ?>"/>
                                                    <input type="hidden" name="cat_id" class="form-control" placeholder="Categories id" value="<?php echo $getcat->id; ?>"/>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3 ">URL Slug *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="slug" placeholder="URL Slug" class="form-control" value="<?php echo $getcat->slug; ?>" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3">Categories Title Urdu</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="urdu_title" class="form-control" value="<?php echo $getcat->urdu_title; ?>" style="text-align: right;"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row" <?= $setting ?> >
                                            <label class="col-md-3"><?php echo $this->lang->line("Arabic Categories Title");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="arb_cat_title" class="form-control" value="<?php echo $getcat->arb_title; ?>"/>
                                                    <input type="hidden" name="cat_id" class="form-control" placeholder="Categories id" value="<?php echo $getcat->id; ?>"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"> <?php echo $this->lang->line("Parent Category");?> *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select class="form-control"  name="parent">
                                                        <option value=""> Select Parent</option>
                                                        <?php  
                                                            $parents = $this->db->query("SELECT `id`,`title` FROM `categories` WHERE `parent` = 0");
                                                            if ($parents->num_rows()>0){
                                                                foreach ($parents->result_array() as $cat){
                                                                    if ($getcat->parent == $cat['id']) {
                                                                        echo '<option value="'.$cat['id'].'" selected="selected">'.$cat['title'].'</option>';
                                                                    }
                                                                    else{
                                                                        echo '<option value="'.$cat['id'].'">'.$cat['title'].'</option>';
                                                                    }
                                                                        
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <?php if ($getcat->leval == 2): ?>
                                            <?php
                                            $SubCatID = $getcat->parent;
                                            $SubCat = $this->db->query("SELECT `id`,`title`,`parent` FROM `categories` WHERE `id` = '$SubCatID'");
                                            foreach ($SubCat->result_array() as $cat_){
                                                $BigParentID = $cat_['parent'];
                                            }
                                            $SubCatsByParentID = $this->db->query("SELECT `id`,`title` FROM `categories` WHERE `parent` = '$BigParentID'");
                                            ?>
                                            
                                             <div class="row" id="chota-parent">
                                                <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Sub Category");?> *</label>
                                                <div class="col-md-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <select class="text-input form-control" data-parent="<?=$BigParentID?>" name="sub_cat">
                                                            <?php
                                                            foreach ($SubCatsByParentID->result_array() as $SubCat){
                                                                if ($SubCatID == $SubCat['id']) {
                                                                ?>
                                                                    <option value="<?=$SubCat['id']?>" selected="selected"><?=$SubCat['title']?></option>
                                                                <?php
                                                                }
                                                                else{
                                                            ?>
                                                                    <option value="<?=$SubCat['id']?>"><?=$SubCat['title']?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    <span class="material-input"></span></div>
                                                </div>
                                            </div><!-- /chota-parent -->
                                        <?php else: ?>
                                            <div class="row" id="chota-parent" style="display: none;">
                                                <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Sub Category");?> *</label>
                                                <div class="col-md-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <select class="text-input form-control" name="sub_cat"></select>
                                                    <span class="material-input"></span></div>
                                                </div>
                                            </div><!-- /chota-parent -->
                                        <?php endif; ?>
                                        
                                        <div class="row">
                                            <label class="col-md-3 label-on-left">Category Type</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <?php
                                                        $cat_type_ = $this->db->query("SELECT * FROM `cat_type` ORDER BY `title`");
                                                        $cat_type = $cat_type_->result();
                                                    ?>
                                                    <?php if (1==2): ?>
                                                        <select class="text-input form-control" name="cat_type_id">
                                                            <option value="">Select Type</option>
                                                            <?php foreach ($cat_type as $CatType): ?>
                                                                <?php if ($getcat->cat_type_id == $CatType->cat_type_id): ?>
                                                                    <option value="<?=$CatType->cat_type_id?>" selected="selected"><?=$CatType->title?></option>
                                                                <?php else: ?>
                                                                    <option value="<?=$CatType->cat_type_id?>"><?=$CatType->title?></option>
                                                                <?php endif ?>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    <?php endif ?>
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
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Categories icon");?> </label>
                                            <div class="col-md-9">
                                                <legend></legend>
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        <img width="100%" height="100%" src="<?php echo $this->config->item('base_url').'uploads/category/'.$getcat->image ?>" />
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                    <div>
                                                        <span class="btn btn-rose btn-round btn-file">
                                                            <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
                                                            <span class="fileinput-exists">Change</span>
                                                            <input type="file" name="cat_img">
                                                        </span>
                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left">App Icon:</label>
                                            <div class="col-md-9">
                                                <legend></legend>
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        <img width="100%" height="100%" src="<?php echo $this->config->item('base_url').'uploads/category/'.$getcat->app_icon ?>" />
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                    <div>
                                                        <span class="btn btn-rose btn-round btn-file">
                                                            <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
                                                            <span class="fileinput-exists">Change</span>
                                                            <input type="file" name="app_icon">
                                                        </span>
                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="border-bottom: 1px solid #eee;margin-bottom: 10px;">
                                            <label class="col-md-3 label-on-left">Show In Main Menu</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <?php if ($getcat->main_menu == 'yes'): ?>
                                                        <input type="radio" name="main_menu" value="yes" class="col-md-3" checked/><label class="col-md-6">Yes</label>
                                                    <?php else: ?>
                                                        <input type="radio" name="main_menu" value="yes" class="col-md-3"/><label class="col-md-6">Yes</label>
                                                    <?php endif ?>
                                                    <span class="material-input"></span>
                                                </div>
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <?php if ($getcat->main_menu == 'no'): ?>
                                                        <input type="radio" name="main_menu" value="no" class="col-md-3" checked/><label class="col-md-6">No</label>
                                                    <?php else: ?>
                                                        <input type="radio" name="main_menu" value="no" class="col-md-3" /><label class="col-md-6">No</label>
                                                    <?php endif ?>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="border-bottom: 1px solid #eee;margin-bottom: 10px;">
                                            <label class="col-md-3 label-on-left">Show In Main Right Menu</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <?php if ($getcat->main_right_menu == 'yes'): ?>
                                                        <input type="radio" name="main_right_menu" value="yes" class="col-md-3" checked/><label class="col-md-6">Yes</label>
                                                    <?php else: ?>
                                                        <input type="radio" name="main_right_menu" value="yes" class="col-md-3"/><label class="col-md-6">Yes</label>
                                                    <?php endif ?>
                                                    <span class="material-input"></span>
                                                </div>
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <?php if ($getcat->main_right_menu == 'no'): ?>
                                                        <input type="radio" name="main_right_menu" value="no" class="col-md-3" checked/><label class="col-md-6">No</label>
                                                    <?php else: ?>
                                                        <input type="radio" name="main_right_menu" value="no" class="col-md-3" /><label class="col-md-6">No</label>
                                                    <?php endif ?>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="border-bottom: 1px solid #eee;margin-bottom: 10px;">
                                            <label class="col-md-3 label-on-left">Show In Main Home Page</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <?php if ($getcat->main_home_page == 'yes'): ?>
                                                        <input type="radio" name="main_home_page" value="yes" class="col-md-3" checked/><label class="col-md-6">Yes</label>
                                                    <?php else: ?>
                                                        <input type="radio" name="main_home_page" value="yes" class="col-md-3"/><label class="col-md-6">Yes</label>
                                                    <?php endif ?>
                                                    <span class="material-input"></span>
                                                </div>
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <?php if ($getcat->main_home_page == 'no'): ?>
                                                        <input type="radio" name="main_home_page" value="no" class="col-md-3" / checked><label class="col-md-6">No</label>
                                                    <?php else: ?>
                                                        <input type="radio" name="main_home_page" value="no" class="col-md-3" /><label class="col-md-6">No</label>
                                                    <?php endif ?>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="border-bottom: 1px solid #eee;margin-bottom: 10px;">
                                            <label class="col-md-3 label-on-left">Show Under Parent In Main Home Page</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <?php if ($getcat->main_home_page_under_parent == 'yes'): ?>
                                                        <input type="radio" name="main_home_page_under_parent" value="yes" class="col-md-3" checked/><label class="col-md-6">Yes</label>
                                                    <?php else: ?>
                                                        <input type="radio" name="main_home_page_under_parent" value="yes" class="col-md-3"/><label class="col-md-6">Yes</label>
                                                    <?php endif ?>
                                                    <span class="material-input"></span>
                                                </div>
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <?php if ($getcat->main_home_page_under_parent == 'no'): ?>
                                                        <input type="radio" name="main_home_page_under_parent" value="no" class="col-md-3" / checked><label class="col-md-6">No</label>
                                                    <?php else: ?>
                                                        <input type="radio" name="main_home_page_under_parent" value="no" class="col-md-3" /><label class="col-md-6">No</label>
                                                    <?php endif ?>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row" style="border-bottom: 1px solid #eee;margin-top: 10px;padding-top: 10px;">
                                            <label class="col-md-3 label-on-left">Filters</label>
                                            <div class="col-md-9">
                                                <?php $filters = explode(',', $getcat->filters); ?>

                                                <div class="form-group">
                                                    <?php if (in_array('size', $filters)): ?>
                                                        <input type="checkbox" name="filters[]" value="size" checked="checked"> &nbsp;&nbsp;
                                                    <?php else: ?>
                                                        <input type="checkbox" name="filters[]" value="size"> &nbsp;&nbsp;
                                                    <?php endif ?>
                                                    <label class="control-label">Size</label>
                                                </div><!-- /form-group -->
                                                <div class="form-group">
                                                    <?php if (in_array('color', $filters)): ?>
                                                        <input type="checkbox" name="filters[]" value="color" checked="checked"> &nbsp;&nbsp;
                                                    <?php else: ?>
                                                        <input type="checkbox" name="filters[]" value="color"> &nbsp;&nbsp;
                                                    <?php endif ?>
                                                    <label class="control-label">Color</label>
                                                </div><!-- /form-group -->

                                            </div>
                                        </div>


                                        <?php if (1==2): ?>
                                            <div class="row" style="border-top: 1px solid #eee;border-bottom: 1px solid #eee;margin-top: 10px;padding-top: 10px;">
                                                <label class="col-md-3 label-on-left">Dynamic Filters</label>
                                                <div class="col-md-9">
                                                    <?php $filter_ids = explode(',', $getcat->filter_ids); ?>
                                                    <?php foreach ($dynamic_filters as $key => $filter): ?>
                                                        <div class="form-group">
                                                            <?php if (in_array($filter['filter_id'], $filter_ids)): ?>
                                                                <input type="checkbox" name="filter_ids[]" value="<?=$filter['filter_id']?>" checked="checked"> &nbsp;&nbsp;
                                                            <?php else: ?>
                                                                <input type="checkbox" name="filter_ids[]" value="<?=$filter['filter_id']?>"> &nbsp;&nbsp;
                                                            <?php endif ?>
                                                            <label class="control-label"><?=$filter['admin_title']?></label>
                                                        </div><!-- /form-group -->
                                                    <?php endforeach ?>
                                                </div>
                                            </div>
                                        <?php endif ?>



                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3 ">Tags</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="tags" placeholder="Fashion, Winter, Summer.." class="form-control" value="<?=$getcat->tags?>" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label class="col-md-3 label-on-left">For you?</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <?php if ($getcat->for_you == "yes"): ?>
                                                        <input type="radio" name="for_you" value="yes" class="col-md-3" checked/><label class="col-md-6">Yes</label>
                                                    <?php else: ?>
                                                        <input type="radio" name="for_you" value="yes" class="col-md-3"/><label class="col-md-6">Yes</label>
                                                    <?php endif ?>
                                                    <span class="material-input"></span>
                                                </div>
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <?php if ($getcat->for_you == "no"): ?>
                                                        <input type="radio" name="for_you" value="no" class="col-md-3" checked/><label class="col-md-6">No</label>
                                                    <?php else: ?>
                                                        <input type="radio" name="for_you" value="no" class="col-md-3" /><label class="col-md-6">No</label>
                                                    <?php endif ?>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label class="col-md-3 label-on-left">Status</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <?php if ($getcat->status == 1): ?>
                                                        <input type="radio" name="cat_status" value="1" class="col-md-3" checked/><label class="col-md-6"><?php echo $this->lang->line("Active");?></label>
                                                    <?php else: ?>
                                                        <input type="radio" name="cat_status" value="1" class="col-md-3"/><label class="col-md-6"><?php echo $this->lang->line("Active");?></label>
                                                    <?php endif ?>
                                                    <span class="material-input"></span>
                                                </div>
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <?php if ($getcat->status == 0): ?>
                                                        <input type="radio" name="cat_status" value="0" class="col-md-3" checked/><label class="col-md-6"><?php echo $this->lang->line("Deactive");?></label>
                                                    <?php else: ?>
                                                        <input type="radio" name="cat_status" value="0" class="col-md-3" /><label class="col-md-6"><?php echo $this->lang->line("Deactive");?></label>
                                                    <?php endif ?>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3 ">Meta Title *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="meta_title" placeholder="Meta Title" class="form-control" value="<?=$getcat->meta_title?>" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3 ">Meta Key Words *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="meta_key" placeholder="Meta Key Words" class="form-control" value="<?=$getcat->meta_key?>" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3 ">Meta Description *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="meta_desc" placeholder="Meta Description" class="form-control" value="<?=$getcat->meta_desc?>" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3 ">Category Description</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <textarea name="description" rows="5" class="form-control"><?=$getcat->description?></textarea>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" class="btn btn-fill btn-rose" name="savecat" value="<?php echo $this->lang->line("Save Category");?>">
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
        $(document).on('change', "select[name='parent']", function() {
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

        });
    });//onload


    
</script>



<?php if ($getcat->leval == 2): ?>
<script>
    $(document).ready(function() {
        $id = parseInt($("select[name='sub_cat']").attr('data-parent'));
        $("select[name='parent'] option").each(function() {
            if ($id == parseInt($(this).val())) {
                $(this).attr('selected','selected');
            }
        });


    });
</script>        
<?php endif ?>



</html>