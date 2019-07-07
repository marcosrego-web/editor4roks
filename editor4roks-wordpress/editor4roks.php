<?php

 /*

	Plugin Name: editor4roks

	Plugin URI:  https://marcosrego.com/en/web-en/editor4roks-en/

	Description: Adds the WYSIWYG HTML Editor to the custom descriptions of your Roksprocket widgets. With editor4roks the descriptions will be easier to edit and the links easier to put directly on the widgets.

	Version:     2.3.0

	Author:      Marcos Rego

	Author URI:  https://marcosrego.com

	License:     GNU Public License version 2 or later

	License URI: http://www.gnu.org/licenseses/gpl-2.0.html

*/

/* Copyright 2019 editor4roks by Marcos Rego (email : web@marcosrego.com)

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

	'https://raw.githubusercontent.com/marcosrego-web/editor4roks/master/updates/wordpress-updates.json',__FILE__,'editor4roks'

);

/*SETTINGS PAGE*/

function e4r_add_admin_menu(  ) { 

	add_options_page( 'editor4roks', 'editor4roks', 'manage_options', 'editor4roks', 'e4r_options_page' );

}

function e4r_settings_init(  ) { 

	register_setting( 'pluginPage', 'e4r_settings' );

	add_settings_section('e4r_pluginPage_section', __( 'Settings', 'editor4roks' ), 'e4r_settings_section_callback', 'pluginPage');

	add_settings_field( 'e4r_select_field_0', __( 'Editor', 'editor4roks' ), 'e4r_select_field_0_render', 'pluginPage', 'e4r_pluginPage_section' );

	add_settings_field( 'e4r_select_field_2', __( 'links4roks', 'editor4roks' ), 'e4r_select_field_2_render', 'pluginPage', 'e4r_pluginPage_section' );

	add_settings_field( 'e4r_select_field_3', __( 'Links', 'editor4roks' ), 'e4r_select_field_3_render', 'pluginPage', 'e4r_pluginPage_section' );

	add_settings_field( 'e4r_select_field_1', __( 'roks4mob', 'editor4roks' ), 'e4r_select_field_1_render', 'pluginPage', 'e4r_pluginPage_section' );

}

/*SETTINGS PAGE OPTIONS*/

function e4r_select_field_0_render(  ) { 

	$options = get_option( 'e4r_settings' );

	?>

	<select class="widefat" name='e4r_settings[e4r_select_field_0]'>

		<option <?php selected( $options['e4r_select_field_0'], 1 ); ?> value='1'>Wordpress Default</option>

		<option <?php selected( $options['e4r_select_field_0'], 2 ); ?> value='2'>NicEdit</option>

	</select>

<?php

}

function e4r_select_field_2_render(  ) { 

	$options = get_option( 'e4r_settings' );

	?>

	<select class="widefat" name='e4r_settings[e4r_select_field_2]' title="">

		<option <?php selected( $options['e4r_select_field_2'], 1 ); ?> value='1'>Enabled</option>

		<option <?php selected( $options['e4r_select_field_2'], 2 ); ?> value='2'>Disabled</option>

	</select>

	<p><em>When enabled, the edit button will also appear next to the custom links inputs to easily select an existing link.</em></p>

<?php

}

function e4r_select_field_3_render(  ) { 

	$options = get_option( 'e4r_settings' );

	$linkstypes = $options['e4r_select_field_3'];

	?>

	

	<label><input type="checkbox" name="e4r_settings[e4r_select_field_3][]" value="1" <?php if(is_array( $linkstypes )) { checked( ( is_array( $linkstypes ) AND in_array( "1", $linkstypes ) ) ? "1" : '', "1" ); } else { echo 'checked="checked"'; } ?>>Menus<br></label>

	<label><input type="checkbox" name="e4r_settings[e4r_select_field_3][]" value="2" <?php checked( ( is_array( $linkstypes ) AND in_array( "2", $linkstypes ) ) ? "2" : '', "2" ); ?>>Posts<br></label>

	<label><input type="checkbox" name="e4r_settings[e4r_select_field_3][]" value="3" <?php checked( ( is_array( $linkstypes ) AND in_array( "3", $linkstypes ) ) ? "3" : '', "3" ); ?>>Categories<br></label>

	<p><em>Choose which type of links should appear when the editor NicEdit or links4roks is enabled.</em></p>

<?php

}

function e4r_select_field_1_render(  ) { 

	$options = get_option( 'e4r_settings' );

	?>

	<select class="widefat" name='e4r_settings[e4r_select_field_1]' title="">

		<option <?php selected( $options['e4r_select_field_1'], 1 ); ?> value='1'>Enabled</option>

		<option <?php selected( $options['e4r_select_field_1'], 2 ); ?> value='2'>Disabled</option>

	</select>

	<p><em>When enabled, Roksprocket's layout will be more friendly on mobile devices.</em></p>

<?php

}

function e4r_settings_section_callback(  ) { 

	echo __( '', 'editor4roks' );

}

