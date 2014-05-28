<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');


class XiusViewCpanel extends XiusView 
{

	protected $_name = 'cpanel';

	function display( $tpl = null )
	{
		parent::display( $tpl );
	}

	function addIcon( $image , $url , $text , $newWindow = false )
	{
		$lang		= JFactory::getLanguage();
		
		$newWindow	= ( $newWindow ) ? ' target="_blank"' : '';
		?>
		<div class="xiusAdminCPanel" style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>; ">
			<a href="<?php echo $url; ?>"<?php echo $newWindow; ?>>
			<div>
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

	function setToolBar()
	{
		JToolBarHelper::help('JHELP_COMPONENTS_JOOMLA_UPDATE',false,"http://www.joomlaxi.com/support/documentation/category/joomlaxi-user-search.html");
	}
}
?>
