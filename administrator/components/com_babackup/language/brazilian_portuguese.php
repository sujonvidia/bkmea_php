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
DEFINE("_BIGAPE_BACKUP_COM_TITLE_CONFIRM"         , "Confirme as Seleções das Pastas");

DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_SHOW"         , "Arquivar Arquivos");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_SHOWDB"       , "Arquivos da Base de Dados");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_EXAMINE"      , "Examinar Arquivo");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_CONFIRM"      , "Opções de Backup");
DEFINE("_BIGAPE_BACKUP_SCREEN_TITLE_GENERATE"     , "Backup Completo");

DEFINE("_BIGAPE_BACKUP_COL_FILENAME"              , "Conjunto de Backup");
DEFINE("_BIGAPE_BACKUP_COL_DOWNLOAD"              , "Download");
DEFINE("_BIGAPE_BACKUP_COL_SIZE"                  , "Tamanho do Conjunto");
DEFINE("_BIGAPE_BACKUP_COL_DATE"                  , "Data do Backup");
DEFINE("_BIGAPE_BACKUP_COL_FOLDER"                , "Pastas");
DEFINE("_BIGAPE_BACKUP_COL_MODE"                  , "Modo");
DEFINE("_BIGAPE_BACKUP_COL_MODIFIED"              , "Última Modificação");
DEFINE("_BIGAPE_BACKUP_COL_TYPE"                  , "Tipo");

DEFINE("_BIGAPE_BACKUP_DELETE_FILE_SUCCESS"       , "Arquivo(s) Apagado(s)");
DEFINE("_BIGAPE_BACKUP_DELETE_FILE_FAILED"        , "Apagar arquivo(s) FALHOU");
DEFINE("_BIGAPE_BACKUP_DOWNLOAD_TITLE"            , "Fazer Download deste Backup");

DEFINE("_BIGAPE_BACKUP_DBBACKUP_SUCCESS"          , "Backup da Base de Dados Criado");

DEFINE("_BIGAPE_BACKUP_SAFE_MODE_ON"              , "<b>Aviso</b><br/>Seu arquivo PHP.INI está configurado com <b>Safe Mode</b>  ativado. Este componente tenta extender a execução do script para no máximo 5 minutos para permitir o backup de sistemas com muitos arquivos, entretanto, o Safe Mode desabilita essa ação e suas configurações atuais de PHP podem causar um erro no backup se o processo demorar mais do que <u>{1} segundos</u>. Esse tempo pode ser extendido se for alterada a configuração \"max_execution_time\" no arquivo PHP.INI");

DEFINE("_BIGAPE_BACKUP_ARCHIVE_NAME"              , "Nome do Backup");
DEFINE("_BIGAPE_BACKUP_NUMBER_FOLDERS"            , "Número de Pastas");
DEFINE("_BIGAPE_BACKUP_NUMBER_FILES"              , "Número de Arquivos");
DEFINE("_BIGAPE_BACKUP_SIZE_ORIGINAL"             , "Tamanho Original do Arquivo");
DEFINE("_BIGAPE_BACKUP_SIZE_ARCHIVE"              , "Tamanho do Backup");
DEFINE("_BIGAPE_BACKUP_DATABASE_ARCHIVE"          , "Backup da Base de Dados");
DEFINE("_BIGAPE_BACKUP_EMAIL_ARCHIVE"             , "Enviar por Email");

DEFINE("_BIGAPE_BACKUP_SELECT_ONE_FILE"           , "Selecione somente um Backup");
DEFINE("_BIGAPE_BACKUP_ERROR_GETTING_CONTENTS"    , "Erro ao examinar o conteúdo do Backup");
DEFINE("_BIGAPE_BACKUP_EXAMINING_CONTENTS"        , "Examinando o conteúdo do arquivo ");

DEFINE("_BIGAPE_BACKUP_CONFIRM_INSTRUCTIONS"      , "<b>Instruções</b><br/>Favor selecionar as pastas que você deseja para o backup.<br/><i>Preste atenção ao fato de que a pasta para o backup não será incluída por padrão</i>");
DEFINE("_BIGAPE_BACKUP_CONFIRM_DATABASE"          , "Fazer cópia da Base de Dados e incluir no Backup");
DEFINE("_BIGAPE_BACKUP_CONFIRM_EMAIL"             , "Enviar uma cópia do Backup para este email quando terminar");

