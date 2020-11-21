<?php
/**
* bigAPE Site Backup 1.1 for Mambo CMS
* @version $Id: polish.php,v 1.1 2006/04/09 09:17:28 morshed Exp $
* @package baBackup
* @copyright (C) 1998 - 2005 bigAPE Development Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.bigape.co.uk.com/
* -------------------------------------------
* Language Translation File
* Creator: Alex Maddern
* Email: mambo@bigape.co.uk
* Translator: Adam Sobkowicz(www.mambosite.net)
* Email: admin@mambosite.net
* Revision: 1.1
* Date: April 2005
*/

// ensure this file is being included by a parent file */
defined( "_VALID_MOS" ) or die( "Direct Access to this location is not allowed." );

// -- General ----------------------------------------------------------------------
DEFINE("_COM_TITLE"                 , "Backup Site'u'");
DEFINE("_COM_TITLE_CONFIRM"         , "Potwierdzanie Wyboru Katalogu");

DEFINE("_SCREEN_TITLE_SHOW"         , "Pliki Archiwalne");
DEFINE("_SCREEN_TITLE_SHOWDB"       , "Archiwa Bazy Danych");
DEFINE("_SCREEN_TITLE_EXAMINE"      , "Testuj Archiwum");
DEFINE("_SCREEN_TITLE_CONFIRM"      , "Opcje Backupu");
DEFINE("_SCREEN_TITLE_GENERATE"     , "Wykonanie Backup'u'");

DEFINE("_COL_FILENAME"              , "Plik Backup'u'");
DEFINE("_COL_DOWNLOAD"              , "Download");
DEFINE("_COL_SIZE"                  , "Rozmiar Pliku");
DEFINE("_COL_DATE"                  , "Data Backup'u'");
DEFINE("_COL_FOLDER"                , "Foldery");
DEFINE("_COL_MODE"                  , "Tryb");
DEFINE("_COL_MODIFIED"              , "Ostatnio zmieniony");
DEFINE("_COL_TYPE"                  , "Typ");

DEFINE("_DELETE_FILE_SUCCESS"       , "Plik(i) skasowne");
DEFINE("_DELETE_FILE_FAILED"        , "Usuwanie plik�w NIE UDANE");
DEFINE("_DOWNLOAD_TITLE"            , "Pobierz ten plik z Backup'em'");

DEFINE("_DBBACKUP_SUCCESS"          , "Utworzono Backup Bazy Danych");

DEFINE("_SAFE_MODE_ON"              , "<b>Uwaga</b><br/>Tw�j plik PHP.INI jest skonfigurowany z w��czonym <b>Safe Mode</b>. Ten komponent b�dzie pr�bowa� rozszerzy� czas wykonania skryptu do 5 minut w celu umo�liwienia zrobienia backup'u du�ego systemu plik�w, jednak�e Safe Mode wy��cza t� akcj� a twoje bie��ce ustawienia PHP s� przyczyn� zako�czenia procesu wykonywania backup'u z b��dem je�li zabiera to wi�cej ni� <u>{1} seconds</u>. Mo�e to by� rozszerzone poprzez zmodyfikowanie ustawie� \"max_execution_time\" w PHP.INI");

DEFINE("_ARCHIVE_NAME"              , "Nazwa archiwum");
DEFINE("_NUMBER_FOLDERS"            , "Liczba Folder�w");
DEFINE("_NUMBER_FILES"              , "Liczba Plik�w");
DEFINE("_SIZE_ORIGINAL"             , "Rozmiar Orginalnego Pliku");
DEFINE("_SIZE_ARCHIVE"              , "Rozmiar Archiwum");
DEFINE("_DATABASE_ARCHIVE"          , "Backup Bazy Danych");
DEFINE("_EMAIL_ARCHIVE"             , "Email Delivery");

DEFINE("_SELECT_ONE_FILE"           , "Wybierz tylko jeden plik archiwalny");
DEFINE("_ERROR_GETTING_CONTENTS"    , "B��d testowania zawarato�ci Archiwum");
DEFINE("_EXAMINING_CONTENTS"        , "Testowanie zawarto�ci plik�w ");

DEFINE("_CONFIRM_INSTRUCTIONS"      , "<b>Instrukcje</b><br/>Wybierz katalogi, kt�re chcesz archiwizowa�<br/><i>Musisz wiedzie�, �� katalog do przechowywania nie jest wybierany domy�lnie</i>");
DEFINE("_CONFIRM_DATABASE"          , "Backup bazy danych i umie�� go w tym archiwum");
DEFINE("_CONFIRM_EMAIL"             , "Wy�lij kopi� archiwum na ten adres po zako�czeniu");

