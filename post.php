<?php
/**
* Calendar - a calendar and events management module for ImpressCMS
*
* Based upon eXtCal 2.22
*
* File: post.php
*
* @copyright	http://www.xoops.org/ The XOOPS Project
* @copyright	XOOPS_copyrights.txt
* @copyright	http://www.impresscms.org/ The ImpressCMS Project
* @license		GNU General Public License (GPL)
*				a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		eXtCal 
* @since		2.22
* @author		Zoullou
* ----------------------------------------------------------------------------------------------------------
* 				Calendar 
* @since		2.3
* @author		ImpressCMS community
*/

include '../../mainfile.php';

include 'class/form/extcalform.php';
include 'class/perm.php';

$permHandler = ExtcalPerm::getHandler();
$extcalUser = icms::$user ? icms::$user : null;

if(!$permHandler->isAllowed($extcalUser, 'extcal_cat_submit', intval($_POST['cat_id']))) {
	redirect_header('index.php', 3);
	exit;
}

// Getting eXtCal object's handler
$eventHandler = icms_getModuleHandler('event', 'extcal');

if(isset($_POST['form_preview'])) {

	$xoopsOption['template_main'] = 'extcal_post.html';
	include ICMS_ROOT_PATH.'/header.php';

	// Title of the page
	$xoopsTpl->assign('icms_pagetitle', _MI_EXTCAL_SUBMIT_EVENT);

	$data = array(
		'event_title'=>$_POST['event_title'],
		'cat_id'=>intval($_POST['cat_id']),
		'event_desc'=>$_POST['event_desc'],
		'event_nbmember'=>intval($_POST['event_nbmember']),
		'event_contact'=>$_POST['event_contact'],
		'event_url'=>$_POST['event_url'],
		'event_email'=>$_POST['event_email'],
		'event_address'=>$_POST['event_address'],
		'event_approved'=>1,
		'event_start'=>$_POST['event_start'],
		'have_end'=>$_POST['have_end'],
		'event_end'=>$_POST['event_end'],
		'dohtml'=>intval(icms::$module->config['allow_html'])
	);

	if(isset($_POST['event_id'])) {
		$data['event_id'] = intval($_POST['event_id']);
	}

	// Creating tempory event object to apply Object data filtering
	$event = $eventHandler->createEventForPreview($data);
	$event = $eventHandler->objectToArray($event, array('cat_id'), 'p');

	// Adding formated date for start and end event
	$eventHandler->formatEventDate($event, icms::$module->config['event_date_event']);

	// Assigning event to the template
	$xoopsTpl->assign('event', $event);

	$lang = array(
		'start'=>_MD_EXTCAL_START,
		'end'=>_MD_EXTCAL_END,
		'contact_info'=>_MD_EXTCAL_CONTACT_INFO,
		'email'=>_MD_EXTCAL_EMAIL,
		'url'=>_MD_EXTCAL_URL,
		'whos_going'=>_MD_EXTCAL_WHOS_GOING,
		'whosnot_going'=>_MD_EXTCAL_WHOSNOT_GOING
	);
	// Assigning language data to the template
	$xoopsTpl->assign('lang', $lang);

	$event['cat_id'] = intval($_POST['cat_id']);
	$event['have_end'] = $_POST['have_end'];

	// Display the submit form
	$form = $eventHandler->getEventForm('user', 'preview', $event);
	$formBody = $form->render();
	$xoopsTpl->assign('preview', true);
	$xoopsTpl->assign('formBody', $formBody);

	include ICMS_ROOT_PATH.'/footer.php';

} elseif(isset($_POST['form_submit'])) {

	// If the date format is wrong
	if(!preg_match('`[0-9]{4}-[01][0-9]-[0123][0-9]`', $_POST['event_start']['date']) ||
		!preg_match('`[0-9]{4}-[01][0-9]-[0123][0-9]`', $_POST['event_end']['date'])) {
		redirect_header('index.php', 3, _MD_EXTCAL_WRONG_DATE_FORMAT."<br />".implode('<br />', icms::$security->getErrors()));
		exit;
	}

	include_once ICMS_ROOT_PATH.'/modules/extcal/class/perm.php';

	$fileHandler = icms_getModuleHandler('file', 'extcal');
	$permHandler = ExtcalPerm::getHandler();
	$approve = $permHandler->isAllowed(icms::$user, 'extcal_cat_autoapprove', intval($_POST['cat_id']));
	
	$data = array(
		'event_title'=>$_POST['event_title'],
		'cat_id'=>intval($_POST['cat_id']),
		'event_desc'=>$_POST['event_desc'],
		'event_nbmember'=>intval($_POST['event_nbmember']),
		'event_contact'=>$_POST['event_contact'],
		'event_url'=>$_POST['event_url'],
		'event_email'=>$_POST['event_email'],
		'event_address'=>$_POST['event_address'],
		'event_approved'=>$approve,
		'event_start'=>$_POST['event_start'],
		'have_end'=>$_POST['have_end'],
		'event_end'=>$_POST['event_end'],
		'dohtml'=>icms::$module->config['allow_html']
	);

	if(isset($_POST['event_id'])) {

		$eventHandler->modifyEvent(intval($_POST['event_id']), $data);
		$fileHandler->updateEventFile(intval($_POST['event_id']));
		$fileHandler->createFile(intval($_POST['event_id']));

	} else {

		$data['event_submitter'] = (icms::$user) ? icms::$user->getVar('uid') : 0;
		$data['event_submitdate'] = time();

		$eventHandler->createEvent($data);
		$fileHandler->createFile($eventHandler->getInsertId());
		
		if(!$approve) {
			$notifyEvent = 'new_event_pending';
		} else {
			$notifyEvent = 'new_event';
		}

		$notification_handler =& icms::handler('notification');
		$notification_handler->triggerEvent('global', 0, $notifyEvent, array('EVENT_TITLE'=>$_POST['event_title']));
		if($approve == 1) {
			$catHandler = icms_getModuleHandler('cat', 'extcal');
			$cat = $catHandler->getCat(intval($_POST['cat_id']), icms::$user, 'all');
			$notification_handler->triggerEvent('cat', intval($_POST['cat_id']), 'new_event_cat', array('EVENT_TITLE'=>$_POST['event_title'], 'CAT_NAME'=>$cat->getVar('cat_name')));
		}
	}

	redirect_header('index.php', 3, _MD_EXTCAL_EVENT_CREATED, false);
}
?>