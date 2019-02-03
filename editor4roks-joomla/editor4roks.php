<?php
/**
 * editor4roks
 *
 * @author Marcos Rego (web@marcosrego.com)
 * @license GNU Public License version 2 or later
 * @link https://marcosrego.com
 */

defined('_JEXEC') or die;

$app = JFactory::getApplication();
if($app->isAdmin()) {
	class PlgSystemEditor4roks extends JPlugin {
		protected $app;
		
		public function onAfterDispatch() {
			global $url;
			global $editor4roksContent;
			
			$url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			$editor4roksContent  = '';
			
			if (strpos($url,'com_roksprocket') !== false) {
				$rootPath = JPATH_ROOT;
				$rootUrl = JUri::root();
				$pluginUrl = $rootUrl.'plugins/system/editor4roks/';
				$doc = JFactory::getDocument();
				$doc->addScript( $pluginUrl.'nicEdit/nicEdit.js');
				$doc->addScript( $pluginUrl.'editor4roks.js');
				$doc->addStyleSheet( $pluginUrl.'e4r-style.css');
				
				$editor4roksContent  = '';
				
				$menu = JMenu::getInstance('site');
				$allMenuItems = $menu->getItems($attributes = array(), $values = array());
				
				$menu = JMenu::getInstance('site');
				$allMenuItems = $menu->getItems($attributes = array(), $values = array());
				$folder = $rootPath.$filesFolder;
				$getFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder), RecursiveIteratorIterator::SELF_FIRST);
					
				$editor4roksContent = $editor4roksContent.'<datalist id="menufilelist">';
					foreach ($allMenuItems as $menuItem) {
						if (substr($menuItem->link, 0, 4 ) === "http") {
							$editor4roksContent = $editor4roksContent.'<option value="'.$menuItem->link.'">🔗 Link - '.$menuItem->title.'</option>';
						} else if (strpos($menuItem->link, 'Itemid=') !== false || strpos($menuItem->link, '#') !== false) {
							$editor4roksContent = $editor4roksContent.'<option value="'.$menuItem->link.'">📁 <span style="text-transform: capitalize">'.$menuItem->menutype.'</span> - '.$menuItem->title.' (id: '.$menuItem->id.')</option>';
						} else if(substr($menuItem->link, -4) == '.pdf' || substr($menuItem->link, -4) == '.PDF') {
							$editor4roksContent = $editor4roksContent.'<option value="'.$menuItem->link.'">📁 📄 Menu to File - '.$menuItem->title.'</option>';
						} else {
							$editor4roksContent = $editor4roksContent.'<option value="'.$menuItem->link.'&Itemid='.$menuItem->id.'">📁 <span style="text-transform: capitalize">'.$menuItem->menutype.'</span> - '.$menuItem->title.' (id: '.$menuItem->id.')</option>';
						}
					}
				$editor4roksContent = $editor4roksContent. '</datalist>';
					
					$editor4roksContent = $editor4roksContent.'<div class="linkeditor4roks"><div class="e4r-container"><div class="e4r-content"><input id="e4r-linkarea" placeholder="Search here for a menu or insert the link..." list="menufilelist"></input><div class="e4r-btn-container"><a class="btn btn-primary btn-insert"><small>✔ INSERT</small></a> <a class="btn btn-cancel"><small>✖ CANCEL</small></a></div></div></div></div>';	
				
				$editor = JFactory::getEditor();

				$editor4roksContent = $editor4roksContent.'<div class="editor4roks"><div class="e4r-container"><div class="e4r-content"><div class="e4r-txt-container">'.$editor->display('e4r-textarea', '', '550', '400', '60', '20', false).'<div class="e4r-btn-container"><a class="btn btn-primary btn-insert"><small>✔ INSERT</small></a> <a class="btn btn-cancel"><small>✖ CANCEL</small></a></div></div></div></div>';
			}
		}
		
		public function onAfterRender() {
			global $url;
			global $editor4roksContent;
			
			if (strpos($url,'com_roksprocket') !== false) {
				$body = $this->app->getBody();
				$body = str_replace('</body>', $editor4roksContent.'</body>', $body );
				$this->app->setBody($body);
			}
		}
	}
}