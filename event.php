<?php
/**
* Calendar - a calendar and events management module for ImpressCMS
*
* Based upon iCalendar 2.22
*
* File: event.php
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

$xoopsOption['template_main'] = 'icalendar_event.html';
include ICMS_ROOT_PATH.'/header.php';

include ICMS_ROOT_PATH.'/include/comment_view.php';

$eventId = filter_input(INPUT_GET, 'event', FILTER_SANITIZE_NUMBER_INT);
if (is_null($eventId)) $eventId = 0;

$eventHandler = icms_getModuleHandler('event', 'icalendar');
$fileHandler = icms_getModuleHandler('file', 'icalendar');
$eventmemberHandler = icms_getModuleHandler('eventmember', 'icalendar');
$eventnotmemberHandler = icms_getModuleHandler('eventnotmember', 'icalendar');
$permHandler = IcalendarPerm::getHandler();

// Retriving event
$eventObj = $eventHandler->getEvent($eventId);

if(!$eventObj) {
	redirect_header('index.php', 3, '');
}

$event = $eventHandler->objectToArray($eventObj, array('cat_id', 'event_submitter'));
$eventHandler->serverTimeToUserTime($event);

// Adding formated date for start and end event
$eventHandler->formatEventDate($event, icms::$module->config['event_date_event']);

// Assigning event to the template
$xoopsTpl->assign('event', $event);

// Title of the page
$xoopsTpl->assign('icms_pagetitle', $event['event_title']);

$lang = array(
	'start'=>_MD_ICALENDAR_START,
	'end'=>_MD_ICALENDAR_END,
	'contact_info'=>_MD_ICALENDAR_CONTACT_INFO,
	'email'=>_MD_ICALENDAR_EMAIL,
	'url'=>_MD_ICALENDAR_URL,
	'whos_going'=>_MD_ICALENDAR_WHOS_GOING,
	'whosnot_going'=>_MD_ICALENDAR_WHOSNOT_GOING,
	'reccur_rule'=>_MD_ICALENDAR_RECCUR_RULE,
	'posted_by'=>_MD_ICALENDAR_POSTED_BY,
	'on'=>_MD_ICALENDAR_ON,
	'edit'=>_MD_ICALENDAR_EDIT_EVENT,
	'print'=>_MD_ICALENDAR_PRINT,
	'delete'=>_MD_ICALENDAR_DELETE,
	'address'=>_MD_ICALENDAR_ADDRESS
);
// Assigning language data to the template
$xoopsTpl->assign('lang', $lang);

// Getting event attachement
$eventFiles = $fileHandler->objectToArray($fileHandler->getEventFiles($eventId));
$fileHandler->formatFilesSize($eventFiles);
$xoopsTpl->assign('event_attachement', $eventFiles);

// Token to disallow direct posting on membre/nonmember page
$xoopsTpl->assign('token', icms::$security->getTokenHTML());

// ### For Who's Going function ###

// If the who's goging function is enabled
if(icms::$module->config['whos_going']) {

	// Retriving member's for this event
	$members = $eventmemberHandler->getMembers($eventId);

	// Initializing variable
	$eventmember['member']['show_button'] = false;

	$nbUser = 0;
	// Making a list with members and counting regitered user's
	foreach($members as $k => $v) {
		$nbUser++;
		$eventmember['member']['userList'][] = array('uid'=>$k, 'uname'=>$v->getVar('uname'));
	}
	$eventmember['member']['nbUser'] = $nbUser;

	// If the user is logged
	if(icms::$user) {

		// Initializing variable
		$eventmember['member']['show_button'] = true;
		$eventmember['member']['button_disabled'] = '';

		// If the user is already restired to this event
		if(array_key_exists(icms::$user->getVar('uid'), $members)) {
			$eventmember['member']['button_text'] = _MD_ICALENDAR_REMOVE_ME;
			$eventmember['member']['joinevent_mode'] = 'remove';
		} else {
			$eventmember['member']['button_text'] = _MD_ICALENDAR_ADD_ME;
			$eventmember['member']['joinevent_mode'] = 'add';

			// If this event is full
			if($event['event_nbmember'] != 0 && $eventmemberHandler->getNbMember($eventId) >= $event['event_nbmember']) {
				$eventmember['member']['disabled'] = ' disabled="disabled"';
			}
		}
	}
}

// ### For Who's not Going function ###

// If the who's not goging function is enabled
if(icms::$module->config['whosnot_going']) {

	// Retriving not member's for this event
	$notmembers = $eventnotmemberHandler->getMembers($eventId);

	// Initializing variable
	$eventmember['notmember']['show_button'] = false;

	$nbUser = 0;
	// Making a list with not members
	foreach($notmembers as $k => $v) {
		$nbUser++;
		$eventmember['notmember']['userList'][] = array('uid'=>$k, 'uname'=>$v->getVar('uname'));
	}
	$eventmember['notmember']['nbUser'] = $nbUser;

	// If the user is logged
	if(icms::$user) {

		// Initializing variable
		$eventmember['notmember']['show_button'] = true;
		$eventmember['notmember']['button_disabled'] = '';

		// If the user is already restired to this event
		if(array_key_exists(icms::$user->getVar('uid'), $notmembers)) {
			$eventmember['notmember']['button_text'] = _MD_ICALENDAR_REMOVE_ME;
			$eventmember['notmember']['joinevent_mode'] = 'remove';
		} else {
			$eventmember['notmember']['button_text'] = _MD_ICALENDAR_ADD_ME;
			$eventmember['notmember']['joinevent_mode'] = 'add';
		}
	}

}

// If who's going or not going function is enabled
if(icms::$module->config['whos_going'] || icms::$module->config['whosnot_going']) {
	$xoopsTpl->assign('eventmember', $eventmember);
}

// Checking user perm
if(icms::$user) {
	$xoopsTpl->assign('isAdmin', icms::$user->isAdmin());
	$canEdit = $permHandler->isAllowed(icms::$user, 'icalendar_cat_edit', $event['cat']['cat_id']) && icms::$user->getVar('uid') == $event['user']['uid'];
	$xoopsTpl->assign('canEdit', $canEdit);
} else {
	$xoopsTpl->assign('isAdmin', false);
	$xoopsTpl->assign('canEdit', false);
}

$xoopsTpl->assign('whosGoing', icms::$module->config['whos_going']);
$xoopsTpl->assign('whosNotGoing', icms::$module->config['whosnot_going']);

include(ICMS_ROOT_PATH.'/footer.php');
?>