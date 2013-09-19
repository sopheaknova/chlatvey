<?php
/*
Template Name: Register Page
*/
?>
	<?php 
	global $user_ID;
	$usernameError='';
	$emailError = '';
	$userExist = '';
	if (!$user_ID) { 
		if($_POST){
			//We shall SQL escape all inputs
			$username = esc_sql($_POST['username']);
			if(empty($username)) { 
				$usernameError = "User name should not be empty.";
				$hasError = true;
			}
			
			$email = esc_sql($_POST['email']);
			if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email)) { 
				$emailError =  "Please enter a valid email.";
				$hasError = true;
			}		
		
			$random_password = wp_generate_password( 12, false );
			$status = wp_create_user( $username, $random_password, $email );
			if ( ($usernameError != '' || $emailError != '') && is_wp_error($status) ) {
				$userExist = "Username already exists. Please try another one.";
				$hasError = true;
			}	
			if(!isset($hasError)) {
				$from = get_option('admin_email');
				$headers = 'From: '.$from . "\r\n";
				$subject = "Registration successful";
				$msg = "Registration successful.\nYour login details\nUsername: $username\nPassword: $random_password";
				wp_mail( $email, $subject, $msg, $headers );
				$emailSent = true;
			}	
		}	
		?>
		
		<?php get_header(); ?>		
		
		<?php get_sidebar('left'); ?>
		<div id="main" role="main">
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
			
			
		    <?php
		    while ( have_posts() ) :
				the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post -->
			<?php endwhile; ?>	
			
			<?php 					
			if(get_option('users_can_register')) { //Check whether user registration is enabled by the administrator
			?>
			
			<?php if(isset($emailSent) && $emailSent == true) { ?>
				<div class="success">
					<p class="success"><?php _e('Please check your email for login details.', SP_TEXT_DOMAIN) ?></p>
				</div>
	        <?php } ?>
	        
	        <?php if($userExist != '') { ?>
					<p class="error"><?php echo $userExist; ?></p>
	        <?php } ?>
			
			<div id="result"></div> <!-- To hold validation results -->
			<form id="wp_signup_form" action="" method="post">
				<p>
	        	<label for="name"><?php _e('Username:', SP_TEXT_DOMAIN); ?> <font>*</font></label>
	            <input type="text" name="username" class="name" value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>" />
	            <?php if($usernameError != '') { ?>
	                <span class="error"><?php echo $usernameError; ?></span> 
	            <?php } ?>
	        	</p>
				<p>
	            <label for="email"><?php _e('E-mail address:', SP_TEXT_DOMAIN); ?> <font>*</font></label>
	            <input type="text" name="email" class="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>" />
	            <?php if($emailError != '') { ?>
	                <span class="error"><?php echo $emailError; ?></span>
	            <?php } ?>
	            </p>
				<input type="submit" id="submitbtn" name="submit" value="SignUp" />		
			</form>
			
			<script type="text/javascript">  						
			$("#submitbtn").click(function() {
			
			$('#result').html('<img src="<?php bloginfo('template_url'); ?>/images/loader.gif" class="loader" />').fadeIn();
			var input_data = $('#wp_signup_form').serialize();
			$.ajax({
			type: "POST",
			url:  "<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>",
			data: input_data,
			success: function(msg){
			$('.loader').remove();
			$('<div>').html(msg).appendTo('div#result').hide().fadeIn('slow');
			}
			});
			return false;
			
			});
			</script>
			
			<?php 
				}
	
			else echo "Registration is currently disabled. Please try again later.";
			?>
				
			<?php get_sidebar('content'); ?>
		</div><!-- #main -->
	<?php get_sidebar(); ?>
	<?php get_footer(); ?>	
	
<?php } else {
	wp_redirect( home_url() ); exit;
} ?>
	
