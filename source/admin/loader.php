<?php
defined('_JEXEC') or die();

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
