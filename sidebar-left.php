<aside id="sidebar-left" class="widget-area" role="complementary">
	<div class="new-fb-btn new-fb-1 new-fb-default-anim"><div class="new-fb-1-1"><div class="new-fb-1-1-1">
	<a href="http://www.chlatvey.com/wp-login.php?loginFacebook=1&redirect=http://www.chlatvey.com" onclick="window.location = 'http://www.chlatvey.com/wp-login.php?loginFacebook=1&redirect='+window.location.href; return false;">CONNECT WITH</a>
	</div></div></div>
<?php 
	global $user_ID, $user_identity, $smof_data; 
	
	$this_user = wp_get_current_user();
	
	echo '<div class="inner-box round-6">';
	 
	if (!$user_ID) {
	    $args = array(
	        'form_id' => 'sp-loginform',
	        'label_username' => __( 'Username', SP_TEXT_DOMAIN ),
	        'label_password' => __( 'Password', SP_TEXT_DOMAIN ),
	        'label_remember' => __( 'Remember Me', SP_TEXT_DOMAIN ),
	        'label_log_in' => __( 'Log In', SP_TEXT_DOMAIN ),
	        'remember' => true
	    );
	   
	    echo '<h5>' . __( 'Sign In', SP_TEXT_DOMAIN ) . '</h5>';
	    
	    if(isset($_GET['login']) && $_GET['login'] == 'failed')
		{
			?>
				<div id="login-error" style="background-color: #FFEBE8;border:1px solid #C00;padding:5px;">
					<p>Login failed: You have entered an incorrect Username or password, please try again.</p>
				</div>
			<?php
		}
	    
	    wp_login_form( $args );
	    
		    
	} else { // If logged in:
		
		$profile_img = aq_resize( esc_attr( get_the_author_meta( 'image', $this_user->ID ) ), 80, 80, true );
		$profile_page = $smof_data['user_profile']; 
		$page = get_page_by_path($profile_page); // get page by slug name
		$weekly_quiz_score = get_the_author_meta( 'weekly_quiz_score', $this_user->ID );
		$fast_quiz_win = get_the_author_meta( 'fast_quiz_win', $this_user->ID );
		$weekly_quiz_score = ($weekly_quiz_score) ? $weekly_quiz_score : '0';
		$fast_quiz_win = ($fast_quiz_win) ? $fast_quiz_win : '0';
		
		
		echo '<div class="profile-photo">';
		echo '<div class="post-thumbnail"><a href="' . get_page_link($page->ID) . '">';
		if ($profile_img) {
			//echo '<img src="' . $profile_img . '" />';
			echo '<img src="' . esc_attr( get_the_author_meta( 'image', $this_user->ID ) ) . '" width="80" height="80" />';
		} else{
			echo '<img src="' . SP_ASSETS_THEME.'images/chlatvey-profile.png" width="80" height="80" />';	
		}
		echo '</a></div>';
		echo '</div>';
		echo '<p>Hello, <strong>', $user_identity . '</strong><br />';
		echo '<a href="' . get_page_link($page->ID) . '">' . __( 'Edit profile', SP_TEXT_DOMAIN ) . '</a><br />';
	    echo '<a href="' . wp_logout_url( home_url() ) . '">' . __( 'Logout', SP_TEXT_DOMAIN ) . '</a></p>';
	    echo '<div class="clear"></div>';
	    echo '<div class="fast-quiz-info">' . __( 'Fast quiz score', SP_TEXT_DOMAIN ) . '<div class="round-6"><span class="fast-quiz-win">' . $fast_quiz_win . '</span>' . __( ' points', SP_TEXT_DOMAIN ) . '</div></div>';
	    echo '<div class="weekly-quiz-info">' . __( 'Weekly quiz score', SP_TEXT_DOMAIN ) . '<div class="round-6"><span class="weekly-score-profile">' . $weekly_quiz_score . '</span>' . __( ' points', SP_TEXT_DOMAIN ) . '</div></div>';
	}//end if not user	
	
	echo '</div><!-- .inner-box .round-6 -->';			
?>

<?php echo sp_top_user_weekly_quiz();?>

<div class="inner-box round-6">
	<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fchlatvey&amp;width=200&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=false&amp;appId=510408359006777" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:290px;" allowTransparency="true"></iframe>
</div>

<?php if ( is_active_sidebar( 'left-sidebar' ) ) dynamic_sidebar('left-sidebar'); ?>
		
</aside> <!--End #sidebar-left-->	