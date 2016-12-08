<?php
/**
 * @package Frank
 * This is the template for single show pages
 */
?>

<?php get_header(); ?>

<div class="main single audio-single show-simple-comments">

	<div class="content full-width dt-media">
	
		<div class="content">

			<?php while ( have_posts() ) : ?>
			
				<?php the_post(); ?>
				
				<div id="dt-media-header" class="clear">
				
					<div class="large-7 medium-6 columns">

						<?php echo '<h1>' . $post->post_title . '</h1>'; ?>
						
						<p class="dt-crumbs">

							<a href="/audiocasts/">Podcasts</a> >
							<span><?php echo $post->post_title; ?></span>
						
						</p>
						
					</div>
					
					<div class="post-paging large-5 medium-6 columns single-nav">
	
						<?php get_template_part( 'modules/post-nav-social' ); ?>
					
					</div>
					
				</div>
				
				<div class="post-content large-12 medium-12 columns" id="dt-media-subscribe">
							
					<?php 
								
						$audiourl = get_post_meta( $post->ID, '_lac0509_dt-audio-url', true );
						if ($audiourl) {
							$htmlaudio = wp_oembed_get( $audiourl );
							echo '<div id="dt-audio-choice">' . $htmlaudio . '</div>';
						}
						
					?>

					<div class="clear" id="dt-review-content" style="width:100%;">
			
						<?php echo '<h3>' . date( 'F j' , strtotime(get_the_date()) ) . '</h3>'; ?>
						<?php the_content(); ?>
						
					</div>	

					<div class="dt-post-meta-single">
								
						<?php 
							
							// Get Favorite Count
							if ( bp_has_activities( '&action=new_blog_post&secondary_id=' . $post->ID ) ) { 
								while ( bp_activities() ) : bp_the_activity();
	
								$my_fav_count = bp_activity_get_meta( bp_get_activity_id(), 'favorite_count' );						
								if (!$my_fav_count >= 1)
									$my_fav_count = 0;
								echo '<span class="dt-archive-toasts">' . $my_fav_count . '</span>';
								endwhile;
						
							}
	
							// Get Comment Count
							echo '<span class="dt-archive-com-count">' . get_comments_number() . '</span>';
																
						?>
								
					</div>
	
				</div>

			<?php endwhile; ?>
		</div>
	</div>
	
	<div class="content">
	
		<div class="large-12 columns">
	
			<h2 id="dt-media-more">More Audiocasts</h2>
		
			<div id="dt-single-slider">
				
				<?php

					 $args = array(
						'numberposts' => 16,
						'orderby' => 'post_date',
						'order' => 'DESC',	
						'exclude' => $post->ID,				
						'post_type' => 'dt-audio'
					);
					
					$homeQ = wp_get_recent_posts( $args, ARRAY_A );
				
					foreach ($homeQ as $recentPost) {
	
						echo '<a href="' . get_the_permalink($recentPost["ID"]) . '">' . get_the_post_thumbnail($recentPost["ID"], 'sm-archive');
						echo '<span class="dt-ep">' . $recentPost["post_title"] . '</span>';
						echo '</a>';
					
					}
					
				?>
				
			</ul>
		
		</div>
		
		</div>
		
	</div>
	
	<?php dynamic_sidebar( 'dt-above-comments' ); ?>
	
	<div class="content clear" id="dt-side-comments">
		 
		<div class="large-12 columns">
			<h2 id="dt-media-more">
			
				Comments
			
				<?php if (!is_user_logged_in()) { ?>
				
					<a class="button thickbox" href="#TB_inline?width=800&height=450&inlineId=dt-login" id="log-in-comment">Log-in to comment</a>
				
				<?php } ?>
			
			</h2>
		</div>
	
		<div class="activity large-9 medium-10 small-12 end columns" role="main">		
			
			<?php 
			
				bp_get_template_part( 'activity/activity-loop-single' );
			
			?>

		</div><!-- .activity -->
		
		<div class="large-3 columns medium-2 small-12" style="text-align:center;">
		
			<?php dynamic_sidebar( 'dt-feature-single' ); ?>
			
		</div>
 		
	</div>
	
</div><!-- .single.main -->

<!-- Plugin: BP EDITABLE ACTIVITY 
	Had to manually que scripts for single show page comments -->

<?php wp_enqueue_script( 'jquery-ui-tooltip' ); ?>
<?php wp_enqueue_script( 'jquery-ui-button' ); ?>
<?php wp_enqueue_script( 'editable-activity', '/wp-content/plugins/bp-editable-activity/assets/editable-activity.js', array('jquery','jquery-editable') ); ?>
<?php wp_enqueue_script( 'jquery-editable', '/wp-content/plugins/bp-editable-activity/assets/jqe/jqueryui-editable/js/jqueryui-editable.min.js', array('jquery','jquery-ui-tooltip','jquery-ui-button') ); ?>

<?php wp_enqueue_style( 'jq-edit-ui-css', '/wp-content/plugins/bp-editable-activity/assets/jqui/jquery-ui-1.10.4.custom.css' ); ?>
<?php wp_enqueue_style( 'jqui-edit-css', '/wp-content/plugins/bp-editable-activity/assets/jqe/jqueryui-editable/css/jqueryui-editable.css' ); ?>

<?php
	$data = array(
		'edit_activity_title' => __( 'Edit Activity', 'bp-editable-activity' ),
		'edit_comment_title' => __( 'Edit Comment', 'bp-editable-activity')
	);
	
	wp_localize_script('editable-activity', 'BPEditableActivity', $data );
?>

<!-- end BP EDITABLE ACTIVITY -->

<?php get_footer(); ?>