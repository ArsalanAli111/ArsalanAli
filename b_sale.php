<?php
  include('system_load.php');
  //This loads system.
  //user Authentication.
  authenticate_user('subscriber');
  //creating company object.
  $store_access = new StoreAccess;
  $new_store = new Store;
  $client = new Client;
    
  if(partial_access('admin') || $store_access->have_module_access('reports')) {} else { 
    HEADER('LOCATION: store.php?message=products');
  }
  if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
    HEADER('LOCATION: stores.php?message=1');
  } //select company redirect ends here.
?>  
<html>
  <head>
      <title>Sale invoice</title>
        <link rel="stylesheet" type="text/css" media="all" href="reports.css" />
        <style type="text/css">
          table{
            border: groove 1px;
            border-color: black;
          }
          table tr td,th{
            border: groove 1px;
            border-color: black;
          }
        </style>
    </head>
    
    <body>
      <div id="reportContainer" style="width:600px;">
      <!--store Head Start here.-->
            <h2 align="center"><?php echo $new_store->get_store_info($_SESSION['store_id'], 'store_name'); ?></h2>
            <h3 align="center">Salesman Summary</h3>
            
            <!--stor_head Ends here.-->
            <?php
                    $to = $_POST['to'];
                    $from = $_POST['from'];
                    $salesman_id = $_POST['salesman_id'];
                    
             ?>
            <h4 align="right">Date: <?php echo $to.'/'.$from ?></h4>
            
            <table width="100%" align="center" cellpadding="5" cellspacing="0">
              <tr style="background-color:#CCC;">
                  <th>Client Name</th>
                    <th>Area</th>
                    <th>Amount</th>
                </tr>
                <?php
                $gr_total =0;
                $query = "SELECT * FROM `sales` WHERE sales_id='$salesman_id' And `datetime` BETWEEN '$to 00:00:00' And '$from 00:00:00'";
  $result = mysqli_query($db,$query);
   
  while($row=mysqli_fetch_array($result))
{ 
  $client_id = $row['client_id'];
  
  $pductQuery = "SELECT * from clients WHERE client_id='".$client_id."'";
      $productResult = $db->query($pductQuery) or die($db->error);
      $productRow = $productResult->fetch_array();
      $full_name = $productRow['full_name'];

      $city = $productRow['city'];
  $sale_id = $row['sale_id'];

// "SELECT * from sale_detail WHERE sale_detail_id='".$sale_id."'"  //credit_id
$receiveables=0;
$receiveable=0;
$queryss = "SELECT * from sale_detail WHERE sale_id='".$sale_id."'";
  $resultss = mysqli_query($db,$queryss);
   
  while($rowss=mysqli_fetch_array($resultss))
{ 
  
   $credit_id = $rowss['credit_id'];
  $pductQueryss = "SELECT * from creditors WHERE credit_id='".$credit_id."'";
      $productResultss = $db->query($pductQueryss) or die($db->error);
      $productRowss = $productResultss->fetch_array();
      $receiveable = $productRowss['receiveable'];
      $receiveables+=$receiveable;


}

$gr_total += $receiveables;
                ?>
                <tr>
                  <td style="text-align: center;"><?php echo $full_name;  ?></td>
                  <td style="text-align: center;"><?php echo $city;  ?></td>
                  <td style="text-align: center;"><?php echo $receiveables; ?></td>
                </tr>
              <?php } ?>
              <tfoot>
                <tr>
                  <th colspan="2">Grand Total</th>
                  <th><?php echo $gr_total; ?></th>

                  </tr>
              </tfoot>
            </table>
            
    </div><!--reportContainer Ends here.-->
    </body>
</html>