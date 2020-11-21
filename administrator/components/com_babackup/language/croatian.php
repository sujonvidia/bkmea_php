<?php
/**
* bigAPE Site Backup 1.1 for Mambo CMS
* @version $Id: croatian.php,v 1.1 2006/04/09 09:17:28 morshed Exp $
* @package baBackup
* @copyright (C) 1998 - 2005 bigAPE Development Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.bigape.co.uk.com/
* -------------------------------------------
* Language Translation File
* Creator: Alex Maddern
* Email: mambo@bigape.co.uk
* Revision: 1.1
* Date: April 2005
*/


// ensure this file is being included by a parent file */
defined( "_VALID_MOS" ) or die( "Direct Access to this location is not allowed." );

// -- General ----------------------------------------------------------------------
DEFINE("_BIGAPE_BACKUP_COM_TITLE"                 , "Sacuvaj Site");
DEFINE("_BIGAPE_BACKUP_COM_TITLE_CONFIRM"         , "Potvrdi Izbor Foldera");

DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_SHOW"         , "Arhiva Files");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_SHOWDB"       , "Arhive Datoteka");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_EXAMINE"      , "Pregledaj Datoteku");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_CONFIRM"      , "Opcije za Arhiviranje");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_GENERATE"     , "Arhiviranje Završeno");

DEFINE("_BIGAPE_BACKUP_COL_FILENAME"              , "Sacuvaj Set");
DEFINE("_BIGAPE_BACKUP_COL_DOWNLOAD"              , "Prenesi Podatke Na Moj Kompjuter");
DEFINE("_BIGAPE_BACKUP_COL_SIZE"                  , "Velicina Set-a");
DEFINE("_BIGAPE_BACKUP_COL_DATE"                  , "Datum Kada je Sacuvano");
DEFINE("_BIGAPE_BACKUP_COL_FOLDER"                , "Folderi");
DEFINE("_BIGAPE_BACKUP_COL_MODE"                  , "Nacin");
DEFINE("_BIGAPE_BACKUP_COL_MODIFIED"              , "Zadnje Modificirano");
DEFINE("_BIGAPE_BACKUP_COL_TYPE"                  , "Vrsta");

DEFINE("_BIGAPE_BACKUP_DELETE_FILE_SUCCESS"       , "File(s) Izbrisane");
DEFINE("_BIGAPE_BACKUP_DELETE_FILE_FAILED"        , "Brisanje file(s) NEUSPJEŠNO");
DEFINE("_BIGAPE_BACKUP_DOWNLOAD_TITLE"            , "Prenesi Ovaj Arhiviran Set Na Moj Kompjuter");

DEFINE("_BIGAPE_BACKUP_DBBACKUP_SUCCESS"          , "Kopija Datoteke Kreirana");

DEFINE("_BIGAPE_BACKUP_SAFE_MODE_ON"              , "<b>Pozor</b><br/>Va PHP.INI file je namješten sa <b>Safe Mode</b> omogucenim. Ovaj komponent pokuša da produži maksimalno vrijeme za izvodenje skripte na 5 minuta, da omoguci sacuvanje vecih file sistema. Medutim, Safe Mode onemoguci uspijeh ove radnje, I vaša sadašnja PHP podešavanja ce uzrokovati grešku u ovom procesu ako proces potraje duže od <u>{1} sekunde(a)</u>. Taj limit se može produžiti tako da se promijeni \"max_execution_time\" podešavanje u PHP.INI");

DEFINE("_BIGAPE_BACKUP_ARCHIVE_NAME"              , "Ime Arhive");
DEFINE("_BIGAPE_BACKUP_NUMBER_FOLDERS"            , "Broj Foldera");
DEFINE("_BIGAPE_BACKUP_NUMBER_FILES"              , "Broj Files");
DEFINE("_BIGAPE_BACKUP_SIZE_ORIGINAL"             , "Velicina Originalne File");
DEFINE("_BIGAPE_BACKUP_SIZE_ARCHIVE"              , "Velicina Arhive");
DEFINE("_BIGAPE_BACKUP_DATABASE_ARCHIVE"          , "Arhiva Datoteke");
DEFINE("_BIGAPE_BACKUP_EMAIL_ARCHIVE"             , "Isporuka Email-a");

DEFINE("_BIGAPE_BACKUP_SELECT_ONE_FILE"           , "Molim da izaberite samo jedan arhivni file ");
DEFINE("_BIGAPE_BACKUP_ERROR_GETTING_CONTENTS"    , "Greška u Pregledu Sadržaja Arhive");
DEFINE("_BIGAPE_BACKUP_EXAMINING_CONTENTS"        , "Pregled Sadržaja File ");

DEFINE("_BIGAPE_BACKUP_CONFIRM_INSTRUCTIONS"      , "<b>Upute</b><br/>Molim da izaberete foldere koje vi želite da arhivirate.<br/><i>Budite svijesni da folder za pohranu vaše kopije nije izabran u pocetku.</i>");
DEFINE("_BIGAPE_BACKUP_CONFIRM_DATABASE"          , "Sacuvaj datodeku I uracunaj ju u ovom sacuvanom setu");
DEFINE("_BIGAPE_BACKUP_CONFIRM_EMAIL"             , "Kada proces završi, pošalji kopiju arhive na ovu adresu");

