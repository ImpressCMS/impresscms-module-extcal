<?php

include '../../mainfile.php';

if(icms::$module->config['start_page'] == 0) {
	header("Location: calendar-month.php");
} else if(icms::$module->config['start_page'] == 1) {
	header("Location: calendar-week.php");
} else if(icms::$module->config['start_page'] == 2) {
	header("Location: year.php");
} else if(icms::$module->config['start_page'] == 3) {
	header("Location: month.php");
} else if(icms::$module->config['start_page'] == 4) {
	header("Location: week.php");
} else if(icms::$module->config['start_page'] == 5) {
	header("Location: day.php");
}
?>