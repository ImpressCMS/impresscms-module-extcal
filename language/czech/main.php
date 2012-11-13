<?php

include_once ICMS_ROOT_PATH.'/language/'.$icmsConfig['language'].'/calendar.php';

define('_MD_EXTCAL_NAV_CALMONTH', 'Kalendářní měsíc');
define('_MD_EXTCAL_NAV_CALWEEK', 'Kalendářní týden');
define('_MD_EXTCAL_NAV_YEAR', 'Rok');
define('_MD_EXTCAL_NAV_MONTH', 'Měsíc');
define('_MD_EXTCAL_NAV_WEEK', 'Týden');
define('_MD_EXTCAL_NAV_DAY', 'Den');

define("_MD_EXTCAL_START","Začátek");
define("_MD_EXTCAL_END","Konec");
define('_MD_EXTCAL_RECCUR_RULE', 'Pravidlo opakování');
define("_MD_EXTCAL_CONTACT_INFO","Kontaktní informace");
define("_MD_EXTCAL_EMAIL","Email");
define("_MD_EXTCAL_URL","URL");
define("_MD_EXTCAL_WHOS_GOING","Zúčastní se:");
define("_MD_EXTCAL_WHOSNOT_GOING","Nezúčastní se:");
define("_MD_EXTCAL_ADD_ME","Přidat mě");
define("_MD_EXTCAL_REMOVE_ME","Odebrat mě");
define("_MD_EXTCAL_POSTED_BY","Vložil:");

define('_MD_EXTCAL_SUBMITED_EVENT', 'Vložená událost');
define('_MD_EXTCAL_SUBMIT_EVENT', 'Vložit událost');
define('_MD_EXTCAL_EDIT_EVENT', 'Upravit událost');
define('_MD_EXTCAL_TITLE', 'Název');
define('_MD_EXTCAL_CATEGORY', 'Kategorie');
define('_MD_EXTCAL_DESCRIPTION', 'Popis');
define('_MD_EXTCAL_NBMEMBER', 'Limit pro pozvané členy');
define('_MD_EXTCAL_NBMEMBER_DESC', '0 = bez omezení');
define('_MD_EXTCAL_CONTACT', 'Kontakt');
define('_MD_EXTCAL_ADDRESS', 'Adresa');
define('_MD_EXTCAL_START_DATE', 'Datum začátku');
define('_MD_EXTCAL_END_DATE', 'Datum konce');
define('_MD_EXTCAL_EVENT_END', 'Zadat konec?');
define('_MD_EXTCAL_FILE_ATTACHEMENT', 'Přiložit soubor');
define('_MD_EXTCAL_PREVIEW', 'Náhled');
define('_MD_EXTCAL_EVENT_CREATED', 'Událost vytvořena');
define('_MD_EXTCAL_MAX_MEMBER_REACHED', 'Tato událost je vyprodána, aneb bylo dosaženo maxima přihlášených');
define('_MD_EXTCAL_WHOS_GOING_ADDED_TO_EVENT', 'Přidat na seznam těch, kdo se zúčastní');
define('_MD_EXTCAL_WHOS_GOING_REMOVED_TO_EVENT', 'Smazat ze seznamu těch, kdo se zúčastní ');
define('_MD_EXTCAL_WHOSNOT_GOING_ADDED_TO_EVENT', 'Přidat na seznam těch, kdo se nezúčastní');
define('_MD_EXTCAL_WHOSNOT_GOING_REMOVED_TO_EVENT', 'Smazat ze seznamu těch, kdo se nezúčastní');

define('_MD_EXTCAL_WRONG_DATE_FORMAT', 'Chybný formát data');
define('_MD_EXTCAL_NO_RECCUR_EVENT', 'Neopakující se událost');
define('_MD_EXTCAL_RECCUR_POLICY', 'Opakující se událost/Periodicky');
define('_MD_EXTCAL_DAILY', 'Denně');
define('_MD_EXTCAL_WEEKLY', 'Týdně');
define('_MD_EXTCAL_MONTHLY', 'Měsíčně');
define('_MD_EXTCAL_YEARLY', 'Ročně');
define('_MD_EXTCAL_DURING', 'Trvá');
define('_MD_EXTCAL_DAYS', 'dní');
define('_MD_EXTCAL_WEEKS', 'týdnů');
define('_MD_EXTCAL_MONTH', 'měsíců');
define('_MD_EXTCAL_ON', 'každé');
define('_MD_EXTCAL_OR_THE', 'nebo');
define('_MD_EXTCAL_DAY_NUM_MONTH', '(Číslo dne v měsíci)');
define('_MD_EXTCAL_YEARS', 'roku/roků');
define('_MD_EXTCAL_SAME_ST_DATE', 'Stejné jako datum zahájení události');
define('_CHECKALL', 'Zaškrtnout vše');

