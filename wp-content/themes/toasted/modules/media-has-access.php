<?php while ( have_posts() ) : ?>

	<?php the_post(); ?>
	
	<div id="dt-media-header" class="large-12 columns">
	
		<div class="large-7 medium-6 columns">

			<?php 
			
				// Does this show belong to a series?
				$dtSeries = wp_get_post_terms( $post->ID, 'series' );
				if ($dtSeries && !is_wp_error( $dtSeries )) { 
				
					// Default to Category Parent (if it exists)
					$howManyTerms = count($dtSeries); 
					$i = 0;
					
					if ($howManyTerms >= 2) {
						$i = $howManyTerms - 1;
					}

					$dtTitle = $dtSeries[$i]->name;	
					$dtLink = $dtSeries[$i]->slug;

					echo '<h1>' . $dtTitle . '</h1>';
					
				 } 
				 
				 
				 else { 
				 
					// If no series title set to show title
					echo '<h1>' . $post->post_title . '</h1>'; 
					$dtTitle = 'Misc';
					$dtLink = '';
					
				 }
					
			?>
			
			<p class="dt-crumbs">

				<a href="/shows/">Shows</a> >
				<a href="/<?php echo $dtLink ?>/"><?php echo $dtTitle; ?></a> >
				<span><?php echo $post->post_title; ?></span>
			
			</p>
			
		</div>
		
		<div class="post-paging large-5 medium-6 columns single-nav">

			<?php get_template_part( 'modules/post-nav-social' ); ?>
		
		</div>
		
	</div>
	
	<div class="post-content large-12 medium-12 columns" id="dt-media-subscribe">
	
		<?php //get_template_part( 'modules/blastro-api-call' ); 
		?>
		
		<?php  woocommerce_empty_cart(); ?>
		
		<?php
		
			// Check if user has purchased this particular episode
			$currentUser = wp_get_current_user();
			$productID = get_post_meta( $post->ID, '_lac0509_dt-show-sku', true );
			
			if ($productID) {
		
				if ( woocommerce_customer_bought_product( $currentUser->user_email, $currentUser->ID, $productID)) {
				
					$hasAccess = true;
				
				}
		
			}
			
			$audiourl = get_post_meta( $post->ID, '_lac0509_dt-audio-url', true );
			$videourl = get_post_meta( $post->ID, '_lac0509_dt-preview-video-url', true );
			$fullvideourl = get_post_meta( $post->ID, '_lac0509_dt-video-url', true );
			
			if ($audiourl || $videourl) {
				$previewMedia = true;
			}
		
		if ($hasAccess) { ?>
				
			<div id="dt-video-access">
			
				<div id="dt-video-option">
				
					<div id="dt-option-content">
						<h2>Need to get live full-length video links in here to test.</h2>
					</div>

				</div>		
			
			</div>
			
		<?php } else if ($fullvideourl) { ?>
			
				<div id="dt-video-option">
				
					<div id="dt-option-content">
						<h2>Full length video episodes are available on demand or by subscription</h2>
						
							<?php
							
							if ($dtSeries !== 'Review') {
							
								// If there is an associated product ID, give user the option to purchase
								if ($productID) {
									echo '<a class="dt-click button" href="http://kcoolman.wpengine.com/cart/?add-to-cart=' . $productID . '">Buy Video</a>';
								}
															
								// Link to subscription options
								echo '<a class="dt-click button" href="http://kcoolman.wpengine.com/subscription-plans/">View Plans</a>';
								
								// If there is an associated audio URL, give user the option to listen for free
								if ($audiourl) {
									echo '<a id="dt-audio-click">Listen to the full audio only version.</a>';
								}
								
								// If there is an associated video preview URL, give user the option to view for free
								if ($videourl) {
									echo '<a id="dt-video-click">Watch a short video preview.</a>';
								}
						
							}
						
							?>
						
					</div>
										
				</div>
				
				<?php 
				
					// Audio Preview
					if ($audiourl) {
						$htmlaudio = wp_oembed_get( $audiourl );
						echo '<div id="dt-audio-choice">' . $htmlaudio . '</div>';
					}
					
					// Video Preview
					if ($videourl) {
						$htmlvideopre = wp_oembed_get( $videourl );
						echo '<div id="dt-video-choice">' . $htmlvideopre . '</div>';
					}
					
				?>
				
			
		<?php } else if ($audiourl) { ?>
									
			<?php 
			
				// Audio only shows
				$htmlaudio = wp_oembed_get( $audiourl );
				echo '<div id="dt-audio-only-choice">' . $htmlaudio . '</div>';
				
			?>		
		
		<?php } ?>

		<div class="large-12 columns dt-media-postinfo">

			<h1 class="post-title"><?php the_title(); ?></h1>
			
			<?php the_content(); ?>
			<?php get_template_part( 'modules/post-metadata' ); ?>
			
		</div>	

	</div>

<?php endwhile; ?>