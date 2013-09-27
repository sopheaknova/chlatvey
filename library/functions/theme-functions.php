<?php

/* ---------------------------------------------------------------------- */
/*	Show main and footer navigation
/* ---------------------------------------------------------------------- */

// Left menu
if( !function_exists('sp_main_left')) {

	function sp_main_left() {
		
		// set default main menu if wp_nav_menu not active
		if ( function_exists ( 'wp_nav_menu' ) )
			wp_nav_menu( array(
				'container'      => false,
				'menu_class'	 => 'nav-menu clear',
				'theme_location' => 'left-main-menu',
				'fallback_cb' => 'sp_main_left_fallback'
				) );
		else
			sp_main_left_fallback();	
	}
}

if (!function_exists('sp_main_left_fallback')) {
	
	function sp_main_left_fallback() {
    	
		$menu_html = '<ul class="nav-menu clear">';
		$menu_html .= '<li><a href="'.admin_url('nav-menus.php').'">'.esc_html__('Add Main menu', SP_TEXT_DOMAIN).'</a></li>';
		$menu_html .= '</ul>';
		echo $menu_html;
		
	}
	
}

// Right menu
if( !function_exists('sp_main_right')) {

	function sp_main_right() {
		
		// set default main menu if wp_nav_menu not active
		if ( function_exists ( 'wp_nav_menu' ) )
			wp_nav_menu( array(
				'container'      => false,
				'menu_class'	 => 'nav-menu clear',
				'theme_location' => 'right-main-menu',
				'fallback_cb' => 'sp_main_right_fallback'
				) );
		else
			sp_main_right_fallback();	
	}
}

if (!function_exists('sp_main_right_fallback')) {
	
	function sp_main_right_fallback() {
    	
		$menu_html = '<ul class="nav-menu clear">';
		$menu_html .= '<li><a href="'.admin_url('nav-menus.php').'">'.esc_html__('Add Main menu', SP_TEXT_DOMAIN).'</a></li>';
		$menu_html .= '</ul>';
		echo $menu_html;
		
	}
	
}

// Footer menu
if (!function_exists('sp_footer_navigation')){
	
	function sp_footer_navigation() {
		
		// set default main menu if wp_nav_menu not active
		if ( function_exists ( 'wp_nav_menu' ) )
			wp_nav_menu( array(
				'container'      => false,
				'menu_class'	 => 'footer-nav',
				'after'		 	 => ' &nbsp;',
				'theme_location' => 'footer-menu',
				'fallback_cb'	 => 'sp_footer_nav_fallback'
				));	
		else
			sp_footer_nav_fallback();	
	}
}

if (!function_exists('sp_footer_nav_fallback')) {
	
	function sp_footer_nav_fallback() {
    	
		$menu_html .= '<ul class="footer-nav">';
		$menu_html .= '<li><a href="'.admin_url('nav-menus.php').'">'.esc_html__('Add Footer menu', SP_TEXT_DOMAIN).'</a></li>';
		$menu_html .= '</ul>';
		echo $menu_html;
		
	}
	
}

/* ---------------------------------------------------------------------- */
/*	Full Meta post entry
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_post_meta' ) ) {
	function sp_post_meta() {
		printf( __( '<span class="posted-on">Posted on </span><a href="%1$s" title="%2$s"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> by </span><span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span><span class="posted-in"> in </span>%8$s ', SP_TEXT_DOMAIN ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', SP_TEXT_DOMAIN ), get_the_author() ) ),
			get_the_author(),
			get_the_category_list( ', ' )
		);
		if ( comments_open() ) : ?>
				<span class="with-comments"><?php _e( ' with ', SP_TEXT_DOMAIN ); ?></span>
				<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . __( '0 Comments', SP_TEXT_DOMAIN ) . '</span>', __( '1 Comment', SP_TEXT_DOMAIN ), __( '% Comments', SP_TEXT_DOMAIN ) ); ?></span>
		<?php endif; // End if comments_open() ?>
		<?php edit_post_link( __( 'Edit', SP_TEXT_DOMAIN ), '<span class="sep"> | </span><span class="edit-link">', '</span>' );
	}
};

/* ---------------------------------------------------------------------- */
/*	Mini Meta post entry
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_meta_mini' ) ) :
	function sp_meta_mini() {
		printf( __( '<a href="%1$s" title="%2$s"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="sep"> |  </span>', SP_TEXT_DOMAIN ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
			//get_the_category_list( ', ' )
		);
		if ( comments_open() ) : ?>
				<span class="sep"><?php _e( ' | ', SP_TEXT_DOMAIN ); ?></span>
				<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . __( '0 Comments', SP_TEXT_DOMAIN ) . '</span>', __( '1 Comment', SP_TEXT_DOMAIN ), __( '% Comments', SP_TEXT_DOMAIN ) ); ?></span>
		<?php endif; // End if comments_open()
	}
endif;

/* ---------------------------------------------------------------------- */
/*	Embeded add video from youtube, vimeo and dailymotion
/* ---------------------------------------------------------------------- */
function sp_get_video_img($url) {
	
	$video_url = @parse_url($url);
	$output = '';

	if ( $video_url['host'] == 'www.youtube.com' || $video_url['host']  == 'youtube.com' ) {
		parse_str( @parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		$video_id =  $my_array_of_vars['v'] ;
		$output .= 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
	}elseif( $video_url['host'] == 'www.youtu.be' || $video_url['host']  == 'youtu.be' ){
		$video_id = substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .= 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
	}
	elseif( $video_url['host'] == 'www.vimeo.com' || $video_url['host']  == 'vimeo.com' ){
		$video_id = (int) substr(@parse_url($url, PHP_URL_PATH), 1);
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
		$output .=$hash[0]['thumbnail_large'];
	}
	elseif( $video_url['host'] == 'www.dailymotion.com' || $video_url['host']  == 'dailymotion.com' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 7);
		$video_id = strtok($video, '_');
		$output .='http://www.dailymotion.com/thumbnail/video/'.$video_id;
	}

	return $output;
	
}

