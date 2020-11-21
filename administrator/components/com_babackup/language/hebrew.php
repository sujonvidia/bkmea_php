<?php
/**
* bigAPE Site Backup 1.1 for Mambo CMS
* @version $Id: hebrew.php,v 1.1 2006/04/09 09:17:28 morshed Exp $
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
DEFINE("_BIGAPE_BACKUP_COM_TITLE"                 , "גיבוי האתר");
DEFINE("_BIGAPE_BACKUP_COM_TITLE_CONFIRM"         , "אישור בחירת ספריות");

DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_SHOW"         , "גיבוי קבצים");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_SHOWDB"       , "ארכיון מסדי נתונים");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_EXAMINE"      , "בדיקת ארכיון");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_CONFIRM"      , "אפשרויות גיבוי");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_GENERATE"     , "הגיבוי הושלם");

DEFINE("_BIGAPE_BACKUP_COL_FILENAME"              , "מקבץ גיבויים");
DEFINE("_BIGAPE_BACKUP_COL_DOWNLOAD"              , "הורדה");
DEFINE("_BIGAPE_BACKUP_COL_SIZE"                  , "גודל המקבץ");
DEFINE("_BIGAPE_BACKUP_COL_DATE"                  , "תאריך הגיבוי");
DEFINE("_BIGAPE_BACKUP_COL_FOLDER"                , "ספריות");
DEFINE("_BIGAPE_BACKUP_COL_MODE"                  , "mode");
DEFINE("_BIGAPE_BACKUP_COL_MODIFIED"              , "שונה לאחרונה ב");
DEFINE("_BIGAPE_BACKUP_COL_TYPE"                  , "Type");

DEFINE("_BIGAPE_BACKUP_DELETE_FILE_SUCCESS"       , "מחיקה הושלמה");
DEFINE("_BIGAPE_BACKUP_DELETE_FILE_FAILED"        , "תקלה בנסיון המחיקה");
DEFINE("_BIGAPE_BACKUP_DOWNLOAD_TITLE"            , "הורדת הגיבוי");

DEFINE("_BIGAPE_BACKUP_DBBACKUP_SUCCESS"          , "גיבוי מסד נתונים הושלם");

DEFINE("_BIGAPE_BACKUP_SAFE_MODE_ON"              , "<b>אזהרה!</b><br/> קובץ ה PHP.INI שברשותך מוגדר במצב <b>מצב בטוח</b> פעיל. רכיב זה מנסה להאריך את זמן הפעולה של הקוד ל 5 דקות על מנת לאפשר יצירת גיבוי של מערכות גדולות יותר, אולם מצב בטוח מונע פעולה זאת והגדרות ה PHP שברשותך יגרמו לתהליך הגיבוי להפסיק עם הודעת שגיאה אם הוא יארך יותר מ <u>(1) שניות</u>. אפשר להאריך את הפעולה על ידי שינוי הגדרת ה \"max_execution_time\" אשר נמצאת בקובץ PHP.INI");
DEFINE("_BIGAPE_BACKUP_ARCHIVE_NAME"              , "שם הארכיון");
DEFINE("_BIGAPE_BACKUP_NUMBER_FOLDERS"            , "מספר הספריות");
DEFINE("_BIGAPE_BACKUP_NUMBER_FILES"              , "מספר הקבצים");
DEFINE("_BIGAPE_BACKUP_SIZE_ORIGINAL"             , "גודל הקובץ המקורי");
DEFINE("_BIGAPE_BACKUP_SIZE_ARCHIVE"              , "גודל הארכיון");
DEFINE("_BIGAPE_BACKUP_DATABASE_ARCHIVE"          , "גיבוי מסד נתונים");
DEFINE("_BIGAPE_BACKUP_EMAIL_ARCHIVE"             , "שליחת אימייל");

DEFINE("_BIGAPE_BACKUP_SELECT_ONE_FILE"           , "אנא בחר ארכיון אחד בלבד");
DEFINE("_BIGAPE_BACKUP_ERROR_GETTING_CONTENTS"    , "שגיאה בעת בדיקת תוכן הארכיון");
DEFINE("_BIGAPE_BACKUP_EXAMINING_CONTENTS"        , "בדיקת תוכן של הקובץ ");

DEFINE("_BIGAPE_BACKUP_CONFIRM_INSTRUCTIONS"      , "<b>הוראות</b><br/>אנא בחר את הספריות שברצונך לגבות<br/><i>שים לב כי ספרית היעד של הגיבוי אינה נבחרת כברירת מחדל</i>");
DEFINE("_BIGAPE_BACKUP_CONFIRM_DATABASE"          , "גבה את מסד הנתונים והוסף למקבץ הגיבויים הנוכחי");
DEFINE("_BIGAPE_BACKUP_CONFIRM_EMAIL"             , "שלח עותק של הארכיון לכתובת הבאה בעת הסיום");

DEFINE("_BIGAPE_BACKUP_DATABASE_EXCLUDED"         , "Excluded");
DEFINE("_BIGAPE_BACKUP_DATABASE_MISSING_TABLES"   , "שגיאה: לא נמצאו הגדרות טבלאה");
DEFINE("_BIGAPE_BACKUP_DATABASE_BACKUP_FAILED"    , "הגיבוי נכשל");
DEFINE("_BIGAPE_BACKUP_DATABASE_BACKUP_COMPLETED" , "הגיבוי הושלם בהצלחה");

DEFINE("_BIGAPE_BACKUP_EMAIL_EXCLUDED"            , "Not Enabled");
DEFINE("_BIGAPE_BACKUP_EMAIL_FAILED"              , "שגיאה בשליחת הדואר האימייל");
DEFINE("_BIGAPE_BACKUP_EMAIL_COMPLETED"           , "שליחת אימייל הושלמה");

DEFINE("_BIGAPE_BACKUP_EMAIL_SUBJECT"             , "גיבוי אתר - שליחת גיבוי");
DEFINE("_BIGAPE_BACKUP_EMAIL_MESSAGE"             , "מצורף הקובץ הבא:");

DEFINE("_BIGAPE_BACKUP_MENU_BACK"                 , "חזרה");
DEFINE("_BIGAPE_BACKUP_MENU_CONTINUE"             , "המשך");
DEFINE("_BIGAPE_BACKUP_MENU_CANCEL"               , "ביטול");
DEFINE("_BIGAPE_BACKUP_MENU_GENERATE"             , 'צור גיבוי');
DEFINE("_BIGAPE_BACKUP_MENU_EXAMINE"              , 'בדוק גיבוי');

DEFINE("_BIGAPE_BACKUP_COM_HELP"                  , '
      <a href="http://www.bigape.co.uk"><img src="http://bigape.co.uk/images/stories/banners/banner-backup-component.jpg" border=0></a><br/>
      <h2>bigAPE גיבוי</h2>
      <b>רקע</b><br/>
      במהלך הניהול של מספר אתרים מבוססי Mambo נתקלנו בצורך לגבות את כל מאגר הקבצים ומסדי הנתוים<br/> אל תוך ארכיון מקובץ אחד
      <br/><br/>
      <b>פתרון</b><br/>
      ניסינו להשתמש בכמה שיותר מאפיינים קיימים של Mambo API שיכולנו ויישמנו מערכת בסיסית לגיבוי מלא של האתר.<br/>
      לרכיב זה אין ממשק למשתמש והוא כולו מנוהל דרך מסכי האדמיניסטרציה.<br/>
      רכיב זה תוכן להיות פשוט עד כמה שאפשר.
      <br/><br/>
      <b>תאימות מערכת</b><br/>
      בדקנו את הרכיב הזה בהגדרות הMambo הבאות:<ul>
      <li>Linux, Apache, MySQL</li>
      <li>Windows XP/2000/2003, Apache, MySQL</li>
      <li>Windows XP/2000/2003, IIS, MySQL</li>
      <li>Mac OSX, Apache, MySQL (untested)</li>
      <li>Mambo v4.5.1 (or above)</li>
      </ul>
      <b>מאפיינים</b><br/>
      רכיב זה מאפשר גיבוי מלא של האתר. המאפיינים הזמינים כעת הם:<ul>
      <li>אפשרות לגבות את כל הקבצים ומסדי הנתונים של מערכת ה Mambo אל תוך קובץ אחד</li>
      <li>אפשרות לבחור איזה ספריות ברצונך להכניס אל תוך הגיבוי</li>
      <li>אפשרות להוריד ולנהל את הארכיונים של ה Mambo</li>
      <li>אפשרות ליצור, להוריד ולנהל ארכיונים של מסדי נתונים של mySQL</li>
      <li>אבצי הארכיון יחודיים בהתבסס על זמן יצירת הארכיון בנוסף לקוד סודי</li>
      <li>הגיבוי אינו כולל קבצי גיבוי שכבר נמצאים בספריות על מנת לחסוך במקום</li>
      </ul>
      <b>מדריך למשתמש</b><br/>
      המדריך למשתמש מצורף בחבילת ההתקנה - <a href="components/com_babackup/docs/babackup_user_guide.pdf" target="_new"><b>גיבוי אתר - מדריך למשתמש(PDF)</b></a><br/>
      <br/><br/>
      <b>תירגומים</b><br/>
      אנו מודים לאנשים הבאים על תרומתם בתרגום<ul>
      <li>Polish - Adam Sobkowicz (www.mambosite.net)</li>
      <li>Hebrew - Elad Shmitank</li>
      <li>French - Benoit Goeyvaerts</li>
      <li>Portuguךs Brasileiro - Bruno Carvalho (www.criativ.pro.br)</li>
      <li>Hrvatski - Nikola Milcic</li>
      <li>Danish - Ole Bang Ottosen (www.ot2sen.dk)</li>
      </ul>
  bigAPE פיתוח בע"מ &copy; 1998-2005 | <a href="http://www.bigape.co.uk">www.bigape.co.uk</a>
      <br/><p/><br/>
');

?>
