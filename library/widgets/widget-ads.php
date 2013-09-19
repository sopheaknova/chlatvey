<?php

/*
*****************************************************
*      WIDGET CLASS
*****************************************************
*/
function sp_media_upload(){
	wp_enqueue_style( 'thickbox' );
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_script( 'media-upload' );	
}
add_action( 'widgets_init', 'sp_media_upload' );

function add_script_ads_image()
{   
    ?>   
    <script type="text/javascript">                 

        jQuery(document).ready(function($){
                         
             $('.upload-image').live('click', function(){
                var sp_this_object = $(this).prev();
                
                tb_show('', 'media-upload.php?post_id=0&type=image&TB_iframe=true');    
            
                window.send_to_editor = function(html) {
                    imgurl = $('img', html).attr('src');
                    sp_this_object.val(imgurl);
                    
                    tb_remove();
                }          
                
                return false;
            });
            

        });  
    </script> 
    <?php
}
add_action( 'admin_print_footer_scripts', 'add_script_ads_image', 999 );

// Ads 250x250
class sp_widget_ads250_250 extends WP_Widget {
	/*
	*****************************************************
	*      widget constructor
	*****************************************************
	*/
	function __construct() {
		$id     = 'sp-widget-ads-250-250';
		$prefix = SP_THEME_NAME . ': ';
		$name   = '<span>' . $prefix . __( 'Ads 250x250', 'sptheme_widget' ) . '</span>';
		$widget_ops = array(
			'classname'   => 'sp-widget-ads-250-250',
			'description' => __( 'Place Ads size 250px by 250px', 'sptheme_widget' )
			);
		$control_ops = array();

		//$this->WP_Widget( $id, $name, $widget_ops, $control_ops );
		parent::__construct( $id, $name, $widget_ops, $control_ops );
		
	} // /__construct
    
    function form( $instance )
    {
        global $icons_name;
        
        /* Impostazioni di default del widget */
        $defaults = array( 
            'title' => '',
            'image' => '',
			'link'	=> ''
        );
        
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>
       
       <p>
            <label>
                <strong><?php _e( 'Title', 'sptheme' ) ?>:</strong><br />
                <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
            </label>
        </p>  
       <p>
            <label><?php _e( 'Image', 'sptheme_widget' ) ?>:
                <input type="text" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo $instance['image']; ?>" />
                <a href="media-upload.php?type=image&TB_iframe=true" class="upload-image button-secondary">Upload</a>
            </label>
        </p>
        
        <p>
            <label>
                <strong><?php _e( 'Link', 'sptheme_widget' ) ?>:</strong><br />
                <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $instance['link']; ?>" />
            </label>
        </p>
        
        <?php
    }
    
    function widget( $args, $instance )
    {
        extract( $args );
		
		$title = apply_filters('widget_title', $instance['title'] );
		$link = esc_attr($instance['link']);
		$banner_img = aq_resize( $instance['image'], 250, 250, true ); 
		
		echo $before_widget;                   
		
		/* Title of widget (before and after define by theme). */
		if ( $link ) :
			if ( $title )
				echo $before_title . '<a href="' . $link . '" title="' . $instance['title'] . '">' . $title . '</a>' . $after_title;
				
			$widget_body = '<a href="' . $link . '"><img src="' . $banner_img . '" class="round-6" /></a>';
			echo apply_filters( 'widget_text', $widget_body );
			
		else:
			if ( $title )
				echo $before_title . $title . $after_title;
				
			$widget_body = '<img src="' . $banner_img . '" class="round-6" />';
			echo apply_filters( 'widget_text', $widget_body );
			
		endif;
		
        echo $after_widget;
    }                     

    function update( $new_instance, $old_instance ) 
    {
        $instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
        $instance['image'] = $new_instance['image'];
        $instance['link'] = $new_instance['link'];
        return $instance;
    }
    
}

