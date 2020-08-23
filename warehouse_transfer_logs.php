<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.
	$new_store = new Store;
	$store_access = new StoreAccess;
	$warehouse = new Warehouse;
	
	if(partial_access('admin') || $store_access->have_module_access('warehouse')) {} else { 
		HEADER('LOCATION: store.php?message=warehouse');
	}//
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
	
	$new_store->set_store($_SESSION['store_id']); //setting store.
	
	if(isset($_GET['warehouse_id'])) { 
		$warehouse_name = $warehouse->get_warehouse_info($_GET['warehouse_id'], 'name');
	} else { 
		$warehouse_name = 'Warehouse';
	}
	 
	$page_title = $warehouse_name.' transfer logs'; //You can edit this to change your page title.
	require_once("includes/header.php"); //including header file.
	
	if(isset($_GET['warehouse_id'])) { 
		echo '<p><strong>Manager:</strong> '.$warehouse->get_warehouse_info($_GET['warehouse_id'], 'manager').' <strong>Contact:</strong> '.$warehouse->get_warehouse_info($_GET['warehouse_id'], 'contact').' <strong>Address:</strong> '.$warehouse->get_warehouse_info($_GET['warehouse_id'], 'address').' '.$warehouse->get_warehouse_info($_GET['warehouse_id'], 'city').' '.$warehouse->get_warehouse_info($_GET['warehouse_id'], 'state').' '.$warehouse->get_warehouse_info($_GET['warehouse_id'], 'country').'</p><hr>';
	}
	
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
                <th>Product</th>
                <th>Units</th>
                <th>From Warehouse</th>
                <th>To Warehouse</th>
                <th>By</th>
            </tr>
        </thead>
        <tbody>
			<?php 
			if(isset($_GET['warehouse_id'])){ 
				$warehouse->list_warehouse_logs($_GET['warehouse_id']);
			}else { 
				$warehouse->list_warehouse_logs('all');
			}
			 ?>
        </tbody>
    </table> 
    <!--content Ends here.-->

<?php
	require_once("includes/footer.php");
?>