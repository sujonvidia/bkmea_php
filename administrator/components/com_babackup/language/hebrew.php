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
DEFINE("_BIGAPE_BACKUP_COM_TITLE"                 , "����� ����");
DEFINE("_BIGAPE_BACKUP_COM_TITLE_CONFIRM"         , "����� ����� ������");

DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_SHOW"         , "����� �����");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_SHOWDB"       , "������ ���� ������");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_EXAMINE"      , "����� ������");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_CONFIRM"      , "�������� �����");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_GENERATE"     , "������ �����");

DEFINE("_BIGAPE_BACKUP_COL_FILENAME"              , "���� �������");
DEFINE("_BIGAPE_BACKUP_COL_DOWNLOAD"              , "�����");
DEFINE("_BIGAPE_BACKUP_COL_SIZE"                  , "���� �����");
DEFINE("_BIGAPE_BACKUP_COL_DATE"                  , "����� ������");
DEFINE("_BIGAPE_BACKUP_COL_FOLDER"                , "������");
DEFINE("_BIGAPE_BACKUP_COL_MODE"                  , "mode");
DEFINE("_BIGAPE_BACKUP_COL_MODIFIED"              , "���� ������� �");
DEFINE("_BIGAPE_BACKUP_COL_TYPE"                  , "Type");

DEFINE("_BIGAPE_BACKUP_DELETE_FILE_SUCCESS"       , "����� ������");
DEFINE("_BIGAPE_BACKUP_DELETE_FILE_FAILED"        , "���� ������ ������");
DEFINE("_BIGAPE_BACKUP_DOWNLOAD_TITLE"            , "����� ������");

DEFINE("_BIGAPE_BACKUP_DBBACKUP_SUCCESS"          , "����� ��� ������ �����");

DEFINE("_BIGAPE_BACKUP_SAFE_MODE_ON"              , "<b>�����!</b><br/> ���� � PHP.INI ������� ����� ���� <b>��� ����</b> ����. ���� �� ���� ������ �� ��� ������ �� ���� � 5 ���� �� ��� ����� ����� ����� �� ������ ������ ����, ���� ��� ���� ���� ����� ��� ������� � PHP ������� ����� ������ ������ ������ �� ����� ����� �� ��� ���� ���� � <u>(1) �����</u>. ���� ������ �� ������ �� ��� ����� ����� � \"max_execution_time\" ��� ����� ����� PHP.INI");
DEFINE("_BIGAPE_BACKUP_ARCHIVE_NAME"              , "�� �������");
DEFINE("_BIGAPE_BACKUP_NUMBER_FOLDERS"            , "���� �������");
DEFINE("_BIGAPE_BACKUP_NUMBER_FILES"              , "���� ������");
DEFINE("_BIGAPE_BACKUP_SIZE_ORIGINAL"             , "���� ����� ������");
DEFINE("_BIGAPE_BACKUP_SIZE_ARCHIVE"              , "���� �������");
DEFINE("_BIGAPE_BACKUP_DATABASE_ARCHIVE"          , "����� ��� ������");
DEFINE("_BIGAPE_BACKUP_EMAIL_ARCHIVE"             , "����� ������");

DEFINE("_BIGAPE_BACKUP_SELECT_ONE_FILE"           , "��� ��� ������ ��� ����");
DEFINE("_BIGAPE_BACKUP_ERROR_GETTING_CONTENTS"    , "����� ��� ����� ���� �������");
DEFINE("_BIGAPE_BACKUP_EXAMINING_CONTENTS"        , "����� ���� �� ����� ");

DEFINE("_BIGAPE_BACKUP_CONFIRM_INSTRUCTIONS"      , "<b>������</b><br/>��� ��� �� ������� ������� �����<br/><i>��� �� �� ����� ���� �� ������ ���� ����� ������ ����</i>");
DEFINE("_BIGAPE_BACKUP_CONFIRM_DATABASE"          , "��� �� ��� ������� ����� ����� �������� ������");
DEFINE("_BIGAPE_BACKUP_CONFIRM_EMAIL"             , "��� ���� �� ������� ������ ���� ��� �����");