define('_MD_EXTCAL_1_MO', '1.'._CAL_MONDAY);
define('_MD_EXTCAL_1_TU', '1.'._CAL_TUESDAY);
define('_MD_EXTCAL_1_WE', '1.'._CAL_WEDNESDAY);
define('_MD_EXTCAL_1_TH', '1.'._CAL_THURSDAY);
define('_MD_EXTCAL_1_FR', '1.'._CAL_FRIDAY);
define('_MD_EXTCAL_1_SA', '1.'._CAL_SATURDAY);
define('_MD_EXTCAL_1_SU', '1.'._CAL_SUNDAY);
define('_MD_EXTCAL_2_MO', '2.'._CAL_MONDAY);
define('_MD_EXTCAL_2_TU', '2.'._CAL_TUESDAY);
define('_MD_EXTCAL_2_WE', '2.'._CAL_WEDNESDAY);
define('_MD_EXTCAL_2_TH', '2.'._CAL_THURSDAY);
define('_MD_EXTCAL_2_FR', '2.'._CAL_FRIDAY);
define('_MD_EXTCAL_2_SA', '2. '._CAL_SATURDAY);
define('_MD_EXTCAL_2_SU', '2. '._CAL_SUNDAY);
define('_MD_EXTCAL_3_MO', '3. '._CAL_MONDAY);
define('_MD_EXTCAL_3_TU', '3. '._CAL_TUESDAY);
define('_MD_EXTCAL_3_WE', '3. '._CAL_WEDNESDAY);
define('_MD_EXTCAL_3_TH', '3. '._CAL_THURSDAY);
define('_MD_EXTCAL_3_FR', '3. '._CAL_FRIDAY);
define('_MD_EXTCAL_3_SA', '3. '._CAL_SATURDAY);
define('_MD_EXTCAL_3_SU', '3. '._CAL_SUNDAY);
define('_MD_EXTCAL_4_MO', '4. '._CAL_MONDAY);
define('_MD_EXTCAL_4_TU', '4. '._CAL_TUESDAY);
define('_MD_EXTCAL_4_WE', '4. '._CAL_WEDNESDAY);
define('_MD_EXTCAL_4_TH', '4. '._CAL_THURSDAY);
define('_MD_EXTCAL_4_FR', '4. '._CAL_FRIDAY);
define('_MD_EXTCAL_4_SA', '4. '._CAL_SATURDAY);
define('_MD_EXTCAL_4_SU', '4. '._CAL_SUNDAY);
define('_MD_EXTCAL_LAST_MO', 'Poslední '._CAL_MONDAY);
define('_MD_EXTCAL_LAST_TU', 'Poslední '._CAL_TUESDAY);
define('_MD_EXTCAL_LAST_WE', 'Poslední '._CAL_WEDNESDAY);
define('_MD_EXTCAL_LAST_TH', 'Poslední '._CAL_THURSDAY);
define('_MD_EXTCAL_LAST_FR', 'Poslední '._CAL_FRIDAY);
define('_MD_EXTCAL_LAST_SA', 'Poslední '._CAL_SATURDAY);
define('_MD_EXTCAL_LAST_SU', 'Poslední '._CAL_SUNDAY);
define('_MD_EXTCAL_MO2', 'Po');
define('_MD_EXTCAL_TU2', 'Út');
define('_MD_EXTCAL_WE2', 'St');
define('_MD_EXTCAL_TH2', 'Ct');
define('_MD_EXTCAL_FR2', 'Pa');
define('_MD_EXTCAL_SA2', 'So');
define('_MD_EXTCAL_SU2', 'Ne');
define('_MD_EXTCAL_JAN', 'Led');
define('_MD_EXTCAL_FEB', 'Ún');
define('_MD_EXTCAL_MAR', 'Bře');
define('_MD_EXTCAL_APR', 'Dub');
define('_MD_EXTCAL_MAY', 'Kvě');
define('_MD_EXTCAL_JUN', 'Črn');
define('_MD_EXTCAL_JUL', 'Črc');
define('_MD_EXTCAL_AUG', 'Srp');
define('_MD_EXTCAL_SEP', 'Zář');
define('_MD_EXTCAL_OCT', 'Říj');
define('_MD_EXTCAL_NOV', 'Lis');
define('_MD_EXTCAL_DEC', 'Pro');

define('_MD_EXTCAL_RR_DAILY', 'Každý den během %u dnů');
define('_MD_EXTCAL_RR_WEEKLY', 'Každý týden, den: %s , počet týdnů: %u');
define('_MD_EXTCAL_RR_MONTHLY', 'Každý měsíc, den: %s , počet měsíců: %u');
define('_MD_EXTCAL_RR_YEARLY', 'Každý rok, den: %s , měsíc: %s , počet roků: %u ');

define('_MD_EXTCAL_FEED', 'RSS kanál');
define('_MD_EXTCAL_PRINT', 'Vytisknout událost');
define('_MD_EXTCAL_DELETE', 'Smazat událost');
?>