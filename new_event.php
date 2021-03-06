<?php
/**
* Calendar - a calendar and events management module for ImpressCMS
*
* Based upon eXtCal 2.22
*
* File: new_event.php
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

include 'class/perm.php';
include 'class/form/extcalform.php';

// Getting eXtCal object's handler
$eventHandler = icms_getModuleHandler('event', 'extcal');

$permHandler = ExtcalPerm::getHandler();
$user = is_object(icms::$user) ? icms::$user : null;
if (count($permHandler->getAuthorizedCat($user, 'extcal_cat_submit')) > 0) {
	
	include ICMS_ROOT_PATH.'/header.php';
	
	// Title of the page
	$xoopsTpl->assign('icms_pagetitle', _MI_EXTCAL_SUBMIT_EVENT);

	// Display the submit form
	$form = $eventHandler->getEventForm();
	$form->display();
	
	include ICMS_ROOT_PATH.'/footer.php';
	
} else {
	redirect_header("index.php", 3);
}