/* ---------------------------------------------------------------------- */
/*	Embeded add video from youtube, vimeo and dailymotion
/* ---------------------------------------------------------------------- */
function sp_add_video ($url, $width = 620, $height = 349) {

	$video_url = @parse_url($url);
	$output = '';

	if ( $video_url['host'] == 'www.youtube.com' || $video_url['host']  == 'youtube.com' ) {
		parse_str( @parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		$video =  $my_array_of_vars['v'] ;
		$output .='<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.youtu.be' || $video_url['host']  == 'youtu.be' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .='<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.vimeo.com' || $video_url['host']  == 'vimeo.com' ){
		$video = (int) substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .='<iframe src="http://player.vimeo.com/video/'.$video.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.dailymotion.com' || $video_url['host']  == 'dailymotion.com' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 7);
		$video_id = strtok($video, '_');
		$output .='<iframe frameborder="0" width="'.$width.'" height="'.$height.'" src="http://www.dailymotion.com/embed/video/'.$video_id.'"></iframe>';
	}

	return $output;
}

/* ---------------------------------------------------------------------- */
/*	Show weekly quiz
/* ---------------------------------------------------------------------- */
function sp_weekly_show_quiz(){
	global $post, $user_ID, $smof_data;
	
	if ($user_ID) {
	
		$settings = get_option( "deal_theme_settings" );
		$terms_page = get_page_by_title($smof_data['terms_page']); 
		$terms_link = get_page_link($terms_page->ID);
		
		$html = "<div class='entry-body'>";
		$html .= "<div id='timer' class='round-6 orange number'></div>";
		$html .= "<div class='clear'></div>";
		$html .= "<div class='entry-content'>" . __("Play to save score to win ", SP_TEXT_DOMAIN) . "<span class='deal-title'>" . $settings['deal_weekly_gift'] . "</span></div>";
		$html .= "<form action='' id='form-start-quiz' method='POST'>";
		$html .= "<label><input type='checkbox' value='' name='terms_of_services' class='terms-services' />" . __("In order to use our services, you must agree to Chlatvey's <a href='$terms_link' target='_blank'>Terms of Service</a>.", SP_TEXT_DOMAIN) . "</label>";
		
		$html .= "<input type='submit' value='". __("Start Now", SP_TEXT_DOMAIN) ."' class='start-quiz' />";
		$html .= "</form>";
		$html .= "</div>";
		
		$html .= "<div id='quiz-panel'>";
	    
	    $questions_str = "";
		
			$quiz_num = 5;
		    $args = array(
		        'post_type' => 'quizzes',
		        'orderby' => 'rand',
		        'post_status' => 'publish',
		        'posts_per_page' => $quiz_num
		    );
		 
			$query = null;
			$query = new WP_Query($args);
			$quiz_index = 1;
		    while ( $query->have_posts() ) : $query->the_post();
		 
		        // Generating the HTML for Questions
		        $question_id = get_the_ID();
		        $question = the_title("", "", FALSE);
		
		        $questions_str .= "<li>";
		        $questions_str .= "<div class='ques-title'><div class='quiz-num'>". __('Question number ', SP_TEXT_DOMAIN) ."<span class='number'>{$quiz_index}</span></div>{$question}</div>";
		        $questions_str .= "<div class='ques-answers' data-quiz-id='{$question_id}' >";
		
		        $quiestion_index = 1;
		        for ($i = 1; $i <= 4; $i++) {
		            $questions_str .= "<span class='answer-num'>{$quiestion_index}</span> <input type='radio' value='{$quiestion_index}' name='ans_{$question_id}[]' />" . get_post_meta($question_id, "sp_answer_{$i}", true) . "<br/>";
		            $quiestion_index++;
		        }
		
		        $questions_str .= "</div></li>";
		
		        $quiz_index++;
		 
		    endwhile;
		    wp_reset_query();
	    
	    		$html .= "<ul class='quiz-slider'>{$questions_str}</ul>";
	            $html .= "<div class='quiz-nav'></div>";
	    $html .= "</div><!-- #quiz_panel -->";
		
		$html .= sp_weekly_quiz_result();
				
		$html .= "<div class='show-result-btn sky-blue round-6'>" . __('Result', SP_TEXT_DOMAIN) . "</div>";
        $html .= "<div id='quiz-result'></div>";
        
        $html .= "<div class='continue-quiz'>";
        $html .= "<p>" . __('Continue play to be winner', SP_TEXT_DOMAIN) . "</p>";
        $html .= sp_continue_quiz();
        $html .= "</div>";
	    
	} else {
		$html = "<p>" . __('You must login to play quiz.', SP_TEXT_DOMAIN) . "</p>";
	}  
    return $html;
}

/* ---------------------------------------------------------------------- */
/*	Show fast quiz
/* ---------------------------------------------------------------------- */
function sp_fast_show_quiz(){
	global $post, $user_ID, $smof_data;
	
	if ($user_ID) {
	
		$settings = get_option( "deal_theme_settings" );
		$terms_page = get_page_by_title($smof_data['terms_page']); 
		$terms_link = get_page_link($terms_page->ID);
		
		$html = "<div class='entry-body'>";
		$html .= "<div id='timer' class='round-6 orange number'></div>";
		$html .= "<div class='clear'></div>";
		$html .= "<div class='entry-content'>" . __("Play to win ", SP_TEXT_DOMAIN) . "<span class='deal-title'>" . $settings['deal_fast_gift'] . "</span></div>";
		$html .= "<form action='' id='form-start-quiz' method='POST'>";
		$html .= "<label><input type='checkbox' value='' name='terms_of_services' class='terms-services' />" . __("In order to use our services, you must agree to Chlatvey's <a href='$terms_link' target='_blank'>Terms of Service</a>.", SP_TEXT_DOMAIN) . "</label>";
		
		$html .= "<input type='submit' value='". __("Start Now", SP_TEXT_DOMAIN) ."' class='start-quiz' />";
		$html .= "</form>";
		$html .= "</div>";
		
		$html .= "<div id='quiz-panel'>";
	    
	    $questions_str = "";
		
			$quiz_num = 5;
		    $args = array(
		        'post_type' => 'quizzes',
		        'orderby' => 'rand',
		        'post_status' => 'publish',
		        'posts_per_page' => $quiz_num
		    );
		 
			$query = null;
			$query = new WP_Query($args);
			$quiz_index = 1;
		    while ( $query->have_posts() ) : $query->the_post();
		 
		        // Generating the HTML for Questions
		        $question_id = get_the_ID();
		        $question = the_title("", "", FALSE);
		
		        $questions_str .= "<li>";
		        $questions_str .= "<div class='ques-title'><div class='quiz-num'>". __('Question number ', SP_TEXT_DOMAIN) ."<span class='number'>{$quiz_index}</span></div>{$question}</div>";
		        $questions_str .= "<div class='ques-answers' data-quiz-id='{$question_id}' >";
		
		        $quiestion_index = 1;
		        for ($i = 1; $i <= 4; $i++) {
		            $questions_str .= "<span class='answer-num'>{$quiestion_index}</span> <input type='radio' value='{$quiestion_index}' name='ans_{$question_id}[]' />" . get_post_meta($question_id, "sp_answer_{$i}", true) . "<br/>";
		            $quiestion_index++;
		        }
		
		        $questions_str .= "</div></li>";
		
		        $quiz_index++;
		 
		    endwhile;
		    wp_reset_query();
	    
	    		$html .= "<ul class='quiz-slider'>{$questions_str}</ul>";
	            $html .= "<div class='quiz-nav'></div>";
	    $html .= "</div><!-- #quiz_panel -->";
		
		$html .= sp_fast_quiz_success();
		
		$html .= sp_fast_quiz_fail();
		
		$html .= "<div class='show-result-btn sky-blue round-6'>" . __('Result', SP_TEXT_DOMAIN) . "</div>";
        $html .= "<div id='quiz-result'></div>";
        
        $html .= "<div class='continue-quiz'>";
        $html .= "<p>" . __('Continue play to be winner', SP_TEXT_DOMAIN) . "</p>";
        $html .= sp_continue_quiz();
        $html .= "</div>";
	    
	} else {
		$html = "<p>" . __('You must login to play quiz.', SP_TEXT_DOMAIN) . "</p>";
	}  
    return $html;
}

/* ---------------------------------------------------------------------- */
/*	Quiz message
/* ---------------------------------------------------------------------- */

/* Weekly message result */
function sp_weekly_quiz_result(){
	//global $user_ID, $user_identity;
	$this_user = wp_get_current_user();
	
	$output = '<div id="weekly-result-info" class="entry-success sky-blue round-6">';
	$output .= '<p>' . __('You have completed answer weekly quiz and Your total score', SP_TEXT_DOMAIN) . '</p>';
	$output .= '<h5><span class="weekly-score">' . get_the_author_meta( 'weekly_quiz_score', $this_user->ID ) . ' </span><span class="attr">' . __('Points', SP_TEXT_DOMAIN) . '</span></h5>';
	$output .= '</div>';
	
	return $output;
}


/* Fast message success */
function sp_fast_quiz_success(){
	
	$settings = get_option( "deal_theme_settings" );
	
	$output = '<div id="fast-quiz-success" class="entry-success sky-blue round-6">';
	$output .= '<h4>' . __('Congratulation!', SP_TEXT_DOMAIN) . '</h4>';
	$output .= '<p>' . __('You got 5 correct answers. You will get gift', SP_TEXT_DOMAIN) . '</p>';
	$output .= '<h5>' . $settings['deal_fast_gift'] . '</h5>';
	$output .= '<p>' . __('Our assistant will contact shortly to give you gift', SP_TEXT_DOMAIN) . '</p>';
	$output .= '</div>';
	
	return $output;
}

/* Fast message fail */
function sp_fast_quiz_fail(){
	
	$output = '<div id="fast-quiz-fail" class="entry-fail red round-6">';
	$output .= '<h4>' . __('Sorry!', SP_TEXT_DOMAIN) . '</h4>';
	$output .= '<p>' . __('Your answer are not correctly at all.', SP_TEXT_DOMAIN) . '</p>';
	$output .= '</div>';
	
	return $output;
}

/* Continue play quiz */
function sp_continue_quiz(){
	global $smof_data;
	
	$fast_quiz_page = get_page_by_title($smof_data['fast_quiz_page']);
	$weekly_quiz_page = get_page_by_title($smof_data['weekly_quiz_page']);
		
	$output = '<div class="start-up-quiz">';
	$output .= '<a class="orange round-6" href="' . get_page_link($fast_quiz_page->ID) . '">' . $fast_quiz_page->post_title . '</a>';
	
	$output .= '<a class="orange round-6" href="' . get_page_link($weekly_quiz_page->ID) . '">' . $weekly_quiz_page->post_title . '</a>';
	$output .= '</div>';
	
	return $output;
}

/* ---------------------------------------------------------------------- */
/*	Get Quiz Result
/* ---------------------------------------------------------------------- */
function get_quiz_results() {
	
	$this_user = wp_get_current_user();
	
	$score = 0;
	
	$quiz_type = $_POST["quiztype"];
	if ($quiz_type == 'fast')
		$fast_score = get_the_author_meta( 'fast_quiz_win', $this_user->ID );
	elseif ($quiz_type == 'weekly')
		$weekly_score = get_the_author_meta( 'weekly_quiz_score', $this_user->ID );	
		
    $question_answers = $_POST["data"];
    $question_results = array();
    foreach ($question_answers as $ques_id => $answer) {
        $question_id = str_replace("qid_", "", $ques_id);

        $correct_answer = get_post_meta($question_id, 'sp_correct_answer', true);
        if ($answer == $correct_answer) {
        	$score++;
            $question_results["$question_id"] = array("answer" => $answer, "correct_answer" => $correct_answer, "mark" => "correct");
        } else {
            $question_results["$question_id"] = array("answer" => $answer, "correct_answer" => $correct_answer, "mark" => "incorrect");
        }
    }

    //update score to user meta field
    if ($quiz_type == 'fast' && $score == '5'):
    	
    	$first_name = get_the_author_meta( 'user_firstname', $this_user->ID );
    	$last_name = get_the_author_meta( 'user_lastname', $this_user->ID );
    	$email = get_the_author_meta( 'user_email', $this_user->ID );
    	$phone = get_the_author_meta( 'phone_number', $this_user->ID );
    	
		update_user_meta( $this_user->ID , 'fast_quiz_win', ($fast_score+1) );
		sp_send_mail_notification($first_name, $last_name, $email, $phone);
	elseif ($quiz_type == 'weekly') :
		update_user_meta( $this_user->ID , 'weekly_quiz_score', ($weekly_score+$score) );
	endif;	
    
    $total_questions = count($question_answers);

    $quiz_result_data = array(
        "total_questions" => $total_questions,
        "score" => $score,
        "result" => $question_results
    );
    
    echo json_encode($quiz_result_data);
    exit;
}

add_action('wp_ajax_nopriv_get_quiz_results', 'get_quiz_results'); //executes for users that are not logged in.
add_action('wp_ajax_get_quiz_results', 'get_quiz_results');

function sp_send_mail_notification($last_name, $first_name, $email, $phone){
	global $smof_data;
	
	$emailTo = $smof_data['email_notify'];
	$subject = 'Fast Quiz Winner name ' . $first_name . ' ' . $last_name;
	$body = "Dear Chlatvey Admin \n\n Today Fast Quiz winner name: $last_name \n\nEmail: $email \n\nPhone: $phone";
	$headers = 'From: '.$first_name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
	
	mail($emailTo, $subject, $body, $headers);
}

/* ---------------------------------------------------------------------- */
/*	Portfolio
/* ---------------------------------------------------------------------- */

function sp_soundcloud($url , $autoplay = 'false' ) {
	return '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.$url.'&amp;auto_play='.$autoplay.'&amp;show_artwork=true"></iframe>';
}

function sp_portfolio_grid( $col = 'list', $posts_per_page = 5 ) {
	
	$temp ='';
	$output = '';
	
	$args = array(
			'posts_per_page' => (int) $posts_per_page,
			'post_type' => 'portfolio',
			);
			
	$post_list = new WP_Query($args);
		
	ob_start();
	if ($post_list && $post_list->have_posts()) {
		
		$output .= '<ul class="portfolio ' . $col . '">';
		
		while ($post_list->have_posts()) : $post_list->the_post();
		
		$output .= '<li>';
		$output .= '<div class="two-fourth"><div class="post-thumbnail">';
		$output .= '<a href="'.get_permalink().'"><img src="' . sp_post_thumbnail('portfolio-2col') . '" /></a>';
		$output .= '</div></div>';
		
		$output .= '<div class="two-fourth last">';
		$output .= '<a href="'.get_permalink().'" class="port-'. $col .'-title">' . get_the_title() .'</a>';
		$output .= '</div>';	
		
		$output .= '</li>';	
		endwhile;
		
		$output .= '</ul>';
		
	}
	$temp = ob_get_clean();
	$output .= $temp;
	
	wp_reset_postdata();
	
	return $output;
	
}

/* ---------------------------------------------------------------------- */
/*	Get Most Racent posts from Category
/* ---------------------------------------------------------------------- */
function sp_last_posts_cat($numberOfPosts = 5 , $thumb = true , $cats = 1){
	global $post;
	$orig_post = $post;
	
	( is_single() ) ? $exclude = $post->ID : $exclude = false;
		
	if ($exclude)
		$lastPosts = get_posts('category='.$cats.'&numberposts='.$numberOfPosts.'&exclude='.$exclude);
	else
		$lastPosts = get_posts('category='.$cats.'&numberposts='.$numberOfPosts);	
		
?>
	<ul>
<?php foreach($lastPosts as $post): setup_postdata($post); ?>
		<li>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', SP_TEXT_DOMAIN ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
				<img src="<?php echo sp_post_image('widget'); ?>" width="60" height="60" />
	            </a>
			</div><!-- post-thumbnail /-->
			<p><a href="<?php the_permalink(); ?>"><?php the_title();?></a></p>
			<div class="entry-meta"><?php echo sp_meta_mini(); ?></div>
		</li>
<?php endforeach; ?>	
	</ul>
	<div class="clear"></div>
<?php
	$post = $orig_post;
	wp_reset_postdata();
}

/* ---------------------------------------------------------------------- */
/*	Get Post image
/* ---------------------------------------------------------------------- */

if( !function_exists('sp_post_image')) {

	function sp_post_image($size = 'thumbnail'){
		global $post;
		$image = '';
		
		//get the post thumbnail;
		$image = sp_post_thumbnail($size);
		if ($image) return $image;
		
		//if the post is video post and haven't a feutre image
		$post_type = get_post_format($post->ID);
		//$vId = get_post_meta($post->ID, 'sp_video_id', true);
		$video_url = get_post_meta($post->ID, 'sp_video_id', true);
		
		if($post_type == 'video')
			$image = sp_get_video_img($video_url);
		
		if($post_type == 'audio') 
			$image = SP_ASSETS_THEME . 'images/sound-post-thumb.gif'; // use placeholder image or sound icon
						
		if ($image) return $image;
		
		//If there is still no image, get the first image from the post
		return sp_get_first_image();
	}
		

}

/* ---------------------------------------------------------------------- */
/*	Get Post Thumbnail
/* ---------------------------------------------------------------------- */
if( !function_exists('sp_post_thumbnail')) {

	function sp_post_thumbnail($size = 'thumbnail'){
		global $post;
		$thumb = '';
		
		//get the post thumbnail;
		$thumb_id = get_post_thumbnail_id($post->ID);
		$thumb_url = wp_get_attachment_image_src($thumb_id, $size);
		$thumb = $thumb_url[0];
		if ($thumb) return $thumb;
	}
		

}

/* ---------------------------------------------------------------------- */
/*	Get first image in post
/* ---------------------------------------------------------------------- */
if( !function_exists('sp_get_first_image')) {
	
	function sp_get_first_image() {
		global $post, $posts;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$first_img = $matches[1][0];
		
		return $first_img;
	}
}

/* ---------------------------------------------------------------------- */
/*	Display excerpt more
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_auto_excerpt_more' ) ) {
	function sp_auto_excerpt_more( $more ) {
		return '&hellip;';
	}
} 
add_filter('excerpt_more', 'sp_auto_excerpt_more');

/* ---------------------------------------------------------------------- */
/*	Sets the post excerpt length by word
/* ---------------------------------------------------------------------- */
function sp_excerpt_length( $length ) {
	global $post;
	
	$content = $post->post_content;
	$words = explode(' ', $content, $length + 1);
	if(count($words) > $length) :
		array_pop($words);
		array_push($words, '...');
		$content = implode(' ', $words);
	endif;
  
	$content = strip_tags(strip_shortcodes($content));
  
	return $content;

}
add_filter('excerpt_length', 'sp_excerpt_length');

/* ---------------------------------------------------------------------- */
/*	Sets the post excerpt length by string length
/* ---------------------------------------------------------------------- */
function sp_excerpt_string_length( $str_length = 130 ) {
	global $post;
		//$excerpt = ( $str_decode ) ? utf8_decode($post->post_excerpt) : $post->post_excerpt;
		$excerpt = $post->post_excerpt;
		if($excerpt==''){
		$excerpt = get_the_content();
		}
		
		echo wp_html_excerpt($excerpt,$str_length) . '...';
}

/* ---------------------------------------------------------------------- */
/*	Blog navigation
/* ---------------------------------------------------------------------- */

if ( !function_exists('sp_pagination') ) {

	function sp_pagination( $pages = '', $range = 2 ) {

		$showitems = ( $range * 2 ) + 1;

		global $paged, $wp_query;

		if( empty( $paged ) )
			$paged = 1;

		if( $pages == '' ) {

			$pages = $wp_query->max_num_pages;

			if( !$pages )
				$pages = 1;

		}

		if( 1 != $pages ) {

			$output = '<nav class="pagination">';

			// if( $paged > 2 && $paged >= $range + 1 /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( 1 ) . '" class="next">&laquo; ' . __('First', 'sptheme_admin') . '</a>';

			if( $paged > 1 /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged - 1 ) . '" class="next">&larr; ' . __('Previous', SP_TEXT_DOMAIN) . '</a>';

			for ( $i = 1; $i <= $pages; $i++ )  {

				if ( 1 != $pages && ( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) )
					$output .= ( $paged == $i ) ? '<span class="current">' . $i . '</span>' : '<a href="' . get_pagenum_link( $i ) . '">' . $i . '</a>';

			}

			if ( $paged < $pages /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged + 1 ) . '" class="prev">' . __('Next', SP_TEXT_DOMAIN) . ' &rarr;</a>';

			// if ( $paged < $pages - 1 && $paged + $range - 1 <= $pages /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( $pages ) . '" class="prev">' . __('Last', 'sptheme_admin') . ' &raquo;</a>';

			$output .= '</nav>';

			return $output;

		}

	}

}


/* ---------------------------------------------------------------------- */
/*	Highlight Search result
/* ---------------------------------------------------------------------- */
/**
 * Highlight search result titles and excerpt
 */
if ( ! function_exists( 'highlight_search_title' ) ) :
	function highlight_search_title() {
		$title = get_the_title();
		$keys = implode( '|', explode(' ', get_search_query() ) );
		$keys = preg_quote( $keys );
		$title = preg_replace( '/(' . $keys . ')/iu', '<ins>\0</ins>', $title );
		echo $title;
	}
endif;

if ( ! function_exists( 'highlight_search_excerpt' ) ) :
	function highlight_search_excerpt() {
		$excerpt = get_the_excerpt();
		$keys = implode( '|', explode( ' ', get_search_query() ) );
		$keys = preg_quote( $keys );
		$excerpt = preg_replace( '/(' . $keys . ')/iu', '<ins>\0</ins>', $excerpt );
		echo '<p>' . $excerpt . '</p>';
	}
endif;

/* ---------------------------------------------------------------------- */
/*	Blog navigation
/* ---------------------------------------------------------------------- */

if ( !function_exists('sp_pagination') ) {

	function sp_pagination( $pages = '', $range = 2 ) {

		$showitems = ( $range * 2 ) + 1;

		global $paged, $wp_query;

		if( empty( $paged ) )
			$paged = 1;

		if( $pages == '' ) {

			$pages = $wp_query->max_num_pages;

			if( !$pages )
				$pages = 1;

		}

		if( 1 != $pages ) {

			$output = '<nav class="pagination">';

			// if( $paged > 2 && $paged >= $range + 1 /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( 1 ) . '" class="next">&laquo; ' . __('First', SP_TEXT_DOMAIN) . '</a>';

			if( $paged > 1 /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged - 1 ) . '" class="next">&larr; ' . __('Previous', SP_TEXT_DOMAIN) . '</a>';

			for ( $i = 1; $i <= $pages; $i++ )  {

				if ( 1 != $pages && ( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) )
					$output .= ( $paged == $i ) ? '<span class="current">' . $i . '</span>' : '<a href="' . get_pagenum_link( $i ) . '">' . $i . '</a>';

			}

			if ( $paged < $pages /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged + 1 ) . '" class="prev">' . __('Next', SP_TEXT_DOMAIN) . ' &rarr;</a>';

			// if ( $paged < $pages - 1 && $paged + $range - 1 <= $pages /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( $pages ) . '" class="prev">' . __('Last', SP_TEXT_DOMAIN) . ' &raquo;</a>';

			$output .= '</nav>';

			return $output;

		}

	}

}

function app_output_buffer() {
	ob_start();
} // soi_output_buffer
add_action('init', 'app_output_buffer');

/* ---------------------------------------------------------------------- */
/*	Get deal name by type
/* ---------------------------------------------------------------------- */
function sp_get_deal_name( $post_type, $tax_slug ){
	global $post;
	$orig_post = $post;
	
	$args = array(
			'post_type'		=> $post_type,
			'posts_per_page'	=> 1,
			'tax_query' => array(
				array(
					'taxonomy' => 'deal-category',
					'field' => 'slug',
					'terms' => $tax_slug
				)
			)
	);
	
	$deals = get_posts( $args );
	
	foreach ( $deals as $post ) : setup_postdata( $post );
		return '<strong>' . get_the_title() . '</strong>';
	endforeach; 
	
	$post = $orig_post;
	wp_reset_postdata();		
}

/* ---------------------------------------------------------------------- */
/*	Show top 10 user of weeky quiz score
/* ---------------------------------------------------------------------- */
function sp_top_user_weekly_quiz(){
	global $wpdb;
	
	$output = '<div class="inner-box round-6">';
	$output .= '<div class="widget-title"><h3>' . __('Top 10 weekly quiz', SP_TEXT_DOMAIN) . '</h3></div>';
	
	$tbl_usermeta = $wpdb->prefix . 'usermeta';
	$tbl_users = $wpdb->prefix . 'users';
	
	$sql = "SELECT m.user_id, m.meta_key, m.meta_value
				FROM " . $tbl_usermeta . " m
				INNER JOIN " . $tbl_users . " u ON (m.user_id = u.ID)
				WHERE m.meta_key = 'weekly_quiz_score' AND m.meta_value !=0
				ORDER BY m.meta_value * 1 DESC";
					
	$user_query = $wpdb->get_results($sql);
	
	if ( ! empty( $user_query ) ) {
	
		$output .='<ul class="top-weekly-user">';
		foreach ( $user_query as $key => $user ) {
		
			if (get_the_author_meta( $wpdb->prefix.'user_level', $user->user_id ) == '0'){
				$profile_img = aq_resize( esc_attr( get_the_author_meta( 'image', $user->user_id ) ), 40, 40, true ); 
				$output .= '<li>';
		        $output .= '<div class="post-thumbnail">';
		        if ($profile_img):
		        	$output .= '<img src="' . $profile_img . '" />';
		        else:
		        	$output .= '<img src="' . SP_ASSETS_THEME . 'images/chlatvey-profile.png" width="50" height="50" />';
		        endif;
		        $output .= '</div>';
		        $output .= '<p>' . get_the_author_meta( 'nickname', $user->user_id ) . '<br />';
				$output .= __('Score: ', SP_TEXT_DOMAIN ) . '<span class="score">' . get_the_author_meta( 'weekly_quiz_score', $user->user_id ) .'</span>';
				$output .= '</p>';
				$output .= '</li>';
			}	

		}
		$output .= '</ul>';
	} else {
		$output .= __('<p>No users found in the top of weekly quiz</p>', SP_TEXT_DOMAIN);
	}
	
	$output .="</div>";
	
	return $output;
}

function sp_top_user_weekly_quiz_temp(){
	
	$output = '<div class="inner-box round-6">';
	$output .= '<div class="widget-title"><h3>' . __('Top 10 weekly quiz', SP_TEXT_DOMAIN) . '</h3></div>';
	
	$args = array(
			'number'	=>	10,
			'meta_key'	=> 'weekly_quiz_score',
			'query_id'	=> 'wps_weekly_quiz_score',
			'order'	 => 'DESC',
			'meta_query' => array(
					            array(
					                  'type' => 'NUMERIC'
					            )
						    ),
			'role' => 'Subscriber'
		);
	$user_query = new WP_User_Query( $args );
		
	// User Loop
	if ( ! empty( $user_query->results ) ) {
	
		$output .='<ul class="top-weekly-user">';
		foreach ( $user_query->results as $user ) {
			$profile_img = aq_resize( $user->image, 50, 50, true ); 
			$output .= '<li>';
	        $output .= '<div class="post-thumbnail">';
	        if ($profile_img):
	        	$output .= '<img src="' . $profile_img . '" />';
	        else:
	        	$output .= '<img src="' . SP_ASSETS_THEME . 'images/chlatvey-profile.png" width="50" height="50" />';
	        endif;
	       	$output .= '</div>';
	        $output .= '<p>' . $user->display_name . '<br />';
			$output .= '<span class="score">' . __('Score: ', SP_TEXT_DOMAIN ) . $user->weekly_quiz_score .'</span>';
			$output .= '</p>';
			$output .= '</li>';
		}
		$output .= '</ul>';
	} else {
		$output .= __('<p>No users found in the top of weekly quiz</p>', SP_TEXT_DOMAIN);
	}
	
	$output .="</div>";
	
	return $output;
}

//add_action( 'pre_user_query', 'wps_pre_user_query' );
function wps_pre_user_query( $query ) {
	global $wpdb;
	if ( isset( $query->query_vars['query_id'] ) && 'wps_weekly_quiz_score' == $query->query_vars['query_id'] )
	$query->query_orderby = str_replace( 'user_login', "$wpdb->usermeta.meta_value", $query->query_orderby );
}

/* ---------------------------------------------------------------------- */
/*	Redirects admins to the dashboard and other users to the homepage
/* ---------------------------------------------------------------------- */
function sp_login_redirect( $redirect_to, $request, $user ){
    //is there a user to check?
    global $user;
    if( isset( $user->roles ) && is_array( $user->roles ) ) {
        //check for admins
        if( in_array( "administrator", $user->roles ) ) {
            // redirect them to the default place
            return wp_redirect( admin_url() );
        } else {
            return site_url();
        }
    }
    else {
        return $redirect_to;
    }
}
add_filter("login_redirect", "sp_login_redirect", 10, 3);

/* ---------------------------------------------------------------------- */
/*	Redirect to homepage, failed login attempt
/* ---------------------------------------------------------------------- */
function sp_login_failed( $user ) {
  	// check what page the login attempt is coming from
  	$referrer = $_SERVER['HTTP_REFERER'];

  	// check that were not on the default login page
	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $user!=null ) {
		// make sure we don't already have a failed login attempt
		if ( !strstr($referrer, '?login=failed' )) {
			// Redirect to the login page and append a querystring of login failed
	    	wp_redirect( $referrer . '?login=failed');
	    } else {
	      	wp_redirect( $referrer );
	    }

	    exit;
	}
}
add_action( 'wp_login_failed', 'sp_login_failed' ); // hook failed login


