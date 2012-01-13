<?php
/**
* Calendar - a calendar and events management module for ImpressCMS
*
* Based upon eXtCal 2.22
*
* File: day.php
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

function orderEvents($event1, $event2) {
	if($event1['event_start'] == $event2['event_start']) {
		return 0;
	}
	if(icms::$module->config['sort_order'] == 'ASC') {
		$opt1 = -1;
		$opt2 = 1;
	} else {
		$opt1 = 1;
		$opt2 = -1;
	}
	return ($event1['event_start'] < $event2['event_start']) ? $opt1 : $opt2;
}

$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
$month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
$day = isset($_GET['day']) ? intval($_GET['day']) : date('j');
$cat = isset($_GET['cat']) ? intval($_GET['cat']) : 0;

include '../../mainfile.php';
$xoopsOption['template_main'] = 'extcal_day.html';
include ICMS_ROOT_PATH.'/header.php';

if(!defined('CALENDAR_ROOT')) {
	define('CALENDAR_ROOT', ICMS_ROOT_PATH.'/modules/'.icms::$module->getVar('dirname').'/class/pear/Calendar/');
}

require_once CALENDAR_ROOT.'Day.php';

// Getting eXtCal object's handler
$catHandler = icms_getModuleHandler('cat', 'extcal');
$eventHandler = icms_getModuleHandler('event', 'extcal');
$extcalTimeHandler = ExtcalTime::getHandler();

// Tooltips include
$xoTheme->addScript('modules/'.icms::$module->getVar('dirname').'/include/ToolTips.js');
$xoTheme->addStylesheet('modules/'.icms::$module->getVar('dirname').'/include/style.css');

$lang = array(
	'start'=>_MD_EXTCAL_START,
	'end'=>_MD_EXTCAL_END,
	'calmonth'=>_MD_EXTCAL_NAV_CALMONTH,
	'calweek'=>_MD_EXTCAL_NAV_CALWEEK,
	'year'=>_MD_EXTCAL_NAV_YEAR,
	'month'=>_MD_EXTCAL_NAV_MONTH,
	'week'=>_MD_EXTCAL_NAV_WEEK,
	'day'=>_MD_EXTCAL_NAV_DAY,
	'feed'=>_MD_EXTCAL_FEED
);
// Assigning language data to the template
$xoopsTpl->assign('lang', $lang);

// ### Create the navigation form ###

// Year selectbox
$yearSelect = new icms_form_elements_Select('', 'year', $year);
for($i=2004;$i<2015;$i++) {
	$yearSelect->addOption($i);
}

// Month selectbox
$monthSelect = new icms_form_elements_Select('', 'month', $month);
for($i=1;$i<13;$i++) {
	$monthSelect->addOption($i, $extcalTimeHandler->getMonthName($i));
}

// Day selectbox
$daySelect = new icms_form_elements_Select('', 'day', $day);
for($i=1;$i<32;$i++) {
	$daySelect->addOption($i);
}

// Category selectbox
$catsList = $catHandler->getAllCat(icms::$user);
$catSelect = new icms_form_elements_Select('', 'cat', $cat);
$catSelect->addOption(0, ' ');
foreach($catsList as $catList) {
	$catSelect->addOption($catList->getVar('cat_id'), $catList->getVar('cat_name'));
}

$form = new icms_form_Simple('', 'navigSelectBox', 'day.php', 'get');
$form->addElement($yearSelect);
$form->addElement($monthSelect);
$form->addElement($daySelect);
$form->addElement($catSelect);
$form->addElement(new icms_form_elements_Button('', '', _SEND, 'submit'));

// Assigning the form to the template
$form->assign($xoopsTpl);

// Retriving events
$events = $eventHandler->objectToArray($eventHandler->getEventDay($day, $month, $year, $cat), array('cat_id'));
$eventHandler->serverTimeToUserTimes($events);

// Formating date
$eventHandler->formatEventsDate($events, icms::$module->config['event_date_year']);

// Treatment for recurring event
$startDay = mktime(0,0,0,$month,$day,$year);
$endDay = $startDay + 86400;
$eventsArray = array();
foreach($events as $event) {

	if(!$event['event_isrecur']) {
		
		// Formating date
		$eventHandler->formatEventDate($event, icms::$module->config['event_date_week']);
		$eventsArray[] = $event;
		
	} else {
		
		$recurEvents = $eventHandler->getRecurEventToDisplay($event, $startDay, $endDay);
		
		// Formating date
		$eventHandler->formatEventsDate($recurEvents, icms::$module->config['event_date_week']);
		$eventsArray = array_merge($eventsArray, $recurEvents);
		
	}
}

// Sort event array by event start
usort($eventsArray, 'orderEvents');

// Assigning events to the template
$xoopsTpl->assign('events', $eventsArray);

// Retriving categories
$cats = $catHandler->objectToArray($catHandler->getAllCat(icms::$user));
// Assigning categories to the template
$xoopsTpl->assign('cats', $cats);

// Making navig data
$dayCalObj = new Calendar_Day($year, $month, $day);
$pDayCalObj = $dayCalObj->prevDay('object');
$nDayCalObj = $dayCalObj->nextDay('object');

$navig = array(
			'prev'=>array(
						'uri'=>'year='.$pDayCalObj->thisYear().'&amp;month='.$pDayCalObj->thisMonth().'&amp;day='.$pDayCalObj->thisDay(),
						'name'=>$extcalTimeHandler->getFormatedDate(icms::$module->config['nav_date_day'], $pDayCalObj->getTimestamp())
			),
			'this'=>array(
						'uri'=>'year='.$dayCalObj->thisYear().'&amp;month='.$dayCalObj->thisMonth().'&amp;day='.$dayCalObj->thisDay(),
						'name'=>$extcalTimeHandler->getFormatedDate(icms::$module->config['nav_date_day'], $dayCalObj->getTimestamp())
			),
			'next'=>array(
						'uri'=>'year='.$nDayCalObj->thisYear().'&amp;month='.$nDayCalObj->thisMonth().'&amp;day='.$nDayCalObj->thisDay(),
						'name'=>$extcalTimeHandler->getFormatedDate(icms::$module->config['nav_date_day'], $nDayCalObj->getTimestamp())
			)
);

// Title of the page
$xoopsTpl->assign('icms_pagetitle', icms::$module->getVar('name').' '.$navig['this']['name']);

// Assigning navig data to the template
$xoopsTpl->assign('navig', $navig);

// Assigning current form navig data to the template
$xoopsTpl->assign('selectedCat', $cat);
$xoopsTpl->assign('year', $year);
$xoopsTpl->assign('month', $month);
$xoopsTpl->assign('day', $day);
$xoopsTpl->assign('view', 'day');

include ICMS_ROOT_PATH.'/footer.php';
?>