DEFINE("_BIGAPE_BACKUP_DATABASE_EXCLUDED"         , "Neobuhvaceno");
DEFINE("_BIGAPE_BACKUP_DATABASE_MISSING_TABLES"   , "Greška: Opis tabele nije naden");
DEFINE("_BIGAPE_BACKUP_DATABASE_BACKUP_FAILED"    , "Kopija podataka NEUSPJEŠNA");
DEFINE("_BIGAPE_BACKUP_DATABASE_BACKUP_COMPLETED" , "Kopija podataka uspiješna");

DEFINE("_BIGAPE_BACKUP_EMAIL_EXCLUDED"            , "Nije omoguceno");
DEFINE("_BIGAPE_BACKUP_EMAIL_FAILED"              , "Dostava Email-a Nije Uspijela");
DEFINE("_BIGAPE_BACKUP_EMAIL_COMPLETED"           , "Završeno");

DEFINE("_BIGAPE_BACKUP_EMAIL_SUBJECT"             , "bigAPE Site Arhiva - Dostava Datoteke");
DEFINE("_BIGAPE_BACKUP_EMAIL_MESSAGE"             , "Sljedeca datoteka je prliožena:");

DEFINE("_BIGAPE_BACKUP_MENU_BACK"                 , "Natrag");
DEFINE("_BIGAPE_BACKUP_MENU_CONTINUE"             , "Nastavi");
DEFINE("_BIGAPE_BACKUP_MENU_CANCEL"               , "Poništi");
DEFINE("_BIGAPE_BACKUP_MENU_GENERATE"             , 'Proizvedi kopiju podataka');
DEFINE("_BIGAPE_BACKUP_MENU_EXAMINE"              , 'Pregledaj kopiju podataka');

DEFINE("_BIGAPE_BACKUP_COM_HELP"                  , '
      <a href="http://www.bigape.co.uk"><img src="http://bigape.co.uk/images/stories/banners/banner-backup-component.jpg" border=0></a><br/>
      <h2>bigAPE Backup</h2>
      <b>Pozadina</b><br/>
      Kroz menadžment od nekoliko Mambo sites, mi smo naišli potrebu da se arhivira cijeli Mambo file sistem i<br/>datotka u jednu komprimiranu arhivu.
      <br/><br/>
      <b>Rješenje</b><br/>
      Mi smo pokušali da upotrebimo postojece Mambo API sposbnosti gdje moguce, i smo primjenili bazicni sistem za arhiviranje cijeloga site-a. <br/>
      Ta komponenta nije otvorena za klijente - funkcionalnost je kontrolirana samo kroz administrativne stranice.<br/>
      Ova kompnenta je razvijena da bude što lakše moguca za upotrebu.<br/><br/>
      <b>Kompatibilnost</b><br/>
      Mi smo testirali ovu komponentu sa sljidecim Mambo konfiguracijama:<ul>
      <li>Linux, Apache, MySQL</li>
      <li>Windows XP/2000/2003, Apache, MySQL</li>
      <li>Windows XP/2000/2003, IIS, MySQL</li>
      <li>Mac OSX, Apache, MySQL (untested)</li>
      <li>Mambo v4.5.1 (ili viša verzija)</li>
      </ul>
      <b>Mogucnosti</b><br/>
      Ova komponenta omogucava arhiviranje site-a. Slijedece mogucnosti su ponudene za sada:<ul>
      <li>Mogucnost da se presnimi cijli Mambo file i datoteka sistem u komprimiranu file-u.</li>
      <li>Mogucnost da se izabere koji folder da se ukljuci i koji da se iskljuci iz procesa arhiviranja. </li>
      <li>Mogucnost da se presnimi i rukovodi sa arhivama Mambo file sistema.</li>
      <li>Mogucnost da se generira, presnimi i rukovodi sa arhivama Mambo mySQL datoteka.</li>
      <li>Arhive file-a su jedinstvene za Mambo instalciju, bazirane na vrijeme nijhove kreacije, i na tajnoga kljuca. </li>
      <li>Arhiva iskljucuje postojece arhivirane setove, da se ocuva mijesta na disku.</li>
      </ul>
      <b>Vodic za korisnike</b><br/>
      Vodic za korisnike programa je ukljucen u standardnom instalacijskom paketu <a href="components/com_babackup/docs/babackup_user_guide.pdf" target="_new"><b>bigAPE Backup User Guide (PDF)</b></a><br/>
      <br/><br/>
      <b>Prevodenje</b><br/>
      Sljedece osobe su darovali njihovo vrijeme i sposobnosti za prevodenje stranih jezika:<ul>
      <li>Polish - Adam Sobkowicz (www.mambosite.net)</li>
      <li>Hebrew - Elad Shmitank</li>
      <li>French - Benoit Goeyvaerts</li>
      <li>Português Brasileiro - Bruno Carvalho (www.criativ.pro.br)</li>
      <li>Hrvatski - Nikola Milcic</li>
      <li>Danish - Ole Bang Ottosen (www.ot2sen.dk)</li>
      </ul>
      bigAPE Development Ltd &copy; 1998-2005 | <a href="http://www.bigape.co.uk">www.bigape.co.uk</a>
      <br/><p/><br/>
');

?>


