<div class="post">

	<p class="post-subtitle" style="margin-bottom:0px;text-transform:uppercase;font-size:12px;"><?php the_category( ', ' ); ?> </p>
	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

	<?php the_excerpt(); ?>
	
	<?php get_template_part( 'modules/post-metadata' ); ?>
	
</div>