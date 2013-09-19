<?php
/**
 * The template for displaying footer.
 *
 * Contains secondary widget areas, footer content and the closing of the
 * #main and #page div elements.
 */

 global $smof_data; ?>
 		<div class="clear"></div>
 		<?php get_sidebar('footer'); ?>
    	</div><!-- .container .clearfix -->
    </div><!-- #content -->
    
    <footer id="footer" role="contentinfo">
        <div class="container clearfix">
        	<nav id="footer-menu" class="footer-menu">
            <?php echo sp_footer_navigation(); ?>
        	</nav>
            <p class="copyright"><?php echo $smof_data['footer_text']; ?></p>
        </div><!-- .container .clearfix -->
    </footer><!-- #footer -->
</div> <!-- #page -->
<div class="scroll-to-top"><a href="#" title="<?php _e( 'Scroll to top', 'newsplus' ); ?>"></a></div><!-- .scroll-to-top -->
<?php wp_footer(); ?>
</body>
</html>