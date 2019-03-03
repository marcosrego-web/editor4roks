<?php

 /*
	Plugin Name: editor4roks
	
	Plugin URI:  https://marcosrego.com/en/web-en/editor4roks-en/

	Description: Adds the WYSIWYG HTML Editor to the custom descriptions of your Roksprocket widgets. With editor4roks the descriptions will be easier to edit and the links easier to put directly on the widgets.

	Version:     2.1.0

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

/*UPDATER*/
require 'update/plugin-update-checker.php';

$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://marcosrego.com/web/editor4roks/wordpress-updates.json',__FILE__,'editor4roks'
);

/*SETTINGS PAGE*/
function e4r_add_admin_menu(  ) { 

	add_options_page( 'editor4roks', 'editor4roks', 'manage_options', 'editor4roks', 'e4r_options_page' );
}

function e4r_settings_init(  ) { 

	register_setting( 'pluginPage', 'e4r_settings' );

	add_settings_section(
		'e4r_pluginPage_section', 
		__( 'Settings', 'editor4roks' ), 
		'e4r_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'e4r_select_field_0', 
		__( 'Editor', 'editor4roks' ), 
		'e4r_select_field_0_render', 
		'pluginPage', 
		'e4r_pluginPage_section' 
	);

}

/*SETTINGS PAGE OPTIONS*/
function e4r_select_field_0_render(  ) { 
	$options = get_option( 'e4r_settings' );
	
	?>
	<select class="widefat" name='e4r_settings[e4r_select_field_0]'>
		<option <?php selected( $options['e4r_select_field_0'], 1 ); ?> value='1'>Default</option>
		<option <?php selected( $options['e4r_select_field_0'], 2 ); ?> value='2'>NicEdit</option>
	</select>

<?php
}

function e4r_settings_section_callback(  ) { 
	echo __( '', 'editor4roks' );
}

function e4r_options_page(  ) { 

	?>
	<form action='options.php' method='post'>

		<h2>editor4roks</h2>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
	<?php

}
add_action( 'admin_menu', 'e4r_add_admin_menu' );
add_action( 'admin_init', 'e4r_settings_init' );


/*EDITOR4ROKS*/
$url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

if (strpos($url,'roksprocket-edit') !== false) {
	function add_files() {
		$e4rVersion = 'v210';
		
		wp_enqueue_style( 'e4r_css', plugins_url( 'assets/css/'.$e4rVersion.'.css', __FILE__ ));
		
		wp_register_script( 'e4r_js', plugins_url( 'assets/js/'.$e4rVersion.'.js', __FILE__ ), array('jquery'));
		wp_enqueue_script( 'e4r_js' );
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

		$options = get_option( 'e4r_settings' );
		$editoroption = $options['e4r_select_field_0'];
		
		if ( $editoroption != 2 || $editoroption == null) {
			//Default Editor
			wp_editor( $content, 'e4r-textarea' );
		} else {
			//NicEdit Editor
			$filesFolder = "/wp-content/uploads";
			$folder = $rootPath.$filesFolder;
			$getFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder), RecursiveIteratorIterator::SELF_FIRST);
			
			echo '<datalist id="imagelist">';

			foreach($getFiles as $image){
				if(substr($image, -4) == '.jpg' || substr($image, -5) == '.jpeg' || substr($image, -4) == '.png' || substr($image, -4) == '.gif' || substr($image, -4) == '.JPG' || substr($image, -5) == '.JPEG' || substr($image, -4) == '.PNG' || substr($image, -4) == '.GIF') {
					$image = str_replace($rootPath,"",$image);
					$imagename = basename($image);
					echo '<option value="'.$rootUrl.$image.'">🖼 Image - '.$imagename.'</option>';
				}
			}

			echo '</datalist>';
			wp_register_script( 'nicEdit', plugins_url( 'assets/js/nicEdit.js', __FILE__ ));
			wp_enqueue_script( 'nicEdit' );
		}
	}
	add_action('admin_head', 'add_files');
	add_action('admin_footer', 'add_html');
}


?>
