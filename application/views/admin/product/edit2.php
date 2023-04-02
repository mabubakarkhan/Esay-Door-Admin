<!doctype html>
<html lang="en">


<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/examples/forms/extended.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2017 21:33:48 GMT -->
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
                        <form form action="<?=site_url( 'admin/update_product' )?>" method="post" enctype="multipart/form-data" class="form-horizontal" >
                            <input type="hidden" name="product_id" value="<?=$product->product_id?>">
                            <?php
                            $filters = explode(',', $cat['filters']);
                            if (in_array('size', $filters)) {
                                $SizesCheck = true;
                                $SizesDisplay = 'block';
                            }
                            else{
                                $SizesCheck = false;
                                $SizesDisplay = 'none';
                            }
                            if (in_array('color', $filters)) {
                                $ColorsCheck = true;
                                $ColorsDisplay = 'block';
                            }
                            else{
                                $ColorsCheck = false;
                                $ColorsDisplay = 'none';
                            }
                            ?>
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
                                    <h4 class="card-title"><?php echo $this->lang->line("Edit products");?></h4>
                                        <div class="row"  style="margin-top:50px">
                                            <label class="col-md-3 label-on-left"> <?php echo $this->lang->line("product title");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="product_name" class="form-control" value="<?php echo $product->product_name; ?>" placeholder="Product Title" required="required" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 50px">
                                            <label class="col-md-3">Product Title Urdu</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="urdu_title" class="form-control" value="<?php echo $product->urdu_title; ?>" style="text-align: right;"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left">Category *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <select class="text-input form-control" name="category_id" required="required">
                                                        <option value=""><?php echo $this->lang->line("Select Category");?></option>
                                                         <?php  
                                                            echo printCategory(0,0,$this,$product);
                                                            function printCategory($parent,$leval,$th,$product){
                                                            
                                                            $q = $th->db->query("SELECT a.*, Deriv1.count FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` WHERE a.`status`=1 and a.`parent`=" . $parent);
                                                            $rows = $q->result();
                                    
                                                            foreach($rows as $row){
                                                                if ($row->count > 0) {
                                                                        
                                                                            //print_r($row) ;
                                                                            //echo "<option value='$row[id]_$co'>".$node.$row["alias"]."</option>";
                                                                            printRow($row,$product,true);
                                                                            printCategory($row->id, $leval + 1,$th,$product);
                                                                            
                                                                        } elseif ($row->count == 0) {
                                                                            printRow($row,$product,false);
                                                                            //print_r($row);
                                                                        }
                                                                }
                                                            }
                                                            function printRow($d,$product,$bool){
                                                                
                                                           // foreach($data as $d){
                                                            
                                                            ?>
                                                               <option value="<?php echo $d->id; ?>" <?php if($product->category_id == $d->id){ echo "selected"; } ?> ><?php for($i=0; $i<$d->leval; $i++){ echo "_"; } echo $d->title; ?></option>
                                                                 
                                                             <?php } ?> 
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
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
                                                            <?php if ($product->brand_id == $brand->brand_id): ?>
                                                                <option value="<?=$brand->brand_id?>" selected="selected"><?=$brand->title?></option>
                                                            <?php else: ?>
                                                                <option value="<?=$brand->brand_id?>"><?=$brand->title?></option>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </select>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Product Description");?></label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <textarea name="product_description" id="product_description" class="textarea" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;  "><?php echo $product->product_description; ?></textarea>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Product Image");?>:</label>
                                            <div class="col-md-9">
                                                <legend></legend>
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        <img width="100%" height="100%" src="<?= base_url('uploads/products/'.$product->category_id.'/'.$product->product_image); ?>" />
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
                                        
                                        
                                        <!--<div class="row">-->
                                        <!--    <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Product Image");?>:</label>-->
                                        <!--    <div class="col-md-9">-->
                                        <!--        <div>-->
                                        <!--            <span class="btn btn-rose btn-round btn-file">-->
                                        <!--                <span class="fileinput-new"><?php echo $this->lang->line("Select image");?></span>-->
                                        <!--                <span class="fileinput-exists"><?php echo $this->lang->line("Change");?></span>-->
                                        <!--                <input type="file" name="prod_img">-->
                                        <!--            <div class="ripple-container"></div></span>-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                <input type="radio" id="prod_status" name="in_stock" value="1"  <?php if($product->in_stock == 1){ echo "checked"; } ?> />
                                                <label for="prod_status" style="margin-left:20px"><?php echo $this->lang->line("In Stock");?></label>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>

                                        <div class="row" style="border-top: 1px solid #eee;margin-top: 10px;padding-top: 10px;">
                                            <label class="col-md-3 label-on-left">New Product :</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="radio" name="new"  value="yes" <?php if($product->new == 'yes'){ echo "checked='checked'"; } ?> />
                                                    <label style="margin-left:20px">YES</label>
                                                    <span class="material-input"></span>
                                                </div><!-- /form-group -->
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="radio" name="new"  value="no" <?php if($product->new == 'no'){ echo "checked='checked'"; } ?> />
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
                                                    <input type="radio" name="featured"  value="yes" <?php if($product->featured == 'yes'){ echo "checked='checked'"; } ?> />
                                                    <label style="margin-left:20px">YES</label>
                                                    <span class="material-input"></span>
                                                </div><!-- /form-group -->
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="radio" name="featured"  value="no" <?php if($product->featured == 'no'){ echo "checked='checked'"; } ?> />
                                                    <label style="margin-left:20px">NO</label>
                                                    <span class="material-input"></span>
                                                </div><!-- /form-group -->
                                            </div><!-- /9 -->
                                        </div><!-- /row -->


                                        <div class="row">                                            
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                <input type="radio" id="prod_status" name="in_stock"  value="0" <?php if($product->in_stock == 0){ echo "checked"; } ?> />
                                                <label for="prod_status" style="margin-left:20px"><?php echo $this->lang->line("Deactive");?></label>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("mrp");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="mrp"  class="form-control" value="<?php echo $product->mrp; ?>" placeholder="00.00"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Price");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="price"  class="form-control product-price" value="<?php echo $product->price+$product->discount; ?>" placeholder="00.00" required="required" />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <?php if (1==2): ?>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left">New Price</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="new_price"  class="form-control" value="<?=$product->new_price?>"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <?php endif ?>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left">Sale Percentage</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="sale_percentage"  class="form-control product-price-sale" value="<?=$product->sale_percentage?>"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-3 label-on-left">Discount</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control product-price-diff" name="discount" value="<?=$product->discount?>"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"> <?php echo $this->lang->line("Price TAX (%)");?>: *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="tax"  class="form-control" value="<?php echo $product->tax; ?>" placeholder="00.00"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label class="col-md-3 label-on-left">Unit Value :</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="unit_value" class="form-control" value="<?php echo $product->unit_value; ?>"  placeholder="00"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Unit");?> : </label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="unit" class="form-control" value="<?php echo $product->unit; ?>" placeholder="KG/ BAG/ NOS/ QTY / etc " />
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>

                                        <?php $catSizes = explode(',', $cat['sizes']); ?>
                                        <?php
                                        if (strlen($catSizes[0]) > 0) {
                                            $SizesDisplay = 'block';
                                        }
                                        else{
                                            $SizesDisplay = 'none';
                                        }
                                        ?>
                                        <div class="row size-block" style="display: <?=$SizesDisplay?>;border-top: 1px solid #eee;margin-top: 10px;padding-top: 10px;">
                                            <label class="col-md-3 label-on-left">Size</label>
                                            <div class="col-md-9" style="padding-top: 20px;padding-bottom: 20px;max-height: 750px;overflow-y: auto;background: #f5f5f5;">
                                                <div class="form-group">
                                                    <input type="checkbox" id="check-all-sizes" checked="checked"> &nbsp;&nbsp;
                                                    <label class="control-label">All</label>
                                                </div>
                                                <?php $Sizes = explode(',', $product->size); ?>
                                                <?php foreach ($sizes as $key => $size): ?>
                                                    <?php if (in_array($size['size_id'], $catSizes)): ?>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <?php if (in_array($size['size_id'], $Sizes)): ?>
                                                                        <input type="checkbox" name="size[]" value="<?=$size['size_id']?>" checked="checked"> &nbsp;&nbsp;
                                                                    <?php else: ?>
                                                                        <input type="checkbox" name="size[]" value="<?=$size['size_id']?>"> &nbsp;&nbsp;
                                                                    <?php endif ?>
                                                                    <label class="control-label"><?=$size['name']?></label>
                                                                </div>
                                                            </div><!-- /4 -->
                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <label>Price</label>
                                                                    <?php
                                                                    $SizePrices = explode(',',$product->size_price);
                                                                    foreach ($SizePrices as $keyCP => $size_price) {
                                                                        $sizePrice = explode('-', $size_price);
                                                                        if ($sizePrice[0] == $size['size_id'] && strlen($sizePrice[1]) > 0) {
                                                                            $sizePriceName = 'name="size_price'.$size['size_id'].'"';
                                                                            $sizePriceValue = 'value="'.$sizePrice[1].'"';
                                                                            break;
                                                                        }
                                                                        else{
                                                                            $sizePriceName = '';
                                                                            $sizePriceValue = 'value="0"';
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <input type="text" data-name="size_price<?=$size['size_id']?>" <?=$sizePriceName?> <?=$sizePriceValue?> class="form-control size-price size-filter-price"> &nbsp;&nbsp;
                                                                </div>
                                                            </div><!-- /8 -->
                                                        </div><!-- {row} -->
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                            </div>
                                        </div>

                                        <div class="row size-block" style="display: <?=$SizesDisplay?>;">
                                            <label class="col-md-3 label-on-left">Size Note Title</label>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="size_note_title" class="form-control" placeholder="Size Note Title" value="<?=$product->size_note_title?>" />
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row size-block" style="display: <?=$SizesDisplay?>;">
                                            <label class="col-md-3 label-on-left">Size Note</label>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="size_note" class="form-control" placeholder="Size Note" value="<?=$product->size_note?>"/>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <?php $catColors = explode(',', $cat['colors']); ?>
                                        <?php
                                        if (strlen($catColors[0]) > 0) {
                                            $ColorsDisplay = 'block';
                                        }
                                        else{
                                            $ColorsDisplay = 'none';
                                        }
                                        ?>
                                        <div class="row color-block" style="display: <?=$ColorsDisplay?>;border-top: 1px solid #eee;border-bottom: 1px solid #eee;margin-top: 10px;margin-bottom: 10px;padding-top: 10px;">
                                            <label class="col-md-3 label-on-left">Color</label>
                                            <div class="col-md-9" style="padding-top: 20px;padding-bottom: 20px;max-height: 750px;overflow-y: auto;background: #f5f5f5;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="checkbox" id="check-all-colors"> &nbsp;&nbsp;
                                                            <label class="control-label">All</label>
                                                        </div>
                                                    </div><!-- /12 -->
                                                </div><!-- {row} -->
                                                <?php $Colors = explode(',', $product->color); ?>
                                                <?php foreach ($colors as $key => $color): ?>
                                                    <?php if (in_array($color['color_id'], $catColors)): ?>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <?php if (in_array($color['color_id'], $Colors)): ?>
                                                                        <input type="checkbox" name="color[]" value="<?=$color['color_id']?>" checked="checked"> &nbsp;&nbsp;
                                                                    <?php else: ?>
                                                                        <input type="checkbox" name="color[]" value="<?=$color['color_id']?>"> &nbsp;&nbsp;
                                                                    <?php endif ?>
                                                                    <label class="control-label"><?=$color['name']?></label>
                                                                </div>
                                                            </div><!-- /2 -->
                                                            <div class="col-md-6">
                                                                <?php $ColorImages = explode(',', $product->color_images); ?>
                                                                <div class="form-group">
                                                                    <input type="file" name="color_file<?=$color['color_id']?>"> &nbsp;&nbsp;
                                                                    <label class="btn" style="cursor: pointer;background: #fff;color: #000;border: 3px solid <?=$color['name']?>;"><?=$color['name']?> Image</label>
                                                                    <?php
                                                                    foreach ($ColorImages as $keyCI => $ColorImage) {
                                                                        $colorImage = explode('-', $ColorImage);
                                                                        if ($colorImage[0] == $color['color_id'] && strlen($ColorImage) > 4) {
                                                                        ?>
                                                                            <input type="hidden" name="color_file_value<?=$color['color_id']?>" value="<?=$ColorImage?>">
                                                                            <img src="<?=base_url('uploads/products/'.$product->category_id.'/'.$ColorImage)?>" style="width: 50px;">
                                                                        <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div><!-- /6 -->
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Price</label>
                                                                    <?php
                                                                    $ColorPrices = explode(',',$product->color_price);
                                                                    foreach ($ColorPrices as $keyCP => $color_price) {
                                                                        $colorPrice = explode('-', $color_price);
                                                                        if ($colorPrice[0] == $color['color_id'] && strlen($colorPrice[1]) > 0) {
                                                                            $colorPriceName = 'name="color_price'.$color['color_id'].'"';
                                                                            $colorPriceValue = 'value="'.$colorPrice[1].'"';
                                                                            break;
                                                                        }
                                                                        else{
                                                                            $colorPriceName = '';
                                                                            $colorPriceValue = 'value="0"';
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <input type="text" data-name="color_price<?=$color['color_id']?>" <?=$colorPriceName?> <?=$colorPriceValue?> class="form-control color-price color-filter-price"> &nbsp;&nbsp;
                                                                </div>
                                                            </div><!-- /4 -->
                                                        </div><!-- {row} -->
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                            </div>
                                        </div>

                                        <div class="row color-block" style="display: <?=$ColorsDisplay?>;">
                                            <label class="col-md-3 label-on-left">Color Note Title</label>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="color_note_title" class="form-control" placeholder="Color Note Title" value="<?=$product->color_note_title?>" />
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row color-block" style="display: <?=$ColorsDisplay?>;">
                                            <label class="col-md-3 label-on-left">Color Note</label>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="color_note" class="form-control" placeholder="Color Note" value="<?=$product->color_note?>"/>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row color-block">
                                            <label class="col-md-3 label-on-left">Which Filter Price To Show *</label>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="control-label"></label>
                                                    <select name="filter_price_show" class="form-control">
                                                        <?php if ($product->filter_price_show == 'color'): ?>
                                                            <option value="none">NONE</option>
                                                            <option value="size">SIZE</option>
                                                            <option value="color" selected="selected">COLOR</option>
                                                        <?php elseif ($product->filter_price_show == 'none'): ?>
                                                            <option value="none" selected="selected">NONE</option>
                                                            <option value="size">SIZE</option>
                                                            <option value="color">COLOR</option>
                                                        <?php else: ?>
                                                            <option value="none">NONE</option>
                                                            <option value="size" selected="selected">SIZE</option>
                                                            <option value="color">COLOR</option>
                                                        <?php endif ?>
                                                    </select>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="dynamic-filters">
                                            
                                            <?=$filters_html?>

                                        </div><!-- /dynamic-filters -->
                                        
                                        <div class="row">
                                            <label class="col-md-3 label-on-left"><?php echo $this->lang->line("Rewards");?> : *</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="rewards" class="form-control" value="<?php echo $product->rewards; ?>"  placeholder="00"/>
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
                                                    <input type="text" name="sku" class="form-control" value="<?=$product->sku?>" placeholder="SKU"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label class="col-md-3 label-on-left">Easy Door SKU</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" name="sku_own" class="form-control" value="<?=$product->sku_own?>" placeholder="Easy Door SKU"/>
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>


                                        <div class="cat-tags-area" style="margin: 10px 0;padding: 10px 0;border-top: 1px solid #eee;border-bottom: 1px solid #eee;">
                                            <?=$tags_html?>
                                        </div><!-- /cat-tags-area -->

                                        <?php if (1==2): ?>
                                            <div class="row" style="margin-top: 50px">
                                                <label class="col-md-3 ">Meta Title *</label>
                                                <div class="col-md-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" name="meta_title" placeholder="Meta Title" class="form-control" value="<?=$product->meta_title?>" />
                                                    <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 50px">
                                                <label class="col-md-3 ">Meta Key Words *</label>
                                                <div class="col-md-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" name="meta_key" placeholder="Meta Key Words" class="form-control" value="<?=$product->meta_key?>" />
                                                    <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 50px">
                                                <label class="col-md-3 ">Meta Description *</label>
                                                <div class="col-md-9">
                                                    <div class="form-group label-floating is-empty">
                                                        <label class="control-label"></label>
                                                        <input type="text" name="meta_desc" placeholder="Meta Description" class="form-control" value="<?=$product->meta_desc?>" />
                                                    <span class="material-input"></span></div>
                                                </div>
                                            </div>
                                        <?php endif ?>


                                        <div class="row">
                                            <label class="col-md-3"></label>
                                            <div class="col-md-9">
                                                <div class="form-group form-button">
                                                    <input type="submit" class="btn btn-fill btn-rose" name="addcatg" value="<?php echo $this->lang->line("Update Product");?>">
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
        md.initSliders()
        demo.initFormExtendedDatetimepickers();
    });
</script>
</html>

<script>
    $(function(){
        $(document).on('change', 'select[name="category_id"]', function(event) {
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
                $(".product-price-diff").val('');
            }
        });
        $(document).on('keyup', '.product-price-diff', function(event) {
            event.preventDefault();
            $price = parseInt($(".product-price").val());
            $diff = parseInt($(".product-price-diff").val());
            $sale = parseFloat($(".product-price-sale").val());
            if ($diff == 0 || isNaN($diff)) {
                $(".product-price-diff").val('');
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

        $(document).on('change', 'select[name="category_id"]', function(event) {
            event.preventDefault();
            $(".size-block,.color-block").fadeOut(0);
            $size = $('select[name="category_id"] option:selected').attr('data-size');
            $color = $('select[name="category_id"] option:selected').attr('data-color');
            if ($size == 'true') {
                $(".size-block").fadeIn(0);
            }
            if ($color == 'true') {
                $(".color-block").fadeIn(0);
            }
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

    })
</script>


<style>
.color-box{
    display: inline-block;
    margin: 3px;
    padding: 3px;
    border: 3px solid #000;
}
</style>