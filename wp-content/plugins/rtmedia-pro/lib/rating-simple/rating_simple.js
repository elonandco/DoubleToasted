(
        function($) {
            $.fn.webwidget_rating_simple = function(p) {
                var p = p || {};
                var b = p && p.rating_star_length ? p.rating_star_length : "5";
                var c = p && p.rating_function_name ? p.rating_function_name : "";
                var e = p && p.rating_initial_value ? p.rating_initial_value : "";
                var d = p && p.directory ? p.directory : "images";
                var f = "";
                var g = $(this);
                b = parseInt(b);
                init();
                g.next("ul").children("li").hover(function() {
                    $(this).parent().children("li").css('background-image', 'url(' + d + '/nst.gif)');
                    var a = $(this).parent().children("li").index($(this));
                    $(this).parent().children("li").slice(0, a + 1).css('background-image', 'url(' + d + '/sth.gif)')
                }, function() {
                });
                g.next("ul").children("li").click(function() {
                    var a = $(this).parent().children("li").index($(this));
                    f = a + 1;
                    g.val(f);
                    if (c != "") {
                        eval(c + "(" + g.val() + ")")
                    }
                });
                g.next("ul").hover(function() {
                }, function() {
                    if (f == "") {
                        $(this).children("li").css('background-image', 'url(' + d + '/nst.gif)')
                    } else {
                        $(this).children("li").css('background-image', 'url(' + d + '/nst.gif)');
                        $(this).children("li").slice(0, f).css('background-image', 'url(' + d + '/sth.gif)')
                    }
                });
                function init() {
                    $('<div style="clear:both;"></div>').insertAfter(g);
                    g.css("float", "left");
                    var a = $("<ul>");
                    a.attr("class", "webwidget_rating_simple");
                    for (var i = 1; i <= b; i++) {
                        a.append('<li style="background-image:url(' + d + '/nst.gif)"><span>' + i + '</span></li>')
                    }
                    a.insertAfter(g);
                    if (e != "") {
                        f = e;
                        g.val(e);
                        g.next("ul").children("li").slice(0, f).css('background-image', 'url(' + d + '/sth.gif)')
                    }
                }}
        }
)(jQuery);