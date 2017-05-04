<?php
/**
 * The template for displaying all single employees.
 *
 * @package Sydney
 */

get_header(); ?>

	<?php if (get_theme_mod('fullwidth_employee')) { //Check if the post needs to be full width
		$fullwidth = 'fullwidth';
	} else {
		$fullwidth = '';
	} ?>

	<div id="primary" class="content-area col-md-9 <?php echo $fullwidth; ?>">
		<main id="main" class="post-wrap" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'partials/content', 'employee' ); ?>
			
			<?php if ( get_theme_mod('employee_nav', 0) != 1 ) {
				sydney_post_navigation();
			} ?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php if ( get_theme_mod('fullwidth_employee', 0) != 1 ) {
	get_sidebar();
} ?>
<?php get_footer(); ?>
