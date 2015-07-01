<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');


/* for blue template */ 
if($params->get('xius_color', 'blue')=="blue"){
	$border = '#BECFE3'; 
	$color = '#2A65A6';
	$background = '#E7EEF5';
	$globeimage = JURI::base().'modules/mod_xiusproximity/css/globe.png';
}
else{
	/* for gray template */
	$border = '#CFCFCF';
	$color = '#5F5F5F';
	$background = '#EFEFEF';
	$globeimage = JURI::base().'modules/mod_xiusproximity/css/grayglobe.png';
}
?>
<style type="text/css">


div#xiusProximity div#xiusKeyword{
	color:<?php echo $color; ?>;
	margin-top:20px;	
}

div#xiusProximity div#xiusKeyword input{
	border:1px solid <?php echo $border; ?>;
	color:<?php echo $color; ?>;
	width:66%;
	margin-left:4px;
}


div#xiusProximity div#proximityHtml{
	color:<?php echo $color; ?>;
}

div#xiusProximity div#proximityHtml input#xiusDistanceInput{
	border:1px solid <?php echo $border; ?>;
	color:<?php echo $color; ?>;
}

div#xiusProximity div#proximityHtml input#xiusDistance {	
	border:0px;
    background:transparent;
	color:<?php echo $color; ?>;
	margin-left:8px;
}

div#xiusProximity div#xiusProxiMap a{
	color:<?php echo $color; ?>;
}

div#xiusProximity div#proximityHtml input#xiusAddress{
	border:1px solid <?php echo $border; ?>;
	color:<?php echo $color; ?>;
}	

div#xiusProximity div#searchButton input{
	-moz-box-shadow:0 1px 0 0 #FFFFFF inset;
	-webkit-box-shadow:0 1px 0 0 #FFFFFF inset;
	background:<?php echo $background; ?> url("<?php echo $globeimage ;?>") no-repeat scroll 5px 2px;
	border:1px solid <?php echo $border; ?>;
	color:<?php echo $color; ?>;
	border-radius:5px;
	font-family:"lucida grande",sans-serif;
	font-size:14px;
	font-weight:normal;
	padding:5px 0 6px 25px;
	text-align:center;
	width:100px;
}

div#xiusProximity .xius-margin{
	margin-top:5px;
}

div#xiusProximity input{
	width:90%;
}
</style>