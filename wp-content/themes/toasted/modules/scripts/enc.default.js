// JavaScript Document

var DoubleToasted = DoubleToasted || {
    sel: {

    },
    slideshow: {},
    updateSlide: function(show,action,pageClicked){
        var currentPage = show.find('.pagination .active'),
            canMove = false;

        //handle slides if prev is clicked
        if(action === 'prev' && !currentPage.is(':first-child')){
            currentPage.removeClass('active').prev('li').addClass('active');
            canMove = true;
        //handle slides if next is clicked
        }else if(action === 'next' && !currentPage.is(':last-child')){
            currentPage.removeClass('active').next('li').addClass('active');
            canMove = true;
        }
        //handle slides if pagination is clicked
        else if(action === 'pagination'){
            currentPage.removeClass('active');
            pageClicked.addClass('active');
            canMove = true;
        }

        //update arrows visibility
        if(action === 'update'){
            show.find('.next.arrow,.prev.arrow').css('opacity',1);
        }
        if(action === 'update' && currentPage.is(':last-child')){
            show.find('.next.arrow').css('opacity',0);
        }
        if(action === 'update' && currentPage.is(':first-child')){
            show.find('.prev.arrow').css('opacity',0);
        }

        //update movement
        if(canMove){
            this.slideshow.width = this.slideshow.width || show.find('.episode').eq(0).outerWidth(true) || show.find('.other').eq(0).outerWidth(true);
            move = show.find('.pagination .active').index() * -(this.slideshow.width);
            show.find('.slider').css({transform: 'translate('+move+'px)'});
            this.updateSlide(show,'update');
        }
    },
    setupSlideShow: function(){
        var episodes,
        $this = this;
        //loop through shows and add pagination
        jQuery('.show').each(function(){
            episodes = jQuery(this).find('.episode');
            $this.createPagination(episodes,jQuery(this));
        });
        if(episodes){
            this.slideshow.width = episodes.outerWidth(true);
        }
    },
    createPagination: function(episodes,show){
        jQuery.each(episodes,function(){
            show.find('.pagination').append('<li></li>')
        })
        show.find('.pagination li:first-child').addClass('active');
    },
    //create rating based on review
    createRating: function(rate){
        var x = 0,
        fullCups = parseFloat(rate.text().split('.')[0]),
        partialCups = parseFloat(rate.text().split('.')[1]),
        review = "";

        for(x;x<fullCups;x++){
            review += "<div class='review full'></div>"
        }
        if(partialCups) review = review + '<div class="review partial"><div class="fill"><div style="height:'+partialCups+'%" class="beer"></div></div></div>'
        rate.parent('.stats').siblings('.play').html(review);
    },
    insertListener: function(){
        if(event.animationName === "episodeLoaded" && !jQuery(event.target).parent('.slider').hasClass('slider-active')){
            var slider = jQuery(event.target).parent('.slider');
            slider.addClass('slider-active');
            if(slider.parent('.show').hasClass("show-movie-review-extravaganza")){
                DoubleToasted.createRating(jQuery(event.target).find('.rating'))
            }

            slider.attr('slider','slide'+slider.parent('.show').index())
            Swipe(slider[0], {
                speed: 400,
                continuous: false,
                stopPropagation: true,
                pagination: slider.siblings('.pagination')[0],
                nextArrow: slider.siblings('.next.arrow'),
                prevArrow: slider.siblings('.prev.arrow'),
                responsiveLayout: "",
                closure: ""
            });
        }
    },
    moveSlide: function(){
        var windowSize = jQuery(window).innerWidth(),
        nextSlide = (jQuery('#dt-home-slider > .active').next().length) ? jQuery('#dt-home-slider > .active').next() : jQuery('#dt-home-slider > div').eq(0);
        if(DoubleToasted.device() !== 'mobile'){
            nextSlide.addClass('active').stop(true,true).animate({width: ((windowSize * .6) - 1)},300);
            nextSlide.siblings().removeClass('active').stop(true,true).animate({width: ((windowSize * .1) - 1)},300);
        }else{
            var pages = jQuery('.relative .pagination li');
            activePage = jQuery('.relative .pagination li.active');
            if(activePage.next().length){
                activePage.next().click();
            }else{
                pages.eq(0).click();
            }
        }
    },
    setupGallery: function(){
            var $this = this,
            windowSize = jQuery(window).innerWidth(),
            numofslides = jQuery('#dt-home-slider > div').length;
        if(this.device() !== 'mobile'){
            jQuery('#dt-home-slider > div').css({width:(windowSize / numofslides) - 1}).addClass('other');
            jQuery('#dt-home-slider > div').eq(numofslides - 1).addClass('active')
        }
        else{
            jQuery('#dt-home-slider > div').addClass('other');
            jQuery('#dt-home-slider > div').eq(0).addClass('active');
        }
        $this.moveSlide();
        mainSlideshow = setInterval($this.moveSlide, 8000);
    },
    listeners: function(){
        var $this = this,
        windowSize = jQuery(window).innerWidth(),
        numofslides = jQuery('#dt-home-slider > div').length;

        //mouse out of sliders
        jQuery('#dt-home-slider').on('mouseleave',function(e){
           mainSlideshow = setInterval($this.moveSlide, 3000);
        });
        //stop slideshow
        jQuery('#dt-home-slider').bind('touchstart', function(){
           clearInterval(mainSlideshow);
        });
        //mouse over div
        jQuery('#dt-home-slider > div').on('mouseenter',function(e){
            clearInterval(mainSlideshow);
            if(DoubleToasted.device() !== 'mobile'){
                jQuery(e.currentTarget).stop(true,true).animate({width: ((windowSize * .6) - 1)},300).addClass('active');
                jQuery(e.currentTarget).siblings().removeClass('active').stop(true,true).animate({width: ((windowSize * .1) - 1)},300);
            }
        });
        //audio button
        jQuery('.audio').on('click',function(e){
            var audio = jQuery('#dt-audio-choice');
            if(audio.length){
                audio.show();
                jQuery('#dt-video-option').hide();
            }
        });
        //audio button
        jQuery('.video').on('click',function(e){
            var tv = jQuery('#dt-video-option');
            if(tv.length){
                tv.show();
                jQuery('#dt-audio-choice').hide();
            }
        });
        //your rating
        jQuery('.your-rating').on('click',function(e){
            jQuery('.review-overlay,.write-a-review').css('visibility','visible');
        });

        //when clicking on the body, close all of the following..
        jQuery('.write-a-review .close,.write-a-review .cencel').on('click',function(e){
            jQuery('.review-overlay,.write-a-review').css('visibility','hidden');
        });
        //social media links
        jQuery('.video-link li').on('click',function(e){
            if(!jQuery(this).hasClass('comments')){
                jQuery(this).addClass('active').siblings().removeClass('active');
            }else{
                jQuery('#dt-side-comments')[0].scrollIntoView(true);
            }
        });
        jQuery('.dt-icon-export a.comments').on('click',function(e){
            console.log('hi');
            if(!jQuery(this).hasClass('comments')){
                jQuery(this).addClass('active').siblings().removeClass('active');
            }else{
                jQuery('#dt-side-comments')[0].scrollIntoView(true);
            }
        });
        //next button
        jQuery('.next.arrow').on('click',function(e){
            var show = jQuery(this).parent();
            $this.updateSlide(show,'next');
        })
        //pagination
        jQuery('body').on('click touchend','.pagination li',function(e){
            var show = jQuery(this).parent().parent() || jQuery(this).parent();
            $this.updateSlide(show,'pagination',jQuery(this));
        })

        //pagination
        jQuery('body').on('click','.mute',function(e){
            jQuery(this).toggleClass('active');
            var video = jQuery(this).parent().siblings('.sample-video').find('video')[0];
            video.muted = !jQuery(this).hasClass('active');
            e.stopPropagation();
            e.preventDefault();
            return false;
        })

        jQuery('body').on('click','.active-members,.active-groups',function(e){
            jQuery(this).toggleClass('active');
        })
        //prev button
        jQuery('.prev.arrow').on('click touchstart',function(e){
            var show = jQuery(this).parent();
            $this.updateSlide(show,'prev');
        })
        //drop down menu
        jQuery('.drop').on('click',function(e){
            jQuery(this).siblings('.dropdown').toggleClass('active');
            e.stopPropagation();
        })

        //when clicking on the body, close all of the following..
        jQuery(window).on('orientationchange',function(e){
            jQuery('.slider').each(function(){
                var index = jQuery(this).siblings('.pagination').find('.active').index();
                var slideOver = jQuery(window).innerWidth() * index;
                jQuery(this).css('-webkit-transform','translate(-'+slideOver+'px, 0px) translateZ(0px)');
            });
        });
        //when clicking on the body, close all of the following..
        jQuery('body').on('click',function(e){
            jQuery('.dropdown').removeClass('active');
        });
        //play video on mouse over
        jQuery('body').on('mouseenter','.episode',function(e){
            if(jQuery(this).find('video').length){
                jQuery(this).find('.mute').show();
                jQuery(this).find('video').get(0).play();
            }
        });
        //pause video on mouse out
        jQuery('body').on('mouseleave','.episode',function(e){
            if(jQuery(this).find('video').length){
                jQuery(this).find('.mute').hide();
                jQuery(this).find('video').get(0).pause();
            }
        });
        document.addEventListener("animationstart", $this.insertListener, false); // standard + firefox
        document.addEventListener("MSAnimationStart", $this.insertListener, false); // IE
        document.addEventListener("webkitAnimationStart", $this.insertListener, false); // Chrome + Safari
    },
    device: function(){
        var windowSize = jQuery(window).width(),
            deviceType = 'mobile';

            if(windowSize >= 450) deviceType = 'tablet';
            if(windowSize >= 960) deviceType = 'desktop';

            return deviceType;
    },
    popUps: function(){
        var popupDate = localStorage.getItem('pop-up'),
        now = new Date().getTime(),
        thirtyDaysInMilliseconds = 2592000000;

        if (popupDate === null || now - popupDate > thirtyDaysInMilliseconds) {
            localStorage.setItem("pop-up", now);
            jQuery(window).load(function() {
                tb_show("", "#TB_inline?width=800&height=500&inlineId=dt-login");
            });
        }
    },
    initSwipe: function(){
        var slideshow = jQuery("#dt-home-slider");
        Swipe(slideshow, {
            speed: 400,
            continuous: true,
            stopPropagation: true,
            responsiveLayout: "",
            closure: "",
            pagination: slideshow.siblings('.pagination')[0]
        })
    },
    init: function(){
        this.listeners();
        this.setupSlideShow();
        this.setupGallery();
        this.popUps();
        this.initSwipe();
    }

}

DoubleToasted.init();