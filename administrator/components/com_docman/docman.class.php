<?php
/*
* DOCMan 1.3.0 for Mambo 4.5.1 CMS
* @version $Id: docman.class.php,v 1.11 2006/05/07 04:38:42 nnabi Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Official website: http://www.mambodocman.com/
*/

defined('_VALID_MOS') or die('Direct access to this location is not allowed.');

require_once( dirname( __FILE__ ) .'/includes/defines.php');

/**
* DOCMan Mainframe class using a singleton pattern
* Provide many supporting API functions
*/

class dmMainFrame
{
        /** @var object An object of configuration variables */
        var $_config = null;

        /** @var object An object that holds the user state */
        var $_user   = null;

        /** @var object An object that holds the user state */
        var $_type   = null;

        /** @var number An number that holds the menu id */
        var $_menuid = 0;

        /**
        * Class constructor
        */
        function dmMainFrame( $type = _DM_TYPE_UNKNOW)
        {
                $this->_initialise( $type );
        }

        function _initialise( $type )
        {
                global $mosConfig_absolute_path;

                $this->_setAdminPaths( $mosConfig_absolute_path );
                $this->_setConfig();
                $this->_setUser();
                $this->_setMenuId();

                $this->setType($type);

                //load common language defines
                $this->loadLanguage('common');

                //include php compatibility files
                $this->loadCompatibility();
        }

        /**
        * Determines the paths for including engine and menu files
        * @param string The base path from which to get the path
        */
        function _setAdminPaths( $basePath = '.' ) {

                $this->_path = new stdClass();

                // sections
                if (file_exists( "$basePath/administrator/components/com_docman/classes")) {
                        $this->_path->classes = "/administrator/components/com_docman/classes";
                }
                if (file_exists( "$basePath/administrator/components/com_docman/contrib")) {
                        $this->_path->contrib = "/administrator/components/com_docman/contrib";
                }
                if (file_exists( "$basePath/administrator/components/com_docman/includes")) {
                        $this->_path->includes = "/administrator/components/com_docman/includes";
                }
                if (file_exists( "$basePath/administrator/components/com_docman/images")) {
                        $this->_path->images = "/administrator/components/com_docman/images";
                }
                if (file_exists( "$basePath/administrator/components/com_docman/temp")) {
                        $this->_path->temp = "/administrator/components/com_docman/temp";
                }

                //frontend
                if (file_exists( "$basePath/components/com_docman/themes")) {
                        $this->_path->themes = "/components/com_docman/themes";
                }
                if (file_exists( "$basePath/components/com_docman/includes_frontend")) {
                        $this->_path->includes_f = "/components/com_docman/includes_frontend";
                }

                //language
                if (file_exists( "$basePath/administrator/components/com_docman/language")) {
                        $this->_path->language = "/administrator/components/com_docman/language";
                }
        }

