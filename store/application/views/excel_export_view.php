<html>
<head>
    <title>Export Data to Excel in Codeigniter using PHPExcel</title>
    
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
</head>
<body>
 <div class="container box">
  <h3 align="center">Export Data to Excel in Codeigniter using PHPExcel</h3>
  <br />
  <div class="table-responsive">
   <table class="table table-bordered">
    <tr>
     <th>Sale Id</th>
     <th>User Id</th>
     <th>Total Amount</th>
     <th>Total Rewards</th>
     <th>Total Kg</th>
    </tr>
    <?php
    foreach($employee_data as $row)
    {
     echo '
     <tr>
      <td>'.$row->sale_id.'</td>
      <td>'.$row->user_id.'</td>
      <td>'.$row->total_amount.'</td>
      <td>'.$row->total_rewards.'</td>
      <td>'.$row->total_kg.'</td>
     </tr>
     ';
    }
    ?>
   </table>
   <div align="center">
    <form method="post" action="<?php echo base_url(); ?>excel_export/action">
     <input type="submit" name="export" class="btn btn-success" value="Export" />
    </form>
   </div>
   <br />
   <br />
  </div>
 </div>
</body>
</html>