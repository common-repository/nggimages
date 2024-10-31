<?php
/**
 * @package NGGImages
 * @author Piotr Piecyk
 * @version 0.2
 */
/*
Plugin Name: NGGImages
Plugin URI: http://blog.piecyk.net/nggimages
Description: This plugin allows you to view all images from selected galleries created using the NextGen Gallery plugin. 
Author: Piotr Piecyk
Version: 0.2
Author URI: http://www.piecyk.net
*/

/*	Copyright 2010 Piotr Piecyk

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/



function nggimages($atts)
{
	global $wpdb;
	
	$gid = $atts['id'];
	$before = str_replace(array("&gt;", "&lt;"), array(">", "<"), $atts['before']);
	$after = str_replace(array("&gt;", "&lt;"), array(">", "<"), $atts['after']);
	
	$query = "SELECT * FROM {$wpdb->nggallery} WHERE gid={$gid}";
	
	$gallery = $wpdb->get_results($query);
	$gallery_path = $gallery[0]->path;
	
	$query = "SELECT filename, alttext, description FROM {$wpdb->nggpictures} WHERE galleryid={$gid} ORDER BY sortorder ASC";
	
	$images = $wpdb->get_results($query);
	
	$content='';
	
	foreach ($images as $image)
	{
		
		$content.= $before.'<img src="'.get_bloginfo('url').'/'.$gallery_path.'/'.$image->filename.'" alt="'.$image->alttext.'" />';
		if ($atts['show_title']) $content.='<p class="nggImagesTitle">'.$image->alttext.'</p>';
		if ($atts['show_description']) $content.='<p class="nggImagesDesc">'.$image->description.'</p>';
		$content.=$after;
		$content.='
		';
		
	}
	
	return $content;
}

add_shortcode("nggimages", "nggimages");

?>
