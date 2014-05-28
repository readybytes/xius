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
div#xiusProximity div,
div#xiusProximity dl,
div#xiusProximity dt,
div#xiusProximity dd,
div#xiusProximity ul,
div#xiusProximity ol,
div#xiusProximity li,
div#xiusProximity h1,
div#xiusProximity h2,
div#xiusProximity h3,
div#xiusProximity h4,
div#xiusProximity h5,
div#xiusProximity h6,
div#xiusProximity pre,
div#xiusProximity form,
div#xiusProximity fieldset,
div#xiusProximity input,
div#xiusProximity textarea,
div#xiusProximity p,
div#xiusProximity blockquote,
div#xiusProximity th,
div#xiusProximity td {
	margin: 0px;
	padding: 0px;
}

div#xiusProximity {
	overflow:hidden;
}

div#xiusProximity div#xiusKeyword{
	float:left;
	color:<?php echo $color; ?>;
   margin:3px 15px 0px 0px;
}

div#xiusProximity div#keywordHtml{
	margin-left:20px;
	float:left;
}

div#xiusProximity div#keywordHtml input{
	width:110px;
	border:1px solid <?php echo $border; ?>;
	font-size: 16px;
	color:<?php echo $color; ?>;
	padding:2px;
}

div#xiusProximity div#proximityDiv{
	float:left;
}

div#xiusProximity div#proximityHtml{
	color:<?php echo $color; ?>;
	overflow: hidden;
	margin-top:3px;
}

div#xiusProximity div#proximityHtml input{
}

	
div#xiusProximity div#xiusProxiDistance {
	float:left;
	margin-left: 5px;
	font-size: 15px;
}

div#xiusProximity div#proximityHtml input#xiusDistanceInput{
	width:40px;
	border:1px solid <?php echo $border; ?>;
	font-size: 16px;
	color:<?php echo $color; ?>;
	padding:2px;
	margin-left:5px;
}

div#xiusProximity div#proximityHtml input#xiusDistance {
	width:40px;
	border:0px;
    background:transparent;
	font-size: 14px;
	color:<?php echo $color; ?>;
}

div#xiusProximity div#proximityHtml div#xiusProxiMap{
	margin-top: 4px;
    margin-left: 17px;
    float:left;
}

div#xiusProximity div#xiusProxiMap a{
	color:<?php echo $color; ?>;
	font-size: 15px;
}

div#xiusProximity div#xiusProxiAddress{
	float: left;
	width:100px;
	margin: 5px 0 5px 17px;
	
}

div#xiusProximity div#proximityHtml input#xiusAddress{
	border:1px solid <?php echo $border; ?>;
	font-size: 16px;
	color:<?php echo $color; ?>;
	padding:2px;
	width:110px;
}	

div#xiusProximity div#xiusProxiLocation{
	float:left;
	margin: 5px 0 5px 17px;
}

div#xiusProximity div#searchButton{
	float:left;
	width: 112px;
}
	
div#xiusProximity div#searchButton input{
	-moz-box-shadow:0 1px 0 0 #FFFFFF inset;
	-webkit-box-shadow:0 1px 0 0 #FFFFFF inset;
	background:<?php echo $background; ?> url("<?php echo $globeimage ;?>") no-repeat scroll 5px 2px;
	border:1px solid <?php echo $border; ?>;
	color:<?php echo $color; ?>;
	font-family:"lucida grande",sans-serif;
	font-size:14px;
	font-weight:normal;
	line-height:1;
	padding:5px 0 6px 20px;
	text-align:center;
	width:110px;
}

div#xiusProximity div#xiusProxiError{
	color:red;
}
div#xiusProximity .float-left{
	float:left;
}
div#xiusProximity input[type="submit"] {
	cursor:pointer;
}
</style>