<?php
	include('system_load.php');
	//This loads system.
	
	//user Authentication.
	authenticate_user('all');
	
	$note_obj = new Notes;	
	
	//updating Notes
	if(isset($_POST['update_note'])) { 
		extract($_POST);
		$message = $note_obj->update_note($edit_note, $note_title, $note_detail);
	}//update ends here.
	
	//setting level data if updating or editing.
	if(isset($_POST['edit_note'])) {
		$note_obj->set_note($_POST['edit_note']);	
	} //level set ends here
	
	//add user processing.
	if(isset($_POST['add_note']) && $_POST['add_note'] == '1') { 
		extract($_POST);
		if($note_title == '') { 
			$message = 'Note Title is required!';
		} else if($note_detail == '') { 
			$message = 'Note Detail is required!';
		}  else {
		$message = $note_obj->add_note($note_title, $note_detail);
		}
	}//add user processing ends here.
	
	if(isset($_POST['edit_note'])){ $page_title = 'Edit note'; } else { $page_title = 'Add New Note';} //page title set.
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
                    <form action="<?php $_SERVER['PHP_SELF']?>" id="add_user" name="user" method="post" enctype="multipart/form-data" role="form">
                     <div class="form-group">
                     <label class="control-label">Note Title*</label>
                     <input type="text" class="form-control" name="note_title" placeholder="Note title" value="<?php echo $note_obj->note_title; ?>" required="required" />
                     </div>
                        
                        <div class="form-group">
                        	<label class="control-label">Note Detail*</label>
                            <textarea name="note_detail" class="form-control" placeholder="Note Detail"><?php echo $note_obj->note_detail; ?></textarea>
                        </div>

					  <?php 
						if(isset($_POST['edit_note'])){ 
							echo '<input type="hidden" name="edit_note" value="'.$_POST['edit_note'].'" />';
							echo '<input type="hidden" name="update_note" value="1" />'; 
						} else { 
							echo '<input type="hidden" name="add_note" value="1" />';
						} ?>
                        <div class="form-group">
                        	<input type="submit" value="<?php if(isset($_POST['edit_note'])){ echo 'Update Note'; } else { echo 'Add Note';} ?>" class="btn btn-primary" />
                        </div>
                    </form>
                    <script type="text/javascript">
						$(document).ready(function() {
						// validate the register form
					$("#add_user").validate();
						});
                    </script>
                   </div><!--left-side-form ends here.-->
<?php
	require_once('includes/sidebar.php');
?>                        
<?php
	require_once("includes/footer.php");
?>