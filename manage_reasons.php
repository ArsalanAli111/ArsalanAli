<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('subscriber');
	//creating company object.
	$new_store = new Store;
	$store_access = new StoreAccess;
	$returnreason = new Returnreason;
		
	if(partial_access('admin') || $store_access->have_module_access('returns')) {} else { 
		HEADER('LOCATION: store.php?message=products');
	}
	
	if(!isset($_SESSION['store_id']) || $_SESSION['store_id'] == '') { 
		HEADER('LOCATION: stores.php?message=1');
	} //select company redirect ends here.
	
	
	//updating user level
	if(isset($_POST['update_reason'])) { 
		extract($_POST);
		$message = $returnreason->update_reason($edit_reason, $title, $description);
	}//update ends here.
	
	//setting level data if updating or editing.
	if(isset($_POST['edit_reason'])) {
		$returnreason->set_reason($_POST['edit_reason']);	
	} //level set ends here
	
	if(isset($_POST['add_reason'])) {
		$add_reason = $_POST['add_reason'];
		if($add_reason == '1') { 
			extract($_POST);
			$message = $returnreason->add_reason($title, $description);
		}
	}//isset add level
	
	if(isset($_POST['edit_reason'])){ $page_title = 'Edit Return Reason'; } else { $page_title = 'Add Return Reason';}; //You can edit this to change your page title.
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
                    <form action="<?php $_SERVER['PHP_SELF']?>" id="add_return_reason" name="level" method="post">
                    <div class="form-group">
                        	<label class="control-label">Reason title*</label>
                            <input type="text" class="form-control" name="title" placeholder="Reason title" value="<?php echo $returnreason->title; ?>" required="required" />
                      </div>
                      <div class="form-group">
                        	<label class="control-label">Description</label>
                            <textarea class="form-control" name="description" placeholder="Return reason description"><?php echo $returnreason->description; ?></textarea>
                      </div>

						<?php 
						if(isset($_POST['edit_reason'])){ 
							echo '<input type="hidden" name="edit_reason" value="'.$_POST['edit_reason'].'" />';
							echo '<input type="hidden" name="update_reason" value="1" />'; 
						} else { 
							echo '<input type="hidden" name="add_reason" value="1" />';
						} ?>
                        <input type="submit" class="btn btn-primary" value="<?php if(isset($_POST['edit_reason'])){ echo 'Update Reason'; } else { echo 'Add Reason';} ?>" />
                    </form>
                    <script>
						$(document).ready(function() {
							// validate the register form
							$("#add_reason").validate();
						});
                    </script>
                   </div><!--left-side-form ends here.-->
                   
<?php
	require_once("includes/footer.php");
?>