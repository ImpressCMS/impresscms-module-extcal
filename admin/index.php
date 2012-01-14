<?php

include '../../../include/cp_header.php';

if(isset($_GET['op'])) {
	$op = $_GET['op'];
} else if(isset($_POST['op'])) {
	$op = $_POST['op'];
} else {
	$op = 'default';
}
if(isset($_GET['fct'])) {
	$fct = $_GET['fct'];
} else {
	$fct = 'default';
}

switch($op) {

	case 'notification':

		switch($fct) {

			case 'send':

				if (!icms::$security->check()) {
					redirect_header('index.php', 3, _NOPERM."<br />".implode('<br />', icms::$security->getErrors()));
					exit;
				}
				icms_cp_header();
				icms::$module -> displayAdminMenu( 2, icms::$module -> getVar( 'name' ) );

				$myts =& MyTextSanitizer::getInstance();
            	$xoopsMailer = new icms_messaging_Handler();
				$catHandler = icms_getModuleHandler('cat', 'extcal');
				$eventHandler = icms_getModuleHandler('event', 'extcal');
				$eventmemberHandler = icms_getModuleHandler('eventmember', 'extcal');
				$extcalTime = ExtcalTime::getHandler();

				$event = $eventHandler->getEvent($_POST['event_id'], icms::$user, true);
				$cat = $catHandler->getCat($event->getVar('cat_id'), icms::$user, 'all');

				$xoopsMailer->setToUsers($eventmemberHandler->getMembers($_POST['event_id']));
				$xoopsMailer->setFromName($myts->oopsStripSlashesGPC($_POST['mail_fromname']));
				$xoopsMailer->setFromEmail($myts->oopsStripSlashesGPC($_POST['mail_fromemail']));
				$xoopsMailer->setSubject($myts->oopsStripSlashesGPC($_POST['mail_subject']));
				$xoopsMailer->setBody($myts->oopsStripSlashesGPC($_POST['mail_body']));
				if ( in_array("mail", $_POST['mail_send_to']) ) {
					$xoopsMailer->useMail();
				}
				if ( in_array("pm", $_POST['mail_send_to']) && empty($_POST['mail_inactive']) ) {
					$xoopsMailer->usePM();
				}
				$tag = array(
					'EV_CAT'=>$cat->getVar('cat_name'),
					'EV_TITLE'=>$event->getVar('event_title'),
					'EV_START'=>$extcalTime->getFormatedDate(icms::$module->config['date_long'], $event->getVar('event_start')),
					'EV_END'=>$extcalTime->getFormatedDate(icms::$module->config['date_long'], $event->getVar('event_end')),
					'EV_LINK'=>ICMS_URL.'/modules/extcal/event.php?event='.$event->getVar('event_id')
				);
				$xoopsMailer->assign($tag);
				$xoopsMailer->send(true);
				echo $xoopsMailer->getSuccess();
				echo $xoopsMailer->getErrors();

				icms_cp_footer();
				break;

			case 'default':
			default:

				icms_cp_header();
				icms::$module -> displayAdminMenu( 1, icms::$module -> getVar( 'name' ) );

				$fromemail = !empty($icmsConfig['adminmail']) ? $icmsConfig['adminmail'] : icms::$user->getVar("email", "E");
				$subject_caption = _AM_EXTCAL_SUBJECT."<br /><br /><span style='font-size:x-small;font-weight:bold;'>"._AM_EXTCAL_USEFUL_TAGS."</span><br /><span style='font-size:x-small;font-weight:normal;'>"._AM_EXTCAL_MAILTAGS6."<br />"._AM_EXTCAL_MAILTAGS2."</span>&nbsp;&nbsp;&nbsp;";
				$body_caption = _AM_EXTCAL_BODY."<br /><br /><span style='font-size:x-small;font-weight:bold;'>"._AM_EXTCAL_USEFUL_TAGS."</span><br /><span style='font-size:x-small;font-weight:normal;'>"._AM_EXTCAL_MAILTAGS1."<br />"._AM_EXTCAL_MAILTAGS2."<br />"._AM_EXTCAL_MAILTAGS3."<br />"._AM_EXTCAL_MAILTAGS4."<br />"._AM_EXTCAL_MAILTAGS5."<br />"._AM_EXTCAL_MAILTAGS6."<br />"._AM_EXTCAL_MAILTAGS7."<br />"._AM_EXTCAL_MAILTAGS8."<br />"._AM_EXTCAL_MAILTAGS9."</span>&nbsp;&nbsp;&nbsp;";
				$to_checkbox = new icms_form_elements_Checkbox(_AM_EXTCAL_SEND_TO, "mail_send_to", "mail");
				$to_checkbox->addOption("mail", _AM_EXTCAL_EMAIL);
				$to_checkbox->addOption("pm", _AM_EXTCAL_PM);

				echo '<fieldset style="border: #e8e8e8 1px solid;"><legend style="font-weight:bold; color:#990000;">'._AM_EXTCAL_APPROVED_EVENT.'</legend>';
				echo '<fieldset style="border: #e8e8e8 1px solid;"><legend style="font-weight:bold; color:#0A3760;">'._AM_EXTCAL_INFORMATION.'</legend>';
				echo _AM_EXTCAL_INFO_SEND_NOTIF;
				echo '</fieldset><br />';
				$form = new icms_form_Theme(_AM_EXTCAL_SEND_NOTIFICATION, "mailusers", "index.php?op=notification&amp;fct=send", 'post', true);
				$form->addElement(new icms_form_elements_Text(_AM_EXTCAL_FROM_NAME, "mail_fromname", 30, 255, $icmsConfig['sitename']), true);
				$form->addElement(new icms_form_elements_Text(_AM_EXTCAL_FROM_EMAIL, "mail_fromemail", 30, 255, $fromemail), true);
				$form->addElement(new icms_form_elements_Text($subject_caption, "mail_subject", 50, 255, _AM_EXTCAL_SEND_NOTIFICATION_SUBJECT), true);
				$form->addElement(new icms_form_elements_Textarea($body_caption, "mail_body", _AM_EXTCAL_SEND_NOTIFICATION_BODY, 10), true);
				$form->addElement($to_checkbox, true);
				$form->addElement(new icms_form_elements_Hidden('event_id', $_GET['event_id']), false);
				$form->addElement(new icms_form_elements_Button("", "mail_submit", _SEND, "submit"));
				$form->display();
				echo '</fieldset>';

				icms_cp_footer();
				break;

		}

		break;

	default:
	case 'default':

		icms_cp_header();
		icms::$module -> displayAdminMenu( 1, icms::$module -> getVar( 'name' ) );

		$catHandler = icms_getModuleHandler('cat', 'extcal');
		$eventHandler = icms_getModuleHandler('event', 'extcal');

		echo '<fieldset style="border: #e8e8e8 1px solid;"><legend style="font-weight:bold; color:#990000;">'._AM_EXTCAL_MODULE_ADMIN_SUMMARY.'</legend>';
		echo '<br />';
		echo '<a href="cat.php">'._AM_EXTCAL_CATEGORY.'</a> : <b>'.$catHandler->getCount().'</b> | ';
		echo '<a href="event.php">'._AM_EXTCAL_EVENT.'</a> : <b>'.$eventHandler->getCount(new icms_db_criteria_Item('event_approved', 1)).'</b> | ';
		echo _AM_EXTCAL_PENDING.' : <b>'.$eventHandler->getCount(new icms_db_criteria_Item('event_approved', 0)).'</b> | ';
		$criteriaCompo = new icms_db_criteria_Compo();
		$criteriaCompo->add(new icms_db_criteria_Item('event_approved', 1));
		$criteriaCompo->add(new icms_db_criteria_Item('event_start', time(), '>='));
		echo _AM_EXTCAL_APPROVED.' : <b>'.$eventHandler->getCount($criteriaCompo).'</b>';
		echo '</fieldset><br />';

		$pendingEvent = $eventHandler->objectToArray($eventHandler->getPendingEvent(), array('cat_id'));
		$eventHandler->formatEventsDate($pendingEvent, 'd/m/Y');

		echo '<fieldset style="border: #e8e8e8 1px solid;"><legend style="font-weight:bold; color:#990000;">'._AM_EXTCAL_PENDING_EVENT.'</legend>';
		echo '<fieldset style="border: #e8e8e8 1px solid;"><legend style="font-weight:bold; color:#0A3760;">'._AM_EXTCAL_INFORMATION.'</legend>';
		echo '<img src="../images/approve.png" style="vertical-align:middle;" />&nbsp;&nbsp;'._AM_EXTCAL_INFO_APPROVE_PENDING_EVENT.'<br />';
		echo '<img src="../images/edit.png" style="vertical-align:middle;" />&nbsp;&nbsp;'._AM_EXTCAL_INFO_EDIT_PENDING_EVENT.'<br />';
		echo '<img src="../images/delete.png" style="vertical-align:middle;" />&nbsp;&nbsp;'._AM_EXTCAL_INFO_DELETE_PENDING_EVENT;
		echo '</fieldset><br />';

		echo '<table class="outer" style="width:100%;">';
		echo '<tr style="text-align:center;">';
		echo '<th>'._AM_EXTCAL_CATEGORY.'</th>';
		echo '<th>'._AM_EXTCAL_TITLE.'</th>';
		echo '<th>'._AM_EXTCAL_START_DATE.'</th>';
		echo '<th>'._AM_EXTCAL_END_DATE.'</th>';
		echo '<th>'._AM_EXTCAL_ACTION.'</th>';
		echo '</tr>';

		if(count($pendingEvent) > 0) {
			$i=0;
			foreach($pendingEvent as $event) {
				$class = ($i++%2 == 0) ? 'even' : 'odd';
				echo '<tr style="text-align:center;" class="'.$class.'">';
				echo '<td>'.$event['cat']['cat_name'].'</td>';
				echo '<td>'.$event['event_title'].'</td>';
				echo '<td>'.$event['formated_event_start'].'</td>';
				echo '<td>'.$event['formated_event_end'].'</td>';
				echo '<td style="width:10%; text-align:center;">';
				echo '<a href="event.php?op=modify&amp;event_id='.$event['event_id'].'"><img src="../images/edit.png" /></a>&nbsp;&nbsp;';
				echo '<a href="event.php?op=delete&amp;event_id='.$event['event_id'].'"><img src="../images/delete.png" /></a>';
				echo '</td>';
				echo '</tr>';
			}
		} else {
			echo '<tr><td colspan="4">'._AM_NO_PENDING_EVENT.'</td></tr>';
		}

		echo '</table></fieldset><br />';

		icms_cp_footer();
		break;
}
?>