<?php
/**
 * Custom podcast feed for DT.com
 * - Pulls soundcloud stream URLs thru API
 * - RSS2 Feed Template for displaying RSS2 Posts feed.
 * - Requires hook in functions.php to load properly
 *
 * @package WordPress
 */

// Define custom length for this RSS feed excerpt
function rss_excerpt_length( $length ) {
	return 2;
}
add_filter( 'excerpt_length', 'rss_excerpt_length', 999 );

header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
$more = 1;

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';

/**
 * Fires between the xml and rss tags in a feed.
 *
 * @since 4.0.0
 *
 * @param string $context Type of feed. Possible values include 'rss2', 'rss2-comments',
 *                        'rdf', 'atom', and 'atom-comments'.
 */
do_action( 'rss_tag_pre', 'rss2' );
?>

<rss version="2.0" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/">
   <channel>
    	<?php

    		// Display the Title
            $dtSeries = wp_get_post_terms( $post->ID, 'series' );
            if ($dtSeries && !is_post_type_archive() ) {
	            echo '<title>' . $dtSeries[0]->name . ' at Doubletoasted.com</title>';
		    }
		    else {
		    	echo '<title>Doubletoasted.com</title>';
		    }

    	?>
        <itunes:author>doubletoasted.com</itunes:author>
        <description>Home of Korey Coleman and the Double Toasted crew. Bringing you the latest Hollywood movie reviews, pop culture commentary and fun animated entertainment.</description>
        <itunes:summary>Home of Korey Coleman and the Double Toasted crew. Bringing you the latest Hollywood movie reviews, pop culture commentary and fun animated entertainment.</itunes:summary>
  		<atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
        <link>http://doubletoasted.com</link>
        <language>en-us</language>
        <copyright>All content is &#xA9; Doubletoasted.com 2015. Feed powered by Soundcloud.</copyright>
        <lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
        <image>
        	<title><?php echo $dtSeries[0]->name . ' at Doubletoasted.com'; ?></title>
            <url>http://doubletoasted.com/wp-content/themes/toasted/images/podcast-img-dt.jpg</url>
            <link>http://doubletoasted.com</link>
        </image>
        <itunes:owner>
            <itunes:name>Korey Coleman</itunes:name>
            <itunes:email>kcoolman@realtime.net</itunes:email>
        </itunes:owner>
        <itunes:category text="TV &amp; Film"/>
        <itunes:category text="Society &amp; Culture"/>
        <itunes:explicit>yes</itunes:explicit>
        <itunes:image href="http://doubletoasted.com/wp-content/themes/toasted/images/podcast-img-dt.jpg" />
        <pubDate>Sun, 01 Jan 2012 00:00:00 EST</pubDate>
		<sy:updatePeriod><?php
			$duration = 'hourly';

			/**
			 * Filter how often to update the RSS feed.
			 *
			 * @since 2.1.0
			 *
			 * @param string $duration The update period. Accepts 'hourly', 'daily', 'weekly', 'monthly',
			 *                         'yearly'. Default 'hourly'.
			 */
			echo apply_filters( 'rss_update_period', $duration );
		?></sy:updatePeriod>
		<?php while( have_posts()) : the_post(); ?> 
        <item>
            <title><?php the_title_rss() ?></title>
            <link><?php the_permalink_rss() ?></link>
            <comments><?php comments_link_feed(); ?></comments>
            <?php
            	$stripped_content = get_the_content();
            	$stripped_content = substr($stripped_content, 0, 150) . '...';
            	echo '<description>'.$stripped_content.'</description>';
            ?>
            <itunes:summary><?php echo $stripped_content; ?></itunes:summary>
            <?php 
	
				// Get the permalink of the podcast
				$audiourl = get_post_meta( get_the_ID(), '_lac0509_dt-audio-url', true );

				if ($audiourl) {

					// Make Public HTTP request to Soundcloud API
					$sc_track = file_get_contents('https://api.soundcloud.com/resolve.json?url=' . $audiourl . '&client_id=73ed0180dff819d1f37cbabe90fc8f36');
					
					if ($sc_track) {

						// Convert JSON Response into associative array
						$sc_json = json_decode($sc_track,true);

						$length_seconds = intval(intval($sc_json['duration']) * .001 );

						// Assemble MP3 link from Soundcloud (built based on RSS feed format)
						echo "<enclosure url='http://feeds.soundcloud.com/stream/" . $sc_json['id'] . "-" . $sc_json['user']['permalink'] . "-" . $sc_json['permalink'] . ".mp3' length='" . $length_seconds . "' type='audio/mpeg' />";
						//212551829-kcoolman-the-daily-double-talk-6-29-15.mp3

					}	
				}

			?>
            <guid><?php the_permalink(); ?></guid>
            <itunes:duration><?php echo $length_seconds; ?></itunes:duration>
            <pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
        </item>
    <?php endwhile; ?>
    </channel>
</rss>
