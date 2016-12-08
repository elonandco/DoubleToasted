(function (window, document, undefined, $) {
    function Community() {
        var loadedVideos = 0;

        var init = function () {
            getFanArt();

            /**
             * Hook for sorting the categories
             */
            $('.categories .dropdown ul li').click(function () {
                var $element = $(this).closest('div[class*="show-"]');

                getShow($element, $(this).data('order'));
            });
        };

        /**
         * Gets all the shows and applies them to the page
         */
        var getFanArt = function () {
            var seriesList = "";

            // see if any of the classes match "show-"
            $('.list').each(function(index) {
                var $element = $(this);
                var classes   = $element.attr('class');
                var classList = [];

                if (classes !== undefined) {
                    classList = classes.split(' ');
                }

                $.each(classList, function (index, item) {
                    if (/^list-/.test(item)) {
                        if(seriesList != "") {
                            seriesList += ",";
                        }
                        var slug = item.replace('list-', '');
                        seriesList += slug;
                    }
                });
            });

            $.ajax({
                       url: '/api/dtshows/get_all_shows/',
                       cache: false,
                       data: {series_list: seriesList},
                       success: function (data) {
                           // on success, we want to add the post
                           $.each(data, function (slug, showData) {
                                console.log('data');
                               if (slug == 'status' || slug == 'cached') {
                                   return;
                               }

                               var $element = $('.show-' + slug);

                               // see if there is a loading class
                               $element.find('.loading').remove();

                               $.each(showData.posts, function (key2, post) {
                                    if(slug == 'fan-art') {
                                       addFanArt($element, key2, post);
                                   }
                               });
                           });
                       }
                   });
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

        this.timeUpdate = function(element) {
            if (element.currentTime >= 7) {
                //alert('yo');
            }
        };

        init();
    }

    $(document).ready(function () {
        window.Community = new Community();
    });
})(window, document, undefined, jQuery);