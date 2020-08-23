<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('admin');
	
	$store_access = new StoreAccess;
	
	if(partial_access('admin') || $store_access->have_module_access('reports')) {} else { 
		HEADER('LOCATION: store.php?message=products');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
	
	$page_title = "Reports"; //You can edit this to change your page title.
	require_once("includes/header.php"); //including header file.

//display message if exist.
	if(isset($message) && $message != '') { 
		echo '<div class="alert alert-success">';
		echo $message;
		echo '</div>';
	}
?>
<div class="row">
	<div class="col-md-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <strong>Customers and Receiveables</strong>
            </div>
            <div style="padding:0px;" class="panel-body list-group">
                <div class="list-group-item"><a href="reports/customer_balance_summary.php" target="_blank">Customer Balance Summary</a></div>
                <div class="list-group-item"><a href="reports/customer_ledger_summary.php" target="_blank">Customer Balance Ledger</a></div>
            </div>
        </div>
    </div>
    <!--customers and receiveables-->
    
    <div class="col-md-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <strong>Vendor and payables</strong>
            </div>
            <div style="padding:0px;" class="panel-body list-group">
                <div class="list-group-item"><a target="_blank" href="reports/vendor_balance_summary.php">Vendor Balance Summary</a></div>
                <div class="list-group-item"><a href="reports/vendor_ledger_summary.php" target="_blank">Vendor Balance Ledger</a></div>
            </div>
        </div>
    </div>


    <div class="col-md-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <strong>Complete Ledger</strong>
            </div>
            <div style="padding:0px;" class="panel-body list-group">
            <form method="POST" action="c_ledger.php">
            <div> <input type="date" name="to" class="form-control" name=""></div>
            <div> <input type="date" name="from" class="form-control" name=""></div>
                <div><button target="_blank" name="c_sum" class="btn btn-primary" style="margin-left: 15px;">Complete Ledger Summary</button></div>
               
               </form>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <strong>Profit And Loss Statement</strong>
            </div>
            <div style="padding:0px;" class="panel-body list-group">
            <form method="POST" action="b_sm.php">
            <div> <input type="date" name="to" class="form-control" name=""></div>
            <div> <input type="date" name="from" class="form-control" name=""></div>
                <div><button target="_blank" name="c_sum" class="btn btn-primary" style="margin-left: 15px;">Complete Summary</button></div>
               </form>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <strong>Salesman Statement</strong>
            </div>
            <div style="padding:0px;" class="panel-body list-group">
            <form method="POST" action="b_sale.php">
            <div><select name="salesman_id" id="salesman_id" class="autofill" style="width:100%">
                      <option value="">Select Salesman by full name or mobile</option>
                      <?php echo $salesman->salesman_options($salesman->salesman_id); ?>  
                    </select></div>

            <div> <input type="date" name="to" class="form-control" name=""></div>
            <div> <input type="date" name="from" class="form-control" name=""></div>
                <div><button target="_blank" name="c_sum" class="btn btn-primary" style="margin-left: 15px;">Complete Report</button></div>
               </form>
            </div>
        </div>
    </div>
    
    <!--customers and receiveables-->
<!--
    <div class="col-md-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <strong>Inventory</strong>
            </div>
            <div style="padding:0px;" class="panel-body list-group">
                <div class="list-group-item"><a href="#">Customer Balance Summary</a></div>
            </div>
        </div>
    </div>
    <!--customers and receiveables-->

</div><!--row Ends here.-->    
<?php
	require_once("includes/footer.php");
?>