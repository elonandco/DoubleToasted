<?php

/* 

	Add all custom post types, yeeehaw!

*/

function lacourse_add_shows_type_0508() {

	register_post_type( 'dt_shows',
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Shows', 'bonestheme'), /* This is the Title of the Group */
			'singular_name' => __('Show', 'bonestheme'), /* This is the individual type */
			'all_items' => __('All Shows', 'bonestheme'), /* the all items menu item */
			'add_new' => __('Add New Show', 'bonestheme'), /* The add new menu item */
			'add_new_item' => __('Add New Show', 'bonestheme'), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __('Edit Show', 'bonestheme'), /* Edit Display Title */
			'new_item' => __('New Show', 'bonestheme'), /* New Display Title */
			'view_item' => __('View Show', 'bonestheme'), /* View Display Title */
			'search_items' => __('Search Shows', 'bonestheme'), /* Search Custom Type Title */
			'not_found' =>  __('The robots didn\'nt find anything in the databank.', 'bonestheme'), /* This displays if there are no entries yet */
			'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Episode Archives.', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 5, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' => false, /* this auto adds a class to be styled */
			'rewrite'	=> array( 'slug' => 'show', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => true, /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'excerpt', 'editor', 'author', 'thumbnail', 'comments', 'page-attributes')
	 	) /* end of options */
	); /* end of register post type */

}

// adding the function to the Wordpress init
add_action( 'init', 'lacourse_add_shows_type_0508');

function lacourse_add_cast_type_0508() {

	register_post_type( 'dt_cast',
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Cast Members', 'bonestheme'), /* This is the Title of the Group */
			'singular_name' => __('Cast Member', 'bonestheme'), /* This is the individual type */
			'all_items' => __('All Cast Members', 'bonestheme'), /* the all items menu item */
			'add_new' => __('Add New Cast Member', 'bonestheme'), /* The add new menu item */
			'add_new_item' => __('Add New Cast Member', 'bonestheme'), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __('Edit Cast Member', 'bonestheme'), /* Edit Display Title */
			'new_item' => __('New Cast Member', 'bonestheme'), /* New Display Title */
			'view_item' => __('View Cast Member', 'bonestheme'), /* View Display Title */
			'search_items' => __('Search Cast Members', 'bonestheme'), /* Search Custom Type Title */
			'not_found' =>  __('The robots didn\'nt find anything in the databank.', 'bonestheme'), /* This displays if there are no entries yet */
			'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Episode Archives.', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 5, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' => false, /* this auto adds a class to be styled */
			'rewrite'	=> array( 'slug' => 'cast', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => true, /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'secondary-title', 'editor', 'thumbnail', 'page-attributes')
	 	) /* end of options */
	); /* end of register post type */

}

// adding the function to the Wordpress init
add_action( 'init', 'lacourse_add_cast_type_0508');

add_action( 'init', 'create_dt_shows_series_cat', 0 );

function create_dt_shows_series_cat() {
    register_taxonomy (
        'series',
        'dt_shows',
        array(
            'labels' => array(
                'name' => 'Series Title',
                'add_new_item' => 'Add Series',
                'new_item_name' => "New Series"
            ),
            'show_ui' => true,
            'show_admin_column' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'rewrite' => array( 'slug' => 'shows' )
        )
    );
}

add_action( 'init', 'carousel_featured_dt', 0 );

function carousel_featured_dt() {
    register_taxonomy (
        'featured',
        array( 'dt_shows', 'dt-video', 'dt-audio', 'post', 'page' ),
        array(
            'labels' => array(
                'name' => 'Feature',
                'add_new_item' => 'Add Feature (dev)',
                'new_item_name' => "New Feature (dev)"
            ),
            'show_ui' => true,
            'show_admin_column' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'rewrite' => false
        )
    );
}

function lacourse_add_reviews_type_0508() {

	register_post_type( 'dt-audio',
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Podcasts', 'bonestheme'), /* This is the Title of the Group */
			'singular_name' => __('Audio', 'bonestheme'), /* This is the individual type */
			'all_items' => __('All Audio', 'bonestheme'), /* the all items menu item */
			'add_new' => __('Add New Audio', 'bonestheme'), /* The add new menu item */
			'add_new_item' => __('Add New Audio', 'bonestheme'), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __('Edit Audio', 'bonestheme'), /* Edit Display Title */
			'new_item' => __('New Audio', 'bonestheme'), /* New Display Title */
			'view_item' => __('View Audio', 'bonestheme'), /* View Display Title */
			'search_items' => __('Search Audio', 'bonestheme'), /* Search Custom Type Title */
			'not_found' =>  __('The robots didn\'nt find anything in the databank.', 'bonestheme'), /* This displays if there are no entries yet */
			'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Free audio shows & podcasts.', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 5, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' => false, /* this auto adds a class to be styled */
			'rewrite'	=> array( 'slug' => 'audio', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'audiocasts', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'page-attributes')
	 	) /* end of options */
	); /* end of register post type */

}