/* ---------------------------------------------------------------------- */
/*	Redirect to homepage, if you didn't type in a username or password
/* ---------------------------------------------------------------------- */
function sp_blank_login( $user, $username, $password ){
  	// check what page the login attempt is coming from
  	$referrer = $_SERVER['HTTP_REFERER'];

  	$error = false;

  	if($username == '' || $password == '')
  	{
  		$error = true;
  	}

  	// check that were not on the default login page
  	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $error ) {

  		// make sure we don't already have a failed login attempt
    	if ( !strstr($referrer, '?login=failed') ) {
    		// Redirect to the login page and append a querystring of login failed
        	wp_redirect( $referrer . '?login=failed' );
      	} else {
        	wp_redirect( $referrer );
      	}

    }
    //exit;
}
add_action( 'authenticate', 'sp_blank_login');

/* ---------------------------------------------------------------------- */
/*	Add new usermeta fields
/* ---------------------------------------------------------------------- */
add_action('show_user_profile', 'my_user_profile_edit_action');
add_action('edit_user_profile', 'my_user_profile_edit_action');
function my_user_profile_edit_action($user) {
?>
	<h3>Add on profile fields</h3>
	<?php
		$profile_img = aq_resize( esc_attr( get_the_author_meta( 'image', $user->ID ) ), 150, 150, true );
	?>
	<table class="form-table">
	<tr>
		<th>
			<label for="gender">Gender</label>
		</th>
		<td>
		<select name="gender">
		  <option <?php if(esc_attr( get_the_author_meta( 'gender', $user->ID ) ) == 'Male'){echo 'selected';} ?> value="Male">Male</option>
		  <option <?php if(esc_attr( get_the_author_meta( 'gender', $user->ID ) ) == 'Female'){echo 'selected';} ?> value="Female">Female</option>
		</select>
		</td>
	</tr>
	<tr>
		<th>
		<label for="phone_number">Phone number</label>
		</th>
		<td>
		<input type="text" name="phone_number" id="phone_number" value="<?php echo esc_attr( get_the_author_meta( 'phone_number', $user->ID ) ); ?>" />
		<span class="description">To make correct phone number, this good format ### ### ### or ### ### ###</span>
		</td>
	</tr>
	<tr>
		<th>
		<label for="user_address">Address</label>
		</th>
		<td>
		<textarea name="user_address" id="user_address"><?php echo esc_attr( get_the_author_meta( 'user_address', $user->ID ) ); ?></textarea><br />
		<span class="description">Enter your full address</span>
		</td>
	</tr>
	<tr>	
		<th>
		<label>Upload profile image</label>
		</th>
		<td>
		<img src="<?php echo $profile_img; ?>"><br />
		<input type="text" name="image" id="image" value="<?php echo esc_attr( get_the_author_meta( 'image', $user->ID ) ); ?>" class="regular-text" />
		<input type='button' class="button-primary" value="Upload Image" id="uploadimage"/><br />
		<span class="description">Please upload your image for your profile.</span>
		</td>
	</tr>
	<tr>
		<th></th>
		<td>
			<input type="hidden" name="fast_quiz_win" value="<?php echo esc_attr( get_the_author_meta( 'fast_quiz_win', $user->ID ) ); ?>" /><br />
			<input type="hidden" name="weekly_quiz_score" value="<?php echo esc_attr( get_the_author_meta( 'weekly_quiz_score', $user->ID ) ); ?>" />
		</td>
	</tr>
	</table>
<?php 
}

