<aside id="sidebar-right" class="widget-area" role="complementary">

<?php
	if ( is_active_sidebar( 'right-sidebar' ) ) :
		dynamic_sidebar('right-sidebar');
	else:
	?>	
		<div class="non-widget widget">
	    <h3><?php _e('About Right Sidebar'); ?></h3>
	    <p class="noside"><?php _e('To edit this sidebar, go to admin backend\'s <strong><em>Appearance -&gt; Widgets</em></strong> and place widgets into the <strong><em>Default Sidebar</em></strong> Area', SP_TEXT_DOMAIN); ?></p>
	    </div>
	    
	<?php
	endif;	
		?>
		
</aside> <!--End #sidebar-right-->	