<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
$script = "function xiusCheckUserSelected(){
			var flag = false;
    		for (var i = 0; true; i++) {
	    		var str = 'xiusCheckUser' + i;
	    		var cbx = document.getElementById(str);
	    		if (!cbx) break;
	        	if(cbx.checked == true)
		           	flag = true;
		        } // for
    		var a = document.getElementById('xius_emailselected_button');
    		if(flag==false){	
    			a.href+='&selected=no';
    			return false;
    		}   
    		a.href+='&selected=yes';
    		return true;    			
    	}";

$document =& JFactory::getDocument();        				
$document->addScriptDeclaration($script);

?>
<a 
	id="<?php echo $this->buttonMapSel->modalname; ?>" 
	class="<?php echo $this->buttonMapSel->modalname; ?>"
	title="<?php echo $this->buttonMapSel->text; ?>" 
	href="<?php echo $this->buttonMapSel->link; ?>"
	rel="<?php echo $this->buttonMapSel->options; ?>" 
	onClick="return xiusCheckUserSelected()"
>
       	<img 
			src="<?php echo JURI::base().'components/com_xius/assets/images/emailselected.png'; ?>" 
    		title="<?php echo XiusText::_("XIUS EMAIL TO SELECTED"); ?>" 
		/>
</a>
<?php  
