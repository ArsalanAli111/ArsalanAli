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
		HEADER('LOCATION: store.php?message=products');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
	
	
	//updating user level
	if(isset($_POST['update_warehouse'])) { 
		extract($_POST);
		$message = $warehouse->update_warehouse($edit_warehouse, $name, $address, $city, $state, $country, $manager, $contact);
	}//update ends here.
	
	//setting level data if updating or editing.
	if(isset($_POST['edit_warehouse'])) {
		$warehouse->set_warehouse($_POST['edit_warehouse']);	
	} //level set ends here
	
	if(isset($_POST['add_warehouse'])) {
		$add_warehouse = $_POST['add_warehouse'];
		if($add_warehouse == '1') { 
			extract($_POST);
			$message = $warehouse->add_warehouse($name, $address, $city, $state, $country, $manager, $contact);
		}
	}//isset add level
	
	if(isset($_POST['edit_warehouse'])){ $page_title = 'Edit Warehouse'; } else { $page_title = 'Add Warehouse';}; //You can edit this to change your page title.
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
                    <div class="col-sm-12">
                    <form action="<?php $_SERVER['PHP_SELF']?>" id="add_warehouse" name="level" method="post">
                    <div class="form-group">
                        	<label class="control-label">Warehouse Name*</label>
                            <input type="text" class="form-control" name="name" placeholder="Warehouse name" value="<?php echo $warehouse->name; ?>" required="required" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Warehouse Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Warehouse address" value="<?php echo $warehouse->address; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">City</label>
                            <input type="text" class="form-control" name="city" placeholder="City" value="<?php echo $warehouse->city; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">State</label>
                            <input type="text" class="form-control" name="state" placeholder="State" value="<?php echo $warehouse->state; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Country</label>
                            <input type="text" class="form-control" name="country" placeholder="Country" value="<?php echo $warehouse->country; ?>" />
                      </div>
					  <div class="form-group">
                        	<label class="control-label">Manager*</label>
                            <input type="text" class="form-control" name="manager" placeholder="Manager" value="<?php echo $warehouse->manager; ?>" required="required" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Contact Num</label>
                            <input type="text" class="form-control" name="contact" placeholder="Contact Number" value="<?php echo $warehouse->contact; ?>" required="required" />
                      </div>	
						<?php 
						if(isset($_POST['edit_warehouse'])){ 
							echo '<input type="hidden" name="edit_warehouse" value="'.$_POST['edit_warehouse'].'" />';
							echo '<input type="hidden" name="update_warehouse" value="1" />'; 
						} else { 
							echo '<input type="hidden" name="add_warehouse" value="1" />';
						} ?>
                        <input type="submit" class="btn btn-primary" value="<?php if(isset($_POST['edit_warehouse'])){ echo 'Update Warehouse'; } else { echo 'Add Warehouse';} ?>" />
                    </form>
                    <script>
						$(document).ready(function() {
							// validate the register form
							$("#add_category").validate();
						});
                    </script>
                   </div><!--left-side-form ends here.-->
                   
<?php
	require_once("includes/footer.php");
?>