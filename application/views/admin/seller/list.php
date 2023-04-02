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
                                    <h4 class="card-title">All Sellers</h4>
                                    <h4 class="card-title"><div class=""><a href="<?php echo site_url("admin/add_restaurant"); ?>" class="btn btn-success btn-round"><i class="material-icons">add</i> Restaurant</a></div></h4>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-bordered" cellspacing="0" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Meta</th>
                                                    <th>Brand Name Request</th>
                                                    <th>Brand</th>
                                                    <th>Balance</th>
                                                    <th>Address</th>
                                                    <th>Bank</th>
                                                    <th>CNIC</th>
                                                    <th>Cheque</th>
                                                    <th>Status</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Meta</th>
                                                    <th>Brand Name Request</th>
                                                    <th>Brand</th>
                                                    <th>Balance</th>
                                                    <th>Address</th>
                                                    <th>Bank</th>
                                                    <th>CNIC</th>
                                                    <th>Cheque</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                  foreach($users as $user)
                                                  {
                                                    
                                                    ?>
                                                   
                                                        <tr>
                                                            
                                                            <td><?=$user->seller_id?></td>
                                                            <td><?=$user->fname.' '.$user->lname?></td>
                                                            <td>
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <td>Email</td>
                                                                        <td><?=$user->email?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Mobile</td>
                                                                        <td><?=$user->mobile?></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td><?=$user->brand_name?></td>
                                                            <td><?=$user->Brand?></td>
                                                            <td>
                                                                <?php if ($user->balance > 0): ?>
                                                                    <button class="btn btn-danger"><?=$user->balance?></button><br>
                                                                    <a href="javascript://" class="btn btn-primary transfer-balance" data-id="<?=$user->seller_id?>">Transfer</a>
                                                                <?php else: ?>
                                                                    <?=$user->balance?>
                                                                <?php endif ?>
                                                            </td>
                                                            <td>
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <td>Business</td>
                                                                        <td><?=$user->shop_address?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>City</td>
                                                                        <td><?=$user->city?></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td>
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <td>Bank Name</td>
                                                                        <td><?=$user->bank_name?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Branch Code</td>
                                                                        <td><?=$user->branch_code?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Branch Code</td>
                                                                        <td><?=$user->branch_code?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Account Number - IBAN</td>
                                                                        <td><?=$user->bank_iban?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Account Title</td>
                                                                        <td><?=$user->bank_title?></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td>
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <td>CNIC</td>
                                                                        <td><?=$user->cnic?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Name On CNIC</td>
                                                                        <td><?=$user->name_on_cnic?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>CNIC Front</td>
                                                                        <td><?php if($user->cnic_front!=""){ ?><div class="cat-img" style="width: 50px; height: 50px;"><a href="<?=UPLOADS_SELLER.$user->cnic_front?>" target="_blank"><img width="100%" height="100%" src="<?=UPLOADS_SELLER.$user->cnic_front?>" /></a></div> <?php } ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>CNIC Back</td>
                                                                        <td><?php if($user->cnic_back!=""){ ?><div class="cat-img" style="width: 50px; height: 50px;"><a href="<?=UPLOADS_SELLER.$user->cnic_back?>" target="_blank"><img width="100%" height="100%" src="<?=UPLOADS_SELLER.$user->cnic_back?>" /></a></div> <?php } ?></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td><?php if($user->cheque_image!=""){ ?><div class="cat-img" style="width: 50px; height: 50px;"><a href="<?=UPLOADS_SELLER.$user->cheque_image?>" target="_blank"><img width="100%" height="100%" src="<?=UPLOADS_SELLER.$user->cheque_image?>" /></a></div> <?php } ?></td>

                                                            <td>
                                                                <?php
                                                                if ($user->status == 'new') {
                                                                    echo '<span class="badge badge-primary">New</span>';
                                                                }
                                                                else if ($user->status == 'active') {
                                                                    echo '<span class="badge badge-success">Active</span>';
                                                                }
                                                                else if ($user->status == 'inactive') {
                                                                    echo '<span class="badge badge-danger">Inactive</span>';
                                                                }
                                                                else if ($user->status == 'block') {
                                                                    echo '<span class="badge badge-danger">Inactive</span>';
                                                                }
                                                                else if ($user->status == 'incomplete') {
                                                                    echo '<span class="badge badge-warning">Incomplete</span>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="td-actions text-right">
                                                                <div class=""><?php echo anchor('admin/edit_seller/'.$user->seller_id,  '<button type="button" rel="tooltip" class="btn btn-success btn-round"><i class="material-icons">edit</i></button>', array("class"=>"")); ?></div>
                                                                <br><a href="http://localhost/OnlineStoreMain/admin-login/<?=$user->seller_id?>/<?=$user->user_password?>/" target="_blank" class="btn btn-success btn-round">Login</a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                  }
                                                ?>
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


        $(document).on('click', '.transfer-balance', function(event) {
            event.preventDefault();
            $id = $(this).attr('data-id');
            $.post('<?=site_url("admin/get_transfer_history")?>', {id: $id}, function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == true) {
                    $("#modal-transfer-history input[name='seller_id']").val($id);
                    $("#modal-transfer-history input[name='balance']").val(resp.balance);
                    $("#modal-transfer-history input[name='amount']").val(resp.balance);
                    $("#modal-transfer-history").attr('data-first',resp.first);
                    $("#modal-transfer-history tbody").html(resp.html);
                    $("#modal-transfer-history").modal('show');
                }
                else{
                    alert(resp.msg);
                }
            });
        });

        $(document).on('submit', '#modal-transfer-history form', function(event) {
            event.preventDefault();
            $form = $(this);
            $.post('<?=site_url("admin/save_transfer_history")?>', {data: $form.serialize()}, function(resp) {
                resp = JSON.parse(resp);
                if (resp.status == true) {
                    $first = $("#modal-transfer-history").attr('data-first');
                    if ($first == 'true') {
                        $("#modal-transfer-history tbody").html(resp.html);
                    }
                    else{
                        $("#modal-transfer-history-table > tbody > tr:first").before(resp.html);
                    }
                    $("#modal-transfer-history").attr('data-first',resp.first);
                    $("#modal-transfer-history input[name='balance']").val(resp.balance);
                    $("#modal-transfer-history input[name='amount']").val(resp.balance);
                    alert('payment transfered');
                }
                else{
                    alert(resp.msg);
                }
            });
        });

    });
