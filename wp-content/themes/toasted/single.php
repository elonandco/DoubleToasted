<?php
/**
 * @package Frank
 */
?>

<?php get_header(); ?>
<?php while (have_posts()) : ?>
    <?php the_post(); ?>
    <?php
    $embedLink = get_post_meta($post->ID, '_lac0509_dt-media-internal', true);

    if (!$embedLink) {
        $internalLink = get_post_meta($post->ID, '_lac0509_dt-media-external', true);
    }

    if ($embedLink || $internalLink) {
        $hasMedia = true;
    }

    ?>
    <div class="main single-news <?php if ($hasMedia) {
        echo ' dt-media-single';
    } ?> show-simple-comments">
    <div class="dt-media <?php if ($hasMedia) {
        echo ' full-width dt-media';
    } ?>">
    <div class="contents">
        <div class="post-content clear">
            <!-- <div id="dt-media-header">
                <div class="content">
                    <div class="large-7 medium-6">
                        <h3><?php the_title(); ?></h3>
                        <p class="dt-crumbs">
                            <a href="/news/">News</a>
                            <span><?php echo $post->post_title; ?></span>
                        </p>
                    </div> <!-- /.large-7 --
                </div> <!-- /.content --
            </div><!-- /.dt-media-header -->
            <div class="second-toolbar">
                <?php get_template_part('modules/post-nav-social'); ?>
                <ul class="video-link">
                    <li class="comments"><i class="fa fa-comment-o" aria-hidden="true"></i></li>
                </ul>

                <div class="large-12 columns single-content">
                    <?php
                    if ($embedLink) {
                        echo wp_oembed_get($embedLink);
                    }

                    if ($internalLink) {
                        do_shortcode($internalLink);
                    }

                    // the_post_thumbnail( 'default-thumbnail', array('class' => 'pfloatleft') );
                    //get_template_part( 'modules/post-metadata' );
                    ?>
                </div> <!-- /.single-content -->
            </div> <!-- /.second-toolbar -->
        </div> <!-- /.post-content -->
    </div> <!-- /.contents -->
<?php endwhile; ?>
    </div> <!-- /.dt-media -->

    <div class="content blog-post-content more-shows clear" style="overflow:hidden;<?php if ($hasMedia) {
        echo 'padding-top:50px;';
    } else {
        echo 'padding-top:0px;';
    } ?>margin-bottom:30px;">
        <div class="large-8 columns">
            <p style="font-size:18px;text-transform:none;">
                Posted on <?php the_date(); ?> by <?php the_author(); ?>
            </p>

            <?php remove_filter('the_content', 'polldaddy_show_rating', 5); ?>
            <?php
            $metaData = '<div class="dt-post-meta-single" style="width:100%;margin-bottom:20px;text-align:center;">';
            $metaData .= '<div class="dt-post-meta-center">';
            // Get Favorite Count
            if (bp_has_activities('&action=new_blog_post&secondary_id=' . $post->ID)) {
                while (bp_activities()) : bp_the_activity();

                    $my_fav_count = bp_activity_get_meta(bp_get_activity_id(), 'favorite_count');

                    if (!$my_fav_count >= 1) {
                        $my_fav_count = 0;
                    }
                    $metaData .= '<span class="dt-archive-toasts">' . $my_fav_count . '</span>';
                endwhile;
            }

            // Get Comment Count
            $metaData .= '<span class="dt-archive-com-count">' . get_comments_number() . '</span>';
            $metaData .= '</div> <!-- /.dt-post-meta-center -->';
            $metaData .= '</div> <!-- /.dt-post-meta-single -->';

            $content = get_the_content();
            $content = preg_replace('/<\/a>/i', '</a>' . $metaData, $content, 1);
            echo $content;
            ?>
        </div> <!-- /.columns -->

        <div class="large-4 columns">
            <?php
            // Show related posts in right hand sidebar

            // Get categories of current post
            $post_cats  = wp_get_post_categories($post->ID);
            $current_id = $post->ID;

            if ($post_cats) {
                foreach ($post_cats as $c) {
                    $cat    = get_category($c);
                    $cats[] = $cat->slug;
                }
            } else {
                $cats = false;
            }

            // Build query with our categories
            $args = array(
                'category_name'  => implode(',', $cats),
                'post_type'      => array('post'),
                'order'          => 'DESC',
                'orderby'        => 'date',
                'posts_per_page' => 5,
            );

            $side_query = new WP_Query($args);

            // The Loop
            if ($side_query->have_posts()) {
                echo '<div class="dt-side-news-related"><h2>Recent news</h2>';

                while ($side_query->have_posts()) : $side_query->the_post();
                    if ($post->ID !== $current_id) {
                        echo '<div class="related-item"><p class="related-meta">' . get_the_date('l, F j') . '</p>';
                        echo '<h4 class="related-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '<span class="related-author"> by ' . get_the_author() . '</span></a></h4></div><div class="divider"></div>';
                    }
                endwhile;
                echo '</div>';
            }

            // Reset Post Data
            wp_reset_postdata();
            ?>

            <?php dynamic_sidebar('dt-ad-single-sidebar'); ?>
        </div> <!-- /.columns -->
    </div> <!-- /.content -->

<?php dynamic_sidebar('dt-above-comments'); ?>

    <div class="content clear" id="dt-side-comments">
        <div class="large-12 columns">
            <h2 id="dt-media-more">
                Comments
                <?php if (!is_user_logged_in()) { ?>
                    <a class="button thickbox" href="#TB_inline?width=800&height=450&inlineId=dt-login"
                       id="log-in-comment">Log-in to comment</a>
                <?php } ?>
            </h2>
        </div> <!-- /.columns -->

        <div class="activity large-9 medium-10 small-12 columns" role="main">
            <?php bp_get_template_part('activity/activity-loop-single'); ?>
        </div><!-- /.activity -->

        <div class="large-3 columns medium-2 small-12" style="text-align:center;">
            <?php dynamic_sidebar('dt-feature-single'); ?>
        </div> <!-- /.columns -->
    </div> <!-- /.content -->

    </div><!-- /.single.main -->

    <!-- Plugin: BP EDITABLE ACTIVITY
        Had to manually que scripts for single show page comments -->

<?php wp_enqueue_script('jquery-ui-tooltip'); ?>
<?php wp_enqueue_script('jquery-ui-button'); ?>
<?php wp_enqueue_script('editable-activity', '/wp-content/plugins/bp-editable-activity/assets/editable-activity.js', array(
    'jquery',
    'jquery-editable',
)); ?>
<?php wp_enqueue_script('jquery-editable', '/wp-content/plugins/bp-editable-activity/assets/jqe/jqueryui-editable/js/jqueryui-editable.min.js', array(
    'jquery',
    'jquery-ui-tooltip',
    'jquery-ui-button',
)); ?>

<?php wp_enqueue_style('jq-edit-ui-css', '/wp-content/plugins/bp-editable-activity/assets/jqui/jquery-ui-1.10.4.custom.css'); ?>
<?php wp_enqueue_style('jqui-edit-css', '/wp-content/plugins/bp-editable-activity/assets/jqe/jqueryui-editable/css/jqueryui-editable.css'); ?>

<?php
$data = array(
    'edit_activity_title' => __('Edit Activity', 'bp-editable-activity'),
    'edit_comment_title'  => __('Edit Comment', 'bp-editable-activity'),
);

wp_localize_script('editable-activity', 'BPEditableActivity', $data);
?>

    <!-- end BP EDITABLE ACTIVITY -->

<?php get_footer(); ?>