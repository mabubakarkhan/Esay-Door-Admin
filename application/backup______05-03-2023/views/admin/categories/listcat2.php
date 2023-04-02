<!doctype html>
<html lang="en">


<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/examples/tables/datatables.net.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2017 21:34:01 GMT -->
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/apple-icon.png"); ?>" />
    <link rel="icon" type="image/png" href="<?php echo base_url($this->config->item("new_theme")."/assets/img/favicon.png"); ?>" />
    <title></title>
    <!-- Canonical SEO -->
    <link rel="canonical" href="//www.creative-tim.com/product/material-dashboard-pro" />

    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url($this->config->item("new_theme")."/assets/css/bootstrap.min.css"); ?>" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

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
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title" ><?php echo $this->lang->line("All Categories");?></h4>
                                    <a class="pull-right" style="" href="<?php echo site_url("admin/addcategories"); ?>">
                                        <?php echo $this->lang->line("ADD");?>
                                    </a>
                                    <a class="pull-right" href="<?=site_url('admin/product_bulk_products_file/')?>" style="margin:  0px 30px 10px 0px;padding: 0px 10px;border: 1px solid;" target="_blank">Upload Bulk Products</a>
                                    <a class="pull-right" href="<?=site_url('admin/upload_filters_to_category/')?>" style="margin:  0px 30px 10px 0px;padding: 0px 10px;border: 1px solid;" target="_blank">Upload Filters To Category</a>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th><?php echo $this->lang->line("Cat ID");?></th>
                                                    <th><?php echo $this->lang->line("cat title");?></th>
                                                    <th><?php echo $this->lang->line("Parent Category");?></th>
                                                    <th>Level</th>
                                                    <th>Child Category</th>
                                                    <th>Products</th>
                                                    <th>Filters</th>
                                                    <th>Tags</th>
                                                    <th>Colors/Sizes</th>
                                                    <th><?php echo $this->lang->line("Image");?></th>
                                                    <th><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-right"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th><?php echo $this->lang->line("Cat ID");?></th>
                                                    <th><?php echo $this->lang->line("cat title");?></th>
                                                    <th><?php echo $this->lang->line("Parent Category");?></th>
                                                    <th>Level</th>
                                                    <th>Child Category</th>
                                                    <th>Products</th>
                                                    <th>Filters</th>
                                                    <th>Tags</th>
                                                    <th>Colors/Sizes</th>
                                                    <th><?php echo $this->lang->line("Image");?></th>
                                                    <th><?php echo $this->lang->line("Status");?></th>
                                                    <th class="text-right"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach($allcat as $acat){ ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $acat->id; ?></td>
                                                    <td><?php echo $acat->title; ?></td>
                                                    <td><?php   if($acat->prtitle!=""){  echo $acat->prtitle; }else { echo "________"; }?></td>
                                                    <td><?php echo $acat->leval+1; ?></td>
                                                    <td><a href="<?=site_url('admin/add_cat_child/'.$acat->id.'/')?>" target="_blank">Add Child</a></td>
                                                    <td><a href="<?=site_url('admin/products/'.$acat->id.'/')?>" target="_blank">Products</a></td>
                                                    <td><a href='javascript://' class="get-filters" data-id="<?php echo $acat->filter_ids; ?>" data-catid="<?php echo $acat->id; ?>" data-title="<?php echo $acat->title; ?>">Explore</a></td>
                                                    <td><a href="<?=site_url("admin/cattags/".$acat->id)?>" target="_blank">Explore</a></td>
                                                    <!-- <td><?php if($acat->image!=""){ ?><div class="cat-img" style="width: 50px; height: 50px;"><img width="100%" height="100%" src="<?php echo $this->config->item('base_url').'uploads/category/'.$acat->image; ?>" /></div> <?php } ?></td> -->
                                                    <td>
                                                        <a href="javascript://" data-id="<?=$acat->id?>" class="get-colors">Colors</a> <br>
                                                        <a href="javascript://" data-id="<?=$acat->id?>" class="get-sizes">Sizes</a>
                                                    </td>
                                                    <td><?php if(strlen($acat->image) > 4){ ?> Yes <?php } else { ?> NO <?php } ?></td>
                                                    
                                                    <td><?php if($acat->status == "1"){ ?><span class="label label-success"> <?php echo $this->lang->line("Active");?></span><?php } else { ?><span class="label label-danger"> <?php echo $this->lang->line("Deactive");?></span><?php } ?></td>

                                                    <td class="td-actions text-right">
                                                        <div class="btn-group">
                                                            <?php echo anchor('admin/editcategory/'.$acat->id, '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                            <i class="material-icons">edit</i>
                                                            </button>', array("class"=>"")); ?>

                                                            <?php echo anchor('admin/deletecat/'.$acat->id, '<button type="button" rel="tooltip" class="btn btn-danger btn-round">
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

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">


    $(document).ready(function() {
        $('select[name="filter[]"]').select2();
    });


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


        $(document).on('click', '.get-filters', function(event) {
            event.preventDefault();
            $id = $(this).attr('data-id');
            $catId = $(this).attr('data-catid');
            $("#modal-filters .edit-filter-for-cat").attr('data-id',$catId);
            $("#modal-filters .edit-filter-for-cat").attr('data-filters',$id);
            $("#modal-filters .add-filter-for-cat").attr('data-id',$catId);
            if (!($id.length > 0)) {
                $id = 0;
            }
            $title = $(this).attr('data-title');

            $("#modal-filters .modal-title").text($title);
            $("#modal-filters table tbody").html('<tr><td colspan="2">Loading...</td></tr>');
            $("#modal-filters").modal('show');

            $("#modal-filters-edit .modal-title").text($title);
            $("#modal-filters-add .modal-title").text($title);
            
            $.post('<?=site_url("admin/get_filters_by_catid")?>', {id: $id, cat: $catId}, function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == true) {
                    $("#modal-filters table tbody").html(resp.html);
                }
                else{
                    $("#modal-filters table tbody").html('<tr><td colspan="2">No Filter Found</td></tr>');
                }
            });
        });

        $(document).on('click', '.edit-filter-for-cat', function(event) {
            event.preventDefault();
            $catId = $(this).attr('data-id');
            $filters = $(this).attr('data-filters');
            $.post('<?=site_url("admin/get_filters_for_edit")?>', {id: $filters,cat:$catId}, function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == true) {
                    $("#modal-filters-edit .modal-body form").html(resp.html);
                    $("#modal-filters-edit").modal('show');
                }
                else{
                    alert(resp.msg);
                }
            });
        });//edit-filter-for-cat

        $(document).on('submit', '#modal-filters-edit form', function(event) {
            event.preventDefault();
            $this = $(this);
            $.post('<?=site_url("admin/submit_cat_filters_ajax")?>', {data: $this.serialize()}, function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == true) {
                    $("#modal-filters table tbody").html(resp.html);
                }
                else{
                    if ($resp.error == 2) {
                        $("#modal-filters table tbody").html('');
                    }
                    alert(resp.msg);
                }
            });
        });

        $(document).on('click', '.add-filter-for-cat', function(event) {
            event.preventDefault();
            $catId = $(this).attr('data-id');
            $.post('<?=site_url("admin/get_filters_for_add")?>', {id:$catId}, function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == true) {
                    $("#modal-filters-add .modal-body input[name='cat_id']").val($catId);
                    $("#modal-filters-add .modal-body form select").html(resp.html);
                    $("#modal-filters-add").modal('show');
                }
                else{
                    alert('No more filters for add');
                }
            });
        });//edit-filter-for-cat

        $(document).on('submit', '#modal-filters-add form', function(event) {
            event.preventDefault();
            $this = $(this);
            $.post('<?=site_url("admin/post_cat_filters_ajax")?>', {data: $this.serialize()}, function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == true) {
                    $("#modal-filters table tbody").html(resp.html);
                }
                else{
                    if ($resp.error == 2) {
                        $("#modal-filters table tbody").html('');
                    }
                    alert(resp.msg);
                }
                $("#modal-filters-add").modal('hide');
            });
        });

        $(document).on('click', '.delete-value', function(event) {
            event.preventDefault();
            $this = $(this);
            $id = $(this).attr('data-id');
            $.post('<?=site_url("admin/delete_filter_value")?>', {id: $id}, function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == true) {
                    $this.parent('td').parent('tr').remove();
                }
                else{
                    alert('not deleted pls try again');
                }
            });
        });

        $(document).on('click', '.get-colors', function(event) {
            event.preventDefault();
            $id = $(this).attr('data-id');
            $.post('<?=site_url("admin/get_cat_colors")?>', {id: $id}, function(resp) {
                resp = $.parseJSON(resp);
                if (resp.status == true) {
                    $("#modal-colors input[name='id']").val($id);
                    $("#modal-colors .modal-title").text(resp.title);
                    $("#modal-colors .row").html(resp.html);
                    $("#modal-colors").modal('show');
                }
                else{
                    alert(resp.msg);
                }
            });
        });

        $(document).on('submit', 'form.colors-form', function(event) {
            event.preventDefault();
            $form = $(this);
            $.post('<?=site_url("admin/update_cat_colors")?>', {data: $form.serialize()}, function(resp) {
                resp = $.parseJSON(resp);
                alert(resp.msg);
            });
        });

        $(document).on('click', '.get-sizes', function(event) {
            event.preventDefault();
            $id = $(this).attr('data-id');
            $.post('<?=site_url("admin/get_cat_sizes")?>', {id: $id}, function(resp) {
                resp = $.parseJSON(resp);
                if (resp.status == true) {
                    $("#modal-sizes input[name='id']").val($id);
                    $("#modal-sizes .modal-title").text(resp.title);
                    $("#modal-sizes .row").html(resp.html);
                    $("#modal-sizes").modal('show');
                }
                else{
                    alert(resp.msg);
                }
            });
        });

        $(document).on('submit', 'form.sizes-form', function(event) {
            event.preventDefault();
            $form = $(this);
            $.post('<?=site_url("admin/update_cat_sizes")?>', {data: $form.serialize()}, function(resp) {
                resp = $.parseJSON(resp);
                alert(resp.msg);
            });
        });

    });