//function upload button
function zkr_profile_upload_js() {
?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).find("input[id^='uploadimage']").live('click', function(){
			//var num = this.id.split('-')[1];
			formfield = $('#image').attr('name');
			tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			 
			window.send_to_editor = function(html) {
			imgurl = $('img',html).attr('src');
			$('#image').val(imgurl);
			tb_remove();
		}
		 
		return false;
		});
	});
</script>
<?php
}
add_action('admin_head','zkr_profile_upload_js');

//Save meta fields
add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );
 
function my_save_extra_profile_fields( $user_id ) {
 
	if ( !current_user_can( 'edit_user', $user_id ) )
	return false;

	update_user_meta( $user_id, 'gender', $_POST['gender'] );
	update_user_meta( $user_id, 'phone_number', $_POST['phone_number'] );
	update_user_meta( $user_id, 'user_address', $_POST['user_address'] );
	update_user_meta( $user_id, 'image', $_POST['image'] );
	update_user_meta( $user_id, 'fast_quiz_win', intval($_POST['fast_quiz_win']) );
	update_user_meta( $user_id, 'weekly_quiz_score', intval($_POST['weekly_quiz_score']) );
}
 
// the following is the js and css for the upload functionality
function zkr_enque_scripts_init(){
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
}
add_action('init', 'zkr_enque_scripts_init');