DEFINE("_BIGAPE_BACKUP_DATABASE_EXCLUDED"         , "Excluded");
DEFINE("_BIGAPE_BACKUP_DATABASE_MISSING_TABLES"   , "�����: �� ����� ������ �����");
DEFINE("_BIGAPE_BACKUP_DATABASE_BACKUP_FAILED"    , "������ ����");
DEFINE("_BIGAPE_BACKUP_DATABASE_BACKUP_COMPLETED" , "������ ����� ������");

DEFINE("_BIGAPE_BACKUP_EMAIL_EXCLUDED"            , "Not Enabled");
DEFINE("_BIGAPE_BACKUP_EMAIL_FAILED"              , "����� ������ ����� �������");
DEFINE("_BIGAPE_BACKUP_EMAIL_COMPLETED"           , "����� ������ ������");

DEFINE("_BIGAPE_BACKUP_EMAIL_SUBJECT"             , "����� ��� - ����� �����");
DEFINE("_BIGAPE_BACKUP_EMAIL_MESSAGE"             , "����� ����� ���:");

DEFINE("_BIGAPE_BACKUP_MENU_BACK"                 , "����");
DEFINE("_BIGAPE_BACKUP_MENU_CONTINUE"             , "����");
DEFINE("_BIGAPE_BACKUP_MENU_CANCEL"               , "�����");
DEFINE("_BIGAPE_BACKUP_MENU_GENERATE"             , '��� �����');
DEFINE("_BIGAPE_BACKUP_MENU_EXAMINE"              , '���� �����');

DEFINE("_BIGAPE_BACKUP_COM_HELP"                  , '
      <a href="http://www.bigape.co.uk"><img src="http://bigape.co.uk/images/stories/banners/banner-backup-component.jpg" border=0></a><br/>
      <h2>bigAPE �����</h2>
      <b>���</b><br/>
      ����� ������ �� ���� ����� ������ Mambo ������ ����� ����� �� �� ���� ������ ����� ������<br/> �� ��� ������ ����� ���
      <br/><br/>
      <b>�����</b><br/>
      ������ ������ ���� ����� �������� ������ �� Mambo API ������� ������� ����� ������ ������ ��� �� ����.<br/>
      ����� �� ��� ���� ������ ���� ���� ����� ��� ���� �������������.<br/>
      ���� �� ���� ����� ���� �� ��� �����.
      <br/><br/>
      <b>������ �����</b><br/>
      ����� �� ����� ��� ������� �Mambo �����:<ul>
      <li>Linux, Apache, MySQL</li>
      <li>Windows XP/2000/2003, Apache, MySQL</li>
      <li>Windows XP/2000/2003, IIS, MySQL</li>
      <li>Mac OSX, Apache, MySQL (untested)</li>
      <li>Mambo v4.5.1 (or above)</li>
      </ul>
      <b>��������</b><br/>
      ���� �� ����� ����� ��� �� ����. ��������� ������� ��� ��:<ul>
      <li>������ ����� �� �� ������ ����� ������� �� ����� � Mambo �� ��� ���� ���</li>
      <li>������ ����� ���� ������ ������ ������ �� ��� ������</li>
      <li>������ ������ ����� �� ��������� �� � Mambo</li>
      <li>������ �����, ������ ����� �������� �� ���� ������ �� mySQL</li>
      <li>���� ������� ������� ������ �� ��� ����� ������� ����� ���� ����</li>
      <li>������ ���� ���� ���� ����� ���� ������ ������� �� ��� ����� �����</li>
      </ul>
      <b>����� ������</b><br/>
      ������ ������ ����� ������ ������ - <a href="components/com_babackup/docs/babackup_user_guide.pdf" target="_new"><b>����� ��� - ����� ������(PDF)</b></a><br/>
      <br/><br/>
      <b>��������</b><br/>
      ��� ����� ������ ����� �� ������ ������<ul>
      <li>Polish - Adam Sobkowicz (www.mambosite.net)</li>
      <li>Hebrew - Elad Shmitank</li>
      <li>French - Benoit Goeyvaerts</li>
      <li>Portugu�s Brasileiro - Bruno Carvalho (www.criativ.pro.br)</li>
      <li>Hrvatski - Nikola Milcic</li>
      <li>Danish - Ole Bang Ottosen (www.ot2sen.dk)</li>
      </ul>
  bigAPE ����� ��"� &copy; 1998-2005 | <a href="http://www.bigape.co.uk">www.bigape.co.uk</a>
      <br/><p/><br/>
');

?>
