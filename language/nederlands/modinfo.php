<?php

define('_MI_ICALENDAR_NAME', 'Calendar');
define('_MI_ICALENDAR_DESC','ImpressCMS Calendar Module');

define('_MI_ICALENDAR_SUBMIT_EVENT','Nieuwe afspraak');

// Admin Menu
define("_MI_ICALENDAR_INDEX", "Index");
define("_MI_ICALENDAR_CATEGORY", "Categorie");
define("_MI_ICALENDAR_EVENT", "Afspraak");
define("_MI_ICALENDAR_PERMISSIONS", "Bevoegdheden");
define("_MI_ICALENDAR_PRUNING", "Verwijderen");

// Block
define("_MI_ICALENDAR_BNAME1", "Minical");
define("_MI_ICALENDAR_BNAME1_DESC", "Mini kalendar block");
define("_MI_ICALENDAR_BNAME2", "Belangrijke afspraak");
define("_MI_ICALENDAR_BNAME2_DESC", "Laat belangrijke afspraak zien");
define("_MI_ICALENDAR_BNAME3", "Volgende afspraak");
define("_MI_ICALENDAR_BNAME3_DESC", "Laat X volgende afspraken zien");
define("_MI_ICALENDAR_BNAME4", "Afspraken van vandaag");
define("_MI_ICALENDAR_BNAME4_DESC", "Laat afspraken van vandaag zien");
define("_MI_ICALENDAR_BNAME5", "Nieuwe afspraak");
define("_MI_ICALENDAR_BNAME5_DESC", "Laat X nieuwe afspraken zien");
define("_MI_ICALENDAR_BNAME6", "Willekeurige afspraak");
define("_MI_ICALENDAR_BNAME6_DESC", "Laat X willekeurige afspraken zien");

// Preferences
define("_MI_ICALENDAR_START_PAGE", "Module hoofd pagina"); 
define("_MI_ICALENDAR_MONTH_CALENDAR", "Maand(kalender)");
define("_MI_ICALENDAR_WEEKLY_CALENDAR", "Week (kalender)");
define("_MI_ICALENDAR_YEARLY_VIEW", "Jaar (Lijt)");
define("_MI_ICALENDAR_MONTHLY_VIEW", "Maand (Lijst)");
define("_MI_ICALENDAR_WEEKLY_VIEW", "Week (Lijst)");
define("_MI_ICALENDAR_DAILY_VIEW", "Dag (Lijst)");
define("_MI_ICALENDAR_WEEK_START_DAY", "Eerste dag vd Week");
define("_MI_ICALENDAR_WEEK_START_DAY_DESC", "Eerste dag van de week in overzicht kalender");
define("_MI_ICALENDAR_SUNDAY", "Zondag");
define("_MI_ICALENDAR_MONDAY", "Maandag");
define("_MI_ICALENDAR_TUESDAY", "Dinsdag");
define("_MI_ICALENDAR_WEDNESDAY", "Woensdag");
define("_MI_ICALENDAR_THURSDAY", "Donderdag");
define("_MI_ICALENDAR_FRIDAY", "Vrijdag");
define("_MI_ICALENDAR_SATURDAY", "Zaterdag");
define("_MI_ICALENDAR_RSS_CACHE_TIME", "RSS cache tijd");
define("_MI_ICALENDAR_RSS_CACHE_TIME_DESC", "Tijd waarna de RSS cache ververst wordt");
define("_MI_ICALENDAR_RSS_NB_EVENT", "Aantal RSS afspraken");
define("_MI_ICALENDAR_RSS_NB_EVENT_DESC", "Aantal afspraken dat op een RSS pagina wordt geplaatst");
define("_MI_ICALENDAR_WHOS_GOING", "'Wie gaat ermee' optie ");
define("_MI_ICALENDAR_WHOS_GOING_DESC", "Zet de optie 'wie gaat er mee?' aan of uit");
define("_MI_ICALENDAR_WHOSNOT_GOING", "'Wie gaat er niet mee? optie");
define("_MI_ICALENDAR_WHOSNOT_GOING_DESC", "Zet de optie 'wie gaat er niet mee' aan of uit");
define("_MI_ICALENDAR_SORT_ORDER", "Sortering lijsten");
define("_MI_ICALENDAR_SORT_ORDER_DESC", "Bepaal hoe de lijstweergaven worden gesorteerd (standaard op start datum)");
define("_MI_ICALENDAR_ASCENDING", "Oplopend");
define("_MI_ICALENDAR_DESCENDING", "Aflopend");
define("_MI_ICALENDAR_EY_DATE_PATTERN", "Afspraak : datum weergave in het jaaroverzicht");
define("_MI_ICALENDAR_EY_DATE_PATTERN_DESC", "Kijk voor geldige datumformaten op http://www.php.net/manual/en/function.date.php");
define("_MI_ICALENDAR_EY_DATE_PATTERN_VALUE", "j/m/Y");
define("_MI_ICALENDAR_NM_DATE_PATTERN", "Navig : Datum weergave in het maandoverzicht");
define("_MI_ICALENDAR_NM_DATE_PATTERN_DESC", "Kijk voor geldige datumformaten op http://www.php.net/manual/en/function.date.php");
define("_MI_ICALENDAR_NM_DATE_PATTERN_VALUE", "F Y");
define("_MI_ICALENDAR_EM_DATE_PATTERN", "Afspraak : Datum weergave in het maandoverzicht");
define("_MI_ICALENDAR_EM_DATE_PATTERN_DESC", "Kijk voor geldige datumformaten op http://www.php.net/manual/en/function.date.php");
define("_MI_ICALENDAR_EM_DATE_PATTERN_VALUE", "j/m/Y");
define("_MI_ICALENDAR_NW_DATE_PATTERN", "Navig : Datum weergave in het weekoverzicht");
define("_MI_ICALENDAR_NW_DATE_PATTERN_DESC", "Kijk voor geldige datumformaten op http://www.php.net/manual/en/function.date.php");
define("_MI_ICALENDAR_NW_DATE_PATTERN_VALUE", "j F Y");
define("_MI_ICALENDAR_EW_DATE_PATTERN", "Afspraak : Datum weergave in het weekoverzicht");
define("_MI_ICALENDAR_EW_DATE_PATTERN_DESC", "Kijk voor geldige datumformaten op http://www.php.net/manual/en/function.date.php");
define("_MI_ICALENDAR_EW_DATE_PATTERN_VALUE", "j/m/Y");
define("_MI_ICALENDAR_ND_DATE_PATTERN", "Navig : Datum weergave in het dagoverzicht");
define("_MI_ICALENDAR_ND_DATE_PATTERN_DESC", "Kijk voor geldige datumformaten op http://www.php.net/manual/en/function.date.php");
define("_MI_ICALENDAR_ND_DATE_PATTERN_VALUE", "l j F Y");
define("_MI_ICALENDAR_ED_DATE_PATTERN", "Afspraak : Datum weergave in het dagoverzicht");
define("_MI_ICALENDAR_ED_DATE_PATTERN_DESC", "Kijk voor geldige datumformaten op http://www.php.net/manual/en/function.date.php");
define("_MI_ICALENDAR_ED_DATE_PATTERN_VALUE", "j/m/Y");
define("_MI_ICALENDAR_EE_DATE_PATTERN", "Afspraak: datum weergave in het afspraakoverzicht ");
define("_MI_ICALENDAR_EE_DATE_PATTERN_DESC", "Kijk voor geldige datumformaten op http://www.php.net/manual/en/function.date.php");
define("_MI_ICALENDAR_EE_DATE_PATTERN_VALUE", "l dS \of F Y h:i:s A");
define("_MI_ICALENDAR_EB_DATE_PATTERN", "Afspraak: Datumweergave van Blocks");
define("_MI_ICALENDAR_EB_DATE_PATTERN_DESC", "Kijk voor geldige datumformaten op http://www.php.net/manual/en/function.date.php");
define("_MI_ICALENDAR_EB_DATE_PATTERN_VALUE", "j/m/Y");
define("_MI_ICALENDAR_DISP_PAST_E_LIST", "Laat vorige afspraak zien in (Lijst)");
define("_MI_ICALENDAR_DISP_PAST_E_LIST_DESC", "");
define("_MI_ICALENDAR_DISP_PAST_E_CAL", "Laat vorige afspraak zien in (Kalender)");
define("_MI_ICALENDAR_DISP_PAST_E_CAL_DESC", "");
define("_MI_ICALENDAR_FILE_EXTENTION", "Bestandsformaat van de bijlagen");
define("_MI_ICALENDAR_FILE_EXTENTION_DESC", "Geef aan welke bestandsformaten mogen worden gebruikt als bijlage bij een afspraak");
define("_MI_ICALENDAR_HTML", "HTML toestaan");
define("_MI_ICALENDAR_HTML_DESC", "Sta HTML toe of niet voor tekst weergave");