/* ---------------------------------------------------------------------- */
/*	Add Lost password in login form
/* ---------------------------------------------------------------------- */

add_action( 'login_form_middle', 'add_lost_password_link' );
add_action( 'login_form_bottom', 'add_create_account_link' );
function add_lost_password_link() {
	$output = '<p class="forgot-password">';
    $output .= '<a href="' . home_url() . '/wp-login.php?action=lostpassword">' . __("forgot password?",SP_TEXT_DOMAIN) . '</a>';
    $output .= '</p>';
    return $output;
}
function add_create_account_link() {
	$output = '<p class="create-account">';
	$output .= '<a href="' . home_url() . '/wp-login.php?action=register">' . __("Create Account",SP_TEXT_DOMAIN) . '</a>';
	$output .= '</p>';
    return $output;
}

/* ---------------------------------------------------------------------- */
/*	Manage deal name and reset weekly score users
/* ---------------------------------------------------------------------- */

function update_weekly_quiz_score() {

	global $smof_data, $wpdb;
	
	$user_query = new WP_User_Query( array( 'role' => 'Subscriber', 'meta_key' => 'weekly_quiz_score', 'meta_value' => '0', 'meta_compare' => '>' ) );
	
	// User Loop
	if ( ! empty( $user_query->results ) ) {
		$score_arr = array();
		foreach ( $user_query->results as $user ) {
			$score_arr[$user->ID] = $user->weekly_quiz_score;
		}
		$max_score = max($score_arr);
		$user_id = array_keys($score_arr, max($score_arr));
		
		$gender = get_the_author_meta( 'gender', $user_id[0] );
		$display_name = get_the_author_meta( 'display_name', $user_id[0] );
		$email = get_the_author_meta( 'user_email', $user_id[0] );
		$phone = esc_attr(get_the_author_meta( 'phone_number', $user_id[0] ));
		
		$emailTo = $smof_data['email_notify'];
		$subject = 'Weekly Quiz Winner ' . $display_name ;
		$body = "Dear Chlatvey Admin \n\n";
		$body .= "Today Weekly Quiz winner name $display_name sex: $gender \n\n";
		$body .= "Email: $email \n\n";
		$body .= "Phone: $phone ";
		$headers = 'From: '.$first_name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
	
		if ($max_score !='0'){
			mail($emailTo, $subject, $body, $headers);
			$tbl_usermeta = $wpdb->prefix . 'usermeta';
			$wpdb->update( $tbl_usermeta, array("meta_value" => 0), array("meta_key" => "weekly_quiz_score") );
		}
	}
	
}

