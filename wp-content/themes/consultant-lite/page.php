<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Consultant_Lite
 */

get_header();
?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main">
			<?php
			
			//get page ID
			$pageID = get_the_ID();
			
			while ( have_posts() ) :
				the_post();
	            //student record page
				if($pageID == 6)
				{
                  get_template_part( 'template-parts/Studentcontent', 'page' );
				    }else if($pageID == 46)
				      {
					    get_template_part( 'template-parts/gradeSectioncontent', 'page' );
				      }else if($pageID == 50)
				        {
					      get_template_part( 'template-parts/gradeSubjectcontent', 'page' );
						    }else if($pageID == 60)
				              {
					            get_template_part( 'template-parts/classGradescontent', 'page' );
				                 }else if($pageID == 97)
				                   {
					                 get_template_part( 'template-parts/printGradescontent', 'page' );
				  }else{
					 get_template_part( 'template-parts/content', 'page' );
				}
	
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
	
			endwhile; // End of the loop.
			?>
	
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php get_sidebar(); ?>

<?php
get_footer();
