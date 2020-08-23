<?php
	include('system_load.php');
	//This loads system.
	
	if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != '') { 
		HEADER('LOCATION: dashboard.php');
	} //If user is loged in redirect to specific page.
	
	$new_user = new Users; //creating user object.
	
	if(isset($_POST['forgot_pass'])) {
		$forgot_pass = $_POST['forgot_pass'];
		if($forgot_pass == 1){
			extract($_POST);
			$message = $new_user->forgot_user($email);
		}//processing forgot password Email sending.
	}//if isset forgot pass
	
	if(isset($_POST['reset_form'])) {
		$reset_form = $_POST['reset_form'];
		if($reset_form == 1){
			extract($_POST);
			if($password!=$match_password){
				$message = 'Passwords doesnt match. Enter again';	
			} else {
			   $confirmation_code = $_GET['confirmation_code'];
			   $message = $new_user->reset_pass_user($_GET['user_id'],$confirmation_code,$password);
			}
		}//reset Form reset password processing.
	}//isset reset_ form
	
	$page_title = "Forgot Password!"; //You can edit this to change your page title.
	require_once('includes/header.php');
	?>
<div class="container">
	<?php
		if(isset($message) && $message != '') { 
			echo '<div class="alert alert-success">';
			echo $message;
			echo '</div>';
		}
	?>
<link rel="stylesheet" type="text/css" href="css/signin.css" media="all" />
         <?php if(!isset($_GET['confirmation_code']) || $_GET['confirmation_code'] == '') : ?>   
        <form action="<?php $_SERVER['PHP_SELF']?>" class="form-signin" id="forgot_form" name="forgot" method="post">
            <label>Please enter your email address or username to recover your password.</label>
                <input type="text" class="form-control" placeholder="Username OR Email*" name="email" required="required" />
                <input type="submit" class="btn btn-lg btn-primary btn-block" value="Submit" />
 	            <input type="hidden" name="forgot_pass" value="1" />
            </form>
            <script>
				$(document).ready(function() {
					// validate the register form
					$("#forgot_form").validate();
				});
            </script>
			<?php else: ?>
            <form action="<?php $_SERVER['PHP_SELF']?>" class="form-signin" id="reset_form" name="reset_form" method="post">
                <input type="password" name="password" class="form-control" placeholder="New Password" required="required" />
                <input type="password" name="match_password" class="form-control" placeholder="Confirm Password" required="required"/>
                <input type="hidden" value="1" name="reset_form" />
                <input type="submit" class="btn btn-lg btn-primary btn-block" value="Submit" />
            </form>
            <script>
				$(document).ready(function() {
					// validate the register form
					$("#reset_form").validate();
				});
            </script>
            <?php endif; ?>

        <div class="text-center">
        	Already have an account? <a href="login.php">Sign in</a><br />
            Not a member yet? <a href="register.php">Sign up</a>
        </div>
<?php
	require_once("includes/footer.php");
?>