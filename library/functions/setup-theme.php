<?php

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 480;
		
		
		//ACTION & FILTER
		add_filter( 'locale', 'set_sp_locale' ); // Setup default theme language
		add_action( 'after_setup_theme', 'sp_theme_setup' );
		add_action('wp_enqueue_scripts', 'sp_scripts_styles'); //print Script and CSS
		add_action( 'wp_head', 'sp_print_css_js' );//Custom CSS and JS when page load		
		add_filter('wp_title', 'sp_filter_wp_title', 10, 2);
		add_filter( 'body_class', 'sp_body_class' );
		//TinyMCE customization
		if ( is_admin() ) {
			add_filter( 'mce_buttons', 'sp_add_buttons_row1' );
			add_filter( 'mce_buttons_2', 'sp_add_buttons_row2' );
		}
		
		add_filter( 'the_excerpt_rss', 'sp_rss_post_thumbnail' );//Display thumbnails in RSS
		add_filter( 'the_content_feed', 'sp_rss_post_thumbnail' );//Display thumbnails in RSS
		
		//BRANDING
		add_action( 'admin_head', 'sp_adminfavicon' );//Set favicons for backend code
		add_action('login_head', 'sp_custom_login_logo');// Custom logo login
		add_action( 'wp_before_admin_bar_render', 'sp_remove_admin_bar_links' );//	Remove logo and other items in Admin menu bar
		add_filter('login_headerurl', 'sp_remove_link_on_admin_login_info');//  Remove wordpress link on admin login logo
		add_filter('login_headertitle', 'sp_change_loging_logo_title');// Change login logo title
		add_filter('admin_footer_text', 'sp_modify_footer_admin'); // Customising footer text

/*-----------------------------------------------------------------------------------*/
/*	setup one language for admin and the other for theme
/*	must be called before load_theme_textdomain()
/*-----------------------------------------------------------------------------------*/
function set_sp_locale($locale) {
	  $locale = ( is_admin() ) ? "en_US" : "kh_KH";
	  setlocale(LC_ALL, $local );
	  return $locale;
}

/*-----------------------------------------------------------------------------------*/
/*	theme set up
/*-----------------------------------------------------------------------------------*/ 
function sp_theme_setup() {

	// Makes theme available for translation.
	load_theme_textdomain( SP_TEXT_DOMAIN, get_template_directory() . '/languages' );

	// Add visual editor stylesheet support
	add_editor_style( SP_ASSETS_THEME . 'css/editor-style.css');

	//
	if (current_user_can('subscriber') || current_user_can('contributor')) {
	  show_admin_bar(false);
	}
	
	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Add post formats
	add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio' ) );

	// Add navigation menus
	register_nav_menus( array(
		'left-main-menu'	=> __( 'Left Main Menu', SP_TEXT_DOMAIN ),
		'right-main-menu'	=> __( 'Right Main Menu', SP_TEXT_DOMAIN ),
		'footer-menu'  => __( 'Footer Menu', SP_TEXT_DOMAIN )
	) );

	// Add suport for post thumbnails and set default sizes
	add_theme_support( 'post-thumbnails' );

	// Add custom image sizes
	add_image_size( 'widget', 60, 60, true );
	add_image_size( 'portfolio-2col', 435, 250, true );
	add_image_size( 'size_max', 960, 9999 );


}


/* ---------------------------------------------------------------------- */
/*	Register CSS and JS
/* ---------------------------------------------------------------------- */

