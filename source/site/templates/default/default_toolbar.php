<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

require_once XIUS_COMPONENT_PATH_SITE.DS.'elements'.DS.'limit.php';
?>
<div class = "xiusToolbar">
<?php
foreach($this->xiusToolbar as $tool)
	echo $tool->value;

?><div class="xiusTbRight">
				<?php
				if(!empty($this->sortableFields))	:
					$html = '<select id="xiussort" name="xiussort" onchange="xiusApplySort(\'sort\');" >';
					foreach($this->sortableFields as $sfields)	:
						$selected = '';
						if($this->sort == $sfields['key']):
							$selected = ' selected=true ';
						endif;

						$html .= '<option value='.$sfields['key'].$selected.'>'.$sfields['value'];
						$html .= '</option>';
					endforeach;
					$html .= '</select>';
					echo $html;

					$ascselected = '';
					$descselected = '';
					if($this->dir == 'ASC')	:
						$ascselected = ' selected=true ';
					elseif($this->dir == 'DESC')	:
						$descselected = ' selected=true ';
					endif;

					$dirhtml = '<select id="xiussortdir" name="xiussortdir" onchange="xiusApplySort(\'sortdir\');" >';
					$dirhtml .= '<option value="ASC" '.$ascselected.'>'.XiusText::_('ASC').'</option>';
					$dirhtml .= '<option value="DESC" '.$descselected.'>'.XiusText::_('DESC').'</option>';
					$dirhtml .= '</select>';

					echo $dirhtml;
				endif;
                //set the default limit for search result
				$mainframe  	= JFactory::getApplication();
				$limit 			= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
				$limitObject 	= new JElementLimit;
				echo $limitObject->fetchElement('limit',$limit);
?>
	</div>
</div>
