<?php
/**
* Calendar - a calendar and events management module for ImpressCMS
*
* Based upon eXtCal 2.22
*
* File: print.php
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

global $icmsConfig;

include_once ICMS_ROOT_PATH.'/language/'.$icmsConfig['language'].'/calendar.php';

if(!isset($_GET['event'])) {
	$eventId = 0;
} else {
	$eventId = intval($_GET['event']);
}
$eventHandler = icms_getModuleHandler('event', 'extcal');
$event = $eventHandler->objectToArray($eventHandler->getEvent($eventId), array('cat_id'));
// Adding formated date for start and end event
$eventHandler->formatEventDate($event, icms::$module->config['event_date_event']);

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
echo '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
echo '<head>'."\n";
echo '<meta http-equiv="content-type" content="text/html; charset='._CHARSET.'" />'."\n";
echo '<title>'.$event['cat']['cat_name'].' - '.$event['event_title'].'</title>'."\n";
echo '</head>'."\n";
echo '<body onload="window.print()">'."\n";
echo '<table style="border:1px solid black; width:640px;" cellspacing="0" cellspadding="0">'."\n";
echo '<tr>'."\n";
echo '<td colspan="2" style="font-size:1.2em; border:1px solid black;">'."\n";
echo $event['event_title']."\n";
echo '</td>'."\n";
echo '</tr>'."\n";
echo '<tr>'."\n";
echo '<td style="width:50%; border:1px solid black;">'."\n";
echo '<b>'.$event['cat']['cat_name'].'</b><br />'."\n";
echo '<span style="font-weight:normal;">'.$event['cat']['cat_desc'].'</span>'."\n";
echo '</td>'."\n";
echo '<td style="border:1px solid black;">'."\n";
if(!$event['event_isrecur']) {
	echo '<b>'._MD_EXTCAL_START.' :</b> <span style="font-weight:normal;">'.$event['formated_event_start'].'</span><br />'."\n";
	echo '<b>'._MD_EXTCAL_END.' :</b> <span style="font-weight:normal;">'.$event['formated_event_end'].'</span>'."\n";
} else {
	echo '<b>'._MD_EXTCAL_RECCUR_RULE.' :</b> <span style="font-weight:normal;">'.$event['formated_reccur_rule'].'</span>'."\n";
}
echo '</td>'."\n";
echo '</tr>'."\n";
echo '<tr>'."\n";
echo '<td style="border:1px solid black;">'."\n";
echo '<b>'._MD_EXTCAL_CONTACT_INFO.'</b><br />'."\n";
echo '<span style="font-weight:normal;">'.$event['event_contact'].'<br />'."\n";
echo $event['event_address'].'</span>'."\n";
echo '</td>'."\n";
echo '<td style="border:1px solid black;">'."\n";
echo '<b>'._MD_EXTCAL_EMAIL.' :</b> <a href="mailto:'.$event['event_email'].'">'.$event['event_email'].'</a><br />'."\n";
echo '<b>'._MD_EXTCAL_URL.' :</b> <a href="'.$event['event_url'].'">'.$event['event_url'].'</a>'."\n";
echo '</td>'."\n";
echo '</tr>'."\n";
echo '<tr>'."\n";
echo '<td colspan="2" style="border:1px solid black;">'.$event['event_desc'].'</td>'."\n";
echo '</tr>'."\n";
echo '</table><br />'."\n";
echo '<div style="text-align:center; width:640px;">';
echo $icmsConfig['sitename'].' - '.$icmsConfig['slogan'].'<br />';
echo '<a href="'.ICMS_URL.'/modules/'.icms::$module->getVar('dirname').'/event.php?event='.$event['event_id'].'">'.ICMS_URL.'/modules/'.icms::$module->getVar('dirname').'/event.php?event='.$event['event_id'].'</a>';
echo '</div>';
echo '</body>'."\n";
echo '</html>'."\n";
?>