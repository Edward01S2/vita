<div class="clear"></div>

<!-- Footer -->
<div id="footer" class="dark">
    <div class="container clearfix">
        <div class="sixteen columns">
            <div class="one-third"><?php	/* Widget Area */ if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Left') ) ?></div>
            <div class="one-third"><?php	/* Widget Area */ if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Center') ) ?></div>
            <div class="one-third column-last"><?php	/* Widget Area */ if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Right') ) ?></div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<!-- End Footer -->

<!-- Theme Hook -->
<?php wp_footer(); ?>

<!-- End Site Container -->
</div> 
</body>
</html>