        /**
        * Returns a stored path variable
        *
        */
        function getPath( $folder, $file = '', $type = 0)
        {
                global $mosConfig_absolute_path, $mosConfig_live_site;

                $result = null;

                if (isset( $this->_path->$folder ))
                {
                        switch($folder)
                        {
                                case 'classes' :
                                {
                                        if($file) {
                                                $path = $this->_path->$folder.'/DOCMAN_'.$file.'.class.php';
                                                if(file_exists($mosConfig_absolute_path.$path))
                                                 $result = $path;
                                        } else
                                                  $result = $this->_path->$folder;
                                } break;

                                case 'contrib' :
                                {
                                        if($file) {
                                                $path = $this->_path->$folder.'/'.$file.'/';
                                                if(file_exists($mosConfig_absolute_path.$path))
                                                 $result = $path;
                                        } else
                                                  $result = $this->_path->$folder;
                                } break;

                                case 'language' :
                                {
                                        if($file) {
                                                $path = $this->_path->$folder.'/'.$file.'.php';
                                                if(file_exists($mosConfig_absolute_path.$path))
                                                 $result = $path;
                                        } else
                                                  $result = $this->_path->$folder;
                                } break;

                                case 'includes':
                                case 'includes_f':
                                {
                                        if($file) {
                                                $path = $this->_path->$folder.'/'.$file.'.php';
                                                if(file_exists($mosConfig_absolute_path.$path))
                                                 $result = $path;
                                        } else
                                                  $result = $this->_path->$folder;
                                } break;

                                case 'images' :
                                        $result = $this->_path->$folder;
                                        break;

                                case 'temp'   :
                                        $result = $this->_path->$folder;
                                        break;

                                case 'themes' :
                                        if($file) {
                                                $path = $this->_path->$folder.'/'.$file.'/';
                                                if(file_exists($mosConfig_absolute_path.$path))
                                                 $result = $path;
                                        } else
                                                  $result = $this->_path->$folder;
                                        break;
                        }
                } else {
                        switch ($folder) {
                                //TODO
                        }
                }

                $path_type = $type ? $mosConfig_live_site :  $mosConfig_absolute_path;

                return $path_type.$result;
        }

        /**
        * Loads the configuration file and creates a new class
        */
        function _setConfig( ) {

                global $mosConfig_absolute_path;

                require_once( $this->getPath('classes', 'config') );
                $this->_config = new DOCMAN_Config('dmConfig', dirname(__FILE__)."/docman.config.php" );

                // Get the path (ignore result) ... this sets a default value
                $this->_config->getCfg('dmpath', $mosConfig_absolute_path."/dmdocuments" );
                $this->_config->saveConfig();
        }

        /**
        * @param string The name of the variable
        * @return mixed The value of the configuration variable or null if not found
        */
        function getCfg( $varname , $default=null) {
                return $this->_config->getCfg($varname, $default);
        }

        /**
        * @param string The name of the variable
        * @param string The new value of the variable
        * @return bool True if succeeded, otherwise false.
        */
        function setCfg( $varname, $value, $create=false) {
                return $this->_config->setCfg($varname, $value, $create);
        }

        /**
        * Saves the configuration object
        */
        function saveConfig() {
                return $this->_config->saveConfig();
        }

        /**
        * Create a user object
        */
        function _setUser( ) {
                require_once( $this->getPath('classes', 'user') );
                $this->_user = new DOCMAN_User();
        }

        function getUser() {
                if (isset( $this->_user )) {
                        return $this->_user;
                } else {
                        return null;
                }
        }

        /**
        * Set the mainframe type
        */
        function setType($type) {
                $this->_type = $type;
        }
        function getType($type) {
                return $this->_type;
        }

        /**
        * Set the menu id
        */
        function _setMenuId() {
                global $database;

                $query = "SELECT m.id AS id"
                        . "\nFROM mos_menu AS m"
                        . "\nLEFT JOIN mos_components AS c ON m.componentid = c.id"
                        . "\nWHERE c.option ='com_docman'";

                $database->setQuery($query);

                $this->_menuid = $database->loadResult();
        }

        function getMenuId() {
                return $this->_menuid;
        }

        /**
        * Load language files
        */
        function loadLanguage($type)
        {
                global $mosConfig_lang;

                if (file_exists($this->getPath('language').'/'.$mosConfig_lang.'.'.$type.'.php')) {
                    include_once ($this->getPath('language').'/'.$mosConfig_lang.'.'.$type.'.php');
                } else {
                    include_once ($this->getPath('language').'/english.'.$type.'.php');
                }
        }

        /**
        * Load PHP compatibility files
        */
        function loadCompatibility()
        {
                if (phpversion() < '4.2.0') {
                        require_once( $this->getPath('contrib', 'pear').'/PHP_Compat.php' );
                }
        }

}

/**
* Document database table class
* @package DOCMan_1.3.0
*/

