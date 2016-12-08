<?php
/**
 * @package Frank
 */
?>

<?php get_header(); ?>
<div class="single main" role="main">
	<div class="section row white-bg">
		<div class="row white-bg">
			<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			
				<div class="large-9 columns">
				
					<div class="large-12 columns">
						
					</div>
					<div class="large-12 columns">
						
					<h1 class="post-title"><?php the_title(); ?></h1>

					<?php echo wp_get_attachment_image( $post->ID, 'full' ); ?>
					</div>
					<div class='large-12 columns'>
						<?php get_template_part( 'partials/post-metadata' ); ?>
					</div>
					<div class="large-12 columns single-nav">
							<?php if (previous_post_link()) { previous_post_link( 'Back: %link' );} ?>
							<?php if (next_post_link()) {next_post_link( 'Next: %link' );} ?>
					</div>
				</div>
				
				<div class="large-3 columns sidebar">
					<?php get_template_part( 'partials/sidebars/sidebar', 'single' ); ?>
				</div>

			<?php endwhile; ?>

		</div>
	</div>
</div>
<?php get_footer(); ?>