<?php
	include('system_load.php');
	//This loads system.
	authenticate_user('subscriber');
	
	HEADER('LOCATION: store.php');
	exit();
	
	$notes_obj = new Notes;
	$message_obj = new Messages;
	
	$page_title = "Dashboard";
	require_once('includes/header.php');	
?>


<div class="col-sm-6">
 <!--level starts here.-->
 <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">My Notes</h3>
    </div>
    <div class="list-group">
        <?php $notes_obj->notes_widget(); ?>
  </div>
</div> <!--mynotes ends here.-->
</div>
<!--level starts here.-->
<div class="col-sm-6">
 <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">Messages</h3>
    </div>
    <div class="list-group">
        <?php $message_obj->message_widget(); ?>
  </div>
</div> <!--mynotes ends here.-->    
</div><!--row ends here.-->

<!--footer-->
<?php require_once('includes/footer.php'); ?>