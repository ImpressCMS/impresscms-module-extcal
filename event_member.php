<?php
/**
* Calendar - a calendar and events management module for ImpressCMS
*
* Based upon iCalendar 2.22
*
* File: event_member.php
*
* @copyright	http://www.xoops.org/ The XOOPS Project
* @copyright	XOOPS_copyrights.txt
* @copyright	http://www.impresscms.org/ The ImpressCMS Project
* @license		GNU General Public License (GPL)
*				a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		iCalendar 
* @since		2.22
* @author		Zoullou
* ----------------------------------------------------------------------------------------------------------
* 				Calendar 
* @since		2.3
* @author		ImpressCMS community
*/

include '../../mainfile.php';

if (!icms::$security->check()) {
	redirect_header('index.php', 3, _NOPERM."<br />".implode('<br />', icms::$security->getErrors()));
	exit;
}

if(icms::$user && icms::$module->config['whos_going']) {
	// If param are right
	if(($_POST['mode'] == 'add' || $_POST['mode'] == 'remove') && intval($_POST['event']) > 0) {

		$eventHandler = icms_getModuleHandler('event', 'icalendar');
		$eventmemberHandler = icms_getModuleHandler('eventmember', 'icalendar');

		// If the user have to be added
		if($_POST['mode'] == 'add') {
			$event = $eventHandler->getEvent(intval($_POST['event']), icms::$user);

			if($event->getVar('event_nbmember') > 0 && $eventmemberHandler->getNbMember(intval($_POST['event'])) >= $event->getVar('event_nbmember')) {
				$rediredtMessage = _MD_ICALENDAR_MAX_MEMBER_REACHED;
			} else {
				$eventmemberHandler->createEventmember(array('event_id'=>intval($_POST['event']), 'uid'=>icms::$user->getVar('uid')));
				$rediredtMessage = _MD_ICALENDAR_WHOS_GOING_ADDED_TO_EVENT;
			}
		// If the user have to be remove
		} else if($_POST['mode'] == 'remove') {
			$eventmemberHandler->deleteEventmember(array(intval($_POST['event']), icms::$user->getVar('uid')));
			$rediredtMessage = _MD_ICALENDAR_WHOS_GOING_REMOVED_TO_EVENT;
		}
		redirect_header('event.php?event='.$_POST['event'], 3, $rediredtMessage, false);
	} else {
		redirect_header('index.php', 3, _NOPERM, false);
	}
} else {
	redirect_header('index.php', 3, _NOPERM, false);
}
?>