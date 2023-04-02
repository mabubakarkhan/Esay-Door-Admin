<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/apple-icon.png"); ?>" />
    <link rel="icon" type="image/png" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/favicon.png"); ?>" />
    <title></title>
    <!-- Canonical SEO -->
    <link rel="canonical" href="//www.creative-tim.com/product/material-dashboard-pro" />

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
        <!--sider -->
        <?php  $this->load->view("admin/common/sidebar"); ?>
        
        <div class="main-panel">
            <!--head -->
            <?php  $this->load->view("admin/common/header"); ?>
            <!--content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('success_req'); ?>
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo $this->lang->line("All Coupon List");?></h4>
                                    <a class="btn btn-primary" data-toggle="modal" href='#modal-add-deal'>Add Deal</a>
                                    <!--a class="pull-right" href="<?php echo site_url(""); ?>">ADD NEW STORE</a-->
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Title</th>
                                                    <th class="text-center">Start</th>
                                                    <th class="text-center">End</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center" style="width: 100px;"> <?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                     <th class="text-center">Title</th>
                                                    <th class="text-center">Start</th>
                                                    <th class="text-center">End</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center" style="width: 100px;"> <?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach($products as $q){ ?>
                                                    <tr>
                                                        <td class="text-center"><?=$q['title']?></td>
                                                        <td class="text-center"><?=$q['start']?></td>
                                                        <td class="text-center"><?=$q['end']?></td>
                                                        <td class="text-center"><?='Status'?></td>
                                                        
                                                        <td class="td-actions text-center">
                                                            <div class="">
                                                                <button type="button" rel="tooltip" class="btn btn-success btn-round edit-deal" data-id="<?=$q['deal_id']?>">
                                                                    <i class="material-icons">edit</i>
                                                                </button>
                                                                <?php echo anchor('admin/delete_deal_product/'.$q['deal_id'], '<button type="button" rel="tooltip" class="btn btn-danger btn-round">
                                                                    <i class="material-icons">close</i>
                                                                </button>', array("class"=>"", "onclick"=>"return confirm('Are you sure delete?')")); ?>
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
                    <!-- end row -->
                </div>
            </div>
            <!--footer -->
            <?php  $this->load->view("admin/common/footer"); ?>
        </div>
    </div>
    <!--fixed -->
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
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
        });


        var table = $('#datatables').DataTable();

        // Edit record
        table.on('click', '.edit', function() {
            $tr = $(this).closest('tr');

            var data = table.row($tr).data();
            alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        });

        // Delete a record
        table.on('click', '.remove', function(e) {
            $tr = $(this).closest('tr');
            table.row($tr).remove().draw();
            e.preventDefault();
        });

        //Like record
        table.on('click', '.like', function() {
            alert('You clicked on Like button');
        });

        $('.card .material-datatables label').addClass('form-group');
    });
</script>

</html>





<div class="modal fade" id="modal-add-deal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create New Deal</h4>
            </div><!-- /modal-header -->
            <div class="modal-body">
                <form action="<?php echo base_url(); ?>index.php/admin/post_deal" method="post">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="datetime-local" name="start" class="form-control" required>
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="datetime-local" name="end" class="form-control" required>
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <h3>Products</h3>
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <label>Enter Minimum Discount Required (10%)</label>
                        <select class="form-control required-percentage" name="discount" required>
                            <option value="">Select Min Discount</option>
                            <?php
                            for ($i=1; $i < 21; $i++) { 
                            ?>
                                <option value="<?=5*$i?>"><?=5*$i?> %</option>
                            <?php
                            }
                            ?>
                        </select>
                    </div><!-- /form-group -->
                    <div class="form-group products-block">
                        
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <button class="btn btn-success">Create</button>
                    </div><!-- /form-group -->
                </form>
            </div><!-- /modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div><!-- /modal-footer -->
        </div><!-- /modal-content -->
    </div><!-- /modal-dialog -->
</div><!-- /modal-add-deal -->

<div class="modal fade" id="modal-edit-deal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create New Deal</h4>
            </div><!-- /modal-header -->
            <div class="modal-body">
                <form action="<?php echo base_url(); ?>index.php/admin/update_deal" method="post">
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="text" name="start" class="form-control" required>
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="text" name="end" class="form-control" required>
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <h3>Products</h3>
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <label>Enter Minimum Discount Required (10%)</label>
                        <select class="form-control required-percentage" name="discount" required>
                            <option value="">Select Min Discount</option>
                            <?php
                            for ($i=1; $i < 21; $i++) { 
                            ?>
                                <option value="<?=5*$i?>"><?=5*$i?> %</option>
                            <?php
                            }
                            ?>
                        </select>
                    </div><!-- /form-group -->
                    <div class="form-group products-block">
                        
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <button class="btn btn-success">Update</button>
                    </div><!-- /form-group -->
                </form>
            </div><!-- /modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div><!-- /modal-footer -->
        </div><!-- /modal-content -->
    </div><!-- /modal-dialog -->
</div><!-- /modal-edit-deal -->







<script>
$(function(){
    $(document).on('change', '#modal-add-deal .required-percentage', function(event) {
        event.preventDefault();
        $("#modal-add-deal .products-block").html('Loading..');
        $discount = $(this).val();
        $discount = parseInt($discount);
        if ($discount > 0) {
            $.post('<?php echo base_url(); ?>index.php/admin/get_products_for_deal', {discount: $discount}, function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == true) {
                    $("#modal-add-deal .products-block").html(resp.html);
                }
                else{
                    $("#modal-add-deal .products-block").html('no product found');
                }
            });
        }
        else{
            $("#modal-add-deal .products-block").html('');
        }
    });
    $(document).on('change', '.modal-edit-deal .required-percentage', function(event) {
        event.preventDefault();
        $("#modal-edit-deal .products-block").html('Loading..');
        $discount = $(this).val();
        $discount = parseInt($discount);
        if ($discount > 0) {
            $.post('<?php echo base_url(); ?>index.php/admin/get_products_for_deal', {discount: $discount}, function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == true) {
                    $("#modal-edit-deal .products-block").html(resp.html);
                }
                else{
                    $("#modal-edit-deal .products-block").html('no product found');
                }
            });
        }
        else{
            $("#modal-edit-deal .products-block").html('');
        }
    });

    $(document).on('click', '.edit-deal', function(event) {
        event.preventDefault();
        $id = $(this).attr('data-id');
        $.post('<?php echo base_url(); ?>index.php/admin/get_deal_for_edit', {id: $id}, function(resp) {
            resp = JSON.parse(resp);
            if (resp.status == true) {
                $("#modal-edit-deal input[name='id']").val($id);
                $("#modal-edit-deal input[name='title']").val(resp.data.title);
                $("#modal-edit-deal input[name='start']").val(resp.data.start);
                $("#modal-edit-deal input[name='end']").val(resp.data.end);
                $("#modal-edit-deal select[name='discount']").html(resp.options);
                $("#modal-edit-deal .products-block").html(resp.html);
                $("#modal-edit-deal").modal('show')
            }
            else{
                alert('Nothing found');
            }
        });
    });



    });//onload
</script>















