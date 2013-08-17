<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class XiusLoader
{

   static function addAutoLoadFolder($folder, $type, $prefix='Xius')
        {
                foreach(JFolder::files($folder,".php$") as $file )
                {
                        if($file===strtolower('index.html'))
                        	continue;

                        $className      = JString::ucfirst($prefix)
                                          . JString::ucfirst($type)
                                          . JString::ucfirst(JFile::stripExt($file));

                        JLoader::register($className, $folder.DS.$file);
                }
        }

   static function addAutoLoadFile($class,$file)
        {
        	JLoader::register($class, $file);
        }

   static function addAutoLoadViews($baseFolders, $format, $prefix='Xius')
		{
			foreach(JFolder::folders($baseFolders) as $folder )
			{
				//e.g. XiController + Product
				$className 	= JString::ucfirst($prefix)
							. JString::ucfirst('View')
							. JString::ucfirst($folder);

				if($format==='ajax') $format = 'html';
				$fileName	= "view.$format.php";
				JLoader::register($className, $baseFolders.DS.$folder.DS.$fileName);
			}
		}
		
   static function addAutoLoadPluginHelper($pluginPath, $type, $prefix='Xius')
        {
        		$plugins = array();
				$plugins = JFolder::folders(XIUS_PLUGINS_PATH);
				foreach($plugins as $plugin)
                {  
                	$path = $pluginPath.DS.$plugin.DS.strtolower($plugin.'helper.php');
                	if(JFile::exists($path))
                	{
                		$className = JString::ucfirst($prefix)
                                    .JString::ucfirst($type)
                                    .JString::ucfirst(JFile::stripExt($plugin));

                        JLoader::register($className, $path);
                        }
                }
        }
}
