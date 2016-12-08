// Sort for Featured Carousel Admin page
jQuery("#feature-this-list").sortable({
	update: function(container, row) { 
	
		jQuery('.spinner.dt-manage-featured').css({'display':'inline-block'}); // Adds loading spinner

		// Get data from our elements
		prev 	= jQuery(row.item).prev().attr('order');
		next 	= jQuery(row.item).next().attr('order');
		post_id = jQuery(row.item).attr('postid');
		
		// Set new order based on surrounding items
		if (prev && next) { 
			new_order = (parseInt(prev) + parseInt(next))/2; }	
			
		else if (!prev) {
			new_order = jQuery("#feature-this-list").attr('timestamp'); }
			
		else { 
			new_order = parseInt(prev) - 1000; } // if last we'll just bump back the date a bit
			
		console.log(new_order, prev, next, post_id);
		
		var ajaxdata = {
			action: 'dt_set_feature_this',
			'post_id': post_id,
			'order': new_order
		};
		
		jQuery('#feature-this-list > tr').removeClass('alternate');
		jQuery('#feature-this-list > tr:even').addClass('alternate');
		
		jQuery.post( ajaxurl, ajaxdata,
			function(response) {
				jQuery('.spinner.dt-manage-featured').css({'display':'none'});
				jQuery(row.item).attr('order', new_order );
			});

	}
});

// This handles "feature this" row action to feature posts
jQuery('.feature-this-post').click(function(e) {

		e.preventDefault(); // make sure our links dont go anywhere
		el = jQuery(this);
		order = 'newest';

 		el.parent().children('.spinner').css({'display':'inline-block'}); // Adds loading spinner
		post_id = el.parents('.hentry').attr('id').split('-')[1]; // get post id from parent

		if (el.hasClass('featured')) {
			order = 0;
		}
		
		var ajaxdata = {
			action: 'dt_set_feature_this',
			'post_id': post_id,
			'order': order
		};
		
		jQuery.post( ajaxurl, ajaxdata,
			function(response) {
				
				jQuery('.spinner').css({'display':'none'}); // Adds loading spinner

				if (order == 0) {
					jQuery(el).removeClass('featured');
					jQuery(el).text('Feature This');
				} else {
					jQuery(el).text('Featured');
				}
			});

});

// Remove Feature on Manage Features Admin Screen
jQuery('.dt-feature-remove').click(function(e) {

		e.preventDefault(); // make sure our links dont go anywhere
		el = jQuery(this);

 		el.parent().children('.spinner').css({'display':'inline-block'}); // Adds loading spinner
		post_id = el.parents('.hentry').attr('postid'); // get post id from parent
		
		var ajaxdata = {
			action: 'dt_set_feature_this',
			'post_id': post_id,
			'order': 0
		};
		
		jQuery.post( ajaxurl, ajaxdata,
			function(response) {
				
				jQuery('.spinner').css({'display':'none'}); // Adds loading spinner
				el.parents('.hentry').fadeOut();
				jQuery('#feature-this-list > tr').removeClass('alternate');
				jQuery('#feature-this-list > tr:even').addClass('alternate');
	
			});

});