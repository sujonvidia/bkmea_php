<?php
/**
* This file used to task handling
* grabs user inputs, process and validate the inputs
* Written by: Morshed Alam
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class' ) );
include_once("../includes/epb.function.php");
include_once("../includes/class.email_bank.php");

$task         = trim( mosGetParam( $_REQUEST, 'task', null ) );
$id           = intval(mosGetParam( $_REQUEST, 'id', '' ));
$cid          = mosGetParam( $_REQUEST, 'cid', array( 0 ) );
$option       = mosGetParam($_REQUEST, 'option', '');
$type         = mosGetParam($_REQUEST, 'type', '');
$circular_id  = mosGetParam($_REQUEST, 'circular_id', '');

if(!$id){
        $id = $cid[0];
}

switch ($task) {
        case 'new':
        case 'edit':
        case 'editA':
                editCirculation( $id, $option, $circular_id, $type );
                break;

        case 'save':
        case 'apply':
                 saveCirculation( $id, $option, $circular_id, $type );
                break;

        case 'remove':
                removeCirculation( $cid, $option, $circular_id, $type );
                break;

        default:
                showCirculationList( $option, $type, $circular_id );
                break;
}

function getTypeInfo($type, $circular_id)
{
        global $database;

        $info = array();
        switch($type)
        {
                case 1:
                   $info['table']     = "#__v3_circular_circulation";
                   $info['tbl_hscode']= "#__v3_circular_hscode";
                   $info['tbl']       = "#__v3_circular";
                   $info['file_name_field']= "file_name";
                   $info['type_name'] = "Circular";
                   $sql = "select title from #__v3_circular where id='".$circular_id."' ";
                   break;

                case 2:
                   $info['table']     = "#__v3_trade_fair_circulation";
                   $info['tbl_hscode']= "#__v3_trade_fair_hscode";
                   $info['tbl']       = "#__v3_trade_fair";
                   $info['file_name_field']= "file_name";
                   $info['type_name'] = "Trade Fair";
                   $sql = "select title from #__v3_trade_fair where id='".$circular_id."' ";
                   break;

                case 3:
                   $info['table']     = "#__v3_trade_lead_circulation";
                   $info['tbl_hscode']= "#__v3_trade_lead_hscode";
                   $info['tbl']       = "#__docman";
                   $info['tbl1']      = "#__v3_trade_lead";
                   $info['file_name_field']= "dmfilename";
                   $info['type_name'] = "Trade Lead";
                   $sql = "select dmname as title from #__docman where id='".$circular_id."' ";
                   break;

                default:
                   $info['table']     = "#__v3_circular_circulation";
                   $info['tbl_hscode']= "#__v3_circular_hscode";
                   $info['tbl']       = "#__v3_circular";
                   $info['file_name_field']= "file_name";
                   $info['type_name'] = "Circular";
                   $sql = "select title from #__v3_circular where id='".$circular_id."' ";
                   break;
        }
        $database->setQuery($sql);
        $info['circular_name'] = $database->loadResult();

        return $info;
}

function showCirculationList( $option, $type, $circular_id ) {
        global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;

        $limit              = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
        $limitstart         = $mainframe->getUserStateFromRequest( "view{$section}limitstart", 'limitstart', 0 );

        $typeInfo = getTypeInfo($type, $circular_id);
        // get the total number of records
        $query = " SELECT count(*) FROM ".$typeInfo['table']." where circular_id='".$circular_id."'" ;
        $database->setQuery( $query );
        $total = $database->loadResult();
        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );

        //get circular list from database
        $query = " SELECT c.*, t.".$typeInfo['file_name_field']." as filename "
                ." from ".$typeInfo['table']." as c, ".$typeInfo['tbl']." as t"
                ." where t.id=c.circular_id and c.circular_id='".$circular_id."' order by c.date DESC "
                ."\n LIMIT $pageNav->limitstart, $pageNav->limit " ;
        $database->setQuery( $query );
        $rows = $database->loadObjectList();

        HTML_Circulation::showCirculationList( $rows, $pageNav, $option, $type, $typeInfo['circular_name'] , $circular_id );
}

function editCirculation( $id, $option, $circular_id, $type )
{
        global $database;

        $query = "select email_address from #__email_bank order by id asc";
        $database->setQuery($query);
        $rows = $database->loadObjectList();
        if(count($rows)){
           foreach($rows as $row){
                   $othersEmail .= trim($othersEmail)==""?$row->email_address:", ".$row->email_address;
           }
        }

        $typeInfo = getTypeInfo($type, $circular_id);
        $row = new mosCirculation( $database, $typeInfo['table'] );
        $row->load($id);

        HTML_Circulation::editCirculation( $row, $othersEmail, $option, $circular_id, $type, $typeInfo['circular_name'] );
}

function saveCirculation( $id=0, $option, $circular_id, $type ) {
        global $database, $my, $mosConfig_owner, $mosConfig_absolute_path;
        global $mosConfig_fromname, $mosConfig_mailfrom;

        $typeInfo = getTypeInfo($type, $circular_id);

        $emailTo = array();
        $faxTo = array();
        $faxNoId = array();
        $emailAddressId = array();
        //get circular HSCode
        $query = " SELECT hscode from ".$typeInfo['tbl_hscode']
                ." where circular_id='".$circular_id."'";
        $database->setQuery( $query );
        $circularHscode = $database->loadResultArray();
        $strCircularHscode = ",".implode(",",$circularHscode).",";
        //get all member info;
        if(trim(strtolower($mosConfig_owner))=="epb"){
           $query =  " select id, name as company_name, contact_person, fax, phone, "
                    ." email from #__stakeholder where is_delete='0' and is_partner='0' ";
        }
        else if(trim(strtolower($mosConfig_owner))=="ccci" ){
           $query =  " select id, firm_fax as fax, head_office_fax as office_fax, "
                    ." firm_email as email, head_office_email as office_email "
                    ." from #__member where is_delete='0' ";
        }
        else if(trim(strtolower($mosConfig_owner))=="scci" ){
           $query =  " select id, firm_fax as fax, head_office_fax as office_fax, "
                    ." firm_email as email, head_office_email as office_email "
                    ." from #__member where is_delete='0' ";
        }
        else{
           $query =  " select id, applicant_fax as fax, office_fax, "
                    ." applicant_email as email, office_email "
                    ." from #__member where is_delete='0' ";
        } 
        $database->setQuery( $query );
        $rows = $database->loadObjectList();

        if(count($circularHscode)){
          if($_REQUEST['chkmember'] && count($rows))  //check total number of member
          {
            for($i=0;$i<count($rows);$i++)
            {
                $row = $rows[$i];
                $query = " select pl.hscode from #__member_product_line as mpl, #__product_line as pl "
                        ." where mpl.member_id='".$row->id."' and mpl.product_id=pl.id ";
                $database->setQuery( $query );
                $hscodeRows = $database->loadResultArray();

                if(count($hscodeRows)) //check total number of hscode
                {
                     for($j=0;$j<count($hscodeRows);$j++)
                     {
                        $hscodeRow = $hscodeRows[$j];
                        $hscodeRow = substr($hscodeRow,0,4); //to compare four digit;
                        if(strpos($strCircularHscode,$hscodeRow))  //serch member's hscode to circular's hscode;
                        {
                            if(trim($row->email) != "" || trim($row->office_email) != ""){
                               $emailTo[] = $row;
                               $emailAddressId[] = $row->id; 
                            }
                            else if(trim($row->fax) != "" || trim($row->office_fax) != ""){
                               $faxTo[] = $row;
                               $faxNoId[] = $row->id;
                            }
                            break;
                        }
                     }

                }
            }
          }
        }
        else{
          if($_REQUEST['chkmember'] && count($rows))  //check total number of member
          {
            for($i=0;$i<count($rows);$i++)
            {
                $row = $rows[$i];
                if(trim($row->email) != "" || trim($row->office_email) != "")
                {
                   $emailTo[] = $row;
                   $emailAddressId[] = $row->id;
                }
                else if(trim($row->fax) != "" || trim($row->office_fax) != "")
                {
                   $faxTo[] = $row;
                   $faxNoId[] = $row->id;
                }
            }
          }
        }
        //email to others
        if($_REQUEST['chkemail'])
        {
             $tempArr = explode(",",$_REQUEST['other_email_address']);
             $counter = count($emailTo);
             foreach($tempArr as $email){
                $emailTo[$counter]->email = $email;
                $counter = $counter+1;
                $obj = new mosEmailBank($database);
                $obj->name = "";
                $obj->email_address = trim($email);
                if($obj->check()){
                  $obj->store();
                }
             }
        }
        //board of director
        if($_REQUEST['chkboard']){
            $query = "select * from #__v3_board_of_director where is_active='1' ";
            $database->setQuery($query);
            $rows = $database->loadObjectList();
            $counter = count($emailTo);
            $directorId = array();
            for($i=0; $i<count($rows); $i++){
                 $emailTo[$counter]->email = $rows[$i]->email_address;
                 $directorId[] = $rows[$i]->id;
                 $counter = $counter+1;
            }

        }
        //send mail;
        $sql = " SELECT * from ".$typeInfo['tbl']." where id='".$circular_id."'";
        $database->setQuery($sql);
        $res = $database->loadObjectList();

        if($type==3)
        {
          $sql = " SELECT * from ".$typeInfo['tbl1']." where doc_id='".$circular_id."'";
          $database->setQuery($sql);
          $res2 = $database->loadObjectList();

          $sql = " SELECT country_name from #__pshop_country where country_id='".$res2[0]->country_id."'";
          $database->setQuery($sql);
          $res1 = $database->loadObjectList();

          $attachment = trim($res[0]->file_name)!=""?$mosConfig_absolute_path."/dmdocuments/-1/".$res[0]->dmname:Null;
          $body = file_get_contents($mosConfig_absolute_path."/administrator/mail_template/trade_lead.tpl");
          $body = str_replace("{TITLE}", $res[0]->dmname, $body);
          $body = str_replace("{QUERY_TYPE}", $res2[0]->is_export_query!=0?($res2[0]->is_export_query==1?"Export":"Import"):"", $body);
          $body = str_replace("{QUERY_BY}", $res2[0]->query_by, $body);
          $body = str_replace("{CONTACT_PERSON}", $res2[0]->contact_person, $body);
          $body = str_replace("{ADDRESS}", $res2[0]->address, $body);
          $body = str_replace("{COUNTRY}", $res1[0]->country_name, $body, $body);
          $body = str_replace("{PHONE}", $res2[0]->phone, $body);
          $body = str_replace("{FAX}", $res2[0]->fax, $body);
          $body = str_replace("{EMAIL}", $res2[0]->email, $body);
          $body = str_replace("{WEB}", $res2[0]->web, $body);
          $body = str_replace("{PUBLICATION_DATE}", mosFormatDate($res[0]->dmdate_published), $body);
          $body = str_replace("{EXPIRE_DATE}", mosFormatDate($res[0]->dmdate_expire), $body);
          $body = str_replace("{NO_OF_PAGES}", $res[0]->dm_volume, $body);
          $body = str_replace("{PRICE_MEMBER}", $res[0]->price_for_member, $body);
          $body = str_replace("{PRICE_NON_MEMBER}", $res[0]->price_for_non_member, $body);
          $body = str_replace("{ABSTRACT}", $res[0]->dmdescription, $body);
          $body = str_replace("{HSCODE}", implode(",",$circularHscode),$body);
        }
        else if($type==2)
        {

          $sql = " SELECT country_name from #__pshop_country where country_id='".$res[0]->country_id."'";
          $database->setQuery($sql);
          $res1 = $database->loadObjectList();

          $attachment = trim($res[0]->file_name)!=""?$mosConfig_absolute_path."/administrator/images/trade_fair/".$res[0]->file_name:Null;
          $body = file_get_contents($mosConfig_absolute_path."/administrator/mail_template/trade_fair.tpl");
          $body = str_replace("{TITLE}", $res[0]->title, $body);
          $body = str_replace("{ISSUE_DATE}", mosFormatDate($res[0]->issue_date), $body);
          $body = str_replace("{ISSUE_BY}", $res[0]->issue_by, $body);
          $body = str_replace("{COUNTRY}", $res1[0]->country_name, $body);
          $body = str_replace("{START_DATE}", mosFormatDate($res[0]->start_date), $body);
          $body = str_replace("{END_DATE}", mosFormatDate($res[0]->end_date), $body);
          $body = str_replace("{VENUE}", $res[0]->venue_address, $body);
          $body = str_replace("{CONTACT_PERSON}", $res[0]->contact_person, $body);
          $body = str_replace("{PHONE}", $res[0]->phone, $body);
          $body = str_replace("{FAX}", $res[0]->fax, $body);
          $body = str_replace("{EMAIL}", $res[0]->email, $body);
          $body = str_replace("{WEB}", $res[0]->web, $body);
          $body = str_replace("{ABSTRACT}", $res[0]->abstract, $body);
          $body = str_replace("{HSCODE}", implode(",",$circularHscode),$body);
        }
        else if($type==1)
        {
          $sql = " SELECT country_name from #__pshop_country where country_id='".$res[0]->country_id."'";
          $database->setQuery($sql);
          $res1 = $database->loadObjectList();

          $attachment = trim($res[0]->file_name)!=""?$mosConfig_absolute_path."/administrator/images/circular/".$res[0]->file_name:Null;
          $body = file_get_contents($mosConfig_absolute_path."/administrator/mail_template/circular.tpl");
          $body = str_replace("{TITLE}", $res[0]->title, $body);
          $body = str_replace("{ISSUE_DATE}", mosFormatDate($res[0]->issue_date), $body);
          $body = str_replace("{ISSUE_BY}", $res[0]->issue_by, $body);
          $body = str_replace("{COUNTRY}", $res1[0]->country_name, $body);
          $body = str_replace("{ABSTRACT}", $res[0]->abstract, $body);
          $body = str_replace("{HSCODE}", implode(",",$circularHscode),$body);
        }

        $subject = "Circular: ".$typeInfo['circular_name'];

        for($i=0; $i<count($emailTo);$i++)
        {
           mosMail($mosConfig_mailfrom, $mosConfig_fromname, $emailTo[$i]->email, $subject, $body, $mode=true, Null, Null, $attachment);
        }

        $row = new mosCirculation( $database, $typeInfo['table'] );

        if($_REQUEST['chkmember'])
           $row->email_to_member = 1;
        else
           $row->email_to_member = 0;

        if($_REQUEST['chkboard']){
           $row->email_to_board_or_director = 1;
           $row->board_of_director = implode(",",$directorId);
        }
        else
           $row->email_to_board_or_director = 0;

        if(trim($_REQUEST['chkemail'])!=""){
           $row->email_to_others = 1;
           $row->others_email_address = $_REQUEST['other_email_address'];
        }
        else
           $row->email_to_others = 0;
           
        $row->circular_id         = $circular_id;
        $row->fax_number_id       = implode(",",$faxNoId);
        $row->email_address_id    = implode(",",$emailAddressId);
        $row->username            = $my->username;
        $row->date                = date('Y-m-d H:i:s');

        if($row->store())
           $msg = 'The Circulation has been processed successfully.';
        else
           $msg = 'Failed to process the Circulation. ';

        mosRedirect( 'index2.php?option='. $option.'&amp;type='.$type.'&amp;circular_id='.$circular_id, $msg );
}

function removeCirculation( &$cid, $option, $circular_id, $type )
{
        global $database;

        $typeInfo = getTypeInfo($type, $circular_id);
        if ( count( $cid ) ) {
           $obj = new mosCirculation( $database, $typeInfo['table'] );
           foreach ($cid as $id) {
             if (!$obj->delete( $id )) {
                echo "<script> alert('".$obj->getError()."'); window.history.go(-1); </script>\n";
                exit();
             }
           }
        }

        $msg = 'The circulation information has been deleted successfully.';
        mosRedirect( 'index2.php?option='. $option.'&amp;type='.$type.'&amp;circular_id='.$circular_id, $msg );
}
?>