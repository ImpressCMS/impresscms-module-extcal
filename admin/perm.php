<?php

include '../../../include/cp_header.php';

icms_cp_header();
icms::$module -> displayAdminMenu( 4, icms::$module -> getVar( 'name' ) . ' | ' . _AM_EXTCAL_PERMISSIONS );

$permtoset = isset( $_POST['permtoset'] ) ? intval( $_POST['permtoset'] ) : 1;
$selected = array( '', '', '', '', '' );
$selected[$permtoset-1] = 'selected';
echo "<form method='post' name='fselperm' action='perm.php'><table border=0><tr><td><select name='permtoset' onChange='javascript: document.fselperm.submit()'>
<option value='1'" . $selected[0] . ">" . _AM_EXTCAL_VIEW_PERMISSION . "</option>
<option value='2'" . $selected[1] . ">" . _AM_EXTCAL_SUBMIT_PERMISSION . "</option>
<option value='3'" . $selected[2] . ">" . _AM_EXTCAL_AUTOAPPROVE_PERMISSION . "</option>
<option value='4'" . $selected[3] . ">" . _AM_EXTCAL_EDIT_PERMISSION . "</option>
</select>&nbsp;<input type='submit' name='go'/></td></tr></table></form>";
$module_id = icms::$module -> getVar( 'mid' );

switch( $permtoset ) {
	case 1:
		$title_of_form = '<fieldset style="border: #e8e8e8 1px solid;"><legend style="display: inline; font-weight: bold; color: #0A3760;">' . _AM_EXTCAL_VIEW_PERMISSION . '</legend><div style="padding: 8px; font-weight: normal;">' . _AM_EXTCAL_VIEW_PERMISSION_DESC . '</div></fieldset>';
		$perm_name = 'extcal_cat_view';
		break;
	case 2:
		$title_of_form = '<fieldset style="border: #e8e8e8 1px solid;"><legend style="display: inline; font-weight: bold; color: #0A3760;">' . _AM_EXTCAL_SUBMIT_PERMISSION . '</legend><div style="padding: 8px; font-weight: normal;">' . _AM_EXTCAL_SUBMIT_PERMISSION_DESC . '</div></fieldset>';
		$perm_name = 'extcal_cat_submit';
		break;
	case 3:
		$title_of_form = '<fieldset style="border: #e8e8e8 1px solid;"><legend style="display: inline; font-weight: bold; color: #0A3760;">' . _AM_EXTCAL_AUTOAPPROVE_PERMISSION . '</legend><div style="padding: 8px; font-weight: normal;">' . _AM_EXTCAL_AUTOAPPROVE_PERMISSION_DESC . '</div></fieldset>';
		$perm_name = 'extcal_cat_autoapprove';
		break;
	case 4:
		$title_of_form = '<fieldset style="border: #e8e8e8 1px solid;"><legend style="display: inline; font-weight: bold; color: #0A3760;">' . _AM_EXTCAL_EDIT_PERMISSION . '</legend><div style="padding: 8px; font-weight: normal;">' . _AM_EXTCAL_EDIT_PERMISSION_DESC . '</div></fieldset>';
		$perm_name = 'extcal_cat_edit';
		break;
}

$permform = new icms_form_Groupperm( $title_of_form, $module_id, $perm_name, '', 'admin/perm.php' );
$result = icms::$xoopsDB -> query( 'SELECT cat_id, cat_name FROM ' . icms::$xoopsDB -> prefix( 'extcal_cat' ) . ' ORDER BY cat_name ASC' );
if ( icms::$xoopsDB -> getRowsNum( $result ) ) {
    while ( $perm_row = icms::$xoopsDB -> fetcharray( $result ) ) {
        $permform -> addItem( $perm_row['cat_id'], '&nbsp;' . $perm_row['cat_name'] );
    }	
    echo $permform -> render();
    echo '';
} else {
    echo '<div><b>' . _AM_EXTCAL_PERM_NO_CATEGORY . '</b></div>';
} 
unset ( $permform );
//redirect_header( 'perm.php', 1, '' );
icms_cp_footer();
?>