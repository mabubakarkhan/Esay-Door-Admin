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
                                    <h4 class="card-title" >Filters</h4>
                                    <a class="pull-right" style="" href="<?php echo site_url("admin/addfilter"); ?>">
                                        <?php echo $this->lang->line("ADD");?>
                                    </a>
                                    <a class="pull-right" href="<?php echo site_url("admin/addfiltervaluecsv"); ?>" style="margin:  0px 30px 10px 0px;padding: 0px 10px;border: 1px solid;" >BULK VALUES UPLOAD</a>
                                    <a class="pull-right" href="<?php echo site_url("admin/addfiltercsv"); ?>" style="margin:  0px 30px 10px 0px;padding: 0px 10px;border: 1px solid;" >BULK FILTER UPLOAD</a>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title For Admin</th>
                                                    <th>Title</th>
                                                    <th>Values</th>
                                                    <th>Copy Filter</th>
                                                    <th class="text-right"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title For Admin</th>
                                                    <th>Title</th>
                                                    <th>Values</th>
                                                    <th>Copy Filter</th>
                                                    <th class="text-right"><?php echo $this->lang->line("Action");?></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php foreach($filters as $q){ ?>
                                                <tr>
                                                    <td><?=$q['filter_id']?></td>
                                                    <td><?=$q['admin_title']?></td>
                                                    <td><?=$q['title']?></td>
                                                    <td><a href="javascript://" class="get-values" data-id="<?=$q['filter_id']?>" data-title="<?=$q['admin_title']?>">Values</a></td>
                                                    <td><a href="javascript://" class="copy-filter" data-id="<?=$q['filter_id']?>" data-title="<?=$q['admin_title']?>">Copy This Filter</a></td>
                                                    <td class="td-actions text-right">
                                                        <div class="btn-group">

                                                            <?php echo anchor('admin/editfilter/'.$q['filter_id'], '<button type="button" rel="tooltip" class="btn btn-success btn-round">
                                                            <i class="material-icons">edit</i>
                                                            </button>', array("class"=>"")); ?>

                                                            <?php echo anchor('admin/deletefilter/'.$q['filter_id'], '<button type="button" rel="tooltip" class="btn btn-danger btn-round">
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


        $(document).on('click', '.get-values', function(event) {
            event.preventDefault();
            $id = $(this).attr('data-id');
            $title = $(this).attr('data-title');
            $("#modal-get-values .modal-title").text($title);
            $("#modal-get-values input[name='filter_id']").val($id);
            $.post('<?=site_url("admin/get_filter_values")?>', {id: $id}, function(resp) {
                resp = JSON.parse(resp);
                $("#modal-get-values tbody").html(resp.html);
                $("#modal-get-values").modal('show');
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

        $(document).on('submit', '#modal-get-values form', function(event) {
            event.preventDefault();
            $form = $(this);
            $.post('<?=site_url("admin/post_filter_values")?>', {data: $form.serialize()}, function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == true) {
                    $("#modal-get-values tbody").append(resp.html);
                }
                else{
                    alert('not submitted, please try again');
                }
            });
        });

        $(document).on('click', '.copy-filter', function(event) {
            event.preventDefault();
            $id = $(this).attr('data-id');
            $title = $(this).attr('data-title');
            $("#modal-copy-filter .modal-title").text($title);
            $("#modal-copy-filter input[name='filter_id']").val($id);
            $("#modal-copy-filter").modal('show');
        });

        $(document).on('submit', '#modal-copy-filter form', function(event) {
            event.preventDefault();
            $form = $(this);
            $.post('<?=site_url("admin/post_filter_copy")?>', {data: $form.serialize()}, function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == true) {
                    alert('submitted, will show after reload webpage');
                }
                else{
                    alert('not submitted, please try again');
                }
            });
        });

    });
</script>

</html>


<div class="modal fade" id="modal-get-values">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="filter_id" value="">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required="required">
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <label>Value</label>
                        <input type="text" name="value" class="form-control" required="required">
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <button class="btn btn-primary">Add</button>
                    </div><!-- /form-group -->
                </form>
                <table class="table table-bordered">
                    <thead>
                        <th>Title</th>
                        <th>Value</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Title</td>
                            <td>Value</td>
                            <td><a href="javascript://" class="dleete-value" data-id=""></a></td>
                        </tr>
                    </tbody>
                </table>
            </div><!-- /modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- #modal-get-values -->

<div class="modal fade" id="modal-copy-filter">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="filter_id" value="">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required="required">
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <label>Title For Admin</label>
                        <input type="text" name="admin_title" class="form-control" required="required">
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <button class="btn btn-primary">Add</button>
                    </div><!-- /form-group -->
                </form>
            </div><!-- /modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- #modal-copy-filter -->

 

    