DEFINE("_DATABASE_EXCLUDED"         , "Wy��czony");
DEFINE("_DATABASE_MISSING_TABLES"   , "Error: Definicje Tabel nie znalezione");
DEFINE("_DATABASE_BACKUP_FAILED"    , "Backup NIE UDANY");
DEFINE("_DATABASE_BACKUP_COMPLETED" , "Backup Zako�czono");

DEFINE("_EMAIL_EXCLUDED"            , "Nie w��czono");
DEFINE("_EMAIL_FAILED"              , "Wys�anie mailem nie powiod�o si�");
DEFINE("_EMAIL_COMPLETED"           , "Zako�czono");

DEFINE("_EMAIL_SUBJECT"             , "Mambo - bigAPE Site Backup - Dostarczono Archiwum");
DEFINE("_EMAIL_MESSAGE"             , "Za��czono nast�puj�ce archiwum:");

DEFINE("_MENU_BACK"                 , "Wstecz");
DEFINE("_MENU_CONTINUE"             , "Kontunuuj");
DEFINE("_MENU_CANCEL"               , "Anuluj");
DEFINE("_MENU_GENERATE"             , 'Utw�rz Backup');
DEFINE("_MENU_EXAMINE"              , 'Testuj Backup');

DEFINE("_COM_HELP"                 , '
      <a href="http://www.bigape.co.uk"><img src="http://bigape.co.uk/images/stories/banners/banner-backup-component.jpg" border=0></a><br>
      <h2>bigAPE Backup</h2>
      <b>Wprowadzenie</b><br/>
      Podczas zarz�dzania kilkoma portalami Mambo pojawi�a si� konieczno�� zarchiwizowania ca�ego systemu plik�w Mambo i bazy danych w jednym skompresowanym archiwum.
      <br/><br/>
      <b>Rozwi�zanie</b><br/>
      Zamierzali�my wykorzysta� istniej�ce mo�liwo�ci API Mambo tam gdzie jest to mo�liwe i zaimplementowali�my podstawowy pe�ny system archiwizacji.<br/>
      Komponent nie ma interfejsu po stronie klienta a ca�a funkcjonalno�� jest dost�pna z poziomu panelu admina.<br/>
      Komponent zosta� tak zaprojektowany tak aby by� jak najprostszy.
      <br/><br/>
      <b>Kompatybilno��</b><br/>
      Przetestowali�my ten komponent na nast�puj�cych konfiguracjach pod Mambo:<ul>
      <li>Linux, Apache, MySQL</li>
      <li>Windows XP/2000/2003, Apache, MySQL</li>
      <li>Windows XP/2000/2003, IIS, MySQL</li>
      <li>Mac OSX, Apache, MySQL (untested)</li>
      <li>Mambo v4.5.1 (or above)</li>
      </ul>
      <b>Mo�liwo�ci</b><br/>
      Komponent dostarcza podstawow� funkcjonalno�� back up\'u. Aktualnie dost�pne s� nast�puj�ce mo�liwo�ci:<ul>
      <li>Kompresja ca�ego systemu plik�w Mambo w postaci skompresowanego pliku.</li>
      <li>Mo�liwo�� wyboru, kt�re foldery maj� by� w��czone lub wy��czone z archiwizacji</li>
      <li>Mo�liwo�� wygenerowania backup-u bazy MySQL i do��czenie go do pliku archiwalnego</li>
      <li>Mo�liwo�� downloadu albo skasowania plik�w z archiwami</li>
      <li>Backup wy��cza istniej�ce archiwa aby oszcz�dza� przestrze� serwera</li>
      </ul>
      <b>Przewodnik U�ytkownika</b><br/>
      W paczce instalacyjnej do��czono Przewodnik U�ytkownika Komponentu - <a href="components/com_babackup/docs/babackup_user_guide.pdf" target="_new"><b>bigAPE Backup User Guide (PDF)</b></a><br/>
      <br/><br/>
      <b>Translations</b><br/>
      Nast�puj�cy ludzie wsparli projekt w zakresie t�umacze�:<ul>
      <li>Polish - Adam Sobkowicz (www.mambosite.net)</li>
      <li>Hebrew - Elad Shmitank</li>
      <li>French - Benoit Goeyvaerts</li>
      <li>Portugu�s Brasileiro - Bruno Carvalho (www.criativ.pro.br)</li>
      <li>Hrvatski - Nikola Milcic</li>
      <li>Danish - Ole Bang Ottosen (www.ot2sen.dk)</li>
      </ul>
      bigAPE Development Ltd &copy; 1998-2005 | <a href="http://www.bigape.co.uk">www.bigape.co.uk</a>
      <br/><p/><br/>
');

?>

