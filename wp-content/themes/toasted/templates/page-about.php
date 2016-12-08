<?php
/**
 * @package Frank
 */

/*
Template Name: About
*/
?>
<?php get_header(); ?>

<div class="main about-us">
	<div id="about-header">
		<div id="wrap_video">
			<div id="video_box">
				<div id="header-video">
					<?php

					    echo do_shortcode('[video width="1920" height="500px" mp4="/wp-content/themes/toasted/images/DT-Logo-Animation-w-ALPHA.mp4" autoplay="on" loop="on"]');

					?>
				</div>
				<div id="video_overlays">
					<span class="vid-desc">Due to the movie screening schedule we have to attend, time change every week. Please check the home page carousel for correct times.</span>
					<div class="video-desc">
						<div class="half-shows">
							<div class="dt-show">
								<span class="show-title">THE SUNDAY SERVICE</span>
								<span class="show-time">SUNDAYS, 5 PM CST</span>
							</div>
							<div class="dt-show">
								<span class="show-title">THE WEEKLY ROAST AND TOAST</span>
								<span class="show-time">8:30 OR 9:30 PM CST</span>
							</div>
							<div class="dt-show">
								<span class="show-title">THE HIGH SCORE</span>
								<span class="show-time">SATURDAYS, 5 PM CST</span>
							</div>
						</div>
						<div class="half-shows">
							<div class="dt-show">
								<span class="show-title">THE CASUAL CALL IN SHOW</span>
								<span class="show-time">TUESDAY, 8:30 OR 9:30 PM CST</span>
							</div>
							<div class="dt-show">
								<span class="show-title">THE MOVIE REVIEW EXTRAVAGANZA</span>
								<span class="show-time">WEDNESDAYS, 8:30 OR 9:30 PM CST</span>
							</div>
							<div class="dt-show">
								<span class="show-title"></span>
								<span class="show-time"></span>
							</div>
						</div>
					</div>
				</div>
				<div>
				</div>
			</div>
		</div>
		<div class="divider top" style="margin-top: -2.5%"></div>
	</div>
	<div class="content" style="">

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : ?>

				<?php the_post(); ?>

				<div class="large-12 columns">
					<div class="large-12 columns">
						<?php the_content(); ?>
					</div>
				</div>


		<?php endwhile; endif; ?>

	</div>

    <div class="more-shows">
	    <div class="divider" style="clear: both;"></div>
	    <div class="show show-cast">
	        <div class="title">
	            <h2>Meet the Rest of the Cast</h2>
	        </div>
	        <ul class="slider">

	        </ul>
	        <ul class="pagination">
	        </ul>
	        <div class="prev arrow"></div>
	        <div class="next arrow"></div>
	    </div>
	</div>

	<div class="divider" style="clear: both;"></div>
	<div class="content" style="margin-top: 25px; clear: both;">
		<div class="small-9 columns">
			<div>
				<h1>Tell Us About ourselves...</h1>
				<h2>...by taking this brief survey</h2>
				<div style="margin-top: 10px;">
					<?php echo do_shortcode('[sform id=\'95282\']'); ?>
	            </div>
			</div>
		</div>
		<div class="small-3 columns">
			<div class="caricature caricature-3"></div>
		</div>
	</div>

	<div class="social-links big" style="clear: both;">
		<div class="divider" style="margin-bottom: -9px; clear: both;"></div>
		<a href="https://www.facebook.com/DoubleToasteddotcom">
			<div class="facebook social-link">
				<i class="fa fa-facebook fa-5x"></i>
			</div>
		</a>
		<a href="http://www.youtube.com/subscription_center?add_user=DoubleToastedDOTcom">
			<div class="youtube social-link">
				<i class="fa fa-youtube fa-5x"></i>
			</div>
		</a>
		<a href="https://twitter.com/doubletoasted_">
			<div class="twitter social-link">
				<i class="fa fa-twitter fa-5x"></i>
			</div>
		</a>
		<a href="https://instagram.com/doubletoastedfanpage/">
			<div class="instagram social-link">
				<i class="fa fa-camera-retro fa-5x"></i>
			</div>
		</a>
		<div class="divider" style="clear: both"></div>
	</div>
	<div style="margin-top: 100px;"></div>
</div><!-- .page.main -->


<?php get_footer(); ?>