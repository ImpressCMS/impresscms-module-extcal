<?php
/**
* Calendar - a calendar and events management module for ImpressCMS
*
* Based upon eXtCal 2.22
*
* File: calendar-week.php
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

$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
$month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
$day = isset($_GET['day']) ? intval($_GET['day']) : date('j');
$cat = isset($_GET['cat']) ? intval($_GET['cat']) : 0;

include '../../mainfile.php';
$xoopsOption['template_main'] = 'extcal_calendar-week.html';
include ICMS_ROOT_PATH.'/header.php';

if(!defined('CALENDAR_ROOT')) {
	define('CALENDAR_ROOT', ICMS_ROOT_PATH.'/modules/'.icms::$module->getVar('dirname').'/class/pear/Calendar/');
}

require_once CALENDAR_ROOT.'Util/Textual.php';
require_once CALENDAR_ROOT.'Month/Weeks.php';
require_once CALENDAR_ROOT.'Week.php';
require_once CALENDAR_ROOT.'Day.php';

// Validate the date (day, month and year)
$dayTS = mktime(0,0,0,$month,$day,$year);
$offset = date('w',$dayTS) - icms::$module->config['week_start_day'];
$dayTS = $dayTS - ($offset * 86400);
$year = date('Y', $dayTS);
$month = date('n', $dayTS);
$day = date('j', $dayTS);

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
	'day'=>_MD_EXTCAL_NAV_DAY
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

$form = new icms_form_Simple('', 'navigSelectBox', 'calendar-week.php', 'get');
$form->addElement($yearSelect);
$form->addElement($monthSelect);
$form->addElement($daySelect);
$form->addElement($catSelect);
$form->addElement(new icms_form_elements_Button('', 'form_submit', _SEND, 'submit'));

// Assigning the form to the template
$form->assign($xoopsTpl);

// Retriving events and formatting them
$events = $eventHandler->objectToArray($eventHandler->getEventCalendarWeek($day, $month, $year, $cat), array('cat_id'));
$eventHandler->serverTimeToUserTimes($events);

// Calculating timestamp for the begin and the end of the month
$startWeek = mktime(0,0,0,$month,$day,$year);
$endWeek = $startWeek + 604799;

/*
*  Adding all event occuring during this week to an array indexed by day number
*/
$eventsArray = array();
foreach($events as $event) {

	if(!$event['event_isrecur']) {
		
		// Formating date
		$eventHandler->formatEventDate($event, icms::$module->config['event_date_week']);
		
		$eventHandler->addEventToCalArray($event, $eventsArray, $startWeek, $endWeek);
		
	} else {
		
		$recurEvents = $eventHandler->getRecurEventToDisplay($event, $startWeek, $endWeek);
		
		// Formating date
		$eventHandler->formatEventsDate($recurEvents, icms::$module->config['event_date_week']);
		
		foreach($recurEvents as $recurEvent) {
			$eventHandler->addEventToCalArray($recurEvent, $eventsArray, $startWeek, $endWeek);
		}
	}
}

/*
*  Making an array to create tabbed output on the template
*/
// Flag current day
$selectedDays = array(new Calendar_Day(
	date('Y', xoops_getUserTimestamp(time(), $extcalTimeHandler->_getUserTimeZone(icms::$user))),
	date('n', xoops_getUserTimestamp(time(), $extcalTimeHandler->_getUserTimeZone(icms::$user))),
	date('j', xoops_getUserTimestamp(time(), $extcalTimeHandler->_getUserTimeZone(icms::$user)))
));

// Build calendar object
$weekCalObj = new Calendar_Week($year, $month, $day, icms::$module->config['week_start_day']);
$pWeekCalObj = $weekCalObj->prevWeek('object');
$nWeekCalObj = $weekCalObj->nextWeek('object');
$weekCalObj->build($selectedDays);

$week = array();
$cellId = 0;
while($dayCalObj = $weekCalObj->fetch()) {
	$week[$cellId] = array('isEmpty'=>$dayCalObj->isEmpty(), 'dayNumber'=>$dayCalObj->thisDay(), 'month'=>$dayCalObj->thisMonth(), 'year'=>$dayCalObj->thisYear(), 'isSelected'=>$dayCalObj->isSelected());
	if(@count($eventsArray[$dayCalObj->thisDay()]) > 0 && !$dayCalObj->isEmpty()) {
		$week[$cellId]['events'] = $eventsArray[$dayCalObj->thisDay()];
	} else {
		$week[$cellId]['events'] = '';
	}
	$cellId++;
}

// Assigning events to the template
$xoopsTpl->assign('week', $week);

// Retriving categories
$cats = $catHandler->objectToArray($catHandler->getAllCat(icms::$user));
// Assigning categories to the template
$xoopsTpl->assign('cats', $cats);

// Retriving weekdayNames
$weekdayNames = Calendar_Util_Textual::weekdayNames();
for($i=0;$i<icms::$module->config['week_start_day'];$i++) {
	$weekdayName = array_shift($weekdayNames);
	$weekdayNames[] = $weekdayName;
}
// Assigning weekdayNames to the template
$xoopsTpl->assign('weekdayNames', $weekdayNames);

// Retriving monthNames
$monthNames = Calendar_Util_Textual::monthNames();

// Making navig data
$navig = array(
			'prev'=>array(
						'uri'=>'year='.$pWeekCalObj->thisYear().'&amp;month='.$pWeekCalObj->thisMonth().'&amp;day='.$pWeekCalObj->thisDay(),
						'name'=>$extcalTimeHandler->getFormatedDate(icms::$module->config['nav_date_week'], $pWeekCalObj->getTimestamp())
			),
			'this'=>array(
						'uri'=>'year='.$weekCalObj->thisYear().'&amp;month='.$weekCalObj->thisMonth().'&amp;day='.$weekCalObj->thisDay(),
						'name'=>$extcalTimeHandler->getFormatedDate(icms::$module->config['nav_date_week'], $weekCalObj->getTimestamp())
			),
			'next'=>array(
						'uri'=>'year='.$nWeekCalObj->thisYear().'&amp;month='.$nWeekCalObj->thisMonth().'&amp;day='.$nWeekCalObj->thisDay(),
						'name'=>$extcalTimeHandler->getFormatedDate(icms::$module->config['nav_date_week'], $nWeekCalObj->getTimestamp())
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
$xoopsTpl->assign('view', 'calweek');

include ICMS_ROOT_PATH.'/footer.php';
?>