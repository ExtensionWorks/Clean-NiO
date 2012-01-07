<?php

// 	NiO PhotoShelter RSS Gallery Widget (version 1.5.3 of September, 22nd 2010)
//  Creates a thumbnail gallery based on a photoshelter RSS feed. PHP script by Johan Peijnenburg of NiO Photography | Nature & travel images
// 	This script uses the SimpleXML extension that was introduced in the release of PHP 5. 
//	If you decide to use it, please blog about it or provide a credit with a link to my site : http://www.niophoto.com
//	Copyright (C) 2010 Johan Peijnenburg | NiO Photography

//	This program is free software: you can redistribute it and/or modify
//	it under the terms of the GNU General Public License as published by
//	the Free Software Foundation, either version 3 of the License, or
//	(at your option) any later version.

//	This program is distributed in the hope that it will be useful,
//	but WITHOUT ANY WARRANTY; without even the implied warranty of
//	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//	GNU General Public License for more details.

//	You should have received a copy of the GNU General Public License
//	along with this program.  If not, see <http://www.gnu.org/licenses/>.

//	For more information contact me at: widgets@niophoto.com

class niogallery {

  var $rssfeed; 	// RSS feed that needs to be used ('full rss hyperlink')
  var $gwidth;		// Width of the gallery (number of pixels)
  var $gcolor;		// Background color of the gallery (color number with the hash)
  var $gborder; 	// Size of border of the gallery (number of pixels). A value of zero surpresses the border.
  var $gbcolor; 	// Border color of the gallery (color number with the hash).
  var $gpadtrbl;	// Padding of a the gallery (number of pixels)  
  var $tpixels; 	// Size of thumbnails (number of pixels)
  var $tformat;		// Opt for a square thumbnail ('S'), normal thumbnails ('N') or thumbnails with a maximized height ('M')
  var $thigh;		// Opt for highest quality thumbnail with watermark ('y' or 'n')
  var $tmargin;		// Margin between thumbs (number of pixels)
  var $tpadtb;		// Top and bottom padding of a thumb (number of pixels)
  var $tpadlr;		// Left and right padding of a thumb (number of pixels)
  var $tcolor;		// Color of the background of the thumb (color number with the hash)
  var $tborder; 	// Size of border of the thumb (number of pixels). A value of zero surpresses the border.
  var $tbcolor; 	// Border color (color number with the hash).
  var $tbhover; 	// Border hover color (color number with the hash).  
  var $tcsize;		// Size of the caption (number of characters). A value of zero surpresses the caption.
  var $tcsource;	// Use IPTC headline or caption for the caption of the thumbnail
  var $tcheight;	// The height of the caption in pixels. Will not apply if no caption is used.
  var $fontcolor;	// Font color (color number with the hash).  
  var $hovtext; 	// Fixed on hover text. If empty, caption and photographer will be shown.
  var $ltarget;		// Open image in same window ('S') or new window ('N'). 
  var $athumbs;		// Number of thumbnails to show.
  
  function niogallery($rssfeed, $gwidth, $gcolor, $gpadtrbl, $gborder, $gbcolor, $tpixels, $tformat, $thigh, $tmargin, $tpadtb, $tpadlr, $tcolor, $tborder, $tbcolor, $tbhover, $tcsize, $tcsource, $tcheight, $fontcolor, $hovtext, $ltarget, $athumbs) {
    $this->rssfeed = $rssfeed; $this->gwidth = $gwidth; $this->gcolor = $gcolor; $this->gpadtrbl = $gpadtrbl; $this->gborder = $gborder; $this->gbcolor = $gbcolor; $this->tpixels = $tpixels; $this->tformat = $tformat; $this->thigh = $thigh; $this->tmargin = $tmargin; $this->tpadtb = $tpadtb; $this->tpadlr = $tpadlr; $this->tcolor = $tcolor; $this->tborder = $tborder; $this->tbcolor = $tbcolor; $this->tbhover = $tbhover; $this->tcsize = $tcsize; $this->tcsource = $tcsource;  $this->tcheight = $tcheight; $this->fontcolor = $fontcolor; $this->hovtext = $hovtext; $this->ltarget = $ltarget; $this->athumbs = $athumbs;
  }

  function readrss() {
  
    $gallery = array();  

	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $this->rssfeed);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
  
    $content = new SimpleXMLElement($data); 
    $p_cnt = count($content->channel->item); 
	
