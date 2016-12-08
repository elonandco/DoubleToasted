<?php
/**
 * @package Frank
 */
?>
<?php get_header(); ?>

<div class="page main">
	<img src="../wp-content/themes/toasted/images/faq_top_image.gif" class="top-banner">
	<div class="content">

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>

			<?php the_post(); ?>

			<div class="large-12 columns">
				<div class="large-12 columns">
					<h1><?php the_title(); ?></h1>
				</div>
			</div>

			<div class="large-12 columns">
				<div class="large-12 columns">
					<?php the_content(); ?>
				</div>
			</div>


	<?php endwhile; endif; ?>

	</div>
</div><!-- .page.main -->

<?php get_footer(); ?>