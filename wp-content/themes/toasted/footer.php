<?php
/**
 * @package Frank
 */
?>

<div class="footer">
    <div class="content full-width dt-today-feature">

        <div class="small-4 columns feature">
            <a href="http://dtmerch.com/">
                <div class="store-link-flash">
                </div>
            </a>
        </div>

        <div class="small-4 columns feature">
            <a href="http://dtmerch.com/">
                <div class="store-link-no-flash">
                </div>
            </a>
        </div>

        <div class="small-4 columns">
            <div class="subscriber-form">
                <div class="subscribe-text">
                    <?php dynamic_sidebar('dt-today-footer'); ?>
                </div>
                <div class="subscribe-form">
                    <form id="newsletter-subscribe">
                        <span class="newsletter-subscribe-response"></span>
                        <input type="text" name="subscriber" value="" placeholder="Enter your email address to signup"/>
                        <input class="submit-subscribe-form" type="submit" value="Subscribe"/>
                    </form>
                </div> <!-- /.subscribe-form -->
            </div>
        </div>
    </div>

    <div class="content full-width dt-info">

        <div class="content">
        <div class="social-media">
            <span>Check us out on:</span>
            <div class="small-12 columns dt-social-share">
                <a target="_blank" href="https://instagram.com/doubletoastedfanpage/">
                    <img class="fl-right" src="<?php echo get_template_directory_uri(); ?>/images/insta-@2x.png"/>
                </a>
                <a target="_blank" href="https://twitter.com/doubletoasted_">
                    <img class="fl-right" src="<?php echo get_template_directory_uri(); ?>/images/Twitter@2x.png"/>
                </a>
                <a target="_blank" href="http://www.youtube.com/subscription_center?add_user=DoubleToastedDOTcom">
                    <img class="fl-right yt" src="<?php echo get_template_directory_uri(); ?>/images/YouTube@2x.png"/>
                </a>
                <a target="_blank" href="https://www.facebook.com/DoubleToasteddotcom?fref=ts">
                    <img class="fl-right fb" src="<?php echo get_template_directory_uri(); ?>/images/Facebook@2x.png"/>
                </a>
            </div> <!-- /.dt-social-share -->
        </div> <!-- /.social-media -->

        <div class="large-6 medium-6 columns nav">
            <?php
            $cached_footer_nav = wp_cache_get('cached_footer_nav');

            if (false === $cached_footer_nav) {
                $nav_menu = wp_nav_menu(array(
                    'echo'           => false,
                    'theme_location' => 'frank_footer_navigation',
                    'container'      => false,
                    'menu_class'     => 'footer-nav-menu',
                    'depth'          => 1,
                ));
                wp_cache_set('cached_footer_nav', $nav_menu);
                echo '<ul class="main-nav-menu" id="menu-main-menu">' . $nav_menu . '</ul>';
            } else {
                echo $cached_footer_nav;
                echo '<h2>cachehit</h2>';
            }

            ?>
        </div> <!-- /.nav -->
        </div>

    </div> <!-- /.container -->
</div><!-- /.footer -->

</div><!-- .dt-window-wrap -->

<?php wp_enqueue_script('jquery', '/wp-includes/js/jquery/jquery.js', array(), '1.11.1', true); ?>
<?php wp_enqueue_script('dt-core', '/wp-content/themes/toasted/modules/scripts/load.js', 'jquery', '3.2.3', true); ?>
<?php wp_enqueue_script('enc-swipe', '/wp-content/themes/toasted/modules/scripts/enc.swipe.js', 'jquery', '3.2.3', true); ?>
<?php wp_enqueue_script('enc-core', '/wp-content/themes/toasted/modules/scripts/enc.default.js', 'jquery', '3.2.3', true); ?>

<?php wp_footer(); ?>

</body>
</html>