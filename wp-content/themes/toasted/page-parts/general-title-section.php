<?php
/**
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */


$title_arr = array();

$title_arr['title'] = kleo_title();
	
//hide title?
$title_arr['show_title'] = true;
if(get_cfield('title_checkbox') == 1) {
	$title_arr['show_title'] = false;
}
if (sq_option('title_location', 'breadcrumb') == 'main') {
	$title_arr['show_title'] = false;
}

//hide breadcrumb?
if(sq_option('breadcrumb_status', 1) == 0) {
	$title_arr['show_breadcrumb'] = false;
}

if(get_cfield('hide_breadcrumb') == 1) {
	$title_arr['show_breadcrumb'] = false;
} else if ( get_cfield('hide_breadcrumb') === '0') {
	$title_arr['show_breadcrumb'] = true;
}

//hide extra info?
if(get_cfield('hide_info') == 1) {
	$title_arr['extra'] = '';
}


if ( (isset($title_arr['show_breadcrumb']) && $title_arr['show_breadcrumb']) || !isset($title_arr['extra']) || $title_arr['show_title']  ) {
	echo kleo_title_section($title_arr);
}