</script>

</html>



<div class="modal fade" id="modal-filters">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal title</h4>
            </div><!-- /modal-header -->
            <div class="modal-body">
                <a href="javascript://" class="edit-filter-for-cat btn btn-info" data-id="" data-filters="">Edit Filters</a>
                <a href="javascript://" class="add-filter-for-cat btn btn-success" data-id="">Add Filters</a>
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Admin Title</th>
                        <th>Title</th>
                        <th>Values</th>
                    </thead>
                    <tbody>
                        <tr><td colspan="2">Loading...</td></tr>
                    </tbody>
                </table>    
            </div><!-- /modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div><!-- /modal-footer -->
        </div><!-- /modal-content -->
    </div><!-- /modal-dialog -->
</div><!-- /modal-filters -->


<div class="modal fade" id="modal-filters-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal title</h4>
            </div><!-- /modal-header -->
            <div class="modal-body">
                <form action="">

                    <input type="hidden" name="cat_id">
                    <div class="form-group">
                        <input type="checkbox" name="filter_ids[]" value="2">
                        <label>Filter 2</label>
                    </div><!-- /form-group -->
                
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div><!-- /form-group -->

                </form>
            </div><!-- /modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div><!-- /modal-footer -->
        </div><!-- /modal-content -->
    </div><!-- /modal-dialog -->
