<?php

 /*
	Plugin Name: editor4roks
	
	Plugin URI:  https://marcosrego.com/en/web-en/editor4roks-en/

	Description: Adds the WYSIWYG HTML Editor to the custom descriptions of your Roksprocket widgets. With editor4roks the descriptions will be easier to edit and the links easier to put directly on the widgets.

	Version:     2.0.1

	Author:      Marcos Rego

	Author URI:  https://marcosrego.com

	License:     GNU Public License version 2 or later

	License URI: http://www.gnu.org/licenseses/gpl-2.0.html

*/

/* Copyright 2018 editor4roks by Marcos Rego (email : web@marcosrego.com)
editor4roks is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
editor4roks is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with editor4roks. If not, see http://www.gnu.org/licenseses/gpl-2.0.html.

*/

defined('ABSPATH') or die;

require 'update/plugin-update-checker.php';

$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://marcosrego.com/web/editor4roks/wordpress-updates.json',__FILE__,'editor4roks'
);

$url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

if (strpos($url,'roksprocket-edit') !== false) {
	function add_files() {
		
		echo '<link rel="stylesheet" href="'. plugins_url( 'e4r-style_v201.css', __FILE__ ) .'" type="text/css" /><script type="text/javascript" src="'. plugins_url( 'editor4roks_v201.js', __FILE__ ) .'"></script>';

	}

	function add_html() {
		$menus = get_terms( 'nav_menu');
		$rootPath = get_home_path();
		$rootUrl = get_home_url();
		$folder = $rootPath.$filesFolder;
		$getFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder), RecursiveIteratorIterator::SELF_FIRST);

			echo '<datalist id="menufilelist">';

			foreach ($menus as $menu) {
				$allMenuItems = wp_get_nav_menu_items( $menu );
				foreach ($allMenuItems as $menuItem) {
					echo '<option value="'.$menuItem->url.'">📁 <span style="text-transform: capitalize">'.$menu->name.'</span> - '.$menuItem->title.'</option>';
				}
			}

			foreach($getFiles as $file){
				if(substr($file, -4) == '.pdf' || substr($file, -4) == '.PDF') {
					$file = str_replace($rootPath,"",$file);
					$filename = basename($file);
					echo '<option value="'.$file.'">📄 File - '.$filename.'</option>';
				}
			}

			echo '</datalist>';

		echo '<div class="linkeditor4roks"><div class="e4r-container"><div class="e4r-content"><input id="e4r-linkarea" placeholder="Search here for a menu or insert the link..." list="menufilelist"></input><div class="e4r-btn-container"><a class="btn btn-primary btn-insert"><small>✔ INSERT</small></a> <a class="btn btn-cancel"><small>✖ CANCEL</small></a> </div></div></div></div>';

		echo '<div class="editor4roks"><div class="e4r-container"><div class="e4r-content"><div class="e4r-txt-container"><textarea id="e4r-textarea"></textarea><div class="e4r-btn-container"><a class="btn btn-primary btn-insert"><small>✔ INSERT</small></a> <a class="btn btn-cancel"><small>✖ CANCEL</small></a></div></div></div></div>';

		wp_editor( $content, 'e4r-textarea' );
	}
	add_action('admin_head', 'add_files');
	add_action('admin_footer', 'add_html');
}

?>
