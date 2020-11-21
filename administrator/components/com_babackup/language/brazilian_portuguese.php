<?php
/**
* bigAPE Site Backup 1.1 for Mambo CMS
* @version $Id: brazilian_portuguese.php,v 1.1 2006/04/09 09:17:28 morshed Exp $
* @package baBackup
* @copyright (C) 1998 - 2005 bigAPE Development Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.bigape.co.uk.com/
* -------------------------------------------
* Brazilian Portuguese Language Translation File
* Creator: Bruno Carvalho
* Email: bruno@criativ.pro.br
* Revision: 1.1
* Date: April 2005
*/


// ensure this file is being included by a parent file */
defined( "_VALID_MOS" ) or die( "Direct Access to this location is not allowed." );

// -- General ----------------------------------------------------------------------
DEFINE("_BIGAPE_BACKUP_COM_TITLE"                 , "Backup do Site");
DEFINE("_BIGAPE_BACKUP_COM_TITLE_CONFIRM"         , "Confirme as Sele��es das Pastas");

DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_SHOW"         , "Arquivar Arquivos");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_SHOWDB"       , "Arquivos da Base de Dados");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_EXAMINE"      , "Examinar Arquivo");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_CONFIRM"      , "Op��es de Backup");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_GENERATE"     , "Backup Completo");

DEFINE("_BIGAPE_BACKUP_COL_FILENAME"              , "Conjunto de Backup");
DEFINE("_BIGAPE_BACKUP_COL_DOWNLOAD"              , "Download");
DEFINE("_BIGAPE_BACKUP_COL_SIZE"                  , "Tamanho do Conjunto");
DEFINE("_BIGAPE_BACKUP_COL_DATE"                  , "Data do Backup");
DEFINE("_BIGAPE_BACKUP_COL_FOLDER"                , "Pastas");
DEFINE("_BIGAPE_BACKUP_COL_MODE"                  , "Modo");
DEFINE("_BIGAPE_BACKUP_COL_MODIFIED"              , "�ltima Modifica��o");
DEFINE("_BIGAPE_BACKUP_COL_TYPE"                  , "Tipo");

DEFINE("_BIGAPE_BACKUP_DELETE_FILE_SUCCESS"       , "Arquivo(s) Apagado(s)");
DEFINE("_BIGAPE_BACKUP_DELETE_FILE_FAILED"        , "Apagar arquivo(s) FALHOU");
DEFINE("_BIGAPE_BACKUP_DOWNLOAD_TITLE"            , "Fazer Download deste Backup");

DEFINE("_BIGAPE_BACKUP_DBBACKUP_SUCCESS"          , "Backup da Base de Dados Criado");

DEFINE("_BIGAPE_BACKUP_SAFE_MODE_ON"              , "<b>Aviso</b><br/>Seu arquivo PHP.INI est� configurado com <b>Safe Mode</b>  ativado. Este componente tenta extender a execu��o do script para no m�ximo 5 minutos para permitir o backup de sistemas com muitos arquivos, entretanto, o Safe Mode desabilita essa a��o e suas configura��es atuais de PHP podem causar um erro no backup se o processo demorar mais do que <u>{1} segundos</u>. Esse tempo pode ser extendido se for alterada a configura��o \"max_execution_time\" no arquivo PHP.INI");

DEFINE("_BIGAPE_BACKUP_ARCHIVE_NAME"              , "Nome do Backup");
DEFINE("_BIGAPE_BACKUP_NUMBER_FOLDERS"            , "N�mero de Pastas");
DEFINE("_BIGAPE_BACKUP_NUMBER_FILES"              , "N�mero de Arquivos");
DEFINE("_BIGAPE_BACKUP_SIZE_ORIGINAL"             , "Tamanho Original do Arquivo");
DEFINE("_BIGAPE_BACKUP_SIZE_ARCHIVE"              , "Tamanho do Backup");
DEFINE("_BIGAPE_BACKUP_DATABASE_ARCHIVE"          , "Backup da Base de Dados");
DEFINE("_BIGAPE_BACKUP_EMAIL_ARCHIVE"             , "Enviar por Email");

DEFINE("_BIGAPE_BACKUP_SELECT_ONE_FILE"           , "Selecione somente um Backup");
DEFINE("_BIGAPE_BACKUP_ERROR_GETTING_CONTENTS"    , "Erro ao examinar o conte�do do Backup");
DEFINE("_BIGAPE_BACKUP_EXAMINING_CONTENTS"        , "Examinando o conte�do do arquivo ");