function sp_scripts_styles() {
	
	global $wp_styles, $smof_data;
	
	if(!is_admin()){
		//CSS
		wp_register_style( 'g_suwannaphum', 'http://fonts.googleapis.com/css?family=Suwannaphum', array(), SP_THEME_VERSION );
		wp_register_style( 'sp-theme-styles', SP_BASE_URL . 'style.css', false, SP_THEME_VERSION );
		wp_register_style( 'khcss', SP_ASSETS_THEME . 'css/kh.css', array(), SP_THEME_VERSION );
		wp_register_style( 'sp-base', SP_ASSETS_THEME . 'css/base.css', false, SP_THEME_VERSION );
		wp_register_style( 'flexslider', SP_ASSETS_THEME . 'css/flexslider.css', array(), '' );
		wp_register_style( 'sp-layout', SP_ASSETS_THEME . 'css/layout.css', false, SP_THEME_VERSION );
		wp_register_style( 'sp-shortcodes', SP_ASSETS_THEME . 'css/shortcodes.css', false, SP_THEME_VERSION );
		
		wp_enqueue_style('sp-base');
		wp_enqueue_style('sp-theme-styles');
		wp_enqueue_style( 'flexslider' );
		wp_enqueue_style('sp-layout');
		wp_enqueue_style('sp-shortcodes');
		
		if (get_bloginfo('language') == 'kh-KH') {
			wp_enqueue_style('g_suwannaphum');
			wp_enqueue_style('khcss');
		}
		
		// Internet Explorer specific stylesheet
		wp_enqueue_style( SP_TEXT_DOMAIN, SP_ASSETS_THEME . 'css/ie.css', array(), SP_THEME_VERSION );
		$wp_styles->add_data( SP_TEXT_DOMAIN, 'conditional', 'lt IE 9' );
		
				
		//JS
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'easing',    SP_ASSETS_THEME . 'js/jquery.easing.min.js', array(), SP_THEME_VERSION, true );
		wp_enqueue_script( 'cycle',    SP_ASSETS_THEME . 'js/jquery.cycle.all.min.js', array(), SP_THEME_VERSION, true );	
		wp_enqueue_script( 'hover-intent',    SP_ASSETS_THEME . 'js/jquery.hoverIntent.minified.js', array(), SP_THEME_VERSION, true );
		
		
		wp_enqueue_script( 'flexslider',    SP_ASSETS_THEME . 'js/jquery.flexslider-min.js', array(), SP_THEME_VERSION, true );
		wp_enqueue_script( 'shortcodes',    SP_ASSETS_THEME . 'js/shortcodes.js', array(), SP_THEME_VERSION, true );
		wp_enqueue_script( 'rhinoslider',    SP_ASSETS_THEME . 'js/rhinoslider-1.05.min.js', array(), SP_THEME_VERSION, true );
		wp_enqueue_script( 'custom_scripts',    SP_ASSETS_THEME . 'js/custom.js', array(), SP_THEME_VERSION, true );
		
		wp_enqueue_script( 'quiz',    SP_ASSETS_THEME . 'js/quiz.js', array(), SP_THEME_VERSION, true );
		
		
		//Quiz variable
		if ( is_page_template('template-fast-quiz.php') )
			$quiz_type_js = 'fast';	
			
		if ( is_page_template('template-weekly-quiz.php') )
			$quiz_type_js = 'weekly';
		
		$settings = get_option( "deal_theme_settings" );
		$quiz_duration = $settings['deal_quiz_time'];
	 
	    $config_array = array(
	 
	        'ajaxURL' => admin_url( 'admin-ajax.php' ),
	        'quizNonce' => wp_create_nonce( 'quiz-nonce' ),
	        'quizDuration' => $quiz_duration,
	        'quizType'	=> $quiz_type_js,
	        'theme_url' => SP_BASE_URL
	 
	    );
	 
	    wp_localize_script( 'quiz', 'quiz', $config_array );
		
	}
}
	
//custom scripts and styles
function sp_print_css_js() { ?>

<!--[if lt IE 9]>
<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<?php }

// Determine whether WP-prettyPhoto plugin is acivated and assign the result to a constant
defined('WP_PRETTY_PHOTO_PLUGIN_ACTIVE')
        || define('WP_PRETTY_PHOTO_PLUGIN_ACTIVE', class_exists( 'WP_prettyPhoto' ) );


