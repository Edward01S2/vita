<?php 
/**
 * This file displays a standard WordPress post.
 */

// If post is single.
if (is_single()) : 

   // Get set column width from functions.php
   global $tw_column_width;

  /**
   * Get post options
   */
  $subheadline  = get_post_meta($post->ID, 'ag_subheadline', true); // Subheadline
  $columns      = get_post_meta($post->ID, 'ag_fullwidth', true) == 'Full' ? 'sixteen' : $tw_column_width; // number of columns
  $postclass 	  = ($columns == 'sixteen') ? 'full-width-post' : 'three-fourths-post';
  ?>

  <!-- Post Classes -->
  <div <?php post_class($postclass); ?>>

    <!-- Post Title -->
    <div class="pagetitle">
      <div class="container">

        <!-- Title -->

          <!-- End Title -->

          <!-- Controls -->
          <!-- End Controls -->

      </div>
    </div>
    <!-- End Post Title -->

      <!-- Post Container -->
      <div class="container">
         <div class="<?php echo $columns; ?> columns">

              <!-- Content -->
              <div class="singlecontent">
                <?php get_template_part('functions/templates/postcontrols'); ?>
                  <?php the_content(); ?>
                  <?php if ($subheadline && $subheadline != '') { ?>
                    <p class="portfolio-subtitle">
                        <?php echo $subheadline; ?> 
                    </p>
                  <?php } ?>
              </div> <div class="clear"></div>
              <!-- End Content --> 
              
          </div>  
      </div>
      <!-- End Post Container -->

</div>
<!-- End Post Classes -->

<?php 
else :
  // Otherwise display thumbnail  
  get_template_part('functions/templates/thumbnail-portfolio'); 
endif; ?>