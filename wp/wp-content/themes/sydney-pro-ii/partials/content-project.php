<?php
/**
 * @package Sydney
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() && ( get_theme_mod( 'project_feat_image' ) != 1 ) ) : ?>
		<div class="entry-thumb">
			<?php the_post_thumbnail('large-thumb'); ?>
		</div>
	<?php endif; ?>

	<header class="entry-header">
		<?php the_title( '<h1 class="title-post">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php sydney_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
