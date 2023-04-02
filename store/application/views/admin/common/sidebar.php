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
        text-align: left;
    }
    .pull-right {
        border: 1px solid purple;
        padding: 2px 25px;
        float: right;
        margin: 0px 20px;
    }
    .animation-transition-general, .sidebar .nav p, .off-canvas-sidebar .nav p, .off-canvas-sidebar .user .photo,  .off-canvas-sidebar .user a, .login-page .card-login, .lock-page .card-profile {
        margin-left: 45px;
    }
    .pagination > li > a, .pagination > li > span {
            padding: 0px 11px !important;
    }
    
</style>
<?php
}
?>

<div class="sidebar" data-active-color="rose" data-background-color="black" data-image="<?php echo base_url($this->config->item("new_theme")."/assets/img/sidebar-1.jpg"); ?> " <?php if($this->session->userdata('language') == "arabic"){ echo 'style="left: unset;right: 0"'; } ?> >
            <!--
            Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
            Tip 2: you can also add an image using data-image tag
            Tip 3: you can change the color of the sidebar with data-background-color="white | black"-->
            <style>
                .card [data-background-color="purple"] {
    background: linear-gradient(60deg, #ffc138, #ffc138);
                }
                .active1{
                    background-color: #ffc138 !important;
                }
                
                .sidebar[data-active-color="rose"] li.active > a, .off-canvas-sidebar[data-active-color="rose"] li.active > a {
    background-color: #ffc138;
            </style>
            
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            
            <script type="text/javascript">
	$(function(){
		$('.nav a').filter(function(){return this.href==location.href}).parent().addClass('active').siblings().removeClass('active')
		$('.nav a').click(function(){
			$(this).parent().addClass('active').siblings().removeClass('active')	
		})
	})
	</script>
            
            <div class="sidebar-wrapper">
                <div class="user">
                    <div class="photo">
                        <?php
                          $q = $this->db->query("Select * from `store_login` where `user_id`='"._get_current_user_id($this)."'");
                          $row=$q->row();
                          
                        ?>
                        <img src="<?= $row->user_image; ?>" />
                        
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <?php _get_current_user_name($this); ?>
                            <b class="caret"></b>
                        </a>
                        <div class="collapse" id="collapseExample">
                            <ul class="nav">
                                <!--li>
                                    <a href="#">My Profile</a>
                                </li-->
                                <li>
                                    <a href="<?php echo site_url("users/edit_store_user/"._get_current_user_id($this)); ?>" ><?php echo $this->lang->line("Edit Profile");?></a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url("admin/signout") ?>" ><?php echo $this->lang->line("Log Out");?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav ">
                    <li class="header"> </li>
            <li class="active treeview">
              <a href="<?php echo site_url("admin/dashboard"); ?>">
                <i class="fa fa-dashboard"></i> <span> <?php echo $this->lang->line("Dashboard");?></span>
              </a>
            </li>
            <?php if(_get_current_user_type_id($this)==0){ ?>
            <!--<li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Common Settings</span>
                <span class="label label-primary pull-right"></span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> User Settings</a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo site_url("admin/user_types"); ?>"><i class="fa fa-circle-o"></i> User Types</a></li>
                        
                    </ul>
                </li>
               
              </ul>
             </li>-->
            <li>
              <a href="<?php echo site_url("admin/registers"); ?>">
                <i class="fa fa-mobile"></i> <span> <?php echo $this->lang->line("App Users");?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li>
           <!--  <li>
              <a href="<?php echo site_url("admin/listcategories"); ?>">
                <i class="fa fa-list"></i> <span> <?php echo $this->lang->line("Categories");?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li> -->
          <!--   <li>
              <a href="<?php echo site_url("admin/socity"); ?>">
                <i class="fa fa-map-signs"></i> <span> <?php echo $this->lang->line("Socity");?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li> -->
            <li>
              <a href="<?php echo site_url("admin/products"); ?>">
                <i class="fa fa-list-alt"></i> <span> <?php echo $this->lang->line("Products");?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li>
         <!--     <li>
              <a href="#">
                <i class="fa fa-clock-o"></i> <span> <?php echo $this->lang->line("Delivery Schedule Hours");?></span><i class="fa fa-angle-left pull-right"></i></small>
              </a>
              <ul class="treeview-menu">
                    <li>
                      <a href="<?php echo site_url("admin/time_slot"); ?>">
                        <i class="fa fa-clock-o"></i> <span> <?php echo $this->lang->line("Time Slot");?></span> <small class="label pull-right bg-green"></small>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo site_url("admin/closing_hours"); ?>">
                        <i class="fa fa-clock-o"></i> <span> <?php echo $this->lang->line("Closing Hours");?></span> <small class="label pull-right bg-green"></small>
                      </a>
                    </li>
                </ul>
            </li> -->
            <li>
              <a href="<?php echo site_url("admin/add_purchase"); ?>">
                <i class="fa fa-shopping-cart"></i> <span> <?php echo $this->lang->line("Stock Update");?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("admin/orders"); ?>">
                <i class="fa fa-slack"></i> <span> <?php echo $this->lang->line("Orders_name");?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li>
            
         <!--    <li>
              <a href="#">
                <i class="fa fa-users"></i> <span> <?php echo "Store Management";?></span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu"> 
                        <li><a href="<?php echo site_url("users"); ?>"><i class="fa fa-circle-o"></i>
                         <?php echo "List Store Users";?></a></li>
                        
                        
              </ul>
            </li> 
            
            <li>
              <a href="#">
                <i class="fa fa-file"></i> <span> <?php echo $this->lang->line("Pages");?></span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                         <li><a href="<?php echo site_url("admin/allpageapp"); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line("List");?></a></li>
                        
              </ul>
            </li>
            
             <li>
              <a href="<?php echo site_url("admin/setting"); ?>">
                <i class="fa fa-cogs"></i> <span> <?php echo $this->lang->line("Order Limit Setting");?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li> -->
             <li>
              <a href="<?php echo site_url("admin/stock"); ?>">
                <i class="fa fa-sticky-note-o"></i> <span> <?php echo $this->lang->line("Stock");?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li> 
           <!--  <li>
              <a href="<?php echo site_url("admin/notification"); ?>">
                <i class="fa fa-bell"></i> <span> <?php echo $this->lang->line("Notification");?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li> 
             <li class="treeview">
              <a href="#">
                <i class="fa fa-picture-o"></i>
                <span> <?php echo $this->lang->line("Slider");?> </span>
                <span class="label label-primary pull-right"></span><i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo site_url("admin/listslider"); ?>"><i class="fa fa-circle-o"></i>  <?php echo $this->lang->line("List");?> </a></li>
                <li><a href="<?php echo site_url("admin/addslider"); ?>"><i class="fa fa-circle-o"></i>  <?php echo $this->lang->line("Add New");?>  </a></li>
              </ul>
            </li> -->
             <li>
              <a href="<?php echo site_url("users"); ?>">
                <i class="fa fa-users"></i> <span> <?php echo $this->lang->line("Add Delivery Boy");?></span> 
                
              </a>
              
            </li>
            <?php  } ?>
             
                </ul>
            </div>
        </div>