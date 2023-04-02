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
                    <div class="row">
                        <form form action="<?=site_url( 'admin/post_product' )?>" method="post" enctype="multipart/form-data" class="form-horizontal" >
                            <?php if($this->session->userdata('language') == "arabic")
                                {
                                ?>
                                    <div class="col-md-3">
                                    </div>
                                <?php
                                }
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

                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">contacts</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add Product</h4>
                                        <div class="row"  style="margin-top:50px">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("product title");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="product_name" class="form-control"  placeholder="Product Title" required="required"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3 ">Product Urdu Title</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="urdu_title" placeholder="Product Title Urdu" class="form-control" style="text-align: right;" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
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
                                            <!-- <div class="row">
                                                <label class="col-md-3 label-on-left">Category Level 1</label>
                                                <div class="col-md-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <select class="text-input form-control category-1 category-select-tag">
                                                            <option value="">Select Parent First</option>
                                                        </select>
                                                    <span class="material-input"></span></div>
                                                </div>
                                            </div> -->
                                        </div><!-- /child-cats -->
                                        <div class="row">
                                            <label class="col-md-3 label-on-left">Brand</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <?php
                                                        $brands_ = $this->db->query("SELECT * FROM `brand` ORDER BY `title`");
                                                        $brands = $brands_->result();
                                                    ?>
                                                    <select class="text-input form-control" name="brand_id">
                                                        <option value="">Select Brand</option>
                                                        <?php foreach ($brands as $brand): ?>
                                                            <option value="<?=$brand->brand_id?>"><?=$brand->title?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Product Description");?></label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <textarea name="product_description" id="product_description" class="textarea" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;  "></textarea>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Product Image");?>:</label>
                                            <div class="col-md-9">
                                                <legend></legend>
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        <img width="100%" height="100%" src="" />
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                    <div>
                                                        <span class="btn btn-rose btn-round btn-file">
                                                            <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>
                                                            <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>
                                                            <input type="file" name="prod_img">
                                                        </span>
                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> <?php echo $this->lang->line("Remove");?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                <input type="radio" name="in_stock" value="1"  checked/>
                                                <label style="margin-left:20px"><?php echo $this->lang->line("In Stock");?></label>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">                                            
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                <input type="radio" name="in_stock"  value="0"  />
                                                <label style="margin-left:20px"><?php echo $this->lang->line("Deactive"); ?></label>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>

                                        <div class="row" style="border-top: 1px solid #eee;margin-top: 10px;padding-top: 10px;">
                                            <label class="col-md-3 label-on-left">New Product :</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="radio" name="new"  value="yes"  />
                                                    <label style="margin-left:20px">YES</label>
                                                    <span class="material-input"></span>
                                                </div><!-- /form-group -->
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="radio" name="new"  value="no"  checked="checked" />
                                                    <label style="margin-left:20px">NO</label>
                                                    <span class="material-input"></span>
                                                </div><!-- /form-group -->
                                            </div><!-- /9 -->
                                        </div><!-- /row -->

                                        <div class="row" style="border-top: 1px solid #eee;border-bottom: 1px solid #eee;margin-top: 10px;margin-bottom: 10px;padding-top: 10px;">
                                            <label class="col-md-3 label-on-left">Featured Product :</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="radio" name="featured"  value="yes"  />
                                                    <label style="margin-left:20px">YES</label>
                                                    <span class="material-input"></span>
                                                </div><!-- /form-group -->
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="radio" name="featured"  value="no"  checked="checked" />
                                                    <label style="margin-left:20px">NO</label>
                                                    <span class="material-input"></span>
                                                </div><!-- /form-group -->
                                            </div><!-- /9 -->
                                        </div><!-- /row -->

                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("mrp");?> :</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="mrp"  class="form-control" placeholder="00.00"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Price");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="price"  class="form-control product-price" placeholder="00.00" required="required"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <?php if (1==2): ?>
                                            <div class="row">
                                                <label class="col-md-3 label-on-left">New Price</label>
                                                <div class="col-md-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" name="new_price"  class="form-control" value="0"/>
                                                    <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left">Sale Percentage</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="sale_percentage"  class="form-control product-price-sale" value="0.00"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left">Discount</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control product-price-diff" name="discount" value="0"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Price TAX (%)");?>:</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="tax"  class="form-control" placeholder="00.00"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label class="col-md-3 label-on-left">Unite Value </label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="unit_value" class="form-control" placeholder="00"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Unit");?></label>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="unit" class="form-control" placeholder="KG/ BAG/ NOS/ QTY / etc " />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        
                                        <div class="row size-block" style="display: none;border-top: 1px solid #eee;margin-top: 10px;padding-top: 10px;">
                                            <label class="col-md-3 label-on-left">Size</label>
                                            <div class="col-md-9 size-block-sizes-only" style="padding-top: 20px;padding-bottom: 20px;max-height: 750px;overflow-y: auto;background: #f5f5f5;">
                                                <div class="form-group">
                                                    <input type="checkbox" id="check-all-sizes"> &nbsp;&nbsp;
                                                    <label class="control-label">All</label>
                                                </div>
                                                <?php foreach ($sizes as $key => $size): ?>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="checkbox" name="size[]" value="<?=$size['size_id']?>"> &nbsp;&nbsp;
                                                                <label class="control-label"><?=$size['name']?></label>
                                                            </div>
                                                        </div><!-- /4 -->
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label>Price</label>
                                                                <input type="text" data-name="size_price<?=$size['size_id']?>" class="form-control size-price size-filter-price" value="0"> &nbsp;&nbsp;
                                                            </div>
                                                        </div><!-- /8 -->
                                                    </div><!-- {row} -->
                                                <?php endforeach ?>
                                            </div><!-- /size-block-sizes-only -->
                                        </div>

                                        <div class="row size-block" style="display: none;">
                                            <label class="col-md-3 label-on-left">Size Note Title</label>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="size_note_title" class="form-control" placeholder="Size Note Title" />
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row size-block" style="display: none;">
                                            <label class="col-md-3 label-on-left">Size Note</label>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="size_note" class="form-control" placeholder="Size Note" />
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row color-block" style="display: none;border-top: 1px solid #eee;border-bottom: 1px solid #eee;margin-top: 10px;margin-bottom: 10px;padding-top: 10px;">
                                            <label class="col-md-3 label-on-left">Color</label>
                                            <div class="col-md-9 color-block-colors-only" style="padding-top: 20px;padding-bottom: 20px;max-height: 750px;overflow-y: auto;background: #f5f5f5;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="checkbox" id="check-all-colors"> &nbsp;&nbsp;
                                                            <label class="control-label">All</label>
                                                        </div>
                                                    </div><!-- /2 -->
                                                </div><!-- {row} -->
                                                <?php foreach ($colors as $key => $color): ?>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="checkbox" name="color[]" value="<?=$color['color_id']?>"> &nbsp;&nbsp;
                                                                <label class="control-label"><?=$color['name']?></label>
                                                            </div>
                                                        </div><!-- /4 -->
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="file" name="color_file<?=$color['color_id']?>"> &nbsp;&nbsp;
                                                                <label class="btn" style="display: block; cursor: pointer;background: #fff;color: #000;border: 3px solid <?=$color['name']?>;"><?=$color['name']?> Image</label>
                                                            </div>
                                                        </div><!-- /4 -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Price</label>
                                                                <input type="text" data-name="color_price<?=$color['color_id']?>" class="form-control color-price color-filter-price" value="0"> &nbsp;&nbsp;
                                                            </div>
                                                        </div><!-- /6 -->
                                                    </div><!-- {row} -->
                                                <?php endforeach ?>
                                            </div><!-- /color-block-colors-only -->
                                        </div>

                                        <div class="row color-block" style="display: none;">
                                            <label class="col-md-3 label-on-left">Color Note Title</label>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="color_note_title" class="form-control" placeholder="Color Note Title" />
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row color-block" style="display: none;">
                                            <label class="col-md-3 label-on-left">Color Note</label>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="color_note" class="form-control" placeholder="Color Note" />
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left">Which Filter Price To Show *</label>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="control-label"></label>
                                                    <select name="filter_price_show" class="form-control" required="required">
                                                        <option value="none" selected="selected">None</option>
                                                        <option value="size">SIZE</option>
                                                        <option value="color">COLOR</option>
                                                    </select>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="dynamic-filters">
                                            
                                            <!-- ------- -->

                                        </div><!-- /dynamic-filters -->

                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Rewards");?></label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="rewards" class="form-control" placeholder="00"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>

                                         <div class="row">
                                            <label class="col-md-3 label-on-left">Warranty</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select name="warranty" class="form-control">
                                                        <option value="yes" selected="selected">Yes</option>
                                                        <option value="no">no</option>
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label class="col-md-3 label-on-left">SKU</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="sku" class="form-control" placeholder="SKU"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label class="col-md-3 label-on-left">Easy Door SKU</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="sku_own" class="form-control" placeholder="Easy Door SKU"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>

                                        <?php if (1==2): ?>
                                            <div class="row" style="margin-top: 50px">
                                                <label class="col-md-3 ">Meta Title *</label>
                                                <div class="col-md-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" name="meta_title" placeholder="Meta Title" class="form-control" required="required" />
                                                    <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 50px">
                                                <label class="col-md-3 ">Meta Key Words *</label>
                                                <div class="col-md-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" name="meta_key" placeholder="Meta Key Words" class="form-control" required="required" />
                                                    <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 50px">
                                                <label class="col-md-3 ">Meta Description *</label>
                                                <div class="col-md-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" name="meta_desc" placeholder="Meta Description" class="form-control" required="required" />
                                                    <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                        <?php endif ?>


                                        <div class="cat-tags-area" style="margin: 10px 0;padding: 10px 0;border-top: 1px solid #eee;border-bottom: 1px solid #eee;display: none;">
                                            
                                        </div><!-- /cat-tags-area -->


                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" class="btn btn-fill btn-rose" name="addcatg" value="Add Product">
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

