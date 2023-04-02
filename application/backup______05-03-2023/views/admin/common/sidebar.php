<?php 
if($this->session->userdata('language') == "arabic")
{
    echo "<style> .main-panel.ps-container.ps-theme-default.ps-active-y { float: left; } </style>";
?>
<style type="text/css">
    .main-panel.ps-container.ps-theme-default.ps-active-y {
        float: left;
    }
    
    .sidebar[data-background-color="black"] .nav li i, .off-canvas-sidebar[data-background-color="black"] .nav li i {
        color: rgba(255, 255, 255, 0.8);
        float:right;
        margin-left: 10px;
    }
    .card-stats .card-header {
        float: right;
        text-align: center;
    }
    .card .card-header.card-header-icon {
        float: right;
    }
    .card .card-header.card-header-icon + .card-content .card-title {
        padding-bottom: 15px;
        float: right;
    }
    div.dataTables_wrapper div.dataTables_filter {
        text-align: right;
        padding-top:20px;
    }
    .pull-right {
        border: 1px solid purple;
        padding: 2px 25px;
        float: right;
        margin: 0px 20px;
    }
    .animation-transition-general, .sidebar .nav p, .off-canvas-sidebar .nav p, .off-canvas-sidebar .user .photo,  .off-canvas-sidebar .user a, .login-page .card-login, .lock-page .card-profile {
        text-align:right;
    }
    
    @media (min-width: 992px)
    {
        .main-panel {
            float:left;
        }
        .sidebar-mini .main-panel {
            margin-left: 0px;
        }
    }
    .sidebar .nav i, .off-canvas-sidebar .nav i {
        font-size: 24px;
        float: left;
        margin-right: 0px;
        line-height: 30px;
        width: 30px;
        text-align: right;
        color: #a9afbb;
    }
    .paginate_button {
        padding: 5px !important;
    }
    .dataTables_paginate a {
        outline: 0;
        padding: 5px;
    }
    
</style>
<style>
    li.active:focus{ border:none; }
    
    .wrapper {
    position: relative;
    top: 0;
    height: 109vh !important;
}
</style>
<?php
}
?>

