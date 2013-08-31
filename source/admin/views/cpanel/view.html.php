<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');


class XiusViewCpanel extends XiusView 
{

	function display( $tpl = null )
	{
		parent::display( $tpl );
	}

	function addIcon( $image , $url , $text , $newWindow = false )
	{
		$lang		= JFactory::getLanguage();
		
		$newWindow	= ( $newWindow ) ? ' target="_blank"' : '';
		?>
		<div class="xiusAdminCPanel" style="text-align:center; float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>; ">
			<a href="<?php echo $url; ?>"<?php echo $newWindow; ?>>
			<div class="icon">
				<?php echo JHTML::_('image', 'components/com_xius/assets/images/' . $image , $text ); ?>
			</div>
			<div><?php echo $text; ?></div>
			</a>
		</div>
		<?php
	}
	
	
	function updates($tpl = null)
	{
		parent::display( $tpl);
	}

}
?>