(function (window, document, undefined, $) {
    function HomeFeeds() {
        var data = {
            action: 'is_user_logged_in'
        };

        var isLoggedIn = false;
        jQuery.post('/wp-admin/admin-ajax.php', data, function(response) {
            if(response == 'yes') {
                isLoggedIn = true;
            }
        });
        
        var loadedVideos = 0;
        var videoSampleTimes = {};

        var init = function () {
            getShows();

            /**
             * Hook for sorting the categories
             */
            $('.categories .dropdown ul li').click(function () {
                var $element = $(this).closest('div[class*="show-"]');

                getShow($element, $(this).data('order'));
            });
        };

        /**
         * Retrieves the show data from WordPress via JSON
         *
         * @param $element
         * @param slug
         * @param sort
         */
        var getShowData = function ($element, slug, sort) {
            sort     = sort || null;
            var data = {
                series_name: slug
            };

            if (sort) {
                if (sort == 'AtoZ') {
                    data['order_by'] = 'title';
                    data['order']    = 'ASC';
                } else if (sort == 'ZtoT') {
                    data['order_by'] = 'title';
                    data['order']    = 'DESC';
                } else if (sort == 'recent') {
                    data['order_by'] = 'date';
                    data['order']    = 'DESC';
                } else if (sort == 'popular') {
                    //data['order_by'] =
                }
            }

            $.ajax({
                       url: '/api/dtshows/get_all_shows/',
                       data: data,
                       success: function (data) {
                           // see if there is a loading class
                           $element.find('.loading').remove();

                           // on success, we want to add the post
                           $.each(data, function (slugName, showData) {
                               if (slugName == 'status' || slugName == 'cached') {
                                   return;
                               }

                               if (slugName != slug) {
                                   return;
                               }

                               $.each(showData.posts, function (key, post) {
                                   if (slugName == 'fan-art') {
                                       addFanArt($element, key, post);
                                   } else {
                                       addShow($element, key, post, slugName);
                                   }
                               });

                               //if (slugName != 'fan-art') {
                               addArchived($element, slugName);
                               renderSampleVideos();
                               //}
                           });
                       }
                   });
        };

        var renderSampleVideos = function() {
            /*card = card + '<script>' +
                'var $pop = Popcorn("#sample-video-' + loadedVideos + '");' +
                '$pop.currentTime(1).capture();' +
                /!*'$pop.capture({ at: 10 });' +*!/
            '</script>';*/

            $('.sample-video').each(function(index, element) {
                var $element = $(this);
                var $video = $element.find('video');

                if ($video !== null || $video !== undefined) {
                    if ($video.attr('preload') !== 'none') {
                        var videoID = $video.attr('id');
                        var $pop = Popcorn('#' + videoID);
                        var sampleStart = videoSampleTimes[videoID]["start"];
                        var sampleEnd = videoSampleTimes[videoID]["end"];

                        $pop.cue( sampleEnd, function() {
                            this.currentTime(sampleStart);
                            this.pause();
                            if(!isLoggedIn) {
                                tb_show(null,"#TB_inline?width=800&height=500&inlineId=dt-login", false);
                            }
                        });

                        $pop.currentTime(sampleStart);
                    }
                }
            });
        };

        /**
         * Gets all the shows and applies them to the page
         */
        var getShows = function () {

            // see if any of the classes match "show-"
            $('.show').each(function(index) {
                var seriesList = "";
                var $element = $(this);
                var classes   = $element.attr('class');
                var classList = [];

                if (classes !== undefined) {
                    classList = classes.split(' ');
                }

                $.each(classList, function (index, item) {
                    if (/^show-/.test(item)) {
                        if(seriesList != "") {
                            seriesList += ",";
                        }
                        var slug = item.replace('show-', '');
                        seriesList += slug;
                    }
                });

                $.ajax({
                       url: '/api/dtshows/get_all_shows/',
                       cache: false,
                       data: {series_list: seriesList},
                       success: function (data) {
                           // on success, we want to add the post
                           $.each(data, function (slug, showData) {
                               if (slug == 'status' || slug == 'cached') {
                                   return;
                               }

                               var $element = $('.show-' + slug);

                               // see if there is a loading class
                               $element.find('.loading').remove();

                               $.each(showData.posts, function (key2, post) {
                                   //addShow($element, key2, post);

                                    if (slug == 'fan-art') {
                                        addFanArt($element, key2, post);
                                    } else if(slug == 'cast') {
                                        addCast($element, key2, post);
                                    } else {
                                        addShow($element, key2, post, slug);
                                    }
                               });

                                var $notShows = ['fan-art', 'cast', 'misc'];
                               if ($notShows.indexOf(slug) == -1) {
                                   addArchived($element, slug);
                                   renderSampleVideos();
                               }
                           });
                       }
                   });
            });
        };

        /**
         * Adds the show card to the slider
         *
         * @param $element
         * @param index
         * @param data
         */
        var addShow = function ($element, index, data, slug) {
            // get some of the elements that we will be modifying
            var $slider    = $element.find('.slider');
            var $paginator = $element.find('.pagination');
            var card       = '';

            // build the card
            if (data == 'ad_placement') {
                card = drawAd();
            } else {
                if (data.thumbnail_images == undefined || data.thumbnail_images.length == 0) {
                    return;
                }

                var maxVideos = 30;
                var isEmulateVideo = data.sample_url && (data.sample_end > 0);

                var preload = 'none';
                var videoID = ''
                var sampleStart = data.sample_start;
                var sampleEnd = data.sample_end;

                if (loadedVideos <= 5) {
                    preload = 'metadata';
                }

                if (isEmulateVideo) {
                    loadedVideos++;

                    videoID = 'sample-video-' + loadedVideos;

                    videoSampleTimes[videoID] = {start: sampleStart, end: sampleEnd};
                }

                card = '<li class="episode '+(isEmulateVideo ? "sample" : "")+'" style="background-image: url(' + data.thumbnail_images.large.url + ')">' +
                    '   <a href="' + data.url + '" style="display: block; text-decoration: none;">' +

                    (isEmulateVideo ? '<div class="sample-video">' +
                    '<video loop muted preload="' + preload + '" id="' + videoID + '" ontimeupdate="window.HomeFeeds.timeUpdate(this)">' +
                    '   <source src="http://doubletoasted.com/wp-content/uploads/ppv-video/' + data.sample_url + '"' +
                    '       type="video/mp4"/>' +
                    '</video>' +
                    '</div>' : '') +

                    '       <span class="episode-title">' + data.title + '</span>' +
                    '       <div class="actions">' +
                    '           <span class="mute"></span>' +
                    '           <span class="play"></span>' +
                    '       </div>' +
                    '       <div class="stats">' +
                    '           <span class="likes">' + data.favorites + ' <br>Likes</span>' +
                    '           <span class="comments">' + data.comment_count + ' <br>Comments</span>' +
                    '           <span class="rating">' + data.rating + ' <br>Rating</span>' +
                    '       </div>' +
                    '   </a>' +
                    '</li>';
            }

            // add the card
            $slider.append(card);

            // build the paginator html
            var paginatorAppend = '<li></li>';

            // change the paginator html if its the first element
            if (index == 0) {
                paginatorAppend = '<li class="active"></li>'
            }

            // add to the paginator section
            $paginator.append(paginatorAppend);
        };

        /**
         * Adds the show card to the slider
         *
         * @param $element
         * @param index
         * @param data
         */
        var addCast = function ($element, index, data, slug) {
            // get some of the elements that we will be modifying
            var $slider    = $element.find('.slider');
            var $paginator = $element.find('.pagination');
            var card       = '';

            // build the card
            if (data.thumbnail_images == undefined) {
                return;
            }

            console.log(data.thumbnail_images.full.url);
            card = '<li class="episode " style="background-image: url(' + data.thumbnail_images.full.url + ')">' +
                    '<div class="about-host">' + 
                        '<h3>' + data.title + '</h3>' +

                        data.content +
                    '</div>' +
                '</li>';

            // add the card
            $slider.append(card);

            // build the paginator html
            var paginatorAppend = '<li></li>';

            // change the paginator html if its the first element
            if (index == 0) {
                paginatorAppend = '<li class="active"></li>'
            }

            // add to the paginator section
            $paginator.append(paginatorAppend);
        };

        var drawAd = function () {
            return '<li class="episode ad"><a href="http://elonandcompany.com" target="_blank"></a></li>';
            /* return '<li class="episode ad">' +
                    '<ins class="adsbygoogle" ' +
                     'style="display:inline-block;width:300px;height:250px" ' +
                     'data-ad-client="ca-pub-4758578222251672" ' +
                     'data-ad-slot="7211124749"></ins>' +
                     '<script>' +
                     '(adsbygoogle = window.adsbygoogle || []).push({}); ' +
                     '</script>' +
                    /!*'<script type="text/javascript">' +
                    'google_ad_client = "ca-pub-4758578222251672";' +
                    'google_ad_slot = "7211124749";' +
                    'google_ad_width = 300;' +
                    'google_ad_height = 250;' +
                    'console.log("google ad client: " + google_ad_client);' +
                    '</script>' +
                    '<script type="text/javascript" src="//pagead2.googlesyndication.com/pagead/show_ads.js"></script>' +*!/
                    '<li>';*/
        };

        var addFanArt = function ($element, index, data) {
            // get some of the elements that we will be modifying
            var $slider    = $element.find('.slider');
            var $paginator = $element.find('.pagination');
            var card       = '';

            // build the card
            if (data == 'ad_placement') {
                card = drawAd();
            } else {
                card = '<li class="episode" style="background: url(' + data.media.url + ') center center; background-size: cover;">' +
                    '   <span class="artist-name">Posted by: <a href="' + data.activity.primary_link + '">' + data.activity.display_name + '</a></span>' +
                    '   <a href="https://doubletoasted.com/groups/fan-art/" style="display: block; text-decoration: none;">' +
                    '       <div class="stats">' +
                    '           <span class="likes">' + data.media.likes + ' <br>Likes</span>' +
                    '           <span class="comments">' + data.media.comments + ' <br>Comments</span>' +
                    '           <span class="rating">' + data.media.ratings_average + ' <br>Rating</span>' +
                    '       </div>' +
                    '   </a>' +
                    '</li>';
            }

            // add the card
            $slider.append(card);

            // build the paginator html
            var paginatorAppend = '<li></li>';

            // change the paginator html if its the first element
            if (index == 0) {
                paginatorAppend = '<li class="active"></li>'
            }

            // add to the paginator section
            $paginator.append(paginatorAppend);
        };

        /**
         * Adds the last card to the end
         *
         * @param slug
         * @param $element
         */
        var addArchived = function ($element, slug) {
            // get some of the elements that we will be modifying
            var $slider    = $element.find('.slider');
            var $paginator = $element.find('.pagination');

            var url  = '/shows/' + slug + '/';
            var text = 'Archived Episodes';

            if (slug == 'reviews') {
                url  = '/audio/';
                text = 'Archived Audio';
            }
            else if (slug == 'fan-art') {
                url  = '/groups/fan-art/';
                text = 'Archived Fan Art';
            } else if (slug == 'news') {
                url  = '/news/';
                text = 'Archived News';
            }

            // build the card
            var card = '<li class="episode">' +
                '   <a href="' + url + '" style="display: block; text-decoration: none;">' +
                '       <span class="episode-title">' + text + '</span>' +
                '   </a>' +
                '</li>';

            // add the card
            $slider.append(card);

            // build the paginator html
            var paginatorAppend = '<li></li>';

            // add to the paginator section
            $paginator.append(paginatorAppend);
        };

        /**
         * Gets the show name, resets elements, and fetches shows
         *
         * @param $element
         * @param sort
         */
        var getShow = function ($element, sort) {
            // find the classes
            var classes   = $element.attr('class');
            var classList = [];

            if (classes !== undefined) {
                classList = classes.split(' ');
            }

            var slug = null;
            sort     = sort || null;

            // see if any of the classes match "show-"
            $.each(classList, function (index, item) {
                if (/^show-/.test(item)) {
                    slug = item.replace('show-', '');
                }
            });

            // reset the slider and the style
            $element.find('.slider')
                    .html('<li class="loading">Loading...</li>')
                    .css('left', '0');

            // reset the pagination
            $element.find('.pagination').html('');

            // reset the previous arrow
            $element.find('.prev.arrow').css('opacity', 0);

            // do the magic
            if (slug) {
                getShowData($element, slug, sort);
            }
        };

        this.timeUpdate = function(element) {
            if (element.currentTime > 7) {
                // console.log(yo);
            }
        };

        init();
    }

    $(document).ready(function () {
        window.HomeFeeds = new HomeFeeds();
    });
})(window, document, undefined, jQuery);