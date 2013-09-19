<header id="header" class="round-6" role="banner">
	<div class="container clearfix">
	<?php
	if ( is_active_sidebar( 'top-sidebar' ) ) :
		dynamic_sidebar('top-sidebar');
	else:
	?>	
		<div class="non-widget widget">
	    <img src="<?php echo SP_ASSETS_THEME; ?>images/placeholder/ads-top-960x120.gif" class="round-6" />
	    </div>
	    
	<?php
	endif;	
		?>
	</div>	
</header><!-- #header -->