</script>

</html>









<div class="modal fade" id="modal-transfer-history" data-first="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Transfer History</h4>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="seller_id">
                    <div class="form-group">
                        <label>Balance *</label>
                        <input type="text" name="balance" class="form-control" readonly="readonly" required="required">
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <label>Amount *</label>
                        <input type="text" name="amount" class="form-control" required="required">
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <label>Method *</label>
                        <select name="method" class="form-control" required="required">
                            <option value="">Select Payment Method</option>
                            <option value="bank transfer">Bank Transfer</option>
                            <option value="online bank transfer">Online Bank Transfer</option>
                            <option value="jazzcash">Jazzcash</option>
                            <option value="easypaisa">Easypaisa</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="desc" class="form-control" rows="3"></textarea>
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <label>Ref *</label>
                        <input type="text" name="ref" class="form-control" required="required">
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Transfer</button>
                    </div><!-- /form-group -->
                </form>
                
                <table class="table table-hover table-bordered" id="modal-transfer-history-table">
                    <thead>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Description</th>
                        <th>Ref</th>
                        <th>At</th>
                    </thead>
                    <tbody></tbody>
                </table>

            </div><!-- /modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div><!-- /modal-footer -->
        </div><!-- /modal-content -->
    </div><!-- /modal-dialog -->
</div><!-- /modal-transfer-history -->










