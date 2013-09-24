<?php
/*
Template Name: Fast quiz
*/
global $deal_theme_settings;
?>
	
		
<?php get_header(); ?>		

<?php get_sidebar('left'); ?>
<div id="main" role="main">
	<div class="inner-box round-6">
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
	
	<?php echo sp_fast_show_quiz(); ?>
	
	</div><!-- .inner-box round-6 -->
	
	<?php get_sidebar('content'); ?>
</div><!-- #main -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>	
	