// Ads 250x125
class sp_widget_ads250_125 extends WP_Widget {
	/*
	*****************************************************
	*      widget constructor
	*****************************************************
	*/
	function __construct() {
		$id     = 'sp-widget-ads-250-125';
		$prefix = SP_THEME_NAME . ': ';
		$name   = '<span>' . $prefix . __( 'Ads 250x125', 'sptheme_widget' ) . '</span>';
		$widget_ops = array(
			'classname'   => 'sp-widget-ads-250-125',
			'description' => __( 'Place Ads size 250px by 125px', 'sptheme_widget' )
			);
		$control_ops = array();

		//$this->WP_Widget( $id, $name, $widget_ops, $control_ops );
		parent::__construct( $id, $name, $widget_ops, $control_ops );
		
	} // /__construct
    
    function form( $instance )
    {
        global $icons_name;
        
        /* Impostazioni di default del widget */
        $defaults = array( 
            'title' => '',
            'image' => '',
			'link'	=> ''
        );
        
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>
       
       <p>
            <label>
                <strong><?php _e( 'Title', 'sptheme' ) ?>:</strong><br />
                <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
            </label>
        </p>  
       <p>
            <label><?php _e( 'Image', 'sptheme_widget' ) ?>:
                <input type="text" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo $instance['image']; ?>" />
                <a href="media-upload.php?type=image&TB_iframe=true" class="upload-image button-secondary">Upload</a>
            </label>
        </p>
        
        <p>
            <label>
                <strong><?php _e( 'Link', 'sptheme_widget' ) ?>:</strong><br />
                <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $instance['link']; ?>" />
            </label>
        </p>
        
        <?php
    }
    
    function widget( $args, $instance )
    {
        extract( $args );
		
		$title = apply_filters('widget_title', $instance['title'] );
		$link = esc_attr($instance['link']);
		$banner_img = aq_resize( $instance['image'], 250, 125, true ); 
		
		echo $before_widget;                   
		
		/* Title of widget (before and after define by theme). */
		if ( $link ) :
			if ( $title )
				echo $before_title . '<a href="' . $link . '" title="' . $instance['title'] . '">' . $title . '</a>' . $after_title;
				
			$widget_body = '<a href="' . $link . '"><img src="' . $banner_img . '" class="round-6" /></a>';
			echo apply_filters( 'widget_text', $widget_body );
			
		else:
			if ( $title )
				echo $before_title . $title . $after_title;
				
			$widget_body = '<img src="' . $banner_img . '" class="round-6" />';
			echo apply_filters( 'widget_text', $widget_body );
			
		endif;
		
        echo $after_widget;
    }                     

    function update( $new_instance, $old_instance ) 
    {
        $instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
        $instance['image'] = $new_instance['image'];
        $instance['link'] = $new_instance['link'];
        return $instance;
    }
    
}

// Ads 960x120
class sp_widget_ads960_120 extends WP_Widget {
	/*
	*****************************************************
	*      widget constructor
	*****************************************************
	*/
	function __construct() {
		$id     = 'sp-widget-ads-960-120';
		$prefix = SP_THEME_NAME . ': ';
		$name   = '<span>' . $prefix . __( 'Ads 960x120', 'sptheme_widget' ) . '</span>';
		$widget_ops = array(
			'classname'   => 'sp-widget-ads-960-120',
			'description' => __( 'Place Ads size 960px by 120px', 'sptheme_widget' )
			);
		$control_ops = array();

		//$this->WP_Widget( $id, $name, $widget_ops, $control_ops );
		parent::__construct( $id, $name, $widget_ops, $control_ops );
		
	} // /__construct
    
    function form( $instance )
    {
        global $icons_name;
        
        /* Impostazioni di default del widget */
        $defaults = array( 
            'title' => '',
            'image' => '',
			'link'	=> ''
        );
        
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>
       
       <p>
            <label>
                <strong><?php _e( 'Title', 'sptheme' ) ?>:</strong><br />
                <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
            </label>
        </p>  
       <p>
            <label><?php _e( 'Image', 'sptheme_widget' ) ?>:
                <input type="text" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo $instance['image']; ?>" />
                <a href="media-upload.php?type=image&TB_iframe=true" class="upload-image button-secondary">Upload</a>
            </label>
        </p>
        
        <p>
            <label>
                <strong><?php _e( 'Link', 'sptheme_widget' ) ?>:</strong><br />
                <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $instance['link']; ?>" />
            </label>
        </p>
        
        <?php
    }
    
