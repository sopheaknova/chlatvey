<?php
/*
Template Name: Maintenance Page
*/
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
<link rel="shortcut icon" href="<?php echo ($smof_data['theme_favicon'] == '') ? SP_BASE_URL.'favicon.ico' : $smof_data['theme_favicon']; ?>" type="image/x-icon" />

</head>
<body <?php body_class(); ?>>

<?php
	while ( have_posts() ) :
	the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post -->
<?php endwhile; ?>
		

<?php wp_footer(); ?>
</body>
</html>
