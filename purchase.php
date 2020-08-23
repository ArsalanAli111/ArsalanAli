<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.
	$new_store = new Store;
	$store_access = new StoreAccess;
	$purchase = new Purchase;
	
	if(partial_access('admin') || $store_access->have_module_access('purchase')) {} else { 
		HEADER('LOCATION: store.php?message=warehouse');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
	
	//delete store if exist.
	if(isset($_POST['delete_purchase']) && $_POST['delete_purchase'] != '') { 
		$message = $purchase->delete_purchase($_POST['delete_purchase']);
	}//delete account.
	
	$new_store->set_store($_SESSION['store_id']); //setting store.
	 
	$page_title = 'Purchases'; //You can edit this to change your page title.
	require_once("includes/header.php"); //including header file.
	?>

	<?php
    //display message if exist.
        if(isset($message) && $message != '') { 
            echo '<div class="alert alert-success">';
            echo $message;
            echo '</div>';
        }
    ?>
	<!--content here-->
    <p>
	    <a href="manage_purchase.php" class="btn btn-primary btn-default">Add New</a>
    </p>
    
    <table cellpadding="0" cellspacing="0" border="0" class="table-responsive table-hover table display table-bordered" id="wc_table" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Agent</th>
                <th>Vendor</th>
                <th>Supp Inv#</th>
                <th>Memo</th>
                <th>Type</th>
                <th>Items</th>
                <th>Payable</th>
                <th>Paid</th>
                <th>View</th>
                <?php if(partial_access('admin')) { ?>
                <th>Delete</th>
				<?php } ?>
            </tr>
        </thead>
        <tbody>
			<?php $purchase->list_all_purchases(); ?>
        </tbody>
    </table> 
    <!--content Ends here.-->

<?php
	require_once("includes/footer.php");
?>