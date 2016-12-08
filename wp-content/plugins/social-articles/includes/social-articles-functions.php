<?php
if ( !defined( 'ABSPATH' ) ) exit;

function social_articles_load_template_filter( $found_template, $templates ) {
    global $bp;

    if( !bp_sa_is_bp_default() || !bp_is_current_component( $bp->social_articles->slug )){
        return $found_template;
    }

    foreach ( (array) $templates as $template ) {
        if ( file_exists( STYLESHEETPATH . '/' . $template ) )
            $filtered_templates[] = STYLESHEETPATH . '/' . $template;
        else
            $filtered_templates[] = dirname( __FILE__ ) . '/templates/' . $template;
    }
    $found_template = $filtered_templates[0];
    return apply_filters( 'social_articles_load_template_filter', $found_template );
}
add_filter( 'bp_located_template', 'social_articles_load_template_filter', 10, 2 );


function social_articles_load_sub_template( $template ) {
    if( empty( $template ) )
        return false;

    if( bp_sa_is_bp_default() ) {
        //locate_template( array(  $template . '.php' ), true );
        if ( $located_template = apply_filters( 'bp_located_template', locate_template( $template , false ), $template ) )
            load_template( apply_filters( 'bp_load_template', $located_template ) );

    } else {
        bp_get_template_part( $template );

    }
}

function get_short_text($text, $limitwrd ) {   
    if (str_word_count($text) > $limitwrd) {
      $words = str_word_count($text, 2);
      if ($words > $limitwrd) {
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limitwrd]) . ' [...]';
      }
    }
    return $text;
}

function custom_get_user_posts_count($status){
    $args = array();     
    $args['post_status'] = $status;
    $args['author'] = bp_displayed_user_id();
    $args['fields'] = 'ids';
    $args['posts_per_page'] = "-1";
    $args['post_type'] = 'dt-users-blog';
    $ps = get_posts($args);
    return count($ps);
}

function bp_sa_is_bp_default() {

    if(current_theme_supports('buddypress') || in_array( 'bp-default', array( get_stylesheet(), get_template() ) )  || ( defined( 'BP_VERSION' ) && version_compare( BP_VERSION, '1.7', '<' ) ))
        return true;
    else {
        $theme = wp_get_theme();
        $theme_tags = ! empty( $theme->tags ) ? $theme->tags : array();
        $backpat = in_array( 'buddypress', $theme_tags );
        if($backpat)
            return true;
        else
            return false; //wordpress theme
    }

}

function isDirectWorkflow(){
    global $socialArticles;
    return $socialArticles->options['workflow'] == 'direct' ;
}

?>