<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');
?>
<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5;"><?php 
				//echo $this->pane->startPane( 'stat-pane1' );
				require_once 'welcome.php';
				//echo $this->pane->endPanel();
				?>
</div>
<table>
		<tr>
				<td width="50%" valign="top">
				<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5;"><?php 
				//echo $this->pane->startPane( 'stat-pane1' );
				require_once 'news.php';
				//echo $this->pane->endPanel();
				?>
				</div>
				</td>
				<td width="50%" valign="top">
				<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5;" ><?php
				//echo $this->pane->startPane( 'stat-pane2' );
				require_once 'updates.php';
				//echo $this->pane->endPanel();
				?>
				</div>
			</td>
			</tr>
		</table>