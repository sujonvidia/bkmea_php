<?php
/**
* @version $Id: directory_bkmea.php,v 1.11 2006/05/28 04:13:56 nnabi Exp $
* @package Mambo
* @subpackage Search
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'front_html' ) );

switch ( $task ) {
        default:
                viewSearch();
                break;
}

$mail_opt = mosGetParam( $_REQUEST, 'mail_opt' );
$firm = mosGetParam( $_REQUEST, 'firm' );

function viewSearch() {
        global $mainframe, $mosConfig_absolute_path, $mosConfig_lang, $my;
        global $Itemid, $database, $_MAMBOTS;
        global $mosconfig_local_general_contact_member;
        global $mosconfig_foreign_general_contact_member;
        global $mosconfig_local_general_contact_non_member;
        global $mosconfig_foreign_general_contact_non_member;
        global $mosconfig_local_detail_contact_member;
        global $mosconfig_foreign_detail_contact_member;
        global $mosconfig_local_detail_contact_non_member;
        global $mosconfig_foreign_detail_contact_non_member;

        $gid = $my->gid;

        // Adds parameter handling
        if( $Itemid > 0 ) {
                $menu =& new mosMenu( $database );
                $menu->load( $Itemid );
                $params =& new mosParameters( $menu->params );
                $params->def( 'page_title', 1 );
                $params->def( 'pageclass_sfx', '' );
                $params->def( 'header', $menu->name, _SEARCH_TITLE );
                $params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );
        } else {
                $params =& new mosParameters('');
                $params->def( 'page_title', 1 );
                $params->def( 'pageclass_sfx', '' );
                $params->def( 'header', _SEARCH_TITLE );
                $params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );
        }
        $pid = mosGetParam( $_REQUEST, 'pid' );
        // html output
        search_html::printformstart(  );
        search_html::openhtml( $params );

        $searchword = mosGetParam( $_REQUEST, 'searchword', '' );
        $searchword = $database->getEscaped( trim( $searchword ) );

        $search_type = mosGetParam( $_REQUEST, 'search_type', '' );
        $search_type = $database->getEscaped( trim( $search_type ) );

        $search_ignore = array();
        @include "$mosConfig_absolute_path/language/$mosConfig_lang.ignore.php";

        $searchphrase = mosGetParam( $_REQUEST, 'searchphrase', 'any' );
        $searchphrases = array();

        $phrase = new stdClass();
        $phrase->value = 'any';
        $phrase->text = _SEARCH_ANYWORDS;
        $searchphrases[] = $phrase;

        $phrase = new stdClass();
        $phrase->value = 'all';
        $phrase->text = _SEARCH_ALLWORDS;
        $searchphrases[] = $phrase;

        $phrase = new stdClass();
        $phrase->value = 'exact';
        $phrase->text = _SEARCH_PHRASE;
        $searchphrases[] = $phrase;

        $lists['searchphrase'] = mosHTML::radioList( $searchphrases, 'searchphrase', '', mosGetParam( $_REQUEST, 'searchphrase', '' ) );
        $lists['location']     = mosAdminMenus::SearchLocation( 'location',$_POST['location']);
        $lists['product_list'] = mosAdminMenus::ProductList( 'product_list', $_POST['product_list'] );
        $lists['search_type']  = mosAdminMenus::SearchOption( 'search_type', $_POST['search_type'] );
        $lists['member_category_id']        = mosAdminMenus::MemberCategory( 'member_category_id', $option, intval( $_POST['member_category_id'] ) );
        $lists['compliance_list']              = mosAdminMenus::ComplianceListSingle( 'compliance_list', $_POST['compliance_list'] );
        //$javascript='onclick="resetcheckbox();"';
        $lists['is_direct_export']          = mosHTML::yesnoRadioList( 'is_direct_export', 'class="inputbox" ', $_SESSION['is_direct_export'] );
        //$lists['is_direct_export']          = mosHTML::yesnoCheckBox( 'is_direct_export[]', 'class="inputbox"','', $javascript );
        // html output
        search_html::searchbox( htmlspecialchars( $searchword ), $lists, $params,$pid );
        // html output
        search_html::searchintro( htmlspecialchars( $searchword ), $params );
        //mosLogSearch( $searchword );
        $phrase         = mosGetParam( $_REQUEST, 'searchphrase', '' );

        if(isset($_POST['submit1']))
        {

                $text=$searchword;
                $product=$_POST['product_list']?$_POST['product_list']:'all';
                $is_direct_export=$_POST['is_direct_export']?$_POST['is_direct_export']:'all';
                $location=$_POST['location']?$_POST['location']:'all';
                $member_category_id=$_POST['member_category_id']?$_POST['member_category_id']:'all';
                $compliance_id=$_POST['compliance_list']?$_POST['compliance_list']:'all';
                $search_type=$_POST['search_type']?$_POST['search_type']:'all';
                $search_criteria=$phrase."__".$text."__".$search_type."__".$product."__".$is_direct_export."__".$location."__".$member_category_id."__".$compliance_id;
                //echo  $search_criteria;
                $_SESSION['searchword'] = $text;

                $now = date( "Y-m-d H:i:s", time()+$mosConfig_offset*60*60 );

                $text = trim( $text );
                $search_obj=new mosSearchPublicSite();
                $results=$search_obj->botSearchMemberBkmea( "statistics", $phrase, $text, $search_type, $product, $is_direct_export, $location, $member_category_id, $compliance_id);


      }
      /////Search query :: End
      $total_foreign_member=0;
      $total_local_member=0;
      for($i=0;$i<count($results);$i++){
              $row=$results[$i];
              if(intval($row->country_id)==18 || intval($row->country_id)==0)
                  $total_local_member=$total_local_member+intval($row->total_member);
              else
                  $total_foreign_member=$total_foreign_member+intval($row->total_member);
      }
      $totalRows         = $total_local_member+$total_foreign_member;
      //price
      $price=array();
      $price['general_contact_member']=($total_local_member*intval($mosconfig_local_general_contact_member))+($total_foreign_member*intval($mosconfig_foreign_general_contact_member));
      $price['general_contact_non_member']=($total_local_member*intval($mosconfig_local_general_contact_non_member))+($total_foreign_member*intval($mosconfig_foreign_general_contact_non_member));
      $price['detail_contact_member']=($total_local_member*intval($mosconfig_local_detail_contact_member))+($total_foreign_member*intval($mosconfig_foreign_general_contact_member));
      $price['detail_contact_non_member']=($total_local_member*intval($mosconfig_local_detail_contact_non_member))+($total_foreign_member*intval($mosconfig_foreign_general_contact_non_member));

      $mainframe->setPageTitle( _SEARCH_TITLE );
      // html output
      search_html::display( $totalRows, $price, $search_criteria,$pid );
      search_html::printformend(  );
}


function mosLogSearch( $search_term ) {
        global $database;
        global $mosConfig_enable_log_searches;

        if ( @$mosConfig_enable_log_searches ) {
                $query = "SELECT hits"
                . "\n FROM #__core_log_searches"
                . "\n WHERE LOWER(search_term)='$search_term'"
                ;
                $database->setQuery( $query );
                $hits = intval( $database->loadResult() );
                if ( $hits ) {
                        $query = "UPDATE #__core_log_searches SET hits=(hits+1) WHERE LOWER(search_term)='$search_term'";
                        $database->setQuery( $query );
                        $database->query();
                } else {
                        $query = "INSERT INTO #__core_log_searches VALUES ('$search_term','1')";
                        $database->setQuery( $query );
                        $database->query();
                }
        }
}

        function send_mail(){
            global $mosConfig_mailfrom, $mosConfig_fromname, $database, $my;
            global $mail_opt, $firm, $mosConfig_sitename,$mosConfig_live_site;
            $query="select firm_name as firm_name, member_reg_no as member_reg_no from #__member where id=$firm";
            $database->setQuery( $query );
            $row = $database->loadObjectList();

            $query1="select name as name , email as email from #__users where id='".$my->id."'";
            $database->setQuery( $query1 );
            $row1 = $database->loadObjectList();

            $MESSAGE= ""._MESSAGE_1."\n\n"._MESSAGE_2." '".$row[0]->firm_name
                     ."'\n"._MESSAGE_3." ".$row[0]->member_reg_no
                     ."\n\n"._MESSAGE_4." \n".$row1[0]->name
                     ."\n\n$mosConfig_sitename\n$mosConfig_live_site"
                     ;

            $mailfrom= $row1[0]->email;
            $mailfromname= $row1[0]->name;
            $headers =  "From:".$mailfromname."<".$mailfrom.">";

            return mail($mosConfig_mailfrom,_PROFILE_REQUEST_SUBJECT,$MESSAGE,$headers);
        }



?>
