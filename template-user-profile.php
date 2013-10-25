<?php
/*
Template Name: User Profile Page
*/
?>

<?php
/*Update User*/
global $user_ID;

if ($user_ID) {
	
	$this_user = wp_get_current_user();
	
	if(isset($_POST["save-edit"])){
	    if($_POST["password-edit"]){
	        wp_update_user( array ( 'ID' => $this_user->ID , 'user_pass' => $_POST["password-edit"] ) ) ;
	    }
	    if($_POST["edit-about"]){
	        wp_update_user( array ( 'ID' => $this_user->ID , 'description' => $_POST["edit-about"] ) ) ;
	    }
	    if(isset($_FILES["avatar-edit"])){
	
	        $temp = explode(".", $_FILES["avatar-edit"]["name"]);
	        $temp = end($temp);
	        $filename = "avatarimg_user".$this_user->ID.".".$temp;
			$wp_upload_dir = wp_upload_dir();
	        $target_path = "wp-content/uploads/" . $wp_upload_dir['subdir'] . "/" .basename($filename);
	        
	
	        if(move_uploaded_file($_FILES['avatar-edit']['tmp_name'], $target_path)){
	            $filename = $target_path;
	            $wp_filetype = wp_check_filetype(basename($filename), null );
	            
	            $profile_photo = $wp_upload_dir['url'] . '/' . basename( $filename );
	            
	            $attachment = array(
	                'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ),
	                'post_mime_type' => $wp_filetype['type'],
	                'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
	                'post_content' => '',
	                'post_status' => 'inherit'
	            );
	           	$attach_id = wp_insert_attachment( $attachment, $filename);
	           	                        
	            update_user_meta($this_user->ID, "image", $profile_photo);
	        }
	    }
	    if($_POST["email-edit"]){
	        //wp_update_user( array ( 'ID' => $this_user->ID , 'description' => $_POST["edit-about"] ) ) ;
	        $some_user = get_user_by("email",$_POST["email-edit"]);
	        if($some_user && ($some_user->ID != $this_user->ID) ){
	            wp_die(__("This e-mail is already in use, please use another one.","um_lang")." <a href='".site_url()."/'>".__("Back","um_lang")."</a>");
	        }else{
	            wp_update_user( array ( 'ID' => $this_user->ID , 'user_email' => $_POST["email-edit"] ) ) ;
	        }
	    }
	    if ($_POST["first-name-edit"]){
		    wp_update_user( array ( 'ID' => $this_user->ID , 'first_name' => $_POST["first-name-edit"] ) ) ;
	    }
	    if ($_POST["last-name-edit"]){
		    wp_update_user( array ( 'ID' => $this_user->ID , 'last_name' => $_POST["last-name-edit"] ) ) ;
	    }
	    if ($_POST["user-phone-edit"]){
		    update_user_meta( $this_user->ID , 'phone_number', $_POST["user-phone-edit"] ) ;
	    }
	    if ($_POST["gender-edit"]){
		    update_user_meta( $this_user->ID , 'gender', $_POST["gender-edit"] ) ;
	    }
	    if ($_POST["user-address-edit"]){
		    update_user_meta( $this_user->ID , 'user_address', $_POST["user-address-edit"] ) ;
	    }
	    /*
$profile_page = $smof_data['user_profile']; 
		$page = get_page_by_path($profile_page);
	    wp_redirect(site_url()."/".get_page_link($page->ID));
	    die(__("Saving Data...", SP_TEXT_DOMAIN));
*/
	}
	/*Update User*/
	
	?>
	
	<?php get_header(); ?>		
			
			<?php get_sidebar('left'); ?>
			<div id="main" role="main">
				<div class="inner-box round-6">
				
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
				
				<form action="" class="edit-profile" method="post" enctype="multipart/form-data">
					<p>
						<label for="name-edit"><?php _e("Username",SP_TEXT_DOMAIN); ?></label>
						<input type="text" id="name-edit" name="name-edit" readonly="readonly" value="<?php the_author_meta("user_login",$this_user->ID); ?>" disabled>
					</p>
					<p>
						<label for="password-edit"><?php _e("Password",SP_TEXT_DOMAIN); ?></label>
						<input type="password" id="password-edit" name="password-edit">
					</p>
					<p>
						<label for="email-edit"><?php _e("Email",SP_TEXT_DOMAIN); ?></label>
						<input type="email" id="email-edit" name="email-edit" placeholder="<?php the_author_meta("user_email",$this_user->ID); ?>">
					</p>
					<p>
					<?php 
					$profile_img = aq_resize( esc_attr( get_the_author_meta( 'image', $this_user->ID ) ), 80, 80, true ); 
				?>
	                <div class="post-thumbnail">
	                <?php
	                if ($profile_img) {
						//echo '<img src="' . $profile_img . '" />';
						echo '<img src="' . esc_attr( get_the_author_meta( 'image', $this_user->ID ) ) . '" width="80" height="80" />';
					} else{
						echo '<img src="' . SP_ASSETS_THEME.'images/chlatvey-profile.png" width="80" height="80" />';	
					}
	                ?>			
	                </div>
					<input type="file" id="avatar-edit" name="avatar-edit">
					</p>
					
					<p class="two-fourth">
						<label for="first-name-edit"><?php _e("Frist name",SP_TEXT_DOMAIN); ?></label>
						<input type="text" id="first-name-edit" name="first-name-edit" value="<?php the_author_meta("first_name",$this_user->ID); ?>">
					</p>
					
					<p class="two-fourth last">
						<label for="last-name-edit"><?php _e("Last name",SP_TEXT_DOMAIN); ?></label>
						<input type="text" id="last-name-edit" name="last-name-edit" value="<?php the_author_meta("last_name",$this_user->ID); ?>">
					</p>
					<p class="two-fourth">
						<label for="gender-edit"><?php _e("Gender",SP_TEXT_DOMAIN); ?></label>
						<select name="gender-edit">
						  <option <?php if( get_the_author_meta( 'gender', $this_user->ID ) === 'Male'){echo 'selected';} ?> value="Male">Male</option>
						  <option <?php if(get_the_author_meta( 'gender', $this_user->ID ) === 'Female' ){echo 'selected';} ?> value="Female">Female</option>
						</select>
					</p>
					<p class="two-fourth last">
						<label for="user-phone-edit"><?php _e("Phone number",SP_TEXT_DOMAIN); ?></label>
						<input type="text" id="user-phone-edit" name="user-phone-edit" value="<?php the_author_meta("phone_number",$this_user->ID); ?>">
					</p>
					<p>
						<label for="user-address-edit"><?php _e("Address",SP_TEXT_DOMAIN); ?></label>
						<input type="text" id="user-address-edit" name="user-address-edit" value="<?php the_author_meta("user_address",$this_user->ID); ?>">
					</p>
					<p>
						<label for="edit-about"><?php _e("About",SP_TEXT_DOMAIN); ?></label>
						<textarea name="edit-about" id="edit-about"><?php the_author_meta("description",$this_user->ID); ?></textarea>
					</p>
					<p>
						<input type="submit" id="save-edit" name="save-edit" value="Save">
					</p>
				</form>
				
				</div> <!-- .inner-box .round-6 -->
				
			</div><!-- #main -->
	
	<?php get_sidebar(); ?>
	<?php get_footer(); ?>
	
<?php } else {
	wp_redirect( home_url() ); exit;
} ?>	