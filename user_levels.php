<?php
	include('system_load.php');
	//This loads system.
	
	//user Authentication.
	authenticate_user('admin');
	
	$user_level = new Userlevel; //creating object of user levels.
	
	//Delete user level.
	if(isset($_POST['delete_level']) && $_POST['delete_level'] != '') { 
		$message = $user_level->delete_level($_SESSION['user_type'], $_POST['delete_level']);
	}//delete level ends here.
	
	$page_title = "Manage User Levels"; //You can edit this to change your page title.
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
					<p>
                	<a href="manage_user_level.php" class="btn btn-primary btn-default">Add New</a>
					</p>
                    <table cellpadding="0" cellspacing="0" border="0" class="table-responsive table-hover table display table-bordered" id="wc_table" width="100%">
                        <thead>
                            <tr>
                                <th>Level Id</th>
                                <th>Level Name</th>
                                <th>Level Description</th>
                                <th>User Level Page</th>
                                <th>Message</th>
                                <th class="sorting_disabled">Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<tr>
                            	<td>0</td>
                                <td>admin</td>
                                <td>Default level for admins</td>
                                <td>dashboard.php</td>
                                <td><button class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_admin">
  							Message
							</button></td>
                            <script type="text/javascript">
$(function(){
$("#message_form_admin").on("submit", function(e){
  e.preventDefault();
  $.post("includes/messageprocess.php", 
	 $("#message_form_admin").serialize(), 
	 function(data, status, xhr){
	   $("#success_message_admin").html("<div class='alert alert-success'>"+data+"</div>");
	 });
});
});
</script>				
<div class="modal fade" id="modal_admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="message_form_admin" method="post" name="send_message">
	<div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Send Message</h4>
      </div>
	  
      <div class="modal-body">
      		<div id="success_message_admin"></div>
	   		<div class="form-group">
				<label class="control-label">Message To</label>
				<input type="text" class="form-control" name="message_to" value="All admin level users" readonly="readonly" />
			</div>
			
			<div class="form-group">
				<label class="control-label">Subject</label>
				<input type="text" class="form-control" name="subject" value="" />
			</div>
			
			<div class="form-group">
				<label class="control-label">Message</label>
				<textarea class="form-control" name="message"></textarea>
			</div>
      </div>
      <input type="hidden" name="level_name" value="admin" />
	  <input type="hidden" name="level_form" value="1" />
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<input type="submit" value="Send Message" class="btn btn-primary" />
      </div>
    </div><!-- /.modal-content -->
   </form>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <?php $user_level->list_levels($_SESSION['user_type']); ?>
                        </tbody>
                    </table>
                     
<?php
	require_once("includes/footer.php");
?>