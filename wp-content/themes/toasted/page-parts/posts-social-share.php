<?php
/** 
 * Displays social share icons
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */
?>
<section class="container-wrap">
	<div class="container">
		<div class="share-links">
      
      <div class="hr-title hr-long"><abbr><?php _e("Share this article:", "kleo_framework"); ?></abbr></div>
      
      <span class="kleo-love">
      	<?php do_action('kleo_show_love'); ?>
      </span>
      <span class="kleo-facebook">
      	<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" class="post_share_facebook" onclick="javascript:window.open(this.href,
					'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=220,width=600');return false;"><i class="icon-facebook"></i>
					</a>
				</li>
      </span>
      <span class="kleo-twitter">
      	<a href="https://twitter.com/share?url=<?php the_permalink(); ?>" class="post_share_twitter" onclick="javascript:window.open(this.href,
					'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=260,width=600');return false;"><i class="icon-twitter"></i>
					</a>
      </span>
      <span class="kleo-googleplus">
      	<a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,
					'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="icon-gplus"></i>
					</a>
      </span>
      <span class="kleo-pinterest">
      	<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php if(function_exists('the_post_thumbnail')) echo wp_get_attachment_url(get_post_thumbnail_id()); ?>&description=<?php echo get_the_title(); ?>"><i class="icon-pinterest-circled"></i>
					</a>
      </span>
      <span class="kleo-mail">
      	<a href="mailto:?subject=<?php the_title(); ?>&body=<?php echo strip_tags(get_the_excerpt()); ?> <?php the_permalink(); ?>" class="post_share_email"><i class="icon-mail"></i>
					</a>
      </span>
      
		</div>					
	</div>
</section>