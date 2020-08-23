<?php
	//Page display settings.
	$page_title = "Installation!"; //You can edit this to change your page title.
	require_once("includes/functions.php"); //option functions file.
	require_once("includes/db_connect.php"); //Database connection file.
	require_once("includes/database_installation.php");
	
	//Check if installation is already complete.
	$installation = get_option('installation');
	if($installation == 'Yes') { 
		HEADER('LOCATION: index.php');
		exit();
	}
	//installation form processing when submits.
	if(isset($_POST['install_submit']) && $_POST['install_submit'] == 'Yes') {
		extract($_POST);
		//validation to check if fields are empty!
		if($site_url == '') { 
			echo 'Site url cannot be empty!';
		} else if($email_from == '') { 
			echo 'Email from cannot be empty!';
		} else if($email_to == '') { 
			echo 'Reply to cannot be empty!';
		} else if($email == '') { 
			echo 'Admin email cannot be empty!';
		} else if($password == '') { 
			echo 'Admin Password cannot be empty!';
		} else {
			set_option('redirect_on_logout', 'index.php');
			set_option('register_user_level', 'subscriber');
			set_option('session_timeout', '180');
			set_option('maximum_login_attempts', '10');
			set_option('wrong_attempts_time', '10');
			//adding site url
			set_option('site_url', $site_url);
			set_option('site_name', $site_name);
			set_option('email_from', $email_from);
			set_option('email_to', $email_to);
			set_option('installation', 'Yes');
			set_option('version', '2.1');
			set_option('language', $language);
			set_option('redirect_on_logout', 'index.php');
			set_option('register_user_level', 'subscriber');
			set_option('session_timeout', '180');
			set_option('maximum_login_attempts', '10');
			set_option('wrong_attempts_time', '10');
			install_admin($first_name, $last_name, $email, $password);
			HEADER('LOCATION: index.php');
		}//form validations
	}//form processing.
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $page_title; ?></title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" media="all" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" media="all" />
<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">
    	<!-- you can copy following form in your registration page!-->
        	<h2><?php echo $page_title; ?></h2>
            <hr />
            <h3>Note: You can delete install.php once your installation is complete and working fine.</h3><br /><br />
            <p>Here you can setup basic values for this login script. Please make sure you give correct values cause you could not edit them later without using PHPmyADMIn options table.</p>
            
            <form name="set_install" id="set_install" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">

                	<div class="form-group">
                    	<label class="control-label">Site URL*:</label>
                        <input type="text" class="form-control" name="site_url" required /><small>Please include / at end of site url e.g http://localhost/</small>
                    </div>
                    
                    <div class="form-group">
                    	<label class="control-label">Site Name:</label>
                        <input class="form-control" type="text" name="site_name" />
                    </div>
                    <div class="form-group">
                    	<label class="control-label">Language:</label>
                        <select name="language" class="form-control">
                        	<option value="english">English</option>
                            <option value="french">French</option>
                            <option value="dutch">Dutch</option>
                            <option value="german">German</option>
                            <option value="italian">Italian</option>
                        </select>
                    </div>
                    <div class="form-group">
                    	<p>
                        	Email settings used for the system will send Emails to users.
                    	</p>
                    </div>
                    <div class="form-group">
                    	<label class="control-label">Email From*:</label>
                        <input class="form-control" type="text" name="email_from" required />
                    </div>
                    <div class="form-group">
                    	<label class="control-label">Reply To*:</label>
                        <input class="form-control" type="text" name="email_to" required />
                    </div>
                     <div class="form-group">
                    	<p>
                        	Administrator Settings this user will able to handle all users their levels their status active/ban.
                        </p>
                        <hr />
                    </div>
                    <div class="form-group">
                    	<label class="control-label">First Name:</label>
                        <input class="form-control" type="text" name="first_name" />
                    </div>
                    <div class="form-group">
                    	<label class="control-label">Last Name:</label>
                        <input class="form-control" type="text" name="last_name" />
                    </div>
                    <div class="form-group">
                    	<label class="control-label">Email*:</label>
                        <input class="form-control" type="text" name="email" required />
                    </div>
                    <div class="form-group">
                    	<label class="control-label">Password*:</label>
                        <input class="form-control" type="password" name="password" required />
                    </div>
                    <input type="hidden" name="install_submit" value="Yes" />
                    <input type="submit" value="Submit" class="btn btn-primary" />
            </form>
            <script>
				$(document).ready(function() {
					// validate the Installation form
					$("#set_install").validate();
				});
            </script>
    </div><!--//wc_wrapper--> 
</body>
</html>