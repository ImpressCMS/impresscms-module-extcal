<?php

include '../../../include/cp_header.php';

if(isset($_GET['op'])) {
	$op = $_GET['op'];
} else {
	$op = 'default';
}

switch($op) {

	case 'enreg':

		// Modify cat
		if(isset($_POST['cat_id'])) {
			$catHandler = icms_getModuleHandler('cat', 'icalendar');
			$var_arr = array(
							'cat_name'=>$_POST['cat_name'],
							'cat_desc'=>$_POST['cat_desc'],
							'cat_color'=>substr($_POST['cat_color'],1)
						);
			$catHandler->modifyCat($_POST['cat_id'], $var_arr);
			redirect_header('cat.php', 3, _AM_ICALENDAR_CAT_EDITED, false);
		// Create new cat
		} else {
			$catHandler = icms_getModuleHandler('cat', 'icalendar');
			$var_arr = array(
							'cat_name'=>$_POST['cat_name'],
							'cat_desc'=>$_POST['cat_desc'],
							'cat_color'=>substr($_POST['cat_color'],1)
						);
			$catHandler->createCat($var_arr);
			redirect_header('cat.php', 3, _AM_ICALENDAR_CAT_CREATED, false);
		}

		break;

	case 'modify':

		if(isset($_POST['form_modify'])) {
			icms_cp_header();
			icms::$module -> displayAdminMenu( 2, icms::$module -> getVar( 'name' ) . ' | ' . _AM_ICALENDAR_CATEGORY );

			$catHandler = icms_getModuleHandler('cat', 'icalendar');
			$cat = $catHandler->getCat($_POST['cat_id'], true);

			echo '<fieldset style="border: #e8e8e8 1px solid;"><legend style="font-weight:bold; color:#990000;">'._AM_ICALENDAR_EDIT_CATEGORY.'</legend>';

			$form = new icms_form_Theme(_AM_ICALENDAR_ADD_CATEGORY, 'add_cat', 'cat.php?op=enreg', 'post', true);
			$form->addElement(new icms_form_elements_Text(_AM_ICALENDAR_NAME, 'cat_name', 30, 255, $cat->getVar('cat_name')), true);
			$form->addElement(new icms_form_elements_Dhtmltextarea(_AM_ICALENDAR_DESCRIPTION, 'cat_desc', $cat->getVar('cat_desc')), false);
			$form->addElement(new icms_form_elements_Colorpicker(_AM_ICALENDAR_COLOR, 'cat_color', '#'.$cat->getVar('cat_color')));
			$form->addElement(new icms_form_elements_Hidden('cat_id', $cat->getVar('cat_id')), false);
			$form->addElement(new icms_form_elements_Button("", "form_submit", _SEND, "submit"), false);
			$form->display();

			echo '</fieldset>';

			icms_cp_footer();
		} else if(isset($_POST['form_delete'])) {
			if(!isset($_POST['confirm'])) {
				icms_cp_header();
				icms::$module -> displayAdminMenu( 2, icms::$module -> getVar( 'name' ) . ' | ' . _AM_ICALENDAR_CATEGORY );

				$hiddens = array('cat_id'=>$_POST['cat_id'], 'form_delete'=>'', 'confirm'=>1);
				xoops_confirm($hiddens, 'cat.php?op=modify', _AM_ICALENDAR_CONFIRM_DELETE_CAT, _DELETE, 'cat.php');

				icms_cp_footer();
			} else if(isset($_POST['confirm']) && $_POST['confirm'] == 1) {
				$catHandler = icms_getModuleHandler('cat', 'icalendar');
				$catHandler->deleteCat($_POST['cat_id']);
				redirect_header('cat.php', 3, _AM_ICALENDAR_CAT_DELETED, false);
			}
		}

		break;

	case 'default':
	default:

		icms_cp_header();
		icms::$module -> displayAdminMenu( 2, icms::$module -> getVar( 'name' ) . ' | ' . _AM_ICALENDAR_CATEGORY );

		$catHandler = icms_getModuleHandler('cat', 'icalendar');
		$cats = $catHandler->getAllCat(icms::$user, 'all');

		echo '<fieldset style="border: #e8e8e8 1px solid;"><legend style="font-weight:bold; color:#990000;">'._AM_ICALENDAR_EDIT_OR_DELETE_CATEGORY.'</legend>';
		$form = new icms_form_Theme(_AM_ICALENDAR_EDIT_OR_DELETE_CATEGORY, 'mod_cat', 'cat.php?op=modify', 'post', true);
		$catSelect = new icms_form_elements_Select(_AM_ICALENDAR_CATEGORY, 'cat_id');

		foreach($cats as $cat) {
			$catSelect->addOption($cat->getVar('cat_id'), $cat->getVar('cat_name'));
		}

		$form->addElement($catSelect, true);
		$button = new icms_form_elements_Tray('');
		$button->addElement(new icms_form_elements_Button('', 'form_modify', _EDIT, 'submit'), false);
		$button->addElement(new icms_form_elements_Button('', 'form_delete', _DELETE, 'submit'), false);
		$form->addElement($button, false);
		$form->display();
		echo '</fieldset><br />';

		echo '<fieldset style="border: #e8e8e8 1px solid;"><legend style="font-weight:bold; color:#990000;">'._AM_ICALENDAR_ADD_CATEGORY.'</legend>';

		$form = new icms_form_Theme(_AM_ICALENDAR_ADD_CATEGORY, 'add_cat', 'cat.php?op=enreg', 'post', true);
		$form->addElement(new icms_form_elements_Text(_AM_ICALENDAR_NAME, 'cat_name', 30, 255), true);
		$form->addElement(new icms_form_elements_Dhtmltextarea(_AM_ICALENDAR_DESCRIPTION, 'cat_desc', ''), false);
		$form->addElement(new icms_form_elements_Colorpicker(_AM_ICALENDAR_COLOR, 'cat_color'));
		$form->addElement(new icms_form_elements_Button('', 'form_submit', _SEND, 'submit'), false);
		$form->display();

		echo '</fieldset><br />';

		icms_cp_footer();
		break;
}
?>