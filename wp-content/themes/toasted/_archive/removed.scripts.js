

// 5. Toggles 'Export' icons in single page pagination
var shareIconsDt = jQuery('.dt-hover-share');
// 
// jQuery('.dt-icon-export').mouseenter(function() {
// 
// 	shareIconsDt.stop();
// 	jQuery('.icon-export').animate({ opacity: '.5'}, 100);
// 	shareIconsDt.animate({
// 		width: '90px'
// 		  }, 150 );
// 
// });
// 
// jQuery('.dt-icon-export').mouseleave(function() {
// 
// 	shareIconsDt.stop();
// 	shareIconsDt.animate({
// 		width: '0px'
// 		  }, 150 );
// 	jQuery('.icon-export').animate({ opacity: '1'}, 100);
// 
// });

// delete this if you decide to keep the new layout
jQuery('.icon-export').fadeOut();
shareIconsDt.animate({
	width: '90px'
	  }, 150 );