DEFINE("_BIGAPE_BACKUP_DATABASE_EXCLUDED"         , "Excluído");
DEFINE("_BIGAPE_BACKUP_DATABASE_MISSING_TABLES"   , "Erro: Definições de tabelas não-encontradas");
DEFINE("_BIGAPE_BACKUP_DATABASE_BACKUP_FAILED"    , "Backup FALHOU");
DEFINE("_BIGAPE_BACKUP_DATABASE_BACKUP_COMPLETED" , "Backup Completo");

DEFINE("_BIGAPE_BACKUP_EMAIL_EXCLUDED"            , "Não-ativado");
DEFINE("_BIGAPE_BACKUP_EMAIL_FAILED"              , "Envio por Email Falhou");
DEFINE("_BIGAPE_BACKUP_EMAIL_COMPLETED"           , "Completado");

DEFINE("_BIGAPE_BACKUP_EMAIL_SUBJECT"             , "bigAPE Site Backup - Envio de Backup");
DEFINE("_BIGAPE_BACKUP_EMAIL_MESSAGE"             , "Em anexo está o seguinte backup:");

DEFINE("_BIGAPE_BACKUP_MENU_BACK"                 , "Voltar");
DEFINE("_BIGAPE_BACKUP_MENU_CONTINUE"             , "Continuar");
DEFINE("_BIGAPE_BACKUP_MENU_CANCEL"               , "Cancelar");
DEFINE("_BIGAPE_BACKUP_MENU_GENERATE"             , 'Gerar Backup');
DEFINE("_BIGAPE_BACKUP_MENU_EXAMINE"              , 'Examinar Backup');

DEFINE("_BIGAPE_BACKUP_COM_HELP"                  , '
      <a href="http://www.bigape.co.uk"><img src="http://bigape.co.uk/images/stories/banners/banner-backup-component.jpg" border=0></a><br/>
      <h2>bigAPE Backup</h2>
      <b>Background</b><br/>
      Durante o gerenciamento de vários sites que usam o Mambo, sentimos a necessidade de arquivo todo um sistema do Mambo e as bases de dados em um único arquivo comprimido.
      <br/><br/>
      <b>Solução</b><br/>
      Tentamos utilizar os recursos da API existente no Mambo quando possível e implementamos um sistema básico de backup completo.<br/>
      Este componente não possui uma interface para o usuário e todas as funcionalidades são gerenciadas por meio da interface de administração.<br/>
      O componente foi desenvolvido para ser o mais simples possível para se utilizar.<br/><br/>
      <b>Compatibilidade</b><br/>
      Testamos esse componente com as seguintes configurações do Mambo:<ul>
      <li>Linux, Apache, MySQL</li>
      <li>Windows XP/2000/2003, Apache, MySQL</li>
      <li>Windows XP/2000/2003, IIS, MySQL</li>
      <li>Mac OSX, Apache, MySQL (não-testado)</li>
      <li>Mambo v4.5.1 (ou superior)</li>
      </ul>
      <b>Recursos</b><br/>
      O componente permite fazer o backup do site. Os seguintes recursos são oferecidos no momento:<ul>
      <li>Capacidade para fazer backup de todo o site Mambo e da base de dados em um arquivo comprimido.</li>
      <li>Capacidade para selecionar quais pastas incluir e excluir do backup.</li>
      <li>Capacidade para fazer o download e gerenciar backups do Mambo.</li>
      <li>Capacidade para gerar, fazer download e gerenciar arquivos da base de dados do Mambo.</li>
      <li>Backups são únicos da instalação do Mambo, com base na data da instalação e na chave secreta.</li>
      <li>Os Backup excluem os backups existentes para conservar espaço.</li>
      </ul>
      <b>Guia do Usuário</b><br/>
      O Guia do Usuário do componente está incluido no pacote de instalação - <a href="components/com_babackup/docs/babackup_user_guide.pdf" target="_new"><b>bigAPE Backup User Guide (PDF) (em inglês)</b></a><br/>
      <br/><br/>
      <b>Traduções</b><br/>
      As seguintes pessoas têm sido generosas o bastante para doar suas habilidades para a tradução do bigAPE Backup:<ul>
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


