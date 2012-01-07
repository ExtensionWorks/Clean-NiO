<?php

function createGallery($attr){
	if (!class_exists('niogallery')) {
		$path = WP_PLUGIN_DIR."/nio/niorssgallery.php";
		include($path); 
	}
	// PARAMETER TO SPECIFY THE RSS FEED TO BE USED
	$Za = $attr['GENERAL']['RSS'];	
	
	// GENERAL PARAMETERS
	$Zb = $attr['GENERAL']['NoThum'];			// Fixes the number of thumbnails to show in the gallery.
	$Zc = $attr['GENERAL']['Header'];			// The header/title for the gallery. The header will be surpressed if nothing ('') is specified.
	$Zd = $attr['GENERAL']['SubTitle'];			// Subtitle. The text area will be surpressed, if nothing ('') is specified.
	$Ze = $attr['GENERAL']['Bottom'];			// Bottom text. The text area will be surpressed, if nothing ('') is specified.
				
	
	// PARAMETERS FOR STYLING THE GALLERY
	$Ga = $attr['STYLE']['GalWidth'];			// Sets the width of the gallery (in number of pixels). 
	$Gb = $attr['STYLE']['GalBackground'];		// Sets the background color of the gallery (please specify a color number including the hash sign).
	$Gc = $attr['STYLE']['GalPadding']; 		// Sets the padding of the gallery (in number of pixels).
	$Gd = $attr['STYLE']['GalBorderSize'];		// Fixes the size of border of the gallery (in number of pixels). A value of '0' surpresses the border.
	$Ge = $attr['STYLE']['GalBorderColor'];		// Sets the border color of the gallery (please specify a color number including the hash sign).
	$Gf = $attr['STYLE']['GalFontColor'];		// Sets the font color. Specify the color number including the hash sign. If emptied (''), the default color for element 'p' will be used. 
	
	// PARAMETERS FOR STYLING THE THUMBNAILS. Leave empty to use the style as set for class
	$Ta = $attr['THUMB']['Size'];	  			// Fixes the size of the of thumbnails (in number of pixels).
	$Tb = $attr['THUMB']['Style'];				// Opt for a square thumbnail ('S'), normal thumbnails ('N') or thumbnails with a maximized height ('M')
	$Tc = $attr['THUMB']['WaterMark'];			// Opt for a higher quality thumbnail with watermark ('Y' or 'N').
	$Td = $attr['THUMB']['Margin'];				// Sets the margin between thumbs (in number of pixels).
	$Te = $attr['THUMB']['TopBottomPadding'];	// Sets the top and bottom padding of a thumb (in number of pixels).
	$Tf = $attr['THUMB']['LeftRightPadding'];	// Sets the left and right padding of a thumb (in number of pixels).
	$Tg = $attr['THUMB']['ThumbBackground'];	// Sets the color of the background of the thumb (use a color number including the hash sign).
	$Th = $attr['THUMB']['ThumbBorderSize'];	// Determines the size of border of the thumb (nin umber of pixels). A value of zero surpresses the border.
	$Ti = $attr['THUMB']['ThumbBorderColor']; 	// Sets the border color (color number with the hash).
	$Tj = $attr['THUMB']['ThumbBorderHover']; 	// Sets the border hover color (color number with the hash).
	$Tk = $attr['THUMB']['ThumbHoverText'];		// Text that is shown on hovering the thumbnails. If emptied, the IPTC caption and IPTC owner wil be shown.
	$Tl = $attr['THUMB']['ThumbTarget'];		// Determines whether PhotoShelter pages open in the same window (S) or a new window (N).
	
	// PARAMETERS FOR ENABLING AND STYLING OF CAPTIONS
	$Ca = $attr['CAPTOIN']['Size']; 			// Fixes the size of the thumbnail caption (in number of characters). A value of '0' surpresses the caption.
	$Cb = $attr['CAPTOIN']['HorC'];				// Determines whether IPTC headline ('H') or IPTC caption ('C') is used for the text underneath the thumbnail.
	$Cc = $attr['CAPTOIN']['Height'];			// Sets the height of the caption in pixels. This will not apply if no caption is used.
	
	// CODE TO GENERATE THE GALLERY BASED ON PARAMETERS SPECIFIED ABOVE. PLEASE DO NOT EDIT!!
	$niogallery = new niogallery($Za,$Ga,$Gb,$Gc,$Gd,$Ge,$Ta,$Tb,$Tc,$Td,$Te,$Tf,$Tg,$Th,$Ti,$Tj,$Ca,$Cb,$Cc,$Gf,$Tk,$Tl,$Zb) ;
	return $niogallery->create($Zc,$Zd,$Ze);
}

function NioBuildAttribute(){
	// GENERAL PARAMETERS
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
	array_walk_recursive($attr['GENERAL'],'buildTable','GENERAL');
	array_walk_recursive($attr['CAPTOIN'],'buildTable','CAPTOIN');
	array_walk_recursive($attr['STYLE'],'buildTable','STYLE');
	array_walk_recursive($attr['THUMB'],'buildTable','THUMB');
	
}

function gatherData(){
	global $attr;
	array_walk_recursive($attr['GENERAL'],'fetchTable','GENERAL');
	array_walk_recursive($attr['CAPTOIN'],'fetchTable','CAPTOIN');
	array_walk_recursive($attr['STYLE'],'fetchTable','STYLE');
	array_walk_recursive($attr['THUMB'],'fetchTable','THUMB');
	return $attr;
}

function buildTable($item, $key, $para){
	add_option("Nio_".$para."_".$key, $value = '', $deprecated = '', $autoload = 'yes');
}

function fetchTable($item, $key, $para){
	global $attr;
	$attr[$para][$key] = get_option("Nio_".$para."_".$key);
}
?>