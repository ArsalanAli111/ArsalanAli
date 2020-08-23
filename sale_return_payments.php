<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.
	$new_store = new Store;
	$store_access = new StoreAccess;
	$client = new Client;
	
	if(partial_access('admin') || $store_access->have_module_access('returns')) {} else { 
		HEADER('LOCATION: store.php?message=warehouse');
	}
	
	//delete store if exist.
	if(isset($_POST['delete_sale_return_payment']) && $_POST['delete_sale_return_payment'] != '') { 
		$message = $client->delete_sale_return_payment($_POST['delete_sale_return_payment']);
	}//delete account.
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
	
	$new_store->set_store($_SESSION['store_id']); //setting store.
	 
	$page_title = 'Sale Return Payments'; //You can edit this to change your page title.
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
    <table cellpadding="0" cellspacing="0" border="0" class="table-responsive table-hover table display table-bordered" id="wc_table" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Method</th>
                <th>Ref No.</th>
                <th>Agent</th>
                <th>Client</th>
                <th>Memo</th>
                <th>Amount</th>
                <?php if(partial_access('admin')) { ?>
                <th>Delete</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
			<?php $client->list_return_payments(); ?>
        </tbody>
    </table> 
    <!--content Ends here.-->

<?php
	require_once("includes/footer.php");
?>