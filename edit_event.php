<?php
/**
* Calendar - a calendar and events management module for ImpressCMS
*
* Based upon iCalendar 2.22
*
* File: edit_event.php
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

include 'class/form/icalendarform.php';
include 'class/perm.php';

$permHandler = IcalendarPerm::getHandler();
$icalendarUser = icms::$user ? icms::$user : null;

if(count($permHandler->getAuthorizedCat($icalendarUser, 'icalendar_cat_submit')) == 0 && 
	count($permHandler->getAuthorizedCat($icalendarUser, 'icalendar_cat_edit')) == 0) {
	redirect_header('index.php', 3);
	exit;
}

if(!isset($_GET['event'])) {
	$eventId = 0;
} else {
	$eventId = intval($_GET['event']);
}

// Getting iCalendar object's handler
$eventHandler = icms_getModuleHandler('event', 'icalendar');

include ICMS_ROOT_PATH.'/header.php';

// Title of the page
$xoopsTpl->assign('icms_pagetitle', _MI_ICALENDAR_SUBMIT_EVENT);

// Display the submit form
$form = $eventHandler->getEventForm('user', 'edit', array('event_id'=>$eventId));
$form->display();

include ICMS_ROOT_PATH.'/footer.php';
?>