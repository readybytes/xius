<?php

//get all plugins
$plugins = XiusHelperUtils::getAvailablePlugins();
// Auto load all plugins
foreach($plugins as $pluginDetails)
{
	$plugin = $pluginDetails['name'];
	$path	= XIUS_PLUGINS_PATH.DS.$plugin;
		
	if( $plugin == 'jsfields'){
		JLoader::register(JString::ucfirst($plugin), $path.DS.$plugin.'20.php');
		JLoader::register(JString::ucfirst($plugin), $path.DS.$plugin.'18.php');
	}
	else 
		JLoader::register(JString::ucfirst($plugin), $path.DS.$plugin.'.php');
	
	// autoload view
	JLoader::register(JString::ucfirst($plugin).'View', $path.DS.$plugin.DS.'views'.DS.'view.html.php');
	
	if(JFile::exists($path.DS.$plugin.'helper.php'))
	{
		JLoader::register(JString::ucfirst($plugin).'helper', $path.DS.$plugin.'helper.php');	
	}

	if(JFile::exists($path.DS.'helper.php'))
	{
		JLoader::register(JString::ucfirst($plugin).'Helper', $path.DS.'helper.php');	
	}
	
}

	$path	= XIUS_PLUGINS_PATH.DS;
	
	//CustomTable element
  	JLoader::register('JElementTablecolumns', $path.DS.'customtable/elements/tablecolumns.php');
  	//base element
  	JLoader::register('JsfieldsBase', $path.DS.'jsfields/base.php');
  	//profiletype
  	JLoader::register('ProfiletypesHelper', $path.DS.'jsfields/profiletype.php');
  	
  	//for proxmity plugin 
  	JLoader::register('XiusPluginControllerProximity', $path.DS.'proximity/controller.php');
  	JLoader::register('ProximityGoogleapiHelper', $path.DS.'proximity/googleapihelper.php');
  	JLoader::register('XiusGmap', $path.DS.'proximity/googlemaphelper.php');
  	//encoder classses
 	JLoader::register('ProximityDatabaseEncoder', $path.DS.'proximity/encoders/database.php');
  	JLoader::register('XiusProximityEncoder', $path.DS.'proximity/encoders/encoder.php');
    JLoader::register('ProximityGoogleEncoder', $path.DS.'proximity/encoders/google.php');
    JLoader::register('ProximityInformationEncoder', $path.DS.'proximity/encoders/information.php');
    
   //load elements 
   $path = XIUS_COMPONENT_PATH_SITE.DS .'elements';
   JLoader::register('JElementXiusJoomlaUserGroup', $path.DS.'xiusJoomlaUserGroup.php');
   JLoader::register('JElementInfo', $path.DS.'info.php');
   JLoader::register('JElementXiuslist', $path.DS.'xiuslist.php');
   JLoader::register('JElementXiusTemplates', $path.DS.'xiusTemplates.php');
 