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
    	<div id="reportContainer" style="width:600px;">
			<!--store Head Start here.-->
            <h2 align="center"><?php echo $new_store->get_store_info($_SESSION['store_id'], 'store_name'); ?></h2>
            <h3 align="center">Ledger Summary</h3>
            
            <!--stor_head Ends here.-->
            <?php if (isset($_POST['c_sum'])) { 
                    $to = $_POST['to'];
                    $from = $_POST['from'];
                  $store_id=  $_SESSION['store_id'];
             ?>
            <h4 align="center" style="border:1px solid; padding: 10px; ">Date: <?php echo $to.' To '.$from; ?></h4>
           
            
            <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0">
            	<tr style="background-color:#CCC;">
                	<th>Customer Name</th>
                    <th>Ref No</th>
                    <th>Amount</th>
                    
                </tr>
<?php
$query = "SELECT receivings.client_id,receivings.amount, receivings.ref_no,clients.full_name FROM receivings LEFT JOIN clients ON receivings.client_id=clients.client_id WHERE receivings.datetime BETWEEN '$to 00:00:00' And '$from 00:00:00' And receivings.`store_id`='$store_id'";
  $result = mysqli_query($db,$query);
   
  while($row=mysqli_fetch_array($result))
		 
{ 
 $client_id = $row['client_id'];
     $full_name = $row['full_name'];
     $amount = $row['amount'];
     $ref_no = $row['ref_no'];
	
?>
              <tr>
                  <td align="center"><?php echo $full_name ?></td>
                  <td align="center"><?php echo $ref_no ?></td>
                  <td align="center"><?php echo $amount ?></td>
              </tr>
             
              <?php } ?>
               <?php 
              	$sql_student = "SELECT sum(amount)  as am from receivings where datetime BETWEEN '$to 00:00:00' And '$from 00:00:00' And store_id='$store_id'";
            $query_studentid = mysqli_query($db, $sql_student) or die("student Query Error!");
            $result_queryid = mysqli_fetch_array($query_studentid)["am"];    
            $student_nameid = $result_queryid;

              ?>
              <tr style="background-color:#CCC;">
              <th></th>
              <th>Total Amount :</th>
              	<th align="center"><?php echo $student_nameid ?></th>
              </tr>
            </table>



 <h4 align="center" style="border:1px solid; padding: 10px; ">Vendor Summary</h4>
           
            
            <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0">
            	<tr style="background-color:#CCC;">
                	<th>Vendor Name</th>
                    <th>Ref No</th>
                    <th>Amount</th>
                    
                </tr>
<?php
$query = "SELECT payments.vendor_id,payments.amount, payments.ref_no,vendors.full_name FROM payments LEFT JOIN vendors ON payments.vendor_id=vendors.vendor_id WHERE payments.datetime BETWEEN '$to 00:00:00' And '$from 00:00:00' And payments.store_id='$store_id'";
  $result = mysqli_query($db,$query);
   
  while($row=mysqli_fetch_array($result))
		 
{ 
 $vendor_id = $row['vendor_id'];
     $full_name = $row['full_name'];
     $amount = $row['amount'];
     $ref_no = $row['ref_no'];
	
?>
              <tr>
                  <td align="center"><?php echo $full_name ?></td>
                  <td align="center"><?php echo $ref_no ?></td>
                  <td align="center"><?php echo $amount ?></td>
              </tr>
             
              <?php } ?>
               <?php 
              	$sql_student = "SELECT sum(amount)  as am from payments where datetime BETWEEN '$to 00:00:00' And '$from 00:00:00' And store_id='$store_id'";
            $query_studentid = mysqli_query($db, $sql_student) or die("student Query Error!");
            $result_queryid = mysqli_fetch_array($query_studentid)["am"];    
            $student_nameids = $result_queryid;

              ?>
              <tr style="background-color:#CCC;">
              <th></th>
              <th>Total Amount :</th>
              	<th align="center"><?php echo $student_nameids ?></th>
              </tr>
            </table>


<h4 align="center" style="border:1px solid; padding: 10px; ">Vendor Summary</h4>
           
            
            <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0">
            	<tr style="background-color:#CCC;">
                	<th>Expense</th>
                    <th>Description</th>
                    <th>Amount</th>
                    
                </tr>
<?php
$query_ex = "SELECT * FROM `expenses` WHERE datetime BETWEEN '$to 00:00:00' And '$from 00:00:00' And store_id='$store_id'";
  $result = mysqli_query($db,$query_ex);
   
  while($rowss=mysqli_fetch_array($result))
		 
{ 
 
     $title = $rowss['title'];
     $description = $rowss['description'];
     $amount = $rowss['amount'];
	
?>
              <tr>
                  <td align="center"><?php echo $title ?></td>
                  <td align="center"><?php echo $description ?></td>
                  <td align="center"><?php echo $amount ?></td>
              </tr>
             
              <?php } ?>
               <?php 
              	$sql_student = "SELECT sum(amount)  as am FROM `expenses` WHERE datetime BETWEEN '$to 00:00:00' And '$from 00:00:00' And store_id='$store_id'";
            $query_studentid = mysqli_query($db, $sql_student) or die("student Query Error!");
            $result_queryid = mysqli_fetch_array($query_studentid)["am"];    
            $student_nameids_am = $result_queryid;

              ?>
              <tr style="background-color:#CCC;">
              <th></th>
              <th>Total Amount :</th>
              	<th align="center"><?php echo $student_nameids_am ?></th>
              </tr>
            </table>


            <?php } ?>
		</div><!--reportContainer Ends here.-->
    </body>
</html>