// add quiz option menu
add_action( 'init', 'deals_admin_init' );
add_action('admin_menu', 'add_deals_options');

function deals_admin_init() {
	$settings = get_option( "deal_theme_settings" );
	if ( empty( $settings ) ) {
		$settings = array(
			'deal_intro' => 'Some intro text for the home page',
			'deal_tag_class' => false,
			'deal_ga' => false
		);
		add_option( "deal_theme_settings", $settings, '', 'yes' );
	}	
}

function add_deals_options() {
		$settings_page = add_menu_page('Deals', 'Deals', 'edit_pages', 'chlatvey-deals', 'deals_custom_options', SP_ASSETS_ADMIN . 'images/icon-deals.png', 39);	
		add_action( "load-{$settings_page}", 'deal_load_settings_page' );
}

//Creating The Tabs
function deal_admin_tabs( $current = 'homepage' ) { 
    $tabs = array( 'homepage' => 'Home', 'weekly-score' => 'Weekly Score' ); 
    $links = array();
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=chlatvey-deals&tab=$tab'>$name</a>";
        
    }
    echo '</h2>';
}

//Redirecting The User To The Right Tab
function deal_load_settings_page() {
	if ( $_POST["deal-settings-submit"] == 'Y' ) {
		check_admin_referer( "deal-settings-page" );
		deal_save_theme_settings();
		$url_parameters = isset($_GET['tab'])? 'updated=true&tab='.$_GET['tab'] : 'updated=true';
		wp_redirect(admin_url('admin.php?page=chlatvey-deals&'.$url_parameters));
		exit;
	}
}