// adding the function to the Wordpress init
//add_action( 'init', 'lacourse_add_reviews_type_0508');	


function lacourse_add_dt_video_type() {

	register_post_type( 'dt-video',
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Videos', 'bonestheme'), /* This is the Title of the Group */
			'singular_name' => __('Video', 'bonestheme'), /* This is the individual type */
			'all_items' => __('All Video', 'bonestheme'), /* the all items menu item */
			'add_new' => __('Add New Video', 'bonestheme'), /* The add new menu item */
			'add_new_item' => __('Add New Video', 'bonestheme'), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __('Edit Video', 'bonestheme'), /* Edit Display Title */
			'new_item' => __('New Video', 'bonestheme'), /* New Display Title */
			'view_item' => __('View Video', 'bonestheme'), /* View Display Title */
			'search_items' => __('Search Video', 'bonestheme'), /* Search Custom Type Title */
			'not_found' =>  __('The robots didn\'nt find anything in the databank.', 'bonestheme'), /* This displays if there are no entries yet */
			'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Videos.', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 5, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' => false, /* this auto adds a class to be styled */
			'rewrite'	=> array( 'slug' => 'videos', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'videos', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'page-attributes')
	 	) /* end of options */
	); /* end of register post type */

}

// adding the function to the Wordpress init
//add_action( 'init', 'lacourse_add_dt_video_type');	

// function lacourse_add_comics_type_0508() { 
// 
// 	register_post_type( 'dt-comics',
// 	 	// let's now add all the options for this post type
// 		array('labels' => array(
// 			'name' => __('Comics', 'bonestheme'), /* This is the Title of the Group */
// 			'singular_name' => __('Comic', 'bonestheme'), /* This is the individual type */
// 			'all_items' => __('All Comic', 'bonestheme'), /* the all items menu item */
// 			'add_new' => __('Add New Comic', 'bonestheme'), /* The add new menu item */
// 			'add_new_item' => __('Add New Comic', 'bonestheme'), /* Add New Display Title */
// 			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
// 			'edit_item' => __('Edit Comic', 'bonestheme'), /* Edit Display Title */
// 			'new_item' => __('New Comic', 'bonestheme'), /* New Display Title */
// 			'view_item' => __('View Comic', 'bonestheme'), /* View Display Title */
// 			'search_items' => __('Search Comic', 'bonestheme'), /* Search Custom Type Title */ 
// 			'not_found' =>  __('The robots didn\'nt find anything in the databank.', 'bonestheme'), /* This displays if there are no entries yet */ 
// 			'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
// 			'parent_item_colon' => ''
// 			), /* end of arrays */
// 			'description' => __( 'Free comic strips, yeah.', 'bonestheme' ), /* Custom Type Description */
// 			'public' => true,
// 			'publicly_queryable' => true,
// 			'exclude_from_search' => false,
// 			'show_ui' => true,
// 			'query_var' => true,
// 			'menu_position' => 5, /* this is what order you want it to appear in on the left hand side menu */ 
// 			'menu_icon' => false, /* this auto adds a class to be styled */
// 			'rewrite'	=> array( 'slug' => 'comic', 'with_front' => false ), /* you can specify its url slug */
// 			'has_archive' => 'comics', /* you can rename the slug here */
// 			'capability_type' => 'post',
// 			'hierarchical' => false,
// 			/* the next one is important, it tells what's enabled in the post editor */
// 			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'page-attributes')
// 	 	) /* end of options */
// 	); /* end of register post type */
// 	
// } 
// 
// // adding the function to the Wordpress init
// add_action( 'init', 'lacourse_add_users_blog_type_0508');	

function lacourse_add_users_blog_type_0508() {

	register_post_type( 'dt-users-blog',
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Community Blog', 'bonestheme'), /* This is the Title of the Group */
			'singular_name' => __('Article', 'bonestheme'), /* This is the individual type */
			'all_items' => __('All Artciles', 'bonestheme'), /* the all items menu item */
			'add_new' => __('Add New Article', 'bonestheme'), /* The add new menu item */
			'add_new_item' => __('Add New Article', 'bonestheme'), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __('Edit Article', 'bonestheme'), /* Edit Display Title */
			'new_item' => __('New Article', 'bonestheme'), /* New Display Title */
			'view_item' => __('View Article', 'bonestheme'), /* View Display Title */
			'search_items' => __('Search Articles', 'bonestheme'), /* Search Custom Type Title */
			'not_found' =>  __('The robots didn\'nt find anything in the databank. The transistor is the RESISTOR! - Mike from deep in the code', 'bonestheme'), /* This displays if there are no entries yet */
			'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Article Archives.', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 35, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' => false, /* this auto adds a class to be styled */
			'rewrite'	=> array( 'slug' => 'community-blog', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => true, /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'page-attributes')
	 	) /* end of options */
	); /* end of register post type */

}

// adding the function to the Wordpress init
add_action( 'init', 'lacourse_add_users_blog_type_0508');


?>
