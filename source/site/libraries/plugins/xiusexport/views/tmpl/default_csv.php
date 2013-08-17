<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
	header('Content-type: application/csv');
	header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=user.csv");
   
	if(!empty($this->users)) :
		echo XiusText::_('USERID');
		if(!empty($this->fields))	:
			foreach($this->fields as $f)	:
				echo ' , '.$f;
			endforeach;
		endif;
		foreach($this->users as $u)	:
			$cuser = CFactory::getUser($u->userid);
			echo "\n".$u->userid;
			 if(!empty($this->userprofile)) :
				foreach($this->userprofile[$u->userid] as $up) :
					echo ','.$up['value'];
				endforeach;
 			endif;
		endforeach;
	endif;