class mosDMDocument extends mosDBTable {
        var $id                 = null;
        var $catid                 = null;
        var $dmname                 = null;
        var $dmfilename         = null;
        var $dmdescription         = null;
        var $dmdate_published         = null;
        var $dmowner                 = null;
        var $published                 = null;
        var $dmurl                 = null;
        var $dmcounter                 = null;
        var $checked_out         = null;
        var $checked_out_time         = null;
        var $approved                 = 1;
        var $dmthumbnail        = null;
        var $dmlastupdateon         = null;
        var $dmlastupdateby         = null;
        var $dmsubmitedby         = null;
        var $dmmantainedby         = null;
        var $dmlicense_id         = null;
        var $dmlicense_display         = null;
        var $access                 = null;
        var $attribs                 = null;
        //added by camellia team;
        var $dmimage                 = null;
        var $dmdate_expire           = null;
        var $search_keyword          = null;
        var $dm_volume               = 0;
        var $price_for_member        = 0;
        var $price_for_non_member    = 0;
        var $is_delete               = 0;
        var $dmlink                  = 0;
        //var $product_type            = 1;

        function mosDMDocument(&$database)
        {
                $this->mosDBTable('#__docman', 'id', $database);
        }

        function load( $cid=0 )
        {
                if( $cid == 0 )                        // Only read if recID passed
                        return $this->init_record();
                else                                // fill in some 'null' fields
                        return parent::load( $cid );
        }

        /*
        *   @desc Internal routine - initialize some critical values
        *        @param none
        *        @param true
        */

        function init_record()
        {
                global $my,$mosConfig_offset ;
                global $_DOCMAN;

                $this->id                = null;
                $this->published        = 0;
                $this->approved         = 0;
                $this->dmsubmitedby     = $my->id;
                $this->dmlastupdateby   = $my->id;

                $this->dmowner                 = $_DOCMAN->getCfg( 'default_viewer' );
                $this->dmmantainedby = $_DOCMAN->getCfg( 'default_editor' );

                $this->dmdate_published = date( "Y-m-d" );

                if( $this->dmowner  == _DM_PERMIT_CREATOR ){
                        $this->dmowner = $this->dmsubmitedby;
                }
                if( $this->dmmantainedby == _DM_PERMIT_CREATOR ){
                        $this->dmmantainedby = $this->dmsubmitedby;
                }
                return true;
        }

        /*
        *   @desc Check a document
        *        @param nothing
        *        @returns boolean true if checked
        */

