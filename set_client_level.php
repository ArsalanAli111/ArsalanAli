<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.
	$new_store = new Store;
	$store_access = new StoreAccess;
	$product = new Product;
	
	if(partial_access('admin') || $store_access->have_module_access('price_level')) {} else { 
		HEADER('LOCATION: store.php?message=products');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
	
	if(isset($_POST['update_client'])) { 
		extract($_POST);
		$message = $product->update_client_level($update_client, $price_level);
	}
	
	$new_store->set_store($_SESSION['store_id']); //setting store.
	 
	$page_title = 'Set Client Price Level'; //You can edit this to change your page title.
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
    <style type="text/css">
    	.rate { 
			width:70px;
		}
    </style>
	<!--content here-->
    <table cellpadding="0" cellspacing="0" border="0" class="table-responsive table-hover table display table-bordered" id="wc_table" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Business Title</th>
                <th>Mobile</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Price Level</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
			<?php $product->list_client_levels(); ?>
        </tbody>
    </table> 
    <!--content Ends here.-->

<?php
	require_once("includes/footer.php");
?>