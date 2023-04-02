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
    <style type="text/css">
        .ui-datepicker-trigger{
            height: 25px !important;
            width: 25px !important
        }
        #ui-datepicker-div{
            background-color: #fff;
        }
    </style>
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
                                    <h4 class="card-title">Orders List (<span class="order-status-heading">Delivered</span>)</h4>
                                    <!--a class="text-right" href="<?php echo site_url("admin/add_products"); ?>">ADD</a-->
                                    <div  class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                        <div class="row">
                                            <div class="col-md-8">
                                                <button class="btn btn-primary order-search-filter-days" data-id="1">Today</button>
                                                <button class="btn btn-primary order-search-filter-days" data-id="3">3 Days</button>
                                                <button class="btn btn-primary order-search-filter-days" data-id="7">7 Days</button>
                                                <button class="btn btn-primary order-search-filter-days" data-id="14">14 Days</button>
                                                <button class="btn btn-primary order-search-filter-days" data-id="30">30 Days</button>
                                                <button class="btn btn-primary order-search-filter-days" data-id="90">90 Days</button>
                                            </div><!-- {4} -->
                                            <div class="col-md-4">
                                                <select class="form-control status-filter">
                                                    <option value="pending">Pending</option>
                                                    <option value="in process">In Process</option>
                                                    <option value="delivered to courier">Delivered To Courier</option>
                                                    <option value="On Way">On Way</option>
                                                    <option value="delivered" selected="selected">Delivered</option>
                                                    <option value="returned">Returned</option>
                                                    <option value="cancelled">Cancelled</option>
                                                </select>
                                            </div><!-- {4} -->
                                        </div><!-- {row} -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h4 class="card-title"><?php echo $this->lang->line("Date From");?></h4>
                                                <div class="form-group">
                                                    <label class="label-control"></label>
                                                    <input type='text' id='txtDate' name="from" class="form-control datetimepicker" value="<?=date('Y-m-d')?>"  readonly="">
                                                    <span class="material-input"></span>
                                                </div>
                                            </div><!-- {4} -->
                                            <div class="col-md-4">
                                                <h4 class="card-title"><?php echo $this->lang->line("Date To");?></h4>
                                                <div class="form-group">
                                                    <label class="label-control"></label>
                                                    <input type='text' id="txtDate2" name="to" class="form-control datepicker" value="<?=date('Y-m-d')?>" readonly="">
                                                    <span class="material-input"></span>
                                                </div>
                                            </div><!-- {4} -->
                                            <div class="col-md-4">
                                                <button class="btn btn-success order-report-btn">Search</button>
                                            </div><!-- {4} -->
                                        </div><!-- {row} -->
                                        <br>
                                    </div>
                                    <div class="material-datatables">
                                        <table id="example" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"><?php echo $this->lang->line("Order");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Date");?></th>
                                                    <th class="text-center">Amount</th>
                                                    <th class="text-center">Payment</th>
                                                    <th class="text-center">Tracking Status</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center"><?php echo $this->lang->line("Order");?></th>
                                                    <th class="text-center"><?php echo $this->lang->line("Date");?></th>
                                                    <th class="text-center">Amount</th>
                                                    <th class="text-center">Payment</th>
                                                    <th class="text-center">Tracking Status</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                
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

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                order: [[0, 'desc']]
            } );
        } );
    </script>



    <script type="text/javascript">
        

        $(document).ready(function() {

            $("#txtDate").datepicker({
                showOn: 'button',
                buttonText: 'Show Date',
                buttonImageOnly: true,
                buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
                dateFormat: 'yy-mm-dd',
                constrainInput: true
            });

            $(".ui-datepicker-trigger").mouseover(function() {
                $(this).css('cursor', 'pointer');
            });

        });

        $(document).ready(function() {

            $("#txtDate2").datepicker({
                showOn: 'button',
                buttonText: 'Show Date',
                buttonImageOnly: true,
                buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
                dateFormat: 'yy-mm-dd',
                constrainInput: true
            });

            $(".ui-datepicker-trigger").mouseover(function() {
                $(this).css('cursor', 'pointer');
            });

        });
    </script>


</html>


<script>
$(function(){


    $(document).on('click', '.order-search-filter-days', function(event) {
        event.preventDefault();
        $Number = parseInt($(this).attr('data-id'));
        if ($Number == 1) {
            var today = new Date();
            var d1 = today.getDate(nd);
            var m1 =  today.getMonth(nd);
            m1 += 1;  // JavaScript months are 0-11
            var y1 = today.getFullYear(nd);
            $("#txtDate2").val(y1+'-'+m1+'-'+d1);
            $("#txtDate").val(y1+'-'+m1+'-'+d1);
        }
        else{
            var today = new Date();
            var d1 = today.getDate(nd);
            var m1 =  today.getMonth(nd);
            m1 += 1;  // JavaScript months are 0-11
            var y1 = today.getFullYear(nd);
            $("#txtDate2").val(y1+'-'+m1+'-'+d1);

            var date = new Date();
            var newdate = new Date(date);
            newdate.setDate(newdate.getDate() - $Number); // minus the date
            var nd = new Date(newdate);
            var formattedDate = new Date(nd);

            var d = formattedDate.getDate(nd);
            var m =  formattedDate.getMonth(nd);
            m += 1;  // JavaScript months are 0-11
            var y = formattedDate.getFullYear(nd);
            $("#txtDate").val(y+'-'+m+'-'+d);
        }
    });

    $(document).on('click', '.order-report-btn', function(event) {
        event.preventDefault();
        $('#example').DataTable().destroy();
        $('#example tbody').empty();
        $(".order-status-heading").text($(".status-filter").val());
        $.post('<?=site_url("admin/get_order_report_ajax/")?>', {
            status: $(".status-filter").val(),
            to: $("#txtDate2").val(),
            from: $("#txtDate").val()
        }, function(resp) {
            resp = JSON.parse(resp);
            if (resp.status == true) {
                $('#example').DataTable().destroy();
                $('#example tbody').empty();
                // var t = $('#example').DataTable();
                var t = $('#example').DataTable( {
                            dom: 'Bfrtip',
                            buttons: [
                                'copyHtml5',
                                'excelHtml5',
                                'csvHtml5',
                                'pdfHtml5'
                            ],
                            order: [[0, 'desc']]
                        } );
                for(var i = 0; i <= resp.data.length ; i++){
                    t.row.add( [
                        resp.data[i].sale_id,
                        resp.data[i].at,
                        resp.data[i].total_amount,
                        resp.data[i].payment_method,
                        resp.data[i].tracking_status
                    ] ).draw( false );
                }
            }
            else{
                alert(resp.msg);
            }
        });
    });

});//onload
</script>