        function check()
        {
                global $my,$mosConfig_offset ;

                // Check fields to be sure they are correct
                $this->_error = "";
                if( ! $this->dmname){
                        $this->_error .= "\\n" . _DML_ENTRY_NAME;
                }
                if( $this->dmfilename == "" ){
                        $this->_error .= "\\n". _DML_ENTRY_DOC;
                }
                if( ! $this->catid ){
                        $this->_error .= "\\n" . _DML_ENTRY_CAT;
                }
                if( ! $this->search_keyword ){
                        $this->_error .= "\\n" . "You must enter search keyword";
                }
                if( ! $this->price_for_local_client ){
                        $this->_error .= "\\n" . "You must enter unit price for local client";
                }
                /*
                if( ! $this->price_for_foreign_client ){
                        $this->_error .= "\\n" . "You must enter unit price for foreign client";
                }
                */
                if( ! $this->dmdescription ){
                        $this->_error .= "\\n" . "You must enter abstract and description";
                }
                if( $this->dmowner == _DM_PERMIT_NOOWNER || $this->dmowner == "" ){
                        $this->_error .= "\\n" . _DML_ENTRY_OWNER;
                }
                /*
                if( $this->dmmantainedby == _DM_PERMIT_NOOWNER ||
                            $this->dmmantainedby == "" ){
                        $this->_error .= "\\n" . _DML_ENTRY_MAINT;
                }

                if( $this->dmdate_published == "" ){
                        $this->_error .= "\\n" . _DML_ENTRY_DATE;
                }

                // Check for links...
                if( strncasecmp( $this->dmfilename , _DM_DOCUMENT_LINK , _DM_DOCUMENT_LINK_LNG )==0){

                        $document_url = stripslashes(mosGetParam( $_REQUEST, 'document_url' , '' ));

                        // Check for a config string..
                        if( @defined( _DM_DOCUMENT_VALIDATE ) ){
                                $rmatch = '(' . _DM_DOCUMENT_VALIDATE . ')' ;
                        }else{
                                $rmatch = '([a-zA-Z]*)';
                        }
                        if( strncasecmp( 'file://' ,  $document_url , 7 ) == 0 ){
                                $this->_error .= "\\n" . _DML_ENTRY_DOCLINK_PROTOCOL ;
                        }else if( ! preg_match( '/^' . $rmatch . ':\/\//' , $document_url ) ){
                                $this->_error .= "\\n" . _DML_ENTRY_DOCLINK_PROTOCOL ;
                        }else if( ! preg_match( '/^' . $rmatch . ':\/\/(.+)$/' , $document_url ) ){
                                $this->_error .= "\\n" . _DML_ENTRY_DOCLINK_NAME;
                        }else if( ($fh = @fopen( $document_url , 'r' ) ) == false ){
                                $this->_error .= "\\n" . _DML_ENTRY_DOCLINK_INVALID ;
                        }else{
                                fclose( $fh );
                                $this->dmfilename = _DM_DOCUMENT_LINK . $document_url;
                        }
                }

                if( $this->_error ){
                        $this->_error = _DML_ENTRY_ERRORS
                        . "\\n---------------------------------"
                        . $this->_error;
                        return false;
                }
                */
                // Fill in default submitted values
                $date = date( "Y-m-d H:i:s" );

                if( $my->id )
                {
                        $this->dmlastupdateby   = $my->id;
                        if( $this->dmowner  == _DM_PERMIT_CREATOR ){
                                $this->dmowner = $this->dmsubmitedby;
                        }
                        if( $this->dmmantainedby == _DM_PERMIT_CREATOR ){
                                $this->dmmantainedby = $this->dmsubmitedby;
                        }
                        if( ! $this->dmsubmitedby  ){
                        $this->dmsubmitedby     = $my->id;
                        }
                }

                if( ! $this->dmdate_published )
                        $this->dmdate_published = $date;

                $this->dmlastupdateon         = $date;
                return true;
        }
        /*
        * @desc Approves a document
        * @param int the document id
        * @param boolean approve/unapprove
        */

        function approve($cid, $approved = 1)
        {
                global $database, $my;

                $cids = implode(',', $cid);
                $database->setQuery(
                        "UPDATE #__docman SET approved='$approved'"
                        ."\n WHERE id IN ($cids) "
                        ."\n   AND (checked_out=0 OR (checked_out='". $my->id . "'))");

                  if (!$database->query()) {
                        echo "<script> alert('".$database->getErrorMsg() ."'); window.history.go(-1); </script>\n";
                        return false;
                   }

                  return true;
        }

        /*
        * @desc Publish a document
        * @param array an array with ids
        * @param boolean publish/unpublish
        */

        function publish( $cid, $publish )
        {
                global $database, $my;

                if (!is_array($cid) || count($cid) <1) {
                        $action = $publish ? 'publish' : 'unpublish';
                        echo "<script> alert('". _DML_SELECT_ITEM_MOVE ." $action'); window.history.go(-1);</script>\n";
                        return false;
                }

                $cids = implode(',', $cid);
                $database->setQuery(
                        "UPDATE #__docman SET published='$publish'"
                        ." \nWHERE id IN ($cids) "
                        ." \n  AND (checked_out=0 OR (checked_out='$my->id'))");

                if (!$database->query()) {
                        echo "<script> alert('".$database->getErrorMsg() ."'); window.history.go(-1); </script>\n";
                        return false;
                }

                return true;
        }

