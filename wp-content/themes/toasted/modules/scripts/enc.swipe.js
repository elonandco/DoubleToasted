/*
 * Swipe 2.0
 *
 * Brad Birdsall
 * Copyright 2013, MIT License
 *
*/

function Swipe(container, options) {
  "use strict";

  // utilities
  var noop = function() {}; // simple no operation function
  var offloadFn = function(fn) { setTimeout(fn || noop, 0) }; // offload a functions execution

  // check browser capabilities
  var browser = {
    addEventListener: !!window.addEventListener,
    touch: ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch,
    transitions: (function(temp) {
      var props = ['transitionProperty', 'WebkitTransition', 'MozTransition', 'OTransition', 'msTransition'];
      for ( var i in props ) if (temp.style[ props[i] ] !== undefined) return true;
      return false;
    })(document.createElement('swipe'))
  };

  var direction = -1;

  // quit if no root element
  if (!container) return;
  var element = jQuery(container)[0];
  var slides, slidePos, width, length;
  options = options || {};
  var index = 0;
  var slidesInLayout = options.responsiveLayout || 1;
  var speed = options.speed || 300;
  options.continuous = options.continuous !== undefined ? options.continuous : false;
  var isAndroid = (/android/gi).test(navigator.appVersion),
      isIDevice = (/iphone|ipad/gi).test(navigator.appVersion),
      isTouchPad = (/hp-tablet/gi).test(navigator.appVersion),
      hasTouch = 'ontouchstart' in window && !isTouchPad;


  function setup() {
    // cache slides

    slides = element.children;
    length = slides.length;

    updateArrows(index);
    updatePagination(index);

    // determine width of each slide
    width = jQuery(slides[0]).outerWidth(true);

    if (browser.transitions) {
        move(0, 0, speed); // index, dist, speed
    }


    if (!browser.transitions) element.style.left = 0 + 'px';

  }

  function onOrientationChange(event){
    index = (hasTouch) ? index : 0;
  }


  function prev() {
    if(index) slide(index-1);

  }

  function next() {
    if (index < (length - slidesInLayout)) slide(index+1);

  }

  function circle(index) {
    // a simple positive modulo using slides.length
    return (slides.length + (index % slides.length)) % slides.length;
  }

  function slide(to, slideSpeed) { // still look into
    // do nothing if already on requested slide
    if (index == to) return;
    width = jQuery(slides[0]).outerWidth(true);

    if (browser.transitions) {

      updateArrows(to);
      updatePagination(to);

      direction = Math.abs(index-to) / (index-to); // 1: backward, -1: forward
      move(index, -width * to, slideSpeed || speed); // 0


    } else {

      to = circle(to);
      animate(index * -width, to * -width, speed);
      //no fallback for a circular continuous if the browser does not accept transitions
    }

    index = to;
    offloadFn(options.callback && options.callback(index, slides[index]));
  }

  function move(index, dist, speed) {
    translate(index, dist, speed);
    slidePos = dist;

  }

  function updateArrows(index){
      if(options.nextArrow && options.prevArrow){
        if(!index) {
            options.prevArrow.css('opacity',0)
        }
        else {
            options.prevArrow.css('opacity',1)
        }

        if(index === slides.length-1){
            options.nextArrow.css('opacity',0)
        }else {
            options.nextArrow.css('opacity',1)
        }
      }
  }

  function updatePagination(currentIndex){
      if(options.pagination){
        jQuery(options.pagination).children().removeClass('active').eq(currentIndex).addClass('active');
        index = currentIndex;
      }
  }

  function translate(index, dist, speed) {
    var style = element && element.style,
        numofSlides = length;

    if (!style) return;


    style.webkitTransitionDuration =
    style.MozTransitionDuration =
    style.msTransitionDuration =
    style.OTransitionDuration =
    style.transitionDuration = speed + 'ms';
    style.webkitTransform = 'translate(' + dist + 'px,0) translateZ(0)';
    style.msTransform =
    style.MozTransform =
    style.OTransform = 'translateX(' + dist + 'px)';

  }

  function animate(from, to, speed) { // still look into
    // if not an animation, just reposition
    if (!speed) {
      element.style.left = to + 'px';
      return;
    }

    var start = +new Date;

    var timer = setInterval(function() {

      var timeElap = +new Date - start;

      if (timeElap > speed) {

        element.style.left = to + 'px';

        if (delay) begin();

        options.transitionEnd && options.transitionEnd.call(event, index, slides[index]);

        clearInterval(timer);
        return;

      }

      element.style.left = (( (to - from) * (Math.floor((timeElap / speed) * 100) / 100) ) + from) + 'px';

    }, 4);

  }

  // setup auto slideshow
  var delay = options.auto || 0;
  var interval;

  function begin() {
    interval = setTimeout(next, delay);

  }

  function stop() {
    delay = 0;
    clearTimeout(interval);

  }


  // setup initial vars
  var start = {};
  var delta = {};
  var isScrolling;

  // setup event capturing
  var events = {

    handleEvent: function(event) {

      switch (event.type) {
        case 'touchstart': this.start(event); break;
        case 'touchmove': this.move(event); break;
        case 'touchend': offloadFn(this.end(event)); break;
        case 'webkitTransitionEnd': //offloadFn(this.clearMemory(event)); break
        case 'msTransitionEnd':
        case 'oTransitionEnd':
        case 'otransitionend':
        case 'transitionend': offloadFn(this.transitionEnd(event)); break;
        case 'resize': onOrientationChange(event); break;
      }

      if (options.stopPropagation) event.stopPropagation();

    },

    start: function(event) {
      var touches = event.touches[0];

      // measure start values
      start = {

        // get initial touch coords
        x: touches.pageX,
        y: touches.pageY,

        // store time to determine touch duration
        time: +new Date

      };

      // used for testing first move event
      isScrolling = undefined;

      // reset delta and end measurements
      delta = {};

      // attach touchmove and touchend listeners
      element.addEventListener('touchmove', this, false);
      element.addEventListener('touchend', this, false);

    },
    move: function(event) {

      // ensure swiping with one touch and not pinching
      if ( event.touches.length > 1 || event.scale && event.scale !== 1) return

      if (options.disableScroll) event.preventDefault(); // get rid of this

      var touches = event.touches[0];
      width = jQuery(slides[0]).outerWidth(true);

      // measure change in x and y
      delta = {
        x: touches.pageX - start.x,
        y: touches.pageY - start.y
      }


      // determine if scrolling test has run - one time test
      if ( typeof isScrolling == 'undefined') {
        isScrolling = !!( isScrolling || Math.abs(delta.x) < Math.abs(delta.y) );
      }

      // if user is not trying to scroll vertically
      if (!isScrolling) {

        // prevent native scrolling
        event.preventDefault();

        direction = (delta.x > 0) ? 1 : -1;

        delta.x =
            delta.x /
            ( (!index && delta.x > 0 // if first slide and sliding left
            || index >= (slides.length - options.responsiveLayout) && delta.x  // or if last slide and sliding right
            && delta.x < 0 // and if sliding at all
            ) ?
            ( Math.abs(delta.x) / width + 1 ) // determine resistance level
            : 1 );    // no resistance if false

          translate(index, delta.x + (-width * index), speed);
      }

    },
    end: function(event) {

      // measure duration
      var duration = +new Date - start.time;
          width = jQuery(slides[0]).outerWidth(true);

      // determine if slide attempt triggers next/prev slide
      var isValidSlide =
            Number(duration) < 250               // if slide duration is less than 250ms
            && Math.abs(delta.x) > 20            // and if slide amt is greater than 20px
            || Math.abs(delta.x) > width/2;      // or if slide amt is greater than half the width

      // determine if slide attempt is past start and end
      var isPastBounds =
            (!index && delta.x > 0) // if first slide and slide amt is greater than 0
            || (index >= (length - slidesInLayout) && delta.x < 0);    // or if last slide and slide amt is less than 0

      // determine direction of swipe (true:right, false:left)
      var direction = delta.x < 0,
          dir = (delta.x > 0) ? 1 : -1;

      // if not scrolling vertically
      if (!isScrolling) {

        if (isValidSlide && !isPastBounds) {
           var to = (direction) ? index + 1 : index - 1;

           move(index, -width * to, speed);
           index = to;
        } else if(isValidSlide && isPastBounds){ // if it doens't have direction, don't do anything
            move(index, (index * -width), speed);

        }

        options.callback && options.callback(index, slides[index]);

        }
      updateArrows(index);
      updatePagination(index);
      // kill touchmove and touchend event listeners until touchstart called again
    },
    transitionEnd: function(event) {
      if (parseInt(event.target.getAttribute('data-index'), 10) == index) {

        if (delay) begin();

        options.transitionEnd && options.transitionEnd.call(event, index, slides[index]);

      }

    }

  }

  // trigger setup
  setup();

  // start auto slideshow if applicable
  if (delay) begin();


  // add event listeners
  if (browser.addEventListener) {

    // set touchstart event on element
    if (browser.touch) element.addEventListener('touchstart', events, false);

    if (browser.transitions) {
      element.addEventListener('webkitTransitionEnd', events, false);
      element.addEventListener('msTransitionEnd', events, false);
      element.addEventListener('oTransitionEnd', events, false);
      element.addEventListener('otransitionend', events, false);
      element.addEventListener('transitionend', events, false);
    }

    // set resize event on window
  window.addEventListener('resize', events, false);

  } else {

  window.onresize = function () { updateArrows(0); updatePagination(0) }; // to play nice with old IE

  }

  // expose the Swipe API
  return {
    setup: function() {

      setup();

    },
    slide: function(to, speed) {

      // cancel slideshow
      stop();

      slide(to, speed);

    },
    prev: function() {

      // cancel slideshow
      stop();

      prev();

    },
    next: function() {

      // cancel slideshow
      stop();

      next();

    },
    getPos: function() {

      // return current index position
      return index;

    },
    getNumSlides: function() {

      // return total number of slides
      return length;
    },
    kill: function() {

      // cancel slideshow
      stop();

      // reset element
      element.style.width = 'auto';
      element.style.left = 0;

      // reset slides
      var pos = slides.length;
      while(pos--) {

        var slide = slides[pos];
        slide.style.width = '100%';
        slide.style.left = 0;

        if (browser.transitions) translate(pos, 0, 0);

      }

      // removed event listeners
      if (browser.addEventListener) {

        // remove current event listeners
        element.removeEventListener('touchstart', events, false);
        element.removeEventListener('webkitTransitionEnd', events, false);
        element.removeEventListener('msTransitionEnd', events, false);
        element.removeEventListener('oTransitionEnd', events, false);
        element.removeEventListener('otransitionend', events, false);
        element.removeEventListener('transitionend', events, false);
        window.removeEventListener('resize', events, false);

      }
      else {

        window.onresize = null;

      }

    }
  }

}


if ( window.jQuery || window.Zepto ) {
  (function($) {
    $.fn.Swipe = function(params) {
      return this.each(function() {
        $(this).data('Swipe', new Swipe($(this)[0], params));
      });
    }
  })( window.jQuery || window.Zepto )
}