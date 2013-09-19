<?php
/**
 * The Header
 */

/* Fetch theme options variables required in this template */
global $smof_data;
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7 no-js" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8 no-js" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<meta name="viewport" content="width=device-width" />

<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="wrapper">
		
        
        <?php get_sidebar('top'); ?>
        
        <div class="main-menu-container clearfix">
        	<nav id="main-nav" class="primary-nav round-6 sky-blue clearfix" role="navigation">	
        	<div class="main-menu-left">
        	<?php echo sp_main_left(); ?>
        	</div>
        	<div class="main-menu-right">
        	<?php echo sp_main_right(); ?>
        	</div>
        	</nav><!-- #main-nav -->
        	<div class="brand" role="banner">
            <?php if( !is_singular() ) echo '<h1>'; else echo '<h2>'; ?>
            
                <a  href="<?php echo home_url() ?>/"  title="<?php echo esc_attr( get_bloginfo('name', 'display') ); ?>">
                    <?php if($smof_data['theme_logo']) : ?>
                    <img src="<?php echo $smof_data['theme_logo']; ?>" alt="<?php echo esc_attr( get_bloginfo('name', 'display') ); ?>" />
                    <?php else: ?>
                    <span><?php bloginfo( 'name' ); ?></span>
                    <?php endif; ?>
                </a>
                
                <?php if( !is_singular() ) echo '</h1>'; else echo '</h2>'; ?>
            </div><!-- end .logo -->        		
        </div><!-- .container .clearfix -->        
		
		
        
        <div id="content" class="round-6">
        	<div class="container clearfix">