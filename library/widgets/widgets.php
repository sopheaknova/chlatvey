<?php

/* ---------------------------------------------------------------------- */
/*	Register sidebars
/* ---------------------------------------------------------------------- */
function sp_widgets_init() {
	
	// Sidebar Right
	register_sidebar( array(
		'name' 			=> __( 'Sidebar Right', 'sptheme_admin' ),
		'id' 			=> 'right-sidebar',
		'description' 	=> __( 'Sidebar Right', 'sptheme_admin' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' 	=> "</div>",
		'before_title' 	=> '<div class="widget-title"><h3>',
		'after_title' 	=> '</h3></div>',
	) );
	
	// Sidebar Left
	register_sidebar( array(
		'name' 			=> __( 'Sidebar Left', 'sptheme_admin' ),
		'id' 			=> 'left-sidebar',
		'description' 	=> __( 'Sidebar Left', 'sptheme_admin' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s inner-box round-6">',
		'after_widget' 	=> "</div>",
		'before_title' 	=> '<div class="widget-title"><h3>',
		'after_title' 	=> '</h3></div>',
	) );
	
	// Top Sidebar
	register_sidebar( array(
		'name' 			=> __( 'Top Sidebar', 'sptheme_admin' ),
		'id' 			=> 'top-sidebar',
		'description' 	=> __( 'Top Sidebar', 'sptheme_admin' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' 	=> "</div>",
		'before_title' 	=> '<div class="widget-title"><h3>',
		'after_title' 	=> '</h3></div>',
	) );
	
	// Content Sidebar
	register_sidebar( array(
		'name' 			=> __( 'Content Sidebar', 'sptheme_admin' ),
		'id' 			=> 'content-sidebar',
		'description' 	=> __( 'Content Sidebar', 'sptheme_admin' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' 	=> "</div>",
		'before_title' 	=> '<div class="widget-title"><h3>',
		'after_title' 	=> '</h3></div>',
	) );
	
	// Footer Sidebar
	register_sidebar( array(
		'name' 			=> __( 'Footer Sidebar', 'sptheme_admin' ),
		'id' 			=> 'footer-sidebar',
		'description' 	=> __( 'Footer Sidebar', 'sptheme_admin' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' 	=> "</div>",
		'before_title' 	=> '<div class="widget-title"><h3>',
		'after_title' 	=> '</h3></div>',
	) );
	
	
	// Addon widgets		
	require_once ( SP_BASE_DIR . 'library/widgets/widget-ads.php' );	

	// Register widgets
	register_widget('sp_widget_ads250_250');
	register_widget('sp_widget_ads250_125');
	register_widget('sp_widget_ads960_120');
	register_widget('sp_widget_ads460_120');
}
add_action('widgets_init', 'sp_widgets_init');


// Add Add Size Widget
require_once ( SP_BASE_DIR . 'library/widgets/widget-ads.php' );

/* ---------------------------------------------------------------------- */
/*	Sidebars Generator
/* ---------------------------------------------------------------------- */

// Class to generate sidebar on the fly
require_once( SP_BASE_DIR . 'library/widgets/sidebar-generator.php' );
/*adds support for the new avia sidebar manager*/
add_theme_support('avia_sidebar_manager');

if(get_theme_support( 'avia_sidebar_manager' )) new avia_sidebar();