</div><!-- /modal-filters -->

<div class="modal fade" id="modal-filters-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal title</h4>
            </div><!-- /modal-header -->
            <div class="modal-body">
                <form action="">

                    <input type="hidden" name="cat_id">
                    <div class="form-group">
                        <label>Filters</label>
                        <select name="filter[]" class="form-control" multiple style="width: 500px;" required="required">
                            <option value="1">Filter 1</option>
                        </select>
                    </div><!-- /form-group -->
                
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Add</button>
                    </div><!-- /form-group -->

                </form>
            </div><!-- /modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div><!-- /modal-footer -->
        </div><!-- /modal-content -->
    </div><!-- /modal-dialog -->
</div><!-- /modal-filters -->


<div class="modal fade" id="modal-colors">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cat Colors</h4>
            </div><!-- /modal-header -->
            <div class="modal-body">
                <form class="colors-form">

                    <input type="hidden" name="id">

                    <div class="container" style="width:100%;">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="checkbox" name="color[]">
                                    <label>Color 1</label>
                                </div><!-- /form-group -->
                            </div><!-- /6 -->

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div><!-- /form-group -->
                            </div><!-- /12 -->

                        </div><!-- /row -->
                    </div><!-- /container -->
                

                </form>
            </div><!-- /modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div><!-- /modal-footer -->
        </div><!-- /modal-content -->
    </div><!-- /modal-dialog -->
</div><!-- /modal-filters -->


<div class="modal fade" id="modal-sizes">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cat Sizes</h4>
            </div><!-- /modal-header -->
            <div class="modal-body">
                <form class="sizes-form">

                    <input type="hidden" name="id">

                    <div class="container" style="width:100%;">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="checkbox" name="color[]">
                                    <label>Color 1</label>
                                </div><!-- /form-group -->
                            </div><!-- /6 -->

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div><!-- /form-group -->
                            </div><!-- /12 -->

                        </div><!-- /row -->
                    </div><!-- /container -->
                

                </form>
            </div><!-- /modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div><!-- /modal-footer -->
        </div><!-- /modal-content -->
    </div><!-- /modal-dialog -->
</div><!-- /modal-filters -->