// if the WP-prettyPhoto plugin is not active handle rel="wp-prettyPhoto" in links for the prettyPhoto integrated script (if enabled)
if ( !WP_PRETTY_PHOTO_PLUGIN_ACTIVE ) {
    /**
     * Insert rel="wp-prettyPhoto" to all links for images, movie, YouTube and iFrame. 
     * This function will ignore links where you have manually entered your own rel reference.
     * @param string $content Post/page contents
     * @return string Prettified post/page contents
     * @link http://0xtc.com/2008/05/27/auto-lightbox-function.xhtml
     * @access public
      */
    function autoinsert_rel_prettyPhoto ($content) {
        global $post;
        $rel = 'wp-prettyPhoto';
        $image_match = '\.bmp|\.gif|\.jpg|\.jpeg|\.png';
        $movie_match = '\.mov.*?';
        $swf_match = '\.swf.*?';
        $youtube_match = 'http:\/\/www\.youtube\.com\/watch\?v=[A-Za-z0-9]*';
        $iframe_match = '.*iframe=true.*';
        $pattern[0] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(".$image_match."|".$movie_match."|".$swf_match."|".$youtube_match."|".$iframe_match.")('|\")([^\>]*?)>/i";
        $pattern[1] = "/<a(.*?)href=('|\")([A-Za-z0-9\/_\.\~\:-]*?)(".$image_match."|".$movie_match."|".$swf_match."|".$youtube_match."|".$iframe_match.")('|\")(.*?)(rel=('|\")".$rel."(.*?)('|\"))([ \t\r\n\v\f]*?)((rel=('|\")".$rel."(.*?)('|\"))?)([ \t\r\n\v\f]?)([^\>]*?)>/i";
        $replacement[0] = '<a$1href=$2$3$4$5$6 rel="'.$rel.'['.$post->ID.']">';
        $replacement[1] = '<a$1href=$2$3$4$5$6$7>';
        $content = preg_replace($pattern, $replacement, $content);
        return $content;
    }
    add_filter('the_content', 'autoinsert_rel_prettyPhoto');
    add_filter('the_excerpt', 'autoinsert_rel_prettyPhoto');


    // Add the 'wp-prettyPhoto' rel attribute to the default WP gallery links
    function gallery_prettyPhoto ($content) {
            // add checks if you want to add prettyPhoto on certain places (archives etc).
            return str_replace("<a", "<a rel='wp-prettyPhoto[gallery]'", $content);
    }
    add_filter( 'wp_get_attachment_link', 'gallery_prettyPhoto');
}
	
/*-----------------------------------------------------------------------------------*/
/* Makes some changes to the <title> tag, by filtering the output of wp_title()
/*-----------------------------------------------------------------------------------*/
function sp_filter_wp_title( $title, $separator ) {

	if ( is_feed() ) return $title;

	global $paged, $page;

	if ( is_search() ) {
		$title = sprintf(__('Search results for %s', 'sptheme_admin'), '"' . get_search_query() . '"');

		if ( $paged >= 2 )
			$title .= " $separator " . sprintf(__('Page %s', 'sptheme_admin'), $paged);

		$title .= " $separator " . get_bloginfo('name', 'display');

		return $title;
	}

	$title .= get_bloginfo('name', 'display');
	$site_description = get_bloginfo('description', 'display');

	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	if ( $paged >= 2 || $page >= 2)
		$title .= " $separator " . sprintf(__('Page %s', 'sptheme_admin'), max($paged, $page) );

	return $title;

}

/*-----------------------------------------------------------------------------------*/
/* Add body class to the theme depending upon options and templates
/*-----------------------------------------------------------------------------------*/ 
function sp_body_class( $classes ) {
	global $post, $smof_data;
	
	if ( is_single() || is_page() || is_singular('portfolio') ) {
		$has_sidebar = get_post_meta($post->ID, 'sp_page_layout', true);
		
		if ( '2cl' == $has_sidebar ) {
			$classes[] = 'sidebar-left';
		} elseif ( ('2cr' == $has_sidebar) ) {
			$classes[] = 'sidebar-right';
		} else {
			$classes[] = 'full-width';
		}
	}
	
	if ( is_category() || is_archive() )
		$classes[] = 'sidebar-right';

	// Enable custom font class only if the font CSS is queued to load.
	/*if ( wp_style_is( 'sptheme-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';*/

	if ( 'stretched' == $smof_data['layout_style'] ) {
		$classes[] = 'is-stretched';
	}

	if ( 'true' == $smof_data['is_rtl_cs'] || is_rtl() ) {
		$classes[] = 'rtl-enabled';
	}

	return $classes;
}	
	
/* ---------------------------------------------------------------------- */
/*	Visual editor improvment
/* ---------------------------------------------------------------------- */
	
/*
* Add buttons to visual editor first row
*
* $buttons = ARRAY [default WordPress visual editor buttons array]
*/
if ( ! function_exists( 'sp_add_buttons_row1' ) ) {
	function sp_add_buttons_row1( $buttons ) {
		//inserting buttons after "italic" button
		$pos = array_search( 'italic', $buttons, true );
		if ( $pos != false ) {
			$add = array_slice( $buttons, 0, $pos + 1 );
			$add[] = 'underline';
			$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
		}

		//inserting buttons after "justifyright" button
		$pos = array_search( 'justifyright', $buttons, true );
		if ( $pos != false ) {
			$add = array_slice( $buttons, 0, $pos + 1 );
			$add[] = 'justifyfull';
			$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
		}
		
		return $buttons;
	}
} // /sp_add_buttons_row1

/*
* Add buttons to visual editor second row
*
* $buttons = ARRAY [default WordPress visual editor buttons array]
*/
if ( ! function_exists( 'sp_add_buttons_row2' ) ) {
	function sp_add_buttons_row2( $buttons ) {
		//inserting buttons before "underline" button
		$pos = array_search( 'underline', $buttons, true );
		if ( $pos != false ) {
			$add = array_slice( $buttons, 0, $pos );
			$add[] = 'removeformat';
			$add[] = '|';
			$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
		}

		//remove "justify full" button from second row
		$pos = array_search( 'justifyfull', $buttons, true );
		if ( $pos != false ) {
			unset( $buttons[$pos] );
			$add = array_slice( $buttons, 0, $pos + 1 );
			$add[] = '|';
			$add[] = 'sub';
			$add[] = 'sup';
			$add[] = '|';
			$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
		}

		return $buttons;
	}
} // sp_add_buttons_row2

//Display thumbnails in RSS
if ( ! function_exists( 'sp_rss_post_thumbnail' ) ) {
	function sp_rss_post_thumbnail( $content ) {
		global $post;

		if ( has_post_thumbnail( $post->ID ) )
			$content = '<p>' . get_the_post_thumbnail( $post->ID ) . '</p>' . get_the_content();

		return $content;
	}
} // /sp_rss_post_thumbnail

/* ---------------------------------------------------------------------- */
/*	Customizable login screen and WordPress admin area
/* ---------------------------------------------------------------------- */
// Custom logo login
function sp_custom_login_logo() {
    echo '<style type="text/css">
		body.login{ background-color:#ffffff; }
        .login h1 a { background-image:url('.SP_ASSETS_THEME.'images/logo.png) !important; height:160px !important; background-size: auto auto !important;}
    </style>';
}

// Remove wordpress link on admin login logo
function sp_remove_link_on_admin_login_info() {
     return  get_bloginfo('url');
}

// Change login logo title
function sp_change_loging_logo_title(){
	return 'Go to '.get_bloginfo('name').' Homepage';
}

//	Remove logo and other items in Admin menu bar
function sp_remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('wp-logo');
}


// Customising footer text
function sp_modify_footer_admin () {  
  echo 'Created by <a href="http://www.novacambodia.com" target="_blank">novadesign</a>. Powered by <a href="http://www.wordpress.org" target="_blank">WordPress</a>';  
} 

//  Set favicons for backend code
function sp_adminfavicon() {
echo '<link rel="icon" type="image/x-icon" href="'.SP_BASE_URL.'favicon.ico" />';
}

//Removing a unused menu and submenu for admin dashboard
function sp_edit_admin_menus() {  

	if (!current_user_can('manage_options')) {    
	    remove_menu_page( 'edit-comments.php' );
	    remove_menu_page( 'link-manager.php' );
	    remove_menu_page( 'tools.php' );
	    remove_menu_page( 'plugins.php' );
	    remove_menu_page( 'users.php' );
	    remove_menu_page( 'options-general.php' );
	    remove_menu_page( 'upload.php' );
	    remove_menu_page( 'edit.php' );
	    remove_menu_page( 'themes.php' );
    }
}  
add_action( 'admin_menu', 'sp_edit_admin_menus' );
