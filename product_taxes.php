<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.
	$new_store = new Store;
	$store_access = new StoreAccess;
	$product_tax = new ProductTax;
	
	if(partial_access('admin') || $store_access->have_module_access('products')) {} else { 
		HEADER('LOCATION: store.php?message=products');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
	
	//Delete user level.
	if(isset($_POST['delete_tax']) && $_POST['delete_tax'] != '') { 
		$message = $product_tax->delete_tax($_POST['delete_tax']);
	}//delete level ends here.
	
	$new_store->set_store($_SESSION['store_id']); //setting store.
	 
	$page_title = 'Product Taxes'; //You can edit this to change your page title.
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
	    <a href="manage_taxes.php" class="btn btn-primary btn-default">Add New</a>
    </p>
    <table cellpadding="0" cellspacing="0" border="0" class="table-responsive table-hover table display table-bordered" id="wc_table" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tax Name</th>
                <th>Rate</th>
                <th>Type</th>
                <th>Description</th>
                <?php if(partial_access('admin')) { ?><th>Edit</th>
                <th>Delete</th><?php } ?>
            </tr>
        </thead>
        <tbody>
			<?php $product_tax->list_taxes(); ?>
        </tbody>
    </table>
    <!--content Ends here.-->

<?php
	require_once("includes/footer.php");
?>