// Saving The Tabbed Fields 
function deal_save_theme_settings() {
	global $pagenow;
	$settings = get_option( "deal_theme_settings" );
	
	if ( $pagenow == 'admin.php' && $_GET['page'] == 'chlatvey-deals' ){ 
		if ( isset ( $_GET['tab'] ) )
	        $tab = $_GET['tab']; 
	    else
	        $tab = 'homepage'; 

	    switch ( $tab ){ 
	        case 'weekly-score' : 
				$settings['deal_w_score']  = $_POST['deal_w_score'];
			break;
			case 'homepage' : 
				$settings['deal_quiz_time']	  = $_POST['deal_quiz_time'];
				$settings['deal_fast_gift']	  = $_POST['deal_fast_gift'];
				$settings['deal_weekly_gift']	  = $_POST['deal_weekly_gift'];
			break;
	    }
	}
	
	if ($_POST['deal_w_score'] == 'reset')
		update_weekly_quiz_score();	
	
	$updated = update_option( "deal_theme_settings", $settings );
}
	
//Displaying The Tabbed Content
function deals_custom_options() {
	global $pagenow;
	$settings = get_option( "deal_theme_settings" );
	?>
	
	<div class="wrap">
		<h2>Manage Chlatvey Deals</h2>
		
		<?php
			if ( 'true' == esc_attr( $_GET['updated'] ) ) echo '<div class="updated" ><p>Data Settings updated.</p></div>';
			
			if ( isset ( $_GET['tab'] ) ) deal_admin_tabs($_GET['tab']); else deal_admin_tabs('homepage');
		?>

		<div id="poststuff">
			<form method="post" action="<?php admin_url( 'admin.php?page=chlatvey-deals' ); ?>">
				<?php
				wp_nonce_field( "deal-settings-page" ); 
				
				if ( $pagenow == 'admin.php' && $_GET['page'] == 'chlatvey-deals' ){ 
				
					if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab']; 
					else $tab = 'homepage'; 
					
					echo '<table class="form-table">';
					switch ( $tab ){
						case 'weekly-score' : 
							?>
							<tr>
								<th><label for="deal_w_score">Reset weekly score</label></th>
								<td>
									<input type="text" id="deal_w_score" name="deal_w_score" /><br/>
									<span class="description">Enter <strong>reset</strong> to reset weekly quiz score</span>
								</td>
							</tr>
							<?php
						break;
						case 'homepage' : 
							?>
							<tr>
								<th><label for="deal_quiz_time">Quiz time</label></th>
								<td>
									<input type="text" id="deal_quiz_time" name="deal_quiz_time" value="<?php echo esc_html( stripslashes( $settings["deal_quiz_time"] ) ); ?>" ><br/>
									<span class="description">Enter timer for user to play quiz. e.g: 1 = 1 minute</span>
								</td>
							</tr>
							<tr>
								<th><label for="deal_fast_gift">Fast Quiz Gift</label></th>
								<td>
									<input type="text" id="deal_fast_gift" name="deal_fast_gift" value="<?php echo esc_html( stripslashes( $settings["deal_fast_gift"] ) ); ?>" ><br/>
									<span class="description">Enter the Fast quiz gift. e.g: 100$</span>
								</td>
							</tr>
							<tr>
								<th><label for="deal_weekly_gift">Weekly Quiz Gift</label></th>
								<td>
									<input type="text" id="deal_weekly_gift" name="deal_weekly_gift" value="<?php echo esc_html( stripslashes( $settings["deal_weekly_gift"] ) ); ?>" ><br/>
									<span class="description">Enter the Weekly quiz gift. e.g: TV Samsung 32''</span>
								</td>
							</tr>
							<?php
						break;
					}
					echo '</table>';
				}
				?>
				<p class="submit" style="clear: both;">
					<input type="submit" name="Submit"  class="button-primary" value="Update Settings" />
					<input type="hidden" name="deal-settings-submit" value="Y" />
				</p>
			</form>
		</div>

	</div>
<?php
}
