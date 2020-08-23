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
	
	if(isset($_POST['product_id']) && isset($_POST['update_rate'])) { 
		extract($_POST);
		$message = $product->update_product_rates($product_id, $update_rate, $default_rate, $level_1, $level_2, $level_3, $level_4, $level_5);
	}
	
	$new_store->set_store($_SESSION['store_id']); //setting store.
	 
	$page_title = 'Set Product Rates'; //You can edit this to change your page title.
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
                <th>PR ID</th>
                <th>Product Name</th>
                <th>Default Rate</th>
                <th>Level 1</th>
                <th>Level 2</th>
                <th>Level 3</th>
                <th>Level 4</th>
                <th>Level 5</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
			<?php $product->list_product_rates(); ?>
        </tbody>
    </table> 
    <!--content Ends here.-->

<?php
	require_once("includes/footer.php");
?>