        /*
        * @desc Move a document
        * @param array an array with ids
        * @param int an int with the new category id
        */

        function move( $cid, $catid )
        {
                global $database, $my;

                if (!(is_array($cid)) || (count($cid) < 1)) {
                        echo "<script> alert('". _SELECT_ITEM_MOVE ." ); window.history.go(-1);</script>\n";
                        return false;
                }

                $cids = implode(',', $cid);
                $database->setQuery(
                        "UPDATE #__docman SET catid='$catid'"
                        ." \nWHERE id IN ($cids) "
                        ." \n  AND (checked_out = 0 OR (checked_out='$my->id'))");

                if (!$database->query()) {
                        echo "<script> alert('".$database->getErrorMsg() ."'); window.history.go(-1); </script>\n";
                        return false;
                }

                return true;
        }

        /*
        * @desc Deletes documents
        * @param array an array with ids
        */

        function remove($cid)
        {
                global $database;

                if (!is_array($cid) || count($cid) <1) {
                        echo "<script>alert(". _DML_SELECT_ITEM_DEL ."); window.history.go(-1);</script>\n";
                        return false;
                }

                $cids = implode(',', $cid);
                $database->setQuery("update #__docman set is_delete='1' WHERE id IN ($cids)");

                if (!$database->query()) {
                        echo "<script> alert('".$database->getErrorMsg() ."'); window.history.go(-1); </script>\n";
                        return false;
                }

                return true;
        }

        function save()
        {
                global $database, $my;

                $this->updateOrder("catid='".$_POST['catid']."'");
                if (!$this->bind($_POST)) {
                        echo "<script> alert('".$this->getError() ."'); window.history.go(-1); </script>\n";
                        exit();
                }
                $this->_tbl_key = "id";
                if (!$this->check()) { // Javascript SHOULD catch all this!
                        echo "<h1><center>" . _DML_ENTRY_ERRORS . "</center><h1>";
                        echo "<script> alert('".$this->getError() ."'); window.history.go(-1); </script>\n";
                        exit();
                }
                if (!$this->store()) {
                        echo "<script> alert('".$this->getError() ."'); window.history.go(-1); </script>\n";
                        exit();
                }
                $this->checkin();
                return true;
        }

        function cancel()
        {
                $this->bind($_POST);
                $this->checkin();

                return true;
        }

        function incrementCounter()
        {
                global $database;
                $database->setQuery("UPDATE #__docman SET dmcounter=dmcounter+1 WHERE id='".$this->id."'");
                if (!$database->query()) {
                        echo "<script> alert('".$db->getErrorMsg() ."'); window.history.go(-1); </script>\n";
                        exit();
                }
                return true;
        }

        function _returnParam( $field , $config_field='',$attribs=null )
        {
                global $_DOCMAN;
                if( ! $config_field ) { $config_field = $field ; }
                if( is_null($attribs)){ $attribs = $this->attribs ;}
                if( ! isset($this->_params) && $attribs )
                {
                        $this->_params =  new mosParameters( $attribs );
                }
                if( isset( $this->_params[$field] ) )
                {
                        return( $this->_params[$field] );
                }
                return $_DOCMAN->getCfg( $config_field );
        }
        function authorCan($a=null)    { return $this->_returnParam( 'author_can'   ,'',$a );}
        function readerAssign($a=null) { return $this->_returnParam( 'reader_assign','',$a );}
        function editorAssign($a=null) { return $this->_returnParam( 'editor_assign','',$a );}
}

/**
* Category database table class
* @package DOCMan_1.3.0
*/
class mosDMCategory extends mosDBTable {

