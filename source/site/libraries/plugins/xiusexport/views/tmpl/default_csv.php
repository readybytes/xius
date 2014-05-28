<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

	header('Content-type: application/csv');
	header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=user.csv");
   
	if(!empty($this->users)) :
		echo XiusText::_('USERID');
		if(!empty($this->fields))	:
			foreach($this->fields as $f)	:
				echo XIUSEXPORT_DELIMITER.$f;
			endforeach;
		endif;
		foreach($this->users as $u)	:
			$cuser = CFactory::getUser($u->userid);
			echo XIUSEXPORT_NEW_LINE_DELIMITER.$u->userid;
			 if(!empty($this->userprofile)) :
				foreach($this->userprofile[$u->userid] as $up) :
					echo XIUSEXPORT_DELIMITER.$up['value'];
				endforeach;
 			endif;
		endforeach;
	endif;
