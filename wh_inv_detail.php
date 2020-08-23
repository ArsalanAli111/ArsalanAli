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
	 
	if(!isset($_GET['wh_id'])) { 
		HEADER('LOCATION: manage_warehouse_inventory.php');
	} else if($_GET['wh_id'] == '0') { 
		$warehouse_name = 'Unallocated';
	} else { 
		$warehouse_name = $warehouse->get_warehouse_info($_GET['wh_id'], 'name');
	}
	
	if(isset($_GET['transfer_form']) && $_GET['transfer_form'] == '1') {
		extract($_GET);
		$message = $warehouse->warehouse_transfer($transfer_units, $product_id, $wh_id, $wh_tr_id);
		HEADER('LOCATION: wh_inv_detail.php?wh_id='.$wh_id.'&message='.$message);
	}//transfer warehouse inventory detail.
	 
	$page_title = $warehouse_name.' Inventory Detail'; //You can edit this to change your page title.
	require_once("includes/header.php"); //including header file.
	
	if($_GET['wh_id'] != '0') { 
		echo '<p><strong>Manager:</strong> '.$warehouse->get_warehouse_info($_GET['wh_id'], 'manager').' <strong>Contact:</strong> '.$warehouse->get_warehouse_info($_GET['wh_id'], 'contact').' <strong>Address:</strong> '.$warehouse->get_warehouse_info($_GET['wh_id'], 'address').' '.$warehouse->get_warehouse_info($_GET['wh_id'], 'city').' '.$warehouse->get_warehouse_info($_GET['wh_id'], 'state').' '.$warehouse->get_warehouse_info($_GET['wh_id'], 'country').'</p><hr>';
	}
	
    //display message if exist.
        if(isset($_GET['message'])) { 
			$message = $_GET['message'];
		}
		if(isset($message) && $message != '') { 
            echo '<div class="alert alert-success">';
            echo $message;
            echo '</div>';
        }
    ?>
    
    <?php if(isset($_GET['product_id']) && isset($_GET['wh_id'])) { ?>
        <div style="padding:10px; border:1px solid #666; width:50%; margin:auto;">
        <script type="text/javascript">
            function valid_units() { 
                var units_entered = document.getElementById('transfer_units').value;
                var avail_units = <?php echo $_GET['avail_units']; ?>;
                
                if(!(units_entered <= avail_units)) { 
                    document.getElementById('transfer_units').value = '';
                    alert('Please enter units below <?php echo $_GET['avail_units']; ?>');
                } 
            }
        </script>
        <h3 align="center">You are about to transfer <?php echo $_GET['product_name']; ?></h3>
        <?php if($_GET['avail_units'] <= 0) { ?>
                <h3>This product have less than or equal to 0 Items Select another product please.</h3>
        <?php } else { ?>
        
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="get">
            <table width="100%" cellpadding="5px" align="center" border="0" cellspacing="0">
                <tr>
                    <th>Select Units to transfer below or equal to <?php echo $_GET['avail_units']; ?> units: </th>
                    <td><input type="text" name="transfer_units" id="transfer_units" onchange="valid_units();" /></td>
                </tr>
                <tr>
                    <th>Transfer to Warehouse:</th>
                    <td>
                        <select name="wh_tr_id" id="wh_tr_id">
                            <option value="0">Select Warehouse..</option>
                            <?php
                                $warehouse->warehouse_options($_GET['wh_id']);
                            ?>
                        </select>
                    </td>
                </tr>
                <input type="hidden" name="wh_id" value="<?php echo $_GET['wh_id']; ?>" />
                <input type="hidden" name="product_id" value="<?php echo $_GET['product_id']; ?>" />
                <input type="hidden" name="transfer_form" value="1" />
                <tr>
                    <td colspan="2" align="center"><input type="submit" name="submit" value="Transfer Products!" /></td>
                </tr>
            </table>
            </form>
            <?php } ?>
        </div>
        <?php } ?>
    
	<!--content here-->
    <table cellpadding="0" cellspacing="0" border="0" class="table-responsive table-hover table display table-bordered" id="wc_table" width="100%">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Available Units</th>
                <th>Transfer</th>
	        </tr>
        </thead>
        <tbody>
			<?php $warehouse->products_list($_GET['wh_id']); ?>
        </tbody>
    </table> 
    <!--content Ends here.-->

<?php
	require_once("includes/footer.php");
?>