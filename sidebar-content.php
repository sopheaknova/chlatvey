<?php
if ( is_active_sidebar( 'content-sidebar' ) ) :
	dynamic_sidebar('content-sidebar');
else:
?>	
	<div class="non-widget widget">
    <img src="<?php echo SP_ASSETS_THEME; ?>images/placeholder/ads-content-460x120.gif" class="round-6" />
    </div>
    
<?php
endif;	
	?>