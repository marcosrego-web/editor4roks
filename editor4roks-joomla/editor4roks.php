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
				$e4rVersion = 'v240';
				$rootPath = JPATH_ROOT;
				$rootUrl = JUri::root();
				$pluginUrl = $rootUrl.'plugins/system/editor4roks/';
				$editor4roksContent  = '';
				$editoroption = $this->params->get('editoroption', 1);
				$linksoption = $this->params->get('links4roks', 1);
				$linkstypes = $this->params->get('links');
				$roks4mob = $this->params->get('roks4mob', 1);
				if ( $editoroption != 0 || $editoroption == null) {
					//Default Editor
					$editor = JFactory::getEditor();
					$editor = $editor->display('e4r_textarea', '', '550', '400', '60', '20', true);
				} else {
					//NicEdit Editor
					JHtml::script($pluginUrl.'assets/js/nicEdit.js');
					$editor = '<textarea id="e4r_textarea"></textarea>';
				}
				$filesFolder = "/images";
				$folder = $rootPath.$filesFolder;
				$getFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder), RecursiveIteratorIterator::SELF_FIRST);
				$editor4roksContent = $editor4roksContent.'<datalist id="imagelist">';
					foreach($getFiles as $image){
						if(substr($image, -4) == '.jpg' || substr($image, -5) == '.jpeg' || substr($image, -4) == '.png' || substr($image, -4) == '.gif' || substr($image, -4) == '.JPG' || substr($image, -5) == '.JPEG' || substr($image, -4) == '.PNG' || substr($image, -4) == '.GIF') {
							$image = str_replace($rootPath."/","",$image);
							if ( $editoroption != 0 || $editoroption == null) { } else {
								$image = $rootUrl.$image;
							}
							$imagename = basename($image);
							$editor4roksContent = $editor4roksContent.'<option value="'.$image.'">'.$imagename.'</option>';
						}
					}
				$editor4roksContent = $editor4roksContent.'</datalist>';
				JHtml::stylesheet($pluginUrl.'assets/css/'.$e4rVersion.'.css');
				if ( $roks4mob != 0 || $roks4mob == null) {
					JHtml::stylesheet($pluginUrl.'assets/css/roks4mob_'.$e4rVersion.'.css');
				}
				JHtml::_('jquery.framework');
				JHtml::script($pluginUrl.'assets/js/'.$e4rVersion.'.js');
				//Get links for links4roks and/or for NicEdit
				if ( $editoroption == 0 || $linksoption == 1 || $linksoption == null) {
					$editor4roksContent = $editor4roksContent.'<datalist id="menufilelist">';
					//'Menus' links type
					if(!is_array( $linkstypes ) || in_array(1, $linkstypes)) {
						$menu = JMenu::getInstance('site');
						$allMenuItems = $menu->getItems($attributes = array(), $values = array());
						foreach ($allMenuItems as $menuItem) {
							if (substr($menuItem->link, 0, 4 ) === "http") {
								$editor4roksContent = $editor4roksContent.'<option value="'.$menuItem->link.'">🔗 '.$menuItem->title.'</option>';
							} else if (strpos($menuItem->link, 'Itemid=') !== false || strpos($menuItem->link, '#') !== false) {
								$editor4roksContent = $editor4roksContent.'<option value="'.$menuItem->link.'">📁 <span style="text-transform: capitalize">'.$menuItem->menutype.'</span> - '.$menuItem->title.' (id: '.$menuItem->id.')</option>';
							} else if(substr($menuItem->link, -4) == '.pdf' || substr($menuItem->link, -4) == '.PDF') {
								$editor4roksContent = $editor4roksContent.'<option value="'.$menuItem->link.'>🔗 '.$menuItem->title.'</option>';
							} else {
								$editor4roksContent = $editor4roksContent.'<option value="'.$menuItem->link.'&Itemid='.$menuItem->id.'">📁 <span style="text-transform: capitalize">'.$menuItem->menutype.'</span> - '.$menuItem->title.' (id: '.$menuItem->id.')</option>';
							}
						}
					}
					//'Articles' links type
					if(is_array( $linkstypes ) && in_array(2, $linkstypes)) {
						$db = JFactory::getDbo();     
						$query = $db->getQuery(true);     
						$query->select('*')->from($db->quoteName('#__content'));  
						$db->setQuery($query);
						$articles = $db->loadObjectList();
						foreach ($articles as $article) {
							$editor4roksContent = $editor4roksContent.'<option value="index.php?option=com_content&view=article&id='.$article->id.'">📝 article - '.$article->title.' (id: '.$article->id.')</option>';
						}
					}
					//'Categories' links type
					if(is_array( $linkstypes ) && in_array(3, $linkstypes)) {
						$db = JFactory::getDbo();     
						$query = $db->getQuery(true);     
						$query->select('*')->from($db->quoteName('#__categories'));  
						$db->setQuery($query);
						$categories = $db->loadObjectList();
						foreach ($categories as $category) {
							if($category->id != 1) {
								$editor4roksContent = $editor4roksContent.'<option value="index.php?option=com_content&view=category&id='.$category->id.'">📖 category - '.$category->title.' (id: '.$category->id.')</option>';
							}
						}
					}
					//'Documents' links type
					if(is_array( $linkstypes ) && in_array(4, $linkstypes)) {
						foreach($getFiles as $document){
							if(substr($document, -4) == '.pdf' || substr($document, -4) == '.PDF' || substr($document, -4) == '.doc' || substr($document, -4) == '.DOC' || substr($document, -5) == '.docx' || substr($document, -5) == '.DOCX' || substr($document, -4) == '.xls' || substr($document, -4) == '.XLS' || substr($document, -5) == '.xlsx' || substr($document, -5) == '.XLSX' || substr($document, -4) == '.odt' || substr($document, -4) == '.ODT'|| substr($image, -4) == '.PPT'|| substr($image, -4) == '.ppt') {
								$document = str_replace($rootPath."/","",$document);
								$documentname = basename($document);
								$editor4roksContent = $editor4roksContent.'<option value="'.$document.'">📋 document - '.$documentname.'</option>';
							}
						}
					}
					//'Images' links type
					if(is_array( $linkstypes ) && in_array(5, $linkstypes)) {
						foreach($getFiles as $image){
							if(substr($image, -4) == '.jpg' || substr($image, -5) == '.jpeg' || substr($image, -4) == '.png' || substr($image, -4) == '.gif' || substr($image, -4) == '.JPG' || substr($image, -5) == '.JPEG' || substr($image, -4) == '.PNG' || substr($image, -4) == '.GIF') {
								$image = str_replace($rootPath."/","",$image);
								$imagename = basename($image);
								$editor4roksContent = $editor4roksContent.'<option value="'.$image.'">🖼 image - '.$imagename.'</option>';
							}
						}
					}
					$editor4roksContent = $editor4roksContent. '</datalist>';
					if ( $linksoption == 1 || $linksoption == null) {
						$editor4roksContent = $editor4roksContent.'<div class="linkeditor4roks"><div class="e4r-container"><div class="e4r-content"><div class="menufilelist"></div><input id="e4r-linkarea" placeholder="Search for a menu or insert the link here..." list="menufilelist"></input><div class="e4r-btn-container"><a class="btn btn-primary btn-insert"><small>✔ INSERT</small></a> <a class="btn btn-cancel"><small>✖ CANCEL</small></a></div></div></div></div>';
					}
				}
				if ( $editoroption != 0) {
					$editor4roksContent = $editor4roksContent.'<style>.modal.imagepicker {display: none;}</style><div class="imgeditor4roks"><div class="e4r-container"><div class="e4r-content"><div class="imagelist"></div><input id="e4r-imgarea" placeholder="Search for an image or insert the link here..." list="imagelist"></input><div class="e4r-btn-container"><a class="btn btn-primary btn-insert"><small>✔ INSERT</small></a> <a class="btn btn-cancel"><small>✖ CANCEL</small></a></div></div></div></div>';
				}
				$editor4roksContent = $editor4roksContent.'<div class="editor4roks"><div class="e4r-container"><div class="e4r-content"><div class="e4r-txt-container">'.$editor.'<div class="e4r-btn-container"><a class="btn btn-primary btn-insert"><small>✔ INSERT</small></a> <a class="btn btn-cancel"><small>✖ CANCEL</small></a></div></div></div></div>';
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
