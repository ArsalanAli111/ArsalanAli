<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.
	
	if(partial_access('admin') || $store_access->have_module_access('salesmans')) {} else { 
		HEADER('LOCATION: store.php?message=products');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
	
	
	//updating user level
	if(isset($_POST['update_salesman'])) { 
		extract($_POST);
		$message = $salesman->update_salesman($edit_salesman, $full_name, $business_title, $mobile, $phone, $address, $city, $state, $zipcode, $country, $email, $price_level, $notes);
	}//update ends here.
	
	//setting level data if updating or editing.
	if(isset($_POST['edit_salesman'])) {
		$salesman->set_salesman($_POST['edit_salesman']);	
	} //level set ends here
	
	if(isset($_POST['add_salesman'])) {
		$add_salesman = $_POST['add_salesman'];
		if($add_salesman == '1') { 
			extract($_POST);
			$message = $salesman->add_salesman($full_name, $business_title, $mobile, $phone, $address, $city, $state, $zipcode, $country, $email, $price_level, $notes);
		}
	}//isset add level
	
	if(isset($_POST['edit_salesman'])){ $page_title = 'Edit salesman'; } else { $page_title = 'Add Salesmane';}; //You can edit this to change your page title.
	require_once("includes/header.php"); //including header file.

	//display message if exist.
		if(isset($message) && $message != '') { 
			echo '<div class="alert alert-success">';
			echo $message;
			echo '</div>';
		}
?>
                    <div class="col-sm-12">
                    <form action="<?php $_SERVER['PHP_SELF']?>" id="add_salesman" name="level" method="post">
                    <div class="form-group">
                        	<label class="control-label">Full Name*</label>
                            <input type="text" class="form-control" name="full_name" placeholder="salesman full name" value="<?php echo $salesman->full_name; ?>" required="required" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Business Title</label>
                            <input type="text" class="form-control" name="business_title" placeholder="Business Title" value="<?php echo $salesman->business_title; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Mobile</label>
                            <input type="text" class="form-control" name="mobile" placeholder="Mobile number" value="<?php echo $salesman->mobile; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Phone</label>
                            <input type="text" class="form-control" name="phone" placeholder="Phone number" value="<?php echo $salesman->phone; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo $salesman->address; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">City</label>
                            <input type="text" class="form-control" name="city" placeholder="City" value="<?php echo $salesman->city; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">State</label>
                            <input type="text" class="form-control" name="state" placeholder="State" value="<?php echo $salesman->state; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Zipcode</label>
                            <input type="text" class="form-control" name="zipcode" placeholder="Zip Code" value="<?php echo $salesman->zipcode; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Country</label>
                            <input type="text" class="form-control" name="country" placeholder="Country" value="<?php echo $salesman->country; ?>" />
                      </div>
				     <div class="form-group">
                        	<label class="control-label">Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $salesman->email; ?>" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Price Level</label>
                            <select name="price_level" class="form-control">
                            	<option <?php if($salesman->price_level == 'default_rate') echo 'selected="selected"'; ?> value="default_rate">Default</option>
                                <option <?php if($salesman->price_level == 'level_1') echo 'selected="selected"'; ?> value="level_1">Level 1</option>
                                <option <?php if($salesman->price_level == 'level_2') echo 'selected="selected"'; ?> value="level_2">Level 2</option>
                                <option <?php if($salesman->price_level == 'level_3') echo 'selected="selected"'; ?> value="level_3">Level 3</option>
                                <option <?php if($salesman->price_level == 'level_4') echo 'selected="selected"'; ?> value="level_4">Level 4</option>
                                <option <?php if($salesman->price_level == 'level_5') echo 'selected="selected"'; ?> value="level_5">Level 5</option>
                            </select>
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Notes</label>
                            <textarea class="form-control" name="notes"><?php echo $salesman->notes; ?></textarea>
                      </div>	
						<?php 
						if(isset($_POST['edit_salesman'])){ 
							echo '<input type="hidden" name="edit_salesman" value="'.$_POST['edit_salesman'].'" />';
							echo '<input type="hidden" name="update_salesman" value="1" />'; 
						} else { 
							echo '<input type="hidden" name="add_salesman" value="1" />';
						} ?>
                        <input type="submit" class="btn btn-primary" value="<?php if(isset($_POST['edit_salesman'])){ echo 'Update salesman'; } else { echo 'Add salesman';} ?>" />
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