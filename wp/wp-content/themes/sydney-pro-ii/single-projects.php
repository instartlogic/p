<?php
/**
 * The template for displaying all single projects.
 *
 * @package Sydney
 */

if (get_theme_mod( 'project_feat_image' ) != 1 ) {
	get_header();
} else {
	get_header('featured-image');
}
?>

	<?php if (get_theme_mod('fullwidth_project')) { //Check if the post needs to be full width
		$fullwidth = 'fullwidth';
	} else {
		$fullwidth = '';
	} ?>

	<div id="primary" class="content-area col-md-9 <?php echo $fullwidth; ?>">
		<main id="main" class="post-wrap" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'partials/content', 'project' ); ?>

			<?php if ( get_theme_mod('project_nav', 0) != 1 ) {
				sydney_post_navigation();
			} ?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php if ( get_theme_mod('fullwidth_project', 0) != 1 ) {
	get_sidebar();
} ?>
<?php get_footer(); ?>
