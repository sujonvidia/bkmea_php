<?php
/**
* @version $Id: bkmea_member.searchbot.php,v 1.4 2006/01/04 06:02:23 sami Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onSearch', 'botSearchMember' );

/**
* Content Search method
*
* The sql must return the following fields that are used in a common display
* routine: href, title, section, created, text, browsernav
* @param string Target search string
* @param string mathcing option, exact|any|all
* @param string ordering option, newest|oldest|popular|alpha|category
*/
function botSearchMember( $text, $phrase='',  $search_type='all', $product='all', $location='all') {
        global $my, $database;
        global $mosConfig_abolute_path, $mosConfig_offset;

        $_SESSION['searchword'] = $text;

        $now = date( "Y-m-d H:i:s", time()+$mosConfig_offset*60*60 );

        $text = trim( $text );
        /*
        if ($text == '') {
                return array();
        }
        */

        $wheres = array();
        switch ($phrase) {
                case 'exact':
                {
                        $wheres2 = array();
                        switch($search_type){
                                case 'company':
                                      $wheres2[] = "LOWER(m.firm_name) LIKE '%$text%'";
                                      break;
                                case 'person':
                                      $wheres2[] = "LOWER(m.applicant_name) LIKE '%$text%'";
                                      break;
                                case 'date':
                                      $wheres2[] = "LOWER(m.date) LIKE '%$text%'";
                                      break;
                                case 'capacity1':
                                      if(is_numeric($text))
                                         $wheres2[] = "m.production_capacity>=$text";
                                      break;
                                case 'capacity2':
                                      if(is_numeric($text))
                                         $wheres2[] = "m.production_capacity<=$text";
                                      break;
                                case 'total_no_machine1':
                                      if(is_numeric($text))
                                         $wheres2[] = "m.machine_number>=$text";
                                      break;
                                case 'total_no_machine2':
                                      if(is_numeric($text))
                                         $wheres2[] = "m.machine_number<=$text";
                                      break;
                                case 'size1':
                                      if(is_numeric($text))
                                        $wheres2[] = "m.employee_total>=$text";
                                      break;
                                case 'size2':
                                      if(is_numeric($text))
                                        $wheres2[] = "m.employee_total<=$text";
                                      break;
                                case 'all':
                                default:
                                      $wheres2[] = "LOWER(m.firm_name) LIKE '%$text%'";
                                      $wheres2[] = "LOWER(m.applicant_name) LIKE '%$text%'";
                                      if(is_numeric($text))
                                        $wheres2[] = "m.employee_total=$text";
                                      if(is_numeric($text))
                                        $wheres2[] = "m.production_capacity=$text";
                                      if(is_numeric($text))
                                        $wheres2[] = "m.machine_number=$text";
                                      $wheres2[] = "LOWER(m.date) LIKE '%$text%'";
                                      break;

                        }
                        $where = '(' . implode( ') OR (', $wheres2 ) . ')';
                        break;
                }
                case 'all':
                case 'any':
                default:
                        $words = explode( ' ', $text );
                        $wheres = array();
                        foreach ($words as $word) {
                                $wheres2 = array();
                                 switch($search_type){
                                         case 'company':
                                               $wheres2[] = "LOWER(m.firm_name) LIKE '%$word%'";
                                               break;
                                         case 'person':
                                               $wheres2[] = "LOWER(m.applicant_name) LIKE '%$word%'";
                                               break;
                                         case 'date':
                                               $wheres2[] = "LOWER(m.date) LIKE '%$word%'";
                                               break;
                                         case 'capacity1':
                                               if(is_numeric($word))
                                                 $wheres2[] = "m.production_capacity>=$word";
                                               break;
                                         case 'capacity2':
                                               if(is_numeric($word))
                                                 $wheres2[] = "m.production_capacity<=$word";
                                               break;
                                         case 'total_no_machine1':
                                               if(is_numeric($word))
                                                  $wheres2[] = "m.machine_number>=$word";
                                               break;
                                         case 'total_no_machine2':
                                               if(is_numeric($word))
                                                  $wheres2[] = "m.machine_number<=$word";
                                               break;
                                         case 'size1':
                                               if(is_numeric($word))
                                                  $wheres2[] = "m.employee_total>=$word";
                                               break;
                                         case 'size2':
                                               if(is_numeric($word))
                                                  $wheres2[] = "m.employee_total<=$word";
                                               break;
                                         case 'all':
                                         default:
                                               $wheres2[] = "LOWER(m.firm_name) LIKE '%$word%'";
                                               $wheres2[] = "LOWER(m.applicant_name) LIKE '%$word%'";
                                               if(is_numeric($word))
                                                 $wheres2[] = "m.employee_total=$word";
                                               if(is_numeric($word))
                                                 $wheres2[] = "m.production_capacity=$word";
                                               if(is_numeric($word))
                                                 $wheres2[] = "m.machine_number=$word";
                                               $wheres2[] = "LOWER(m.date) LIKE '%$word%'";
                                               break;

                                 }
                                $wheres[] = implode( ' OR ', $wheres2 );
                        }
                        $where = '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
                        break;
        }
        $product_search="";
        if($product!="all" && is_numeric($product) ) {
             $product_search = " and ( mpl.product_id='$product' and mpl.member_id=m.id )";
        }
        else
            $product_search="";

        $location_search="";
        if($location!="all" && is_numeric($location) ) {
             $location_search = " and ( m.location='$location' )";
        }
        else
            $location_search="";

        $sql = "SELECT distinct( m.firm_name ) AS firm_name, m.id as id "
               . "\n FROM #__member AS m"
               . "\n Left Join #__member_product_line as mpl on mpl.member_id = m.id"
               . "\n WHERE ( $where ) $product_search $location_search and m.is_delete!=1"
               ;

        $database->setQuery( $sql );
        $list = $database->loadObjectList();
        return $list;
}
?>