<div class="sidebar" data-active-color="rose" data-background-color="black" data-image="<?php echo base_url($this->config->item("new_theme")."/assets/img/sidebar-1.jpg"); ?> " 
<?php if($this->session->userdata('language') == "arabic"){ echo 'style="left: unset;right: 0"'; } ?> >
            <!--
            Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
            Tip 2: you can also add an image using data-image tag
            Tip 3: you can change the color of the sidebar with data-background-color="white | black"-->
    <!--        <style>-->
    <!--            .card [data-background-color="purple"] {-->
    <!--background: linear-gradient(60deg, #ffc138, #ffc138);-->
    <!--            }-->
    <!--            .active1{-->
    <!--                background-color: #ffc138 !important;-->
    <!--            }-->
                
    <!--            .sidebar[data-active-color="rose"] li.active > a, .off-canvas-sidebar[data-active-color="rose"] li.active > a {-->
    <!--background-color: #ffc138;-->
    <!--        </style>-->
            
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            
            <script type="text/javascript">
	$(function(){
		$('.nav a').filter(function(){return this.href==location.href}).parent().addClass('active').siblings().removeClass('active')
		$('.nav a').click(function(){
			$(this).parent().addClass('active').siblings().removeClass('active')	
		})
	})
	</script>
            <div class="logo" style="padding:0px">
                <a href="<?php echo $this->config->item('base_url');?>" class="simple-text"  style="padding:0px">
                    <img src="<?php echo $this->config->item('base_url').'/uploads/download.png' ; ?>" width="100%" alt=""  style="padding:0px">
                </a>
            </div>
            <div class="logo logo-mini"  style="padding:0px">
                <a href="<?php echo $this->config->item('base_url'); ?>" class="simple-text" style="padding:0px">
                    <img src="<?php echo $this->config->item('base_url').'/uploads/download.png' ; ?>" width="100%" alt=""  style="padding:0px">
                </a>
            </div>
            <div class="sidebar-wrapper">
                <div class="user">
                    <div class="photo">
                        <?php 
                            $z = _get_current_user_id($this);
                            $img=$this->db->query("SELECT * FROM `users` where user_id='".$z."' ") ;
                            $image= $img->result();
                            //echo $z;
                            foreach($image as $row){
                        ?>
                        <img src="<?php echo $this->config->item('base_url').'/uploads/profile/'.$row->user_image ?>" />
                        <?php } ?>
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <?php echo ""._get_current_user_name($this)."" ; ?>
                            <b class="caret"></b>
                        </a>
                        <div class="collapse" id="collapseExample">
                            <ul class="nav">
                                <!--li>
                                    <a href="#">My Profile</a>
                                </li-->
                                <li>
                                    <a href="<?php echo site_url("users/edit_mainuser/"._get_current_user_id($this)); ?>" ><?php echo $this->lang->line("Edit Profile");?></a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url("admin/signout") ?>" ><?php echo $this->lang->line("Log Out");?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav">
                    <li>
                        <a href="<?php echo site_url("admin/dashboard"); ?>" >
                            <i class="material-icons">dashboard</i>
                            <p><?php echo $this->lang->line("dashboard");?></p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/orders"); ?>">
                            <i class="material-icons">play_for_work</i>
                            <p>
                                <?php
                                $NewOrders_ = $this->db->query("SELECT COUNT(`sale_id`) AS Count FROM `sale` WHERE `status` = '0'");
                                $NewOrder = $NewOrders_->result();
                                if ($NewOrder[0]->Count > 0) {
                                    echo 'Orders ('.$NewOrder[0]->Count.')';
                                }
                                else{
                                    echo $this->lang->line("Orders");  
                                }
                                ?>
                            </p>

                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/order_reports"); ?>">
                            <i class="material-icons">timeline</i>
                            <p>Order Reports</p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/listcategories"); ?>">
                            <i class="material-icons">category</i>
                            <p><?php echo $this->lang->line("Categories");?></p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/products"); ?>">
                            <i class="material-icons"> restaurant_menu</i>
                            <p><?php echo $this->lang->line("Products");?></p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/product_images_bulk"); ?>">
                            <i class="material-icons"> restaurant_menu</i>
                            <p>Product Bulk Images</p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/registers"); ?>">
                            <i class="material-icons">smartphone</i>
                            <p>Customers</p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/brands"); ?>">
                            <i class="material-icons">stores</i>
                            <p>brands</p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/sellers"); ?>">
                            <i class="material-icons">stores</i>
                            <p>
                            <?php
                            $sellerNew = $this->db->query("SELECT COUNT(`seller_id`) AS Count FROM `seller` WHERE `status` = 'new'");
                            $sellerNew = $sellerNew->result();
                            if ($sellerNew[0]->Count > 0) {
                                echo 'Sellers ('.$sellerNew[0]->Count.')';
                            }
                            else{
                                echo 'Sellers';
                            }
                            ?>
                            </p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/sizes"); ?>">
                            <i class="material-icons">smartphone</i>
                            <p>Sizes</p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/colors"); ?>">
                            <i class="material-icons">smartphone</i>
                            <p>Colors</p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/sms_setting"); ?>">
                            <i class="material-icons">smartphone</i>
                            <p>SmS Setting</p>
                        </a>
                    </li>
                    <?php if (1==2): ?>
                        <li class="">
                            <a href="<?php echo site_url("admin/food_cats"); ?>">
                                <i class="material-icons">category</i>
                                <p>food cats</p>
                            </a>
                        </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/stores"); ?>">
                            <i class="material-icons">pin_drop</i>
                            <p>stores</p>
                        </a>
                    </li>
                    <?php endif ?>
                    <li class="">
                        <a href="<?php echo site_url("admin/filters"); ?>">
                            <i class="material-icons"> theaters</i>
                            <p>Filters</p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/email_templates"); ?>">
                            <i class="material-icons"> theaters</i>
                            <p>Email Templates</p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/setting"); ?>">
                            <i class="material-icons">timeline</i>
                            <p><?php echo $this->lang->line("Order Limit Setting");?></p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/socity"); ?>">
                            <i class="material-icons">pin_drop</i>
                            <p><?php echo $this->lang->line("Socity");?></p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/city"); ?>">
                            <i class="material-icons">map</i>
                            <p><?php echo $this->lang->line("City");?></p>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#pagesExamples">
                            <i class="material-icons">alarm</i>
                            <p><?php echo $this->lang->line("Delivery Schedule Hours");?>
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="pagesExamples">
                            <ul class="nav">
                                <li>
                                    <a href="<?php echo site_url("admin/time_slot"); ?>"> <?php echo $this->lang->line("Time Slot");?></a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url("admin/closing_hours"); ?>"><?php echo $this->lang->line("Closing Hours");?></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/add_purchase"); ?>">
                            <i class="material-icons">restore_from_trash</i>
                            <p><?php echo $this->lang->line("Stock Update");?></p>
                        </a>
                    </li>
                    <?php if (1==2): ?>
                    <li class="">
                        <a href="<?php echo site_url("admin/food_orders"); ?>">
                            <i class="material-icons">play_for_work</i>
                            <p>Food Orders</p>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#StoreManagement">
                            <i class="material-icons">store_mall_directory</i>
                            <p><?php echo $this->lang->line("Store Management");?>
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="StoreManagement">
                            <ul class="nav">
                                <li>
                                    <a href="<?php echo site_url("users"); ?>"> <?php echo $this->lang->line("List Store Users");?></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <?php endif ?>
                    <li>
                        <a data-toggle="collapse" href="#Pages">
                            <i class="material-icons">file_copy</i>
                            <p><?php echo $this->lang->line("Pages");?>
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="Pages">
                            <ul class="nav">
                                <li>
                                    <a href="<?php echo site_url("admin/allpageapp"); ?>"> <?php echo $this->lang->line("List");?></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/declared_rewards"); ?>">
                            <i class="material-icons">stars</i>
                            <p><?php echo $this->lang->line("Declared Reward Value");?></p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/stock"); ?>">
                            <i class="material-icons">perm_data_setting</i>
                            <p><?php echo $this->lang->line("Stock");?></p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/notification"); ?>">
                            <i class="material-icons">notifications_active</i>
                            <p><?php echo $this->lang->line("Notification");?></p>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#Slider">
                            <i class="material-icons">perm_media</i>
                            <p><?php echo $this->lang->line("Slider");?>
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="Slider">
                            <ul class="nav">
                                <li>
                                    <a href="<?php echo site_url("admin/listslider"); ?>"><?php echo $this->lang->line("Main Slider");?></a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url("admin/banner"); ?>"><?php echo $this->lang->line("Secondary Slider");?></a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url("admin/feature_banner"); ?>"><?php echo $this->lang->line("Feature Brand Slider");?></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="<?php echo site_url("admin/coupons"); ?>">
                            <i class="material-icons">theaters</i>
                            <p><?php echo $this->lang->line("Coupons");?></p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/faqs"); ?>">
                            <i class="material-icons"> theaters</i>
                            <p>FAQs</p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/ad"); ?>">
                            <i class="material-icons"> theaters</i>
                            <p>AD</p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/newsletter"); ?>">
                            <i class="material-icons"> theaters</i>
                            <p>Newsletter</p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/testimonials"); ?>">
                            <i class="material-icons"> theaters</i>
                            <p>Testimonials</p>
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo site_url("admin/blog"); ?>">
                            <i class="material-icons"> theaters</i>
                            <p>Blog</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url("admin/dealofday"); ?>">
                            <i class="material-icons">date_range</i>
                            <p><?php echo $this->lang->line("Deal Products");?></p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url("admin/mobile_number"); ?>">
                            <i class="material-icons">phonelink_setup</i>
                            <p>App Mobile No.</p>
                        </a>
                    </li>
                    <!--li>
                        <a href="<?php echo site_url("admin/ads"); ?>">
                            <i class="material-icons">aspect_ratio</i>
                            <p>Ads</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url("admin/payment"); ?>">
                            <i class="material-icons">payment</i>
                            <p>Payment Details</p>
                        </a>
                    </li-->
                    <li>
                        <a href="<?php echo site_url("admin/help"); ?>">
                            <i class="material-icons">info</i>
                            <p><?php echo $this->lang->line("Raise a Ticket");?></p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>