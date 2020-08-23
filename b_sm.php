
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
		HEADER('LOCATION: ../store.php?message=products');
	}
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: ../stores.php?message=1');
	} //select company redirect ends here.
?>	
<html>
	<head>
    	<title>Complete Ledger</title>
        <link rel="stylesheet" type="text/css" media="all" href="reports.css" />
    </head>
    
    <body>
    	<div id="reportContainer" style="width:800px; margin-left: 200px;">
			<!--store Head Start here.-->
            <h2 align="center"><?php echo $new_store->get_store_info($_SESSION['store_id'], 'store_name'); ?></h2>
            <h3 align="center">Profit & Loss Summary</h3>
            
            <!--stor_head Ends here.-->
            <?php if (isset($_POST['c_sum'])) { 
                    $to = $_POST['to'];
                    $from = $_POST['from'];
                    $store_id=  $_SESSION['store_id'];
             ?>
            <h4 align="center" style="border:1px solid; padding: 10px; ">Date: <?php echo $to.' To '.$from; ?></h4>
           
            
            <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0">
            	<tr style="background-color:#CCC;">
                	<th>Code</th>
                    <th>Product Name</th>
                    <th>Sale qty</th>
                    <th>Net Sale</th>

                    <th>Cost</th>
                    <th>Selling Rate</th>

                    <th>Per Piece Profit</th>
                    
                    <th>Total Product Profit</th>
                    
                </tr>
<?php

$gr_total =0;
$taxs =0;
$sale_pc=0;
$main_total=0;
$net_total=0;
$query = "SELECT distinct(products.product_id) FROM products LEFT JOIN price ON price.product_id=products.product_id Where products.store_id='$store_id'";
  $result = mysqli_query($db,$query);
   
  while($row=mysqli_fetch_array($result))
{ 
 $product_id = $row['product_id'];
 $pductQuery = "SELECT * from products WHERE product_id='".$product_id."'";
      $productResult = $db->query($pductQuery) or die($db->error);
      $productRow = $productResult->fetch_array();
      $pId = $productRow['product_manual_id'];
      $pName = $productRow['product_name'];

      $priceQuery = "SELECT * from price WHERE product_id='".$product_id."' And cost>0 And selling_price>0  order by price_id desc";
      $priceResult = $db->query($priceQuery) or die($db->error);
      $priceRow = $priceResult->fetch_array();
      $price = $priceRow['selling_price'];
      $costs = $priceRow['cost'];
      $tax = $priceRow['tax'];
   $query_t = "SELECT sales.sale_id,sale_detail.inventory_id,sale_detail.price_id FROM sales LEFT JOIN sale_detail ON sales.sale_id=sale_detail.sale_id WHERE sales.datetime BETWEEN '$to 00:00:00' And '$from 00:00:00' And sales.`store_id`='$store_id'";
  $result_t = mysqli_query($db,$query_t);
  
   
  while($row_t=mysqli_fetch_array($result_t))
     
{ 
 $inventory_id = $row_t['inventory_id'];
$inventoryQuery = "SELECT out_inv from inventory WHERE inventory_id='".$inventory_id."' And product_id='$product_id'";
      $inventoryResult = $db->query($inventoryQuery) or die($db->error);
      $inventoryRow = $inventoryResult->fetch_array();
       $qty = $inventoryRow['out_inv'];
      $sale_pc=$sale_pc+$qty;
}

$total_sa = $price-$costs;
$total =  $total_sa*$sale_pc;

$gr_total = $gr_total+$total;  
$taxs = $taxs+$tax;
$main_total +=$sale_pc;
$net_total += $sale_pc*$price;
?>
              <tr>
                  <td align="center"><?php echo $pId ?></td>
                  <td align="center"><?php echo $pName ?></td>
                  <td align="center"><?php echo $sale_pc ?></td>
                  <td align="center"><?php echo $sale_pc*$price ?></td>
                  <td align="center"><?php echo $costs ?></td>
                  <td align="center"><?php echo $price ?></td>
                  <td align="center"><?php echo $total_sa ?></td>
                  
                  <td align="center"><?php echo $total  ?></td>
              </tr>
             
              <?php } ?>
               <?php 
              	$sql_student = "SELECT sum(amount)  as am from receivings where datetime BETWEEN '$to 00:00:00' And '$from 00:00:00'";
            $query_studentid = mysqli_query($db, $sql_student) or die("student Query Error!");
            $result_queryid = mysqli_fetch_array($query_studentid)["am"];    
            $student_nameid = $result_queryid;


            $sql_student_st = "SELECT sum(amount)  as amt from expenses where datetime BETWEEN '$to 00:00:00' And '$from 00:00:00'";
            $query_studentid_st = mysqli_query($db, $sql_student_st) or die("student Query Error!");
            $result_queryid_st = mysqli_fetch_array($query_studentid_st)["amt"];    
            $student_nameid_st = $result_queryid_st;

              ?>
              <tr style="background-color:#CCC;">
              <th></th>
              <th>Total Amount :</th>
                <th align="center"><?php echo $main_total; ?></th>
              <th><?php echo $net_total; ?></th>

              	<th align="center"><?php echo $student_nameid_st ?></th>
              <th></th>
              <th></th>
<th align="center"> <?php echo $gr_total-$student_nameid_st-$taxs; ?></th>
                
              </tr>
            </table>




            <?php }  ?>
		</div><!--reportContainer Ends here.-->
    </body>
</html>