<script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>

<script type="text/javascript">
        CKEDITOR.replace( 'product_description' );
    $(document).ready(function() {
        //md.initSliders()
        demo.initFormExtendedDatetimepickers();
    });
</script>
</html>



<script>
    $(function(){

        //$(document).on('change', 'select[name="category_id"]', function(event) {
        $(document).on('change', '.category-select-tag', function(event) {
            event.preventDefault();
            $(".cat-tags-area").hide(0);
            $(".cat-tags-area").html('');
            $cat = $(this).val();
            $.post('<?=site_url( 'admin/get_cat_tags' )?>', {cat: $cat}, function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == true) {
                    $(".cat-tags-area").html(resp.html);
                    $(".cat-tags-area").show(0);
                }
            });
        });

        /**
        *
        *   PRODUCT DIFF
        *
        */
        $(document).on('keyup', '.product-price-sale,.product-price', function(event) {
            event.preventDefault();
            $price = parseInt($(".product-price").val());
            $diff = parseInt($(".product-price-diff").val());
            $sale = parseFloat($(".product-price-sale").val());
            if ($sale > 0) {
                $unit = $price/100;
                $Diff = $unit*$sale;
                $(".product-price-diff").val(parseInt($Diff));
            }
            else{
                $(".product-price-diff").val(0);
            }
        });
        $(document).on('keyup', '.product-price-diff', function(event) {
            event.preventDefault();
            $price = parseInt($(".product-price").val());
            $diff = parseInt($(".product-price-diff").val());
            $sale = parseFloat($(".product-price-sale").val());
            if ($diff == 0 || isNaN($diff)) {
                $(".product-price-diff").val(0);
                $(".product-price-sale").val(0);
            }
            else{
                $unit = $price/100;
                $Diff = $diff/$unit;
                $(".product-price-sale").val(parseInt($Diff));
            }
        });


        $(document).on('change', '#check-all-sizes', function(event) {
            event.preventDefault();
            if ($(this).prop('checked') == true) {
                $("input[name='size[]']").prop('checked',true);
            }
            else{
                $("input[name='size[]']").prop('checked',false);
            }
        });

        $(document).on('change', '#check-all-colors', function(event) {
            event.preventDefault();
            if ($(this).prop('checked') == true) {
                $("input[name='color[]']").prop('checked',true);
            }
            else{
                $("input[name='color[]']").prop('checked',false);
            }
        });
        
        // $(document).on('change', 'select[name="category_id"]', function(event) {
        $(document).on('change', '.category-select-tag', function(event) {
            event.preventDefault();
            $this = $(this);
            $id = $this.val();
            $(".size-block,.color-block").fadeOut(0);
            $size = $('option:selected',this).attr('data-size');
            $color = $('option:selected',this).attr('data-color');
            if ($size == 'true') {
                $.post('<?=site_url("admin/get_sizes_by_cat")?>', {id: $id}, function(resp) {
                    resp = JSON.parse(resp);
                    if (resp.status == true) {
                        $(".size-block-sizes-only").html(resp.html);
                        $(".size-block").fadeIn(0);
                    }
                });
            }
            if ($color == 'true') {
                $.post('<?=site_url("admin/get_colors_by_cat")?>', {id: $id}, function(resp) {
                    resp = JSON.parse(resp);
                    if (resp.status == true) {
                        $(".color-block-colors-only").html(resp.html);
                        $(".color-block").fadeIn(0);
                    }
                });
            }

            $filter = $('option:selected',this).attr('data-filter-ids');
            $(".dynamic-filters").html('');
            $.post('<?=site_url("admin/get_filter_values_html")?>', {id: $filter}, function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == true) {
                    $(".dynamic-filters").html(resp.html);
                }
            });
        });


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

        $(document).on('blur', '.color-filter-price', function(event) {
            event.preventDefault();
            $price = parseInt($(this).val());
            if (!($price > 0)) {
                $(this).val(0);
                $(this).removeAttr('name');
            }
            else{
                $(this).prop('name',$(this).attr('data-name'));
            }
        });
        $(document).on('blur', '.size-filter-price', function(event) {
            event.preventDefault();
            $price = parseInt($(this).val());
            if (!($price > 0)) {
                $(this).val(0);
                $(this).removeAttr('name');
            }
            else{
                $(this).prop('name',$(this).attr('data-name'));
            }
        });


    });
</script>