function e4r_options_page(  ) { 

	?>

	<form action='options.php' method='post'>

		<h1>editor4roks</h1>

		<p>Adds the WYSIWYG HTML Editor to the custom descriptions of your Roksprocket widgets. With editor4roks the descriptions will be easier to edit and the links easier to put directly on the widgets.</p>

		<p>

		<a href="https://marcosrego.com/en/web-en/editor4roks-en/" target="_blank" class="button">editor4roks</a>

		<a href="http://www.rockettheme.com/joomla/extensions/roksprocket" target="_blank" class="button">Roksprocket on RocketTheme website</a>

		<a href="http://nicedit.com/" target="_blank" class="button">NicEdit editor website</a>

		</p><br>

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

function e4r_add_action_plugin( $actions, $plugin_file ) {

	static $plugin;

	if (!isset($plugin))

		$plugin = plugin_basename(__FILE__);

	if ($plugin == $plugin_file) {

			$settings = array('settings' => '<a href="'.admin_url( 'options-general.php?page=editor4roks' ).'">' . __('Settings', 'General') . '</a>');

    		$actions = array_merge($settings, $actions);

		}

		return $actions;

}

add_filter( 'plugin_action_links', 'e4r_add_action_plugin', 10, 5 );

/*EDITOR4ROKS*/

$url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];



if (strpos($url,'roksprocket-list') !== false) {

	function add_files() {

		$e4rVersion = 'v230';

		if ( $roks4mob != 2 || $roks4mob == null) {

			wp_enqueue_style( 'r4m_css', plugins_url( 'assets/css/roks4mob_'.$e4rVersion.'.css', __FILE__ ));

		}

	}

	add_action('admin_head', 'add_files');

}

if (strpos($url,'roksprocket-edit') !== false) {

	function add_files() {

		$e4rVersion = 'v230';

		$options = get_option( 'e4r_settings' );

		$roks4mob = $options['e4r_select_field_1'];

		wp_enqueue_style( 'e4r_css', plugins_url( 'assets/css/'.$e4rVersion.'.css', __FILE__ ));

		if ( $roks4mob != 2 || $roks4mob == null) {

			wp_enqueue_style( 'r4m_css', plugins_url( 'assets/css/roks4mob_'.$e4rVersion.'.css', __FILE__ ));

		}

		wp_register_script( 'e4r_js', plugins_url( 'assets/js/'.$e4rVersion.'.js', __FILE__ ), array('jquery'));

		wp_enqueue_script( 'e4r_js' );

	}

	function add_html() {

		$options = get_option( 'e4r_settings' );

		$editoroption = $options['e4r_select_field_0'];

		$linksoption = $options['e4r_select_field_2'];

		$linkstypes = $options['e4r_select_field_3'];



		$menus = get_terms( 'nav_menu');

		$rootPath = get_home_path();

		$rootUrl = get_home_url();

		$folder = $rootPath.$filesFolder;

		$getFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder), RecursiveIteratorIterator::SELF_FIRST);



		//Get links for links4roks and/or for NicEdit

		if ( $editoroption == 2 || $linksoption == 1 || $linksoption == null) {

			echo '<datalist id="menufilelist">';



			//'Menus' links type

			if(!is_array( $linkstypes ) || in_array(1, $linkstypes)) {

				foreach ($menus as $menu) {

					$allMenuItems = wp_get_nav_menu_items( $menu );

					foreach ($allMenuItems as $menuItem) {

						echo '<option value="'.$menuItem->url.'">📁 menu <span style="text-transform: lowercase">'.$menu->name.'</span> - '.$menuItem->title.'</option>';

					}

				}

				foreach($getFiles as $file){

					if(substr($file, -4) == '.pdf' || substr($file, -4) == '.PDF') {

						$file = str_replace($rootPath,"",$file);

						$filename = basename($file);

						echo '<option value="'.$file.'">📄 '.$filename.'</option>';

					}

				}

			}



			//'Posts' links type

			if(is_array( $linkstypes ) && in_array(2, $linkstypes)) {

				$postlist = get_posts(array('numberposts'=>-1));



				if ( ! empty( $postlist ) ) {

					foreach ( $postlist as $key => $post) {

						echo '<option value="'.get_permalink($post->ID).'">📝 post - '.$post->post_title.' (id: '.$post->ID.')</option>';

					}

				}

			}



			//'Categories' links type

			if(is_array( $linkstypes ) && in_array(3, $linkstypes)) {

				$catlist = get_terms('category');

				if ( ! empty( $catlist ) ) {

					foreach ( $catlist as $key => $category) {

						echo '<option value="'.get_category_link($category->term_id).'">📖 category - '.$category->name.' (id: '.$category->term_id.')</option>';

					}

				}

			}

			echo '</datalist>';



			if ( $linksoption == 1 || $linksoption == null) {

				echo '<div class="linkeditor4roks"><div class="e4r-container"><div class="e4r-content"><div class="menufilelist"></div><input id="e4r-linkarea" placeholder="Search for a menu or insert the link here..." list="menufilelist"></input><div class="e4r-btn-container"><a class="btn btn-primary btn-insert"><small>✔ INSERT</small></a> <a class="btn btn-cancel"><small>✖ CANCEL</small></a> </div></div></div></div>';

			}

		}

		echo '<div class="editor4roks"><div class="e4r-container"><div class="e4r-content"><div class="e4r-txt-container"><textarea id="e4r-textarea"></textarea><div class="e4r-btn-container"><a class="btn btn-primary btn-insert"><small>✔ INSERT</small></a> <a class="btn btn-cancel"><small>✖ CANCEL</small></a></div></div></div></div>';

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

					echo '<option value="'.$rootUrl.$image.'">🖼 '.$imagename.'</option>';

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