DEFINE("_BIGAPE_BACKUP_CONFIRM_INSTRUCTIONS"      , "<b>Instru��es</b><br/>Favor selecionar as pastas que voc� deseja para o backup.<br/><i>Preste aten��o ao fato de que a pasta para o backup n�o ser� inclu�da por padr�o</i>");
DEFINE("_BIGAPE_BACKUP_CONFIRM_DATABASE"          , "Fazer c�pia da Base de Dados e incluir no Backup");
DEFINE("_BIGAPE_BACKUP_CONFIRM_EMAIL"             , "Enviar uma c�pia do Backup para este email quando terminar");

DEFINE("_BIGAPE_BACKUP_DATABASE_EXCLUDED"         , "Exclu�do");
DEFINE("_BIGAPE_BACKUP_DATABASE_MISSING_TABLES"   , "Erro: Defini��es de tabelas n�o-encontradas");
DEFINE("_BIGAPE_BACKUP_DATABASE_BACKUP_FAILED"    , "Backup FALHOU");
DEFINE("_BIGAPE_BACKUP_DATABASE_BACKUP_COMPLETED" , "Backup Completo");

DEFINE("_BIGAPE_BACKUP_EMAIL_EXCLUDED"            , "N�o-ativado");
DEFINE("_BIGAPE_BACKUP_EMAIL_FAILED"              , "Envio por Email Falhou");
DEFINE("_BIGAPE_BACKUP_EMAIL_COMPLETED"           , "Completado");

DEFINE("_BIGAPE_BACKUP_EMAIL_SUBJECT"             , "bigAPE Site Backup - Envio de Backup");
DEFINE("_BIGAPE_BACKUP_EMAIL_MESSAGE"             , "Em anexo est� o seguinte backup:");

DEFINE("_BIGAPE_BACKUP_MENU_BACK"                 , "Voltar");
DEFINE("_BIGAPE_BACKUP_MENU_CONTINUE"             , "Continuar");
DEFINE("_BIGAPE_BACKUP_MENU_CANCEL"               , "Cancelar");
DEFINE("_BIGAPE_BACKUP_MENU_GENERATE"             , 'Gerar Backup');
DEFINE("_BIGAPE_BACKUP_MENU_EXAMINE"              , 'Examinar Backup');

DEFINE("_BIGAPE_BACKUP_COM_HELP"                  , '
      <a href="http://www.bigape.co.uk"><img src="http://bigape.co.uk/images/stories/banners/banner-backup-component.jpg" border=0></a><br/>
      <h2>bigAPE Backup</h2>
      <b>Background</b><br/>
      Durante o gerenciamento de v�rios sites que usam o Mambo, sentimos a necessidade de arquivo todo um sistema do Mambo e as bases de dados em um �nico arquivo comprimido.
      <br/><br/>
      <b>Solu��o</b><br/>
      Tentamos utilizar os recursos da API existente no Mambo quando poss�vel e implementamos um sistema b�sico de backup completo.<br/>
      Este componente n�o possui uma interface para o usu�rio e todas as funcionalidades s�o gerenciadas por meio da interface de administra��o.<br/>
      O componente foi desenvolvido para ser o mais simples poss�vel para se utilizar.<br/><br/>
      <b>Compatibilidade</b><br/>
      Testamos esse componente com as seguintes configura��es do Mambo:<ul>
      <li>Linux, Apache, MySQL</li>
      <li>Windows XP/2000/2003, Apache, MySQL</li>
      <li>Windows XP/2000/2003, IIS, MySQL</li>
      <li>Mac OSX, Apache, MySQL (n�o-testado)</li>
      <li>Mambo v4.5.1 (ou superior)</li>
      </ul>
      <b>Recursos</b><br/>
      O componente permite fazer o backup do site. Os seguintes recursos s�o oferecidos no momento:<ul>
      <li>Capacidade para fazer backup de todo o site Mambo e da base de dados em um arquivo comprimido.</li>
      <li>Capacidade para selecionar quais pastas incluir e excluir do backup.</li>
      <li>Capacidade para fazer o download e gerenciar backups do Mambo.</li>
      <li>Capacidade para gerar, fazer download e gerenciar arquivos da base de dados do Mambo.</li>
      <li>Backups s�o �nicos da instala��o do Mambo, com base na data da instala��o e na chave secreta.</li>
      <li>Os Backup excluem os backups existentes para conservar espa�o.</li>
      </ul>
      <b>Guia do Usu�rio</b><br/>
      O Guia do Usu�rio do componente est� incluido no pacote de instala��o - <a href="components/com_babackup/docs/babackup_user_guide.pdf" target="_new"><b>bigAPE Backup User Guide (PDF) (em ingl�s)</b></a><br/>
      <br/><br/>
      <b>Tradu��es</b><br/>
      As seguintes pessoas t�m sido generosas o bastante para doar suas habilidades para a tradu��o do bigAPE Backup:<ul>
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