    function widget( $args, $instance )
    {
        extract( $args );
		
		$title = apply_filters('widget_title', $instance['title'] );
		$link = esc_attr($instance['link']);
		$banner_img = aq_resize( $instance['image'], 960, 120, true ); 
		
		echo $before_widget;                   
		
		/* Title of widget (before and after define by theme). */
		if ( $link ) :
			if ( $title )
				echo $before_title . '<a href="' . $link . '" title="' . $instance['title'] . '">' . $title . '</a>' . $after_title;
				
			$widget_body = '<a href="' . $link . '"><img src="' . $banner_img . '" class="round-6" /></a>';
			echo apply_filters( 'widget_text', $widget_body );
			
		else:
			if ( $title )
				echo $before_title . $title . $after_title;
				
			$widget_body = '<img src="' . $banner_img . '" class="round-6" />';
			echo apply_filters( 'widget_text', $widget_body );
			
		endif;
		
        echo $after_widget;
    }                     

    function update( $new_instance, $old_instance ) 
    {
        $instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
        $instance['image'] = $new_instance['image'];
        $instance['link'] = $new_instance['link'];
        return $instance;
    }
    
}

// Ads 460x120
class sp_widget_ads460_120 extends WP_Widget {
	/*
	*****************************************************
	*      widget constructor
	*****************************************************
	*/
	function __construct() {
		$id     = 'sp-widget-ads-460-120';
		$prefix = SP_THEME_NAME . ': ';
		$name   = '<span>' . $prefix . __( 'Ads 460x120', 'sptheme_widget' ) . '</span>';
		$widget_ops = array(
			'classname'   => 'sp-widget-ads-460-120',
			'description' => __( 'Place Ads size 460px by 120px', 'sptheme_widget' )
			);
		$control_ops = array();

		//$this->WP_Widget( $id, $name, $widget_ops, $control_ops );
		parent::__construct( $id, $name, $widget_ops, $control_ops );
		
		
		
	} // /__construct
    
    function form( $instance )
    {
        global $icons_name;
        
        /* Impostazioni di default del widget */
        $defaults = array( 
            'title' => '',
            'image' => '',
			'link'	=> ''
        );
        
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>
       
       <p>
            <label>
                <strong><?php _e( 'Title', 'sptheme' ) ?>:</strong><br />
                <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
            </label>
        </p>  
       <p>
            <label><?php _e( 'Image', 'sptheme_widget' ) ?>:
                <input type="text" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo $instance['image']; ?>" />
                <a href="media-upload.php?type=image&TB_iframe=true" class="upload-image button-secondary">Upload</a>
            </label>
        </p>
        
        <p>
            <label>
                <strong><?php _e( 'Link', 'sptheme_widget' ) ?>:</strong><br />
                <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $instance['link']; ?>" />
            </label>
        </p>
        
        <?php
    }
    
    function widget( $args, $instance )
    {
        extract( $args );
		
		$title = apply_filters('widget_title', $instance['title'] );
		$link = esc_attr($instance['link']);
		$banner_img = aq_resize( $instance['image'], 460, 120, true ); 
		
		echo $before_widget;                   
		
		/* Title of widget (before and after define by theme). */
		if ( $link ) :
			if ( $title )
				echo $before_title . '<a href="' . $link . '" title="' . $instance['title'] . '">' . $title . '</a>' . $after_title;
				
			$widget_body = '<a href="' . $link . '"><img src="' . $banner_img . '" class="round-6" /></a>';
			echo apply_filters( 'widget_text', $widget_body );
			
		else:
			if ( $title )
				echo $before_title . $title . $after_title;
				
			$widget_body = '<img src="' . $banner_img . '" class="round-6" />';
			echo apply_filters( 'widget_text', $widget_body );
			
		endif;
		
        echo $after_widget;
    }                     

    function update( $new_instance, $old_instance ) 
    {
        $instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
        $instance['image'] = $new_instance['image'];
        $instance['link'] = $new_instance['link'];
        return $instance;
    }
    
}     
?>
