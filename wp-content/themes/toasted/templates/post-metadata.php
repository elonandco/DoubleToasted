<p class="post-subtitle">
	<?php
		echo _x( 'Written by', 'post_author_attribution', 'frank_theme' );
		echo ' ';
		the_author_link();
	?>
	on	<a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
 
<?php the_tags( '', ' ' ); ?>

<!-- 
	<a href="<?php comments_link(); ?>">
		<?php
// 			comments_number(
// 				__( 'No Comments', 'frank_theme' ),
// 				__( 'One Comment', 'frank_theme' ),
// 				__( '% Comments', 'frank_theme' )
// 			);
		?>
	</a>
 -->
	
	</p>