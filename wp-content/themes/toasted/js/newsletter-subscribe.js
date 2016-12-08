(function (window, document, undefined, $) {
    function NewsletterSubscribe() {
        var init = function () {
            // bind to the submit form
            $('#newsletter-subscribe').submit(function (event) {
                // get the subscriber input text
                var $subscriber = $(this).find('input[name="subscriber"]');

                $.ajax({
                           type: 'POST',
                           url: '/api/ccemail/register_list/',
                           data: {
                               email: $subscriber.val(),
                               check_exists: true
                           },
                           cache: false,
                           success: function (result) {
                               $('.newsletter-subscribe-response')
                                   .html(result.result);

                               if (result.clearField) {
                                   $subscriber.val('');
                               }
                           }
                       });

                event.preventDefault();
            });
        };

        init();
    }

    $(document).ready(function () {
        window.NewsletterSubscribe = new NewsletterSubscribe();
    });
})(window, document, undefined, jQuery);