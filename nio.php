<?php

/*
Plugin Name: Clean Nio
Description: This is a wordpress plugin to implement the functionality of niophoto.com's photoshelter-rss-thumbnail-gallery-widget.
Author: Andy - <a href="http://hypnoticzoo.com/" title="Visit author homepage">Hypnotic Zoo</a> | <a href="http://www.hypnoticzoo.com/freebies/wordpress/clean-nio/?utm_source=wordpress&utm_medium=plugin&utm_content=v1&utm_campaign=wordpress" title="Visit plugin site">Visit plugin site</a>
Version: 1.0
*/
require_once('niorssgallery.php');
require_once('functions.php');
require_once('control.php');

register_activation_hook(__FILE__,'NioBuildAttribute');

$attr = array();
$attr['GENERAL']['RSS'] = '';
$attr['GENERAL']['NoThum'] = '' ;
$attr['GENERAL']['Header'] = '';
$attr['GENERAL']['SubTitle'] = '';
$attr['GENERAL']['Bottom'] = '';
			

// PARAMETERS FOR STYLING THE GALLERY
$attr['STYLE']['GalWidth']  = '';
$attr['STYLE']['GalBackground'] = '' ;
$attr['STYLE']['GalPadding'] = '' ;
$attr['STYLE']['GalBorderSize'] = '' ;
$attr['STYLE']['GalBorderColor'] = '';
$attr['STYLE']['GalFontColor'] = '';

// PARAMETERS FOR STYLING THE THUMBNAILS. Leave empty to use the style as set for class
$attr['THUMB']['Size'] = '' ;
$attr['THUMB']['Style'] = '';
$attr['THUMB']['WaterMark'] = '' ;
$attr['THUMB']['Margin'] = '' ;
$attr['THUMB']['TopBottomPadding'] = '' ;
$attr['THUMB']['LeftRightPadding'] = '' ;
$attr['THUMB']['ThumbBackground'] = '' ;
$attr['THUMB']['ThumbBorderSize'] = '' ;
$attr['THUMB']['ThumbBorderColor'] = '' ;
$attr['THUMB']['ThumbBorderHover'] = '' ;
$attr['THUMB']['ThumbHoverText'] = '' ;
$attr['THUMB']['ThumbTarget'] = '' ;

// PARAMETERS FOR ENABLING AND STYLING OF CAPTIONS
$attr['CAPTOIN']['Size'] = '' ;
$attr['CAPTOIN']['HorC'] = '';
$attr['CAPTOIN']['Height'] = '';

function niogallery_func( $atts ) {
	global $attr;
	gatherData();
	extract( shortcode_atts( array(
		'rss' => $attr['GENERAL']['RSS'],
		'layout' => 'M',
	), $atts ) );
	$attr['GENERAL']['RSS'] = $rss;
	$attr['THUMB']['Style'] = $layout;
	$title = get_query_var( 'pagename' );
	if(strtolower($title)!='blog'){
		echo createGallery($attr);
	}
}
add_shortcode( 'niogallery', 'niogallery_func' );
?>