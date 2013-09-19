<aside id="sidebar-footer" class="widget-footer" role="complementary">
<?php
if ( is_active_sidebar( 'footer-sidebar' ) ) :
	dynamic_sidebar('footer-sidebar');
else:
?>	
	<div class="non-widget widget">
    <img src="<?php echo SP_ASSETS_THEME; ?>images/placeholder/ads-top-960x120.gif" class="round-6" />
    </div>
    
<?php
endif;	
	?>
</aside>	