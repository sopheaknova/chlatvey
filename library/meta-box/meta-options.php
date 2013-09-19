<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit: 
 * @link http://www.deluxeblogtips.com/2010/04/how-to-create-meta-box-wordpress-post.html
 */

/********************* META BOX DEFINITIONS ***********************/

$prefix = 'sp_';

global $meta_boxes, $sidebars;

$meta_boxes = array();

/* ---------------------------------------------------------------------- */
/*	POST TYPE: QUIZZES
/* ---------------------------------------------------------------------- */

$meta_boxes[] = array(
	'id'       => 'answer-options',
	'title'    => __('Answer Options', 'sptheme_admin'),
	'pages'    => array('quizzes'),
	'context'  => 'normal',
	'priority' => 'high',
	'fields'   => array(
		
		array(
			'name'     => __( 'Choose correct answer', 'sptheme_admin' ),
			'id'       => $prefix . 'correct_answer',
			'type'     => 'select',
			// Array of 'value' => 'Label' pairs for select box
			'options'  => array(
				'1' => __( '01', 'sptheme_admin' ),
				'2' => __( '02', 'sptheme_admin' ),
				'3' => __( '03', 'sptheme_admin' ),
				'4' => __( '04', 'sptheme_admin' ),
			),
		),
		
		array(
			'type' => 'divider',
			'id'   => 'fake_divider_id', // Not used, but needed
		),
	
		array(
			'name' => __('Answer 01', 'sptheme_admin'),
			'id'   => $prefix . 'answer_1',
			'type' => 'text',
			'size' => 80,
			'std'  => '',
			'desc' => __('enter answer 01 here', 'sptheme_admin'),
		),
		array(
			'name' => __('Answer 02', 'sptheme_admin'),
			'id'   => $prefix . 'answer_2',
			'type' => 'text',
			'size' => 80,
			'std'  => '',
			'desc' => __('enter answer 02 here', 'sptheme_admin'),
		),
		array(
			'name' => __('Answer 03', 'sptheme_admin'),
			'id'   => $prefix . 'answer_3',
			'type' => 'text',
			'size' => 80,
			'std'  => '',
			'desc' => __('enter answer 03 here', 'sptheme_admin'),
		),
		array(
			'name' => __('Answer 04', 'sptheme_admin'),
			'id'   => $prefix . 'answer_4',
			'type' => 'text',
			'size' => 80,
			'std'  => '',
			'desc' => __('enter answer 04 here', 'sptheme_admin'),
		)
	)
);


/* ---------------------------------------------------------------------- */
/*	POST FORMAT: VIDEO
/* ---------------------------------------------------------------------- */

$meta_boxes[] = array(
	'id'       => 'post-video-settings',
	'title'    => __('External Video Settings', 'sptheme_admin'),
	'pages'    => array('post'),
	'context'  => 'normal',
	'priority' => 'high',
	'fields'   => array(
		array(
			'name' => __('Video URL', 'sptheme_admin'),
			'id'   => $prefix . 'video_id',
			'type' => 'text',
			'std'  => '',
			'desc' => __('ex: http://www.youtube.com/watch?v=sdUUx5FdySs.', 'sptheme_admin'),
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	POST FORMAT: AUDIO
/* ---------------------------------------------------------------------- */

$meta_boxes[] = array(
	'id'       => 'post-audio-settings',
	'title'    => __('External Audio Settings', 'sptheme_admin'),
	'pages'    => array('post'),
	'context'  => 'normal',
	'priority' => 'high',
	'fields'   => array(
		array(
			'name' => __('Audio/Sound URL', 'sptheme_admin'),
			'id'   => $prefix . 'audio_external',
			'type' => 'text',
			'std'  => '',
			'desc' => __('ex: https://soundcloud.com/loy9/loy9-radio-pro-81-all-my.', 'sptheme_admin'),
		)
	)
);


/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function sp_register_meta_boxes()
{
	global $meta_boxes;

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( class_exists( 'RW_Meta_Box' ) )
	{
		foreach ( $meta_boxes as $meta_box )
		{
			new RW_Meta_Box( $meta_box );
		}
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded
//  before (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'sp_register_meta_boxes' );