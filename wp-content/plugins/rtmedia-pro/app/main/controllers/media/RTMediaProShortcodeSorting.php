<?php
/**
 * Created by PhpStorm.
 * User: sanket
 * Date: 20/1/15
 * Time: 2:31 PM
 */

class RTMediaProShortcodeSorting {

	public function __construct() {
		add_filter( "rtmedia_allowed_query", array( $this, "rtmedia_allowed_sort_by_parameter_in_query" ), 99 );
		add_action( "rtmedia_gallery_after_title", array( $this, "rtmedia_gallery_shortcode_sort_option" ) );
        add_action( "rtmedia_set_query", array( $this, "rtmedia_set_query_filters" ), 99 );
        add_filter( 'rtmedia_query_filter', array( $this, 'add_shortcode_sort_fields_in_query' ), 10, 1 );
	}

	/*
	 * allow "sort_parameters" shortcode parameter
	 */
	public function rtmedia_allowed_sort_by_parameter_in_query( $param = array() ) {
		$param[] = 'sort_parameters';

		return $param;
	}

	/*
	 * render sort options
	 */
	public function rtmedia_gallery_shortcode_sort_option() {
        global $media_query_clone_shortcode_sorting, $rtmedia_query;
        
        if( isset( $rtmedia_query->is_gallery_shortcode ) && $rtmedia_query->is_gallery_shortcode && isset( $media_query_clone_shortcode_sorting[ 'sort_parameters' ] ) && $media_query_clone_shortcode_sorting[ 'sort_parameters' ] != '' ) {
            $rtmedia_sort_params = explode( ',', $media_query_clone_shortcode_sorting[ 'sort_parameters' ] );
            $rtmedia_sort_labels = array(
                'new' => __( 'Newest', 'rtmedia' ),
                'view' => __( 'Most Viewed', 'rtmedia' ),
                'like' => __( 'Most Liked', 'rtmedia' ),
                'comment' => __( 'Most Commented', 'rtmedia' ),
                'rate' => __( 'Most Rated', 'rtmedia' )
            );            
            $rtmedia_sort_labels = apply_filters( 'rtmedia_change_sort_parameters_label', $rtmedia_sort_labels );
            ?>
            <div class="clear"></div>
            <div class="rtmedia-pro-sortable-parameters">
                <?php 
                for( $s = 0; $s < sizeof( $rtmedia_sort_params ); $s++ ) {
                    $key = $rtmedia_sort_params[ $s ];
                    $value = $rtmedia_sort_labels[ $key ];
                    ?>
                    <span id="rtm-sort-most-<?php echo $key; ?>" onclick="rtmedia_sort_shortcode_gallery( this, '<?php echo $key; ?>' );"><?php echo $value; ?></span>
                    <?php
                }
                ?>
            </div>
            <?php
        }
	}

	/*
	 * filter media query after RTMediaQuery is set
	 */
    public function rtmedia_set_query_filters() {
        add_filter( 'rtmedia_media_query', array( $this, 'modify_media_query' ), 10, 3);
    }

	/*
	 * Unset "sort_parameters" from media query. It's necessary otherwise it will check for "sort_parameters" as a database column which is not exist
	 */
    public function modify_media_query( $media_query, $action_query, $query ) {
        global $rtmedia_query;
        global $media_query_clone_shortcode_sorting; // store media_query for reference
        $media_query_clone_shortcode_sorting = $media_query;
        
        if( isset( $media_query[ 'sort_parameters' ] ) && $media_query[ 'sort_parameters' ] != '' ) {
            unset( $media_query[ 'sort_parameters' ] );
            
            // unset from global query so that multiple gallery shortcode can work
            if( isset( $rtmedia_query->query ) && isset( $rtmedia_query->query[ 'sort_parameters' ] ) ) {
                unset( $rtmedia_query->query[ 'sort_parameters' ] );
            }
        }
        return $media_query;
    }

	/*
	 * set order and order by
	 */
    public function add_shortcode_sort_fields_in_query( $args ) {
        if ( isset( $_GET[ 'json' ] ) && $_GET[ 'json' ] ) {
            if( isset( $_GET[ 'sort_by' ] ) && $_GET[ 'sort_by' ] != '' ) {
                switch( $_GET[ 'sort_by' ] ) {
                    case 'new' :
                        $args[ 'order_by' ] = "media_id";
                        break;
                    case 'view' :
                        // Filter for join with wp_rt_rtm_media_interaction table
                        add_filter( 'rtmedia-model-join-query', array( $this, 'join_query_rtmedia_interaction_view_count' ), 20, 2 );
                        add_filter( 'rtmedia-model-order-by-query', array( $this, 'rtmedia_select_query_view_count_order' ), 20, 2 );
                        break;
                    case 'like' :
                        $args[ 'order_by' ] = 'likes';
                        break;
                    case 'comment' :
                        add_filter( 'rtmedia-model-join-query', array( $this, 'join_query_rtmedia_comment_count' ), 20, 2 );
						add_filter( 'rtmedia-model-order-by-query', array( $this, 'rtmedia_select_query_comment_count_order' ), 20, 2 );
                        break;
                    case 'rate' :
                        $args[ 'order_by' ] = 'ratings_average';
                        break;
                }
            }
            
            if ( isset( $_GET[ 'sort_order' ] ) && $_GET[ 'sort_order' ] != "" ){
				switch ( $_GET[ 'sort_order' ] ) {
					case 'asc' :
						$args[ 'order' ] = "ASC";
                        break;
					default :
						$args[ 'order' ] = "DESC";
                        break;
				}
			}
        }
        
        return $args;
    }
    
    public function join_query_rtmedia_interaction_view_count( $join, $table_name ) {
        $rtmedia_meta = new RTMediaMeta();
        $join_table = $rtmedia_meta->model->table_name;
        $join .= " LEFT JOIN {$join_table} ON ( {$join_table}.media_id = {$table_name}.id AND ( {$join_table}.meta_key = 'view' ) ) ";
        return $join;
    }
    
    // Setting order for views
    function rtmedia_select_query_view_count_order( $orderby, $table_name ) {
        $rtmedia_meta = new RTMediaMeta();
        $select_table = $rtmedia_meta->model->table_name;
		$order = "DESC";
		if ( isset( $_GET[ 'sort_order' ] ) && $_GET[ 'sort_order' ] != "" ){
			if ( $_GET[ 'sort_order' ] == 'asc' ) {
				$order = "ASC";
			}
		}
        $orderby =  'ORDER BY ' . $select_table . '.meta_value ' . $order . ', ' . $table_name . '.media_id DESC';
        return $orderby;
    }
    
    public function join_query_rtmedia_comment_count( $join, $table_name ) {
        global $wpdb;

        $join .= " LEFT JOIN {$wpdb->posts} ON ( {$wpdb->posts}.ID = {$table_name}.media_id ) ";
        return $join;
    }
    
    public function rtmedia_select_query_comment_count_order( $orderby, $table_name ) {
        global $wpdb;

		$order = "DESC";
		if ( isset( $_GET[ 'sort_order' ] ) && $_GET[ 'sort_order' ] != "" ){
			if ( $_GET[ 'sort_order' ] == 'asc' ) {
				$order = "ASC";
			}
		}
        $orderby =  'ORDER BY ' . $wpdb->posts . '.comment_count ' . $order . ', ' . $table_name . '.media_id DESC';
        return $orderby;
    }

}