        /** @var int */
        var $id                        = null;
        var $parent_id                = null;
        var $title                = null;
        var $name                = null;
        var $image                = null;
        var $section                = null;
        var $image_position        = null;
        var $description        = null;
        var $published                = null;
        var $checked_out        = null;
        var $checked_out_time        = null;
        var $editor                = null;
        var $ordering                = null;
        var $access                = null;
        var $count                = null;
        var $params                = null;
        //add by camellia team
        var $is_delete                = 0;

        /**
        * @param database A database connector object
        */
        function mosDMCategory( &$db ) {
                $this->mosDBTable( '#__categories', 'id', $db );
        }

        /**
        * @desc          generic check method
        * @return boolean True if the object is ok
        */
        function check()        {
                $this->section = "com_docman";
                // check for valid name
                if (trim( $this->name ) == '') {
                        $this->_error = "Your Category must have a name.";
                        return false;
                }
                // check for existing name
                $this->_db->setQuery( "SELECT id FROM #__categories "
                . "\nWHERE name='".$this->name."' AND section='".$this->section."' and is_delete='0'"
                );

                $xid = intval( $this->_db->loadResult() );
                if ($xid && $xid != intval( $this->id )) {
                        $this->_error = "There is a category already with that name, please try again.";
                        return false;
                }
                return true;
        }
}

/**
* Group database table class
* @package DOCMan_1.3.0
*/

class mosDMGroups extends mosDBTable {
        var $groups_id                = null;
        var $groups_name        = null;
        var $groups_description = null;
        var $groups_access         = null;
        var $groups_members         = null;

        function mosDMGroups(&$database)
        {
                $this->mosDBTable('#__docman_groups', 'groups_id', $database);
        }
}

/**
* License database table class
* @package DOCMan_1.3.0
*/

class mosDMLicenses extends mosDBTable {
        var $id         = null;
        var $name         = null;
        var $license         = null;

        function mosDMLicenses(&$database)
        {
                $this->mosDBTable('#__docman_licenses', 'id', $database);
        }
}

/**
* History database table class
* @package DOCMan_1.3.0
*/

class mosDMHistory extends mosDBTable {
        var $id         = null;
        var $doc_id         = null;
        var $his_date         = null;
        var $his_who         = null;
        var $his_obs         = null;

        function mosDMHistory(&$database)
        {
                $this->mosDBTable('#__docman_history', 'id', $database);
        }
}

/**
* Log database table class
* @package DOCMan_1.3.0
*/

class mosDMLog extends mosDBTable {
        var $id                 = null;
        var $log_docid                 = null;
        var $log_ip                = null;
        var $log_datetime         = null;
        var $log_user                 = null;
        var $log_browser         = null;
        var $log_os                 = null;

        function mosDMLog(&$database)
        {
                $this->mosDBTable('#__docman_log', 'id', $database);
        }

        /*
        * @desc Deletes download logs entries
        * @param array the log ids as an array
        */

        function remove($cid) //removeLog
        {
                global $database;

                if (!is_array($cid) || count($cid) <1) {
                        echo "<script> alert(". _DML_SELECT_ITEM_DEL ."); window.history.go(-1);</script>\n";
                        return false;
                }

                if (count($cid)) {
                        $cids = implode(',', $cid);
                        $database->setQuery(
                                "DELETE FROM #__docman_log "
                                . "\n WHERE id IN ($cids)"
                        );

                        if (!$database->query()) {
                                echo "<script> alert('".$database->getErrorMsg() ."'); window.history.go(-1); </script>\n";
                                return false;
                        }
                }
                return true;
        }

        function loadRows($cid)
        {
                global $database;

                if( is_array( $cid ) ) {
                        if( count( $cid )){
                                $cids = implode(',', $cid);
                        }
                } else {
                        $cids = $cid;
                }
                if( ! $cids )
                        return null;

                $database->setQuery(
                          "SELECT * FROM #__docman_log "
                        . "\n WHERE id IN ($cids)"
                );
                return $database->loadObjectlist();
        }
}

?>