// Notifications
define("_MI_ICALENDAR_GLOBAL_NOTIFY", "Alle berichten");
define("_MI_ICALENDAR_GLOBAL_NOTIFYDSC", "Stuur bericht voor afspraken in alle categoriën");
define("_MI_ICALENDAR_CAT_NOTIFY", "Categorie berichten");
define("_MI_ICALENDAR_CAT_NOTIFYDSC", "Stuur bericht voor een bepaalde categorie");
define("_MI_ICALENDAR_EVENT_NOTIFY", "Afspraak");
define("_MI_ICALENDAR_EVENT_NOTIFYDSC", "Stuur bericht van afspraak");
define("_MI_ICALENDAR_NEW_EVENT_NOTIFY", "Nieuwe afspraak");
define("_MI_ICALENDAR_NEW_EVENT_NOTIFYCAP", "Laat mij weten wanneer een nieuwe afspraak is ingepland");
define("_MI_ICALENDAR_NEW_EVENT_NOTIFYDSC", "Ontvang een bericht van nieuwe afspraken");
define("_MI_ICALENDAR_NEW_EVENT_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} automatisch bericht : Nieuwe afspraak gepland");
define("_MI_ICALENDAR_NEW_EVENT_PENDING_NOTIFY", "Nieuwe afspraak in wachtrij");
define("_MI_ICALENDAR_NEW_EVENT_PENDING_NOTIFYCAP", "Laat mij weten wanneer een afspraak is gepland maar niet automatich is goedgekeurd");
define("_MI_ICALENDAR_NEW_EVENT_PENDING_NOTIFYDSC", "ontvang een bericht als een afspraak is gepland maar niet automatich is goedgekeurd");
define("_MI_ICALENDAR_NEW_EVENT_PENDING_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} automatisch bericht : Nieuwe afspraak gepland maar nog niet goedgekeurd");
define("_MI_ICALENDAR_NEW_EVENT_CAT_NOTIFY", "Nieuwe afspraak");
define("_MI_ICALENDAR_NEW_EVENT_CAT_NOTIFYCAP", "Stuur mij een bericht als een afspraak is gepland in deze categorie");
define("_MI_ICALENDAR_NEW_EVENT_CAT_NOTIFYDSC", "Ontvang een bericht als een afspraak is gepland in een bepaalde categorie");
define("_MI_ICALENDAR_NEW_EVENT_CAT_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} automatisch bericht : Nieuwe afspraak gepland");

?>