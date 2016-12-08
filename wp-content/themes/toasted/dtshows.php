<?php

/*
Controller name: DT Posts
Controller description: Awesome methods for Double Toasted posts
*/

class JSON_API_Dtshows_Controller {

    public function get_all_shows() {
        global $json_api;

        // get the uri
        $url          = parse_url($_SERVER['REQUEST_URI']);
        $singleSeries = $json_api->query->series_name;
        $test         = $json_api->query->test;
        $resetCache   = $json_api->query->reset_cache;
        $seriesList   = $json_api->query->series_list;
        $limit        = 15;
        $noTaxonomy = array('all-series', 'cast', 'misc');

        // defaults
        $defaults = array(
            'ignore_sticky_posts' => true,
            'post_type'           => 'dt_shows',
            'post_status'         => 'publish',
            'include'             => 'date,url,thumbnail,title,comment_count,custom_fields',
            'posts_per_page'      => $limit,
            'orderby'             => 'date',
            'order'               => 'DESC',
        );

        // see if we want to override any defaults
        $query = wp_parse_args($url['query']);
        unset($query['json']);
        unset($query['post_status']);

        // do the actual overwriting
        $query = array_merge($defaults, $query);

        // a little hack :)
        if ($query['include']) {
            $json_api->response->include_values = array_merge($json_api->response->include_values, explode(',', $query['include']));
        }

        $cacheKey = 'dt-home-feeds-data-' . $query['post_type'] . '-' . $query['orderby'] . '.txt';
        // . '.' . $query['post_type'] . '.' . $query['orderby'] . '.' . $query['order'];

        // disable cache for now
        /*$cachedData = $this->getCache($cacheKey);
        if ($cachedData && !$resetCache) {
            return $cachedData;
        }*/

        $allSeries = array();
        $results   = array(
            'cached' => false,
        );

        if(!empty($seriesList)) {
            $seriesList = explode(",",$seriesList);
            $i = 0;
            foreach($seriesList as $seriesName) {
                if(!in_array($seriesName, $noTaxonomy)) {
                    $series = get_term_by('slug', $seriesName, 'series');

                    $termMeta = get_option('taxonomy_' . $series->term_id);

                    if (isset($termMeta['hide_from_feed']) && $termMeta['hide_from_feed'] == 'true') {
                        continue;
                    }

                    $series->ad_placement = isset($termMeta['ad_placement']) ? $termMeta['ad_placement'] : '';

                    $allSeries[$i] = $series;
                } else {
                    $allSeries[$i] = (object)array(
                        'slug' => $seriesName
                    );
                }

                $i++;
            }

        } else if (empty($singleSeries)) {
            $seriesData = get_terms(array(
                'taxonomy'   => 'series',
                'hide_empty' => false
            ));

            foreach ($seriesData as $series) {
                $termMeta = get_option('taxonomy_' . $series->term_id);

                if (isset($termMeta['hide_from_feed']) && $termMeta['hide_from_feed'] == 'true') {
                    continue;
                }

                $series->ad_placement = isset($termMeta['ad_placement']) ? $termMeta['ad_placement'] : '';

                $allSeries[] = $series;
            }
        } else {
            $allSeries[] = (object)array(
                'slug' => $singleSeries,
            );
        }

        foreach ($allSeries as $series) {
            $posts              = null;
            $slug               = $series->slug;
            if(!empty($slug) && !in_array($slug, $noTaxonomy)) {
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'series',
                        'field'    => 'slug',
                        'terms'    => $series->slug,
                    ),
                );
            } elseif ($slug == 'misc') {
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'series',
                        'field'    => 'slug',
                        'operator' => 'NOT EXISTS',
                    ),
                );
            }

            if ($series->slug == 'fan-art') {
                $posts      = $this->get_fan_art_media();
                $cleanPosts = $this->posts_result($posts['posts']);
            } elseif ($series->slug == 'news') {
                $posts      = $this->get_news();
                $cleanPosts = $this->posts_result($posts['posts']);
            } elseif ($series->slug == 'cast') {
                $query['post_type'] = 'dt_cast';
                $query['include'] = 'date,url,thumbnail,title,content,comment_count,custom_fields,post_status';
                $json_api->response->include_values = array_merge($json_api->response->include_values, explode(',', $query['include']));
                unset($array['posts_per_page']);
                // fetch the posts
                $posts      = $json_api->introspector->get_posts($query); // query the results
                $cleanPosts = $this->posts_result($posts);      
            } else {
                // fetch the posts
                $posts      = $json_api->introspector->get_posts($query); // query the results
                $cleanPosts = $this->posts_result($posts);                // clean up the records
            }

            //die('<pre>' . print_r($cleanPosts, 1));
            $adPlacements = explode(',', $series->ad_placement);        // find the ad_placements
            $seriesShows  = array();                                    // a collection we will be using

            // loop through the posts and insert the ads
            $postIndex = 0;
            for ($i = 0; $i < count($cleanPosts['posts']); $i++) {
                $post = $cleanPosts['posts'][$postIndex];

                if (in_array(($i + 1), $adPlacements)) {
                    // insert the ad
                    $seriesShows[] = 'ad_placement';
                } else {
                    // insert the show
                    $seriesShows[] = $post;
                    $postIndex++;
                }

                // if we hit the limit, we stop the loop
                if (count($seriesShows) >= $limit) {
                    break;
                }
            }

            // overwrite the property
            $cleanPosts['posts'] = $seriesShows;

            $results[$series->slug] = $cleanPosts;
            //$results[$series->slug]['query'] = $query;

            //die($GLOBALS['wp_query']->request);
            wp_reset_query();
        }

        $this->setCache('dt-home-feeds-data.txt', $results);

        return $results;
    }

    private function getCache($file) {
        $currentTime     = time();
        $expireTimeHours = 0.5;
        $expireTime      = $expireTimeHours * 60 * 60;
        $fileTime        = filemtime($file);

        if (file_exists($file) && ($currentTime - $expireTime < $fileTime)) {
            $data           = unserialize(file_get_contents($file));
            $data['cached'] = true;

            return $data;
        }
    }

    public function get_fan_art_media() {
        $model          = new RTMediaModel();
        $numberOfMedias = 15;
        $maxIteration   = 100;
        $iteration      = 0;
        $activityFields = array(
            'primary_link',
            'display_name',
        );

        $return = array();

        while (true) {
            $mediaResults = $model->get(array(
                'media_type' => 'photo',
            ), ($iteration * $numberOfMedias), $numberOfMedias);

            foreach ($mediaResults as $media) {
                // make sure its a post to the group
                if (isset($media->context)) {
                    if ($media->context != 'group') {
                        continue;
                    }
                } else {
                    // context wasn't found, lets get out of here
                    continue;
                }

                // make sure we're on group 1 (fan art)
                if (isset($media->context_id)) {
                    if ((int)$media->context_id != 1) {
                        continue;
                    }
                } else {
                    // no context id was found, lets bail
                    continue;
                }

                $activityId  = $media->activity_id;
                $activity    = new BP_Activity_Activity($activityId);
                $commentData = $activity->get_activity_comments(array($activityId));
                $mediaUrl    = rtmedia_image("rt_media_thumbnail", $media->id, false);
                $media->url  = $mediaUrl;


                global $wpdb;
                $media->comments = $wpdb->get_var('SELECT COUNT(*) FROM ' . $wpdb->comments . ' WHERE comment_post_ID = "' . $media->media_id . '"');

                if (isset($commentData[$activityId])) {
                    $commentData = $commentData[$activityId];
                }

                if (isset($commentData->contents)) {
                    unset($commentData->contents);
                }

                $activityData = array();

                //$test = bp_activity_thumbnail_content_images($commentData->content);
                foreach ($activityFields as $field) {
                    if (isset($commentData->$field)) {
                        $activityData[$field] = $commentData->$field;
                    }
                }

                $return[] = array(
                    'media'    => $media,
                    'activity' => (object)$activityData,
                );

                // see if we reached our limit
                if (count($return) == $numberOfMedias) {
                    break; // break from the foreach loop
                }

                // see if we've hit max iterations
                if ($iteration >= $maxIteration) {
                    break; // break from the foreach loop
                }
            }

            // see if we reached our limit
            if (count($return) == $numberOfMedias) {
                break; // break from the while loop
            }

            // see if we've hit max iterations
            if ($iteration >= $maxIteration) {
                break; // break from the while loop
            }

            // bump our iteration count
            $iteration++;
        }

        return array('posts' => $return);
    }

    protected function posts_result($posts) {
        global $wp_query;

        // sanitize some inputs
        foreach ($posts as &$post) {
            $favorites = 0;
            $rating    = 0;

            $sample_start = get_post_meta($post->id, '_lac0509_dt-video-sample_start', true);
            $sample_end   = get_post_meta($post->id, '_lac0509_dt-video-sample_end', true);
            $vid_url      = get_post_meta($post->id, '_lac0509_dt-video-url', true);

            if (!$sample_start) {
                $sample_start = 0;
            }

            if (!$sample_end) {
                $sample_end = 0;
            }

            // make sure it ends after it starts ;)
            if ($sample_end < $sample_start) {
                $sample_end = $sample_start + 30;
            }

            $post->sample_start = $sample_start;
            $post->sample_end   = $sample_end;

            if($vid_url) {
                $post->sample_url = $vid_url;
            }

            if (isset($post->custom_fields)) {
                $customFields = $post->custom_fields;
                if (isset($customFields->dt_post_favorite_count)) {
                    $favorites = $customFields->dt_post_favorite_count[0];
                }

                if (isset($customFields->pd_rating)) {
                    $ratingsData = unserialize($post->custom_fields->pd_rating[0]);
                    $rating      = round($ratingsData['average'], 2);
                }
            }

            $post->favorites  = (int)$favorites;
            $post->rating     = (float)$rating;
            $post->popularity = (float)($favorites + $rating);

            unset($post->custom_fields);
        }

        return array(
            'count'       => count($posts),
            'count_total' => (int)$wp_query->found_posts,
            'pages'       => $wp_query->max_num_pages,
            'posts'       => $posts,
        );
    }

    public function get_news() {
        global $json_api;

        // get the uri
        $url   = parse_url($_SERVER['REQUEST_URI']);
        $limit = 15;

        // defaults
        $defaults = array(
            'ignore_sticky_posts' => true,
            'category_name'       => 'Uncategorized',
            'post_status'         => 'published',
            'include'             => 'date,url,thumbnail,title,comment_count,custom_fields',
            'posts_per_page'      => $limit,
            'orderby'             => 'date',
            'order'               => 'DESC',
        );

        // see if we want to override any defaults
        $query = wp_parse_args($url['query']);
        unset($query['json']);
        unset($query['post_status']);

        // do the actual overwriting
        $query = array_merge($defaults, $query);

        // a little hack :)
        if ($query['include']) {
            $json_api->response->include_values = array_merge($json_api->response->include_values, explode(',', $query['include']));
        }

        // fetch the posts
        $posts = $json_api->introspector->get_posts($query); // query the results
        $posts = $this->posts_result($posts);                // clean up the records

        wp_reset_query();

        return array('posts' => $posts['posts']);
    }

    private function setCache($file, $data) {
        file_put_contents($file, serialize($data));
    }

}