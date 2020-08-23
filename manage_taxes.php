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
	
	
	//updating user level
	if(isset($_POST['update_tax'])) { 
		extract($_POST);
		$message = $product_tax->update_tax($edit_tax,$tax_name,$tax_rate, $tax_type, $tax_description);
	}//update ends here.
	//setting level data if updating or editing.
	if(isset($_POST['edit_tax'])) {
		$product_tax->set_tax($_POST['edit_tax']);	
	} //level set ends here
	if(isset($_POST['add_tax'])) {
		$add_tax = $_POST['add_tax'];
		if($add_tax == '1') { 
			extract($_POST);
			$message = $product_tax->add_tax($tax_name, $tax_rate, $tax_type, $tax_description);
		}
	}//isset add level
	
	if(isset($_POST['edit_tax'])){ $page_title = 'Edit Product Tax'; } else { $page_title = 'Add Product Tax';}; //You can edit this to change your page title.
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
                    <form action="<?php $_SERVER['PHP_SELF']?>" id="add_tax" name="level" method="post">
                    <div class="form-group">
                        	<label class="control-label">Tax Name*</label>
                            <input type="text" class="form-control" name="tax_name" placeholder="Product Tax name" value="<?php echo $product_tax->tax_name; ?>" required="required" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Tax Rate*</label>
                            <input type="text" class="form-control" name="tax_rate" placeholder="Product Tax Rate" value="<?php echo $product_tax->tax_rate; ?>" required="required" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Tax Type*</label>
                            <select name="tax_type" class="form-control">
                            	<option value="">Select Type</option>
                                <option <?php if($product_tax->tax_type == 'fixed') echo "selected='selected'"; ?> value="fixed">Fixed</option>
                                <option <?php if($product_tax->tax_type == 'percentage') echo "selected='selected'"; ?> value="percentage">Percentage</option>
                            </select>
                      </div>
                     <div class="form-group">
                        	<label class="control-label">Tax Description</label>
                            <textarea class="form-control" placeholder="Tax description" name="tax_description"><?php echo $product_tax->tax_description; ?></textarea>
                      </div>
						<?php 
						if(isset($_POST['edit_tax'])){ 
							echo '<input type="hidden" name="edit_tax" value="'.$_POST['edit_tax'].'" />';
							echo '<input type="hidden" name="update_tax" value="1" />'; 
						} else { 
							echo '<input type="hidden" name="add_tax" value="1" />';
						} ?>
                        <input type="submit" class="btn btn-primary" value="<?php if(isset($_POST['edit_tax'])){ echo 'Update Tax'; } else { echo 'Add Tax';} ?>" />
                    </form>
                    <script>
						$(document).ready(function() {
							// validate the register form
							$("#add_tax").validate();
						});
                    </script>
                   </div><!--left-side-form ends here.-->
                   
<?php
	require_once("includes/footer.php");
?>