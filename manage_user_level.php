<?php
	include('system_load.php');
	//This loads system.
	//user Authentication.
	authenticate_user('admin');
	//processing add form.
	$user_level_obj = new Userlevel;
	//updating user level
	if(isset($_POST['update_level'])) { 
		extract($_POST);
		$message = $user_level_obj->update_user_level($edit_level,$level_name, $level_description, $level_page);
	}//update ends here.
	//setting level data if updating or editing.
	if(isset($_POST['edit_level'])) {
		$user_level_obj->set_level($_POST['edit_level']);	
	} //level set ends here
	if(isset($_POST['add_level'])) {
		$add_level = $_POST['add_level'];
		if($add_level == '1') { 
			extract($_POST);
			$message = $user_level_obj->add_user_level($level_name, $level_description, $level_page);
		}
	}//isset add level
	if(isset($_POST['edit_level'])){ $page_title = 'Edit user level'; } else { $page_title = 'Add New User Level';}; //You can edit this to change your page title.
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
                    <div class="col-sm-8">
                    <form action="<?php $_SERVER['PHP_SELF']?>" id="add_level" name="level" method="post">
                    <div class="form-group">
                        	<label class="control-label">Level Name*</label>
                            <input type="text" class="form-control" name="level_name" placeholder="User level name" value="<?php echo $user_level_obj->level_name; ?>" required="required" />
                      </div>
                      
                     <div class="form-group">
                        	<label class="control-label">Level Description</label>
                            <textarea class="form-control" placeholder="User level description" name="level_description"><?php echo $user_level_obj->level_description; ?></textarea>
                      </div>
                      
                      <div class="form-group">
                        	<label class="control-label">Page Name*</label>
                            <small>This would be default page where user of stated level redirected after login.</small><input type="text" name="level_page" class="form-control" value="<?php echo $user_level_obj->level_page; ?>" placeholder="User level page" required="required" /><br /><small>e.g manager.php this would be default page for user types of entered name. You can use ../manager.php if your file is one directory back of this script.</small>
                       </div>
                        <div class="form-group">
                        <small>To make a page password secure and accessable by entered level name users let's say you created user level manager and setup default page manager.php. Now you want to secure manager_2.php with password but manager user level users can access and admins we need to put 
<pre>
&lt;?php
	include('system_load.php'); //Please make sure this file loads properly.
	//This loads system.
	authenticate_user('manager');
?&gt;		
</pre>
PHP code in start of manager.php and manager_2.php Both files will need login and user level manager.</small>
                        </div>
						<?php 
						if(isset($_POST['edit_level'])){ 
							echo '<input type="hidden" name="edit_level" value="'.$_POST['edit_level'].'" />';
							echo '<input type="hidden" name="update_level" value="1" />'; 
						} else { 
							echo '<input type="hidden" name="add_level" value="1" />';
						} ?>
                        <input type="submit" class="btn btn-primary" value="<?php if(isset($_POST['edit_level'])){ echo 'Update level'; } else { echo 'Add Level';} ?>" />
                    </form>
                    <script>
						$(document).ready(function() {
							// validate the register form
							$("#add_level").validate();
						});
                    </script>
                   </div><!--left-side-form ends here.-->
                   
<?php
	require_once('includes/sidebar.php');
?>                        
<?php
	require_once("includes/footer.php");
?>