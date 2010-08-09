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

        function addAutoLoadFolder($folder, $type, $prefix='Xius')
        {
                foreach(JFolder::files($folder) as $file )
                {
                        if($file===strtolower('index.html'))
                        	continue;
                      
                        $className      = JString::ucfirst($prefix)
                                                . JString::ucfirst($type)
                                                . JString::ucfirst(JFile::stripExt($file));
                        
                        JLoader::register($className, $folder.DS.$file);
                }
        }
        
        function addAutoLoadFile($class,$file)
        {
        	JLoader::register($class, $file);
        }
}