    for ($c = 0; ($c < $p_cnt ) && ($c < $this->athumbs); $c++) {
      $item = $content->channel->item[$c];
      $hyper = (string) $item->link; 									// Hyperlink for the photograph
      $title = (string) $item->title; 									// The title for the photograph
      $media = $item->children('http://search.yahoo.com/mrss/');		// Media namespace
      $attr = $media->thumbnail->attributes();							// Attributes for the feed item
 	  $feedurl = (string) $attr['url']; 								// URL for the thumbnail  
      $descr0 = $item->xpath('./media:description'); 					// Array with title for the photograph     
	  $descr = $descr0[0];												// Fetshes title for the photograph from array  
      $keyw0 = $item->xpath('./media:keywords'); 						// Array with title for the photograph 
	  $keyw = $keyw0[0];												// Retrieves title for the photograph from array  
	  $owidth0 = $item->xpath('./ps:width');							// Retrieves width of the original image from XML 
	  $owidth = (int) $owidth0[0];										  
	  $oheight0 = $item->xpath('./ps:height');							// Retrieves height of the original image from XML 
	  $oheight = (int) $oheight0[0];										  
	  $ratio = $oheight/$owidth ;
	  
	  // SETTING THE TEXT TO BE SHOWN ON HOVERING THE THUMB: EITHER THE FIXED ONE AS SPECIFIED OR ONE BASED ON IPTC
	  if ($this->hovtext<>"")
	  	{ $hover = (string) $this->hovtext; }
	  else
	  	{ $hover = (string) $title; }

	  // SETTING THE CAPTION, BUT ONLY IF ONE IS REQUIRED
	  if ($this->tcsize>0) 
	  	{ if (strtoupper($this->tcsource)=="H")
			{ if (strlen(substr($title,0,strripos($title," by ") ) ) > $this->tcsize ) 
		   		{ $shortcap = (string) substr(substr($title,0,strripos($title," by ") ), 0,$this->tcsize) . "..." ; }
		  	  else
	  			{ $shortcap = (string) substr(substr($title,0,strripos($title," by ") ), 0,$this->tcsize) ; }
	  		}
	  	  else
	  		{ if (strlen($descr) > $this->tcsize ) 
 		  		{ $shortcap = (string) substr($descr, 0,$this->tcsize) . "..." ; }
 	      	  else
	  			{ $shortcap = (string) substr($descr, 0,$this->tcsize) ; }
	  		}
		  $cheight = (int) $this->tcheight;
		  $caption = (string) "<div class='niocapt' style='padding:5px 5px; height:{$cheight}px;'><p><a href='{$hyper}'>{$shortcap}</a></p></div>"; 
		}
	  else 
        { $shortcap = (string) "" ; 
          $cheight = (int) 0; 
          $caption = (string) "";
        }

	  // STRIPPING THE IMAGE URL AS RETREIVED FROM TE URL
 	  $shorturl = (string) substr($feedurl,0,strripos($feedurl,"/t/150") ) ; 

	  // PRODUCING THE THUMBNAIL URL
	  if (strtoupper($this->thigh)=="N") { 
	  	  $tquality = (string) "/t/";
	      if (strtoupper($this->tformat)=="S" || strtoupper($this->tformat)=="Y")
	   	  	{ $pssize = (int) round($this->tpixels * (max($oheight, $owidth) / min($oheight, $owidth)));
	   	  	  $theight = (int) $this->tpixels ;
	   	  	  $twidth = (int) $this->tpixels ;
	   	      $url = (string) home_url()."/wp-content/plugins/nio/timthumb.php?src=" . $shorturl . $tquality . $pssize . "/" . $pssize . "/thumbnail.jpg&h=" . $this->tpixels . "&w=" . $this->tpixels . "&zc=1&q=100";
	   	      $sheight = (int) $theight + $cheight ;
	   	      $swidth = (int) $twidth ;
	   	    }  
	      elseif (strtoupper($this->tformat)=="M")
	      	{ if ($ratio<1) 
	      	  	{ $pssize = (int) round($this->tpixels/$ratio,1) ; $theight = (int) $this->tpixels ; $twidth = (int) round($this->tpixels/$ratio,1);}
	      	  else
	      	    { $pssize = (int) $this->tpixels ; $theight = (int) $this->tpixels; $twidth = (int) round ($this->tpixels/$ratio,1);}
  	      	  $url = (string) $shorturl . $tquality . $pssize ;
	   	      $sheight = (int) $this->tpixels + $cheight ;
	   	      $swidth = (int) $twidth ;
	   	    }
	      else
	   		{ $pssize = (int) $this->tpixels; $theight = (int) $this->tpixels ; $twidth = (int) $pssize ; 
	   		  $url = (string) $shorturl . $tquality . $pssize ;
	   		  $sheight = (int) $theight + $cheight ;
	   	      $swidth = (int) $twidth ;
	   		}
		 }
	  else {
	  	  $tquality = (string) "/s/"; 
	      if (strtoupper($this->tformat)=="S" || strtoupper($this->tformat)=="Y")
	   	  	{ $pssize = (int) round($this->tpixels * (max($oheight, $owidth) / min($oheight, $owidth)));
	   	  	  $theight = (int) $this->tpixels ;
	   	  	  $twidth = (int) $this->tpixels ;
	   	      $url = (string) "/niorssgallery/timthumb.php?src=" . $shorturl . $tquality . 500 . "/" . 500 . "/thumbnail.jpg&h=" . $this->tpixels . "&w=" . $this->tpixels . "&zc=1&q=100" ;
	   	      $sheight = (int) $theight + $cheight ;
	   	      $swidth = (int) $twidth ;
	   	    }  
	      elseif (strtoupper($this->tformat)=="M")
	      	{ if ($ratio<1) 
	      	  	{ $pssize = (int) round($this->tpixels/$ratio,1) ; $theight = (int) $this->tpixels ; $twidth = (int) round($this->tpixels/$ratio,1);}
	      	  else
	      	    { $pssize = (int) $this->tpixels ; $theight = (int) $this->tpixels; $twidth = (int) round ($this->tpixels/$ratio,1);}
	      	  $url = (string) "/niorssgallery/timthumb.php?src=" . $shorturl . $tquality . 500 . "/" . 500 . "/thumbnail.jpg&h=" . $theight . "&w=" . $twidth . "&zc=1&q=100" ;
	   	      $sheight = (int) $theight + $cheight ;
	   	      $swidth = (int) $twidth ;
	   	    }
	      else
	      	{ if ($ratio<1) 
	      	  	{ $pssize = (int) $this->tpixels ; $theight = (int) round($pssize * $ratio); $twidth = (int) $pssize;}
	      	  else
	      	    { $pssize = (int) $this->tpixels ; $theight = (int) $pssize; $twidth = (int) round ($pssize / $ratio);}
	   	      $url = (string) "/niorssgallery/timthumb.php?src=" . $shorturl . $tquality . 500 . "/" . 500 . "/thumbnail.jpg&h=" . $theight . "&w=" . $twidth . "&zc=1&q=100" ;
	   	      $theight = (int) $this->tpixels ;
	   	      $sheight = (int) $this->tpixels + $cheight ;
	   	      $swidth = (int) $this->tpixels ;
	      	}
		 }
      	
	  // SETTING THE TARGET LOCATION FOR URLS      	
	  if (strtoupper($this->ltarget)<>"S")
	  	{ $target = (string) "_blank"; }
	  else
	  	{ $target = (string) "_top"; }      	

	  // ADDING THE THUMB TO THE GALLERY    	
      $gallery[] = 
<<<EOT
<div class="nioslide" style="width:{$swidth}px; height:{$sheight}px; border:{$this->tborder}px solid {$this->tbcolor}; background-color: {$this->tcolor}; margin: {$this->tmargin}px {$this->tmargin}px 0 0; padding:{$this->tpadtb}px {$this->tpadlr}px; float:left; text-align:center; ">
<div class='niothumb' style="color:{$this->tbcolor}; height:{$theight}px;"> <a href="{$hyper}" target="{$target}"> <img src="{$url}" title="{$hover}" alt="{$keyw}"/></a> </div>
{$caption}
</div>
EOT;
    }
    return $gallery;
  }

  var $header; 		// Header to display above the gallery
  
  function create($header, $toptext, $bottext) {
	$time = microtime();
	$time = explode(' ', $time);
	$time = $time[1] + $time[0];
	$start = $time;
    $gallery = $this->readrss();
    $i = 0;
    $gpadr = $this->gpadtrbl-$this->tmargin;
    $fullhead = "" ;
    if ( str_word_count($header)>0 )
    	$fullhead = "<h3 class='niohead' style='color:{$this->fontcolor};'>{$header}</h3>";
    $fullttext = "" ;
    if ( str_word_count($toptext)>0 )
    	$fullttext = "<p class='niotoptext' style='color:{$this->fontcolor}; margin-bottom:10px; padding-right: {$this->tmargin}px;'>{$toptext}</p>";
    $fullbtext = "" ;
    if ( str_word_count($bottext)>0 )
    	$fullbtext = "<p class='niobottext' style='color:{$this->fontcolor}; margin-top:20px; margin-bottom:5px; padding-right: {$this->tmargin}px;'>{$bottext}</p>";
    $display = <<<EOT
		 <style type="text/css">
		 .nioslide:hover { border-color:{$this->tbhover} !important; }
		 .niothumb a {color: {$this->tbcolor} !important; }
		 </style> 
         <div class='niogall' style="border:{$this->gborder}px solid {$this->gbcolor}; margin-bottom: 30px; padding: {$this->gpadtrbl}px {$gpadr}px {$this->gpadtrbl}px {$this->gpadtrbl}px; background-color:{$this->gcolor}; width:{$this->gwidth}px;">
         {$fullhead}
         {$fullttext}
EOT;
    while ( $i < $this->athumbs ) {
      $display .= $gallery[$i];
      $i++;
    }
    $display .= 
<<<EOT
<div style="clear: both;"></div>
 {$fullbtext}</div>
EOT;
	$time = microtime();
	$time = explode(' ', $time);
	$time = $time[1] + $time[0];
	$finish = $time;
	$total_time = round(($finish - $start), 4);
	$display.= '<!-- niorssgallery generated in '.$total_time.' seconds.-->';
    return $display;
  }
}
?>