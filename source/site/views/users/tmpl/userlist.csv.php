<?php
	header('Content-type: application/csv');
	header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename='user.csv");
	if(!empty($this->users)) : 
		echo JText::_('Userid');
		if(!empty($this->fields))	:
			foreach($this->fields as $f)	:
				echo ' , '.JText::_($f);
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