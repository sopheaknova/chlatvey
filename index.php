<?php
/**
 * The main template file.
 */

//global $pls_archive_template;
get_header(); ?>
	
	
<?php get_sidebar('left'); ?>	
<div id="main">
	<div class="cover-home">
	<img src="<?php echo $smof_data['home_cover']; ?>" class="round-6" />
	</div>
	<div class="inner-box round-6">
		<?php echo sp_continue_quiz(); ?>
	</div> <!-- .inner-box .round-6 -->	
	<?php get_sidebar('content'); ?>
</div><!-- #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>