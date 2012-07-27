<?php

if (!defined('ICMS_ROOT_PATH')) {
	die("ICMS root path not defined");
}

class IcalendarFormDateTime {

	function IcalendarFormDateTime(&$form, $startTS = 0, $endTS = 0) {

		$startTS = intval($startTS);
		$startTS = ($startTS > 0) ? $startTS : time();
		$startDatetime = getDate($startTS);

		$endTS = intval($endTS);
		$endTS = ($endTS > 0) ? $endTS : time();
		$endDatetime = getDate($endTS);

		$timearray = array();
		for ($i = 0; $i < 24; $i++) {
			for ($j = 0; $j < 60; $j = $j + 10) {
				$key = ($i * 3600) + ($j * 60);
				$timearray[$key] = ($j != 0) ? $i.':'.$j : $i.':0'.$j;
			}
		}
		ksort($timearray);


		// Start date element's form
		$startElmtTray = new icms_form_elements_Tray(_MD_ICALENDAR_START_DATE, '&nbsp;');

		$startDate = new calendar_form_elements_Date('', 'event_start[date]', 15, $startTS);
		$startDate->setExtra('onBlur=\'validDate("event_start[date]", "event_start[time]", "event_end[date]", "event_end[time]");\'');
		$startElmtTray->addElement($startDate);

		$startTime = new icms_form_elements_Select('', 'event_start[time]', $startDatetime['hours'] * 3600 + 600 * ceil($startDatetime['minutes'] / 10));
		$startTime->setExtra('onChange=\'validDate("event_start[date]", "event_start[time]", "event_end[date]", "event_end[time]");\'');
		$startTime->addOptionArray($timearray);
		$startElmtTray->addElement($startTime);

		$form->addElement($startElmtTray, true);


		// End date element's form
		$endElmtTray = new icms_form_elements_Tray(_MD_ICALENDAR_END_DATE, '<br />');
		$endDateElmtTray = new icms_form_elements_Tray('', "&nbsp;");

		$endElmtTray->addElement(new icms_form_elements_Radioyn(_MD_ICALENDAR_EVENT_END, 'have_end', 1));

		$endDate = new calendar_form_elements_Date('', 'event_end[date]', 15, $endTS);
		$endDate->setExtra('onBlur=\'validDate("event_start[date]", "event_start[time]", "event_end[date]", "event_end[time]");\'');
		$endDateElmtTray->addElement($endDate);

		$endTime = new icms_form_elements_Select('', 'event_end[time]', $endDatetime['hours'] * 3600 + 600 * ceil($endDatetime['minutes'] / 10));
		$endTime->setExtra('onChange=\'validDate("event_start[date]", "event_start[time]", "event_end[date]", "event_end[time]");\'');
		$endTime->addOptionArray($timearray);
		$endDateElmtTray->addElement($endTime);

		$endElmtTray->addElement($endDateElmtTray);
		$form->addElement($endElmtTray);

	}
}
?>