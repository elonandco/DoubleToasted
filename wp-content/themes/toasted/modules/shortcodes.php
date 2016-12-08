<?php

// [section]
function lacourse_section( $atts, $content = null ) {

// 	$content = str_replace('<p><', '<', $content);
// 	$content = str_replace('></p>', '>', $content);
// 	$content = str_replace('<p></p>', '', $content);
	//var_dump($content);

    $class = '';
        
    extract( shortcode_atts( array(
	      'bg' => 'white',
     ), $atts ) );
     
     if ($bg == 'texture') {
     	$class = 'texture';
     }
     
     return '<div class="section ' . $class . '"><div class="content"><div class="row">' . do_shortcode($content) . '</div></div></div>';
     	
}

add_shortcode('section', 'lacourse_section');

// [grid]
function lacourse_col( $atts, $content = null ) {
        
    extract( shortcode_atts( array(
	      'col' => false,
     ), $atts ) );
    
    $col = intval($col);
    
    if (is_int($col)) {    
		return '<div class="large-' . $col . ' medium-' . $col . ' columns">' . do_shortcode($content) . '</div>';
	}
	
	else {
		return '<div class="large-12 columns">' . $content . '</div>';
	}

}
add_shortcode('grid', 'lacourse_col');

// [accordion]
function verdtek_accordion( $atts, $content = null ) {
	
   	return '<div class="accordion">' . do_shortcode($content) . '</div>';

}
add_shortcode('accordion', 'verdtek_accordion');

// [acc-item]
function verdtek_accitem( $atts, $content = null ) {

    extract( shortcode_atts( array(
	      'title' => ''
     ), $atts ) );
     
    if ($title != '') {
	   	return '<div class="acc-title"><p><a class="acc-toggle"><i class="entypo circled-plus"></i>' . $title . '</a></p></div>' . '<div class="acc-content">' . $content . '</div>';
	}
}
add_shortcode('acc-item', 'verdtek_accitem');

?>