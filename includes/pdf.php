<?php
/**
* @version $Id: pdf.php,v 1.4 2005/01/06 01:13:29 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
* Created by Phil Taylor me@phil-taylor.com
* Support file to display PDF Text Only using class from - http://www.ros.co.nz/pdf/readme.pdf
* HTMLDoc is available from: http://www.easysw.com/htmldoc and needs installing on the server for better HTML to PDF conversion
**/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mosConfig_offset, $mosConfig_hideAuthor, $mosConfig_hideModifyDate, $mosConfig_hideCreateDate, $mosConfig_live_site;


//update
/*
* common function for PDf report
* Print Report Title
* Report Header & Footer
*/  function numtoword($number){
$converted_string="";
/* $n_quo_1=$number/10000000;
$n_quo_1=(int)$n_quo_1;
$n_rem_1=$number%10000000;
$n_rem_1=(int)$n_rem_1;
if($n_quo_1<100){
$word=get_word($n_quo_1);
$converted_string=$converted_string.$word;
} */
if($number<0){
	$converted_string="Negetive ";
	$number=$number*(-1);
}
$n_quo_2=$number/100000;
$n_quo_2=(int)$n_quo_2;
$n_rem_2=$number%100000;
$n_rem_2=(int)$n_rem_2;
$word=get_word($n_quo_2);
if($word!="")
$converted_string=$converted_string.$word." Million ";

$n_quo_3=$n_rem_2/1000;
$n_quo_3=(int)$n_quo_3;
$n_rem_3=$n_rem_2%1000;
$n_rem_3=(int)$n_rem_3;
$word=get_word($n_quo_3);
if($word!="")
$converted_string=$converted_string.$word." Thousand ";

$n_quo_4=$n_rem_3/100;
$n_quo_4=(int)$n_quo_4;
$n_rem_4=$n_rem_3%100;
$n_rem_4=(int)$n_rem_4;
$word=get_word($n_quo_4);
if($word!="")
$converted_string=$converted_string.$word." Hundred ";

$word=get_word($n_rem_4);
$converted_string=$converted_string.$word;
return $converted_string;

}

function get_word($num){
	switch($num){
		Case 0:  $str="" ; break;
		Case 1:  $str="One " ; break;
		Case 2:  $str="Two " ; break;
		Case 3:  $str="Three " ; break;
		Case 4:  $str="Four " ; break;
		Case 5:  $str="Five " ; break;
		Case 6:  $str="Six " ; break;
		Case 7:  $str="Seven " ; break;
		Case 8:  $str="Eight " ; break;
		Case 9:  $str="Nine " ; break;
		Case 10:  $str="Ten " ; break;
		Case 11:  $str="Eleven " ; break;
		Case 12:  $str="Twelve " ; break;
		Case 13:  $str="Thirteen " ; break;
		Case 14:  $str="Forteen " ; break;
		Case 15:  $str="Fifteen " ; break;
		Case 16:  $str="Sixteen " ; break;
		Case 17:  $str="Seventeen " ; break;
		Case 18:  $str="Eighteen " ; break;
		Case 19:  $str="Nineteen " ; break;
		Case 20:  $str="Twoenty " ; break;
		Case 21:  $str="Twenty One " ; break;
		Case 22:  $str="Twenty Two " ; break;
		Case 23:  $str="Twenty Three " ; break;
		Case 24:  $str="Twenty Four " ; break;
		Case 25:  $str="Twenty Five " ; break;
		Case 26:  $str="Twenty Six " ; break;
		Case 27:  $str="Twenty Seven " ; break;
		Case 28:  $str="Twenty Eight " ; break;
		Case 29:  $str="Twenty Nine " ; break;
		Case 30:  $str="Thirty " ; break;
		Case 31:  $str="Thirty One " ; break;
		Case 32:  $str="Thirty Two " ; break;
		Case 33:  $str="Thirty Three " ; break;
		Case 34:  $str="Thirty Four " ; break;
		Case 35:  $str="Thirty Five " ; break;
		Case 36:  $str="Thirty Six " ; break;
		Case 37:  $str="Thirty Seven " ; break;
		Case 38:  $str="Thirty Eight " ; break;
		Case 39:  $str="Thirty Nine " ; break;
		Case 40:  $str="Forty " ; break;
		Case 41:  $str="Forty One " ; break;
		Case 42:  $str="Forty Two " ; break;
		Case 43:  $str="Forty Three " ; break;
		Case 44:  $str="Forty Four " ; break;
		Case 45:  $str="Forty Five " ; break;
		Case 46:  $str="Forty Six " ; break;
		Case 47:  $str="Forty Seven " ; break;
		Case 48:  $str="Forty Eight " ; break;
		Case 49:  $str="Forty Nine " ; break;
		Case 50:  $str="Fifty " ; break;
		Case 51:  $str="Fifty One " ; break;
		Case 52:  $str="Fifty Two " ; break;
		Case 53:  $str="Fifty Three " ; break;
		Case 54:  $str="Fifty Four " ; break;
		Case 55:  $str="Fifty Five " ; break;
		Case 56:  $str="Fifty Six " ; break;
		Case 57:  $str="Fifty Seven " ; break;
		Case 58:  $str="Fifty Eight" ; break;
		Case 59:  $str="Fifty Nine" ; break;
		Case 60:  $str="Sixty " ; break;
		Case 61:  $str="Sixty One" ; break;
		Case 62:  $str="Sixty Two" ; break;
		Case 63:  $str="Sixty Three" ; break;
		Case 64:  $str="Sixty Four" ; break;
		Case 65:  $str="Sixty Five" ; break;
		Case 66:  $str="Sixty Six" ; break;
		Case 67:  $str="Sixty Seven" ; break;
		Case 68:  $str="Sixty Eight" ; break;
		Case 69:  $str="Sixty Nine" ; break;
		Case 70:  $str="Seventy " ; break;
		Case 71:  $str="Seventy One " ; break;
		Case 72:  $str="Seventy Two " ; break;
		Case 73:  $str="Seventy Three " ; break;
		Case 74:  $str="OSeventy Four " ; break;
		Case 75:  $str="Seventy Five " ; break;
		Case 76:  $str="Seventy Six " ; break;
		Case 77:  $str="Seventy Seven " ; break;
		Case 78:  $str="Seventy Eight " ; break;
		Case 79:  $str="Seventy Nine " ; break;
		Case 80:  $str="Eighty " ; break;
		Case 81:  $str="Eighty One " ; break;
		Case 82:  $str="Eighty Two " ; break;
		Case 83:  $str="Eighty Three " ; break;
		Case 84:  $str="Eighty Four " ; break;
		Case 85:  $str="Eighty Five " ; break;
		Case 86:  $str="Eighty Six " ; break;
		Case 87:  $str="Eighty Seven " ; break;
		Case 88:  $str="Eighty Eight " ; break;
		Case 89:  $str="Eighty Nine " ; break;
		Case 90:  $str="Ninety " ; break;
		Case 91:  $str="Ninety One " ; break;
		Case 92:  $str="Ninety  Two " ; break;
		Case 93:  $str="Ninety  Three" ; break;
		Case 94:  $str="Ninety Four " ; break;
		Case 95:  $str="Ninety  Five " ; break;
		Case 96:  $str="Ninety Six " ; break;
		Case 97:  $str="Ninety Seven " ; break;
		Case 98:  $str="Ninety Eight " ; break;
		Case 99:  $str="Ninety Nine " ; break;
	}
	return $str;
}
function ReportTitle(&$pdf, $for='', $CHAMBER, $ADDRESS, $CONTACT='', $EMAIL='', $TITLE, $align='center',$reporting_period='',$membership_range='',$showSubTitle=true){
	global $mosConfig_offset;

	$logo=$for;
	$justification_arr=array('justification' => $align);

	switch($logo){
		case 'bkmea':
			$logo="./administrator/images/photograph/logo_bkmea.jpg";
			$pdf->addJpegFromFile($logo,15,752,64,64);
			$WEB=_WEB_BKMEA;
			$pdf->ezText(stripslashes($CHAMBER), 15,$justification_arr);
			$pdf->ezText(stripslashes($ADDRESS), 10,$justification_arr);
			$CONTACT==""?"":$pdf->ezText(stripslashes($CONTACT).". ".stripslashes($EMAIL), 10,$justification_arr);
			break;

		case 'ccci':
			$logo="./administrator/images/photograph/logo_ccci.jpg";
			$pdf->addJpegFromFile($logo,15,752,64,64);
			$WEB=_WEB_CCCI;
			$pdf->ezText(stripslashes($CHAMBER), 15,$justification_arr);
			$pdf->ezText(stripslashes($ADDRESS), 10,$justification_arr);
			$CONTACT==""?"":$pdf->ezText(stripslashes($CONTACT).". ".stripslashes($EMAIL), 10,$justification_arr);
			break;

		case 'scci':
			$logo="./administrator/images/photograph/logo_scci.jpg";
			$pdf->addJpegFromFile($logo,55,752,50,50);
			$WEB=_WEB_SCCI;
			$pdf->ezText(stripslashes($CHAMBER), 17,$justification_arr);
			$pdf->ezText(stripslashes($ADDRESS), 9,$justification_arr);
			$pdf->ezText(stripslashes($CONTACT), 8,$justification_arr);
			$pdf->ezText(stripslashes($EMAIL).". ".stripslashes($WEB), 8,$justification_arr);
			break;

		case 'epb':
			$logo="./administrator/images/logo_epb.jpg";
			$pdf->addJpegFromFile($logo,55,742,50,50);
			$WEB=_WEB_EPB;
			$pdf->ezText(stripslashes($CHAMBER), 17,$justification_arr);
			$pdf->ezText(stripslashes($ADDRESS), 9,$justification_arr);
			$pdf->ezText(stripslashes($CONTACT), 8,$justification_arr);
			$pdf->ezText(stripslashes($EMAIL).". ".stripslashes($WEB), 8,$justification_arr);
			break;

		default:
			break;
	}

	//$EMAIL==""?"":$pdf->ezText($EMAIL, 10,$justification_arr);
	$pdf->ezText("",11);
	$pdf->ezText(stripslashes($TITLE), 11, $justification_arr);
	$justification_arr_right=array('justification' => 'right');

	$pdf->ezText($reporting_period,10,array('justification'=>'center'));
	if ($for=='ccci')
	$pdf->ezText($membership_range,10,array('justification'=>'center'));
	//date( 'F j, Y, H:i', time() + $mosConfig_offset*60*60 )
	$date_time=date( 'F j, Y')." at ".date( 'H:i', time() + $mosConfig_offset*60*60 );
	$pdf->ezText('Generated: '.$date_time , 9, $justification_arr_right);
	$pdf->ezText("",2);

	$pdf->ezStartPageNumbers(560,  20, 6,'','Page {PAGENUM} of {TOTALPAGENUM}','');

	if($showSubTitle){
		$sub_title=$TITLE;
		$reporting_period=explode(":",$reporting_period);
		$reporting_period=$reporting_period[1];
		$sub_title.=$reporting_period!=''?' ( '.$reporting_period.' )':'';
	}
	else
	$sub_title = "";

	if(strlen($reporting_period)==0)
	$x=340;
	else if(strlen($reporting_period)<20)
	$x=410;
	else
	$x=460;

	$pdf->ezPageHeaderReportTitle($x, 828, 10,'center',$sub_title,'',2);

}

function ReportFooter(&$pdf){
	global $mosConfig_live_site, $mosConfig_sitename, $_VERSION;

	// footer
	$pdf->setStrokeColor( 0, 0, 0, 5 );
	$pdf->line( 10, 25, 578, 25 );
	//$pdf->line( 10, 822, 578, 822 );
	$pdf->addText( 30, 20, 6, $mosConfig_live_site .' - '. $mosConfig_sitename );
	$pdf->addText( 250, 20, 6, $_VERSION->COPYRIGHT_PDF );

}

function ReportVoterListFooter(&$pdf,$title,$total_no_members,$for,$election_date){
	global $mosConfig_live_site, $mosConfig_sitename, $_VERSION;
	global $config_member_1,$config_member_2;
	global $config_chairman,$config_secretary;
	global $config_notice,$config_voter_election_date;
	// footer
	$pdf->setStrokeColor( 0, 0, 0, 5 );
	//$pdf->line( 10, 35, 578, 35 );
	//$pdf->line( 10, 822, 578, 822 );
	/* $pdf->addText( 210, 165, 10, 'Total Number of Members : '.$total_no_members);
	$pdf->addText( 250, 150, 10, $title);
	$pdf->addText( 30, 110, 7,'('. stripslashes($config_member_1).')' );
	$pdf->addText( 30, 100, 6, 'Member, Election Board, '.strtoupper($for) );
	$pdf->addText( 250, 110, 7, '('.stripslashes($config_member_2).')' );
	$pdf->addText( 250, 100, 6, 'Member, Election Board, '.strtoupper($for) );
	$pdf->addText( 480, 110, 7, '('.stripslashes($config_chairman).')' );
	$pdf->addText( 480, 100, 6, 'Chairman, Election Board, '.strtoupper($for) );
	$pdf->addText( 30, 80, 6, 'Date : '.date("jS F Y", strtotime($election_date)) );
	$pdf->addText( 480, 80, 6, 'By order of the Election Board' );
	$pdf->addText( 480, 50, 7, '('.stripslashes($config_secretary).')' );
	$pdf->addText( 500, 40, 6, 'Secretary' );
	$pdf->addText( 30, 30, 6,'N.B. '. $config_notice);
	//$pdf->addText( 250, 30, 6, $_VERSION->COPYRIGHT );    */
	$text="\n".'Total Number of Voters : '.$total_no_members."\n";


	$text.="\n\n".$title."\n\n\n\n";


	$text.='('.stripslashes($config_member_1).')'."                      ";
	$text.='('.stripslashes($config_member_2).')'."                      ";
	$text.='('.stripslashes($config_chairman).')'."\n";
	$text.='Member, Election Board, '.strtoupper($for)."                ";
	$text.='Member, Election Board, '.strtoupper($for)."                ";
	$text.='Chairman, Election Board, '.strtoupper($for)."\n\n";
	$text.= 'Date : '.date("jS F Y").'                                                                                           By order of the Election Board'."\n\n\n\n" ;
	$text.= '                                                                                                                             ('.stripslashes($config_secretary).')'."\n" ;
	$text.= '                                                                                                                                   Secretary'."\n" ;
	$pdf->ezText($text,10,array('justification'=>'center'));
	$pdf->ezText('N.B. '. $config_notice,6);

}

function decodeHTML( $string ) {
	$string = strtr( $string, array_flip(get_html_translation_table( HTML_ENTITIES ) ) );
	$string = preg_replace( "/&#([0-9]+);/me", "chr('\\1')", $string );
	return $string;
}

function get_php_setting ($val ) {
	$r = ( ini_get( $val ) == '1' ? 1 : 0 );
	return $r ? 'ON' : 'OFF';
}

function dofreePDF ( $database ) {
	global $mosConfig_live_site,$option, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;

	$id = intval( mosGetParam( $_REQUEST, 'id', 1 ) );
	include( 'includes/class.ezpdf.php' );
	$row = new mosContent( $database );
	$row->load( $id );
	//Find Author Name
	$users_rows = new mosUser( $database );
	$users_rows->load( $row->created_by );
	$row->author = $users_rows->name;
	$row->usertype = $users_rows->usertype;
	$row->fulltext="$option";
	//$row->introtext="----------";
	// Ugly but needed to get rid of all the stuff the PDF class cant handle
	$row->fulltext         = str_replace( '<p>', "\n\n" , $row->fulltext );
	$row->fulltext         = str_replace( '<P>', "\n\n" , $row->fulltext );
	$row->fulltext         = str_replace( '<br />', "\n" , $row->fulltext );
	$row->fulltext         = str_replace( '<br>', "\n" , $row->fulltext );
	$row->fulltext         = str_replace( '<BR />', "\n" , $row->fulltext );
	$row->fulltext         = str_replace( '<BR>', "\n" , $row->fulltext );
	$row->fulltext         = str_replace( '<li>', "\n - " , $row->fulltext );
	$row->fulltext         = str_replace( '<LI>', "\n - " , $row->fulltext );
	$row->fulltext         = strip_tags( $row->fulltext );
	$row->fulltext         = str_replace( '{mosimage}', '', $row->fulltext );
	$row->fulltext         = str_replace( '{mospagebreak}', '', $row->fulltext );
	$row->fulltext         = decodeHTML( $row->fulltext );

	$row->introtext         = str_replace( '<p>', "\n\n", $row->introtext );
	$row->introtext         = str_replace( '<P>', "\n\n", $row->introtext );
	$row->introtext         = str_replace( '<li>', "\n - " , $row->introtext );
	$row->introtext         = str_replace( '<LI>', "\n - " , $row->introtext );
	$row->introtext         = strip_tags( $row->introtext );
	$row->introtext         = str_replace( '{mosimage}', '', $row->introtext );
	$row->introtext         = str_replace( '{mospagebreak}', '', $row->introtext );
	$row->introtext         = decodeHTML( $row->introtext );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font

	$all = $pdf->openObject();
	$pdf->saveState();
	$pdf->setStrokeColor( 0, 0, 0, 1 );

	// footer
	$pdf->line( 10, 40, 578, 40 );
	$pdf->line( 10, 822, 578, 822 );
	$pdf->addText( 30, 34, 6, $mosConfig_live_site .' - '. $mosConfig_sitename );
	$pdf->addText( 250, 34, 6, 'Powered by Millennium' );
	$pdf->addText( 450, 34, 6, 'Generated: '. date( 'j F, Y, H:i', time() + $mosConfig_offset*60*60 ) );

	$pdf->restoreState();
	$pdf->closeObject();
	$pdf->addObject( $all, 'all' );
	$pdf->ezSetDy( 30 );

	$txt1 = $row->title;
	$pdf->ezText( $txt1, 14 );

	$txt2 = NULL;
	$mod_date = NULL;
	$create_date = NULL;
	if ( intval( $row->modified ) <> 0 ) {
		$mod_date = mosFormatDate( $row->modified );
	}
	if ( intval( $row->created ) <> 0 ) {
		$create_date = mosFormatDate( $row->created );
	}

	if ( $mosConfig_hideCreateDate == '0' ) {
		$txt2 .= '('. $create_date .') - ';
	}

	if ( $mosConfig_hideAuthor == "0" ) {
		if ( $row->author != '' && $mosConfig_hideAuthor == '0' ) {
			if ($row->usertype == 'administrator' || $row->usertype == 'superadministrator') {
				$txt2 .=  _WRITTEN_BY .' '. ( $row->created_by_alias ? $row->created_by_alias : $row->author );
			} else {
				$txt2 .=  _AUTHOR_BY .' '. ( $row->created_by_alias ? $row->created_by_alias : $row->author );
			}
		}
	}

	if ( $mosConfig_hideModifyDate == "0" ) {
		$txt2 .= ' - '. _LAST_UPDATED .' ('. $mod_date .') ';
	}

	$txt2 .= "\n\n";
	$pdf->ezText( $txt2, 8 );
	$txt3 = $row->introtext ."\n". $row->fulltext;
	$pdf->ezText( $txt3, 10 );
	$pdf->ezStream();
}

//report for membership details

function MemberDetail ( $database ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $id, $type_id, $Itemid;

	$id = intval( mosGetParam( $_REQUEST, 'id', 1 ) );
	include( 'includes/class.ezpdf.php' );
	$query="SELECT m.companyname as companyname,m.person as person,"
	."\n m.designation as designation, mt.title as type,"
	."\n m.address1 as address1,m.address2 as address2,"
	."\n m.address3 as address3, m.contact1 as contact1,"
	."\n mry.start_date as start_date, mry.end_date as end_date,"
	."\n m.contact2 as contact2 FROM #__membership as m,"
	."\n #__member_type AS mt, #__member_reg_year AS mry "
	."\n WHERE m.id ='$id' and m.type_id=mt.id and mry.id=m.member_reg_id" ;

	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	foreach ($rows as $row);
	$company=$row->companyname;
	$type=$row->type;
	$person=$row->person;
	$designation=$row->designation;
	$address1=$row->address1;
	$address2=$row->address2;
	$address3=$row->address3;
	$contact1=$row->contact1;
	$contact=$row->contact2;
	$start_date=$row->start_date;
	$end_date=$row->end_date;


	//$created=$row->date;

	$fulltext=           "Membership Type : " .$type."<br><br>";
	$fulltext=$fulltext. "Registration Date : " .$start_date." to ".$end_date."<br><br>";
	$fulltext=$fulltext. "Contact Person : " .$person."<br><br>";
	$fulltext=$fulltext. "Designation : " .$designation."<br><br>";
	$fulltext=$fulltext. "Business Address : " .$address1."<br><br>";
	$fulltext=$fulltext. "Mailing Address : " .$person."<br><br>";
	$fulltext=$fulltext. "Head Office Address : " .$person."<br><br>";
	if($contact1!="")
	$fulltext=$fulltext. "Contact Number : " .$contact1."(office)";
	if($contact2!="")
	$fulltext=$fulltext.", ".$contact2."(res)<br>";

	// Ugly but needed to get rid of all the stuff the PDF class cant handle
	$fulltext         = str_replace( '<p>', "\n\n" , $fulltext );
	$fulltext         = str_replace( '<P>', "\n\n" , $fulltext );
	$fulltext         = str_replace( '<br />', "\n" , $fulltext );
	$fulltext         = str_replace( '<br>', "\n" , $fulltext );
	$fulltext         = str_replace( '<BR />', "\n" , $fulltext );
	$fulltext         = str_replace( '<BR>', "\n" , $fulltext );
	$fulltext         = str_replace( '<li>', "\n - " , $fulltext );
	$fulltext         = str_replace( '<LI>', "\n - " , $fulltext );
	$fulltext         = strip_tags( $fulltext );
	$fulltext         = str_replace( '{mosimage}', '', $fulltext );
	$fulltext         = str_replace( '{mospagebreak}', '', $fulltext );
	$fulltext         = decodeHTML( $fulltext );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font

	$all = $pdf->openObject();
	$pdf->saveState();
	$pdf->setStrokeColor( 0, 0, 0, 1 );

	// footer
	$pdf->line( 10, 40, 578, 40 );
	$pdf->line( 10, 822, 578, 822 );
	$pdf->addText( 30, 34, 6, $mosConfig_live_site .' - '. $mosConfig_sitename );
	$pdf->addText( 250, 34, 6, 'Powered by Millennium' );
	$pdf->addText( 450, 34, 6, 'Generated: '. date( 'j F, Y, H:i', time() + $mosConfig_offset*60*60 ) );

	$pdf->restoreState();
	$pdf->closeObject();
	$pdf->addObject( $all, 'all' );
	$pdf->ezSetDy( 30 );

	$txt1 = $row->companyname;
	$pdf->ezText( $txt1, 14 );

	$txt2 = NULL;
	$create_date = NULL;
	if ( intval( $created ) <> 0 ) {
		$create_date = mosFormatDate( $created );
	}
	/*
	if ( $mosConfig_hideCreateDate == '0' ) {
	$txt2 .= '('. $create_date .')  ';
	}
	*/
	if ( $mosConfig_hideAuthor == "0" ) {
		if ( $row->author != '' && $mosConfig_hideAuthor == '0' ) {
			if ($row->usertype == 'administrator' || $row->usertype == 'superadministrator') {
				$txt2 .=  _WRITTEN_BY .' '. ( $row->created_by_alias ? $row->created_by_alias : $row->author );
			} else {
				$txt2 .=  _AUTHOR_BY .' '. ( $row->created_by_alias ? $row->created_by_alias : $row->author );
			}
		}
	}

	$txt2 .= "\n\n";
	$pdf->ezText( $txt2, 8 );
	$txt3 = $fulltext;
	$pdf->ezText( $txt3, 10 );
	$pdf->ezStream();
}

function MemberCertificite ( $database, $mid, $user_id, $working_reg_year_id ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $id, $type_id, $Itemid;

	$id = intval( mosGetParam( $_REQUEST, 'id', 1 ) );
	include( 'includes/class.ezpdf.php' );

	/*$query="select m.id as mbid, m.firm_name as firm,m.applicant_name"
	. "\n as aplicant, m.member_reg_no as lastRegNO, ry.name as yearname,"
	. "\n ry.id as yearid,m.applicant_address_street as street,"
	. "\n  m.applicant_address_town_suburb as town,"
	. "\n m.applicant_address_district as district,m.applicant_address_division"
	. "\n as division, m.applicant_address_country as country"
	. "\n FROM #__member AS m Left JOIN #__member_reg_year as ry"
	. "\n on m.last_reg_year_id=ry.id  where m.id = '$mid'"
	; */
	$query="select cat.name as member_category,m.reg_date as registration_date ,m.member_status as status,m.id as mbid, m.firm_name as firm,m.applicant_name"
	. "\n as aplicant, mh.member_reg_no as lastRegNO, ry.name as yearname,"
	. "\n ry.id as yearid,m.applicant_address_street as street,"
	. "\n m.applicant_address_town_suburb as town,"
	. "\n m.applicant_address_district as district,m.applicant_address_division"
	. "\n as division, m.applicant_address_country as country"
	. "\n FROM #__member AS m,#__member_category as cat left join #__member_history as mh on m.id=mh.member_id"
	. "\n Left JOIN #__member_reg_year as ry on mh.reg_year_id=ry.id"
	. "\n where m.id = '$mid' and mh.reg_year_id='$working_reg_year_id'"
	. "\n and m.member_category_id =cat.id"
	;


	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	//foreach ($rows as $row);
	$memberid=$rows[0]->mbid;
	$yearid=$rows[0]->yearid;

	$company=$rows[0]->firm;
	$regno=$rows[0]->lastRegNO;
	//$address=$rows[0]->applicant_address;

	$address=$rows[0]->street;
	$address.= trim($rows[0]->town)!="" ?", ".$rows[0]->town:"";
	$address.= trim($rows[0]->district)!="" ?", ".$rows[0]->district:"";
	$address.= trim($rows[0]->division)!="" ?", ".$rows[0]->division:"";
	$address.= trim($rows[0]->country)!="" ?", ".$rows[0]->country:"";

	$yearname=$rows[0]->yearname;

	//$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	$pdf =& new Cezpdf( 'CUST', 'landscape' );  //A4 Portrait
	//$pdf =& new Cezpdf( 'CUST', 'P' );
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf -> ezSetCmMargins( 0, 0, 0, 0);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font

	$all = $pdf->openObject();
	$pdf->saveState();
	$pdf->setStrokeColor( 0, 0, 0, 1 );



	IF ($rows[0]->status=="0")
	{
		$pdf->setColor(0.8,0,0,0.8);
		$pdf->addText(260.4,300,26,"PROVISIONAL");
	}

	$pdf->setColor(0,0,0,0);
	$sql_query= "select count(id) as printed_times from #__member_certificate as"
	. "\n mc where mc.reg_year_id ='$working_reg_year_id' and mc.member_id ='$mid' and mc.member_status='".$rows[0]->status."'"
	;
	$query=$database->replaceTablePrefix($sql_query);
	$database->setQuery( $sql_query );
	$row = $database->loadObjectList();

	if ($row[0]->printed_times>"0")
	{
		$pdf->setColor(0.5,0.5,0.5,0.5);
		//$pdf->addText(600,480,15,"DUPLICATE");
		$pdf->addText(45,480,15,"DUPLICATE");
	}
	$pdf->setColor(0,0,0,0);
	// footer

	$pdf->addText( 600,312,12, $regno."-".trim(strtoupper($rows[0]->member_category))."/".date('Y', strtotime(trim($rows[0]->registration_date))));
	$pdf->addText( 288, 263, 16, stripslashes($company) );
	$pdf->addText( 67, 224, 10, stripslashes($address) );
	$var = date('Y');

	$pdf->addText( 516, 155, 10,   $yearname );
	$pdf->addText( 150, 47, 10,  date( 'jS F, Y ', time() + $mosConfig_offset*60*60 ) );

	$pdf->restoreState();
	$pdf->closeObject();
	$pdf->addObject( $all, 'all' );
	$pdf->ezSetDy( 30 );

	$txt1 = $row->companyname;
	$pdf->ezText( $txt1, 14 );

	$txt2 = NULL;
	$create_date = NULL;
	if ( intval( $created ) <> 0 ) {
		$create_date = mosFormatDate( $created );
	}

	if ( $mosConfig_hideAuthor == "0" ) {
		if ( $row->author != '' && $mosConfig_hideAuthor == '0' ) {
			if ($row->usertype == 'administrator' || $row->usertype == 'superadministrator') {
				$txt2 .=  _WRITTEN_BY .' '. ( $row->created_by_alias ? $row->created_by_alias : $row->author );
			} else {
				$txt2 .=  _AUTHOR_BY .' '. ( $row->created_by_alias ? $row->created_by_alias : $row->author );
			}
		}
	}
	$pdf->ezStream();



	$date = date( "Y-m-d " );
	//$date1=mosHTML::ConvertDateForDatatbase(date);

	$sql_query="insert into #__member_certificate values('','$memberid','$yearid','$user_id','$date','".$rows[0]->status."')";

	$sql_query=$database->replaceTablePrefix($sql_query);

	if((!mysql_query($sql_query)) ||(!$database->addMemberTrail($mid,'4',$user_id)))
	{
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
}

function MemberIdcard ( $database, $mid,$user_id,$working_reg_year_id ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $id, $type_id, $Itemid;
	global $mosConfig_absolute_path, $mosconfig_designation_idcard;
	$id = intval( mosGetParam( $_REQUEST, 'id', 1 ) );
	include( 'includes/class.ezpdf.php' );
	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait

	$preview=intval(mosGetParam( $_REQUEST, 'preview' ));



	$query= "select m.id as mbid,m.type_id as type_id, m.firm_name as firm,m.applicant_name as aplicant,"
	."\n mh.member_reg_no as lastRegNO, m.firm_reg_address_street as street,"
	."\n m.firm_reg_address_town_suburb as town,m.firm_reg_address_district"
	."\n as district,m.firm_reg_address_division as division,"
	."\n m.applicant_last_name as alast_name, m.applicant_title as atitle, "
	."\n m.representative_title as rtitle, m.representative_last_name as rlast_name, "
	."\n m.firm_reg_address_country as country,  des.name as designation,m.representative_photograph as rphotograph,"
	."\n m.representative_name as representative_name,rdes.name as rdesignation,"
	."\n m.applicant_photograph as photograpgh , m.tin as tin FROM #__member AS m"
	."\n left join #__designation as des on m.applicant_designation=des.id"
	."\n left join #__designation as rdes on m.representative_designation=rdes.id"
	."\n left join #__member_history as mh"
	. "\n on mh.member_id = m.id where m.id = '$mid' and mh.reg_year_id=$working_reg_year_id"
	;

	$bank = mosGetParam( $_REQUEST, 'bank' );
	$money_receipt_no=mosGetParam( $_REQUEST, 'money_receipt_no' );
	$money_receipt_date=mosHTML::ConvertDateForDatatbase(mosGetParam( $_REQUEST, 'money_receipt_date' ));
	$printedtimes=mosGetParam( $_REQUEST, 'printedtimes' );

	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$photograpgh=$rows[0]->representative_name? $rows[0]->rphotograph : $rows[0]->photograpgh;
	$memberid=$rows[0]->mbid;

	$img='./administrator/images/photograph/'.$memberid.'/'.strtolower($photograpgh);    // to set the path of the image only jpg will take


	$type_id=$rows[0]->type_id;
	if ($type_id==1)
	$regtype='G';
	else if ($type_id==2)
	$regtype='TA';
	else if ($type_id==3)
	$regtype='O';
	else if ($type_id==4)
	$regtype='A';
	//$aplicant=$rows[0]->representative_name ? $rows[0]->representative_name : $rows[0]->aplicant;
	$aplicant=$rows[0]->representative_name ? $rows[0]->rtitle." ".$rows[0]->representative_name." ".$rows[0]->rlast_name : $rows[0]->atitle." ".$rows[0]->aplicant." ".$rows[0]->alast_name ;
	$company=$rows[0]->firm;
	$regno=$rows[0]->lastRegNO;
	//$address=$rows[0]->street.', '.$rows[0]->town.', '.$rows[0]->district.', '.$rows[0]->division.', '.$rows[0]->country;
	$address=$rows[0]->street;
	$address.= trim($rows[0]->town)!="" ?", ".$rows[0]->town:"";
	$address.= trim($rows[0]->district)!="" ?", ".$rows[0]->district:"";
	$address.= trim($rows[0]->division)!="" ?", ".$rows[0]->division:"";
	$address.= trim($rows[0]->country)!="" ?", ".$rows[0]->country:"";

	$designation=$rows[0]->representative_name? $rows[0]->rdesignation: $rows[0]->designation;
	$tin=$rows[0]->tin;


	$query= "select ry.id as yearid, ry.name as yearname ,"
	. "\n ry.end_date as end_date from #__member_reg_year as ry where ry.id='$working_reg_year_id'"
	;

	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$end_date=$rows[0]->end_date;
	$yearid=$rows[0]->yearid;

	$sql1="select count(card_no) as card_no  from #__member_idcard where type_id ='$type_id'"
	. "\n and reg_year_id ='$yearid' and member_id='$memberid'"
	;
	$database->setQuery( $sql1);
	$result1 = $database->loadResult();

	$query="select card_no as card_no  from #__member_idcard where type_id ='$type_id'"
	. "\n and reg_year_id ='$yearid' and member_id='$mid'"
	;

	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$pdf -> ezSetCmMargins( 0, 0, 0, 0);


	$all = $pdf->openObject();
	$pdf->saveState();
	//logo
	$imglogo="./administrator/images/photograph/scci_logo_id_card.jpg"; // for the shed image
	if (file_exists($imglogo))
	{
		$pdf->addJpegFromFile($imglogo,80, 696, 73,73);     //210,743,65.6,74);
	}

	$imgright="./administrator/images/photograph/".$type_id."_right_bar.jpg"; // for the shed image
	if (file_exists($imgright))
	{
		$pdf->addJpegFromFile($imgright,260,666.2,15.6,76);
	}

	$imgtop="./administrator/images/photograph/".$type_id."_top_bar.jpg";
	if (file_exists($imgtop))
	{
		$pdf->addJpegFromFile($imgtop,15,802,195,15);
	}

	//if ($rows[0]->card_no)
	if ($result1>=1)
	{
		$cardno=$rows[0]->card_no;
		//$pdf->setColor(2,2,2,0);
		$pdf->setColor(0.4,0.4,0.4,0.4);
		if ($result1>1)
		$pdf->addText(19,795,10,'Duplicate',-30);
		$pdf->setColor(0,0,0,0);
		//$pdf->addText(16,806,7,'Duplicate');

	}
	else
	{
		$query="select count(distinct(member_id)) as count1 from #__member_idcard where type_id ='$type_id'"
		. "\n and reg_year_id ='$yearid'"
		;

		$query=$database->replaceTablePrefix($query);
		$database->setQuery( $query );
		$rows = $database->loadObjectList();

		$cardno=$rows[0]->count1 ? $rows[0]->count1 + 1 : 1 ;
	}

	if($preview==1){
		$pdf->setStrokeColor(128,0,0);
		$pdf->line(15,820,281,666.2);
		$pdf->line(15,666.2,281,820);
		$pdf->setStrokeColor(0,0,0);
	}

	$issueDate = date('d/m/Y');

	$pdf->setStrokeColor( 0, 0, 0, 1 );

	$pdf->rectangle(15,666.2,266.1,154.8); //to draw the bigger one rectangle
	$pdf->rectangle(210,743,65.6,74);   //to draw the samaller one

	$pdf->selectFont( './fonts/Courier-Oblique.afm' );
	$pdf->setColor(2,2,2,0);
	$pdf->addText( 80, 806 , 12, "IDENTITY CARD" );

	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setColor(0,40,0,0);
	$pdf->addText( 23, 790 , 7, 'THE SYLHET CHAMBER OF COMMERCE & INDUSTRY' );
	$pdf->setColor(0,0,0,0);
	$pdf->addText( 35, 780 , 7, 'Chamber Building, Jail Road, Sylhet, Bangladesh' );

	// $pdf->addText( 23, 766, 6,$imgright);
	$pdf->addText( 23, 756, 6,'Name');
	$pdf->addText( 23, 746, 6,'Name of Firm');
	$pdf->addText( 23, 736, 6,'Address');
	$pdf->addText( 23, 726, 6,'Designation');
	$pdf->addText( 23, 716, 6,'Membership #');
	$pdf->addText( 23, 706, 6,'Issue Date');

	$pdf->addText( 62, 756, 6,':');
	$pdf->addText( 62, 746, 6,':');
	$pdf->addText( 62, 736, 6,':');
	$pdf->addText( 62, 726, 6,':');
	$pdf->addText( 62, 716, 6,':');
	$pdf->addText( 62, 706, 6,':');

	$fontsize=7;
	if(strlen($company)>32)
	$fontsize=6;
	if (file_exists($img))
	{
		$pdf->addJpegFromFile($img,210,743,65.6,74);
	}

	$pdf->addText( 65, 756, 7,stripslashes($aplicant));
	$pdf->addText( 65, 746, $fontsize,stripslashes($company));
	$pdf->addText( 65, 736, 6,stripslashes($address));
	$pdf->addText( 65, 726, 7,stripslashes($designation));
	$pdf->addText( 65, 716, 7,$regtype.$regno);
	$pdf->addText( 65, 706, 7,$issueDate);

	$pdf->addText( 150, 726, 6,'TIN #');
	$pdf->addText( 150, 716, 6,'Card #');
	$pdf->addText( 150, 706, 6,'Valid up to');



	$pdf->addText( 180, 726, 6,':');
	$pdf->addText( 180, 716, 6,':');
	$pdf->addText( 180, 706, 6,':');


	$pdf->addText( 183, 726, 7,$tin);
	$pdf->addText( 183, 716, 7,$cardno);
	$pdf->addText( 183, 706, 7,date("j/m/Y", strtotime($end_date)) );

	$pdf->addText( 23, 677, 8,$mosconfig_designation_idcard);
	$pdf->addText( 170, 677, 8,'Secretary');

	// $pdf->rectangle(206,593.2,57.6,72);

	/*
	if (file_exists($img))
	{
	$pdf->addJpegFromFile($img,210,743,65.6,74);
	}
	*/
	$pdf->restoreState();
	$pdf->closeObject();
	$pdf->addObject( $all, 'all' );
	$pdf->ezSetDy( 30 );

	$pdf->ezStream();

	$date = date( "Y-m-d H:i:s" );

	if($preview!=1){

		$sql="select id from #__member_idcard where member_id='$memberid'"
		."\n and type_id='$type_id' and reg_year_id='$yearid' and money_receipt_no='$money_receipt_no' and money_receipt_date='$money_receipt_date'"
		;
		$database->setQuery( $sql );
		$result = $database->loadResult();
		if (intval($result)==0){

			$sql_query="insert into #__member_idcard values('','$memberid','$type_id','$yearid','$cardno','$user_id','$date','$money_receipt_no','$money_receipt_date')";
			//$sql_query="insert into #__member_idcard values('','$memberid','$type_id','$yearid','$cardno','$user_id','$date')";
			$sql_query=$database->replaceTablePrefix($sql_query);
			$database->setQuery($sql_query);
			if(!$database->query() )
			{
				echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
				exit();
			}
			$reference_id=$database->insertid();
			$database->addMemberTrail($memberid,'5',$user_id,'',$bank,$money_receipt_no);

			$sql_trans="select max(transaction_no) as transaction_no from #__account_transaction";
			$database->setQuery($sql_trans);
			$transaction_no=($database->loadResult()+1);
			$date1=date('Y-m-d');
			$sql_amount="select idcard_fee as idcard_fee from #__member_charge where member_type_id='$type_id' and reg_year_id='$yearid'";
			$database->setQuery($sql_amount);
			$amount=$database->loadResult();
			$account_query1="insert into #__account_transaction values('','$transaction_no','121','$amount','0','$reference_id','$money_receipt_date','$date1')";
			$account_query1=$database->replaceTablePrefix($account_query1);
			$account_query2="insert into #__account_transaction values('','$transaction_no','1','$amount','1','$reference_id','$money_receipt_date','$date1')";
			$account_query2=$database->replaceTablePrefix($account_query2);

			if(!(mysql_query($account_query1) && mysql_query($account_query2) ))
			{
				echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
				exit();
			}
		}
	}
}





function MemberCertificite_office_copy ( $database, $mid,$working_reg_year_id ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $id, $type_id, $Itemid;

	$id = intval( mosGetParam( $_REQUEST, 'id', 1 ) );
	include( 'includes/class.ezpdf.php' );

	/*$query="select m.id as mbid, m.firm_name as firm,m.applicant_name as aplicant, m.member_reg_no as"
	."\n lastRegNO, ry.name as yearname,ry.id as yearid, m.applicant_address_street as street,"
	. "\n  m.applicant_address_town_suburb as town,"
	. "\n m.applicant_address_district as district,m.applicant_address_division"
	. "\n as division, m.applicant_address_country as country,"
	."\n ry.end_date as end_date, mt.name as member_type, m.member_status as member_status  "
	."\n FROM #__member AS m Left JOIN #__member_reg_year as ry  on m.last_reg_year_id=ry.id"
	."\n left join #__member_type AS mt on m.type_id=mt.id  where m.id = '$mid'";*/


	$bank = mosGetParam( $_REQUEST, 'bank' );
	$money_receipt_no=mosGetParam( $_REQUEST, 'money_receipt_no' );


	$query="select m.id as mbid, m.firm_name as firm,m.applicant_name as aplicant, mh.member_reg_no as"
	."\n lastRegNO, ry.name as yearname,ry.id as yearid, m.applicant_address_street as street,"
	. "\n  m.applicant_address_town_suburb as town,mc.name as member_category,"
	. "\n m.applicant_address_district as district,m.applicant_address_division"
	. "\n as division, m.applicant_address_country as country,"
	."\n ry.end_date as end_date, mt.name as member_type, m.member_status as member_status  "
	."\n FROM #__member AS m"
	."\n Left JOIN #__member_history as mh  on mh.member_id=m.id"
	."\n Left JOIN #__member_reg_year as ry  on mh.reg_year_id=ry.id"
	."\n left join #__member_type AS mt on m.type_id=mt.id"
	. "\n Left JOIN #__member_category as mc on mc.id=m.member_category_id"
	."\n where m.id = '$mid' and mh.reg_year_id='$working_reg_year_id'";


	$query1="select YEAR(mh.date) as enrollment_year from #__member_history"
	."\n as mh where mh.member_id=$mid and mh.entry_type=1"
	;
	$query1=$database->replaceTablePrefix($query1);
	$database->setQuery( $query1 );
	$rows1 = $database->loadObjectList();
	$enrollment_year=$rows1[0]->enrollment_year;
	/*$dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
	$res =& $dbconn->query($sql_query);
	$row =& $res->fetchRow();
	*/
	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	//foreach ($rows as $row);
	$memberid=$rows[0]->mbid;
	$yearid=$rows[0]->yearid;
	$end_date=mosHTML::ConvertDateDisplayLong($rows[0]->end_date);

	$company=$rows[0]->firm;
	$regno=$rows[0]->lastRegNO;
	//$address=$rows[0]->applicant_address;
	//$address=$rows[0]->street.', '.$rows[0]->town.', '.$rows[0]->district.', '.$rows[0]->division.', '.$rows[0]->country;

	$address=$rows[0]->street;
	$address.= trim($rows[0]->town)!="" ?", ".$rows[0]->town:"";
	$address.= trim($rows[0]->district)!="" ?", ".$rows[0]->district:"";
	$address.= trim($rows[0]->division)!="" ?", ".$rows[0]->division:"";
	$address.= trim($rows[0]->country)!="" ?", ".$rows[0]->country:"";

	$yearname=$rows[0]->yearname;
	$member_type=$rows[0]->member_type;
	$member_status=$rows[0]->member_status;
	$member_category=$rows[0]->member_category;

	// $query="select money_receipt_no from #__member_history where id=(select max(id) from #__member_history where  member_id  ='$mid')";
	$query="select money_receipt_no from #__member_history where  member_id  ='$mid' and reg_year_id='$working_reg_year_id'";
	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	$money_receipt_no=$rows[0]->money_receipt_no;

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//      $pdf =& new Cezpdf( 'CUST', 'landscape' );  //A4 Portrait
	//     $pdf =& new Cezpdf( 'CUST1', 'P' );
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf -> ezSetCmMargins( 0, 0, 0, 0);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font

	$all = $pdf->openObject();
	$pdf->saveState();
	$pdf->setStrokeColor( 0, 0, 0, 1 );


	// $pdf->addText( 144.5, 498.6 , 12, $regno );
	// $pdf->addText( 266.4, 238.7, 20, $company );
	// $pdf->addText( 50.4, 201.7, 15, $address );

	// $pdf->addText( 144.5, 14, 15,  date( 'jS F, Y ', time() + $mosConfig_offset*60*60 ) );

	$pdf->addText( 16.5,806 , 12, _CHAMBER_NAME_BKMEA );
	$pdf->addText( 16.5, 786 , 10, 'Registration NO     : '.$regno );
	$pdf->addText( 16.5, 766, 10, 'Firm Name             : '.stripslashes($company) );
	$pdf->addText( 16.5, 746, 10, 'Address                 : '.stripslashes($address) );
	$pdf->addText( 16.5, 726, 10, 'Member Type        : '.stripslashes($member_type) );
	$pdf->addText( 16.5, 706, 10, 'Member Category  : '.stripslashes($member_category) );

	if ($member_status=='0')
	{
		$pdf->addText( 16.5, 686, 10,   'Member Status      : Provisional' );

	}
	else    $pdf->addText( 16.5, 686, 10,  'Member Status      : Permament' );
	// member_type


	$var = date('Y');

	//$pdf->addText( 470.5, 155.7, 15,   $var.'('.' '.numtoword($var).')' );
	$pdf->addText( 16.5, 666, 10,  'Valid Upto              : '.$end_date );
	$pdf->addText( 16.5, 646, 10,  'Money Receipt No : '.$money_receipt_no );

	$pdf->addText( 16.5, 626, 10,  'Issue Date              : '.date( 'jS F, Y ', time() + $mosConfig_offset*60*60 ) );
	$pdf->addText( 16.5, 606, 10,  'Enrollment Year     : '.$enrollment_year );

	$pdf->restoreState();
	$pdf->closeObject();
	$pdf->addObject( $all, 'all' );
	$pdf->ezSetDy( 30 );

	$pdf->ezStream();

}


function MemberCertificateScci ( $database, $mid ,$user_id,$working_reg_year_id,$typeid) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $id, $type_id, $Itemid;
	global $mosconfig_president_name;

	$id = intval( mosGetParam( $_REQUEST, 'id', 1 ) );
	include( 'includes/class.ezpdf.php' );
	//$pdf =& new Cezpdf( 'CUSTCCS', 'landscape' );
	$pdf =& new Cezpdf( 'a4', 'landscape' );
	$pdf -> ezSetCmMargins( 0, 0, 0, 0);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font

	$bank = mosGetParam( $_REQUEST, 'bank' );
	$money_receipt_no=mosGetParam( $_REQUEST, 'money_receipt_no' );
	$money_receipt_date=mosGetParam( $_REQUEST, 'money_receipt_date' );
	$working_reg_year_id=mosGetParam( $_REQUEST, 'working_reg_year_id' );
	$typeid=mosGetParam( $_REQUEST, 'typeid' );
	$printedtimes=mosGetParam( $_REQUEST, 'printedtimes' );
	// added my mizan at scci office dated on 13.03.2006
	$certificate_serial_no = mosGetParam( $_REQUEST, 'certificate_serial_no' );
	$president_name = mosGetParam( $_REQUEST, 'president_name' );
	//mosHTML::ConvertDateForDatatbase(date)
	if (intval($printedtimes)>0)
	{
		$pdf->setColor(1,0,0,1);
		//$pdf->addText(600,480,15,"DUPLICATE");
		$pdf->addText(50,565,15,"DUPLICATE");
		$pdf->setColor(0,0,0,0);
	}


	if($typeid>0){
		$type_name = $database->getMemberTypeName($typeid);
		$type_name_arr=explode(" ",$type_name);
		$type_name=$type_name_arr[0];
		$type_name.=(strtolower($type_name_arr[1])=="member" || trim($type_name_arr[1])=="")? "":" ".$type_name_arr[1];
		//$title=$type_name_arr[0].' Voter Card';
		if ($typeid==1)
		$reg='G';
		else if ($typeid==2)
		$reg='TA';
		else if ($typeid==3)
		$reg='O';
		else if ($typeid==4)
		$reg='A';




	}
	$query=" SELECT m.id AS mbid, m.firm_name AS firm, m.applicant_name AS aplicant,"
	. "\n mh.member_reg_no AS lastRegNO, m.firm_reg_address_street AS street,"
	. "\n m.firm_reg_address_town_suburb AS town, m.firm_reg_address_district AS district,"
	. "\n m.firm_reg_address_division AS division, m.firm_reg_address_country AS country,"
	. "\n mh.money_receipt_no AS money_receipt_no,mh.reg_date as reg_date,m.money_receipt_date as given_date "
	. "\n ,m.import_reg_no AS import_reg_no,m.export_reg_no as export_reg_no"
	. "\n FROM #__member AS m LEFT JOIN #__member_history AS mh ON m.id = mh.member_id"
	. "\n WHERE m.id ='$mid' and mh.reg_year_id ='$working_reg_year_id'";

	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	$memberid=$rows[0]->mbid;
	$company=$rows[0]->firm;
	$regno=$rows[0]->lastRegNO;
	$address=$rows[0]->street;
	$address.= trim($rows[0]->town)!="" ?", ".$rows[0]->town:"";
	$address.= trim($rows[0]->district)!="" ?", ".$rows[0]->district:"";
	$address.= trim($rows[0]->division)!="" ?", ".$rows[0]->division:"";
	$address.= trim($rows[0]->country)!="" ?", ".$rows[0]->country:"";
	$import_reg_no=$rows[0]->import_reg_no!=""?$rows[0]->import_reg_no:"~ ~ ~";
	$export_reg_no=$rows[0]->export_reg_no!=""?$rows[0]->export_reg_no:"~ ~ ~";

	if(trim($money_receipt_date)==""){
		//$reg_date=explode("-",$reg_date);
		//$reg_date=$reg_date[2]."-".$reg_date[1]."-".$reg_date[0];
		//$regdate=date("jS F Y", strtotime($rows[0]->reg_date));
		$regdate=date("jS F Y", strtotime($rows[0]->given_date));
	}
	else{
		$regdate=date("jS F Y", strtotime($money_receipt_date));
	}



	$query= "select ry.id as yearid, ry.end_date as end_date, ry.name as yearname ,"
	. "\n ry.end_date as end_date from #__member_reg_year as ry where ry.id='$working_reg_year_id'"
	;

	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$query= "select count(mc.id) from #__member_certificate as mc"
	."\n , #__member as m where m.id=mc.member_id and m.type_id='$typeid';";
	$database->setQuery( $query );
	$serial = $database->loadResult();
	$serial=$serial+1;

	$yearid=$rows[0]->yearid;
	$yearname=$rows[0]->yearname;
	$end_date=$rows[0]->end_date;



	$all = $pdf->openObject();
	$pdf->saveState();
	$pdf->setStrokeColor( 0, 0, 0, 1 );

	$pdf->addText( 150, 551 , 15, $reg.$regno );
	$pdf->addText( 720, 551 , 15, $serial );
	$pdf->addText( 160.22, 320.4, 15, stripslashes($company) );
	$pdf->addText( 160.22, 286.4, 15, stripslashes($address) );

	$pdf->addText( 306.4, 250.4, 15, stripslashes($import_reg_no) );
	$pdf->addText( 690.4, 250.4, 15, stripslashes($export_reg_no) );
	$pdf->addText( 110, 214, 15, strtoupper(stripslashes($type_name)) );
	$arr=explode("-",$end_date);
	$pdf->addText( 350, 180, 15,date("jS F Y", strtoupper(strtotime($end_date))) );

	$regdate=explode(" ",$regdate);
	$pdf->addText( 144, 105, 15,$regdate[0]." ".$regdate[1]." ".$regdate[2]);
	//$pdf->addText( 190, 112, 15,$regdate[1]);
	// $pdf->addText( 230.6, 112, 15,$regdate[2]);
	$pdf->addText( 605, 45, 15,$mosconfig_president_name);


	$date = date( "Y-m-d H:i:s" );

	if($printedtimes==0){
		$sql="select money_receipt_no as money_receipt_no, money_receipt_date as money_receipt_date"
		."\n from #__member_history where member_id='$id' and reg_year_id='$working_reg_year_id' ";
		$database->setQuery($sql);
		$rows=$database->loadObjectList();
		$row=$rows[0];
		$money_receipt_no=$row->money_receipt_no;
		$money_receipt_date=$row->money_receipt_date;
	}
	$sql="select id from #__member_certificate where member_id='$memberid'"
	."\n and money_receipt_no='$money_receipt_no' and money_receipt_date='$money_receipt_date'"
	;
	$database->setQuery( $sql );
	$result = $database->loadResult();
	$date1=date( "Y-m-d" );
	if (intval($result)==0){
		$sql_query="insert into #__member_certificate values('','$memberid','$yearid','$user_id','$date','$money_receipt_no','$money_receipt_date')";
		//$sql_query="insert into #__member_certificate values('','$memberid','$yearid','$user_id','$date')";
		$database->setQuery($sql_query);
		if(!$database->query())
		{
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		$reference_id=$database->insertid();
		$database->addMemberTrail($mid,'4',$user_id,'',$bank,$money_receipt_no);

		$sql="select certificate_fee as certificate_fee from #__member_charge where member_type_id='$typeid' and reg_year_id='$working_reg_year_id'";
		$database->setQuery($sql);
		$amount=$database->loadResult();

		$sql_trans="select max(transaction_no) as transaction_no from #__account_transaction";
		$database->setQuery($sql_trans);
		$transaction_no=($database->loadResult()+1);

		$account_query1="insert into #__account_transaction values('','$transaction_no','131','$amount','0','$reference_id','$money_receipt_date','$date1')";
		$account_query1=$database->replaceTablePrefix($account_query1);
		$account_query2="insert into #__account_transaction values('','$transaction_no','1','$amount','1','$reference_id','$money_receipt_date','$date1')";
		$account_query2=$database->replaceTablePrefix($account_query2);

		if(!(mysql_query($account_query1) && mysql_query($account_query2) ))
		{
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
	}
	$pdf->restoreState();
	$pdf->closeObject();
	$pdf->addObject( $all, 'all' );
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}

function MemberCertificateScci_bak ( $database, $mid ,$user_id,$working_reg_year_id,$typeid) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $id, $Itemid, $mosconfig_president_name;

	$id = intval( mosGetParam( $_REQUEST, 'id', 1 ) );
	include( 'includes/class.ezpdf.php' );
	//$pdf =& new Cezpdf( 'CUSTCCS', 'landscape' );
	$pdf =& new Cezpdf( 'a4', 'landscape' );
	$pdf -> ezSetCmMargins( 0, 0, 0, 0);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font

	$bank = mosGetParam( $_REQUEST, 'bank' );
	$money_receipt_no=mosGetParam( $_REQUEST, 'money_receipt_no' );
	$money_receipt_date=mosGetParam( $_REQUEST, 'money_receipt_date' );
	$working_reg_year_id=mosGetParam( $_REQUEST, 'working_reg_year_id' );
	$typeid=mosGetParam( $_REQUEST, 'typeid' );
	$printedtimes=mosGetParam( $_REQUEST, 'printedtimes' );

	if ($printedtimes>"0")
	{
		$pdf->setColor(1,0,0,1);
		//$pdf->addText(600,480,15,"DUPLICATE");
		$pdf->addText(73,560,15,"DUPLICATE");
		$pdf->setColor(0,0,0,0);
	}


	if($typeid>0){
		$type_name = $database->getMemberTypeName($typeid);
		$type_name_arr=explode(" ",$type_name);
		$type_name=$type_name_arr[0];
		$type_name.=(strtolower($type_name_arr[1])=="member" || trim($type_name_arr[1])=="")? "":" ".$type_name_arr[1];
		//$title=$type_name_arr[0].' Voter Card';
		if ($typeid==1)
		$reg='G';
		else if ($typeid==2)
		$reg='TA';
		else if ($typeid==3)
		$reg='O';
		else if ($typeid==4)
		$reg='A';

	}

	$query=" SELECT m.id AS mbid, m.firm_name AS firm, m.applicant_name AS aplicant,"
	. "\n mh.member_reg_no AS lastRegNO, m.firm_reg_address_street AS street,"
	. "\n m.firm_reg_address_town_suburb AS town, m.firm_reg_address_district AS district,"
	. "\n m.firm_reg_address_division AS division, m.firm_reg_address_country AS country,"
	. "\n mh.money_receipt_no AS money_receipt_no,mh.reg_date as reg_date"
	. "\n ,m.import_reg_no AS import_reg_no,m.export_reg_no as export_reg_no"
	. "\n FROM #__member AS m LEFT JOIN #__member_history AS mh ON m.id = mh.member_id"
	. "\n WHERE m.id ='$mid' and mh.reg_year_id ='$working_reg_year_id'";

	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	$memberid=$rows[0]->mbid;
	$company=$rows[0]->firm;
	$regno=$rows[0]->lastRegNO;
	$address=$rows[0]->street;
	$address.= trim($rows[0]->town)!="" ?", ".$rows[0]->town:"";
	$address.= trim($rows[0]->district)!="" ?", ".$rows[0]->district:"";
	$address.= trim($rows[0]->division)!="" ?", ".$rows[0]->division:"";
	$address.= trim($rows[0]->country)!="" ?", ".$rows[0]->country:"";
	$import_reg_no=$rows[0]->import_reg_no!=""?$rows[0]->import_reg_no:"~ ~ ~";
	$export_reg_no=$rows[0]->export_reg_no!=""?$rows[0]->export_reg_no:"~ ~ ~";
	$regdate=date("jS F Y", strtotime($rows[0]->reg_date));

	$query= "select ry.id as yearid, ry.end_date as end_date, ry.name as yearname ,"
	. "\n ry.end_date as end_date from #__member_reg_year as ry where ry.id='$working_reg_year_id'"
	;

	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$query= "select count(*) from #__member_certificate";
	$database->setQuery( $query );
	$serial = $database->loadResult();
	$serial=$serial+1;

	$yearid=$rows[0]->yearid;
	$yearname=$rows[0]->yearname;
	$end_date=$rows[0]->end_date;

	$all = $pdf->openObject();
	$pdf->saveState();
	$pdf->setStrokeColor( 0, 0, 0, 1 );

	$pdf->addText( 176.22, 543.77 , 12, $reg.$regno );
	$pdf->addText( 735, 540.77 , 12, $serial );

	$pdf->addText( 163.22, 321.64, 15, stripslashes($company) );
	$pdf->addText( 70.4, 292.4, 15, stripslashes($address) );

	$pdf->addText( 293.4, 255.4, 12, stripslashes($import_reg_no) );
	$pdf->addText( 640.4, 255.4, 12, stripslashes($export_reg_no) );
	$pdf->addText( 106, 224.4, 12, stripslashes($type_name) );
	$arr=explode("-",$end_date);
	$pdf->addText( 355, 191, 12,date("jS F Y", strtotime($end_date)) );

	$regdate=explode(" ",$regdate);
	$pdf->addText( 184, 121, 12,$regdate[0]." ".$regdate[1]." ".$regdate[2]);
	$pdf->addText( 612, 66, 12,$mosconfig_president_name);


	$date = date( "Y-m-d H:i:s" );

	if($printedtimes==0){
		$sql="select money_receipt_no as money_receipt_no, money_receipt_date as money_receipt_date"
		."\n from #__member_history where member_id='$id' and reg_year_id='$working_reg_year_id' ";
		$database->setQuery($sql);
		$rows=$database->loadObjectList();
		$row=$rows[0];
		$money_receipt_no=$row->money_receipt_no;
		$money_receipt_date=$row->money_receipt_date;
	}

	$date1=date( "Y-m-d" );
	$sql_query="insert into #__member_certificate values('','$memberid','$yearid','$user_id','$date','$money_receipt_no','$money_receipt_date')";
	//$sql_query="insert into #__member_certificate values('','$memberid','$yearid','$user_id','$date')";
	$database->setQuery($sql_query);
	if(!$database->query())
	{
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$reference_id=$database->insertid();
	$database->addMemberTrail($mid,'4',$user_id,'',$bank,$money_receipt_no);

	$sql="select certificate_fee as certificate_fee from #__member_charge where member_type_id='$typeid' and reg_year_id='$working_reg_year_id'";
	$database->setQuery($sql);
	$amount=$database->loadResult();

	$sql_trans="select max(transaction_no) as transaction_no from #__account_transaction";
	$database->setQuery($sql_trans);
	$transaction_no=($database->loadResult()+1);

	$account_query1="insert into #__account_transaction values('','$transaction_no','131','$amount','0','$reference_id','$money_receipt_date','$date1')";
	$account_query1=$database->replaceTablePrefix($account_query1);
	$account_query2="insert into #__account_transaction values('','$transaction_no','1','$amount','1','$reference_id','$money_receipt_date','$date1')";
	$account_query2=$database->replaceTablePrefix($account_query2);

	if(!(mysql_query($account_query1) && mysql_query($account_query2) ))
	{
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$pdf->restoreState();
	$pdf->closeObject();
	$pdf->addObject( $all, 'all' );
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}


function MemberCertificateScciAssociate ( $database, $mid ,$user_id,$working_reg_year_id) {             // for associate member of sylhet
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $id, $type_id, $Itemid;

	$id = intval( mosGetParam( $_REQUEST, 'id', 1 ) );
	include( 'includes/class.ezpdf.php' );


	$query=" SELECT m.id AS mbid, m.firm_name AS firm, m.applicant_name AS aplicant,"
	. "\n mh.member_reg_no AS lastRegNO, m.firm_reg_address_street AS street,"
	. "\n m.firm_reg_address_town_suburb AS town, m.firm_reg_address_district AS district,"
	. "\n m.firm_reg_address_division AS division, m.firm_reg_address_country AS country,"
	. "\n mh.money_receipt_no AS money_receipt_no"
	. "\n FROM #__member AS m LEFT JOIN #__member_history AS mh ON m.id = mh.member_id"
	. "\n WHERE m.id ='$mid' and mh.reg_year_id='$working_reg_year_id'";

	$bank = mosGetParam( $_REQUEST, 'bank' );
	$money_receipt_no=mosGetParam( $_REQUEST, 'money_receipt_no' );
	$money_receipt_date=mosGetParam( $_REQUEST, 'money_receipt_date' );
	$working_reg_year_id=mosGetParam( $_REQUEST, 'working_reg_year_id' );
	$typeid=mosGetParam( $_REQUEST, 'typeid' );
	$printedtimes=mosGetParam( $_REQUEST, 'printedtimes' );


	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	//foreach ($rows as $row);
	$memberid=$rows[0]->mbid;
	$company=$rows[0]->firm;
	$regno=$rows[0]->lastRegNO;
	//$address=$rows[0]->applicant_address;


	$money_receipt_no=$rows[0]->money_receipt_no;
	// $address=$rows[0]->street.', '.$rows[0]->town.', '.$rows[0]->district.', '.$rows[0]->division.', '.$rows[0]->country;

	$address=$rows[0]->street;
	$address.= trim($rows[0]->town)!="" ?", ".$rows[0]->town:"";
	$address.= trim($rows[0]->district)!="" ?", ".$rows[0]->district:"";
	$address.= trim($rows[0]->division)!="" ?", ".$rows[0]->division:"";
	$address.= trim($rows[0]->country)!="" ?", ".$rows[0]->country:"";

	$query= "select ry.id as yearid, ry.end_date as end_date, ry.name as yearname ,"
	. "\n ry.end_date as end_date from #__member_reg_year as ry where ry.id='$working_reg_year_id'"
	;

	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	$end_date=$rows[0]->end_date;
	$yearid=$rows[0]->yearid;
	$yearname=$rows[0]->yearname;


	$pdf =& new Cezpdf( 'CUSTASSOCCS', 'landscape' );

	$pdf -> ezSetCmMargins( 0, 0, 0, 0);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font

	$all = $pdf->openObject();
	$pdf->saveState();
	$pdf->setStrokeColor( 0, 0, 0, 1 );

	$pdf->addText( 141.73, 527.55 , 12, $regno );
	$pdf->addText( 314.3, 291.13, 15, stripslashes($company) );
	$pdf->addText( 70.87, 253.37, 15, stripslashes($address) );
	$var = date('Y');

	$arr=explode("-",$end_date);

	$pdf->addText( 133, 175, 12,date("jS F Y", strtotime($end_date)) );
	$pdf->addText( 220, 130.67, 12, $money_receipt_no );

	$pdf->restoreState();
	$pdf->closeObject();
	$pdf->addObject( $all, 'all' );
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();


	$date = date( "Y-m-d H:i:s" );
	if($printedtimes==0){
		$sql="select money_receipt_no as money_receipt_no, money_receipt_date as money_receipt_date"
		."\n from #__member_history where member_id='$id' and reg_year_id='$working_reg_year_id' ";
		$database->setQuery($sql);
		$rows=$database->loadObjectList();
		$row=$rows[0];
		$money_receipt_no=$row->money_receipt_no;
		$money_receipt_date=$row->money_receipt_date;
	}

	$sql_query="insert into #__member_certificate values('','$memberid','$yearid','$user_id','$date','$money_receipt_no','$money_receipt_date')";
	$database->setQuery($sql_query);
	if(!$database->query())
	{
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$reference_id=$database->insertid();
	$database->addMemberTrail($mid,'4',$user_id,'',$bank,$money_receipt_no);

	$sql="select certificate_fee as certificate_fee from #__member_charge where member_type_id='$typeid' and reg_year_id='$working_reg_year_id'";
	$database->setQuery($sql);
	$amount=$database->loadResult();

	$sql_trans="select max(transaction_no) as transaction_no from #__account_transaction";
	$database->setQuery($sql_trans);
	$transaction_no=($database->loadResult()+1);

	$account_query1="insert into #__account_transaction values('','$transaction_no','131','$amount','0','$reference_id','$date')";
	$account_query1=$database->replaceTablePrefix($account_query1);
	$account_query2="insert into #__account_transaction values('','$transaction_no','1','$amount','1','$reference_id','$date')";
	$account_query2=$database->replaceTablePrefix($account_query2);

	if(!(mysql_query($account_query1) && mysql_query($account_query2) ))
	{
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

}

function MemberCertificite_ccc ( $database, $mid ,$user_id,$working_reg_year_id ) {  //certificate for chittagong
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $id, $type_id, $Itemid;

	$id = intval( mosGetParam( $_REQUEST, 'id', 1 ) );
	include( 'includes/class.ezpdf.php' );

	/*$query="select m.id as mbid, m.firm_name as firm,m.applicant_name as aplicant,ry.end_date as end_date , m.member_reg_no as lastRegNO, ry.name as yearname,ry.id as yearid, m.applicant_address  as applicant_address FROM mos_membership AS m Left JOIN mos_member_reg_year as ry  on m.last_reg_year_id=ry.id  where m.id = '$mid'";*/

	/*$query= "select m.id as mbid, m.firm_name as firm,m.applicant_name as aplicant, m.member_reg_no as lastRegNO,"
	. "\n m.import_reg_no as import_reg_no, m.export_reg_no as export_reg_no, m.indenting_trade_no as"
	. "\n indenting_trade_no , m.firm_reg_address_street as street, m.firm_reg_address_town_suburb as town,"
	. "\n m.firm_reg_address_district as district,m.firm_reg_address_division as division,"
	. "\n m.firm_reg_address_country as country  FROM #__member AS m  where m.id = '$mid'"
	;*/

	$query= "select m.id as mbid, m.firm_name as firm,m.applicant_name as aplicant, mh.member_reg_no as lastRegNO,"
	. "\n m.import_reg_no as import_reg_no, m.export_reg_no as export_reg_no, m.indenting_trade_no as"
	. "\n indenting_trade_no , m.firm_reg_address_street as street, m.firm_reg_address_town_suburb as town,"
	. "\n m.firm_reg_address_district as district,m.firm_reg_address_division as division,"
	. "\n m.firm_reg_address_country as country,mh.reg_date as reg_date FROM #__member AS m"
	. "\n left join #__member_history as mh on mh.member_id=m.id where mh.reg_year_id='$working_reg_year_id' and  m.id = '$mid'"
	;


	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	//foreach ($rows as $row);
	$memberid=$rows[0]->mbid;

	$import_reg_no=$rows[0]->import_reg_no;
	$export_reg_no=$rows[0]->export_reg_no;
	$indenting_trade_no=$rows[0]->indenting_trade_no;
	$regdate=date("jS F Y", strtotime($rows[0]->reg_date));
	$regdate=explode(" ",$regdate);

	$company=$rows[0]->firm;
	$regno='M|GEN|36|'.$rows[0]->lastRegNO.'|';
	//$address=$rows[0]->street.', '.$rows[0]->town.', '.$rows[0]->district.', '.$rows[0]->division.', '.$rows[0]->country;

	$address=$rows[0]->street;
	$address.= trim($rows[0]->town)!="" ?", ".$rows[0]->town:"";
	$address.= trim($rows[0]->district)!="" ?", ".$rows[0]->district:"";
	$address.= trim($rows[0]->division)!="" ?", ".$rows[0]->division:"";
	$address.= trim($rows[0]->country)!="" ?", ".$rows[0]->country:"";

	$query= "select ry.id as yearid,  ry.name as yearname ,"
	. "\n ry.end_date as end_date from #__member_reg_year as ry where ry.id='$working_reg_year_id'"
	;
	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$yearname=$rows[0]->yearname;
	$yearid=$rows[0]->yearid;
	//$yeartitle=$rows[0]->yeartitle;
	$regno=$regno.$yearname;

	$end_date=$rows[0]->end_date;

	//$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf =& new Cezpdf( 'CUSTccs', 'landscape' );  //A4 Portrait
	$pdf =& new Cezpdf( 'CUSTCCC', 'landscape' );
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf -> ezSetCmMargins( 0, 0, 0, 0);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font

	$all = $pdf->openObject();
	$pdf->saveState();
	$pdf->setStrokeColor( 0, 0, 0, 1 );


	$pdf->addText( 99.21, 367.37 , 12, $regno );
	$pdf->addText( 156.71, 318.64, 15, stripslashes($company) );
	$pdf->addText( 83.70, 291.29, 12, stripslashes($address) );

	$pdf->addText( 266.11, 260.45, 12, $import_reg_no );
	$pdf->addText( 539.71, 260.45, 12, $export_reg_no);
	$pdf->addText( 285.76, 228.27, 12, $indenting_trade_no );







	$pdf->addText( 311, 179.59, 12,date("jS F Y", strtotime($end_date)) );
	$pdf->addText( 144, 101, 12,$regdate[0] );
	$pdf->addText( 350, 101, 12,$regdate[1] );
	$pdf->addText( 560.6, 101, 12,$regdate[2] );


	//$pdf->addText( 99.21,126, 12,  date( 'd-m', time() + $mosConfig_offset*60*60 ) ); // this two lines are for the issue date we may need these in future
	//$pdf->addText( 200.17,126, 12,  $var[3] );


	$pdf->restoreState();
	$pdf->closeObject();
	$pdf->addObject( $all, 'all' );
	$pdf->ezSetDy( 30 );

	$txt1 = stripslashes($row->companyname);
	$pdf->ezText( $txt1, 14 );

	$txt2 = NULL;
	$create_date = NULL;
	if ( intval( $created ) <> 0 ) {
		$create_date = mosFormatDate( $created );
	}
	/*
	if ( $mosConfig_hideCreateDate == '0' ) {
	$txt2 .= '('. $create_date .')  ';
	}
	*/
	if ( $mosConfig_hideAuthor == "0" ) {
		if ( $row->author != '' && $mosConfig_hideAuthor == '0' ) {
			if ($row->usertype == 'administrator' || $row->usertype == 'superadministrator') {
				$txt2 .=  _WRITTEN_BY .' '. ( $row->created_by_alias ? $row->created_by_alias : $row->author );
			} else {
				$txt2 .=  _AUTHOR_BY .' '. ( $row->created_by_alias ? $row->created_by_alias : $row->author );
			}
		}
	}

	// $txt2 .= "\n\n";
	// $pdf->ezText( $txt2, 8 );
	//$pdf->line( 10, 40, 78, 40 );
	//$pdf->line( 10, 800, 78, 800 );
	// $txt3 = $fulltext;
	// $pdf->ezText( $txt3, 10 );
	$pdf->ezStream();



	$date = date( "Y-m-d H:i:s" );

	//        $sql_query="insert into mos_member_certificate values('','$memberid','$yearid','$user_id','$date')";
	$sql_query="insert into mos_member_certificate values('','$memberid','$yearid','$user_id','$date')";
	$sql_query=$database->replaceTablePrefix($sql_query);
	if((!mysql_query($sql_query)) ||(!$database->addMemberTrail($mid,'4',$user_id)))
	{
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
}


//report for membership details

function AllMemberCcci ( ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font

	//$all = $pdf->openObject();
	//$pdf->saveState();
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');
	//this is the start of the logic to get the search result

	//Header
	$TITLE="Member List";
	ReportTitle($pdf, 'ccci',_CHAMBER_NAME_CCCI, _ADDRESS_CCCI, _CONTACT_NUMBER_CCCI, _EMAIL_CCCI, $TITLE, 'center');


	$rows=array();
	$search_obj=new mosSearchPublicSite();
	//et(entry type)=1 --> for real time purchase;
	if(intval($_GET['et'])==1){
		$search_criteria=explode("__",$_GET['search_criteria']);         //search criteria for business directory
		$rows=$search_obj->botSearchMemberCcci('general', $search_criteria[0], $search_criteria[1], $search_criteria[2], $search_criteria[3], $search_criteria[4], $search_criteria[5], $search_criteria[6], $search_criteria[7], $search_criteria[8]);
		$search_obj->invoice_id=intval($_GET['invoice_id']);
		$search_obj->saveSearchQuery();
		//$pdf->ezText($_GET['invoice_id']."-".intval($_GET['et']),10);
	}
	//et(entry type)=0 --> for sales tracker;
	if(intval($_GET['et'])==0){
		$search_obj->invoice_id=intval($_GET['invoice_id']);
		$rows=$search_obj->execSearchQuery();
	}
	$totalRows = count( $rows );
	$i=1;

	$data=array();
	foreach($rows as $row){
		$SLNO=$i;
		$id =$row->id;
		$firm_name =$row->firm_name;
		$applicant=$row->title." ".$row->first_name." ".$row->last_name;
		$employee=$row->employee==0?"":$row->employee;
		$address=$row->street;
		$address.= trim($row->town)    !="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?", ".$row->district:"";
		$address.= trim($row->division)!="" ?", ".$row->division:"";
		$address.= trim($row->country) !="" ?", ".$row->country:"";
		$capacity=$row->capacity==0?"":$row->capacity;
		$location=$row->location;
		$product="";

		$sql = "SELECT pl.name AS pname "
		. "\n FROM #__member_product_line as mpl, #__product_line as pl "
		. "\n WHERE mpl.member_id='$id' and mpl.product_id=pl.id";
		$database->setQuery( $sql );
		$lists = $database->loadObjectList();
		$temp=false;
		foreach($lists as $list){
			if($temp==false){
				$product = $list->pname;
				$temp=true;
			}
			else
			$product .= (trim($list->pname)!="" || !is_null($list->pname))?", ".$list->pname:"";
		}

		$arr=array('SLNO'=>stripslashes($SLNO),'firm_name'=>stripslashes($firm_name),'applicant'=>stripslashes($applicant)
		,'employee'=>stripslashes($employee),'address'=>stripslashes($address),'capacity'=>stripslashes($capacity)
		,'location'=>stripslashes($location),'product'=>stripslashes($product));
		array_push($data,$arr);
		$i++;
	}

	$cols = array('SLNO'=>"Sl.",'firm_name'=>'Firm Name',
	'applicant'=>'Contact Person','employee'=>'No of Emp.',
	'address'=>'Address','capacity'=>'Capacity',
	'location'=>'Location',
	'product'=>'Product');

	$pdf->ezTable($data,$cols,'',array('xPos'=>580,'showLines'=>2, 'showHeadings'=>1,'shaded'=> 0,'xOrientation'=>'left','width'=>570,
	'cols'=>array(
	'SLNO'=>array('justification'=>'left','width'=>25),
	'firm_name'=>array('justification'=>'left','width'=>90),
	'applicant'=>array('justification'=>'left','width'=>85),
	'employee'=>array('justification'=>'left','width'=>40),
	'address'=>array('justification'=>'left','width'=>105),
	'capacity'=>array('justification'=>'left','width'=>50),
	'location'=>array('justification'=>'left','width'=>50),
	'product'=>array('justification'=>'left','width'=>115)
	)),9);

	//end of logic


	// footer
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}

//report for membership details

function IndividualMemberCcci ( ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');
	//this is the start of the logic to get the search result

	$rows=array();
	$search_obj=new mosSearchPublicSite();
	//et(entry type)=1 --> for real time purchase;
	if(intval($_GET['et'])==1){
		$search_criteria=explode("__",$_GET['search_criteria']);
		$rows=$search_obj->botSearchMemberCcci('detail', $search_criteria[0], $search_criteria[1], $search_criteria[2], $search_criteria[3], $search_criteria[4], $search_criteria[5], $search_criteria[6], $search_criteria[7], $search_criteria[8]);
		$search_obj->invoice_id=intval($_GET['invoice_id']);
		$search_obj->saveSearchQuery();
		//$pdf->ezText($_GET['invoice_id']."-".intval($_GET['et']),10);
	}
	//et(entry type)=0 --> for sales tracker;
	if(intval($_GET['et'])==0){
		$search_obj->invoice_id=intval($_GET['invoice_id']);
		$rows=$search_obj->execSearchQuery();
	}

	$total_member=count($rows);
	for($page=0;$page<$total_member;$page++){
		$row=$rows[$page];
		//Header
		$TITLE="";
		ReportTitle($pdf, 'ccci',_CHAMBER_NAME_CCCI, _ADDRESS_CCCI, _CONTACT_NUMBER_CCCI, _EMAIL_CCCI, $TITLE, 'center');

		$address1 =$row->street;
		$address1.=trim($row->town)    !="" ? ", ".$row->town:"";
		$address1.=trim($row->district)!="" ? ", ".$row->district:"";
		$address1.=trim($row->division)!="" ? ", ".$row->division:"";
		$address1.=trim($row->country) !="" ? ",  ".$row->country:"";
		$address2 =$row->hstreet;
		$address2.=trim($row->htown)    !="" ? ", ".$row->htown:"";
		$address2.=trim($row->hdistrict)!="" ? ", ".$row->hdistrict:"";
		$address2.=trim($row->hdivision)!="" ? ", ".$row->hdivision:"";
		$address2.=trim($row->hcountry) !=""  ? ",  ".$row->hcountry:"";
		$employee =$row->employee?" Total - ".$row->employee:"";
		$employee.=$row->male?" ( Male - ".$row->male:"";
		$employee.=$row->female?" Female - ".$row->female." ) ":"";
		$capacity.=$row->capacity ==0 ? "":$row->capacity;

		$pdf->ezText( stripslashes($row->firm_name), 12 );
		$pdf->ezText( "", 10 );
		$pdf->ezText( "Contact Person : ".stripslashes($row->title." ".$row->first_name." ".$row->last_name), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Member Type : ".stripslashes($row->type_name), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Membership Number : ".stripslashes($row->reg_no), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Registration Date : ".date('dS F Y', strtotime($row->reg_date)), 10 );  //date('dS F Y', strtotime($row->reg_date))
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Last Update Date : ".date('dS F Y', strtotime($row->date)), 10 );        //date('dS F Y', strtotime($row->date))
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Commencing Date : ".$row->commencing_date, 10 );  //date('dS F Y', strtotime($row->commencing_date))
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Production Capacity/Year : ".stripslashes($capacity), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Employee : ".stripslashes($employee), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Location : ".stripslashes($row->location), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Applicant Firm Address : ".stripslashes($address1), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Applicant Firm Phone : ".stripslashes($row->home_phone), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Applicant Mobile : ".stripslashes($row->firm_mobile), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Applicant Fax : ".stripslashes($row->firm_fax), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Applicant Email : ".stripslashes($row->firm_email), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Head Office Address : ".stripslashes($address2), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Head Office Phone : ".stripslashes($row->office_phone.", ".$row->head_office_mobile), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Head Office Fax : ".stripslashes($row->head_office_fax), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Head Office Email : ".stripslashes($row->head_office_email), 10 );
		$pdf->ezText( "", 8 );

		$query1= "SELECT pl.name as pname "
		."\n from #__member_product_line as mpl, #__product_line as pl"
		."\n WHERE mpl.member_id ='".$row->id."' and pl.id=mpl.product_id" ;

		$database->setQuery( $query1 );
		$lists = $database->loadObjectList();

		$temp=false;
		foreach($lists as $list){
			if($temp==false){
				$product = $list->pname;
				$temp=true;
			}
			else
			$product .= (trim($list->pname)!="" || !is_null($list->pname))?", ".$list->pname:"";
		}
		$pdf->ezText( "Product List : ".stripslashes($product), 10 );
		ReportFooter($pdf);
		if($page<($total_member-1))
		$pdf->ezNewPage();
	}

	//end of logic
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}
//report for membership details

function AllMemberScci ( ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font

	//$all = $pdf->openObject();
	//$pdf->saveState();
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');
	//this is the start of the logic to get the search result

	//Header
	$TITLE="Member List";
	ReportTitle($pdf, 'scci',_CHAMBER_NAME_SCCI, _ADDRESS_SCCI, _CONTACT_NUMBER_SCCI, _EMAIL_SCCI, $TITLE, 'center');


	$rows=array();
	$search_obj=new mosSearchPublicSite();
	//et(entry type)=1 --> for real time purchase;
	if(intval($_GET['et'])==1){
		$search_criteria=explode("__",$_GET['search_criteria']);
		$rows=$search_obj->botSearchMemberScci('general', $search_criteria[0], $search_criteria[1], $search_criteria[2], $search_criteria[3], $search_criteria[4], $search_criteria[5], $search_criteria[6], $search_criteria[7]);
		$search_obj->invoice_id=intval($_GET['invoice_id']);
		$search_obj->saveSearchQuery();
		//$pdf->ezText($_GET['invoice_id']."-".intval($_GET['et']),10);
	}
	//et(entry type)=0 --> for sales tracker;
	if(intval($_GET['et'])==0){
		$search_obj->invoice_id=intval($_GET['invoice_id']);
		$rows=$search_obj->execSearchQuery();
	}

	$totalRows = count( $rows );
	$i=1;

	$data=array();
	foreach($rows as $row){
		$SLNO=$i;
		$id =$row->id;
		$firm_name =$row->firm_name;
		$applicant=$row->title." ".$row->first_name." ".$row->last_name;
		$employee=$row->employee==0?"":$row->employee;
		$address=$row->street;
		$address.= trim($row->town)    !="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?", ".$row->district:"";
		$address.= trim($row->division)!="" ?", ".$row->division:"";
		$address.= trim($row->country) !="" ?", ".$row->country:"";
		$capacity=$row->capacity==0?"":$row->capacity;
		$location=$row->location;
		$product="";

		$sql = "SELECT pl.name AS pname "
		. "\n FROM #__member_product_line as mpl, #__product_line as pl "
		. "\n WHERE mpl.member_id='$id' and mpl.product_id=pl.id";
		$database->setQuery( $sql );
		$lists = $database->loadObjectList();
		$temp=false;
		foreach($lists as $list){
			if($temp==false){
				$product = $list->pname;
				$temp=true;
			}
			else
			$product .= (trim($list->pname)!="" || !is_null($list->pname))?", ".$list->pname:"";
		}

		$arr=array('SLNO'=>stripslashes($SLNO),'firm_name'=>stripslashes($firm_name),'applicant'=>stripslashes($applicant)
		,'employee'=>stripslashes($employee),'address'=>stripslashes($address),'capacity'=>stripslashes($capacity)
		,'location'=>stripslashes($location),'product'=>stripslashes($product));
		array_push($data,$arr);
		$i++;
	}

	$cols = array('SLNO'=>"Sl.",'firm_name'=>'Firm Name',
	'applicant'=>'Contact Person','employee'=>'No of Emp.',
	'address'=>'Address','capacity'=>'Capacity',
	'location'=>'Location',
	'product'=>'Product');

	$pdf->ezTable($data,$cols,'',array('xPos'=>580,'showLines'=>2, 'showHeadings'=>1,'shaded'=> 0,'xOrientation'=>'left','width'=>570,
	'cols'=>array(
	'SLNO'=>array('justification'=>'left','width'=>25),
	'firm_name'=>array('justification'=>'left','width'=>90),
	'applicant'=>array('justification'=>'left','width'=>85),
	'employee'=>array('justification'=>'left','width'=>40),
	'address'=>array('justification'=>'left','width'=>105),
	'capacity'=>array('justification'=>'left','width'=>50),
	'location'=>array('justification'=>'left','width'=>50),
	'product'=>array('justification'=>'left','width'=>115)
	)),9);

	//end of logic


	// footer
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}

//report for membership details

function IndividualMemberScci ( ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');
	//this is the start of the logic to get the search result

	$rows=array();
	$search_obj=new mosSearchPublicSite();
	//et(entry type)=1 --> for real time purchase;
	if(intval($_GET['et'])==1){
		$search_criteria=explode("__",$_GET['search_criteria']);
		$rows=$search_obj->botSearchMemberScci('detail', $search_criteria[0], $search_criteria[1], $search_criteria[2], $search_criteria[3], $search_criteria[4], $search_criteria[5], $search_criteria[6], $search_criteria[7]);
		$search_obj->invoice_id=intval($_GET['invoice_id']);
		$search_obj->saveSearchQuery();
		//$pdf->ezText($_GET['invoice_id']."-".intval($_GET['et']),10);
	}
	//et(entry type)=0 --> for sales tracker;
	if(intval($_GET['et'])==0){
		$search_obj->invoice_id=intval($_GET['invoice_id']);
		$rows=$search_obj->execSearchQuery();
	}

	$total_member=count($rows);
	for($page=0;$page<$total_member;$page++){
		$row=$rows[$page];
		//Header
		$TITLE="";
		ReportTitle($pdf, 'scci',_CHAMBER_NAME_SCCI, _ADDRESS_SCCI, _CONTACT_NUMBER_SCCI, _EMAIL_SCCI, $TITLE, 'center');

		$address1 =$row->street;
		$address1.=trim($row->town)    !="" ? ", ".$row->town:"";
		$address1.=trim($row->district)!="" ? ", ".$row->district:"";
		$address1.=trim($row->division)!="" ? ", ".$row->division:"";
		$address1.=trim($row->country) !="" ? ",  ".$row->country:"";
		$address2 =$row->hstreet;
		$address2.=trim($row->htown)    !="" ? ", ".$row->htown:"";
		$address2.=trim($row->hdistrict)!="" ? ", ".$row->hdistrict:"";
		$address2.=trim($row->hdivision)!="" ? ", ".$row->hdivision:"";
		$address2.=trim($row->hcountry) !=""  ? ",  ".$row->hcountry:"";
		$employee =$row->employee?" Total - ".$row->employee:"";
		$employee.=$row->male?" ( Male - ".$row->male:"";
		$employee.=$row->female?" Female - ".$row->female." ) ":"";
		$capacity.=$row->capacity ==0 ? "":$row->capacity;

		$pdf->ezText( stripslashes($row->firm_name), 12 );
		$pdf->ezText( "", 10 );
		$pdf->ezText( "Contact Person : ".stripslashes($row->title." ".$row->first_name." ".$row->last_name), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Member Type : ".stripslashes($row->type_name), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Membership Code : ".stripslashes($row->reg_no), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Registration Date : ".date('dS F Y', strtotime($row->reg_date)), 10 );  //date('dS F Y', strtotime($row->reg_date))
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Last Update Date : ".date('dS F Y', strtotime($row->date)), 10 );        //date('dS F Y', strtotime($row->date))
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Commencing Date : ".$row->commencing_date, 10 );  //date('dS F Y', strtotime($row->commencing_date))
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Production Capacity/Year : ".stripslashes($capacity), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Employee : ".stripslashes($employee), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Location : ".stripslashes($row->location), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Applicant Firm Address : ".stripslashes($address1), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Applicant Firm Phone : ".stripslashes($row->home_phone), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Applicant Mobile : ".stripslashes($row->firm_mobile), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Applicant Fax : ".stripslashes($row->firm_fax), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Applicant Email : ".stripslashes($row->firm_email), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Head Office Address : ".stripslashes($address2), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Head Office Phone : ".stripslashes($row->office_phone.", ".$row->head_office_mobile), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Head Office Fax : ".stripslashes($row->head_office_fax), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Head Office Email : ".stripslashes($row->head_office_email), 10 );
		$pdf->ezText( "", 8 );

		$query1= "SELECT pl.name as pname "
		."\n from #__member_product_line as mpl, #__product_line as pl"
		."\n WHERE mpl.member_id ='".$row->id."' and pl.id=mpl.product_id" ;

		$database->setQuery( $query1 );
		$lists = $database->loadObjectList();

		$temp=false;
		foreach($lists as $list){
			if($temp==false){
				$product = $list->pname;
				$temp=true;
			}
			else
			$product .= (trim($list->pname)!="" || !is_null($list->pname))?", ".$list->pname:"";
		}
		$pdf->ezText( "Product List : ".stripslashes($product), 10 );
		ReportFooter($pdf);
		if($page<($total_member-1))
		$pdf->ezNewPage();
	}

	//end of logic
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}

function AllMemberBkmea ( ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font

	//$all = $pdf->openObject();
	//$pdf->saveState();
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');
	//this is the start of the logic to get the search result

	//Header
	$TITLE="Member List";
	ReportTitle($pdf, 'bkmea',_CHAMBER_NAME_BKMEA, _ADDRESS_BKMEA, _CONTACT_NUMBER_BKMEA, _EMAIL_BKMEA, $TITLE, 'center');


	$rows=array();
	$search_obj=new mosSearchPublicSite();
	//et(entry type)=1 --> for real time purchase;
	if(intval($_GET['et'])==1){
		$search_criteria=explode("__",$_GET['search_criteria']);
		//$rows=$search_obj-botSearchMemberBkmea('general', $search_criteria[0], $search_criteria[1], $search_criteria[2], $search_criteria[3], $search_criteria[4], $search_criteria[5],$search_criteria[6],$search_criteria[7]);
		$rows=$search_obj->botSearchMemberBkmea('general', $search_criteria[0], $search_criteria[1], $search_criteria[2], $search_criteria[3], $search_criteria[4], $search_criteria[5],$search_criteria[6],$search_criteria[7]);
		$search_obj->invoice_id=intval($_GET['invoice_id']);
		$search_obj->saveSearchQuery();
		//$pdf->ezText($_GET['invoice_id']."-".intval($_GET['et']),10);
	}
	//et(entry type)=0 --> for sales tracker;
	if(intval($_GET['et'])==0){
		$search_obj->invoice_id=intval($_GET['invoice_id']);
		$rows=$search_obj->execSearchQuery();
	}

	$totalRows = count( $rows );
	$i=1;
	$data=array();
	foreach($rows as $row){
		$SLNO=$i;
		$id =$row->id;
		$firm_name =$row->firm_name;
		$applicant=$row->title." ".$row->firstname." ".$row->lastname;
		$employee=$row->employee==0?"":$row->employee;
		$address=$row->street;
		$address.= trim($row->town)    !="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?", ".$row->district:"";
		$address.= trim($row->division)!="" ?", ".$row->division:"";
		$address.= trim($row->country) !="" ?", ".$row->country:"";
		$capacity=$row->capacity==0?"":$row->capacity;
		$location=$row->location;
		$product="";

		$sql = "SELECT pl.name AS pname "
		. "\n FROM #__member_product_line as mpl, #__product_line as pl "
		. "\n WHERE mpl.member_id='$id' and mpl.product_id=pl.id";
		$database->setQuery( $sql );
		$lists = $database->loadObjectList();
		$temp=false;
		foreach($lists as $list){
			if($temp==false){
				$product = $list->pname;
				$temp=true;
			}
			else
			$product .= (trim($list->pname)!="" || !is_null($list->pname))?", ".$list->pname:"";
		}

		$arr=array('SLNO'=>stripslashes($SLNO),'firm_name'=>stripslashes($firm_name),'applicant'=>stripslashes($applicant)
		,'employee'=>stripslashes($employee),'address'=>stripslashes($address),'capacity'=>stripslashes($capacity)
		,'location'=>stripslashes($location),'product'=>stripslashes($product));
		array_push($data,$arr);
		$i++;
	}

	$cols = array('SLNO'=>"Sl.",'firm_name'=>'Firm Name',
	'applicant'=>'Contact Person','employee'=>'No of Emp.',
	'address'=>'Address','capacity'=>'Capacity',
	'location'=>'Location',
	'product'=>'Product');

	$pdf->ezTable($data,$cols,'',array('xPos'=>580,'showLines'=>2, 'showHeadings'=>1,'shaded'=> 0,'xOrientation'=>'left','width'=>570,
	'cols'=>array(
	'SLNO'=>array('justification'=>'left','width'=>30),
	'firm_name'=>array('justification'=>'left','width'=>90),
	'applicant'=>array('justification'=>'left','width'=>85),
	'employee'=>array('justification'=>'left','width'=>40),
	'address'=>array('justification'=>'left','width'=>105),
	'capacity'=>array('justification'=>'left','width'=>50),
	'location'=>array('justification'=>'left','width'=>50),
	'product'=>array('justification'=>'left','width'=>115)
	)),9);

	//end of logic

	// footer
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}

//report for membership details

function IndividualMemberBkmea ( ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');
	//this is the start of the logic to get the search result
	$rows=array();
	$search_obj=new mosSearchPublicSite();
	//et(entry type)=1 --> for real time purchase;
	if(intval($_GET['et'])==1){
		$search_criteria=explode("__",$_GET['search_criteria']);
		//$rows=$search_obj->botSearchMemberBkmea('detail', $search_criteria[0], $search_criteria[1], $search_criteria[2], $search_criteria[3], $search_criteria[4], $search_criteria[5],$search_criteria[6],$search_criteria[7]);
		$rows=$search_obj->botSearchMemberBkmea('detail', $search_criteria[0], $search_criteria[1], $search_criteria[2], $search_criteria[3], $search_criteria[4], $search_criteria[5],$search_criteria[6],$search_criteria[7]);
		$search_obj->invoice_id=intval($_GET['invoice_id']);
		$search_obj->saveSearchQuery();
		//$pdf->ezText($_GET['invoice_id']."-".intval($_GET['et']),10);
	}
	//et(entry type)=0 --> for sales tracker;
	if(intval($_GET['et'])==0){
		$search_obj->invoice_id=intval($_GET['invoice_id']);
		$rows=$search_obj->execSearchQuery();
	}

	$total_member=count($rows);
	for($page=0;$page<$total_member;$page++){
		$row=$rows[$page];
		//Header
		$TITLE="";
		ReportTitle($pdf, 'bkmea',_CHAMBER_NAME_BKMEA, _ADDRESS_BKMEA, _CONTACT_NUMBER_BKMEA, _EMAIL_BKMEA, $TITLE, 'center');

		$address1 =$row->street;
		$address1.=trim($row->town)    !="" ? ", ".$row->town:"";
		$address1.=trim($row->district)!="" ? ", ".$row->district:"";
		$address1.=trim($row->division)!="" ? ", ".$row->division:"";
		$address1.=trim($row->country) !="" ? ",  ".$row->country:"";
		$address2 =$row->fstreet;
		$address2.=trim($row->ftown)    !="" ? ", ".$row->ftown:"";
		$address2.=trim($row->fdistrict)!="" ? ", ".$row->fdistrict:"";
		$address2.=trim($row->fdivision)!="" ? ", ".$row->fdivision:"";
		$address2.=trim($row->fcountry) !=""  ? ",  ".$row->fcountry:"";
		$employee =$row->total_employee?" Total - ".$row->total_employee:"";
		$employee.=$row->male?" ( Male - ".$row->male:"";
		$employee.=$row->female?" Female - ".$row->female." ) ":"";
		$capacity=$row->capacity ==0 ? "Not Available":$row->capacity;

		$pdf->ezText( stripslashes($row->firm_name), 12 );
		$pdf->ezText( "", 10 );
		$pdf->ezText( "Contact Person : ".stripslashes($row->title." ".$row->firstname." ".$row->lastname), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Member Type : ".stripslashes($row->type), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Registration Date : ".date('dS F Y',strtotime($row->reg_date)), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Last Update Date : ".date('dS F Y H:i',strtotime($row->date)), 10 );        //mosHTML::ConvertDateDisplayLong($row[0]->commencing_date)
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Commencing Date : ".date('dS F Y',strtotime($row->commencing_date)), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Production Capacity/day : ".stripslashes($capacity), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Employee : ".stripslashes($employee), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Location : ".stripslashes($row->location), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Factory Address : ".stripslashes($address1), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Office Address : ".stripslashes($address2), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Home Phone : ".stripslashes($row->home_phone), 10 );
		$pdf->ezText( "", 8 );
		$pdf->ezText( "Office Phone : ".stripslashes($row->office_phone), 10 );
		$pdf->ezText( "", 8 );

		$query1= "SELECT pl.name as pname "
		."\n from #__member_product_line as mpl, #__product_line as pl"
		."\n WHERE mpl.member_id ='".$row->id."' and pl.id=mpl.product_id" ;

		$database->setQuery( $query1 );
		$lists = $database->loadObjectList();

		$temp=false;
		foreach($lists as $list){
			if($temp==false){
				$product = $list->pname;
				$temp=true;
			}
			else
			$product .= (trim($list->pname)!="" || !is_null($list->pname))?", ".$list->pname:"";
		}
		$pdf->ezText( "Product List: ".stripslashes($product), 10 );
		ReportFooter($pdf);
		if($page<($total_member-1))
		$pdf->ezNewPage();
	}
	//end of logic
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}

function MemberCertificite_office_copy_ccci ( $database, $mid, $working_reg_year_id,$FOR) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $id, $type_id, $Itemid;

	$id = intval( mosGetParam( $_REQUEST, 'id', 1 ) );
	include( 'includes/class.ezpdf.php' );


	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait

	$pdf -> ezSetCmMargins( 0, 0, 0, 0);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font

	$all = $pdf->openObject();
	$pdf->saveState();
	$pdf->setStrokeColor( 0, 0, 0, 1 );

	$query= "select m.id as mbid, m.firm_name as firm,m.applicant_name as aplicant, mh.member_reg_no as"
	. "\n lastRegNO, mt.name as member_type, m.firm_reg_address_street as street,"
	. "\n m.firm_reg_address_town_suburb as town, m.firm_reg_address_district as"
	. "\n district,m.firm_reg_address_division as division, m.firm_reg_address_country as country"
	. "\n ,m.import_reg_no as import_reg_no, m.export_reg_no as export_reg_no,m.indenting_trade_no as indenting_trade_no"
	. "\n FROM #__member AS m left join mos_member_type AS mt on m.type_id=mt.id"
	. "\n left join mos_member_history AS mh on mh.member_id=m.id"
	. "\n where m.id =  '$mid' and mh.reg_year_id='$working_reg_year_id' and (mh.entry_type=1 or mh.entry_type=2) "
	;

	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	$memberid=$rows[0]->mbid;

	$company=$rows[0]->firm;
	$regno=$FOR=='ccc'? 'M|GEN|36|'.$rows[0]->lastRegNO.'|' : $rows[0]->lastRegNO;
	$address =$rows[0]->street;
	$address.= trim($rows[0]->town)!="" ?", ".$rows[0]->town:"";
	$address.= trim($rows[0]->district)!="" ?", ".$rows[0]->district:"";
	$address.= trim($rows[0]->division)!="" ?", ".$rows[0]->division:"";
	$address.= trim($rows[0]->country)!="" ?", ".$rows[0]->country:"";
	//$address=$rows[0]->street.', '.$rows[0]->town.', '.$rows[0]->district.', '.$rows[0]->division.', '.$rows[0]->country;

	$import_reg_no=$rows[0]->import_reg_no;
	$export_reg_no=$rows[0]->export_reg_no;
	$indenting_trade_no=$rows[0]->indenting_trade_no;

	$member_type=$rows[0]->member_type;

	$query= "select ry.id as yearid,  ry.name as yearname ,"
	. "\n ry.end_date as end_date from #__member_reg_year as ry where ry.id='$working_reg_year_id'"
	;

	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$yearid=$rows[0]->yearid;
	$end_date=$rows[0]->end_date;
	$yearname=$rows[0]->yearname;

	$regno= $FOR=='ccc'? $regno.$yearname : $regno."";

	$query="select money_receipt_no from #__member_history where id=(select max(id) from #__member_history where  member_id  ='$mid' and reg_year_id='$working_reg_year_id')";
	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	$money_receipt_no=$rows[0]->money_receipt_no;



	$pdf->ezText( "  "._CHAMBER_NAME_CCCI , 12);
	$pdf->ezText( '', 6);

	$pdf->ezText( '  Registration No                : '.$regno , 10);
	$pdf->ezText( '', 8);
	$pdf->ezText( '  Firm Name                       : '.stripslashes($company) , 10);
	$pdf->ezText( '', 8);
	$pdf->ezText( '  Address                            : '.stripslashes($address) , 10);
	$pdf->ezText( '', 8);
	$pdf->ezText( '  Member Type                   : '.stripslashes($member_type) , 10);
	$pdf->ezText( '', 8);
	$pdf->ezText( '  Import Registration No     : '.stripslashes($import_reg_no) , 10);
	$pdf->ezText( '', 8);
	$pdf->ezText( '  Export Registration No     : '.stripslashes($export_reg_no) , 10);
	$pdf->ezText( '', 8);
	$pdf->ezText( '  Indenting Registration No : '.stripslashes($indenting_trade_no), 10 );
	$pdf->ezText( '', 8);

	$var = date('Y');
	$pdf->ezText( '  Valid Upto                         : '.date("jS F Y", strtotime($end_date)) , 10);
	$pdf->ezText( '', 8);
	$pdf->ezText( '  Money Receipt No            : '.$money_receipt_no , 10);
	$pdf->ezText( '', 8);
	$pdf->ezText( '  Printed Date                      : '.date("dS F Y") , 10);

	$pdf->restoreState();
	$pdf->closeObject();
	$pdf->addObject( $all, 'all' );
	$pdf->ezSetDy( 30 );

	$pdf->ezStream();

}


function MemberCertificite_office_copy_scci ( $database, $mid, $working_reg_year_id,$FOR,$typeid) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $id, $type_id, $Itemid;

	$id = intval( mosGetParam( $_REQUEST, 'id', 1 ) );
	include( 'includes/class.ezpdf.php' );


	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait

	$pdf -> ezSetCmMargins( 0, 0, 1, 0);   //top,bottom, left, right
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font

	$all = $pdf->openObject();
	$pdf->saveState();
	$pdf->setStrokeColor( 0, 0, 0, 1 );

	$query= "select m.id as mbid, m.firm_name as firm,m.applicant_name as aplicant, mh.member_reg_no as"
	. "\n lastRegNO, mt.name as member_type, m.firm_reg_address_street as street,"
	. "\n m.firm_reg_address_town_suburb as town, m.firm_reg_address_district as"
	. "\n district,m.firm_reg_address_division as division, m.firm_reg_address_country as country"
	. "\n ,m.import_reg_no as import_reg_no, m.export_reg_no as export_reg_no,m.indenting_trade_no as indenting_trade_no"
	. "\n FROM #__member AS m left join mos_member_type AS mt on m.type_id=mt.id"
	. "\n left join mos_member_history AS mh on mh.member_id=m.id"
	. "\n where m.id =  '$mid' and mh.reg_year_id='$working_reg_year_id' and (mh.entry_type=1 or mh.entry_type=2) "
	;

	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	$memberid=$rows[0]->mbid;

	$company=$rows[0]->firm;
	$regno=$FOR=='ccc'? 'M|GEN|36|'.$rows[0]->lastRegNO.'|' : $rows[0]->lastRegNO;
	$address =$rows[0]->street;
	$address.= trim($rows[0]->town)!="" ?", ".$rows[0]->town:"";
	$address.= trim($rows[0]->district)!="" ?", ".$rows[0]->district:"";
	$address.= trim($rows[0]->division)!="" ?", ".$rows[0]->division:"";
	$address.= trim($rows[0]->country)!="" ?", ".$rows[0]->country:"";
	//$address=$rows[0]->street.', '.$rows[0]->town.', '.$rows[0]->district.', '.$rows[0]->division.', '.$rows[0]->country;

	$import_reg_no=$rows[0]->import_reg_no;
	$export_reg_no=$rows[0]->export_reg_no;
	$indenting_trade_no=$rows[0]->indenting_trade_no;

	$member_type=$rows[0]->member_type;

	if ($typeid==1)
	$reg='G';
	else if ($typeid==2)
	$reg='TA';
	else if ($typeid==3)
	$reg='O';
	else if ($typeid==4)
	$reg='A';

	$query= "select ry.id as yearid,  ry.name as yearname , entry_type as entry_type,"
	. "\n ry.end_date as end_date from #__member_reg_year as ry "
	. "\n Left Join #__member_history as mh on mh.reg_year_id=ry.id"
	. "\n where ry.id='$working_reg_year_id'"
	;

	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$yearid=$rows[0]->yearid;
	$end_date=$rows[0]->end_date;
	$yearname=$rows[0]->yearname;
	$certificate_for=($rows[0]->entry_type==1)?"New Member":"Renewed Member";

	$regno= $FOR=='ccc'? $regno.$yearname : $regno."";

	$query="select money_receipt_no from #__member_history where id=(select max(id) from #__member_history where  member_id  ='$mid' and reg_year_id='$working_reg_year_id')";
	$query=$database->replaceTablePrefix($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	$money_receipt_no=$rows[0]->money_receipt_no;

	$query= "select count(mc.id) from #__member_certificate as mc"
	."\n , #__member as m where m.id=mc.member_id and m.type_id='$typeid';";
	$database->setQuery( $query );
	$serial = $database->loadResult();
	$serial=$serial+1;

	$pdf->ezText( _CHAMBER_NAME_SCCI , 12);
	$pdf->ezText( '', 6);
	$pdf->ezText( 'Certificate For                  : '.$certificate_for , 10);
	$pdf->ezText( '', 6);
	$pdf->ezText( 'Membership Code           : '.$reg.$regno , 10);
	$pdf->ezText( '', 6);
	$pdf->ezText( 'Firm Name                       : '.stripslashes($company) , 10);
	$pdf->ezText( '', 6);
	$pdf->ezText( 'Address                            : '.stripslashes($address) , 10);
	$pdf->ezText( '', 6);
	$pdf->ezText( 'Member Type                   : '.stripslashes($member_type) , 10);
	$pdf->ezText( '', 6);
	$pdf->ezText( 'Import Registration No     : '.stripslashes($import_reg_no) , 10);
	$pdf->ezText( '', 6);
	$pdf->ezText( 'Export Registration No     : '.stripslashes($export_reg_no) , 10);
	$pdf->ezText( '', 6);
	$pdf->ezText( 'Indenting Registration No : '.stripslashes($indenting_trade_no), 10 );
	$pdf->ezText( '', 6);

	$var = date('Y');
	$pdf->ezText( 'Certificate Valid Upto        : '.date("jS F Y", strtotime($end_date)) , 10);
	$pdf->ezText( '', 6);
	$pdf->ezText( 'unless otherwise notified by the office of CCCI&E/', 10);
	$pdf->ezText( 'scheduled Bank or other concerened authority', 10);
	$pdf->ezText( '', 6);
	$pdf->ezText( 'Money Receipt No            : '.$money_receipt_no , 10);
	$pdf->ezText( '', 6);
	$pdf->ezText( 'Entry Date                        : '.date("Y-m-d") , 10);
	$pdf->ezText( '', 6);
	$pdf->ezText( 'Serial Number                  : '.$serial , 10);

	$pdf->restoreState();
	$pdf->closeObject();
	$pdf->addObject( $all, 'all' );
	$pdf->ezSetDy( 30 );

	$pdf->ezStream();

}
//report :: for new and renewed member
/*
function MemberReportBkmea ( ) {
global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
global $database, $_MAMBOTS, $mosHtmlObj;

include( 'includes/class.ezpdf.php' );

$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
//$pdf->ezSetMargins(30,30,30,30);
$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
$pdf->setStrokeColor( 0, 0, 0, 1 );
$pdf->ezSetDy(-10,'makeSpace');

//this is the start of the logic to get the search result
$year = date('Y');
$type_id     = intval( mosGetParam( $_REQUEST, 'type_id' ));
$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));

$last_reg_year_id   = trim( mosGetParam( $_REQUEST, 'last_reg_year_id' ));
$category_id   = trim( mosGetParam( $_REQUEST, 'category_id' ));



$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);

$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);

$where = array();

if ($category_id>0)
{
$where[]="m.member_category_id='$category_id'";
}

if ($type_id > 0) {
$where[] = "m.type_id='$type_id'";
$type_name = $database->getMemberTypeName($type_id);
$TITLE=$type_name." List";
}
else
$TITLE="All Member List";

// report header


if ($report_for == 0) {    //All member
$where[] = "(( h.entry_type = '1' and h.reg_year_id='$last_reg_year_id') || ( h.entry_type = '2' and h.reg_year_id='$last_reg_year_id' )) ";

if ($date_from != '' && $date_to != '' ) {
$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
$where[] = "( ( m.reg_date>='$date_from' and m.reg_date<='$date_to') || ( m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to' ))";
}
else if ($date_from == '' && $date_to != '' ) {
$reporting_period="Reporting Period : Upto ".$date_to_display;
$where[] = "( m.reg_date<='$date_to' || m.last_reg_date<='$date_to' )";
}
else if ($date_from != '' && $date_to == '' ) {
$reporting_period="Reporting Period : From ".$date_from_display;
$where[] = "( m.reg_date>='$date_from' || m.last_reg_date>='$date_from' )";
}
}
else if ($report_for == 1) {    //new member
$where[] = "h.entry_type = '1' and h.reg_year_id='$last_reg_year_id'";

if ($date_from != '' && $date_to != '' ) {
$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
$where[] = "m.reg_date>='$date_from' and m.reg_date<='$date_to'";
}
else if ($date_from == '' && $date_to != '' ) {
$reporting_period="Reporting Period : Upto ".$date_to_display;
$where[] = "m.reg_date<='$date_to'";
}
else if ($date_from != '' && $date_to == '' ) {
$reporting_period="Reporting Period : From ".$date_from_display;
$where[] = "m.reg_date>='$date_from'";
}
}
else if ($report_for == 2) {    //renewed member
$where[] = "h.entry_type = '2' and h.reg_year_id='$last_reg_year_id'";

if ($date_from != '' && $date_to != '' ) {
$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
$where[] = "m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to'";
}
else if ($date_from == '' && $date_to != '' ) {
$reporting_period="Reporting Period : Upto ".$date_to_display;
$where[] = "m.last_reg_date<='$date_to'";
}
else if ($date_from != '' && $date_to == '' ) {
$reporting_period="Reporting Period : From ".$date_from_display;
$where[] = "m.last_reg_date>='$date_from'";
}
}
else if($report_for == 3 ){
// $where[]= "h.member_id not in (select member_id from mos_member_history"
//       ."\n where reg_year_id = $last_reg_year_id and (entry_type='1' or entry_type='2') ) "
//     ."\n and h.reg_year_id<$last_reg_year_id "
//   ;

$where[]= " m.last_reg_year_id<$last_reg_year_id "
;

// if ($date_from != '' && $date_to != '' ) {
// $where[] = "m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to'";
//}
//else if ($date_from == '' && $date_to != '' ) {
// $where[] = "m.last_reg_date<='$date_to'";
//}
//else if ($date_from != '' && $date_to == '' ) {
//$where[] = "m.last_reg_date>='$date_from'";
// }

}
ReportTitle($pdf, 'bkmea',_CHAMBER_NAME_BKMEA, _ADDRESS_BKMEA, _CONTACT_NUMBER_BKMEA, _EMAIL_BKMEA, $TITLE, 'center',$reporting_period);

$query = "select distinct(m.id) as id, m.firm_name as firm_name, m.tin as tin "
."\n ,m.type_id as type_id , m.last_reg_year_id as last_reg_year_id,mt.name as type_name"
."\n ,m.applicant_office_phone as phone, md.name as designation,h.member_reg_no as member_reg_no"
."\n ,m.applicant_name as name, m.applicant_address_street as street"
."\n ,m.applicant_title as title, m.applicant_last_name as last_name"
."\n ,m.applicant_address_town_suburb as town, m.applicant_address_district as district"
."\n ,m.applicant_address_division as division, m.applicant_address_country as country"
."\n ,m.applicant_fax as fax,m.applicant_mobile as mobile,m.applicant_email as email from #__member as m "
."\n LEFT JOIN #__member_history AS h ON h.member_id = m.id"
."\n LEFT JOIN #__designation AS md ON md.id = m.applicant_designation"
."\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
."\n where m.is_delete =0 "
. ( count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
."\n ORDER BY m.firm_name "
;

$database->setQuery( $query );
$rows = $database->loadObjectList();


$i=1;
$data=array();
foreach($rows as $row){
//get total dues for outstanding member
if($report_for == 3 ){
$sql=  "select sum(renewal_fee+renew_development_fee+worker_welfare) as renewal_fee from mos_member_charge"
."\n where member_type_id= ".$row->type_id
."\n and reg_year_id>(select max(reg_year_id) from MOS_member_history"
."\n where reg_year_id<$last_reg_year_id and member_id=".$row->id
."\n ) and reg_year_id<=$last_reg_year_id "
;

$database->setQuery( $sql );
$row1 = $database->loadObjectList();
$renewal_fee=$row1[0]->renewal_fee;
$grand_total = $grand_total + $renewal_fee;
}
//common for all
$SLNO=$i;
$applicant=$row->name;
$address=$row->street;
$address.= trim($row->town)!="" ?", ".$row->town:"";
$address.= trim($row->district)!="" ?", ".$row->district:"";
$address.= trim($row->division)!="" ?", ".$row->division:"";
$address.= trim($row->country)!="" ?", ".$row->country:"";
$tin = $row->tin;
$email=stripcslashes($row->email);
$email=$row->emaill!=""?"\n".decodeHTML($email):"";

$col1= strip_tags( $row->firm_name.$email."\n".$address );
$col1= decodeHTML( $col1 );
$contact= $row->mobile == "" ? "" :"Mobile: ".$row->mobile ;
$contact.= $contact == "" ? "" : "\n";
$contact.= $row->phone == "" ? "" :"Phone: ".$row->phone ;
$contact.= $contact == "" ? "" : "\n";
$contact.= $row->fax == "" ? "" :"Fax: ".$row->fax ;
$contact= decodeHTML( $contact );
$col4=$row->title;
$col4.=" ".$row->name;
$col4.=$row->last_name!=""?" ".$row->name:"";
$col4.=$row->designation!=""?"\n".$row->designation:"";
$col4= decodeHTML($col4 );
$member_reg_no=$row->member_reg_no;
$type_name=$row->type_name;



if($report_for>=0 && $report_for<3){    //prepare array for New and Renewal Member
$arr=array( 'SLNO'=>stripslashes($SLNO)
,'member_reg_no'=>stripslashes($member_reg_no)
,'firm_name'=>stripslashes($col1)
,'type_name'=>stripslashes($type_name)
//,'email'=>$email
,'contact'=>stripslashes($contact)
,'applicant'=>stripslashes($col4)
);
}
else{                                  //prepare array for outstanding Member
$arr=array( 'SLNO'=>stripslashes($SLNO)
,'member_reg_no'=>stripslashes($member_reg_no)
,'firm_name'=>stripslashes($col1)
//,'tin'=>stripslashes($tin)
,'type_name'=>stripslashes($type_name)
,'contact'=>stripslashes($contact)
,'applicant'=>stripslashes($col4)
,'dues'=>$renewal_fee
);
}

array_push($data,$arr);

$i++;
}
if($report_for>=0 && $report_for<3){
//prepare col title for new and renewal member
$cols = array('SLNO'=>"Sl.",
'member_reg_no'=>'Membership No.',
'firm_name'=>'Firm Name',
'type_name'=>'Member Type',
//'email'=>'E-mail Address',
'contact'=>'Mobile, Phone, Fax',
'applicant'=>'Applicant Name'
);
//generate table for new and renewal member
$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>580,'xOrientation'=>'left','width'=>570,
'cols'=>array(
'SLNO'=>array('justification'=>'left','width'=>25),
'member_reg_no'=>array('justification'=>'left','width'=>77),
'firm_name'=>array('justification'=>'left','width'=>173),
'type_name'=>array('justification'=>'left','width'=>85),
//'tin'=>array('justification'=>'left','width'=>80),
'contact'=>array('justification'=>'left','width'=>100),
'applicant'=>array('justification'=>'left','width'=>110),
)), 9);
}
else{
//prepare col title for outstanding member
$cols = array('SLNO'=>"Sl.",
'member_reg_no'=>'Membership No.',
'firm_name'=>'Firm Name',
'type_name'=>'Member Type',
//'email'=>'E-mail Address',
'contact'=>'Mobile, Phone, Fax',
'applicant'=>'Applicant Name',
'dues'=>'Dues (Tk.)'
);
$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>580,'xOrientation'=>'left','width'=>570,
'cols'=>array(
'SLNO'=>array('justification'=>'left','width'=>25),
'member_reg_no'=>array('justification'=>'left','width'=>77),
'firm_name'=>array('justification'=>'left','width'=>133),
'type_name'=>array('justification'=>'left','width'=>85),
//'tin'=>array('justification'=>'left','width'=>80),
'contact'=>array('justification'=>'left','width'=>95),
'applicant'=>array('justification'=>'left','width'=>100),
'dues'=>array('justification'=>'right','width'=>55),
)), 9);
$pdf->ezText( "", 3 );
$data1=array();

$cols1 = array('SLNO'=>"",
'member_reg_no'=>'',
'firm_name'=>'',
'type_name'=>'',
//'email'=>'E-mail Address',
'contact'=>'',
'applicant'=>'Total Dues (Tk.) :',
'dues'=>$grand_total
);
$pdf->ezTable($data1,$cols1,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(1,1,1),'xPos'=>580,'xOrientation'=>'left','width'=>570,
'cols'=>array(
'SLNO'=>array('justification'=>'left','width'=>25),
'member_reg_no'=>array('justification'=>'left','width'=>77),
'firm_name'=>array('justification'=>'left','width'=>133),
'type_name'=>array('justification'=>'left','width'=>85),
//'tin'=>array('justification'=>'left','width'=>80),
'contact'=>array('justification'=>'left','width'=>100),
'applicant'=>array('justification'=>'right','width'=>100),
'dues'=>array('justification'=>'right','width'=>50),
)), 9);

$pdf->ezText("In Words : ".numtoword($grand_total)."Taka Only",10);
//$pdf->ezText( "", 10 );
// $pdf->ezText( "Total Dues: Tk. ".$grand_total, 10 );

}


//end of logic

// footer
ReportFooter($pdf);
$pdf->ezSetDy( 30 );
$pdf->ezStream();
}
*/

function MemberReportBkmea ( ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	//$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//this is the start of the logic to get the search result
	$year = date('Y');
	$type_id     = intval( mosGetParam( $_REQUEST, 'type_id' ));
	$membership_no     =  mosGetParam( $_REQUEST, 'membership_no' );
	$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));
	$no_of_years=intval( mosGetParam( $_REQUEST, 'no_of_years' ));
	$last_reg_year_id   = trim( mosGetParam( $_REQUEST, 'last_reg_year_id' ));
	$category_id   = trim( mosGetParam( $_REQUEST, 'category_id' ));
	$order_by=intval( mosGetParam( $_REQUEST, 'order_by' ));


	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);

	$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
	$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);

	$where = array();

	if ($category_id>0)
	{
		$where[]="m.member_category_id='$category_id'";
	}

	if ($type_id > 0) {
		$where[] = "m.type_id='$type_id'";
		$type_name = $database->getMemberTypeName($type_id);
		$TITLE=$type_name." List";
	}
	else {
		if($report_for==3)
		$TITLE="Outstanding Member List";
		else
		$TITLE="List Of All Member";
	}

	if ($membership_no!=""){
		$members1=explode(",",$membership_no);
		$members2=array();

		for ($i=0;$i<count($members1);$i++){
			if(trim($members1)!=""){
				if (strpos($members1[$i],'-',0)){
					$temp=explode("-",$members1[$i]);
					if ($temp[0]>$temp[1]){
						$t=$temp[0];
						$temp[0]=$temp[1];
						$temp[1]=$t;
					}
					for ($j=intval($temp[0]);$j<=intval($temp[1]);$j++){
						if (is_numeric($j))
						array_push($members2,$j);
					}
				}
				else{
					if (is_numeric($members1[$i]))
					array_push($members2,$members1[$i]);
				}
			}
		}

		/*  for ($i=0;$i<count($members2);$i++){
		for ($j=$i+1;$j<count($members2);$j++){
		if ($members2[$i]==$members2[$j]){
		for ($k=$j;$k<count($members2);$k++){
		$members2[$k]=$members2[$k+1];
		}
		}
		}
		} */
		$members=implode(',',$members2);
		if (sizeof($members2)>0)
		$where[] = "m.member_reg_no IN ($members)";
	}

	// report header

	if ($report_for == 0) {    //All member
		$where[] = "(( h.entry_type = '1' and h.reg_year_id='$last_reg_year_id') || ( h.entry_type = '2' and h.reg_year_id='$last_reg_year_id' )) ";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "( ( m.reg_date>='$date_from' and m.reg_date<='$date_to') || ( m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to' ))";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "( m.reg_date<='$date_to' || m.last_reg_date<='$date_to' )";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "( m.reg_date>='$date_from' || m.last_reg_date>='$date_from' )";
		}
	}
	else if ($report_for == 1) {    //new member
		$where[] = "h.entry_type = '1' and h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "m.reg_date>='$date_from' and m.reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "m.reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "m.reg_date>='$date_from'";
		}
	}
	else if ($report_for == 2) {    //renewed member
		$where[] = "h.entry_type = '2' and h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "m.last_reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "m.last_reg_date>='$date_from'";
		}
	}
	else if($report_for == 3 ){
		/* $where[]= "h.member_id not in (select member_id from mos_member_history"
		."\n where reg_year_id = $last_reg_year_id and (entry_type='1' or entry_type='2') ) "
		."\n and h.reg_year_id<$last_reg_year_id "
		;
		*/
		if (intval($no_of_years)>0){
			$from=($last_reg_year_id-$no_of_years)>=0?($last_reg_year_id-$no_of_years):0;
			$to=$last_reg_year_id;
			//$where[]=" m.last_reg_year_id>=$from and m.last_reg_year_id<$to";
			$where[]=" m.last_reg_year_id=$from and m.last_reg_year_id<$to";
		}
		else{
			$where[]= " m.last_reg_year_id<$last_reg_year_id ";
		}

		/*
		if ($date_from != '' && $date_to != '' ) {
		$where[] = "m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
		$where[] = "m.last_reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
		$where[] = "m.last_reg_date>='$date_from'";
		}
		*/
	}
	if (intval($order_by)==1){
		$orderBy="CAST(m.member_reg_no AS UNSIGNED) ASC";
	}
	else{
		$orderBy="m.firm_name ASC";
	}
	ReportTitle($pdf, 'bkmea',_CHAMBER_NAME_BKMEA, _ADDRESS_BKMEA, _CONTACT_NUMBER_BKMEA, _EMAIL_BKMEA, $TITLE, 'center',$reporting_period);

	$query = "select distinct(m.id) as id, m.firm_name as firm_name, m.tin as tin "
	."\n ,m.type_id as type_id , m.last_reg_year_id as last_reg_year_id,mt.name as type_name"
	."\n ,m.applicant_office_phone as office_phone,m.applicant_home_phone as home_phone"
	."\n ,m.office_phone as phone, md.name as designation,h.member_reg_no as member_reg_no"
	."\n ,m.applicant_title as title,m.applicant_name as name,mc.name as member_category "
	."\n ,m.applicant_last_name as last_name,m.applicant_address_street as street "
	."\n ,m.applicant_address_town_suburb as town, m.applicant_address_district as district"
	."\n ,m.applicant_address_division as division, m.applicant_address_country as country"
	."\n ,m.applicant_fax as fax,m.applicant_mobile as mobile,m.applicant_email as email"
	."\n ,m.applicant_web as web,YEAR(m.reg_date) as membership_year from #__member as m "
	."\n LEFT JOIN #__member_history AS h ON h.member_id = m.id"
	."\n LEFT JOIN #__designation AS md ON md.id = m.applicant_designation"
	."\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
	."\n LEFT JOIN #__member_category AS mc ON mc.id = m.member_category_id"
	."\n where m.is_delete =0"
	. ( count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
	."\n ORDER BY ".$orderBy
	;

	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	//$pdf->ezText($order_by,10);
	if($report_for>=0 && $report_for<3){
		$pdf->line( 6, 722, 575, 722 );
		$j=1;
		$data=array();
		//foreach($rows as $row){
		for($i=0; $i<count($rows); $i++){
			//$SLNO=$i;
			$col1="";$col2="";$col3="";
			$SLNO=$j;
			$row=$rows[$i];
			$applicant="";
			$firm_name="";
			$address="";
			$applicant="\n";
			$applicant.=$row->member_reg_no." - ".$row->member_category;
			$applicant.="/".$row->membership_year;
			$applicant.="\n<b>".$row->title."</b>";
			$applicant.=" "."<b>".$row->name."</b>";
			$applicant.=trim($row->last_name)!="" ?" "."<b>".$row->last_name."</b>":"";
			$applicant.=trim($row->designation)!="" ?"\n".$row->designation:"";
			$firm_name="\n<b>".$row->firm_name."</b>";
			$address="\n".$row->street;
			$address.= trim($row->town)!="" ?", ".$row->town:"";
			$address.= trim($row->district)!="" ?"\n".$row->district:"";
			$address.= trim($row->division)!="" ?", ".$row->division:"";
			$address.= trim($row->country)!="" ?", ".$row->country:"";
			$phone="";
			if (trim($row->office_phone)!=""){
				$phone.="\n\nPhone : ".$row->office_phone;
			}
			if (trim($row->home_phone)!="" && trim($phone)!=""){
				$phone.=", ".$row->home_phone;
			}
			else if (trim($row->home_phone)!="" && trim($phone)==""){
				$phone.="\n\nPhone : ".$row->home_phone;
			}
			if (trim($row->phone)!="" && trim($phone)!=""){
				$phone.=", ".$row->phone;
			}
			else if (trim($row->phone)!="" && trim($phone)==""){
				$phone.="\n\nPhone : ".$row->phone;
			}
			else if (trim($row->phone)=="" && trim($phone)==""){
				$phone.="\n\nPhone : ";
			}
			$address.=$phone;
			//$address.= $row->office_phone!=""?"\n\nPhone : ".$row->office_phone.", ":"\n\nPhone : ";
			//$address.= $row->home_phone!=""?", ".$row->home_phone:"";
			//$address.= $row->phone!=""?", ".$row->phone:"";
			$address.= $row->mobile!=""?"\nMobile : ".$row->mobile:"\nMobile : ";
			$address.= $row->fax!=""?"\nFax : ".$row->fax:"\nFax : ";
			$address.= $row->email!=""?"\nE-mail : ".$row->email:"\nE-mail : ";
			$address.= $row->web!=""?"\nWeb : ".$row->web:"\nWeb : ";
			$address.="\n";
			$col1=$applicant.$firm_name.$address;

			$i++;
			if($i<count($rows)){
				$SLNO=++$j;
				$row=$rows[$i];
				$applicant="";
				$firm_name="";
				$address="";
				$applicant="\n";
				$applicant.=$row->member_reg_no." - ".$row->member_category;
				$applicant.="/".$row->membership_year;
				$applicant.="\n<b>".$row->title."</b>";
				$applicant.=" "."<b>".$row->name."</b>";
				$applicant.=trim($row->last_name)!="" ?" "."<b>".$row->last_name."</b>":"";
				$applicant.=trim($row->designation)!="" ?"\n".$row->designation:"";
				$firm_name="\n<b>".$row->firm_name."</b>";
				$address="\n".$row->street;
				$address.= trim($row->town)!="" ?", ".$row->town:"";
				$address.= trim($row->district)!="" ?"\n".$row->district:"";
				$address.= trim($row->division)!="" ?", ".$row->division:"";
				$address.= trim($row->country)!="" ?", ".$row->country:"";
				$phone="";
				if (trim($row->office_phone)!=""){
					$phone.="\n\nPhone : ".$row->office_phone;
				}
				if (trim($row->home_phone)!="" && trim($phone)!=""){
					$phone.=", ".$row->home_phone;
				}
				else if (trim($row->home_phone)!="" && trim($phone)==""){
					$phone.="\n\nPhone : ".$row->home_phone;
				}
				if (trim($row->phone)!="" && trim($phone)!=""){
					$phone.=", ".$row->phone;
				}
				else if (trim($row->phone)!="" && trim($phone)==""){
					$phone.="\n\nPhone : ".$row->phone;
				}
				else if (trim($row->phone)=="" && trim($phone)==""){
					$phone.="\n\nPhone : ";
				}
				$address.=$phone;
				//$address.= $row->office_phone!=""?"\n\nPhone : ".$row->office_phone:"\n\nPhone : ";
				//$address.= $row->home_phone!=""?", ".$row->home_phone:"";
				//$address.= $row->phone!=""?", ".$row->phone:"";
				$address.= $row->mobile!=""?"\nMobile : ".$row->mobile:"\nMobile : ";
				$address.= $row->fax!=""?"\nFax : ".$row->fax:"\nFax : ";
				$address.= $row->email!=""?"\nE-mail : ".$row->email:"\nE-mail : ";
				$address.= $row->web!=""?"\nWeb : ".$row->web:"\nWeb : ";
				$address.="\n";
				$col2=$applicant.$firm_name.$address;
			}


			$i++;
			if($i<count($rows)){
				$SLNO=++$j;
				$row=$rows[$i];
				$applicant="";
				$firm_name="";
				$address="";
				$applicant="\n";
				$applicant.=$row->member_reg_no." - ".$row->member_category;
				$applicant.="/".$row->membership_year;
				$applicant.="\n".$row->title;
				$applicant.="\n<b>".$row->title."</b>";
				$applicant.=" "."<b>".$row->name."</b>";
				$applicant.=trim($row->last_name)!="" ?" "."<b>".$row->last_name."</b>":"";
				$applicant.=trim($row->designation)!="" ?"\n".$row->designation:"";
				$firm_name="\n<b>".$row->firm_name."</b>";
				$address="\n".$row->street;
				$address.= trim($row->town)!="" ?", ".$row->town:"";
				$address.= trim($row->district)!="" ?"\n".$row->district:"";
				$address.= trim($row->division)!="" ?", ".$row->division:"";
				$address.= trim($row->country)!="" ?", ".$row->country:"";
				$phone="";
				if (trim($row->office_phone)!=""){
					$phone.="\n\nPhone : ".$row->office_phone;
				}
				if (trim($row->home_phone)!="" && trim($phone)!=""){
					$phone.=", ".$row->home_phone;
				}
				else if (trim($row->home_phone)!="" && trim($phone)==""){
					$phone.="\n\nPhone : ".$row->home_phone;
				}
				if (trim($row->phone)!="" && trim($phone)!=""){
					$phone.=", ".$row->phone;
				}
				else if (trim($row->phone)!="" && trim($phone)==""){
					$phone.="\n\nPhone : ".$row->phone;
				}
				else if (trim($row->phone)=="" && trim($phone)==""){
					$phone.="\n\nPhone : ";
				}
				$address.=$phone;
				//$address.= $row->office_phone!=""?"\n\nPhone : ".$row->office_phone:"\n\nPhone : ";
				//$address.= $row->home_phone!=""?", ".$row->home_phone:"";
				//$address.= $row->phone!=""?", ".$row->phone:"";
				$address.= $row->mobile!=""?"\nMobile : ".$row->mobile:"\nMobile : ";
				$address.= $row->fax!=""?"\nFax : ".$row->fax:"\nFax : ";
				$address.= $row->email!=""?"\nE-mail : ".$row->email:"\nE-mail : ";
				$address.= $row->web!=""?"\nWeb : ".$row->web:"\nWeb : ";
				$address.="\n";
				$col3=$applicant.$firm_name.$address;
			}

			$arr=array( 'col1'=>stripslashes($col1)
			,'col2'=>stripslashes($col2)
			,'col3'=>stripslashes($col3)
			);
			array_push($data,$arr);
			$j++;
		}
	}

	if($report_for == 3 ){
		$i=1;
		$data=array();
		foreach($rows as $row){
			//get total dues for outstanding member
			if($report_for == 3 ){
				$sql=  "select count(reg_year_id) as no_year,sum(renewal_fee+renew_development_fee+safety_measure_renewal+other_renewal_fee) as renewal_fee from #__member_charge"
				."\n where member_type_id= ".$row->type_id
				."\n and reg_year_id>(select max(reg_year_id) from #__member_history"
				."\n where reg_year_id<$last_reg_year_id and member_id=".$row->id
				."\n ) and reg_year_id<=$last_reg_year_id "
				;

				$database->setQuery( $sql );
				$row1 = $database->loadObjectList();
				$renewal_fee=$row1[0]->renewal_fee;
				$grand_total = $grand_total + $renewal_fee;
			}
			//common for all
			$SLNO=$i;$col4="";
			$applicant=$row->name;
			$address=$row->street;
			$address.= trim($row->town)!="" ?", ".$row->town:"";
			$address.= trim($row->district)!="" ?", ".$row->district:"";
			$address.= trim($row->division)!="" ?", ".$row->division:"";
			$address.= trim($row->country)!="" ?", ".$row->country:"";
			$tin = $row->tin;
			$email=stripcslashes($row->email);
			$email=$row->emaill!=""?"\n".decodeHTML($email):"";

			$col1= strip_tags( $row->firm_name.$email."\n".$address );
			$col1= decodeHTML( $col1 );
			$contact= $row->mobile == "" ? "" :"Mobile: ".$row->mobile ;
			$contact.= $contact == "" ? "" : "\n";
			$contact.= $row->phone == "" ? "" :"Phone: ".$row->phone ;
			$contact.= $contact == "" ? "" : "\n";
			$contact.= $row->fax == "" ? "" :"Fax: ".$row->fax ;
			$contact= decodeHTML( $contact );
			$col4=$row->title;
			$col4.=" ".$row->name;
			$col4.=$row->last_name!=""?" ".$row->name:"";
			$col4.=$row->designation!=""?"\n".$row->designation:"";
			$col4= decodeHTML($col4 );
			$member_reg_no=$row->member_reg_no;
			$type_name=$row->type_name;



			if($report_for>=0 && $report_for<3){    //prepare array for New and Renewal Member
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'member_reg_no'=>stripslashes($member_reg_no)
				,'firm_name'=>stripslashes($col1)
				,'type_name'=>stripslashes($type_name)
				//,'email'=>$email
				,'contact'=>stripslashes($contact)
				,'applicant'=>stripslashes($col4)
				);
			}
			else{                                  //prepare array for outstanding Member
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'member_reg_no'=>stripslashes($member_reg_no)
				,'firm_name'=>stripslashes($col1)
				,'membership_year'=>stripslashes($row->membership_year)
				//,'tin'=>stripslashes($tin)
				,'type_name'=>stripslashes($type_name)
				,'contact'=>stripslashes($contact)
				,'applicant'=>stripslashes($col4)
				,'no_of_years'=>$row1[0]->no_year
				,'dues'=>$renewal_fee
				);
			}

			array_push($data,$arr);

			$i++;
		}
	}
	if($report_for>=0 && $report_for<3){
		//prepare col title for new and renewal member
		$cols = array( 'col1'=>'',
		'col2'=>'',
		'col3'=>''
		);

		$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>0,'shaded'=> 0, 'lineCol'=>array(1,1,1), 'xPos'=>580,'xOrientation'=>'left','width'=>570,
		'cols'=>array(
		'col1'=>array('justification'=>'left','width'=>190),
		'col2'=>array('justification'=>'left','width'=>190),
		'col3'=>array('justification'=>'left','width'=>190))
		), 9);
	}
	else{
		//prepare col title for outstanding member
		$cols = array('SLNO'=>"Sl.",
		'member_reg_no'=>'Membership No.',
		'firm_name'=>'Firm Name',
		'membership_year'=>'Reg. Year',
		'type_name'=>'Member Type',
		//'email'=>'E-mail Address',
		'contact'=>'Mobile, Phone, Fax',
		'applicant'=>'Applicant Name',
		'no_of_years'=>'# of Years',
		'dues'=>'Dues (Tk.)'

		);
		$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.4,0.4,0.4),'xPos'=>580,'xOrientation'=>'left','width'=>670,
		'cols'=>array(
		'SLNO'=>array('justification'=>'left','width'=>20),
		'member_reg_no'=>array('justification'=>'left','width'=>55),
		'firm_name'=>array('justification'=>'left','width'=>100),
		'membership_year'=>array('justification'=>'left','width'=>40),
		'type_name'=>array('justification'=>'left','width'=>70),
		//'tin'=>array('justification'=>'left','width'=>80),
		'contact'=>array('justification'=>'left','width'=>95),
		'applicant'=>array('justification'=>'left','width'=>100),
		'no_of_years'=>array('justification'=>'left','width'=>32),
		'dues'=>array('justification'=>'right','width'=>50),
		)), 8);
		$pdf->ezText( "", 3 );
		$data1=array();

		$cols1 = array('SLNO'=>"",
		'member_reg_no'=>'',
		'firm_name'=>'',
		'type_name'=>'',
		//'email'=>'E-mail Address',
		'contact'=>'',
		'applicant'=>'',
		'applicant'=>'Total Dues (Tk.) :',
		'dues'=>$grand_total
		);
		$pdf->ezTable($data1,$cols1,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(1,1,1),'xPos'=>580,'xOrientation'=>'left','width'=>670,
		'cols'=>array(
		'SLNO'=>array('justification'=>'left','width'=>20),
		'member_reg_no'=>array('justification'=>'left','width'=>55),
		'firm_name'=>array('justification'=>'left','width'=>100),
		'membership_year'=>array('justification'=>'left','width'=>40),
		'type_name'=>array('justification'=>'left','width'=>70),
		//'tin'=>array('justification'=>'left','width'=>80),
		'contact'=>array('justification'=>'left','width'=>100),
		'applicant'=>array('justification'=>'right','width'=>100),
		'no_of_years'=>array('justification'=>'right','width'=>32),
		'dues'=>array('justification'=>'right','width'=>50),
		)), 8);

		$pdf->ezText("In Words : ".numtoword($grand_total)."Taka Only",10);
		//$pdf->ezText( "", 10 );
		// $pdf->ezText( "Total Dues: Tk. ".$grand_total, 10 );

	}


	//end of logic

	// footer
	//$pdf->ezText($query,10);
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}

function AllMemberReportBkmea ( ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	//$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//this is the start of the logic to get the search result
	$year = date('Y');
	$type_id     = intval( mosGetParam( $_REQUEST, 'type_id' ));
	$membership_no     =  mosGetParam( $_REQUEST, 'membership_no' );
	$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));
	$last_reg_year_id   = trim( mosGetParam( $_REQUEST, 'last_reg_year_id' ));
	$category_id   = trim( mosGetParam( $_REQUEST, 'category_id' ));
	$order_by=intval( mosGetParam( $_REQUEST, 'order_by' ));


	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);

	$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
	$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);

	$where = array();

	if ($category_id>0)
	{
		$where[]="m.member_category_id='$category_id'";
	}

	if ($type_id > 0) {
		$where[] = "m.type_id='$type_id'";
		$type_name = $database->getMemberTypeName($type_id);
		$TITLE="All ".$type_name." List";
	}
	else {

		$TITLE="List of All Member";
	}

	if ($membership_no!=""){
		$members1=explode(",",$membership_no);
		$members2=array();

		for ($i=0;$i<count($members1);$i++){
			if(trim($members1)!=""){
				if (strpos($members1[$i],'-',0)){
					$temp=explode("-",$members1[$i]);
					if ($temp[0]>$temp[1]){
						$t=$temp[0];
						$temp[0]=$temp[1];
						$temp[1]=$t;
					}
					for ($j=intval($temp[0]);$j<=intval($temp[1]);$j++){
						if (is_numeric($j))
						array_push($members2,$j);
					}
				}
				else{
					if (is_numeric($members1[$i]))
					array_push($members2,$members1[$i]);
				}
			}
		}


		$members=implode(',',$members2);
		if (sizeof($members2)>0)
		$where[] = "m.member_reg_no IN ($members)";
	}

	// report header

	if ($report_for == 0) {    //All member
		$where[] = " ( h.entry_type = '1' OR  h.entry_type = '2' ) ";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "( ( m.reg_date>='$date_from' and m.reg_date<='$date_to') || ( m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to' ))";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "( m.reg_date<='$date_to' || m.last_reg_date<='$date_to' )";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "( m.reg_date>='$date_from' || m.last_reg_date>='$date_from' )";
		}
	}
	else if ($report_for == 1) {    //new member
		$where[] = "h.entry_type = '1'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "m.reg_date>='$date_from' and m.reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "m.reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "m.reg_date>='$date_from'";
		}
	}
	else if ($report_for == 2) {    //renewed member
		$where[] = "h.entry_type = '2' ";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "m.last_reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "m.last_reg_date>='$date_from'";
		}
	}
	if (intval($order_by)==1){
		$orderBy="CAST(m.member_reg_no AS UNSIGNED) ASC";
	}
	else{
		$orderBy="m.firm_name ASC";
	}

	ReportTitle($pdf, 'bkmea',_CHAMBER_NAME_BKMEA, _ADDRESS_BKMEA, _CONTACT_NUMBER_BKMEA, _EMAIL_BKMEA, $TITLE, 'center',$reporting_period);

	$query = "select distinct(m.id) as id, m.firm_name as firm_name, m.tin as tin "
	."\n ,m.type_id as type_id , m.last_reg_year_id as last_reg_year_id,mt.name as type_name"
	."\n ,m.applicant_office_phone as office_phone,m.applicant_home_phone as home_phone"
	."\n ,m.office_phone as phone, md.name as designation,h.member_reg_no as member_reg_no"
	."\n ,m.applicant_title as title,m.applicant_name as name,mc.name as member_category "
	."\n ,m.applicant_last_name as last_name,m.applicant_address_street as street "
	."\n ,m.applicant_address_town_suburb as town, m.applicant_address_district as district"
	."\n ,m.applicant_address_division as division, m.applicant_address_country as country"
	."\n ,m.applicant_fax as fax,m.applicant_mobile as mobile,m.applicant_email as email"
	."\n ,m.applicant_web as web,YEAR(m.reg_date) as membership_year from #__member as m "
	."\n LEFT JOIN #__member_history AS h ON h.member_id = m.id"
	."\n LEFT JOIN #__designation AS md ON md.id = m.applicant_designation"
	."\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
	."\n LEFT JOIN #__member_category AS mc ON mc.id = m.member_category_id"
	."\n where m.is_delete =0"
	. ( count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
	//."\n ORDER BY m.firm_name "
	."\n ORDER BY ".$orderBy
	;

	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	//$pdf->ezText($query,10);
	$pdf->line( 6, 722, 575, 722 );
	$j=1;
	$data=array();
	//foreach($rows as $row){
	for($i=0; $i<count($rows); $i++){
		//$SLNO=$i;
		$col1="";$col2="";$col3="";
		$SLNO=$j;
		$row=$rows[$i];
		$applicant="";
		$firm_name="";
		$address="";
		$firm_name="\n<b>".$row->firm_name."</b>";
		$applicant="\n";
		$applicant.=$row->member_reg_no." - ".$row->member_category;
		$applicant.="/".$row->membership_year;
		$applicant.=$firm_name;
		$applicant.="\n<b>".$row->title."</b>";
		$applicant.=" "."<b>".$row->name."</b>";
		$applicant.=trim($row->last_name)!="" ?" "."<b>".$row->last_name."</b>":"";
		$applicant.=trim($row->designation)!="" ?"\n".$row->designation:"";
		//$firm_name="\n".$row->firm_name;
		$address="\n".$row->street;
		$address.= trim($row->town)!="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?"\n".$row->district:"";
		$address.= trim($row->division)!="" ?", ".$row->division:"";
		$address.= trim($row->country)!="" ?", ".$row->country:"";
		$phone="";
		if (trim($row->office_phone)!=""){
			$phone.="\n\nPhone : ".$row->office_phone;
		}
		if (trim($row->home_phone)!="" && trim($phone)!=""){
			$phone.=", ".$row->home_phone;
		}
		else if (trim($row->home_phone)!="" && trim($phone)==""){
			$phone.="\n\nPhone : ".$row->home_phone;
		}
		if (trim($row->phone)!="" && trim($phone)!=""){
			$phone.=", ".$row->phone;
		}
		else if (trim($row->phone)!="" && trim($phone)==""){
			$phone.="\n\nPhone : ".$row->phone;
		}
		else if (trim($row->phone)=="" && trim($phone)==""){
			$phone.="\n\nPhone : ";
		}
		$address.=$phone;
		//$address.= $row->office_phone!=""?"\n\nPhone : ".$row->office_phone:"\n\nPhone : ";
		//$address.= $row->home_phone!=""?", ".$row->home_phone:"";
		//$address.= $row->phone!=""?", ".$row->phone:"";
		$address.= $row->mobile!=""?"\nMobile : ".$row->mobile:"\nMobile : ";
		$address.= $row->fax!=""?"\nFax : ".$row->fax:"\nFax : ";
		$address.= $row->email!=""?"\nE-mail : ".$row->email:"\nE-mail : ";
		$address.= $row->web!=""?"\nWeb : ".$row->web:"\nWeb : ";
		//$address.="\n";
		$col1=$applicant.$address;

		$i++;
		if($i<count($rows)){
			$SLNO=++$j;
			$row=$rows[$i];
			$applicant="";
			$firm_name="";
			$address="";
			$firm_name="\n<b>".$row->firm_name."</b>";
			$applicant="\n";
			$applicant.=$row->member_reg_no." - ".$row->member_category;
			$applicant.="/".$row->membership_year;
			$applicant.=$firm_name;
			$applicant.="\n<b>".$row->title."</b>";
			$applicant.=" "."<b>".$row->name."</b>";
			$applicant.=trim($row->last_name)!="" ?" "."<b>".$row->last_name."</b>":"";
			$applicant.=trim($row->designation)!="" ?"\n".$row->designation:"";
			//$firm_name="\n".$row->firm_name;
			$address="\n".$row->street;
			$address.= trim($row->town)!="" ?", ".$row->town:"";
			$address.= trim($row->district)!="" ?"\n".$row->district:"";
			$address.= trim($row->division)!="" ?", ".$row->division:"";
			$address.= trim($row->country)!="" ?", ".$row->country:"";
			$phone="";
			if (trim($row->office_phone)!=""){
				$phone.="\n\nPhone : ".$row->office_phone;
			}
			if (trim($row->home_phone)!="" && trim($phone)!=""){
				$phone.=", ".$row->home_phone;
			}
			else if (trim($row->home_phone)!="" && trim($phone)==""){
				$phone.="\n\nPhone : ".$row->home_phone;
			}
			if (trim($row->phone)!="" && trim($phone)!=""){
				$phone.=", ".$row->phone;
			}
			else if (trim($row->phone)!="" && trim($phone)==""){
				$phone.="\n\nPhone : ".$row->phone;
			}
			else if (trim($row->phone)=="" && trim($phone)==""){
				$phone.="\n\nPhone : ";
			}
			$address.=$phone;
			//$address.= $row->office_phone!=""?"\n\nPhone : ".$row->office_phone:"\n\nPhone : ";
			//$address.= $row->home_phone!=""?", ".$row->home_phone:"";
			//$address.= $row->phone!=""?", ".$row->phone:"";
			$address.= $row->mobile!=""?"\nMobile : ".$row->mobile:"\nMobile : ";
			$address.= $row->fax!=""?"\nFax : ".$row->fax:"\nFax : ";
			$address.= $row->email!=""?"\nE-mail : ".$row->email:"\nE-mail : ";
			$address.= $row->web!=""?"\nWeb : ".$row->web:"\nWeb : ";
			//$address.="\n";
			$col2=$applicant.$address;
		}


		$i++;
		if($i<count($rows)){
			$SLNO=++$j;
			$row=$rows[$i];
			$applicant="";
			$firm_name="";
			$address="";
			$firm_name="\n<b>".$row->firm_name."</b>";
			$applicant="\n";
			$applicant.=$row->member_reg_no." - ".$row->member_category;
			$applicant.="/".$row->membership_year;
			$applicant.=$firm_name;
			$applicant.="\n<b>".$row->title."</b>";
			$applicant.=" "."<b>".$row->name."</b>";
			$applicant.=trim($row->last_name)!="" ?" "."<b>".$row->last_name."</b>":"";
			$applicant.=trim($row->designation)!="" ?"\n".$row->designation:"";
			//$firm_name="\n".$row->firm_name;
			$address="\n".$row->street;
			$address.= trim($row->town)!="" ?", ".$row->town:"";
			$address.= trim($row->district)!="" ?"\n".$row->district:"";
			$address.= trim($row->division)!="" ?", ".$row->division:"";
			$address.= trim($row->country)!="" ?", ".$row->country:"";
			$phone="";
			if (trim($row->office_phone)!=""){
				$phone.="\n\nPhone : ".$row->office_phone;
			}
			if (trim($row->home_phone)!="" && trim($phone)!=""){
				$phone.=", ".$row->home_phone;
			}
			else if (trim($row->home_phone)!="" && trim($phone)==""){
				$phone.="\n\nPhone : ".$row->home_phone;
			}
			if (trim($row->phone)!="" && trim($phone)!=""){
				$phone.=", ".$row->phone;
			}
			else if (trim($row->phone)!="" && trim($phone)==""){
				$phone.="\n\nPhone : ".$row->phone;
			}
			else if (trim($row->phone)=="" && trim($phone)==""){
				$phone.="\n\nPhone : ";
			}
			$address.=$phone;

			//$address.= $row->office_phone!=""?"\n\nPhone : ".$row->office_phone:"\n\nPhone : ";
			//$address.= $row->home_phone!=""?", ".$row->home_phone:"";
			//$address.= $row->phone!=""?", ".$row->phone:"";
			$address.= $row->mobile!=""?"\nMobile : ".$row->mobile:"\nMobile : ";
			$address.= $row->fax!=""?"\nFax : ".$row->fax:"\nFax : ";
			$address.= $row->email!=""?"\nE-mail : ".$row->email:"\nE-mail : ";
			$address.= $row->web!=""?"\nWeb : ".$row->web:"\nWeb : ";
			//$address.="\n";
			$col3=$applicant.$address;
		}

		$arr=array( 'col1'=>stripslashes($col1)
		,'col2'=>stripslashes($col2)
		,'col3'=>stripslashes($col3)
		);
		array_push($data,$arr);
		$j++;
	}


	//prepare col title for new and renewal member
	$cols = array( 'col1'=>'',
	'col2'=>'',
	'col3'=>''
	);

	$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>0,'shaded'=> 0, 'lineCol'=>array(1,1,1), 'xPos'=>580,'xOrientation'=>'left','width'=>570,
	'cols'=>array(
	'col1'=>array('justification'=>'left','width'=>190),
	'col2'=>array('justification'=>'left','width'=>190),
	'col3'=>array('justification'=>'left','width'=>190))
	), 9);




	//end of logic

	// footer
	//$pdf->ezText($query,10);
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}


function TopMemberReportBkmea ( ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	//$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//this is the start of the logic to get the search result
	$order_by=intval( mosGetParam( $_REQUEST, 'order_by' ));
	$fromYear=intval( mosGetParam( $_REQUEST, 'fromYear' ));

	$where = array();


	if (intval($order_by)==1){
		$orderBy="m.investment DESC";
		$subTitle = " Top Investors ";
	}
	else{
		$orderBy="m.employee_total desc";
		$subTitle = "Top Employment";
	}

	$query = "select distinct(m.id) as id, m.firm_name as firm_name,YEAR(m.reg_date) as membership_year,m.investment,m.employee_total "
	."\n from mos_member as m "
	."\n where m.is_delete =0 and YEAR(m.reg_date)='{$fromYear}' "
	."\n ORDER BY ".$orderBy
	;

	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	//	$pdf->ezText($query,10);

	$data=array();
	$dataH=array();
	foreach ($rows as $key => $value) {
		$row = &$rows[$key];
		$arr=array( 'SLNO'=>stripslashes($key+1)
		,'firm_name'=>stripslashes($row->firm_name)
		,'investment'=>stripslashes($row->investment)
		,'employee_total'=>stripslashes($row->employee_total)
		);

		array_push($data,$arr);
	}

	/*$arrH=array( 'col1'=>stripslashes(' Year '.$rows[0]->membership_year));
	array_push($dataH,$arrH);

	$cols = array( 'col1'=>'');

	$pdf->ezTable($dataH,$cols,'',array('showLines'=>2, 'showHeadings'=>0,'shaded'=> 0, 'lineCol'=>array(1,1,1), 'xPos'=>580,'xOrientation'=>'left','width'=>570,
	'cols'=>array(
	'col1'=>array('justification'=>'center','width'=>570)
	)), 9);*/



	$TITLE="List of ".$subTitle. " In The Year ".$rows[0]->membership_year .".";

	ReportTitle($pdf, 'bkmea',_CHAMBER_NAME_BKMEA, _ADDRESS_BKMEA, _CONTACT_NUMBER_BKMEA, _EMAIL_BKMEA, $TITLE, 'center',$reporting_period);

	$pdf->line( 6, 722, 575, 722 );

			$pdf->ezText('',10);
	//prepare col title for outstanding member
	$cols = array('SLNO'=>"Sl.",
	'firm_name'=>'Firm Name',
	'investment'=>'Total Investment',
	'employee_total'=>'Total Employment'
	);

	$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.4,0.4,0.4),'xPos'=>'center','xOrientation'=>'center','width'=>570,
	'cols'=>array(
	'SLNO'=>array('justification'=>'left','width'=>50),
	'firm_name'=>array('justification'=>'left','width'=>300),
	'investment'=>array('justification'=>'right','width'=>100),
	'employee_total'=>array('justification'=>'left','width'=>100),
	)), 9);

	// footer
	//$pdf->ezText($query,10);
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}


//report :: for new and renewed member of CCCI

function MemberReportCcci ( $FOR ){
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//this is the start of the logic to get the search result
	$year = date('Y');
	$type_id     = intval( mosGetParam( $_REQUEST, 'type_id' ));
	$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));
	$last_reg_year_id   = trim( mosGetParam( $_REQUEST, 'last_reg_year_id' ));
	$membership_no     =  mosGetParam( $_REQUEST, 'membership_no' );
	$is_outside     = intval( mosGetParam( $_REQUEST, 'is_outside' ));
	$location     = intval( mosGetParam( $_REQUEST, 'location' ));

	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);

	$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
	$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);



	//Header
	$TITLE="List of all Members for the ";
	$NAME=(strtolower($FOR)=='ccci')?_CHAMBER_NAME_CCCI:_CHAMBER_NAME_SCCI;
	$ADDRESS=(strtolower($FOR)=='ccci')?_ADDRESS_CCCI:_ADDRESS_SCCI;
	$CONTACT=(strtolower($FOR)=='ccci')?_CONTACT_NUMBER_CCCI:_CONTACT_NUMBER_SCCI;
	$EMAIL=(strtolower($FOR)=='ccci')?_EMAIL_CCCI:_EMAIL_SCCI;


	$where = array();

	if ($type_id > 0  ) {
		$where[] = "m.type_id='$type_id'";
		$type_name = $database->getMemberTypeName($type_id);
		$TITLE=$type_name." List";
	}
	else {
		$TITLE="List of all Members for the ";
		//$where[] = "(m.type_id='3' || m.type_id='4')";
	}
	$sql="select name from #__member_reg_year where id='$last_reg_year_id'";
	$database->setQuery($sql);
	$TITLE.=$database->loadResult();

	if ($membership_no!=""){
		$members1=explode(",",$membership_no);
		$members2=array();

		for ($i=0;$i<count($members1);$i++){
			if(trim($members1)!=""){
				if (strpos($members1[$i],'-',0)){
					$temp=explode("-",$members1[$i]);
					if ($temp[0]>$temp[1]){
						$t=$temp[0];
						$temp[0]=$temp[1];
						$temp[1]=$t;
					}
					for ($j=intval($temp[0]);$j<=intval($temp[1]);$j++){
						if (is_numeric($j))
						array_push($members2,$j);
					}
				}
				else{
					if (is_numeric($members1[$i]))
					array_push($members2,$members1[$i]);
				}
			}
		}

		/*  for ($i=0;$i<count($members2);$i++){
		for ($j=$i+1;$j<count($members2);$j++){
		if ($members2[$i]==$members2[$j]){
		for ($k=$j;$k<count($members2);$k++){
		$members2[$k]=$members2[$k+1];
		}
		}
		}
		} */
		$members=implode(',',$members2);
		if (sizeof($members2)>0)
		$where[] = "m.member_reg_no IN ($members)";
	}

	if (intval($is_outside) > -1) {
		$where[] = "m.is_outside='$is_outside'";
	}
	if (intval($location) >0) {
		$where[] = "m.location='$location'";
	}

	$i=0;
	if ($member_reg_no_from > 0) {
		$i++;
		$membership_range="Membership Range : From ".$member_reg_no_from;
		$where[] = "h.member_reg_no>='$member_reg_no_from'";
	}
	if ($member_reg_no_to > 0) {
		$i++;
		$membership_range="Membership Range : Upto ".$member_reg_no_to;
		$where[] = "h.member_reg_no<='$member_reg_no_to'";
	}
	if ($i==2){
		$membership_range="Membership Range : From ".$member_reg_no_from." Upto ".$member_reg_no_to;
	}

	if ($report_for == 0) {    //All member
		$where[] = "h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "( ( h.reg_date>='$date_from' and h.reg_date<='$date_to' and h.entry_type = 1 ) || ( h.reg_date>='$date_from' and h.reg_date<='$date_to' and h.entry_type = 2 ))";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "( h.reg_date<='$date_to' || h.reg_date<='$date_to' )";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "( h.reg_date>='$date_from' || h.reg_date>='$date_from' )";
		}
	}
	else if ($report_for == 1) {    //new member
		$where[] = "h.entry_type = '1' and h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "h.reg_date>='$date_from' and h.reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "h.reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "h.reg_date>='$date_from'";
		}
	}
	else if ($report_for == 2) {    //renewed member
		$where[] = "h.entry_type = '2' and h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "h.reg_date>='$date_from' and h.reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "h.reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "h.reg_date>='$date_from'";
		}
	}
	else if($report_for == 3 ){
		$where[]= "\n h.reg_year_id = (select max(id) from #__member_reg_year where id<'$last_reg_year_id' )"
		."\n and member_id not in (select member_id from #__member_history"
		."\n where reg_year_id = '$last_reg_year_id')"
		."\n and (h.entry_type='1' or h.entry_type='2')"
		;
		/*
		if ($date_from != '' && $date_to != '' ) {
		$where[] = "m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
		$where[] = "m.last_reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
		$where[] = "m.last_reg_date>='$date_from'";
		}   */
	}

	ReportTitle($pdf, $FOR, $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center',$reporting_period,$membership_range);

	$query = "select distinct(m.id) as id, m.firm_name as firm_name, m.tin as tin "
	."\n ,m.type_id as type_id , h.reg_year_id as last_reg_year_id"
	."\n ,c.renewal_fee as renewal_fee,mt.name as member_type "
	."\n ,m.firm_phone as phone, pdes.name as pnomdesignation"
	."\n ,m.principal_nominee_title as pnt, m.principal_nominee_name as pnom, m.principal_nominee_last_name as pnln"
	."\n ,m.alt_nominee_title as ant, m.alt_nominee_name as altname, m.alt_nominee_last_name as anln"
	."\n ,representative_title as representative_title, rdes.name as representativdesignation , m.representative_name as representative"
	."\n ,representative_last_name as representative_last_name, ades.name as altnomdesignation"
	."\n , m.firm_reg_address_street as street"
	."\n ,m.firm_reg_address_town_suburb as town, m.firm_reg_address_district as district"
	."\n ,m.firm_reg_address_division as division, m.firm_reg_address_country as country"
	."\n ,m.firm_fax as fax from #__member as m "
	."\n left join #__member_type as mt on m.type_id=mt.id"
	."\n LEFT JOIN #__member_history AS h ON h.member_id = m.id"
	."\n left join #__designation as pdes on pdes.id=m.principal_nominee_designation"
	."\n left join #__designation as ades on ades.id=m.alt_nominee_designation"
	."\n left join #__designation as rdes on rdes.id=m.representative_designation"
	."\n LEFT JOIN #__member_charge AS c ON c.member_type_id = m.type_id and c.reg_year_id='$last_reg_year_id'"
	."\n where m.is_delete =0 "
	. ( count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
	//."\n ORDER BY h.member_reg_no, mt.id "
	. "\n ORDER BY m.firm_name"
	;
	//$pdf->ezText($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();


	$i=1;
	$data=array();
	$grand_total=0;
	foreach($rows as $row){

		$renewal_fee=$row->renewal_fee;
		$grand_total=$grand_total+$renewal_fee;
		//common for all
		$SLNO=$i;
		$applicant=$row->name;
		$address=$row->street;
		$address.= trim($row->town)!="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?", ".$row->district:"";
		$address.= trim($row->division)!="" ?", ".$row->division:"";
		$address.= trim($row->country)!="" ?", ".$row->country:"";
		$tin = $row->tin;


		$col1= strip_tags( $row->firm_name."\n".$address );
		$col1= decodeHTML( $col1 );
		$contact= $row->phone == "" ? "" :"Tel: ".$row->phone ;
		$contact.= $contact == "" ? "" : "\n" ;
		$contact.= $row->fax == "" ? "" :"Fax: ".$row->fax ;
		$contact= decodeHTML( $contact );

		if($row->type_id==3 || $row->type_id==4 )
		{
			$col4= $row->pnt." ".$row->pnom." ".$row->pnln;

			$col4.= $col4 == "" ? "" : "\n" ;

			$col4.= $row->pnomdesignation == "" ? "" :$row->pnomdesignation ;
			$col4.= $col4 == "" ? "" : "\n" ;
			$col4.= $row->altname == "" ? "" :$row->ant." ".$row->altname." ".$row->anln ;

			$col4.= $col4 == "" ? "" : "\n" ;
			$col4.= $row->altnomdesignation == "" ? "" :$row->altnomdesignation ;
		}
		else
		{
			$col4= stripslashes($row->representative_title)." ".stripslashes($row->representative)." ".stripslashes($row->representative_last_name);

			$col4.= $col4 == "" ? "" : "\n" ;

			$col4.= $row->representativdesignation == "" ? "" :$row->representativdesignation ;


		}

		$col4= decodeHTML( $col4 );
		$member_type=$row->member_type;
		$member_type= decodeHTML($member_type);

		if($report_for>=0 && $report_for<3){    //prepare array for New and Renewal Member
			if ($type_id==0)// when member type is all
			{
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'firm_name'=>stripslashes($col1)
				,'member_type'=> stripcslashes($member_type)
				,'tin'=>stripslashes($tin)
				,'contact'=>stripslashes($contact)
				,'applicant'=>stripslashes($col4)
				);
			}
			else
			{
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'firm_name'=>stripslashes($col1)
				,'tin'=>stripslashes($tin)
				,'contact'=>stripslashes($contact)
				,'applicant'=>stripslashes($col4)
				);
			}
		}
		else{ //prepare array for outstanding Member
			if($type_id==0) // when member type is all
			{
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'firm_name'=>stripslashes($col1)
				,'member_type'=> stripcslashes($member_type)
				,'tin'=>stripslashes($tin)
				,'contact'=>stripslashes($contact)
				,'applicant'=>stripslashes($col4)
				,'dues'=>$renewal_fee
				);


			}
			else
			{
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'firm_name'=>stripslashes($col1)
				,'tin'=>stripslashes($tin)
				,'contact'=>stripslashes($contact)
				,'applicant'=>stripslashes($col4)
				,'dues'=>$renewal_fee
				);
			}
		}

		array_push($data,$arr);

		$i++;
	}
	if($report_for>=0 && $report_for<3){
		//prepare col title for new and renewal member
		if ($type_id==0)  // all type of member
		{
			$cols = array('SLNO'=>"Sl.",'firm_name'=>'Name of the Firm',
			'member_type'=>'Member Type','tin'=>'TIN Number',
			'contact'=>'Tel. & Fax No.',
			'applicant'=>'Names of the Nominees'
			);

			$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'xPos'=>580,'xOrientation'=>'left','width'=>570,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>42),
			'firm_name'=>array('justification'=>'left','width'=>150),
			'member_type'=>array('justification'=>'left','width'=>50),
			'tin'=>array('justification'=>'left','width'=>80),
			'contact'=>array('justification'=>'left','width'=>115),
			'applicant'=>array('justification'=>'left','width'=>120),
			)), 9);
		}
		else
		{

			$cols = array('SLNO'=>"Sl.",'firm_name'=>'Name of the Firm',
			'tin'=>'TIN Number',
			'contact'=>'Tel. & Fax No.',
			'applicant'=>'Name of the Nomonees'
			);
			//generate table for new and renewal member

			$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0,'xPos'=>580,'xOrientation'=>'left','width'=>570,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>40),
			'firm_name'=>array('justification'=>'left','width'=>170),
			'tin'=>array('justification'=>'left','width'=>80),
			'contact'=>array('justification'=>'left','width'=>125),
			'applicant'=>array('justification'=>'left','width'=>145),
			)), 9);
		}

	}
	else{
		//prepare col title for outstanding member
		if($type_id==0) //when member type is all
		{
			$cols = array('SLNO'=>"Sl.",'firm_name'=>'Name of Firm',
			'member_type'=>'Member Type','tin'=>'TIN Number',
			'contact'=>'Tel. & Fax No.',
			'applicant'=>'Name of the Nomonees',
			'dues'=>'Dues (Tk.)'
			);

			$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0,'xPos'=>580,'xOrientation'=>'left','width'=>570,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>40),
			'firm_name'=>array('justification'=>'left','width'=>140),
			'member_type'=>array('justification'=>'left','width'=>50),
			'tin'=>array('justification'=>'left','width'=>50),
			'contact'=>array('justification'=>'left','width'=>105),
			'applicant'=>array('justification'=>'left','width'=>125),
			'dues'=>array('justification'=>'right','width'=>50),
			)), 9);


		}

		else
		{
			$cols = array('SLNO'=>"Sl.",'firm_name'=>'Name of Firm',
			'tin'=>'TIN Number',
			'contact'=>'Tel. & Fax No.',
			'applicant'=>'Name of the Nomonees',
			'dues'=>'Dues (Tk.)'
			);
			$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0,'xPos'=>580,'xOrientation'=>'left','width'=>570,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>40),
			'firm_name'=>array('justification'=>'left','width'=>170),
			'tin'=>array('justification'=>'left','width'=>50),
			'contact'=>array('justification'=>'left','width'=>105),
			'applicant'=>array('justification'=>'left','width'=>145),
			'dues'=>array('justification'=>'right','width'=>50),
			)), 9);

		}

		//generate table for outstanding member

		$pdf->ezText( "", 3 );
		if ($grand_total>0){
			$data1=array();

			$cols1 = array('SLNO'=>"",
			'member_reg_no'=>'',
			'firm_name'=>'',
			'type_name'=>'',
			//'email'=>'E-mail Address',
			'contact'=>'',
			'applicant'=>'Total Dues (Tk.) :',
			'dues'=>$grand_total
			);
			$pdf->ezTable($data1,$cols1,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(1,1,1),'xPos'=>580,'xOrientation'=>'left','width'=>570,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>25),
			'member_reg_no'=>array('justification'=>'left','width'=>77),
			'firm_name'=>array('justification'=>'left','width'=>133),
			'type_name'=>array('justification'=>'left','width'=>85),
			//'tin'=>array('justification'=>'left','width'=>80),
			'contact'=>array('justification'=>'left','width'=>100),
			'applicant'=>array('justification'=>'right','width'=>100),
			'dues'=>array('justification'=>'right','width'=>50),
			)), 9);

			$pdf->ezText("In Words : ".numtoword($grand_total)."Taka Only",10);

			//$pdf->ezText( "", 10 );
			//$pdf->ezText( "Total Dues: Tk. ".$grand_total, 10 );
		}

	}


	//end of logic

	// footer
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}


/*
*  to get the pdf file
*  about member voter list for SCCI and CCCI
*/


function DeligateMemberReport ( $FOR ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//this is the start of the logic to get the search result
	$year = date('Y');
	$type_id     = intval( mosGetParam( $_REQUEST, 'type_id' ));
	$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));
	$last_reg_year_id   = trim( mosGetParam( $_REQUEST, 'last_reg_year_id' ));

	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);

	//Header
	$TITLE="All Member List";
	$NAME=(strtolower($FOR)=='ccci')?_CHAMBER_NAME_CCCI:_CHAMBER_NAME_SCCI;
	$ADDRESS=(strtolower($FOR)=='ccci')?_ADDRESS_CCCI:_ADDRESS_SCCI;
	$CONTACT=(strtolower($FOR)=='ccci')?_CONTACT_NUMBER_CCCI:_CONTACT_NUMBER_SCCI;
	$EMAIL=(strtolower($FOR)=='ccci')?_EMAIL_CCCI:_EMAIL_SCCI;


	$where = array();

	if ($type_id > 0 ) {
		$where[] = "m.type_id='$type_id'";
		$type_name = $database->getMemberTypeName($type_id);
		$TITLE=$type_name." List";
	}
	else {
		$TITLE="List Of ALL Member";
		$where[] = "(m.type_id='5')";
	}


	ReportTitle($pdf, $FOR, $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center');

	if ($report_for == 0) {    //All member
		$where[] = "h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$where[] = "( ( h.reg_date>='$date_from' and h.reg_date<='$date_to' and h.entry_type = 1 ) || ( h.reg_date>='$date_from' and h.reg_date<='$date_to' and h.entry_type = 2 ))";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$where[] = "( h.reg_date<='$date_to' || h.reg_date<='$date_to' )";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$where[] = "( h.reg_date>='$date_from' || h.reg_date>='$date_from' )";
		}
	}
	else if ($report_for == 1) {    //new member
		$where[] = "h.entry_type = '1' and h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$where[] = "h.reg_date>='$date_from' and h.reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$where[] = "h.reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$where[] = "h.reg_date>='$date_from'";
		}
	}
	else if ($report_for == 2) {    //renewed member
		$where[] = "h.entry_type = '2' and h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$where[] = "h.reg_date>='$date_from' and h.reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$where[] = "h.reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$where[] = "h.reg_date>='$date_from'";
		}
	}
	else if($report_for == 3 ){
		$where[]= "\n h.reg_year_id = (select max(id) from #__member_reg_year where id<'$last_reg_year_id' )"
		."\n and member_id not in (select member_id from #__member_history"
		."\n where reg_year_id = '$last_reg_year_id')"
		."\n and (h.entry_type='1' or h.entry_type='2')"
		;
		/*
		if ($date_from != '' && $date_to != '' ) {
		$where[] = "m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
		$where[] = "m.last_reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
		$where[] = "m.last_reg_date>='$date_from'";
		}   */
	}

	$query = "select distinct(m.id) as id, m.firm_name as firm_name, m.tin as tin "
	."\n ,m.type_id as type_id , h.reg_year_id as last_reg_year_id"
	."\n ,c.renewal_fee as renewal_fee,mt.name as member_type "
	."\n ,m.firm_phone as phone, des.name as designation"
	."\n ,m.representative_name as name, m.firm_reg_address_street as street"
	."\n ,m.firm_reg_address_town_suburb as town, m.firm_reg_address_district as district"
	."\n ,m.firm_reg_address_division as division, m.firm_reg_address_country as country"
	."\n ,m.firm_fax as fax from #__member as m "
	."\n left join #__member_type as mt on m.type_id=mt.id"
	."\n LEFT JOIN #__member_history AS h ON h.member_id = m.id"
	."\n left join #__designation as des on des.id=m.representative_designation"
	."\n LEFT JOIN #__member_charge AS c ON c.member_type_id = m.type_id and c.reg_year_id='$last_reg_year_id'"
	."\n where m.is_delete =0 "
	. ( count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
	."\n ORDER BY m.firm_name "
	;
	//$pdf->ezText($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();


	$i=1;
	$data=array();
	$grand_total=0;
	foreach($rows as $row){

		$renewal_fee=$row->renewal_fee;
		$grand_total=$grand_total+$renewal_fee;
		//common for all
		$SLNO=$i;
		$applicant=$row->name;
		$address=$row->street;
		$address.= trim($row->town)!="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?", ".$row->district:"";
		$address.= trim($row->division)!="" ?", ".$row->division:"";
		$address.= trim($row->country)!="" ?", ".$row->country:"";
		$tin = $row->tin;


		$col1= strip_tags( $row->firm_name."\n".$address );
		$col1= decodeHTML( $col1 );
		$contact= $row->phone == "" ? "" :"Tel: ".$row->phone ;
		$contact.= $contact == "" ? "" : "\n" ;
		$contact.= $row->fax == "" ? "" :"Fax: ".$row->fax ;
		$contact= decodeHTML( $contact );
		$col4= $row->name;
		$col4.= $col4 == "" ? "" : "\n" ;
		$col4.= $row->designation == "" ? "" :$row->designation ;
		$col4= decodeHTML( $col4 );
		$member_type=$row->member_type;
		$member_type= decodeHTML($member_type);

		if($report_for>=0 && $report_for<3){    //prepare array for New and Renewal Member
			if ($type_id==0)// when member type is all
			{
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'firm_name'=>stripslashes($col1)
				,'member_type'=> stripcslashes($member_type)
				,'tin'=>stripslashes($tin)
				,'contact'=>stripslashes($contact)
				,'applicant'=>stripslashes($col4)
				);
			}
			else
			{
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'firm_name'=>stripslashes($col1)
				,'tin'=>stripslashes($tin)
				,'contact'=>stripslashes($contact)
				,'applicant'=>stripslashes($col4)
				);
			}
		}
		else{ //prepare array for outstanding Member
			if($type_id==0) // when member type is all
			{
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'firm_name'=>stripslashes($col1)
				,'member_type'=> stripcslashes($member_type)
				,'tin'=>stripslashes($tin)
				,'contact'=>stripslashes($contact)
				,'applicant'=>stripslashes($col4)
				,'dues'=>$renewal_fee
				);


			}
			else
			{
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'firm_name'=>stripslashes($col1)
				,'tin'=>stripslashes($tin)
				,'contact'=>stripslashes($contact)
				,'applicant'=>stripslashes($col4)
				,'dues'=>$renewal_fee
				);
			}
		}

		array_push($data,$arr);

		$i++;
	}
	if($report_for>=0 && $report_for<3){
		//prepare col title for new and renewal member
		if ($type_id==0)  // all type of member
		{
			$cols = array('SLNO'=>"Sl.",'firm_name'=>'Name of the Firm',
			'member_type'=>'Member Type','tin'=>'TIN Number',
			'contact'=>'Tel. & Fax No.',
			'applicant'=>'Name of the Representative'
			);

			$pdf->ezTable($data,$cols,'',array('xPos'=>580,'xOrientation'=>'left','width'=>570,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>22),
			'firm_name'=>array('justification'=>'left','width'=>150),
			'member_type'=>array('justification'=>'left','width'=>50),
			'tin'=>array('justification'=>'left','width'=>80),
			'contact'=>array('justification'=>'left','width'=>115),
			'applicant'=>array('justification'=>'left','width'=>140),
			)), 9);
		}
		else
		{

			$cols = array('SLNO'=>"Sl.",'firm_name'=>'Name of the Firm',
			'tin'=>'TIN Number',
			'contact'=>'Tel. & Fax No.',
			'applicant'=>'Name of the Representative'
			);
			//generate table for new and renewal member

			$pdf->ezTable($data,$cols,'',array('xPos'=>580,'xOrientation'=>'left','width'=>570,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>25),
			'firm_name'=>array('justification'=>'left','width'=>170),
			'tin'=>array('justification'=>'left','width'=>80),
			'contact'=>array('justification'=>'left','width'=>125),
			'applicant'=>array('justification'=>'left','width'=>160),
			)), 9);
		}

	}
	else{
		//prepare col title for outstanding member
		if($type_id==0) //when member type is all
		{
			$cols = array('SLNO'=>"Sl.",'firm_name'=>'Name of Firm',
			'member_type'=>'Member Type','tin'=>'TIN Number',
			'contact'=>'Tel. & Fax No.',
			'applicant'=>'Name of Representative',
			'dues'=>'Dues (Tk.)'
			);

			$pdf->ezTable($data,$cols,'',array('xPos'=>580,'xOrientation'=>'left','width'=>570,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>25),
			'firm_name'=>array('justification'=>'left','width'=>140),
			'member_type'=>array('justification'=>'left','width'=>50),
			'tin'=>array('justification'=>'left','width'=>50),
			'contact'=>array('justification'=>'left','width'=>105),
			'applicant'=>array('justification'=>'left','width'=>140),
			'dues'=>array('justification'=>'left','width'=>50),
			)), 9);


		}

		else
		{
			$cols = array('SLNO'=>"Sl.",'firm_name'=>'Name of Firm',
			'tin'=>'TIN Number',
			'contact'=>'Tel. & Fax No.',
			'applicant'=>'Name of Representative',
			'dues'=>'Dues (Tk.)'
			);
			$pdf->ezTable($data,$cols,'',array('xPos'=>580,'xOrientation'=>'left','width'=>570,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>25),
			'firm_name'=>array('justification'=>'left','width'=>170),
			'tin'=>array('justification'=>'left','width'=>50),
			'contact'=>array('justification'=>'left','width'=>105),
			'applicant'=>array('justification'=>'left','width'=>160),
			'dues'=>array('justification'=>'left','width'=>50),
			)), 9);

		}

		//generate table for outstanding member

		$pdf->ezText( "", 10 );
		$pdf->ezText( "Total Dues: Tk. ".$grand_total, 10 );

	}


	//end of logic

	// footer
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}




function  MemberVoterlistCcci( $FOR, $database, $type_id, $report_for,$last_reg_id )
{
	global $config_voter_election_date,$mosconfig_voter_new_date,$mosconfig_voter_renew_date;


	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font

	$pdf->setStrokeColor( 0, 0, 0, 1 );

	//Header

	$NAME=(strtolower($FOR)=='ccci')?_CHAMBER_NAME_CCCI:_CHAMBER_NAME_SCCI;
	$ADDRESS=(strtolower($FOR)=='ccci')?_ADDRESS_CCCI:_ADDRESS_SCCI;
	$CONTACT=(strtolower($FOR)=='ccci')?_CONTACT_NUMBER_CCCI:_CONTACT_NUMBER_SCCI;
	$EMAIL=(strtolower($FOR)=='ccci')?_EMAIL_CCCI:_EMAIL_SCCI;

	if($type_id>0){
		$type_name = $database->getMemberTypeName($type_id);
		$TITLE="Voter List - ".$type_name;
	}
	else
	$TITLE="Voter List - All Member";

	ReportTitle($pdf, $FOR, $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center');


	//this is the start of the logic to get the search result
	$election_date=mosHTML::ConvertDateForDatatbase($config_voter_election_date);
	$rows=array();

	if ($report_for == 1)//new member
	{
		if ($type_id==0) // 0 for all catagory
		{
			$where[] = " (m.type_id='3' || m.type_id='4') and mh.entry_type=1 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day)";
		}
		else
		{
			$where[] = " m.type_id='$type_id' and mh.entry_type=1 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day)";
		}
	}
	else if ($report_for == 2)//reneew member
	{
		if ($type_id==0) // 0 for all catagory
		{
			$where[] = "(m.type_id='3' || m.type_id='4') and mh.entry_type=2 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)";
		}
		else // 0 for associate member
		{
			$where[] = "m.type_id='$type_id' and mh.entry_type=2 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)";
		}

	}
	else if ($report_for == 0)
	{
		if ($type_id==0) // 0 for all catagory
		{
			$where[] = "(m.type_id='3' || m.type_id='4') and ((mh.entry_type=1 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day)) ||(mh.entry_type=2 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)))";
		}
		else
		{
			$where[] = "m.type_id='$type_id' and ((mh.entry_type=1 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day)) ||(mh.entry_type=2 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)))";
		}

	}


	$query = "select m.firm_name as firm_name, m.tin as tin "
	."\n ,m.firm_phone as phone, pdes.name as principal_nominee_designation"
	."\n ,m.principal_nominee_title as pnt,m.principal_nominee_name as principal_nominee_name,m.principal_nominee_last_name as pnln"
	."\n ,m.firm_reg_address_street as street"
	."\n ,m.alt_nominee_title as ant,m.alt_nominee_name as alt_nominee_name,m.alt_nominee_last_name as anln"
	."\n ,ades.name as alt_nominee_designation"
	."\n ,m.firm_reg_address_town_suburb as town, m.firm_reg_address_district as district"
	."\n ,m.firm_reg_address_division as division, m.firm_reg_address_country as country"
	."\n ,m.firm_fax as fax,mt.name as type_name"
	."\n from #__member as m left join #__member_history as mh on m.id=mh.member_id "
	."\n left join #__member_type as mt on m.type_id=mt.id"
	."\n left join #__designation as pdes on pdes.id=m.principal_nominee_designation"
	."\n left join #__designation as ades on ades.id=m.alt_nominee_designation"
	."\n where m.is_delete=0 and  mh.reg_year_id= '$last_reg_id' "
	// ."\n mh.entry_type=1 and m.last_reg_date<= date_sub(\"".$date."\", interval 1 day)"
	. ( count( $where ) ? "\n and " . implode( ' AND ', $where ) : "")
	//."\n order by mh.member_reg_no, mt.id "
	."\n order by m.firm_name "
	;

	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$totalRows = count( $rows );
	$i=1;
	$data=array();
	foreach($rows as $row){
		$SLNO=$i;
		//$applicant=$row->name;
		$address=$row->street;
		$address.= trim($row->town)!="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?", ".$row->district:"";
		$address.= trim($row->division)!="" ?", ".$row->division:"";
		$address.= trim($row->country)!="" ?", ".$row->country:"";
		$tin = $row->tin;


		$col1= strip_tags( $row->firm_name."\n".$address );
		$col1= decodeHTML( $col1 );
		$contact= $row->phone == "" ? "" :"Tel: ".$row->phone ;
		$contact.= $contact == "" ? "" : "\n" ;
		$contact.= $row->fax == "" ? "" :"Fax: ".$row->fax ;
		$contact= decodeHTML( $contact );
		//$col4= strip_tags( $row->name."\n".$row->designation );
		$col4=strip_tags( $row->pnt." ".$row->principal_nominee_name." ".$row->pnln."\n".$row->principal_nominee_designation."\n".$row->ant." ".$row->alt_nominee_name." ".$row->anln."\n".$row->alt_nominee_designation);
		$col4= decodeHTML( $col4 );

		$col5= $row->type_name;
		$col5= decodeHTML( $col5 );

		if ($type_id==0)
		{
			$arr=array( 'SLNO'=>stripslashes($SLNO)
			,'firm_name'=>stripslashes($col1)
			,'tin'=>stripslashes($tin)
			,'Member_Type'=>stripslashes($col5)
			,'contact'=>stripslashes($contact)
			,'applicant'=>stripslashes($col4)
			);

		}
		else
		{
			$arr=array( 'SLNO'=>stripslashes($SLNO)
			,'firm_name'=>stripslashes($col1)
			,'tin'=>stripslashes($tin)
			,'contact'=>stripslashes($contact)
			,'applicant'=>stripslashes($col4)
			);
		}

		array_push($data,$arr);

		$i++;
	}

	if ($type_id==0)
	{
		$cols = array('SLNO'=>"Sl.",'firm_name'=>'Name of Firm',
		'Member_Type'=>'Member Type',
		'tin'=>'TIN Number',
		'contact'=>'Tel. & Fax No.',
		'applicant'=>'Names Of The Nominees'
		);


	}
	else
	{
		$cols = array('SLNO'=>"Sl.",'firm_name'=>'Name of Firm',
		'tin'=>'TIN Number',
		'contact'=>'Tel. & Fax No.',
		'applicant'=>'Names Of The Nominees'
		);
	}


	if ($type_id==0)
	{
		$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0,'xPos'=>580,'xOrientation'=>'left','width'=>570,
		'cols'=>array(
		'SLNO'=>array('justification'=>'left','width'=>22),
		'firm_name'=>array('justification'=>'left','width'=>160),
		'Member_Type'=>array('justification'=>'left','width'=>50),
		'tin'=>array('justification'=>'left','width'=>60),
		'contact'=>array('justification'=>'left','width'=>115),
		'applicant'=>array('justification'=>'left','width'=>148),
		)), 9);


	}
	else
	{
		$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0,'xPos'=>580,'xOrientation'=>'left','width'=>570,
		'cols'=>array(
		'SLNO'=>array('justification'=>'left','width'=>25),
		'firm_name'=>array('justification'=>'left','width'=>170),

		'tin'=>array('justification'=>'left','width'=>80),
		'contact'=>array('justification'=>'left','width'=>125),
		'applicant'=>array('justification'=>'left','width'=>160),
		)), 9);
	}

	//end of logic

	// footer
	$title="\n\nElection Board";
	$total_no_members=$totalRows;
	$for=$FOR;
	strtoupper($for)=="CCCI"?ReportVoterListFooter($pdf,$title,$total_no_members,$for,$election_date):ReportFooter($pdf);
	//ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}

//report for User Trail details
function UserReport( $FOR ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//Header
	$TITLE="Activity Report on User";
	if(strtolower($FOR)=="bkmea"){
		$NAME    =_CHAMBER_NAME_BKMEA;
		$ADDRESS =_ADDRESS_BKMEA;
		$CONTACT =_CONTACT_NUMBER_BKMEA;
		$EMAIL   =_EMAIL_BKMEA;
	}
	else if(strtolower($FOR)=="ccci"){
		$NAME    =_CHAMBER_NAME_CCCI;
		$ADDRESS =_ADDRESS_CCCI;
		$CONTACT =_CONTACT_NUMBER_CCCI;
		$EMAIL   =_EMAIL_CCCI;
	}
	else if(strtolower($FOR)=="scci"){
		$NAME    =_CHAMBER_NAME_SCCI;
		$ADDRESS =_ADDRESS_SCCI;
		$CONTACT =_CONTACT_NUMBER_SCCI;
		$EMAIL   =_EMAIL_SCCI;
	}
	else if(strtolower(trim($FOR))=="epb"){
		$NAME    =_ORG_NAME;
		$ADDRESS =_ADDRESS_EPB;
		$CONTACT =_CONTACT_NUMBER_EPB;
		$EMAIL   =_EMAIL_EPB;
	}




	//this is the start of the logic to get the search result
	$year = date('Y');
	$type_id     = intval( mosGetParam( $_REQUEST, 'type_id' ));
	$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));

	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);

	$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
	$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);

	if ($type_id==1)
	$user_type="Biz Admin";
	elseif ($type_id==2)
	$user_type="Sys Admin";
	elseif ($type_id==3)
	$user_type="Data Admin";
	elseif ($type_id==4)
	$user_type=""; // for registered user

	//$where = array();
	$where = "";
	if ($type_id==0 && $report_for==0) {

		if (!$date_from && !$date_to){
			$where = "";
		}elseif ($date_from && !$date_to){
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where = "where DATE_FORMAT(ut.action_time,'%Y-%m-%d')>='$date_from'";
		}elseif (!$date_from && $date_to){
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where = "where DATE_FORMAT(ut.action_time,'%Y-%m-%d')<='$date_to'";
		}elseif ($date_from && $date_to){
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where = "where DATE_FORMAT(ut.action_time,'%Y-%m-%d')>='$date_from' and DATE_FORMAT(ut.action_time,'%Y-%m-%d')<='$date_to'";
		}
	}
	elseif ($type_id!=0 && $report_for==0) {

		if (!$date_from && !$date_to){
			$where = "where LCase(TRIM(ut.usertype))=LCase(TRIM('".$user_type."'))";
		}elseif ($date_from && !$date_to){
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where = "where LCase(TRIM(ut.usertype))=LCase(TRIM('".$user_type."')) and DATE_FORMAT(ut.action_time,'%Y-%m-%d')>='$date_from'";
		}elseif (!$date_from && $date_to){
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where = "where LCase(TRIM(ut.usertype))=LCase(TRIM('".$user_type."')) and DATE_FORMAT(ut.action_time,'%Y-%m-%d')<='$date_to'";
		}elseif ($date_from && $date_to){
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where = "where LCase(TRIM(ut.usertype))=LCase(TRIM('".$user_type."')) and DATE_FORMAT(ut.action_time,'%Y-%m-%d')>='$date_from' and DATE_FORMAT(ut.action_time,'%Y-%m-%d')<='$date_to'";
		}
	}
	elseif ($type_id==0 && $report_for!=0) {

		if (!$date_from && !$date_to){
			$where = "where ut.action_type=$report_for";
		}elseif ($date_from && !$date_to){
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where = "where ut.action_type=$report_for and DATE_FORMAT(ut.action_time,'%Y-%m-%d')>='$date_from'";
		}elseif (!$date_from && $date_to){
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where = "where ut.action_type=$report_for and DATE_FORMAT(ut.action_time,'%Y-%m-%d')<='$date_to'";
		}elseif ($date_from && $date_to){
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where = "where ut.action_type=$report_for and DATE_FORMAT(ut.action_time,'%Y-%m-%d')>='$date_from' and DATE_FORMAT(ut.action_time,'%Y-%m-%d')<='$date_to'";
		}
	}
	elseif ($type_id!=0 && $report_for!=0) {

		if (!$date_from && !$date_to){
			$where = "where ut.action_type=$report_for and LCase(TRIM(ut.usertype))=LCase(TRIM('".$user_type."'))";
		}elseif ($date_from && !$date_to){
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where = "where ut.action_type=$report_for and LCase(TRIM(ut.usertype))=LCase(TRIM('".$user_type."')) and DATE_FORMAT(ut.action_time,'%Y-%m-%d')>='$date_from'";
		}elseif (!$date_from && $date_to){
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where = "where ut.action_type=$report_for and LCase(TRIM(ut.usertype))=LCase(TRIM('".$user_type."')) and DATE_FORMAT(ut.action_time,'%Y-%m-%d')<='$date_to'";
		}elseif ($date_from && $date_to){
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where = "where ut.action_type=$report_for and LCase(TRIM(ut.usertype))=LCase(TRIM('".$user_type."')) and DATE_FORMAT(ut.action_time,'%Y-%m-%d')>='$date_from' and DATE_FORMAT(ut.action_time,'%Y-%m-%d')<='$date_to'";
		}
	}


	ReportTitle($pdf, $FOR, $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center',$reporting_period);
	// alignment can be control by ezText function by third parameter
	//$pdf->ezText("Welcome",10,array('justification'=>'center'));
	//$pn=$pdf->ezStartPageNumbers(50,100,10); //show page number e.g. 1 of 1
	$query = "select ut.* from #__user_trail AS ut $where  order by ut.action_time DESC"
	;

	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$totalRows = count( $rows );
	$i=1;
	$data=array();
	foreach($rows as $row){
		$SLNO=$i;
		$name=$row->name;
		$login_id=$row->user_name;
		$usertype=$row->usertype==""?"Public":$row->usertype;
		$action_time=mosHtml::ConvertDateTimeDisplayLong($row->action_time);
		if ($row->action_type==1)
		$action_type='New User';
		elseif ($row->action_type==2)
		$action_type='Deleted User';
		$action_by=$row->action_by==""?"System":$row->action_by;

		$arr=array( 'action_time'=>stripslashes($action_time)
		,'name'=>stripslashes($name)
		,'login_id'=>stripslashes($login_id)
		,'usertype'=>stripslashes($usertype)
		,'action_type'=>stripslashes($action_type)
		,'action_by'=>stripslashes($action_by)
		);

		array_push($data,$arr);

		$i++;
	}

	$cols = array( 'action_time'=>'Action Date',
	'name'=>'Name',
	'login_id'=>'Login Name',
	'usertype'=>'User Type',
	'action_type'=>'Action Type',
	'action_by'=>'Action By'
	);

	$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>580,'xOrientation'=>'left','width'=>570,
	'cols'=>array(
	'action_time'=>array('justification'=>'left','width'=>105),
	'name'=>array('justification'=>'left','width'=>115),
	'login_id'=>array('justification'=>'left','width'=>70),
	'usertype'=>array('justification'=>'left','width'=>100),
	'action_type'=>array('justification'=>'left','width'=>70),
	'action_by'=>array('justification'=>'left','width'=>110),
	)), 9);


	//end of logic

	// footer
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}



//Member History report

function MemberHistoryReport( $FOR='bkmea' ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//this is the start of the logic to get the search result

	$year = date('Y');
	$type_id     =  trim(mosGetParam( $_REQUEST, 'type_id'));
	$user_type=$type_id;
	$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));

	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);

	$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
	$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);
	//Header
	if(strtolower($FOR)=="bkmea"){
		$NAME    =_CHAMBER_NAME_BKMEA;
		$ADDRESS =_ADDRESS_BKMEA;
		$CONTACT =_CONTACT_NUMBER_BKMEA;
		$EMAIL   =_EMAIL_BKMEA;
	}
	else if(strtolower($FOR)=="ccci"){
		$NAME    =_CHAMBER_NAME_CCCI;
		$ADDRESS =_ADDRESS_CCCI;
		$CONTACT =_CONTACT_NUMBER_CCCI;
		$EMAIL   =_EMAIL_CCCI;
	}
	else if(strtolower($FOR)=="scci"){
		$NAME    =_CHAMBER_NAME_SCCI;
		$ADDRESS =_ADDRESS_SCCI;
		$CONTACT =_CONTACT_NUMBER_SCCI;
		$EMAIL   =_EMAIL_SCCI;
	}

	$TITLE="Activity Report on Member ";



	$where = Array();
	if ($date_from != '' && $date_to != '' ) {
		$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
		$where[] = "DATE_FORMAT(mt.date,'%Y-%m-%d')>='$date_from' and DATE_FORMAT(mt.date,'%Y-%m-%d')<='$date_to'";
	}
	else if ($date_from == '' && $date_to != '' ) {
		$reporting_period="Reporting Period : Upto ".$date_to_display;
		$where[] = "DATE_FORMAT(mt.date,'%Y-%m-%d')<='$date_to'";
	}
	else if ($date_from != '' && $date_to == '' ) {
		$reporting_period="Reporting Period : From ".$date_from_display;
		$where[] = "DATE_FORMAT(mt.date,'%Y-%m-%d')>='$date_from'";
	}

	ReportTitle($pdf, $FOR, $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center',$reporting_period);

	if ($type_id!='0') {
		$where[] = "LCase(TRIM(u.username))= LCase(TRIM('".$user_type."'))";
	}

	if ($report_for>0) {
		$where[] = "mt.entry_type= '$report_for'";
	}

	$query = "select mt.member_id as member_id, mt.user_id as user_id, mt.entry_type as action_type,"
	."\n mt.date as action_date_time, u.name as name, u.username as username,"
	."\n m.id as id, m.firm_name as firm_name, m.member_reg_no as member_reg_no"
	."\n from #__member_trail as mt "
	."\n JOIN #__users as u ON mt.user_id=u.username"
	."\n LEFT JOIN #__member as m ON mt.member_id=m.id "
	. ( count( $where ) ? "\n where " . implode( ' AND ', $where ) : "")
	." order by mt.date DESC,m.firm_name ASC"
	;
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$totalRows = count( $rows );
	$i=1;
	$data=array();
	foreach($rows as $row){
		$SLNO=$i;
		$firm_name=$row->firm_name;
		$member_reg_no=$row->member_reg_no;
		$action_date_time=mosHtml::ConvertDateTimeDisplayLong($row->action_date_time);
		if ($row->action_type==1)
		$action_type="New Profile";
		elseif ($row->action_type==3)
		$action_type="Update Profile";
		elseif ($row->action_type==6)
		$action_type="Delete Profile";
		elseif ($row->action_type==2)
		$action_type="Renew Member";
		elseif ($row->action_type==4)
		$action_type="Member Certificate";
		elseif ($row->action_type==5)
		$action_type="Member ID Card";
		$name=$row->name;
		//$name.="\n\n\n";
		$name=decodeHTML($name);
		$login_id=$row->username;

		$arr=array('action_date_time'=>stripslashes($action_date_time)
		,'firm_name'=>stripslashes($firm_name)
		,'member_reg_no'=>stripslashes($member_reg_no)
		,'action_type'=>stripslashes($action_type)
		,'login_id'=>stripslashes($login_id)
		,'name'=>stripslashes($name)
		);

		array_push($data,$arr);

		$i++;
	}

	$cols = array( 'action_date_time'=>'Action Date',
	'firm_name'=>'Firm Name',
	'member_reg_no'=>'Firm Reg. No.',
	'action_type'=>'Action Type',
	'login_id'=>'Login Name',
	'name'=>'Full Name'
	);

	$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7), 'xPos'=>585,'xOrientation'=>'left','width'=>555,
	'cols'=>array(
	'action_date_time'=>array('justification'=>'left','width'=>90),
	'firm_name'=>array('justification'=>'left','width'=>150),
	'member_reg_no'=>array('justification'=>'left','width'=>80),
	'action_type'=>array('justification'=>'left','width'=>90),
	'login_id'=>array('justification'=>'left','width'=>70),
	'name'=>array('justification'=>'left','width'=>80),
	)), 9);


	//end of logic

	// footer
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}
//Delegate Member Voter List report

function DelegateVoterCCCI( $FOR,$last_reg_id,$flag=null ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;
	global $config_voter_election_date,$mosconfig_voter_new_date,$mosconfig_voter_renew_date;

	$election_date=mosHTML::ConvertDateForDatatbase($config_voter_election_date);


	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	// query to find working registration year
	// $last_reg_id=  working registration year id
	$query = "select mry.name as name from #__member_reg_year as mry where mry.id='".$last_reg_id."'";
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	foreach ($rows as $row){
		$last_reg_year=$row->name;
	}

	$NAME    =_CHAMBER_NAME_CCCI;
	$ADDRESS =_ADDRESS_CCCI;
	$CONTACT =_CONTACT_NUMBER_CCCI;
	$EMAIL   =_EMAIL_CCCI;

	if (flag!=1)
	$TITLE=" Delegate Member (".$last_reg_year.')';
	else
	$TITLE="List of Voters for Election for ".$last_reg_year."\n\n Delegate Voter List ";

	ReportTitle($pdf, $FOR, $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center');
	// $pdf->ezText("List of Voters for Election for ".$last_reg_id,10,array('justification'=>'center'));

	// query added by mizan for finding the list of voters
	$is_voter=$flag==1?"mh.is_voter=1 and":"";
	$query = "select m.id as id, m.applicant_name as applicant_name ,m.firm_name as firm_name,"
	."\n mt.name as member_type, mh.is_voter as is_voter"
	."\n ,pt.firm_phone as phone, des.name as representative_designation"
	."\n ,m.representative_name as representative_name, pt.firm_reg_address_street as street"
	."\n ,m.representative_title as representative_title,m.representative_last_name as representative_last_name"
	."\n ,pt.firm_reg_address_town_suburb as town, pt.firm_reg_address_district as district"
	."\n ,pt.firm_reg_address_division as division, pt.firm_reg_address_country as country,"
	."\n pt.firm_name as company_name from #__member as m"
	."\n left join #__member_history as mh on m.id=mh.member_id "
	."\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
	."\n left join #__member as pt on m.parent=pt.id"
	."\n left join #__designation as des on des.id=m.representative_designation"
	."\n where $is_voter m.is_delete=0 and  mh.reg_year_id= '$last_reg_id'"
	."\n and m.type_id=5 and ((mh.entry_type=1 and "
	."\n mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day))"
	."\n || (mh.entry_type=2 and mh.reg_date<="
	."\n date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)))"
	//."\n order by mh.member_reg_no, mt.id"
	."\n order by m.firm_name"
	;
	$database->setQuery( $query );
	$rows = $database->loadObjectList();


	$totalRows = count( $rows );
	$i=1;
	$data=array();$previous_company_name="";
	foreach($rows as $row){
		$SLNO=$i;
		if (trim($row->company_name)!=trim($previous_company_name)){
			$company_name=stripslashes($row->company_name);
			$company_name.=$row->strret?"\n".stripslashes($row->strret):"";
			$company_name.=$row->strret?", ".stripslashes($row->town):"";
			$company_name.=$row->district?"\n".stripslashes($row->district):"";
			$company_name.=$row->district?", ".stripslashes($row->division):"";
			$company_name.=$row->division?", ".stripslashes($row->country):"";
			$company_name.=$row->country?"\nPhone : ".stripslashes($row->country):"";
			$previous_company_name=$row->company_name;
		}
		else{
			$company_name="";
		}
		$representative_name=stripslashes($row->representative_title)." ".stripslashes($row->representative_name)." ".stripslashes($row->representative_last_name);
		$representative_name.=$row->firm_name?"\n".stripslashes($row->firm_name):"";
		$representative_name.=$row->street?"\n".stripslashes($row->street):"";
		$representative_name.=$row->town?", ".stripslashes($row->town):"";
		$representative_name.=$row->district?", ".stripslashes($row->district):"";
		$representative_name.=$row->division?"\n".stripslashes($row->division):"";
		$representative_name.=$row->country?", ".stripslashes($row->country):"";


		$arr=array( 'company_name'=>stripslashes($company_name)
		,'SLNO'=>stripslashes($SLNO)
		,'representative_name'=>stripslashes($representative_name)
		);

		array_push($data,$arr);

		$i++;
	}

	$cols = array( 'company_name'=>'Name of Group Members',
	'SLNO'=>"No. of Voters",
	'representative_name'=>'Elected Representatives of Delegate Members'
	);

	$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0,'xPos'=>585,'xOrientation'=>'left','width'=>555,
	'cols'=>array(
	'company_name'=>array('justification'=>'left','width'=>220),
	'SLNO'=>array('justification'=>'center','width'=>75),
	'representative_name'=>array('justification'=>'left','width'=>250),
	)), 9);


	//end of logic

	// footer
	//ReportFooter($pdf);
	if($flag==1)
	{
		$title="Election Board";
		$total_no_members=$totalRows;
		$for=$FOR;
		strtoupper($for)=="CCCI"?ReportVoterListFooter($pdf,$title,$total_no_members,$for,$election_date):ReportFooter($pdf);
	}
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}



function  MemberVoterlistScci( $FOR, $database, $type_id, $report_for,$last_reg_id )
{
	global $config_voter_election_date,$mosconfig_voter_new_date,$mosconfig_voter_renew_date;


	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font

	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$membership_no     =  mosGetParam( $_REQUEST, 'membership_no' );
	//Header

	$NAME=_CHAMBER_NAME_SCCI;
	$ADDRESS=_ADDRESS_SCCI;
	$CONTACT=_CONTACT_NUMBER_SCCI;
	$EMAIL=_EMAIL_SCCI;

	if($type_id>0){
		$type_name = $database->getMemberTypeName($type_id);
		$type_name_arr=explode(" ",$type_name);
		$type_name=$type_name_arr[0];
		$type_name.=(strtolower($type_name_arr[1])=="member" || trim($type_name_arr[1])=="")? "":" ".$type_name_arr[1];
		$TITLE=$type_name." Voter List for the Year ";
	}
	else
	$TITLE="All Member Voter List for the Year ";

	$sql="select end_date from #__member_reg_year where id='$last_reg_id'";
	$database->setQuery($sql);
	$year=explode("-",$database->loadResult());
	$TITLE.=$year[0];

	ReportTitle($pdf, $FOR, $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center');


	//this is the start of the logic to get the search result
	$election_date=mosHTML::ConvertDateForDatatbase($config_voter_election_date);
	$rows=array();

	if ($membership_no!=""){
		$members1=explode(",",$membership_no);
		$members2=array();

		for ($i=0;$i<count($members1);$i++){
			if(trim($members1)!=""){
				if (strpos($members1[$i],'-',0)){
					$temp=explode("-",$members1[$i]);
					if ($temp[0]>$temp[1]){
						$t=$temp[0];
						$temp[0]=$temp[1];
						$temp[1]=$t;
					}
					for ($j=intval($temp[0]);$j<=intval($temp[1]);$j++){
						if (is_numeric($j))
						array_push($members2,$j);
					}
				}
				else{
					if (is_numeric($members1[$i]))
					array_push($members2,$members1[$i]);
				}
			}
		}

		/*  for ($i=0;$i<count($members2);$i++){
		for ($j=$i+1;$j<count($members2);$j++){
		if ($members2[$i]==$members2[$j]){
		for ($k=$j;$k<count($members2);$k++){
		$members2[$k]=$members2[$k+1];
		}
		}
		}
		} */
		$members=implode(',',$members2);
		if (sizeof($members2)>0)
		$where[] = "m.member_reg_no IN ($members)";
	}

	if ($report_for == 1)//new member
	{
		if ($type_id==0) // 0 for all catagory
		{
			$where[] = " (m.type_id='3' || m.type_id='4') and mh.entry_type=1 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day)";
		}
		else
		{
			$where[] = " m.type_id='$type_id' and mh.entry_type=1 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day)";
		}
	}
	else if ($report_for == 2)//reneew member
	{
		if ($type_id==0) // 0 for all catagory
		{
			$where[] = "(m.type_id='3' || m.type_id='4') and mh.entry_type=2 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)";
		}
		else // 0 for associate member
		{
			$where[] = "m.type_id='$type_id' and mh.entry_type=2 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)";
		}

	}
	else if ($report_for == 0)
	{
		if ($type_id==0) // 0 for all catagory
		{
			$where[] = "(m.type_id='3' || m.type_id='4') and ((mh.entry_type=1 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day)) ||(mh.entry_type=2 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)))";
		}
		else
		{
			$where[] = "m.type_id='$type_id' and ((mh.entry_type=1 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day)) ||(mh.entry_type=2 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)))";
		}

	}


	$query = "select  distinct (m.tin) as tin,m.id as id, m.firm_name as firm_name, mh.member_reg_no as membershipno "
	."\n ,m.firm_phone as phone , m.firm_reg_address_street as street"
	."\n ,representative_photograph as photograph"
	."\n ,m.representative_name, des.name as representative_designation"
	."\n ,m.representative_title, m.representative_last_name"
	."\n ,m.firm_reg_address_town_suburb as town, m.firm_reg_address_district as district"
	."\n ,m.firm_reg_address_division as division, m.firm_reg_address_country as country"
	."\n ,m.firm_fax as fax,mt.name as type_name"
	."\n from #__member as m left join #__member_history as mh on m.id=mh.member_id "
	."\n left join #__member_type as mt on m.type_id=mt.id"

	."\n left join #__designation as des on des.id=m.representative_designation"
	."\n where m.is_delete=0 and  mh.reg_year_id= '$last_reg_id' and mh.is_voter=1"
	// ."\n mh.entry_type=1 and m.last_reg_date<= date_sub(\"".$date."\", interval 1 day)"
	. ( count( $where ) ? "\n and " . implode( ' AND ', $where ) : "")
	//."\n group by m.tin order by m.firm_name"
	."\n group by m.tin order by mh.member_reg_no"
	;
	//$pdf->ezText($query,12);

	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$totalRows = count( $rows );
	$i=1;
	$data=array();
	foreach($rows as $row){
		$SLNO=$i;
		//$applicant=$row->name;
		$address=$row->street;
		$address.= trim($row->town)!="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?", ".$row->district:"";
		//$address.= trim($row->division)!="" ?", ".$row->division:"";
		//$address.= trim($row->country)!="" ?", ".$row->country:"";
		$tin = $row->tin;
		$tin.="\n\n\n\n";


		$col1= strip_tags( $row->firm_name."\n".$address );
		$col1= decodeHTML( $col1 );
		$contact= $row->phone == "" ? "" :"Tel: ".$row->phone ;
		$contact.= $contact == "" ? "" : "\n" ;
		$contact.= $row->fax == "" ? "" :"Fax: ".$row->fax ;
		$contact= decodeHTML( $contact );

		$col4= $row->representative_title;
		$col4.= $row->representative_name=""?"":" ".$row->representative_name;
		$col4.= $row->representative_last_name=""?"":" ".$row->representative_last_name;
		//$col4.= $row->representative_designation == "" ? "" :"\n".$row->representative_designation ;



		//$col4=strip_tags( $row->representative_name."\n".$row->representative_designation."\n\n\n");
		//$col4=strip_tags( $row->representative_name);
		$col4= decodeHTML( $col4 );
		//$photograph='./administrator/images/photograph/'.$row->id.'/'.$row->photograph;
		$photograph='./administrator/images/photograph/'.$row->id.'/'.strtolower($row->photograph);
		$membershipno=$row->membershipno;

		$col5= $row->type_name;
		$col5= decodeHTML( $col5 );

		if ($type_id==0)
		{
			$arr=array( 'SLNO'=>stripslashes($SLNO)
			,'firm_name'=>stripslashes($col1)
			,'tin'=>stripslashes($tin)
			,'Member_Type'=>stripslashes($col5)

			,'applicant'=>stripslashes($col4)
			);

		}
		else
		{
			$arr=array( 'SLNO'=>stripslashes($SLNO)
			,'membershipno'=>$membershipno
			,'firm_name'=>stripslashes($col1)
			,'tin'=>stripslashes($tin)
			,'applicant'=>stripslashes($col4)
			,'photograph'=>$photograph
			);
		}

		array_push($data,$arr);

		$i++;
	}

	if ($type_id==0)
	{
		$cols = array('SLNO'=>"Voter #",'firm_name'=>'Name of The Firm & Address',
		'Member_Type'=>'Member Type',
		'tin'=>'TIN Number',

		'applicant'=>'Names of the Representative'
		);


	}
	else
	{
		$cols = array('SLNO'=>'Voter #','membershipno'=>'Mem. Code'
		,'firm_name'=>'Name of The Firm & Address',
		'tin'=>'TIN Number',

		'applicant'=>'Names of the Representative',
		'photograph'=>'Photo'
		);
	}


	if ($type_id==0)
	{
		$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>580,'xOrientation'=>'left','width'=>570,
		'cols'=>array(
		'SLNO'=>array('justification'=>'left','width'=>40),
		'firm_name'=>array('justification'=>'left','width'=>150),
		'Member_Type'=>array('justification'=>'left','width'=>50),
		'tin'=>array('justification'=>'left','width'=>90),
		'photograph'=>array('justification'=>'left','width'=>148),
		)), 9);


	}
	else
	{
		$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>580,'xOrientation'=>'left','width'=>570,
		'cols'=>array(
		'SLNO'=>array('justification'=>'left','width'=>40),
		'membershipno'=>array('justification'=>'left','width'=>60),
		'firm_name'=>array('justification'=>'left','width'=>160),
		'tin'=>array('justification'=>'left','width'=>90),
		'contact'=>array('justification'=>'left','width'=>125),
		'applicant'=>array('justification'=>'left','width'=>160),
		'photograph'=>array('justification'=>'left','width'=>50),
		)), 9);
	}

	//end of logic

	// footer

	//ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}


function MemberReportScci ( $FOR ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//this is the start of the logic to get the search result
	$year = date('Y');
	$type_id     = intval( mosGetParam( $_REQUEST, 'type_id' ));
	$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));
	$office_copy  = intval( mosGetParam( $_REQUEST, 'office_copy'));
	$last_reg_year_id   = trim( mosGetParam( $_REQUEST, 'last_reg_year_id' ));
	$membership_no     =  mosGetParam( $_REQUEST, 'membership_no' );

	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);

	$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
	$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);
	//Header
	$TITLE="List Of ALL Members ";
	$NAME=_CHAMBER_NAME_SCCI;
	$ADDRESS=_ADDRESS_SCCI;
	$CONTACT=_CONTACT_NUMBER_SCCI;
	$EMAIL=_EMAIL_SCCI;


	$where = array();

	if ($type_id > 0  ) {
		$where[] = "m.type_id='$type_id'";
		$type_name = $database->getMemberTypeName($type_id);
		$TITLE=$type_name." List for the ";
	}
	else {
		$TITLE="List Of ALL Members  for the ";
	}

	$sql="select name from #__member_reg_year where id='$last_reg_year_id'";
	$database->setQuery($sql);
	$TITLE.=$database->loadResult();

	if ($membership_no!=""){
		$members1=explode(",",$membership_no);
		$members2=array();

		for ($i=0;$i<count($members1);$i++){
			if(trim($members1)!=""){
				if (strpos($members1[$i],'-',0)){
					$temp=explode("-",$members1[$i]);
					if ($temp[0]>$temp[1]){
						$t=$temp[0];
						$temp[0]=$temp[1];
						$temp[1]=$t;
					}
					for ($j=intval($temp[0]);$j<=intval($temp[1]);$j++){
						if (is_numeric($j))
						array_push($members2,$j);
					}
				}
				else{
					if (is_numeric($members1[$i]))
					array_push($members2,$members1[$i]);
				}
			}
		}

		/*  for ($i=0;$i<count($members2);$i++){
		for ($j=$i+1;$j<count($members2);$j++){
		if ($members2[$i]==$members2[$j]){
		for ($k=$j;$k<count($members2);$k++){
		$members2[$k]=$members2[$k+1];
		}
		}
		}
		} */
		$members=implode(',',$members2);
		if (sizeof($members2)>0)
		$where[] = "m.member_reg_no IN ($members)";
	}

	if ($report_for == 0) {    //All member
		$where[] = "h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "( ( h.reg_date>='$date_from' and h.reg_date<='$date_to' and h.entry_type = 1 ) || ( h.reg_date>='$date_from' and h.reg_date<='$date_to' and h.entry_type = 2 ))";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "( h.reg_date<='$date_to' || h.reg_date<='$date_to' )";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "( h.reg_date>='$date_from' || h.reg_date>='$date_from' )";
		}
	}
	else if ($report_for == 1) {    //new member
		$where[] = "h.entry_type = '1' and h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "h.reg_date>='$date_from' and h.reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "h.reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "h.reg_date>='$date_from'";
		}
	}
	else if ($report_for == 2) {    //renewed member
		$where[] = "h.entry_type = '2' and h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "h.reg_date>='$date_from' and h.reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "h.reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "h.reg_date>='$date_from'";
		}
	}
	else if($report_for == 3 ){
		$where[]= "\n h.reg_year_id = (select max(id) from #__member_reg_year where id<'$last_reg_year_id' )"
		."\n and member_id not in (select member_id from #__member_history"
		."\n where reg_year_id = '$last_reg_year_id')"
		."\n and (h.entry_type='1' or h.entry_type='2')"
		;
	}

	ReportTitle($pdf, $FOR, $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center',$reporting_period);

	$query = "select distinct(m.id) as id, m.firm_name as firm_name, m.tin as tin, m.trade_licence_no as trade_licence_no "
	."\n ,m.type_id as type_id ,h.member_reg_no as membershipno, h.reg_year_id as last_reg_year_id"
	."\n ,c.renewal_fee as renewal_fee, mt.name as member_type "
	."\n ,m.firm_phone as phone, m.firm_mobile as mobile, m.firm_fax as fax"
	."\n ,ades.name as applicantdesignation , m.applicant_name as applicantname"
	."\n ,m.applicant_title as applicanttitle, m.applicant_last_name as applicantlastname"
	."\n ,m.firm_reg_address_street as street"
	."\n ,m.firm_reg_address_town_suburb as town, m.firm_reg_address_district as district"
	."\n ,m.applicant_photograph as photograph from #__member as m "
	."\n left join #__member_type as mt on m.type_id=mt.id"
	."\n LEFT JOIN #__member_history AS h ON h.member_id = m.id"
	."\n left join #__designation as ades on ades.id=m.applicant_designation"
	."\n LEFT JOIN #__member_charge AS c ON c.member_type_id = m.type_id and c.reg_year_id='$last_reg_year_id'"
	."\n where m.is_delete =0 "
	. ( count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
	."\n ORDER BY h.member_reg_no"
	;
	//$pdf->ezText($query,10);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();


	$i=1;
	$data=array();
	$grand_total=0;
	foreach($rows as $row){

		$renewal_fee=$row->renewal_fee;
		$grand_total=$grand_total+$renewal_fee;
		//common for all
		$SLNO=$i;
		//$applicant=$row->name;
		$address=$row->street;
		$address.= trim($row->town)!="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?", ".$row->district:"";
		$tin = $row->tin;
		$trade_licence_no = $row->trade_licence_no;
		$membershipno=$row->membershipno."\n\n\n\n";

		$photograph='./administrator/images/photograph/'.$row->id.'/'.strtolower($row->photograph);
		$col1= strip_tags( $row->firm_name."\n".$address );
		$col1= decodeHTML( $col1 );
		$contact= (trim($row->mobile) == "") ? "" :"Mobile: ".$row->mobile ;
		$contact.= $contact == "" ? "" : "\n" ;
		$contact.=  $row->phone == "" ? "" :"Tel: ".$row->phone ;
		$contact.= $contact == "" ? "" : "\n" ;
		$contact.= $row->fax == "" ? "" :"Fax: ".$row->fax ;
		$contact= decodeHTML( $contact );
		{
			$col4= $row->applicanttitle;
			$col4.= $row->applicantname=""?"":" ".$row->applicantname;
			$col4.= $row->applicantlastname=""?"":" ".$row->applicantlastname;

			//$col4.= $col4 == "" ? "" : "\n" ;

			$col4.= $row->applicantdesignation == "" ? "" :"\n".$row->applicantdesignation ;


		}

		$col4= decodeHTML( $col4 );
		$member_type=$row->member_type;
		$member_type= decodeHTML($member_type);

		if($report_for>=0 && $report_for<3){    //prepare array for New and Renewal Member
			if ($type_id==0)// when member type is all
			{
				if ($office_copy==1){ // for office copy
					$arr=array( 'SLNO'=>stripslashes($SLNO)
					,'membershipno'=>stripslashes($membershipno)
					,'firm_name'=>stripslashes($col1)
					,'member_type'=> stripcslashes($member_type)
					,'contact'=>stripslashes($contact)
					,'tin'=>stripslashes($tin)
					,'trade_licence_no'=>stripslashes($trade_licence_no)
					,'applicant'=>stripslashes($col4)
					,'photograph'=>$photograph
					);

				}
				else{   // for outside clients
					$arr=array( 'SLNO'=>stripslashes($SLNO)
					,'membershipno'=>stripslashes($membershipno)
					,'firm_name'=>stripslashes($col1)
					,'member_type'=> stripcslashes($member_type)
					,'contact'=>stripslashes($contact)
					,'applicant'=>stripslashes($col4)
					,'photograph'=>$photograph
					);

				}


			}
			else
			{
				if ($office_copy==1){  // for office copy
					$arr=array( 'SLNO'=>stripslashes($SLNO)
					,'membershipno'=>stripslashes($membershipno)
					,'firm_name'=>stripslashes($col1)
					,'contact'=>stripslashes($contact)
					,'tin'=>stripslashes($tin)
					,'trade_licence_no'=>stripslashes($trade_licence_no)
					,'applicant'=>stripslashes($col4)
					,'photograph'=>$photograph
					);
				}
				else{ // for outside clients
					$arr=array( 'SLNO'=>stripslashes($SLNO)
					,'membershipno'=>stripslashes($membershipno)
					,'firm_name'=>stripslashes($col1)
					,'contact'=>stripslashes($contact)
					,'applicant'=>stripslashes($col4)
					,'photograph'=>$photograph
					);
				}

			}
		}
		else{ //prepare array for outstanding Member
			if($type_id==0) // when member type is all
			{
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'membershipno'=>stripslashes($membershipno)
				,'firm_name'=>stripslashes($col1)
				,'member_type'=> stripcslashes($member_type)

				,'contact'=>stripslashes($contact)
				,'applicant'=>stripslashes($col4)
				//,'dues'=>$renewal_fee
				);


			}
			else
			{
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'membershipno'=>stripslashes($membershipno)
				,'firm_name'=>stripslashes($col1)
				,'contact'=>stripslashes($contact)
				,'applicant'=>stripslashes($col4)
				// ,'dues'=>$renewal_fee
				);
			}
		}

		array_push($data,$arr);

		$i++;
	}
	if($report_for>=0 && $report_for<3){
		//prepare col title for new and renewal member
		if ($type_id==0)  // all type of member
		{
			if ($office_copy==1){  // for office copy
				$cols = array('SLNO'=>"Sl.",
				'membershipno'=>'Mem. Code',
				'firm_name'=>'Name of the Firm',
				'member_type'=>'Member Type',
				'contact'=>'Mobile, Phone, Fax',
				'tin'=>'TIN No.',
				'trade_licence_no'=>'Trade License No.',
				//'applicant'=>'Name of the Representative',
				'applicant'=>'Name of the Applicant',
				'photograph'=>'Photo'
				);

				$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7), 'xPos'=>580,'xOrientation'=>'left','width'=>570,
				'cols'=>array(
				'SLNO'=>array('justification'=>'left','width'=>35),
				'membershipno'=>array('justification'=>'left','width'=>60),
				'firm_name'=>array('justification'=>'left','width'=>80),
				'member_type'=>array('justification'=>'left','width'=>50),
				'contact'=>array('justification'=>'left','width'=>80),
				'tin'=>array('justification'=>'left','width'=>70),
				'trade_licence_no'=>array('justification'=>'left','width'=>50),
				'applicant'=>array('justification'=>'left','width'=>85),
				'photograph'=>array('justification'=>'left','width'=>50),
				)), 9);
			}
			else{  // for outside clients
				$cols = array('SLNO'=>"Sl.",
				'membershipno'=>'Mem. Code',
				'firm_name'=>'Name of the Firm',
				'member_type'=>'Member Type',
				'contact'=>'Mobile, Phone, Fax',
				//'applicant'=>'Name of the Representative',
				'applicant'=>'Name of the Applicant',
				'photograph'=>'Photo'
				);

				$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7), 'xPos'=>580,'xOrientation'=>'left','width'=>570,
				'cols'=>array(
				'SLNO'=>array('justification'=>'left','width'=>35),
				'membershipno'=>array('justification'=>'left','width'=>60),
				'firm_name'=>array('justification'=>'left','width'=>150),
				'member_type'=>array('justification'=>'left','width'=>50),
				'contact'=>array('justification'=>'left','width'=>100),
				'applicant'=>array('justification'=>'left','width'=>115),
				'photograph'=>array('justification'=>'left','width'=>50),
				)), 9);
			}
		}
		else
		{
			if ($office_copy==1){  // for office copy
				$cols = array('SLNO'=>"Sl.",
				'membershipno'=>'Mem. Code',
				'firm_name'=>'Name of the Firm',
				'contact'=>'Mobile, Phone, Fax',
				'tin'=>'TIN No.',
				'trade_licence_no'=>'Trade License No.',
				//'applicant'=>'Name of the Representative',
				'applicant'=>'Name of the Applicant',
				'photograph'=>'Photo'
				);
				//generate table for new and renewal member

				$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7), 'xPos'=>580,'xOrientation'=>'left','width'=>570,
				'cols'=>array(
				'SLNO'=>array('justification'=>'left','width'=>35),
				'membershipno'=>array('justification'=>'left','width'=>60),
				'firm_name'=>array('justification'=>'left','width'=>80),
				'contact'=>array('justification'=>'left','width'=>100),
				'tin'=>array('justification'=>'left','width'=>70),
				'trade_licence_no'=>array('justification'=>'left','width'=>65),
				'applicant'=>array('justification'=>'left','width'=>100),
				'photograph'=>array('justification'=>'left','width'=>50),
				)), 9);
			}
			else{  // for outside clients
				$cols = array('SLNO'=>"Sl.",
				'membershipno'=>'Mem. Code',
				'firm_name'=>'Name of the Firm',
				'contact'=>'Mobile, Phone, Fax',
				//'applicant'=>'Name of the Representative',
				'applicant'=>'Name of the Applicant',
				'photograph'=>'Photo'
				);
				//generate table for new and renewal member

				$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7), 'xPos'=>580,'xOrientation'=>'left','width'=>570,
				'cols'=>array(
				'SLNO'=>array('justification'=>'left','width'=>35),
				'membershipno'=>array('justification'=>'left','width'=>60),
				'firm_name'=>array('justification'=>'left','width'=>170),
				'contact'=>array('justification'=>'left','width'=>100),
				'applicant'=>array('justification'=>'left','width'=>115),
				'photograph'=>array('justification'=>'left','width'=>50),
				)), 9);
			}
		}

	}
	else{
		//prepare col title for outstanding member
		if($type_id==0) //when member type is all
		{
			$cols = array('SLNO'=>"Sl.",
			'membershipno'=>'Mem. Code',
			'firm_name'=>'Name of Firm',
			'member_type'=>'Member Type',
			'contact'=>'Mobile, Phone, Fax',
			//'applicant'=>'Name of the Representative',
			'applicant'=>'Name of the Applicant',
			//'dues'=>'Dues (Tk.)'
			);

			$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>580,'xOrientation'=>'left','width'=>570,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>35),
			'membershipno'=>array('justification'=>'left','width'=>60),
			'firm_name'=>array('justification'=>'left','width'=>140),
			'member_type'=>array('justification'=>'left','width'=>60),

			'contact'=>array('justification'=>'left','width'=>120),
			'applicant'=>array('justification'=>'left','width'=>135),
			//'dues'=>array('justification'=>'left','width'=>50),
			)), 9);


		}

		else
		{
			$cols = array('SLNO'=>"Sl.",
			'membershipno'=>'Mem. Code',
			'firm_name'=>'Name of Firm',
			'contact'=>'Mobile, Phone, Fax',
			//'applicant'=>'Name of the Representative',
			'applicant'=>'Name of the Applicant',
			//'dues'=>'Dues (Tk.)'
			);
			$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>580,'xOrientation'=>'left','width'=>570,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>35),
			'membershipno'=>array('justification'=>'left','width'=>60),
			'firm_name'=>array('justification'=>'left','width'=>170),
			'contact'=>array('justification'=>'left','width'=>120),
			'applicant'=>array('justification'=>'left','width'=>145),
			//'dues'=>array('justification'=>'left','width'=>50),
			)), 9);

		}

		//generate table for outstanding member

		$pdf->ezText( "", 10 );
		//$pdf->ezText( "Total Dues: Tk. ".$grand_total, 10 );

	}


	//end of logic

	// footer
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}
// Type two member report scci
function MemberReportScci_forApproval ( ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//this is the start of the logic to get the search result
	$year = date('Y');
	$type_id     = intval( mosGetParam( $_REQUEST, 'type_id' ));
	$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));
	$office_copy  = intval( mosGetParam( $_REQUEST, 'office_copy'));
	$last_reg_year_id   = trim( mosGetParam( $_REQUEST, 'last_reg_year_id' ));
	$membership_no     =  mosGetParam( $_REQUEST, 'membership_no' );

	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);

	$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
	$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);
	//Header
	$TITLE="List of All Members ";
	$NAME=_CHAMBER_NAME_SCCI;
	$ADDRESS=_ADDRESS_SCCI;
	$CONTACT=_CONTACT_NUMBER_SCCI;
	$EMAIL=_EMAIL_SCCI;


	$where = array();

	if ($type_id > 0  ) {
		$where[] = "m.type_id='$type_id'";
		$type_name = $database->getMemberTypeName($type_id);
		$TITLE=$type_name." List for the ";
	}
	else {
		$TITLE="List of All Members  for the ";
	}

	$sql="select name from #__member_reg_year where id='$last_reg_year_id'";
	$database->setQuery($sql);
	$TITLE.=$database->loadResult();

	if ($membership_no!=""){
		$members1=explode(",",$membership_no);
		$members2=array();

		for ($i=0;$i<count($members1);$i++){
			if(trim($members1)!=""){
				if (strpos($members1[$i],'-',0)){
					$temp=explode("-",$members1[$i]);
					if ($temp[0]>$temp[1]){
						$t=$temp[0];
						$temp[0]=$temp[1];
						$temp[1]=$t;
					}
					for ($j=intval($temp[0]);$j<=intval($temp[1]);$j++){
						if (is_numeric($j))
						array_push($members2,$j);
					}
				}
				else{
					if (is_numeric($members1[$i]))
					array_push($members2,$members1[$i]);
				}
			}
		}

		/*  for ($i=0;$i<count($members2);$i++){
		for ($j=$i+1;$j<count($members2);$j++){
		if ($members2[$i]==$members2[$j]){
		for ($k=$j;$k<count($members2);$k++){
		$members2[$k]=$members2[$k+1];
		}
		}
		}
		} */
		$members=implode(',',$members2);
		if (sizeof($members2)>0)
		$where[] = "m.member_reg_no IN ($members)";
	}


	if ($report_for == 0) {    //All member
		$where[] = "h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "( ( h.reg_date>='$date_from' and h.reg_date<='$date_to' and h.entry_type = 1 ) || ( h.reg_date>='$date_from' and h.reg_date<='$date_to' and h.entry_type = 2 ))";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "( h.reg_date<='$date_to' || h.reg_date<='$date_to' )";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "( h.reg_date>='$date_from' || h.reg_date>='$date_from' )";
		}
	}
	else if ($report_for == 1) {    //new member
		$where[] = "h.entry_type = '1' and h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "h.reg_date>='$date_from' and h.reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "h.reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "h.reg_date>='$date_from'";
		}
	}
	else if ($report_for == 2) {    //renewed member
		$where[] = "h.entry_type = '2' and h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "h.reg_date>='$date_from' and h.reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "h.reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "h.reg_date>='$date_from'";
		}
	}

	ReportTitle($pdf, "scci", $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center',$reporting_period);

	$query = "select distinct(m.id) as id, m.firm_name as firm_name, m.tin as tin, m.trade_licence_no as trade_licence_no "
	."\n ,m.type_id as type_id ,h.member_reg_no as membershipno, h.reg_year_id as last_reg_year_id"
	//."\n ,c.renewal_fee as renewal_fee, mt.name as member_type "
	."\n , mt.name as member_type,m.trade_licence_issued_by as trade_licence_issued_by "
	."\n ,m.firm_phone as phone, m.firm_mobile as mobile, m.firm_fax as fax"
	."\n ,ades.name as applicantdesignation , m.applicant_name as applicantname"
	."\n ,m.applicant_title as applicanttitle, m.applicant_last_name as applicantlastname"
	."\n ,m.firm_reg_address_street as street,m.trade_licence_expire_date as trade_licence_expire_date "
	."\n ,m.firm_reg_address_town_suburb as town, m.firm_reg_address_district as district"
	."\n ,m.applicant_photograph as photograph from #__member as m "
	."\n left join #__member_type as mt on m.type_id=mt.id"
	."\n LEFT JOIN #__member_history AS h ON h.member_id = m.id"
	."\n left join #__designation as ades on ades.id=m.applicant_designation"
	//."\n LEFT JOIN #__member_charge AS c ON c.member_type_id = m.type_id and c.reg_year_id='$last_reg_year_id'"
	."\n where m.is_delete =0 "
	. ( count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
	."\n ORDER BY h.member_reg_no"
	;
	//$pdf->ezText($query,10);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();


	$i=1;
	$data=array();
	foreach($rows as $row){


		//common for all
		$SLNO=$i;
		//$applicant=$row->name;
		$address=$row->street;
		$address.= trim($row->town)!="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?", ".$row->district:"";
		$tin = $row->tin;
		$trade_licence_no = $row->trade_licence_no;

		$col4= $row->applicanttitle;
		$col4.= $row->applicantname=""?"":" ".$row->applicantname;
		$col4.= $row->applicantlastname=""?"":" ".$row->applicantlastname;
		$col4= decodeHTML( $col4 );

		//$photograph='./administrator/images/photograph/'.$row->id.'/'.strtolower($row->photograph);
		$col1= strip_tags( $row->firm_name."\n".$col4."\n".$address );
		$col1= decodeHTML( $col1 );
		$contact= (trim($row->mobile) == "") ? "" :"Mobile: ".$row->mobile ;
		$contact.= $contact == "" ? "" : "\n" ;
		$contact.=  $row->phone == "" ? "" :"Tel: ".$row->phone ;
		$contact.= $contact == "" ? "" : "\n" ;
		$contact.= $row->fax == "" ? "" :"Fax: ".$row->fax ;
		$contact= decodeHTML( $contact );
		$trade_licence_issued_by=$row->trade_licence_issued_by;
		$trade_licence_expire_date=$mosHtmlObj->ConvertDateDisplayShort($row->trade_licence_expire_date);
		$member_type=$row->member_type;
		$member_type= decodeHTML($member_type);
		$trade_licence=trim($trade_licence_issued_by)?$trade_licence_issued_by:"";
		$trade_licence.=$trade_licence?"\n".$trade_licence_no:$trade_licence_no;
		$trade_licence.=$trade_licence_expire_date?"\n".$trade_licence_expire_date:"";
		if($report_for>=0 && $report_for<3){    //prepare array for New and Renewal Member
			if ($type_id==0)// when member type is all
			{
				if ($office_copy==1){ // for office copy
					$arr=array( 'SLNO'=>stripslashes($SLNO)
					,'firm_name'=>stripslashes($col1)
					,'trade_licence'=>stripslashes($trade_licence)
					,'tin'=>stripslashes($tin)
					,'member_type'=> stripcslashes($member_type)
					,'remarks'=>''
					);

				}
				else{   // for outside clients
					$arr=array( 'SLNO'=>stripslashes($SLNO)
					,'firm_name'=>stripslashes($col1)
					,'trade_licence'=>stripslashes($trade_licence)
					,'tin'=>stripslashes($tin)
					,'member_type'=> stripcslashes($member_type)
					,'remarks'=>''
					);

				}


			}
			else
			{
				if ($office_copy==1){  // for office copy
					$arr=array( 'SLNO'=>stripslashes($SLNO)
					,'firm_name'=>stripslashes($col1)
					,'trade_licence'=>stripslashes($trade_licence)
					,'tin'=>stripslashes($tin)
					,'member_type'=> stripcslashes($member_type)
					,'remarks'=>''
					);
				}
				else{ // for outside clients
					$arr=array( 'SLNO'=>stripslashes($SLNO)
					,'firm_name'=>stripslashes($col1)
					,'trade_licence'=>stripslashes($trade_licence)
					,'tin'=>stripslashes($tin)
					,'member_type'=> stripcslashes($member_type)
					,'remarks'=>''
					);
				}

			}
		}


		array_push($data,$arr);

		$i++;
	}
	if($report_for>=0 && $report_for<3){
		//prepare col title for new and renewal member
		$tmp='Trade License Issuing Authority,  Number, Expiry Date';
		if ($type_id==0)  // all type of member
		{
			if ($office_copy==1){  // for office copy
				$cols = array('SLNO'=>"Sl #",
				'firm_name'=>'Name of the Firm and Address',
				'trade_licence'=>$tmp,
				'tin'=>'TIN #',
				'member_type'=>'Membership Category',
				'remarks'=>'Remarks'
				);

				$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7), 'xPos'=>580,'xOrientation'=>'left','width'=>570,
				'cols'=>array(
				'SLNO'=>array('justification'=>'left','width'=>40),
				'firm_name'=>array('justification'=>'left','width'=>150),
				'trade_licence'=>array('justification'=>'left','width'=>150),
				'tin'=>array('justification'=>'left','width'=>100),
				'member_type'=>array('justification'=>'left','width'=>80),
				'remarks'=>array('justification'=>'left','width'=>50),
				)), 9);
			}
			else{  // for outside clients
				$cols = array('SLNO'=>"Sl #",
				'firm_name'=>'Name of the Firm and Address',
				'trade_licence'=>$tmp,
				'tin'=>'TIN #',
				'member_type'=>'Membership Category',
				'remarks'=>'Remarks'
				);

				$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7), 'xPos'=>580,'xOrientation'=>'left','width'=>570,
				'cols'=>array(
				'SLNO'=>array('justification'=>'left','width'=>40),
				'firm_name'=>array('justification'=>'left','width'=>150),
				'trade_licence'=>array('justification'=>'left','width'=>150),
				'tin'=>array('justification'=>'left','width'=>100),
				'member_type'=>array('justification'=>'left','width'=>80),
				'remarks'=>array('justification'=>'left','width'=>50),
				)), 9);
			}
		}
		else
		{
			if ($office_copy==1){  // for office copy
				$cols = array('SLNO'=>"Sl #",
				'firm_name'=>'Name of the Firm and Address',
				'trade_licence'=>$tmp,
				'tin'=>'TIN #',
				'member_type'=>'Membership Category',
				'remarks'=>'Remarks'
				);

				$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7), 'xPos'=>580,'xOrientation'=>'left','width'=>570,
				'cols'=>array(
				'SLNO'=>array('justification'=>'left','width'=>40),
				'firm_name'=>array('justification'=>'left','width'=>150),
				'trade_licence'=>array('justification'=>'left','width'=>150),
				'tin'=>array('justification'=>'left','width'=>100),
				'member_type'=>array('justification'=>'left','width'=>80),
				'remarks'=>array('justification'=>'left','width'=>50),
				)), 9);
			}
			else{  // for outside clients
				$cols = array('SLNO'=>"Sl #",
				'firm_name'=>'Name of the Firm and Address',
				'trade_licence'=>$tmp,
				'tin'=>'TIN #',
				'member_type'=>'Membership Category',
				'remarks'=>'Remarks'
				);

				$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7), 'xPos'=>580,'xOrientation'=>'left','width'=>570,
				'cols'=>array(
				'SLNO'=>array('justification'=>'left','width'=>40),
				'firm_name'=>array('justification'=>'left','width'=>150),
				'trade_licence'=>array('justification'=>'left','width'=>150),
				'tin'=>array('justification'=>'left','width'=>100),
				'member_type'=>array('justification'=>'left','width'=>80),
				'remarks'=>array('justification'=>'left','width'=>50),
				)), 9);
			}
		}

	}

	//end of logic

	// footer
	//$pdf->ezText( $members, 10 );
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}

function MailMergeScci ( $FOR ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//this is the start of the logic to get the search result
	$year = date('Y');
	$type_id     = intval( mosGetParam( $_REQUEST, 'type_id' ));
	$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));
	$last_reg_year_id   = trim( mosGetParam( $_REQUEST, 'last_reg_year_id' ));

	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);

	$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
	$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);



	//Header
	$TITLE="List Of ALL Members";
	$NAME=_CHAMBER_NAME_SCCI;
	$ADDRESS=_ADDRESS_SCCI;
	$CONTACT=_CONTACT_NUMBER_SCCI;
	$EMAIL=_EMAIL_SCCI;


	$where = array();

	if ($type_id > 0  ) {
		$where[] = "m.type_id='$type_id'";
		$type_name = $database->getMemberTypeName($type_id);
		$TITLE=$type_name." Mailing List for the ";
	}
	else {
		$TITLE="Mailing List  for the ";
	}

	$sql="select name from #__member_reg_year where id='$last_reg_year_id'";
	$database->setQuery($sql);
	$TITLE.=$database->loadResult();
	$membership_no = $_REQUEST['membership_no'];

	if ($membership_no!=""){
		$members1=explode(",",$membership_no);
		$members2=array();

		for ($i=0;$i<count($members1);$i++){
			if(trim($members1)!=""){
				if (strpos($members1[$i],'-',0)){
					$temp=explode("-",$members1[$i]);
					if ($temp[0]>$temp[1]){
						$t=$temp[0];
						$temp[0]=$temp[1];
						$temp[1]=$t;
					}
					for ($j=intval($temp[0]);$j<=intval($temp[1]);$j++){
						if (is_numeric($j))
						array_push($members2,$j);
					}
				}
				else{
					if (is_numeric($members1[$i]))
					array_push($members2,$members1[$i]);
				}
			}
		}

		/*  for ($i=0;$i<count($members2);$i++){
		for ($j=$i+1;$j<count($members2);$j++){
		if ($members2[$i]==$members2[$j]){
		for ($k=$j;$k<count($members2);$k++){
		$members2[$k]=$members2[$k+1];
		}
		}
		}
		} */
		$members=implode(',',$members2);
		if (sizeof($members2)>0)
		$where[] = "m.member_reg_no IN ($members)";
	}


	if ($report_for == 0) {    //All member
		$where[] = "h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "( ( h.reg_date>='$date_from' and h.reg_date<='$date_to' and h.entry_type = 1 ) || ( h.reg_date>='$date_from' and h.reg_date<='$date_to' and h.entry_type = 2 ))";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "( h.reg_date<='$date_to' || h.reg_date<='$date_to' )";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "( h.reg_date>='$date_from' || h.reg_date>='$date_from' )";
		}
	}
	else if ($report_for == 1) {    //new member
		$where[] = "h.entry_type = '1' and h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "h.reg_date>='$date_from' and h.reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "h.reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "h.reg_date>='$date_from'";
		}
	}
	else if ($report_for == 2) {    //renewed member
		$where[] = "h.entry_type = '2' and h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "h.reg_date>='$date_from' and h.reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "h.reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "h.reg_date>='$date_from'";
		}
	}
	else if($report_for == 3 ){
		$where[]= "\n h.reg_year_id = (select max(id) from #__member_reg_year where id<'$last_reg_year_id' )"
		."\n and member_id not in (select member_id from #__member_history"
		."\n where reg_year_id = '$last_reg_year_id')"
		."\n and (h.entry_type='1' or h.entry_type='2')"
		;
	}

	ReportTitle($pdf, $FOR, $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center',$reporting_period);
	$pdf->line( 6, 700, 575, 700 );
	$query = "select distinct(m.id) as id, m.firm_name as firm_name "
	//."\n , m.representative_title as title, m.representative_name as representative"
	//."\n , m.representative_last_name as representativelastname"
	."\n , m.applicant_title as title, m.applicant_name as applicant"
	."\n , m.applicant_last_name as applicantlastname"
	."\n , m.firm_reg_address_street as street"
	."\n , m.firm_reg_address_town_suburb as town, m.firm_reg_address_district as district"
	//."\n , m.firm_reg_address_division as division, m.firm_reg_address_country as country"
	."\n from #__member as m "
	."\n left join #__member_type as mt on m.type_id=mt.id"
	."\n LEFT JOIN #__member_history AS h ON h.member_id = m.id"
	//."\n left join #__designation as pdes on pdes.id=m.principal_nominee_designation"
	//."\n left join #__designation as ades on ades.id=m.alt_nominee_designation"
	."\n left join #__designation as rdes on rdes.id=m.representative_designation"
	//."\n LEFT JOIN #__member_charge AS c ON c.member_type_id = m.type_id and c.reg_year_id='$last_reg_year_id'"
	."\n where m.is_delete =0 "
	. ( count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
	."\n ORDER BY h.member_reg_no "
	;
	//$pdf->ezText($query);
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	$space_left="  ";
	$j=1;
	$data=array();
	for($i=0; $i<count($rows); $i++){
		$SLNO=$j;
		$row=$rows[$i];
		/*$name= $row->title;
		$name.= $row->representative!=""?" ".$row->representative:"";
		$name.= $row->representativelastname!=""?" ".$row->representativelastname:"";
		*/
		$name= $row->title!=""?$SLNO.". ":"";
		$name.= $row->title;
		$name.= $row->applicant!=""?" ".$row->applicant:"";
		$name.= $row->applicantlastname!=""?" ".$row->applicantlastname:"";

		$firm_name= strip_tags( $row->firm_name );
		$address=$row->street;
		$address.= trim($row->town)!="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?", ".$row->district:"";
		//$address.= trim($row->division)!="" ?", ".$row->division:"";
		//$address.= trim($row->country)!="" ?", ".$row->country:"";
		$col1="\n".$name."\n".$firm_name."\n".$address."\n";
		$col1= strip_tags( $col1 );
		$col1= decodeHTML( $col1 );
		//array_push($data,$arr);

		$i++;
		$SLNO=++$j;
		$row=$rows[$i];
		/*$name= $row->title;
		$name.= $row->representative!=""?" ".$row->representative:"";
		$name.= $row->representativelastname!=""?" ".$row->representativelastname:"";
		*/
		$name= $row->title!=""?$SLNO.". ":"";
		$name.= $row->title;
		$name.= $row->applicant!=""?" ".$row->applicant:"";
		$name.= $row->applicantlastname!=""?" ".$row->applicantlastname:"";

		$firm_name= strip_tags( $row->firm_name );
		$address=$row->street;
		$address.= trim($row->town)!="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?", ".$row->district:"";
		//$address.= trim($row->division)!="" ?", ".$row->division:"";
		//$address.= trim($row->country)!="" ?", ".$row->country:"";
		$col2="\n".$name."\n".$firm_name."\n".$address."\n";
		$col2= strip_tags( $col2 );
		$col2= decodeHTML( $col2 );

		$name = "";
		$firm_name = "";
		$address = "";
		$i++;
		$SLNO=++$j;
		$row=$rows[$i];
		/*$name= $row->title;
		$name.= $row->representative!=""?" ".$row->representative:"";
		$name.= $row->representativelastname!=""?" ".$row->representativelastname:"";
		*/
		$name= $row->title!=""?$SLNO.". ":"";
		$name.= $row->title;
		$name.= $row->applicant!=""?" ".$row->applicant:"";
		$name.= $row->applicantlastname!=""?" ".$row->applicantlastname:"";

		$firm_name= strip_tags( $row->firm_name );
		$address=$row->street;
		$address.= trim($row->town)!="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?", ".$row->district:"";
		//$address.= trim($row->division)!="" ?", ".$row->division:"";
		//$address.= trim($row->country)!="" ?", ".$row->country:"";
		$col3="\n".$name."\n".$firm_name."\n".$address."\n";
		$col3= strip_tags( $col3 );
		$col3= decodeHTML( $col3 );

		$arr=array( 'col1'=>stripslashes($col1)
		,'col2'=>stripslashes($col2)
		,'col3'=>stripslashes($col3)
		);
		array_push($data,$arr);
		$j++;
	}
	$cols = array( 'col1'=>'',
	'col2'=>'',
	'col3'=>''
	);

	$pdf->ezTable($data,$cols,'',array('showLines'=>1, 'showHeadings'=>0,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7), 'xPos'=>580,'xOrientation'=>'left','width'=>570,
	'cols'=>array(
	'col1'=>array('justification'=>'left','width'=>190),
	'col2'=>array('justification'=>'left','width'=>190),
	'col3'=>array('justification'=>'left','width'=>190))
	), 9);

	//end of logic

	// footer
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}

function Memberprofile($mid)
{

	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	//$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//this is the start of the logic to get the search result

	$query=  "select m.*, mt.name as member_type,mc.country_name as country_name "
	."\n ,ml.location as location from #__member as m"
	."\n left join #__pshop_country as mc on m.country_id=mc.country_id"
	."\n left join #__member_type as mt  on m.type_id =mt.id"
	."\n left join #__member_location as ml on m.location =ml.id"
	."\n where m.id='$mid'"
	;


	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	//Header
	$NAME=_CHAMBER_NAME_SCCI;
	$ADDRESS=_ADDRESS_SCCI;
	$CONTACT=_CONTACT_NUMBER_SCCI;
	$EMAIL=_EMAIL_SCCI;

	ReportTitle($pdf, 'scci', $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center');

	$pdf->ezText("\n"."Details"."\n", 12,array('justification'=>'center'));
	$pdf->ezText("Member Type : ".$rows[0]->member_type, 8);
	$pdf->ezText("Registration Number : ".$rows[0]->member_reg_no, 8);
	$pdf->ezText("Registration Date : ".mosHTML::ConvertDateDisplayLong($rows[0]->reg_date), 8);

	$pdf->ezText("\n"."Applicant Firm Information"."\n", 12,array('justification'=>'center'));
	$pdf->ezText("Name of the Firm : ".$rows[0]->firm_name, 8);

	$address=$rows[0]->firm_reg_address_street;
	$address.= trim($rows[0]->firm_reg_address_town_suburb)!="" ?", ".$rows[0]->firm_reg_address_town_suburb:"";
	$address.= trim($rows[0]->firm_reg_address_district)!="" ?", ".$rows[0]->firm_reg_address_district:"";
	$address.= trim($rows[0]->firm_reg_address_division)!="" ?", ".$rows[0]->firm_reg_address_division :"";
	$address.= trim($rows[0]->firm_reg_address_country)!="" ?", ".$rows[0]->firm_reg_address_country:"";
	$pdf->ezText("Firm Address : ".$address, 8);
	$pdf->ezText("Phone : ".$rows[0]->firm_phone."    Fax  :".$rows[0]->firm_fax, 8);

	$pdf->ezText("Email Address : ".$rows[0]->firm_email, 8);
	$pdf->ezText("Web Address : ".$rows[0]->firm_web, 8);

	$pdf->ezText("\n"."Head Office/Mailimg Address "."\n", 12, array('justification'=>'center'));
	$address=$rows[0]->head_office_address_street ;
	$address.= trim($rows[0]->head_office_address_town_suburb)!="" ?", ".$rows[0]->head_office_address_town_suburb:"";
	$address.= trim($rows[0]->head_office_address_district)!="" ?", ".$rows[0]->head_office_address_district:"";
	$address.= trim($rows[0]->head_office_address_division)!="" ?", ".$rows[0]->head_office_address_division :"";
	$address.= trim($rows[0]->head_office_address_country)!="" ?", ".$rows[0]->head_office_address_country:"";

	$pdf->ezText("Head Office/ Mailing Address  : ".$address, 8);
	$pdf->ezText("Phone : ".$rows[0]->head_office_phone."    Fax  :".$rows[0]->head_office_fax, 8);
	$pdf->ezText("Email Address : ".$rows[0]->head_office_email, 8);
	$pdf->ezText("Web Address : ".$rows[0]->head_office_web, 8);

	$pdf->ezText("No of Employee : Male :".$rows[0]->employee_male."  Female :".$rows[0]->employee_female."  Total: ".$rows[0]->employee_total, 8);
	$pdf->ezText("Production Capacity : ".$rows[0]->production_capacity, 8);
	$pdf->ezText("Corporate Status : ".$rows[0]->corporate_status, 8);
	$pdf->ezText("Established Year : ".$rows[0]->establishment_year, 8);
	$pdf->ezText("Country of Incorporation : ".$rows[0]->country_name, 8);
	$pdf->ezText("Location : ".$rows[0]->location, 8);

	$pdf->ezText("Name of the proprietor : ".$rows[0]->applicant_name, 8);
	$pdf->ezText("Designation : ".$rows[0]->applicant_designation, 8);

	$pdf->ezText("Name of the Representative  : ".$rows[0]->representative_name, 8);
	$pdf->ezText("Designation  : ".$rows[0]->representative_designation, 8);

	$pdf->ezText("Name of the Principal Nominee : ".$rows[0]->principal_nominee_name, 8);

	$pdf->ezText("Designation : ".$rows[0]->principal_nominee_designation, 8);

	$pdf->ezText("Money Receipt No: ".$rows[0]->money_receipt_no, 8);
	$pdf->ezText("Bank Name : ".$rows[0]->bank_name, 8);
	$pdf->ezText("Bank Address : ".$rows[0]->bank_address, 8);


	$pdf->ezText("\n"."Trade License Information"."\n", 12,array('justification'=>'center'));
	$pdf->ezText("Trade License Number : ".$rows[0]->trade_licence_no, 8);
	$pdf->ezText("Name of the Issued Authority  : ".$rows[0]->trade_licence_issued_by, 8);
	$pdf->ezText("Issue Date : ".mosHTML::ConvertDateDisplayLong($rows[0]->trade_licence_issue_date), 8);
	$pdf->ezText("Expiry Date : ".mosHTML::ConvertDateDisplayLong($rows[0]->trade_licence_expire_date), 8);




	$pdf->ezText("Impoter Reg. No  : ".$rows[0]->import_reg_no, 8);
	$pdf->ezText("Expoter Reg. No : ".$rows[0]->export_reg_no, 8);
	$pdf->ezText("Indenting Trade Number  : ".$rows[0]->indenting_trade_no, 8);
	$pdf->ezText("Tax Payers Identification number(TIN)  : ".$rows[0]->tin, 8);
	$pdf->ezText("Registration Number under Factories Act : ".$rows[0]->factory_act_reg_no, 8);


	$pdf->ezText("\n"."Proposer Information"."\n", 12,array('justification'=>'center'));
	$pdf->ezText("Proposer Name: ".$rows[0]->proposer1_name, 8);
	$pdf->ezText("Address  : ".$rows[0]->proposer1_address, 8);
	$pdf->ezText("Membership No".$rows[0]->proposer1_member_reg_no, 8);
	$pdf->ezText("Seconder Name: ".$rows[0]->proposer2_name, 8);
	$pdf->ezText("Address  : ".$rows[0]->proposer2_address, 8);
	$pdf->ezText("Membership No".$rows[0]->proposer2_member_reg_no, 8);




	//end of logic

	// footer
	ReportFooter($pdf);
	$pdf->ezSetDy( 50 );
	$pdf->ezStream();


}

function Accounts_Transaction_Report ( $FOR='scci' ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;
	$reg_id=$_REQUEST['last_reg_year_id'];

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//Header
	$TITLE="Accounts Transaction Report";
	if(strtolower($FOR)=="bkmea"){
		$NAME    =_CHAMBER_NAME_BKMEA;
		$ADDRESS =_ADDRESS_BKMEA;
		$CONTACT =_CONTACT_NUMBER_BKMEA;
		$EMAIL   =_EMAIL_BKMEA;
	}
	else if(strtolower($FOR)=="ccci"){
		$NAME    =_CHAMBER_NAME_CCCI;
		$ADDRESS =_ADDRESS_CCCI;
		$CONTACT =_CONTACT_NUMBER_CCCI;
		$EMAIL   =_EMAIL_CCCI;
	}
	else if(strtolower($FOR)=="scci"){
		$NAME    ="The "._CHAMBER_NAME_SCCI;
		$ADDRESS =_ADDRESS_SCCI;
		$CONTACT =_CONTACT_NUMBER_SCCI;
		$EMAIL   =_EMAIL_SCCI;
	}


	//this is the start of the logic to get the search result
	$year = date('Y');
	$type_id     = intval( mosGetParam( $_REQUEST, 'type_id' ));
	$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));

	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);

	$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
	$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);
	//$where[] = array();

	if ($date_from!='' && $date_to==''){
		$reporting_period="Reporting Period : From ".$date_from_display;
		$where[] = "DATE_FORMAT(at.transaction_date,'%Y-%m-%d')>='$date_from'";
	}elseif ($date_from=='' && $date_to!=''){
		$reporting_period="Reporting Period : Upto ".$date_to_display;
		$where[] = "DATE_FORMAT(at.transaction_date,'%Y-%m-%d')<='$date_to'";
	}elseif ($date_from!='' && $date_to!=''){
		$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
		$where[] = "DATE_FORMAT(at.transaction_date,'%Y-%m-%d')>='$date_from' and DATE_FORMAT(at.transaction_date,'%Y-%m-%d')<='$date_to'";
	}

	ReportTitle($pdf, $FOR, $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center',$reporting_period);

	if (intval($type_id)>0) {
		$where[] = "m.type_id='$type_id' ";
	}

	if (intval($report_for)==-99){     //summary report
		$query_99_all="select child.name as name, sum(child.amount) as amount"
		."\n from (select m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		."\n left join #__member_history as mh on mh.id=at.reference_no"
		."\n left join #__member as m on m.id=mh.member_id"
		."\n where at.transaction_type=0"
		."\n and at.account_id!='131' and at.account_id!='121' and mh.reg_year_id='$reg_id'"
		//.(intval($report_for)!=0 ?" and at.account_id='$report_for' ":"")
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name,at.transaction_date) as child"
		."\n group by account_id"
		;
		$query_99_121="select child.name as name, sum(child.amount) as amount"
		."\n from (select m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		."\n left join #__member_idcard as mi on mi.id=at.reference_no"
		."\n left join #__member as m on m.id=mi.member_id"
		."\n where at.transaction_type=0  and mi.reg_year_id='$reg_id' "
		."\n and at.account_id='121' "
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name,at.transaction_date) as child"
		."\n group by account_id"
		;
		$query_99_131="select child.name as name, sum(child.amount) as amount"
		."\n from (select m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		."\n left join #__member_certificate as mc on mc.id=at.reference_no"
		."\n left join #__member as m on m.id=mc.member_id"
		."\n where at.transaction_type=0  and mc.reg_year_id='$reg_id'"
		."\n and at.account_id='131' "
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name,at.transaction_date) as child"
		."\n group by account_id"
		;
	}
	else{
		$query_all="select m.type_id as type_id,mh.member_reg_no as membership_code,m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,at.transaction_date as transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		//."\n left join #__member as m on m.id=at.reference_no"
		."\n left join #__member_history as mh on mh.id=at.reference_no"
		."\n left join #__member as m on m.id=mh.member_id"
		."\n where at.transaction_type=0"
		."\n and at.account_id!='131' and at.account_id!='121' and mh.reg_year_id='$reg_id'"
		.(intval($report_for)!=0 ?" and at.account_id='$report_for' ":"")
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name,at.transaction_date"
		;
		$query_121="select m.type_id as type_id,m.member_reg_no as membership_code,m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,at.transaction_date as transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		//."\n left join #__member as m on m.id=at.reference_no"
		."\n left join #__member_idcard as mi on mi.id=at.reference_no"
		."\n left join #__member as m on m.id=mi.member_id"
		."\n where at.transaction_type=0  and mi.reg_year_id='$reg_id' "
		."\n and at.account_id='121' "
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name,at.transaction_date"
		;
		$query_131="select m.type_id as type_id,m.member_reg_no as membership_code,m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,at.transaction_date as transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		//."\n left join #__member as m on m.id=at.reference_no"
		."\n left join #__member_certificate as mc on mc.id=at.reference_no"
		."\n left join #__member as m on m.id=mc.member_id"
		."\n where at.transaction_type=0  and mc.reg_year_id='$reg_id'"
		."\n and at.account_id='131' "
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name,at.transaction_date"
		;
	}

	if($report_for==-99){
		$database->setQuery( $query_99_all );
		$rows = $database->loadObjectList();
		$database->setQuery( $query_99_131 );
		$rows = array_merge($rows,$database->loadObjectList());
		//$pdf->ezText($query_99_131,10);
		$database->setQuery( $query_99_121 );
		$rows = array_merge($rows,$database->loadObjectList());

	}else if(intval($report_for)==0){
		$database->setQuery( $query_all );
		$rows = $database->loadObjectList();
		$database->setQuery( $query_131 );
		$rows = array_merge($rows,$database->loadObjectList());
		$database->setQuery( $query_121 );
		$rows = array_merge($rows,$database->loadObjectList());
		//$pdf->ezText($query_131,10);
	}else if($report_for==131){    //Certificate
		$database->setQuery( $query_131 );
		$rows = $database->loadObjectList();
	}else if($report_for==121){     //Id Card
		$database->setQuery( $query_121 );
		$rows = $database->loadObjectList();
	}else if($report_for!=131 && $report_for!=121){      //admission, enroll, renew
		$database->setQuery( $query_all );
		$rows = $database->loadObjectList();
	}

	$totalRows = count( $rows );
	$i=1;$p_id=0;
	$data=array();
	$amount=0;
	foreach($rows as $row1){
		$SLNO=$i;

		if ($row1->type_id==1)
		$type='G';
		else if ($row1->type_id==2)
		$type='TA';
		else if ($row1->type_id==3)
		$type='O';
		else if ($row1->type_id==4)
		$type='A';

		$membership_code=$type.$row1->membership_code;
		$firm_name=$row1->firm_name;
		$name=$row1->name;
		$amount=$row1->amount;
		$transaction_date=$mosHtmlObj->ConvertDateDisplayShort($row1->transaction_date);
		$amount=$row1->amount;
		$total=$total+$amount;
		$arr=array( 'SLNO'=>stripslashes($SLNO)
		,'membership_code'=>stripslashes($membership_code)
		,'firm_name'=>stripslashes($firm_name)
		,'name'=>stripslashes($name)
		,'transaction_date'=>stripslashes($transaction_date)
		,'amount'=>stripslashes($amount)
		);

		array_push($data,$arr);

		$i++;
	}

	if ($report_for!=-99){ // 99 for summery
		$cols = array( 'SLNO'=>"Sl.",
		'membership_code'=>'Membership Code',
		'firm_name'=>'Firm Name',
		'name'=>'Transaction Type',
		'transaction_date'=>'Transaction Date',
		'amount'=>'Amount (Tk.)'
		);

		$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>570,'xOrientation'=>'left','width'=>540,
		'cols'=>array(
		'SLNO'=>array('justification'=>'left','width'=>50),
		'membership_code'=>array('justification'=>'left','width'=>60),
		'firm_name'=>array('justification'=>'left','width'=>150),
		'name'=>array('justification'=>'left','width'=>120),
		'transaction_date'=>array('justification'=>'center','width'=>80),
		'amount'=>array('justification'=>'right','width'=>70),
		)), 9);
	}
	elseif ($report_for==-99){ // 99 for summery
		$cols = array( 'SLNO'=>"Sl.",
		'name'=>'Transaction Type',
		'amount'=>'Amount (Tk.)',
		);

		$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>570,'xOrientation'=>'left','width'=>540,
		'cols'=>array(
		'SLNO'=>array('justification'=>'left','width'=>50),
		'name'=>array('justification'=>'left','width'=>350),
		'amount'=>array('justification'=>'right','width'=>140),
		)), 9);
	}

	//end of logic
	$pdf->ezText("",3);
	if ($total>0){


		if ($report_for!=-99){
			$data1=array();
			$cols1 = array( 'SLNO'=>"",
			'firm_name'=>'',
			'name'=>'',
			'transaction_date'=>'Total Amount (Tk.) :',
			'amount'=>$total
			);

			$pdf->ezTable($data1,$cols1,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(1,1,1),'xPos'=>570,'xOrientation'=>'left','width'=>540,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>50),
			'membership_code'=>array('justification'=>'left','width'=>60),
			'firm_name'=>array('justification'=>'left','width'=>150),
			'name'=>array('justification'=>'right','width'=>130),
			'transaction_date'=>array('justification'=>'left','width'=>90),
			'amount'=>array('justification'=>'right','width'=>70),
			)), 9);
		}
		else if ($report_for==-99){
			$data1=array();
			$cols1 = array( 'SLNO'=>"",
			'name'=>'Total Amount (Tk.) :',
			'amount'=>$total
			);

			$pdf->ezTable($data1,$cols1,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(1,1,1),'xPos'=>570,'xOrientation'=>'left','width'=>540,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>50),
			'name'=>array('justification'=>'right','width'=>350),
			'amount'=>array('justification'=>'right','width'=>140),
			)), 9);
		}
		//$pdf->ezText("Total : ".$total." TK.",10);
		//$pdf->ezText(" ",10);
		$pdf->ezText("In Words : ".numtoword($total)."Taka Only",10);
	}
	// footer
	$pdf->ezText("",10);
	//$pdf->ezText("Total : ".$assets." TK.",10);
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}

// accounts transaction report for BKMEA

function Accounts_Transaction_Report_BKMEA ( $FOR='bkmea' ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;
	$reg_id=$_REQUEST['last_reg_year_id'];

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//Header
	$TITLE="Accounts Transaction Report";
	if(strtolower($FOR)=="bkmea"){
		$NAME    =_CHAMBER_NAME_BKMEA;
		$ADDRESS =_ADDRESS_BKMEA;
		$CONTACT =_CONTACT_NUMBER_BKMEA;
		$EMAIL   =_EMAIL_BKMEA;
	}

	//this is the start of the logic to get the search result
	$year = date('Y');
	$type_id     = intval( mosGetParam( $_REQUEST, 'type_id' ));
	$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));
	$category_id   = intval( mosGetParam( $_REQUEST, 'category_id' ));
	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);
	$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
	$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);

	//$where[] = array();

	if ($date_from!='' && $date_to==''){
		$reporting_period="Reporting Period : From ".$date_from_display;
		$where[] = "DATE_FORMAT(at.transaction_date,'%Y-%m-%d')>='$date_from'";
	}elseif ($date_from=='' && $date_to!=''){
		$reporting_period="Reporting Period : Upto ".$date_to_display;
		$where[] = "DATE_FORMAT(at.transaction_date,'%Y-%m-%d')<='$date_to'";
	}elseif ($date_from!='' && $date_to!=''){
		$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
		$where[] = "DATE_FORMAT(at.transaction_date,'%Y-%m-%d')>='$date_from' and DATE_FORMAT(at.transaction_date,'%Y-%m-%d')<='$date_to'";
	}

	ReportTitle($pdf, $FOR, $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center',$reporting_period);

	//if (intval($report_for)!=201){
	if (intval($type_id)>0 && intval($report_for)!=201) {
		//$where[] = "m.type_id='$type_id' ";
		$typeid="m.type_id='$type_id' ";
	}
	if (intval($category_id)>0 && intval($report_for)!=201)
	{
		//$where[]="m.member_category_id='$category_id'";
		$categoryid="m.member_category_id='$category_id'";
	}
	//}

	if (intval($report_for)==-99){
		$query_99_all="select child.name as name, sum(child.amount) as amount"
		."\n from (select m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		."\n left join #__member_history as mh on mh.id=at.reference_no"
		."\n left join #__member as m on m.id=mh.member_id"
		."\n where at.transaction_type=0"
		//."\n and at.account_id!='131' and at.account_id!='121' and mh.reg_year_id='$reg_id'"
		."\n and at.account_id!='131' and at.account_id!='201' and mh.reg_year_id='$reg_id'"
		//.(intval($report_for)!=0 ?" and at.account_id='$report_for' ":"")
		.(intval($typeid)!=0 ?" and $typeid ":"")
		.(intval($categoryid)!=0 ?" and $categoryid ":"")
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name) as child"
		."\n group by account_id"
		;
		/*
		$query_99_121="select child.name as name, sum(child.amount) as amount"
		."\n from (select m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		."\n left join #__member_idcard as mi on mi.id=at.reference_no"
		."\n left join #__member as m on m.id=mi.member_id"
		."\n where at.transaction_type=0  and mi.reg_year_id='$reg_id' "
		."\n and at.account_id='121' "
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name) as child"
		."\n group by account_id"
		;
		*/
		$query_99_131="select child.name as name, sum(child.amount) as amount"
		."\n from (select m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		."\n left join #__member_certificate as mc on mc.id=at.reference_no"
		."\n left join #__member as m on m.id=mc.member_id"
		."\n where at.transaction_type=0  and mc.reg_year_id='$reg_id'"
		."\n and at.account_id='131' "
		.(intval($typeid)!=0 ?" and $typeid ":"")
		.(intval($categoryid)!=0 ?" and $categoryid ":"")
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name) as child"
		."\n group by account_id"
		;

		$query_99_201="select child.name as name, sum(child.amount) as amount"
		."\n from (select c.organization_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		."\n left join #__invoice as inv on inv.id=at.reference_no"
		."\n left join #__customer as c on c.id=inv.customer_id"
		."\n where at.transaction_type=0 "
		."\n and at.account_id='201' "
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name) as child"
		."\n group by account_id"
		;
	}
	else{
		$query_all="select m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		//."\n left join #__member as m on m.id=at.reference_no"
		."\n left join #__member_history as mh on mh.id=at.reference_no"
		."\n left join #__member as m on m.id=mh.member_id"
		."\n where at.transaction_type=0"
		//."\n and at.account_id!='131' and at.account_id!='121' and mh.reg_year_id='$reg_id'"
		."\n and at.account_id!='131' and at.account_id!='201' and mh.reg_year_id='$reg_id'"
		.(intval($report_for)!=0 ?" and at.account_id='$report_for' ":"")
		.(intval($typeid)!=0 ?" and $typeid ":"")
		.(intval($categoryid)!=0 ?" and $categoryid ":"")
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name"
		;
		/*
		$query_121="select m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		//."\n left join #__member as m on m.id=at.reference_no"
		."\n left join #__member_idcard as mi on mi.id=at.reference_no"
		."\n left join #__member as m on m.id=mi.member_id"
		."\n where at.transaction_type=0  and mi.reg_year_id='$reg_id' "
		."\n and at.account_id='121' "
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name"
		;
		*/
		$query_131="select m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		//."\n left join #__member as m on m.id=at.reference_no"
		."\n left join #__member_certificate as mc on mc.id=at.reference_no"
		."\n left join #__member as m on m.id=mc.member_id"
		."\n where at.transaction_type=0  and mc.reg_year_id='$reg_id'"
		."\n and at.account_id='131' "
		.(intval($typeid)!=0 ?" and $typeid ":"")
		.(intval($categoryid)!=0 ?" and $categoryid ":"")
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name"
		;

		$query_201="select c.organization_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		//."\n left join #__member as m on m.id=at.reference_no"
		."\n left join #__invoice as inv on inv.id=at.reference_no"
		."\n left join #__customer as c on c.id=inv.customer_id"
		."\n where at.transaction_type=0"
		."\n and at.account_id='201' "
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name"
		;
	}

	if($report_for==-99){
		$database->setQuery( $query_99_all );
		$rows = $database->loadObjectList();
		$database->setQuery( $query_99_131 );
		$rows = array_merge($rows,$database->loadObjectList());
		$database->setQuery( $query_99_201 );
		$rows = array_merge($rows,$database->loadObjectList());
		//$pdf->ezText($query_99_131,10);
		//$database->setQuery( $query_99_121 );
		//$rows = array_merge($rows,$database->loadObjectList());

	}else if($report_for==131){    //Certificate
		$database->setQuery( $query_131 );
		$rows = $database->loadObjectList();
	}else if($report_for==201){     //Info product
		$database->setQuery( $query_201 );
		$rows = $database->loadObjectList();
	}else if($report_for!=131 && $report_for!=201 && $report_for>0){      //admission, enroll, renew
		$database->setQuery( $query_all );
		$rows = $database->loadObjectList();
	}else if(intval($report_for)==0){
		$database->setQuery( $query_all );
		$rows = $database->loadObjectList();
		$database->setQuery( $query_131 );
		$rows = array_merge($rows,$database->loadObjectList());
		$database->setQuery( $query_201 );
		$rows = array_merge($rows,$database->loadObjectList());
		//$database->setQuery( $query_121 );
		//$rows = array_merge($rows,$database->loadObjectList());
		//$pdf->ezText($query_131,10);
	}

	$totalRows = count( $rows );
	$i=1;$p_id=0;
	$data=array();
	$total=0;
	foreach($rows as $row1){
		$SLNO=$i;

		$firm_name=$row1->firm_name;
		$name=$row1->name;
		$transaction_date=$mosHtmlObj->ConvertDateDisplayShort($row1->transaction_date);
		$amount=$row1->amount;
		$total=$total+$amount;
		$arr=array( 'SLNO'=>stripslashes($SLNO)
		,'firm_name'=>stripslashes($firm_name)
		,'name'=>stripslashes($name)
		,'amount'=>stripslashes($amount)
		,'transaction_date'=>stripslashes($transaction_date)
		);

		array_push($data,$arr);

		$i++;
	}

	if ($report_for!=-99){ // 99 for summery
		$cols = array( 'SLNO'=>"Sl.",
		'firm_name'=>'Firm Name',
		'name'=>'Transaction Type',
		'transaction_date'=>'Transaction Date',
		'amount'=>'Amount (Tk.)'
		);

		$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>570,'xOrientation'=>'left','width'=>540,
		'cols'=>array(
		'SLNO'=>array('justification'=>'left','width'=>50),
		'firm_name'=>array('justification'=>'left','width'=>150),
		'name'=>array('justification'=>'left','width'=>120),
		'transaction_date'=>array('justification'=>'center','width'=>110),
		'amount'=>array('justification'=>'right','width'=>110),
		)), 9);
	}
	elseif ($report_for==-99){ // 99 for summery
		$cols = array( 'SLNO'=>"Sl.",
		'name'=>'Transaction Type',
		'amount'=>'Amount (Tk.)',
		);

		$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>570,'xOrientation'=>'left','width'=>540,
		'cols'=>array(
		'SLNO'=>array('justification'=>'left','width'=>50),
		'name'=>array('justification'=>'left','width'=>350),
		'amount'=>array('justification'=>'right','width'=>140),
		)), 9);
	}

	//end of logic
	$pdf->ezText("",3);
	if ($total>0){


		if ($report_for!=-99){
			$data1=array();
			$cols1 = array( 'SLNO'=>"",
			'firm_name'=>'',
			'name'=>'',
			'transaction_date'=>'Total Amount (Tk.) :',
			'amount'=>$total
			);

			$pdf->ezTable($data1,$cols1,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(1,1,1),'xPos'=>570,'xOrientation'=>'left','width'=>540,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>50),
			'firm_name'=>array('justification'=>'left','width'=>150),
			'name'=>array('justification'=>'right','width'=>140),
			'transaction_date'=>array('justification'=>'left','width'=>120),
			'amount'=>array('justification'=>'right','width'=>80),
			)), 9);
		}
		else if ($report_for==-99){
			$data1=array();
			$cols1 = array( 'SLNO'=>"",
			'name'=>'Total Amount (Tk.) :',
			'amount'=>$total
			);

			$pdf->ezTable($data1,$cols1,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(1,1,1),'xPos'=>570,'xOrientation'=>'left','width'=>540,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>50),
			'name'=>array('justification'=>'right','width'=>350),
			'amount'=>array('justification'=>'right','width'=>140),
			)), 9);
		}
		//$pdf->ezText("Total : ".$total." TK.",10);
		//$pdf->ezText(" ",10);
		$pdf->ezText("In Words : ".numtoword($total)."Taka Only",10);
	}

	//$pdf->ezText($report_for,10);
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}

// Info Product Sales report for BKMEA

function infoProductSalesReport ( $FOR='bkmea' ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;
	$reg_id=$_REQUEST['last_reg_year_id'];

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//Header
	$TITLE=trim(strtolower($FOR))=="epb"?"Trade Lead Sales Report":"Information Product Sales Report";
	//Header
	if(strtolower($FOR)=="bkmea"){
		$NAME    =_CHAMBER_NAME_BKMEA;
		$ADDRESS =_ADDRESS_BKMEA;
		$CONTACT =_CONTACT_NUMBER_BKMEA;
		$EMAIL   =_EMAIL_BKMEA;
	}
	else if(strtolower($FOR)=="ccci"){
		$NAME    =_CHAMBER_NAME_CCCI;
		$ADDRESS =_ADDRESS_CCCI;
		$CONTACT =_CONTACT_NUMBER_CCCI;
		$EMAIL   =_EMAIL_CCCI;
	}
	else if(strtolower($FOR)=="scci"){
		$NAME    =_CHAMBER_NAME_SCCI;
		$ADDRESS =_ADDRESS_SCCI;
		$CONTACT =_CONTACT_NUMBER_SCCI;
		$EMAIL   =_EMAIL_SCCI;
	}
	else if(strtolower(trim($FOR))=="epb"){
		$NAME    =_ORG_NAME;
		$ADDRESS =_ADDRESS_EPB;
		$CONTACT =_CONTACT_NUMBER_EPB;
		$EMAIL   =_EMAIL_EPB;
	}

	//this is the start of the logic to get the search result
	$year = date('Y');
	$info_product     = intval( mosGetParam( $_REQUEST, 'info_product' ));
	$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));
	$category_id   = intval( mosGetParam( $_REQUEST, 'info_product_category' ));
	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);
	$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
	$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);

	//$where[] = array();

	if ($date_from!='' && $date_to==''){
		$reporting_period="Reporting Period : From ".$date_from_display;
		$where[] = "DATE_FORMAT(at.transaction_date,'%Y-%m-%d')>='$date_from'";
	}elseif ($date_from=='' && $date_to!=''){
		$reporting_period="Reporting Period : Upto ".$date_to_display;
		$where[] = "DATE_FORMAT(at.transaction_date,'%Y-%m-%d')<='$date_to'";
	}elseif ($date_from!='' && $date_to!=''){
		$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
		$where[] = "DATE_FORMAT(at.transaction_date,'%Y-%m-%d')>='$date_from' and DATE_FORMAT(at.transaction_date,'%Y-%m-%d')<='$date_to'";
	}

	ReportTitle($pdf, $FOR, $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center',$reporting_period);

	if (intval($info_product)>0) {
		$productSales=" and at.account_id='$info_product' ";
	}
	else {
		$productSales=" and (at.account_id='201' or at.account_id='202') ";
	}
	if (intval($info_product)==-99){

		$query_99_201="select child.name as name, sum(child.amount) as amount,child.price as price,child.discount as discount"
		."\n from (select cat.name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no,inv.user as username"
		."\n ,inv.price as price,inv.discount as discount,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		."\n left join #__invoice as inv on inv.id=at.reference_no"
		."\n join #__customer as c on c.id=inv.customer_id"
		."\n left join #__docman as d on d.id=inv.product_id"
		."\n left join #__categories as cat on cat.id=d.catid"
		."\n where at.transaction_type=0 "
		//."\n and at.account_id='201' "
		.$productSales
		.(intval($report_for)!=0 ?" and d.id='$report_for' ":"")
		.(intval($category_id)!=0 ?" and cat.id='$category_id' ":"")
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name) as child"
		."\n group by account_id"
		;
	}

	else{

		$query_201="select cat.name as category_name,d.dmname as product_name,c.customer_title as title"
		."\n ,c.customer_first_name as first_name,c.customer_last_name as last_name"
		."\n ,ac.name as name,at.account_id as account_id,inv.user as username"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,inv.price as price,inv.discount as discount,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		."\n left join #__invoice as inv on inv.id=at.reference_no"
		."\n left join #__customer as c on c.id=inv.customer_id"
		."\n left join #__docman as d on d.id=inv.product_id"
		."\n left join #__categories as cat on cat.id=d.catid"
		."\n where at.transaction_type=0 "
		//."\n and at.account_id='201' "
		.$productSales
		.(intval($report_for)!=0 ?" and d.id='$report_for' ":"")
		.(intval($category_id)!=0 ?" and cat.id='$category_id' ":"")
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name"
		;
	}

	if($info_product==-99){
		$database->setQuery( $query_99_201 );
		$rows = $database->loadObjectList();
	}else {
		$database->setQuery( $query_201 );
		$rows = $database->loadObjectList();
	}

	$totalRows = count( $rows );
	$i=1;$p_id=0;
	$data=array();
	$total=0;
	foreach($rows as $row1){
		$SLNO=$i;

		$category_name=$row1->category_name;
		$product_name=$row1->product_name;
		$title=$row1->title;
		$first_name=$row1->first_name;
		$last_name=$row1->last_name;
		$transaction_date=$mosHtmlObj->ConvertDateDisplayLong($row1->transaction_date);
		$price=round($row1->price,2);
		$discount=round($row1->discount,2);
		$amount=round($row1->amount,2);
		$sold_by=$row1->username;
		$customer=$title;
		$customer.=$first_name!=""? " ".$first_name:"";
		$customer.=$last_name!=""? " ".$last_name:"";
		$name=$row1->name;//transaction type i.e Info Product Sale, Directory Sale

		if ($info_product==-999){
			if (strtolower(trim($customer))==""){
				$total=$total+$amount;
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'product_name'=>stripslashes($product_name)
				,'category_name'=>stripslashes($category_name)
				,'transaction_date'=>stripslashes($transaction_date)
				,'customer'=>'Office'
				,'sold_by'=>stripslashes($sold_by)
				,'price'=>($price==intval($price))?$price.".00":$price
				,'discount'=>($discount==intval($discount))?$discount.".00":$discount
				,'amount'=>($amount==intval($amount))?$amount.".00":$amount
				,'name'=>stripslashes($name)
				);

				array_push($data,$arr);
				$i++;
			}
		}
		else{
			if (strtolower(trim($customer))!="" || intval($info_product)==-99){
				$total=$total+$amount;
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'product_name'=>stripslashes($product_name)
				,'category_name'=>stripslashes($category_name)
				,'transaction_date'=>stripslashes($transaction_date)
				,'customer'=>stripslashes($customer)
				,'sold_by'=>stripslashes($sold_by)
				,'price'=>($price==intval($price))?$price.".00":$price
				,'discount'=>($discount==intval($discount))?$discount.".00":$discount
				,'amount'=>($amount==intval($amount))?$amount.".00":$amount
				,'name'=>stripslashes($name)
				);

				array_push($data,$arr);
				$i++;
			}
		}

	}

	if ($info_product!=-99){ // 99 for summery
		if(trim(strtolower($FOR))!="epb"){
			$cols = array( 'SLNO'=>"<b>Sl.</b>",
			'product_name'=>'<b>Product Name</b>',
			'category_name'=>'<b>Category Name</b>',
			'transaction_date'=>'<b>Date</b>',
			'customer'=>'<b>Customer\'s Name</b>',
			'sold_by'=>'<b>Sold By</b>',
			'price'=>'<b>Price (Tk.)</b>',
			'discount'=>'<b>Discount (%)</b>',
			'amount'=>'<b>Amount (Tk.)</b>'
			);

			$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>585,'xOrientation'=>'left','width'=>565,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>25),
			'product_name'=>array('justification'=>'left','width'=>70),
			'category_name'=>array('justification'=>'left','width'=>80),
			'transaction_date'=>array('justification'=>'center','width'=>60),
			'customer'=>array('justification'=>'left','width'=>90),
			'sold_by'=>array('justification'=>'left','width'=>60),
			'price'=>array('justification'=>'right','width'=>60),
			'discount'=>array('justification'=>'right','width'=>60),
			'amount'=>array('justification'=>'right','width'=>60),
			)), 9);
		}else{
			$cols = array( 'SLNO'=>"<b>Sl.</b>",
			'product_name'=>'<b>Trade Lead Name</b>',
			'transaction_date'=>'<b>Date</b>',
			'customer'=>'<b>Customer\'s Name</b>',
			'sold_by'=>'<b>Sold By</b>',
			'price'=>'<b>Price (Tk.)</b>',
			'discount'=>'<b>Discount (%)</b>',
			'amount'=>'<b>Amount (Tk.)</b>'
			);

			$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>585,'xOrientation'=>'left','width'=>565,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>25),
			'product_name'=>array('justification'=>'left','width'=>120),
			'transaction_date'=>array('justification'=>'center','width'=>70),
			'customer'=>array('justification'=>'left','width'=>90),
			'sold_by'=>array('justification'=>'left','width'=>60),
			'price'=>array('justification'=>'right','width'=>60),
			'discount'=>array('justification'=>'right','width'=>70),
			'amount'=>array('justification'=>'right','width'=>70),
			)), 9);
		}
	}
	elseif ($info_product==-99){ // 99 for summery
		$cols = array( 'SLNO'=>"<b>Sl.</b>",
		'name'=>'<b>Transaction Type</b>',
		'amount'=>'<b>Amount (Tk.)</b>',
		);

		$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>570,'xOrientation'=>'left','width'=>540,
		'cols'=>array(
		'SLNO'=>array('justification'=>'left','width'=>50),
		'name'=>array('justification'=>'left','width'=>350),
		'amount'=>array('justification'=>'right','width'=>140),
		)), 9);
	}

	//end of logic
	$pdf->ezText("",3);
	if ($total>0){


		if ($info_product!=-99){
			$data1=array();
			if(trim(strtolower($FOR))!="epb"){
				$cols1 = array( 'SLNO'=>'',
				'product_name'=>'',
				'category_name'=>'',
				'transaction_date'=>'',
				'customer'=>'',
				'sold_by'=>'',
				'price'=>'',
				'discount'=>'<b>Total Tk</b>',
				'amount'=>($total==intval($total))?$total.".00":round($total,2)

				);

				$pdf->ezTable($data1,$cols1,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(1,1,1),'xPos'=>585,'xOrientation'=>'left','width'=>565,
				'cols'=>array(
				'SLNO'=>array('justification'=>'left','width'=>25),
				'product_name'=>array('justification'=>'left','width'=>70),
				'category_name'=>array('justification'=>'left','width'=>80),
				'transaction_date'=>array('justification'=>'center','width'=>60),
				'customer'=>array('justification'=>'left','width'=>90),
				'sold_by'=>array('justification'=>'left','width'=>60),
				'price'=>array('justification'=>'right','width'=>60),
				'discount'=>array('justification'=>'right','width'=>60),
				'amount'=>array('justification'=>'right','width'=>60),
				)), 9);
			}else{
				$cols1 = array( 'SLNO'=>'',
				'product_name'=>'',
				'transaction_date'=>'',
				'customer'=>'',
				'sold_by'=>'',
				'price'=>'',
				'discount'=>'<b>Total Tk</b>',
				'amount'=>($total==intval($total))?$total.".00":round($total,2)

				);

				$pdf->ezTable($data1,$cols1,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(1,1,1),'xPos'=>585,'xOrientation'=>'left','width'=>565,
				'cols'=>array(
				'SLNO'=>array('justification'=>'left','width'=>25),
				'product_name'=>array('justification'=>'left','width'=>120),
				'transaction_date'=>array('justification'=>'center','width'=>70),
				'customer'=>array('justification'=>'left','width'=>90),
				'sold_by'=>array('justification'=>'left','width'=>60),
				'price'=>array('justification'=>'right','width'=>60),
				'discount'=>array('justification'=>'right','width'=>70),
				'amount'=>array('justification'=>'right','width'=>70),
				)), 9);
			}
		}
		else if ($info_product==-99){
			$data1=array();
			$cols1 = array( 'SLNO'=>"",
			'name'=>'<b>Total Tk :</b>',
			'amount'=>($total==intval($total))?$total.".00":round($total,2)
			);

			$pdf->ezTable($data1,$cols1,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(1,1,1),'xPos'=>570,'xOrientation'=>'left','width'=>540,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>50),
			'name'=>array('justification'=>'right','width'=>350),
			'amount'=>array('justification'=>'right','width'=>140),
			)), 9);
		}
		//$pdf->ezText("Total : ".$total." TK.",10);
		//$pdf->ezText(" ",10);
		$pdf->ezText("<b>In Words :</b> Taka ".numtoword($total)." Only",10);
	}

	//$pdf->ezText($report_for,10);
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}

// Info Product Customer report for BKMEA

function infoProductCustomerReport ( $FOR='bkmea' ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;
	$reg_id=$_REQUEST['last_reg_year_id'];

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//Header
	$TITLE=trim(strtolower($FOR))=="epb"?"Customer Report":"Information Product Customer Report";
	//Header
	if(strtolower($FOR)=="bkmea"){
		$NAME    =_CHAMBER_NAME_BKMEA;
		$ADDRESS =_ADDRESS_BKMEA;
		$CONTACT =_CONTACT_NUMBER_BKMEA;
		$EMAIL   =_EMAIL_BKMEA;
	}
	else if(strtolower($FOR)=="ccci"){
		$NAME    =_CHAMBER_NAME_CCCI;
		$ADDRESS =_ADDRESS_CCCI;
		$CONTACT =_CONTACT_NUMBER_CCCI;
		$EMAIL   =_EMAIL_CCCI;
	}
	else if(strtolower($FOR)=="scci"){
		$NAME    =_CHAMBER_NAME_SCCI;
		$ADDRESS =_ADDRESS_SCCI;
		$CONTACT =_CONTACT_NUMBER_SCCI;
		$EMAIL   =_EMAIL_SCCI;
	}
	else if(strtolower(trim($FOR))=="epb"){
		$NAME    =_ORG_NAME;
		$ADDRESS =_ADDRESS_EPB;
		$CONTACT =_CONTACT_NUMBER_EPB;
		$EMAIL   =_EMAIL_EPB;
	}

	//this is the start of the logic to get the search result
	$year = date('Y');
	$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
	$purchase  = intval( mosGetParam( $_REQUEST, 'purchase'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));
	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);
	$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
	$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);

	//$where[] = array();

	if ($date_from!='' && $date_to==''){
		$reporting_period="Reporting Period : From ".$date_from_display;
		$where[] = "DATE_FORMAT(at.transaction_date,'%Y-%m-%d')>='$date_from'";
	}elseif ($date_from=='' && $date_to!=''){
		$reporting_period="Reporting Period : Upto ".$date_to_display;
		$where[] = "DATE_FORMAT(at.transaction_date,'%Y-%m-%d')<='$date_to'";
	}elseif ($date_from!='' && $date_to!=''){
		$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
		$where[] = "DATE_FORMAT(at.transaction_date,'%Y-%m-%d')>='$date_from' and DATE_FORMAT(at.transaction_date,'%Y-%m-%d')<='$date_to'";
	}

	ReportTitle($pdf, $FOR, $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center',$reporting_period);

	if (intval($report_for)==1) {
		$where[]="c.membership_id!='0' ";
	}
	elseif (intval($report_for)==2){
		$where[]="c.membership_id='0'";
	}

	if (intval($purchase)==0) {
		$repeat="";
	}
	elseif (intval($purchase)==1) {
		$repeat="having count(customer_id)=1";
	}
	elseif (intval($purchase)==2){
		$repeat="having count(customer_id)>1";
	}

	$query="select child.*, sum(child.amount) as amount,count(customer_id) as repetitive"
	."\n from (select cat.name as category_name,ac.name as name,at.account_id as account_id"
	."\n ,cat.name as category_name,d.dmname as product_name,c.customer_title as title"
	."\n ,c.customer_first_name as first_name,c.customer_last_name as last_name"
	."\n ,c.address as address,c.country as country"
	."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
	."\n ,transaction_date,customer_id,sum(at.amount) as amount from #__account_transaction as at"
	."\n join #__account_chart as ac on at.account_id=ac.id"
	."\n left join #__invoice as inv on inv.id=at.reference_no"
	."\n join #__customer as c on c.id=inv.customer_id"
	."\n left join #__docman as d on d.id=inv.product_id"
	."\n left join #__categories as cat on cat.id=d.catid"
	."\n where at.transaction_type=0 "
	."\n and (at.account_id='201' or at.account_id='202') "
	. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
	."\n group by reference_no,transaction_type,account_id order by ac.name) as child"
	."\n group by child.customer_id ".$repeat
	;

	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$totalRows = count( $rows );
	$i=1;
	$data=array();
	$total=0;
	foreach($rows as $row1){
		$SLNO=$i;

		$category_name=$row1->category_name;
		$repetitive=$row1->repetitive-1;
		$address=$row1->address;
		$product_name=$row1->product_name;
		$title=$row1->title;
		$first_name=$row1->first_name;
		$last_name=$row1->last_name;
		$transaction_date=$mosHtmlObj->ConvertDateDisplayLong($row1->transaction_date);
		$amount=round($row1->amount,2);
		$total=$total+$amount;
		$customer=$title;
		$customer.=$first_name!=""? " ".$first_name:"";
		$customer.=$last_name!=""? " ".$last_name:"";
		$name=$row1->name;//transaction type i.e Info Product Sale, Directory Sale

		$arr=array( 'SLNO'=>stripslashes($SLNO)
		,'customer'=>stripslashes($customer)
		,'address'=>stripslashes($address)
		,'repetitive'=>stripslashes($repetitive)
		,'amount'=>($amount==intval($amount))?$amount.".00":$amount
		);

		array_push($data,$arr);

		$i++;
	}

	$cols = array( 'SLNO'=>"<b>Sl.</b>",
	'customer'=>'<b>Customer\'s Name</b>',
	'address'=>'<b>Address</b>',
	'repetitive'=>'<b># of Prev. Transactions</b>',
	'amount'=>'<b>Total Amount (Tk.)</b>'
	);

	$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>570,'xOrientation'=>'left','width'=>540,
	'cols'=>array(
	'SLNO'=>array('justification'=>'left','width'=>40),
	'customer'=>array('justification'=>'left','width'=>125),
	'address'=>array('justification'=>'left','width'=>125),
	'repetitive'=>array('justification'=>'center','width'=>125),
	'amount'=>array('justification'=>'right','width'=>125),
	)), 9);

	//end of logic
	$pdf->ezText("",3);
	if ($total>0){

		$data1=array();
		$cols1 = array( 'SLNO'=>'',
		'customer'=>'',
		'address'=>'',
		'repetitive'=>'<b>Total Tk</b>',
		'amount'=>($total==intval($total))?"$total.00":round($total,2)
		);

		$pdf->ezTable($data1,$cols1,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(1,1,1),'xPos'=>570,'xOrientation'=>'left','width'=>540,
		'cols'=>array(
		'SLNO'=>array('justification'=>'left','width'=>40),
		'customer'=>array('justification'=>'left','width'=>125),
		'address'=>array('justification'=>'left','width'=>125),
		'repetitive'=>array('justification'=>'right','width'=>125),
		'amount'=>array('justification'=>'right','width'=>125),
		)), 9);

		//$pdf->ezText("Total : ".$total." TK.",10);
		//$pdf->ezText(" ",10);
		$pdf->ezText("<b>In Words :</b> Taka ".numtoword($total)." Only",10);
	}

	//$pdf->ezText($purchase,10);
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}

// Info Product List report for BKMEA

function infoProductListReport ( $FOR='bkmea' ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;
	$reg_id=$_REQUEST['last_reg_year_id'];

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//Header
	$TITLE=trim(strtolower($FOR))=="epb"?"Trade Leads Report":"Information Products Report";

	//Header
	if(strtolower($FOR)=="bkmea"){
		$NAME    =_CHAMBER_NAME_BKMEA;
		$ADDRESS =_ADDRESS_BKMEA;
		$CONTACT =_CONTACT_NUMBER_BKMEA;
		$EMAIL   =_EMAIL_BKMEA;
	}
	else if(strtolower($FOR)=="ccci"){
		$NAME    =_CHAMBER_NAME_CCCI;
		$ADDRESS =_ADDRESS_CCCI;
		$CONTACT =_CONTACT_NUMBER_CCCI;
		$EMAIL   =_EMAIL_CCCI;
	}
	else if(strtolower($FOR)=="scci"){
		$NAME    =_CHAMBER_NAME_SCCI;
		$ADDRESS =_ADDRESS_SCCI;
		$CONTACT =_CONTACT_NUMBER_SCCI;
		$EMAIL   =_EMAIL_SCCI;
	}
	else if(strtolower(trim($FOR))=="epb"){
		$NAME    =_ORG_NAME;
		$ADDRESS =_ADDRESS_EPB;
		$CONTACT =_CONTACT_NUMBER_EPB;
		$EMAIL   =_EMAIL_EPB;
	}

	//this is the start of the logic to get the search result
	$year = date('Y');
	$info_product  = intval( mosGetParam( $_REQUEST, 'info_product'));
	$info_product_category  = intval( mosGetParam( $_REQUEST, 'info_product_category'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));
	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);
	$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
	$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);

	//$where[] = array();

	if ($date_from!='' && $date_to==''){
		$reporting_period="Reporting Period : From ".$date_from_display;
		$where[] = "DATE_FORMAT(d.dmdate_published,'%Y-%m-%d')>='$date_from'";
	}elseif ($date_from=='' && $date_to!=''){
		$reporting_period="Reporting Period : Upto ".$date_to_display;
		$where[] = "DATE_FORMAT(d.dmdate_published,'%Y-%m-%d')<='$date_to'";
	}elseif ($date_from!='' && $date_to!=''){
		$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
		$where[] = "DATE_FORMAT(d.dmdate_published,'%Y-%m-%d')>='$date_from' and DATE_FORMAT(d.dmdate_published,'%Y-%m-%d')<='$date_to'";
	}

	ReportTitle($pdf, $FOR, $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center',$reporting_period);

	if (intval($info_product)>0) {
		$where[]="d.id='$info_product' ";
	}
	if (intval($info_product_category)>0){
		$where[]="c.id='$info_product_category'";
	}

	$query="SELECT d.dmname AS product_name,c.name AS category_name"
	."\n ,d.price_for_non_member AS nonmember_price,d.dmdate_expire AS expiry_date"
	."\n ,d.price_for_member AS member_price,d.dmdate_published AS published_date"
	."\n FROM mos_docman AS d LEFT JOIN mos_categories AS c ON d.catid=c.id"
	."\n WHERE d.is_delete='0' and c.is_delete='0'"
	. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
	;

	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$totalRows = count( $rows );
	$i=1;$p_id=0;
	$data=array();
	$total=0;
	foreach($rows as $row1){
		$SLNO=$i;

		$product_name=$row1->product_name;
		$category_name=$row1->category_name;
		$nonmember_price=round($row1->nonmember_price,2);
		$member_price=round($row1->member_price,2);
		$published_date=$mosHtmlObj->ConvertDateDisplayLong($row1->published_date);
		$expiry_date=$mosHtmlObj->ConvertDateDisplayLong($row1->expiry_date);

		$arr=array( 'SLNO'=>stripslashes($SLNO)
		,'product_name'=>stripslashes($product_name)
		,'category_name'=>stripslashes($category_name)
		,'member_price'=>($member_price==intval($member_price))?$member_price.".00":$member_price
		,'nonmember_price'=>($nonmember_price==intval($nonmember_price))?$nonmember_price.".00":$nonmember_price
		,'published_date'=>stripslashes($published_date)
		,'expiry_date'=>stripslashes($expiry_date)
		);

		array_push($data,$arr);

		$i++;
	}
	if(trim(strtolower($FOR))=="epb"){
		$cols = array( 'SLNO'=>"<b>Sl.</b>",
		'product_name'=>'<b>Trade Lead Name</b>',
		'member_price'=>'<b>Member Price (Tk.)</b>',
		'nonmember_price'=>'<b>Non Member Price (Tk.)</b>',
		'published_date'=>'<b>Publish Date</b>',
		'expiry_date'=>'<b>Expiry Date</b>'
		);
	}
	else{
		$cols = array( 'SLNO'=>"<b>Sl.</b>",
		'product_name'=>'<b>Product Name</b>',
		'category_name'=>'<b>Category Name</b>',
		'member_price'=>'<b>Member Price (Tk.)</b>',
		'nonmember_price'=>'<b>Non Member Price (Tk.)</b>',
		'published_date'=>'<b>Publish Dat</b>e',
		'expiry_date'=>'<b>Expiry Date</b>'
		);
	}
	if(trim(strtolower($FOR))=="epb"){
		$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>570,'xOrientation'=>'left','width'=>540,
		'cols'=>array(
		'SLNO'=>array('justification'=>'left','width'=>35),
		'product_name'=>array('justification'=>'left','width'=>165),
		'member_price'=>array('justification'=>'right','width'=>90),
		'nonmember_price'=>array('justification'=>'right','width'=>110),
		'published_date'=>array('justification'=>'center','width'=>70),
		'expiry_date'=>array('justification'=>'center','width'=>70),
		)), 9);
	}
	else{
		$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>570,'xOrientation'=>'left','width'=>540,
		'cols'=>array(
		'SLNO'=>array('justification'=>'left','width'=>40),
		'product_name'=>array('justification'=>'left','width'=>100),
		'category_name'=>array('justification'=>'left','width'=>100),
		'member_price'=>array('justification'=>'right','width'=>80),
		'nonmember_price'=>array('justification'=>'right','width'=>90),
		'published_date'=>array('justification'=>'center','width'=>70),
		'expiry_date'=>array('justification'=>'center','width'=>60),
		)), 9);
	}

	//end of logic
	//$pdf->ezText("",3);


	//$pdf->ezText($report_for,10);
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}
//report :: for mail merge

function MailMergeBkmea ( ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	//$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//this is the start of the logic to get the search result
	$year = date('Y');
	$type_id     = intval( mosGetParam( $_REQUEST, 'type_id' ));
	$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));

	$last_reg_year_id   = trim( mosGetParam( $_REQUEST, 'last_reg_year_id' ));
	$category_id   = trim( mosGetParam( $_REQUEST, 'category_id' ));
	$membership_no     =  mosGetParam( $_REQUEST, 'membership_no' );
	
	$order_by=intval( mosGetParam( $_REQUEST, 'order_by' ));

	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);

	$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
	$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);

	$where = array();

	if ($category_id>0)
	{
		$where[]="m.member_category_id='$category_id'";
	}

	if ($type_id > 0) {
		$where[] = "m.type_id='$type_id'";
		$type_name = $database->getMemberTypeName($type_id);
		//$TITLE=$type_name." List";
		$TITLE=$type_name." Mailing List for ";
	}
	else
	//$TITLE="Member List";
	$TITLE="Mailing List  for ";



	$sql="select name from #__member_reg_year where id='$last_reg_year_id'";
	$database->setQuery($sql);
	$TITLE.=$database->loadResult();

	if ($membership_no!=""){
		$members1=explode(",",$membership_no);
		$members2=array();

		for ($i=0;$i<count($members1);$i++){
			if(trim($members1)!=""){
				if (strpos($members1[$i],'-',0)){
					$temp=explode("-",$members1[$i]);
					if ($temp[0]>$temp[1]){
						$t=$temp[0];
						$temp[0]=$temp[1];
						$temp[1]=$t;
					}
					for ($j=intval($temp[0]);$j<=intval($temp[1]);$j++){
						if (is_numeric($j))
						array_push($members2,$j);
					}
				}
				else{
					if (is_numeric($members1[$i]))
					array_push($members2,$members1[$i]);
				}
			}
		}

		/*  for ($i=0;$i<count($members2);$i++){
		for ($j=$i+1;$j<count($members2);$j++){
		if ($members2[$i]==$members2[$j]){
		for ($k=$j;$k<count($members2);$k++){
		$members2[$k]=$members2[$k+1];
		}
		}
		}
		} */
		$members=implode(',',$members2);
		if (sizeof($members2)>0)
		$where[] = "m.member_reg_no IN ($members)";
	}

	// report header

	if ($report_for == 0) {    //All member
		$where[] = "(( h.entry_type = '1' and h.reg_year_id='$last_reg_year_id') || ( h.entry_type = '2' and h.reg_year_id='$last_reg_year_id' )) ";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "( ( m.reg_date>='$date_from' and m.reg_date<='$date_to') || ( m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to' ))";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "( m.reg_date<='$date_to' || m.last_reg_date<='$date_to' )";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "( m.reg_date>='$date_from' || m.last_reg_date>='$date_from' )";
		}
	}
	else if ($report_for == 1) {    //new member
		$where[] = "h.entry_type = '1' and h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "m.reg_date>='$date_from' and m.reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "m.reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "m.reg_date>='$date_from'";
		}
	}
	else if ($report_for == 2) {    //renewed member
		$where[] = "h.entry_type = '2' and h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "m.last_reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "m.last_reg_date>='$date_from'";
		}
	}
	else if($report_for == 3 ){
		/* $where[]= "h.member_id not in (select member_id from mos_member_history"
		."\n where reg_year_id = $last_reg_year_id and (entry_type='1' or entry_type='2') ) "
		."\n and h.reg_year_id<$last_reg_year_id "
		;
		*/
		$where[]= " m.last_reg_year_id<$last_reg_year_id "
		;
		/*
		if ($date_from != '' && $date_to != '' ) {
		$where[] = "m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
		$where[] = "m.last_reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
		$where[] = "m.last_reg_date>='$date_from'";
		}
		*/
	}
	
	if (intval($order_by)==1){
		$orderBy="CAST(m.member_reg_no AS UNSIGNED) ASC";
	}
	else{
		$orderBy="m.firm_name ASC";
	}
	
	ReportTitle($pdf, 'bkmea',_CHAMBER_NAME_BKMEA, _ADDRESS_BKMEA, _CONTACT_NUMBER_BKMEA, _EMAIL_BKMEA, $TITLE, 'center',$reporting_period);
	$pdf->line( 6, 722, 575, 722 );
	$query = "select distinct(m.id) as id, m.firm_name as firm_name, m.tin as tin "
	."\n ,m.type_id as type_id , m.last_reg_year_id as last_reg_year_id"
	."\n ,m.applicant_name as applicant_name,m.applicant_email as email"
	."\n ,m.applicant_title as applicant_title,m.applicant_last_name as applicant_last_name"
	."\n ,m.applicant_office_phone as phone, md.name as designation"
	."\n ,m.representative_title as representative_title,m.representative_last_name as representative_last_name"
	."\n ,m.representative_name as representative_name, m.applicant_address_street as street"
	."\n ,m.applicant_address_town_suburb as town, m.applicant_address_district as district"
	."\n ,m.applicant_address_division as division, m.applicant_address_country as country"
	."\n ,m.applicant_home_phone as home_phone, m.applicant_office_phone as office_phone"
	."\n ,m.applicant_fax as fax from #__member as m "
	."\n LEFT JOIN #__member_history AS h ON h.member_id = m.id"
	//."\n LEFT JOIN #__designation AS md ON md.id = m.representative_designation"
	."\n LEFT JOIN #__designation AS md ON md.id = m.applicant_designation"
	."\n where m.is_delete =0 "
	. ( count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
//	."\n ORDER BY m.firm_name "
	."\n ORDER BY ".$orderBy;
	;

	$database->setQuery( $query );
	$rows = $database->loadObjectList();


	$j=1;
	$data=array();
	//foreach($rows as $row){
	for($i=0; $i<count($rows); $i++){
		//$SLNO=$i;
		$col1="";$col2="";$col3="";
		$SLNO=$j;
		$row=$rows[$i];
		$applicant="";
		$firm_name="";
		$address="";
		$applicant="\n";
		$applicant.=$row->applicant_title!=""?$SLNO."\n":"";
		$applicant.="<b>".$row->applicant_title."</b>";
		$applicant.=" "."<b>".$row->applicant_name."</b>";
		$applicant.=trim($row->applicant_last_name)!="" ?" "."<b>".$row->applicant_last_name."</b>":"";
		$applicant.=trim($row->designation)!="" ?"\n".$row->designation:"";
		$firm_name="\n<b>".$row->firm_name."</b>";
		$address="\n\n".$row->street;
		$address.= trim($row->town)!="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?"\n".$row->district:"";
		$address.="\n";
		//$col1=strip_tags($applicant.$firm_name.$address);
		$col1=$applicant.$firm_name.$address;

		$i++;
		$SLNO=++$j;
		$row=$rows[$i];
		$applicant="";
		$firm_name="";
		$address="";
		$applicant="\n";
		$applicant.=$row->applicant_title!=""?$SLNO."\n":"";
		$applicant.="<b>".$row->applicant_title."</b>";
		$applicant.=" "."<b>".$row->applicant_name."</b>";
		$applicant.=trim($row->applicant_last_name)!="" ?" "."<b>".$row->applicant_last_name."</b>":"";
		$applicant.=trim($row->designation)!="" ?"\n".$row->designation:"";
		$firm_name="\n<b>".$row->firm_name."</b>";
		$address="\n\n".$row->street;
		$address.= trim($row->town)!="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?"\n".$row->district:"";
		$address.="\n";
		//$col2=strip_tags($applicant.$firm_name.$address);
		$col2=$applicant.$firm_name.$address;

		$i++;
		$SLNO=++$j;
		$row=$rows[$i];
		$applicant="";
		$firm_name="";
		$address="";
		$applicant="\n";
		$applicant.=$row->applicant_title!=""?$SLNO."\n":"";
		$applicant.="<b>".$row->applicant_title."</b>";
		$applicant.=" "."<b>".$row->applicant_name."</b>";
		$applicant.=trim($row->applicant_last_name)!="" ?" "."<b>".$row->applicant_last_name."</b>":"";
		$applicant.=trim($row->designation)!="" ?"\n".$row->designation:"";
		$firm_name="\n<b>".$row->firm_name."</b>";
		$address="\n\n".$row->street;
		$address.= trim($row->town)!="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?"\n".$row->district:"";
		$address.="\n";
		//$col3=strip_tags($applicant.$firm_name.$address);
		$col3=$applicant.$firm_name.$address;

		$arr=array( 'col1'=>$col1
		,'col2'=>$col2
		,'col3'=>$col3
		);
		array_push($data,$arr);
		$j++;
	}
	$cols = array( 'col1'=>'',
	'col2'=>'',
	'col3'=>''
	);
	//$pdf->selectFont( './fonts/Helvetica-Bold.afm' );
	$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>0,'shaded'=> 0, 'lineCol'=>array(1,1,1), 'xPos'=>580,'xOrientation'=>'left','width'=>570,
	'cols'=>array(
	'col1'=>array('justification'=>'left','width'=>190),
	'col2'=>array('justification'=>'left','width'=>190),
	'col3'=>array('justification'=>'left','width'=>190))
	), 9);


	//end of logic

	// footer
	//$pdf->ezText();
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}
//report :: for all mail merge

function AllMailMergeBkmea ( ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	//$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//this is the start of the logic to get the search result
	$year = date('Y');
	$type_id     = intval( mosGetParam( $_REQUEST, 'type_id' ));
	$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));

	$last_reg_year_id   = trim( mosGetParam( $_REQUEST, 'last_reg_year_id' ));
	$category_id   = trim( mosGetParam( $_REQUEST, 'category_id' ));
	$membership_no     =  mosGetParam( $_REQUEST, 'membership_no' );
	$order_by=intval( mosGetParam( $_REQUEST, 'order_by' ));
	
	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);

	$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
	$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);

	$where = array();

	if ($category_id>0)
	{
		$where[]="m.member_category_id='$category_id'";
	}

	if ($type_id > 0) {
		$where[] = "m.type_id='$type_id'";
		$type_name = $database->getMemberTypeName($type_id);
		//$TITLE=$type_name." List";
		//$TITLE=$type_name." Mailing List for the ";
		$TITLE=" Mailing List for all ".$type_name;
	}
	else{
		//$TITLE="Member List";
		//$TITLE="Mailing List for the ";
		$TITLE="Mailing List for All Member ";
	}


	/*
	$sql="select name from #__member_reg_year where id='$last_reg_year_id'";
	$database->setQuery($sql);
	$TITLE.=$database->loadResult();
	*/
	if ($membership_no!=""){
		$members1=explode(",",$membership_no);
		$members2=array();

		for ($i=0;$i<count($members1);$i++){
			if(trim($members1)!=""){
				if (strpos($members1[$i],'-',0)){
					$temp=explode("-",$members1[$i]);
					if ($temp[0]>$temp[1]){
						$t=$temp[0];
						$temp[0]=$temp[1];
						$temp[1]=$t;
					}
					for ($j=intval($temp[0]);$j<=intval($temp[1]);$j++){
						if (is_numeric($j))
						array_push($members2,$j);
					}
				}
				else{
					if (is_numeric($members1[$i]))
					array_push($members2,$members1[$i]);
				}
			}
		}

		/*  for ($i=0;$i<count($members2);$i++){
		for ($j=$i+1;$j<count($members2);$j++){
		if ($members2[$i]==$members2[$j]){
		for ($k=$j;$k<count($members2);$k++){
		$members2[$k]=$members2[$k+1];
		}
		}
		}
		} */
		$members=implode(',',$members2);
		if (sizeof($members2)>0)
		$where[] = "m.member_reg_no IN ($members)";
	}

	// report header

	if ($report_for == 0) {    //All member
		$where[] = "( h.entry_type = '1' || h.entry_type = '2' ) ";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "( ( m.reg_date>='$date_from' and m.reg_date<='$date_to') || ( m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to' ))";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "( m.reg_date<='$date_to' || m.last_reg_date<='$date_to' )";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "( m.reg_date>='$date_from' || m.last_reg_date>='$date_from' )";
		}
	}
	else if ($report_for == 1) {    //new member
		$where[] = "h.entry_type = '1' ";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "m.reg_date>='$date_from' and m.reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "m.reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "m.reg_date>='$date_from'";
		}
	}
	else if ($report_for == 2) {    //renewed member
		$where[] = "h.entry_type = '2' ";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "m.last_reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "m.last_reg_date>='$date_from'";
		}
	}
	else if($report_for == 3 ){
		/* $where[]= "h.member_id not in (select member_id from mos_member_history"
		."\n where reg_year_id = $last_reg_year_id and (entry_type='1' or entry_type='2') ) "
		."\n and h.reg_year_id<$last_reg_year_id "
		;
		*/
		$where[]= " m.last_reg_year_id<$last_reg_year_id "
		;
		/*
		if ($date_from != '' && $date_to != '' ) {
		$where[] = "m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
		$where[] = "m.last_reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
		$where[] = "m.last_reg_date>='$date_from'";
		}
		*/
	}
	
	if (intval($order_by)==1){
		$orderBy="CAST(m.member_reg_no AS UNSIGNED) ASC";
	}
	else{
		$orderBy="m.firm_name ASC";
	}
	
	ReportTitle($pdf, 'bkmea',_CHAMBER_NAME_BKMEA, _ADDRESS_BKMEA, _CONTACT_NUMBER_BKMEA, _EMAIL_BKMEA, $TITLE, 'center',$reporting_period);
	$pdf->line( 6, 722, 575, 722 );
	$query = "select distinct(m.id) as id, m.firm_name as firm_name, m.tin as tin "
	."\n ,m.type_id as type_id , m.last_reg_year_id as last_reg_year_id"
	."\n ,m.applicant_name as applicant_name,m.applicant_email as email"
	."\n ,m.applicant_title as applicant_title,m.applicant_last_name as applicant_last_name"
	."\n ,m.applicant_office_phone as phone, md.name as designation"
	."\n ,m.representative_title as representative_title,m.representative_last_name as representative_last_name"
	."\n ,m.representative_name as representative_name, m.applicant_address_street as street"
	."\n ,m.applicant_address_town_suburb as town, m.applicant_address_district as district"
	."\n ,m.applicant_address_division as division, m.applicant_address_country as country"
	."\n ,m.applicant_home_phone as home_phone, m.applicant_office_phone as office_phone"
	."\n ,m.applicant_fax as fax from #__member as m "
	."\n LEFT JOIN #__member_history AS h ON h.member_id = m.id"
	//."\n LEFT JOIN #__designation AS md ON md.id = m.representative_designation"
	."\n LEFT JOIN #__designation AS md ON md.id = m.applicant_designation"
	."\n where m.is_delete =0 "
	. ( count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
//	."\n ORDER BY m.firm_name "
	."\n ORDER BY ".$orderBy
	;

	$database->setQuery( $query );
	$rows = $database->loadObjectList();


	$j=1;
	$data=array();
	//foreach($rows as $row){
	for($i=0; $i<count($rows); $i++){
		//$SLNO=$i;
		$col1="";$col2="";$col3="";
		$SLNO=$j;
		$row=$rows[$i];
		$applicant="";
		$firm_name="";
		$address="";
		$applicant="\n";
		$applicant.=$row->applicant_title!=""?$SLNO."\n":"";
		$applicant.="<b>".$row->applicant_title."</b>";
		$applicant.=" "."<b>".$row->applicant_name."</b>";
		$applicant.=trim($row->applicant_last_name)!="" ?" "."<b>".$row->applicant_last_name."</b>":"";
		$applicant.=trim($row->designation)!="" ?"\n".$row->designation:"";
		$firm_name="\n<b>".$row->firm_name."</b>";
		$address="\n\n".$row->street;
		$address.= trim($row->town)!="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?"\n".$row->district:"";
		$address.="\n";
		//$col1=strip_tags($applicant.$firm_name.$address);
		$col1=$applicant.$firm_name.$address;

		$i++;
		$SLNO=++$j;
		$row=$rows[$i];
		$applicant="";
		$firm_name="";
		$address="";
		$applicant="\n";
		$applicant.=$row->applicant_title!=""?$SLNO."\n":"";
		$applicant.="<b>".$row->applicant_title."</b>";
		$applicant.=" "."<b>".$row->applicant_name."</b>";
		$applicant.=trim($row->applicant_last_name)!="" ?" "."<b>".$row->applicant_last_name."</b>":"";
		$applicant.=trim($row->designation)!="" ?"\n".$row->designation:"";
		$firm_name="\n<b>".$row->firm_name."</b>";
		$address="\n\n".$row->street;
		$address.= trim($row->town)!="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?"\n".$row->district:"";
		$address.="\n";
		//$col2=strip_tags($applicant.$firm_name.$address);
		$col2=$applicant.$firm_name.$address;

		$i++;
		$SLNO=++$j;
		$row=$rows[$i];
		$applicant="";
		$firm_name="";
		$address="";
		$applicant="\n";
		$applicant.=$row->applicant_title!=""?$SLNO."\n":"";
		$applicant.="<b>".$row->applicant_title."</b>";
		$applicant.=" "."<b>".$row->applicant_name."</b>";
		$applicant.=trim($row->applicant_last_name)!="" ?" "."<b>".$row->applicant_last_name."</b>":"";
		$applicant.=trim($row->designation)!="" ?"\n".$row->designation:"";
		$firm_name="\n<b>".$row->firm_name."</b>";
		$address="\n\n".$row->street;
		$address.= trim($row->town)!="" ?", ".$row->town:"";
		$address.= trim($row->district)!="" ?"\n".$row->district:"";
		$address.="\n";
		//$col3=strip_tags($applicant.$firm_name.$address);
		$col3=$applicant.$firm_name.$address;

		$arr=array( 'col1'=>stripslashes($col1)
		,'col2'=>stripslashes($col2)
		,'col3'=>stripslashes($col3)
		);
		array_push($data,$arr);
		$j++;
	}
	$cols = array( 'col1'=>'',
	'col2'=>'',
	'col3'=>''
	);

	$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>0,'shaded'=> 0, 'lineCol'=>array(1,1,1), 'xPos'=>580,'xOrientation'=>'left','width'=>570,
	'cols'=>array(
	'col1'=>array('justification'=>'left','width'=>190),
	'col2'=>array('justification'=>'left','width'=>190),
	'col3'=>array('justification'=>'left','width'=>190))
	), 9);


	//end of logic

	// footer
	//$pdf->ezText();
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}
// accounts transaction report for BKMEA

function Accounts_Transaction_Report_CCCI ( $FOR='ccci' ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;
	$reg_id=$_REQUEST['last_reg_year_id'];

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//Header
	$TITLE="Accounts Transaction Report";
	if(strtolower($FOR)=="ccci"){
		$NAME    =_CHAMBER_NAME_CCCI;
		$ADDRESS =_ADDRESS_CCCI;
		$CONTACT =_CONTACT_NUMBER_CCCI;
		$EMAIL   =_EMAIL_CCCI;
	}

	//this is the start of the logic to get the search result
	$year = date('Y');
	$type_id     = intval( mosGetParam( $_REQUEST, 'type_id' ));
	$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));

	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);
	$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
	$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);

	//$where[] = array();

	if ($date_from!='' && $date_to==''){
		$reporting_period="Reporting Period : From ".$date_from_display;
		$where[] = "DATE_FORMAT(at.transaction_date,'%Y-%m-%d')>='$date_from'";
	}elseif ($date_from=='' && $date_to!=''){
		$reporting_period="Reporting Period : Upto ".$date_to_display;
		$where[] = "DATE_FORMAT(at.transaction_date,'%Y-%m-%d')<='$date_to'";
	}elseif ($date_from!='' && $date_to!=''){
		$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
		$where[] = "DATE_FORMAT(at.transaction_date,'%Y-%m-%d')>='$date_from' and DATE_FORMAT(at.transaction_date,'%Y-%m-%d')<='$date_to'";
	}

	ReportTitle($pdf, $FOR, $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center',$reporting_period);

	if (intval($type_id)>0) {
		$where[] = "m.type_id='$type_id' ";
	}


	if (intval($report_for)==-99){
		$query_99_all="select child.name as name, sum(child.amount) as amount"
		."\n from (select m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		."\n left join #__member_history as mh on mh.id=at.reference_no"
		."\n left join #__member as m on m.id=mh.member_id"
		."\n where at.transaction_type=0"
		//."\n and at.account_id!='131' and at.account_id!='121' and mh.reg_year_id='$reg_id'"
		."\n and mh.reg_year_id='$reg_id'"
		//.(intval($report_for)!=0 ?" and at.account_id='$report_for' ":"")
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name,at.transaction_date) as child"
		."\n group by account_id"
		;
		/*
		$query_99_121="select child.name as name, sum(child.amount) as amount"
		."\n from (select m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		."\n left join #__member_idcard as mi on mi.id=at.reference_no"
		."\n left join #__member as m on m.id=mi.member_id"
		."\n where at.transaction_type=0  and mi.reg_year_id='$reg_id' "
		."\n and at.account_id='121' "
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name) as child"
		."\n group by account_id"
		;

		$query_99_131="select child.name as name, sum(child.amount) as amount"
		."\n from (select m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		."\n left join #__member_certificate as mc on mc.id=at.reference_no"
		."\n left join #__member as m on m.id=mc.member_id"
		."\n where at.transaction_type=0  and mc.reg_year_id='$reg_id'"
		."\n and at.account_id='131' "
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name) as child"
		."\n group by account_id"
		; */
	}
	else{
		$query_all="select m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		//."\n left join #__member as m on m.id=at.reference_no"
		."\n left join #__member_history as mh on mh.id=at.reference_no"
		."\n left join #__member as m on m.id=mh.member_id"
		."\n where at.transaction_type=0"
		//."\n and at.account_id!='131' and at.account_id!='121' and mh.reg_year_id='$reg_id'"
		."\n and mh.reg_year_id='$reg_id'"
		.(intval($report_for)!=0 ?" and at.account_id='$report_for' ":"")
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name,at.transaction_date"
		;
		/*
		$query_121="select m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		//."\n left join #__member as m on m.id=at.reference_no"
		."\n left join #__member_idcard as mi on mi.id=at.reference_no"
		."\n left join #__member as m on m.id=mi.member_id"
		."\n where at.transaction_type=0  and mi.reg_year_id='$reg_id' "
		."\n and at.account_id='121' "
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name"
		;

		$query_131="select m.firm_name as firm_name,ac.name as name,at.account_id as account_id"
		."\n ,at.transaction_type as transaction_type,at.reference_no as reference_no"
		."\n ,transaction_date,sum(at.amount) as amount from #__account_transaction as at"
		."\n join #__account_chart as ac on at.account_id=ac.id"
		//."\n left join #__member as m on m.id=at.reference_no"
		."\n left join #__member_certificate as mc on mc.id=at.reference_no"
		."\n left join #__member as m on m.id=mc.member_id"
		."\n where at.transaction_type=0  and mc.reg_year_id='$reg_id'"
		."\n and at.account_id='131' "
		. (count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
		."\n group by reference_no,transaction_type,account_id order by ac.name"
		; */
	}

	if($report_for==-99){
		$database->setQuery( $query_99_all );
		$rows = $database->loadObjectList();
		//$database->setQuery( $query_99_131 );
		//$rows = array_merge($rows,$database->loadObjectList());
		//$pdf->ezText($query_99_131,10);
		//$database->setQuery( $query_99_121 );
		//$rows = array_merge($rows,$database->loadObjectList());

	}/*else if($report_for==131){    //Certificate
	$database->setQuery( $query_131 );
	$rows = $database->loadObjectList();
	}/*else if($report_for==121){     //Id Card
	$database->setQuery( $query_121 );
	$rows = $database->loadObjectList();
	}*/else if($report_for>0){      //admission, enroll, renew
	$database->setQuery( $query_all );
	$rows = $database->loadObjectList();
	}else if(intval($report_for)==0){
		$database->setQuery( $query_all );
		$rows = $database->loadObjectList();
		//$database->setQuery( $query_131 );
		//$rows = array_merge($rows,$database->loadObjectList());
		//$database->setQuery( $query_121 );
		//$rows = array_merge($rows,$database->loadObjectList());
		//$pdf->ezText($query_131,10);
	}

	$totalRows = count( $rows );
	$i=1;$p_id=0;
	$data=array();
	$total=0;
	foreach($rows as $row1){
		$SLNO=$i;

		$firm_name=$row1->firm_name;
		$name=$row1->name;
		$transaction_date=$mosHtmlObj->ConvertDateDisplayShort($row1->transaction_date);
		$amount=$row1->amount;
		$total=$total+$amount;
		$arr=array( 'SLNO'=>stripslashes($SLNO)
		,'firm_name'=>stripslashes($firm_name)
		,'name'=>stripslashes($name)
		,'amount'=>stripslashes($amount)
		,'transaction_date'=>stripslashes($transaction_date)
		);

		array_push($data,$arr);

		$i++;
	}

	if ($report_for!=-99){ // 99 for summery
		$cols = array( 'SLNO'=>"Sl.",
		'firm_name'=>'Firm Name',
		'name'=>'Transaction Type',
		'transaction_date'=>'Transaction Date',
		'amount'=>'Amount (Tk.)'
		);

		$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>570,'xOrientation'=>'left','width'=>540,
		'cols'=>array(
		'SLNO'=>array('justification'=>'left','width'=>50),
		'firm_name'=>array('justification'=>'left','width'=>150),
		'name'=>array('justification'=>'left','width'=>120),
		'transaction_date'=>array('justification'=>'center','width'=>110),
		'amount'=>array('justification'=>'right','width'=>110),
		)), 9);
	}
	elseif ($report_for==-99){ // 99 for summery
		$cols = array( 'SLNO'=>"Sl.",
		'name'=>'Transaction Type',
		'amount'=>'Amount (Tk.)',
		);

		$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>570,'xOrientation'=>'left','width'=>540,
		'cols'=>array(
		'SLNO'=>array('justification'=>'left','width'=>50),
		'name'=>array('justification'=>'left','width'=>350),
		'amount'=>array('justification'=>'right','width'=>140),
		)), 9);
	}

	//end of logic
	$pdf->ezText("",3);
	if ($total>0){


		if ($report_for!=-99){
			$data1=array();
			$cols1 = array( 'SLNO'=>"",
			'firm_name'=>'',
			'name'=>'',
			'transaction_date'=>'Total Amount (Tk.) :',
			'amount'=>$total
			);

			$pdf->ezTable($data1,$cols1,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(1,1,1),'xPos'=>570,'xOrientation'=>'left','width'=>540,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>50),
			'firm_name'=>array('justification'=>'left','width'=>150),
			'name'=>array('justification'=>'right','width'=>140),
			'transaction_date'=>array('justification'=>'left','width'=>120),
			'amount'=>array('justification'=>'right','width'=>80),
			)), 9);
		}
		else if ($report_for==-99){
			$data1=array();
			$cols1 = array( 'SLNO'=>"",
			'name'=>'Total Amount (Tk.) :',
			'amount'=>$total
			);

			$pdf->ezTable($data1,$cols1,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(1,1,1),'xPos'=>570,'xOrientation'=>'left','width'=>540,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>50),
			'name'=>array('justification'=>'right','width'=>350),
			'amount'=>array('justification'=>'right','width'=>140),
			)), 9);
		}
		//$pdf->ezText("Total : ".$total." TK.",10);
		//$pdf->ezText(" ",10);
		$pdf->ezText("In Words : ".numtoword($total)."Taka Only",10);
	}


	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}
function MailMergeCCCI ( ) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	//$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//this is the start of the logic to get the search result
	$year = date('Y');
	$type_id     = intval( mosGetParam( $_REQUEST, 'type_id' ));
	$report_for  = intval( mosGetParam( $_REQUEST, 'report_for'));
	$date_from   = trim( mosGetParam( $_REQUEST, 'date_from'));
	$date_to     = trim( mosGetParam( $_REQUEST, 'date_to' ));
	$location     = trim( mosGetParam( $_REQUEST, 'location' ));
	$is_outside     = trim( mosGetParam( $_REQUEST, 'is_outside' ));
	$membership_no     =  mosGetParam( $_REQUEST, 'membership_no' );
	$last_reg_year_id   = trim( mosGetParam( $_REQUEST, 'last_reg_year_id' ));
	//$category_id   = trim( mosGetParam( $_REQUEST, 'category_id' ));

	$date_from = $mosHtmlObj->ConvertDateForDatatbase($date_from);
	$date_to   = $mosHtmlObj->ConvertDateForDatatbase($date_to);

	$date_from_display = $mosHtmlObj->ConvertDateDisplayShort($date_from);
	$date_to_display   = $mosHtmlObj->ConvertDateDisplayShort($date_to);



	$where = array();

	/*if ($category_id>0)
	{
	$where[]="m.member_category_id='$category_id'";
	}*/

	if ($type_id > 0) {
		$where[] = "m.type_id='$type_id'";
		$type_name = $database->getMemberTypeName($type_id);
		//$TITLE=$type_name." List";
		$TITLE=$type_name." Mailing List for the ";
	}
	else
	//$TITLE="Member List";
	$TITLE="Mailing List  for the ";

	$sql="select name from #__member_reg_year where id='$last_reg_year_id'";
	$database->setQuery($sql);
	$TITLE.=$database->loadResult();

	// report header

	if ($membership_no!=""){
		$members1=explode(",",$membership_no);
		$members2=array();

		for ($i=0;$i<count($members1);$i++){
			if(trim($members1)!=""){
				if (strpos($members1[$i],'-',0)){
					$temp=explode("-",$members1[$i]);
					if ($temp[0]>$temp[1]){
						$t=$temp[0];
						$temp[0]=$temp[1];
						$temp[1]=$t;
					}
					for ($j=intval($temp[0]);$j<=intval($temp[1]);$j++){
						if (is_numeric($j))
						array_push($members2,$j);
					}
				}
				else{
					if (is_numeric($members1[$i]))
					array_push($members2,$members1[$i]);
				}
			}
		}

		/*  for ($i=0;$i<count($members2);$i++){
		for ($j=$i+1;$j<count($members2);$j++){
		if ($members2[$i]==$members2[$j]){
		for ($k=$j;$k<count($members2);$k++){
		$members2[$k]=$members2[$k+1];
		}
		}
		}
		} */
		$members=implode(',',$members2);
		if (sizeof($members2)>0)
		$where[] = "m.member_reg_no IN ($members)";
	}

	if (intval($is_outside) > -1) {
		$where[] = "m.is_outside='$is_outside'";
	}
	if (intval($location) >0) {
		$where[] = "m.location='$location'";
	}

	$i=0;
	if ($member_reg_no_from > 0) {
		$i++;
		$membership_range="Membership Range : From ".$member_reg_no_from;
		$where[] = "h.member_reg_no>='$member_reg_no_from'";
	}
	if ($member_reg_no_to > 0) {
		$i++;
		$membership_range="Membership Range : Upto ".$member_reg_no_to;
		$where[] = "h.member_reg_no<='$member_reg_no_to'";
	}
	if ($i==2){
		$membership_range="Membership Range : From ".$member_reg_no_from." Upto ".$member_reg_no_to;
	}

	if ($report_for == 0) {    //All member
		$where[] = "(( h.entry_type = '1' and h.reg_year_id='$last_reg_year_id') || ( h.entry_type = '2' and h.reg_year_id='$last_reg_year_id' )) ";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "( ( m.reg_date>='$date_from' and m.reg_date<='$date_to') || ( m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to' ))";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "( m.reg_date<='$date_to' || m.last_reg_date<='$date_to' )";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "( m.reg_date>='$date_from' || m.last_reg_date>='$date_from' )";
		}
	}
	else if ($report_for == 1) {    //new member
		$where[] = "h.entry_type = '1' and h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "m.reg_date>='$date_from' and m.reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "m.reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "m.reg_date>='$date_from'";
		}
	}
	else if ($report_for == 2) {    //renewed member
		$where[] = "h.entry_type = '2' and h.reg_year_id='$last_reg_year_id'";

		if ($date_from != '' && $date_to != '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
			$where[] = "m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
			$reporting_period="Reporting Period : Upto ".$date_to_display;
			$where[] = "m.last_reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
			$reporting_period="Reporting Period : From ".$date_from_display;
			$where[] = "m.last_reg_date>='$date_from'";
		}
	}
	else if($report_for == 3 ){
		/* $where[]= "h.member_id not in (select member_id from mos_member_history"
		."\n where reg_year_id = $last_reg_year_id and (entry_type='1' or entry_type='2') ) "
		."\n and h.reg_year_id<$last_reg_year_id "
		;
		*/
		//$where[]= " m.last_reg_year_id<$last_reg_year_id "
		$where[]= " h.reg_year_id<$last_reg_year_id "
		;
		/*
		if ($date_from != '' && $date_to != '' ) {
		$where[] = "m.last_reg_date>='$date_from' and m.last_reg_date<='$date_to'";
		}
		else if ($date_from == '' && $date_to != '' ) {
		$where[] = "m.last_reg_date<='$date_to'";
		}
		else if ($date_from != '' && $date_to == '' ) {
		$where[] = "m.last_reg_date>='$date_from'";
		}
		*/
	}

	ReportTitle($pdf, 'ccci',_CHAMBER_NAME_CCCI, _ADDRESS_CCCI, _CONTACT_NUMBER_CCCI, _EMAIL_CCCI, $TITLE, 'center',$reporting_period,$membership_range);
	$pdf->line( 6, 698, 575, 698 );
	$query = "select distinct(m.id) as id, m.firm_name as firm_name "
	//."\n ,m.type_id as type_id , m.last_reg_year_id as last_reg_year_id"
	."\n ,m.type_id as type_id , h.reg_year_id as last_reg_year_id"
	."\n ,m.applicant_title as title,m.applicant_name as first_name"
	."\n ,m.applicant_last_name as last_name, md.name as designation"
	."\n ,m.representative_title as rtitle,m.representative_name as rfirst_name"
	."\n ,m.representative_last_name as rlast_name, md1.name as rdesignation"
	."\n ,m.firm_reg_address_street as firm_reg_address_street"
	."\n ,m.firm_reg_address_town_suburb as firm_reg_address_town_suburb"
	."\n ,m.firm_reg_address_district as firm_reg_address_district"
	."\n ,m.firm_reg_address_division as firm_reg_address_division"
	."\n ,m.firm_reg_address_country as firm_reg_address_country"
	."\n from #__member as m"
	."\n LEFT JOIN #__member_history AS h ON h.member_id = m.id"
	."\n LEFT JOIN #__designation AS md ON md.id = m.applicant_designation"
	."\n LEFT JOIN #__designation AS md1 ON md1.id = m.representative_designation"
	."\n where m.is_delete =0 "
	. ( count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
	."\n ORDER BY m.firm_name "
	;

	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	$j=0;
	$data=array();
	//foreach($rows as $row){
	$total_row=count($rows);
	//$pdf->ezText($total_row,15);
	for($i=0; $i<$total_row; ){
		$col1="";
		$col2="";
		$col3="";
		if($total_row>$i){
			$j=$j+1;
			$SLNO=$j;
			$row=$rows[$i];
			$applicant="\n";
			$applicant.=$SLNO."\n";
			if($row->type_id!=3 && $row->type_id!=4){
				$applicant.=stripslashes($row->rtitle);
				$applicant.=" ".stripslashes($row->rfirst_name);
				$applicant.=" ".stripslashes($row->rlast_name);
				$applicant.=trim($row->rdesignation)!="" ?"\n".$row->rdesignation:"";
			}else{
				$applicant.=stripslashes($row->title);
				$applicant.=" ".stripslashes($row->first_name);
				$applicant.=" ".stripslashes($row->last_name);
				$applicant.=trim($row->designation)!="" ?"\n".$row->designation:"";
			}

			$applicant.="\n";
			$firm_name=stripslashes($row->firm_name)!=""?stripslashes($row->firm_name):"";
			$address=stripslashes($row->firm_reg_address_street)!="" ? stripslashes($row->firm_reg_address_street):"";
			$address.=stripslashes($row->firm_reg_address_town_suburb)!="" ? " ".stripslashes($row->firm_reg_address_town_suburb):"";
			$address.=stripslashes($row->firm_reg_address_district)!="" ? "\n".stripslashes($row->firm_reg_address_district):"";
			$address.=stripslashes($row->firm_reg_address_division)!="" ? " ".stripslashes($row->firm_reg_address_division):"";
			$address.=stripslashes($row->firm_reg_address_country)!="" ? "\n".stripslashes($row->firm_reg_address_country):"";
			$applicant.=$firm_name;
			$applicant.="\n";
			$applicant.=$address;
			$applicant.="\n";
			$col1=$applicant;
		}
		$i=$i+1;
		//$arr=array('applicant'=>stripslashes($applicant)
		//            );

		if($total_row>$i){
			$j=$j+1;
			$SLNO=$j;
			$row=$rows[$i];
			$applicant="\n";
			$applicant.=$SLNO."\n";
			if($row->type_id!=3 && $row->type_id!=4){
				$applicant.=stripslashes($row->rtitle);
				$applicant.=" ".stripslashes($row->rfirst_name);
				$applicant.=" ".stripslashes($row->rlast_name);
				$applicant.=trim($row->rdesignation)!="" ?"\n".$row->rdesignation:"";
			}else{
				$applicant.=stripslashes($row->title);
				$applicant.=" ".stripslashes($row->first_name);
				$applicant.=" ".stripslashes($row->last_name);
				$applicant.=trim($row->designation)!="" ?"\n".$row->designation:"";
			}
			$applicant.="\n";
			$firm_name=stripslashes($row->firm_name)!=""?stripslashes($row->firm_name):"";
			$address=stripslashes($row->firm_reg_address_street)!="" ? stripslashes($row->firm_reg_address_street):"";
			$address.=stripslashes($row->firm_reg_address_town_suburb)!="" ? " ".stripslashes($row->firm_reg_address_town_suburb):"";
			$address.=stripslashes($row->firm_reg_address_district)!="" ? "\n".stripslashes($row->firm_reg_address_district):"";
			$address.=stripslashes($row->firm_reg_address_division)!="" ? " ".stripslashes($row->firm_reg_address_division):"";
			$address.=stripslashes($row->firm_reg_address_country)!="" ? "\n".stripslashes($row->firm_reg_address_country):"";
			$applicant.=$firm_name;
			$applicant.="\n";
			$applicant.=$address;
			$applicant.="\n";
			$col2=$applicant;
		}
		$i=$i+1;


		if($total_row>$i){
			$j=$j+1;
			$SLNO=$j;
			$row=$rows[$i];
			$applicant="\n";
			$applicant.=$SLNO."\n";
			if($row->type_id!=3 && $row->type_id!=4){
				$applicant.=stripslashes($row->rtitle);
				$applicant.=" ".stripslashes($row->rfirst_name);
				$applicant.=" ".stripslashes($row->rlast_name);
				$applicant.=trim($row->rdesignation)!="" ?"\n".$row->rdesignation:"";
			}else{
				$applicant.=stripslashes($row->title);
				$applicant.=" ".stripslashes($row->first_name);
				$applicant.=" ".stripslashes($row->last_name);
				$applicant.=trim($row->designation)!="" ?"\n".$row->designation:"";
			}
			$applicant.="\n";
			$firm_name=stripslashes($row->firm_name)!=""?stripslashes($row->firm_name):"";
			$address=stripslashes($row->firm_reg_address_street)!="" ? stripslashes($row->firm_reg_address_street):"";
			$address.=stripslashes($row->firm_reg_address_town_suburb)!="" ? " ".stripslashes($row->firm_reg_address_town_suburb):"";
			$address.=stripslashes($row->firm_reg_address_district)!="" ? "\n".stripslashes($row->firm_reg_address_district):"";
			$address.=stripslashes($row->firm_reg_address_division)!="" ? " ".stripslashes($row->firm_reg_address_division):"";
			$address.=stripslashes($row->firm_reg_address_country)!="" ? "\n".stripslashes($row->firm_reg_address_country):"";
			$applicant.=$firm_name;
			$applicant.="\n";
			$applicant.=$address;
			$applicant.="\n";
			$col3=$applicant;
		}
		$i=$i+1;

		$arr=array( 'col1'=>stripslashes($col1)
		,'col2'=>stripslashes($col2)
		,'col3'=>stripslashes($col3)
		);
		array_push($data,$arr);
	}
	$cols = array( 'col1'=>'',
	'col2'=>'',
	'col3'=>''
	);

	$pdf->ezTable($data,$cols,'',array('showLines'=>0, 'showHeadings'=>0,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7), 'xPos'=>590,'xOrientation'=>'left','width'=>570,
	'cols'=>array(
	'col1'=>array('justification'=>'left','width'=>190),
	'col2'=>array('justification'=>'left','width'=>190),
	'col3'=>array('justification'=>'left','width'=>190))
	), 9);

	//end of logic

	// footer

	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}

function  MemberVoterIDCardScci( $FOR, $database, $type_id,$last_reg_id )
{
	global $config_voter_election_date,$mosconfig_voter_new_date,$mosconfig_voter_renew_date;


	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font

	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$membership_no     =  mosGetParam( $_REQUEST, 'membership_no' );
	//Header


	if($type_id>0){

		$type_name = $database->getMemberTypeName($type_id);
		$type_name_arr=explode(" ",$type_name);
		$type_name=$type_name_arr[0];
		$type_name.=(strtolower($type_name_arr[1])=="member" || trim($type_name_arr[1])=="")? "":" ".$type_name_arr[1];

		$title=$type_name.' Voter Card';
		if ($type_id==1)
		$reg='G';
		else if ($type_id==2)
		$reg='TA';
		else if ($type_id==3)
		$reg='O';
		else if ($type_id==4)
		$reg='A';

	}

	$sql="select end_date from #__member_reg_year where id='$last_reg_id'";
	$database->setQuery($sql);
	$year=explode("-",$database->loadResult());
	$year=$year[0];

	//this is the start of the logic to get the search result
	$election_date=mosHTML::ConvertDateForDatatbase($config_voter_election_date);
	$e_date=mosHTML::ConvertDateDisplayLong($election_date);
	$rows=array();
	$where=array();

	$imgright="./administrator/images/photograph/".$type_id."_voter_right.jpg"; // for the shed image
	$imgtop="./administrator/images/photograph/".$type_id."_voter_top.jpg";
	$imglogo="./administrator/images/photograph/SCCI_Logo_ID_Card.jpg";

	$where[] = "m.type_id='$type_id' and ((mh.entry_type=1 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day)) ||(mh.entry_type=2 and mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)))";


	if ($membership_no!=""){
		$members1=explode(",",$membership_no);
		$members2=array();

		for ($i=0;$i<count($members1);$i++){
			if(trim($members1)!=""){
				if (strpos($members1[$i],'-',0)){
					$temp=explode("-",$members1[$i]);
					if ($temp[0]>$temp[1]){
						$t=$temp[0];
						$temp[0]=$temp[1];
						$temp[1]=$t;
					}
					for ($j=intval($temp[0]);$j<=intval($temp[1]);$j++){
						if (is_numeric($j))
						array_push($members2,$j);
					}
				}
				else{
					if (is_numeric($members1[$i]))
					array_push($members2,$members1[$i]);
				}
			}
		}

		/*  for ($i=0;$i<count($members2);$i++){
		for ($j=$i+1;$j<count($members2);$j++){
		if ($members2[$i]==$members2[$j]){
		for ($k=$j;$k<count($members2);$k++){
		$members2[$k]=$members2[$k+1];
		}
		}
		}
		} */
		$members=implode(',',$members2);
		if (sizeof($members2)>0)
		$where[] = "m.member_reg_no IN ($members)";
	}


	$query = "select  distinct (m.tin) as tin,m.id as id, m.firm_name as firm_name, mh.member_reg_no as membershipno "
	."\n ,representative_photograph as photograph"
	."\n ,m.representative_title as title, representative_last_name as last_name"
	."\n ,m.representative_name as name, des.name as representative_designation"
	."\n ,mt.name as type_name"
	."\n from #__member as m left join #__member_history as mh on m.id=mh.member_id "
	."\n left join #__member_type as mt on m.type_id=mt.id"
	."\n left join #__designation as des on des.id=m.representative_designation"
	."\n where m.is_delete=0 and  mh.reg_year_id= '".$last_reg_id."' and mh.is_voter=1"
	// ."\n mh.entry_type=1 and m.last_reg_date<= date_sub(\"".$date."\", interval 1 day)"
	. ( count( $where ) ? "\n and " . implode( ' AND ', $where ) : "")
	."\n group by m.tin order by mh.member_reg_no"
	;


	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$totalRows = count( $rows );



	for ($i=0; $i<$totalRows;)
	{

		$x=15;
		$y=666.2;
		for ($j=0; $j<4; $j++)
		{
			if ($i<$totalRows)
			{

				$pdf->rectangle($x,$y,266.1,169.8); //biger rectangle(outline)


				$pdf->rectangle($x+195,$y+86.8,65.6,74);

				if (file_exists($imgright))
				{
					$pdf->addJpegFromFile($imgright,$x+243,$y,18.6,91);
				}
				if (file_exists($imgtop))
				{
					$pdf->addJpegFromFile($imgtop,$x,$y+145.8,195,15);
				}

				if (file_exists($imglogo))
				{
					$pdf->addJpegFromFile($imglogo,$x+70,$y+30.8,80,80);
				}

				$photograph= $rows[$i]->photograph;
				$memberid=$rows[$i]->id;

				$img='./administrator/images/photograph/'.$memberid.'/'.strtolower($photograph);    // to set the path of the image only jpg will take

				if (trim($photograph)!="")
				{
					$pdf->addJpegFromFile($img,$x+195,$y+86.6,65.6,74);
					//$pdf->addText( $x+20, $y+5,15, "member id:".$img."."  );
				}

				$pdf->addText( $x+45, $y+149.8,12, $title  );
				$pdf->setColor(0,0,140,140);
				$pdf->addText( $x+8, $y+136.8 , 7, 'THE SYLHET CHAMBER OF COMMERCE & INDUSTRY' );
				$pdf->setColor(0,0,0,0);
				$pdf->addText( $x+20, $y+126.8, 7, 'Chamber Building, Jail Road, Sylhet, Bangladesh' );

				$pdf->addText( $x+8, $y+100.8,6, 'Voter'  );
				$pdf->addText( $x+25, $y+100.8,6, ':'  );
				$pdf->addText( $x+30, $y+100.8,8, $rows[$i]->firm_name);
				$pdf->addText( $x+8, $y+80.8,6, 'Representative');
				$pdf->addText( $x+52, $y+80.8,6, ':');
				$pdf->addText( $x+57, $y+80.8,8, $rows[$i]->title.' '.$rows[$i]->name.' '.$rows[$i]->last_name);

				$pdf->addText( $x+8, $y+66.8, 6,'Voter #');
				$pdf->addText( $x+30, $y+66.8, 6,':');
				$pdf->addText( $x+35, $y+66.8, 6,$i+1);

				$pdf->addText( $x+140, $y+66.8, 6,'Membership #');
				$pdf->addText( $x+180, $y+66.8, 6,':');
				$pdf->addText( $x+185, $y+66.8, 6,$reg.$rows[$i]->membershipno);

				$pdf->addText( $x+8, $y+52.8,7,'This card is valid only for casting vote in the election for '.$year.' of the Sylhet');
				$pdf->addText( $x+8, $y+45.8,7,'Chamber of Commerce & Industry to be held on '.$e_date.'.');

				$pdf->addText( $x+8, $y+20.8,7,'.....................');
				$pdf->addText( $x+8, $y+12.8,8,'Chairman');
				$pdf->addText( $x+8, $y+5.8,6,'Election Board');

				$pdf->addText( $x+170, $y+13.8,7,'............................');
				$pdf->addText( $x+170, $y+5.8,8,'Voter Signature');


				$i++;

				$x+=296.1;

			}


			if ($i<$totalRows)
			{

				$pdf->rectangle($x,$y,266.1,169.8); //biger rectangle(outline)


				$pdf->rectangle($x+195,$y+91.8,65.6,74);

				if (file_exists($imgright))
				{
					$pdf->addJpegFromFile($imgright,$x+243,$y,18.6,91);
				}
				if (file_exists($imgtop))
				{
					$pdf->addJpegFromFile($imgtop,$x,$y+145.8,195,15);
				}

				if (file_exists($imglogo))
				{
					$pdf->addJpegFromFile($imglogo,$x+70,$y+30.8,80,80);
				}

				$photograph= $rows[$i]->photograph;
				$memberid=$rows[$i]->id;

				$img='./administrator/images/photograph/'.$memberid.'/'.strtolower($photograph);    // to set the path of the image only jpg will take

				if (trim($photograph)!="")
				{
					$pdf->addJpegFromFile($img,$x+195,$y+91.8,65.6,74);
					//$pdf->addText( $x+20, $y+5,15, "member id:".$img."."  );
				}

				$pdf->addText( $x+45, $y+149.8,12, $title  );
				$pdf->setColor(0,0,140,140);
				$pdf->addText( $x+8, $y+136.8 , 7, 'THE SYLHET CHAMBER OF COMMERCE & INDUSTRY' );
				$pdf->setColor(0,0,0,0);
				$pdf->addText( $x+20, $y+126.8, 7, 'Chamber Building, Jail Road, Sylhet, Bangladesh' );

				$pdf->addText( $x+8, $y+100.8,6, 'Voter'  );
				$pdf->addText( $x+25, $y+100.8,6, ':'  );
				$pdf->addText( $x+30, $y+100.8,8, $rows[$i]->firm_name);
				$pdf->addText( $x+8, $y+80.8,6, 'Representative');
				$pdf->addText( $x+52, $y+80.8,6, ':');
				$pdf->addText( $x+57, $y+80.8,8, $rows[$i]->title.' '.$rows[$i]->name.' '.$rows[$i]->last_name);

				$pdf->addText( $x+8, $y+66.8, 6,'Voter #');
				$pdf->addText( $x+30, $y+66.8, 6,':');
				$pdf->addText( $x+35, $y+66.8, 6,$i+1);

				$pdf->addText( $x+140, $y+66.8, 6,'Membership #');
				$pdf->addText( $x+180, $y+66.8, 6,':');
				$pdf->addText( $x+185, $y+66.8, 6,$reg.$rows[$i]->membershipno);

				$pdf->addText( $x+8, $y+52.8,7,'This card is valid only for casting vote in the election for '.$year.' of the Sylhet');
				$pdf->addText( $x+8, $y+45.8,7,'Chamber of Commerce & Industry to be held on '.$e_date.'.');

				$pdf->addText( $x+8, $y+20.8,7,'.....................');
				$pdf->addText( $x+8, $y+12.8,8,'Chairman');
				$pdf->addText( $x+8, $y+5.8,6,'Election Board');

				$pdf->addText( $x+170, $y+13.8,7,'............................');
				$pdf->addText( $x+170, $y+5.8,8,'Voter Signature');




				$i++;
				$x=15;
				$y=$y-195.8;
			}

		} //end of inner for loop  //for ($j=0; $j<4; $j++)
		if ($i<$totalRows)
		$pdf->ezNewPage();
	}


	//end of logic

	// footer

	//ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}


function infoProductCoupon() {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate, $mosConfig_hideAuthor, $mosConfig_hideModifyDate;
	global $database, $_MAMBOTS, $mosHtmlObj,$mosConfig_owner;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	//$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');

	//this is the start of the logic to get the search result
	$year = date('Y');
	$for     = intval( mosGetParam( $_REQUEST, 'for' ));
	$customerID     = intval( mosGetParam( $_REQUEST, 'customerID' ));
	$invoiceID     = intval( mosGetParam( $_REQUEST, 'invoiceID' ));
	$pName     = mosGetParam( $_REQUEST, 'pName' );

	//$TITLE="Invoice";
	$TITLE=trim(strtolower($mosConfig_owner))=="epb"?"Trade Lead Sales Coupon":"Information Product Coupon";

	if(strtolower(trim($mosConfig_owner))=="bkmea"){
		$NAME    =_CHAMBER_NAME_BKMEA;
		$ADDRESS =_ADDRESS_BKMEA;
		$CONTACT =_CONTACT_NUMBER_BKMEA;
		$EMAIL   =_EMAIL_BKMEA;
	}
	else if(strtolower(trim($mosConfig_owner))=="ccci"){
		$NAME    =_CHAMBER_NAME_CCCI;
		$ADDRESS =_ADDRESS_CCCI;
		$CONTACT =_CONTACT_NUMBER_CCCI;
		$EMAIL   =_EMAIL_CCCI;
	}
	else if(strtolower(trim($mosConfig_owner))=="scci"){
		$NAME    =_CHAMBER_NAME_SCCI;
		$ADDRESS =_ADDRESS_SCCI;
		$CONTACT =_CONTACT_NUMBER_SCCI;
		$EMAIL   =_EMAIL_SCCI;
	}
	else if(strtolower(trim($mosConfig_owner))=="epb"){
		$NAME    =_ORG_NAME;
		$ADDRESS =_ADDRESS_EPB;
		$CONTACT =_CONTACT_NUMBER_EPB;
		$EMAIL   =_EMAIL_EPB;
	}
	ReportTitle($pdf, strtolower(trim($mosConfig_owner)), $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center', $reporting_period);



	$query_customer="select * from #__customer where id='".$customerID."'";
	$database->setQuery( $query_customer );
	$customer_rows = $database->loadObjectList();

	$query_invoice="select * from #__invoice where id='".$invoiceID."'";
	$database->setQuery( $query_invoice );
	$invoice_rows = $database->loadObjectList();

	$customer_row= & $customer_rows[0];
	$invoice_row= & $invoice_rows[0];

	$customerName="Customer Name : ".$customer_row->customer_title." ".$customer_row->customer_first_name." ".$customer_row->customer_last_name;
	$cName=$customer_row->customer_title." ".$customer_row->customer_first_name." ".$customer_row->customer_last_name;
	$customerAddress="Address  : ".$customer_row->address;
	$customerPhone=$customer_row->phone_no!=""?"Phone       : ".$customer_row->phone_no:"";
	$customerMobile=$customer_row->mobile_no!=""?"Mobile     : ".$customer_row->mobile_no:"";
	$customerEmail=$customer_row->email!=""?"E-mail     : ".$customer_row->email:"";
	$customerID_invoiceID="Customer ID  : ".$customerID."                                             ";
	$customerID_invoiceID.="                                                                            ";
	$customerID_invoiceID.="Coupon Number : ".$invoiceID;

	$pdf->ezText("",20);
	$pdf->ezText($customerID_invoiceID,10);
	$pdf->ezText($customerName,10);
	$pdf->ezText($customerAddress,10);
	if (trim($customerPhone)!="")
	$pdf->ezText($customerPhone,10);
	if (trim($customerMobile)!="")
	$pdf->ezText($customerMobile,10);
	if (trim($customerEmail)!="")
	$pdf->ezText($customerEmail,10);
	$pdf->ezText("",20);
	//$pdf->ezText('Date: '. date( 'j F, Y, H:i', time() + $mosConfig_offset*60*60 ), 9, $justification_arr_right);
	//$pdf->addText(435,700,10,"Info Product Coupon No. ".$invoice_row->id);
	$SLNO=1;
	$price=round($invoice_row->price,2);
	$discount=round($invoice_row->discount,2);
	$amount=$price-round(($price*$discount)/100,2);
	$total=$amount;

	$data=array();
	$arr=array( 'SLNO'=>stripslashes($SLNO)
	,'product_name'=>stripslashes($pName)
	,'price'=>$price==intval($price)?$price.".00":$price
	,'discount'=>$discount==intval($discount)?$discount.".00":$discount
	,'amount'=>$amount==intval($amount)?$amount.".00":$amount
	);

	array_push($data,$arr);


	if(trim(strtolower($mosConfig_owner))=="epb"){
		$cols = array( 'SLNO'=>"Sl. #",
		'product_name'=>'Trade Lead Name',
		'price'=>'Price (Tk.)',
		'discount'=>'Discount (%)',
		'amount'=>'Amount (Tk.)'
		);
	}
	else{
		$cols = array( 'SLNO'=>"Sl. #",
		'product_name'=>'Trade Lead Name',
		'price'=>'Price (Tk.)',
		'discount'=>'Discount (%)',
		'amount'=>'Amount (Tk.)'
		);
	}

	$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(0.7,0.7,0.7),'xPos'=>570,'xOrientation'=>'left','width'=>540,
	'cols'=>array(
	'SLNO'=>array('justification'=>'left','width'=>40),
	'product_name'=>array('justification'=>'left','width'=>200),
	'price'=>array('justification'=>'right','width'=>100),
	'discount'=>array('justification'=>'right','width'=>100),
	'amount'=>array('justification'=>'right','width'=>100),
	)), 9);


	//end of logic
	$pdf->ezText("",3);

	$data1=array();
	$cols1 = array( 'SLNO'=>'',
	'product_name'=>'',
	'price'=>'',
	'discount'=>'Total Tk.',
	'amount'=>$total==intval($total)?$total.".00":round($total,2)

	);

	$pdf->ezTable($data1,$cols1,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(1,1,1),'xPos'=>570,'xOrientation'=>'left','width'=>540,
	'cols'=>array(
	'SLNO'=>array('justification'=>'left','width'=>40),
	'product_name'=>array('justification'=>'left','width'=>200),
	'price'=>array('justification'=>'right','width'=>100),
	'discount'=>array('justification'=>'right','width'=>100),
	'amount'=>array('justification'=>'right','width'=>100),
	)), 9);
	$fraction=round($total,2)-intval($total);
	if ($fraction>0){
		$p=explode(".",$fraction);
		$paisa=$p[1];
		$pdf->ezText("In Words : Taka ".numtoword(round($total,2))." and Paisa ".numtoword($paisa)." Only",10);
	}
	else if (intval($total)>0)
	$pdf->ezText("In Words : Taka ".numtoword(round($total,2))." Only",10);

	// for authorized signature
	$pdf->ezText("",10);
	$signature="\n\n\n\n";
	$signature.=" __________________                                                                           ";
	$signature.="                                          ___________________";
	$signature.="\n";
	$signature.=" Authorized Signature                                                                       ";
	$signature.="                                                   Customer's Signature";

	$pdf->ezText($signature,10);
	/*
	$space="                 ";
	$customerHeading="Customer Information :";
	$customerInformation.=$space."Customer Id. : ".$customerID."\n";
	$customerInformation.=$space.$customerName."\n";
	$customerInformation.=$space.$customerAddress."\n";
	if (trim($customerPhone)!="")
	$customerInformation.=$space.$customerPhone."\n";
	if (trim($customerMobile)!="")
	$customerInformation.=$space.$customerMobile."\n";
	if (trim($customerEmail)!="")
	$customerInformation.=$space.$customerEmail."\n";

	$productHeading="Product Information :";
	$productInformation.=$space."Name : ".$pName."\n";
	$productInformation.=$space."Title Price : ".$price."\n";
	$productInformation.=$space."Discount : ".$discount."\n";
	$productInformation.=$space."Payable Amount : ".$amount."\n";
	//$productInformation.=$space.$pdf->ezText("In Words : ".numtoword($total)."Taka Only",10);



	$data2=array('customerInfo'=>$customerInformation);
	$cols2=array('customerInfo'=>'Customer Information :');

	$pdf->ezTable($data2,$cols2,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0, 'lineCol'=>array(1,1,1),'xPos'=>570,'xOrientation'=>'left','width'=>540,
	'cols'=>array(
	'customerInfo'=>array('justification'=>'left','width'=>540)
	)), 9);

	$pdf->ezText("Coupon No. : ".$invoiceID,10);
	$pdf->ezText("",5);
	$pdf->ezText('Date: '. date( 'j F, Y' ), 9);
	$pdf->ezText("",10);
	$pdf->ezText($customerHeading,10);
	$pdf->ezText("",5);
	$pdf->ezText($customerInformation,10);

	$pdf->ezText("",10);
	$pdf->ezText($productHeading,10);
	$pdf->ezText("",5);
	$pdf->ezText($productInformation,10);
	$pdf->ezText($space."In Words : ".numtoword($total)."Taka Only",10);
	*/
	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}

function circulationReportSentTo ( )
{
	global $database, $mosConfig_owner;

	include( 'includes/class.ezpdf.php' );

	$pdf =& new Cezpdf( 'a4', 'P' );  //A4 Portrait
	//$pdf -> ezSetCmMargins( 2, 1.5, 1, 1);
	$pdf->ezSetMargins(30,30,30,30);
	$pdf->selectFont( './fonts/Helvetica.afm' ); //choose font
	$pdf->setStrokeColor( 0, 0, 0, 1 );
	$pdf->ezSetDy(-10,'makeSpace');


	//define report for fax/email
	//$_REQUEST['report_for']=="1" for fax
	//$_REQUEST['report_for']=="2" for email
	if($_REQUEST['report_for']=="1")
	{
		if($_REQUEST['type']=='1')
		$query = " SELECT c.file_name from #__v3_circular as c, #__v3_circular_circulation cc
                         where cc.id='".$_REQUEST['id']."' and cc.circular_id=c.id ";
		else if($_REQUEST['type']=='2')
		$query = " SELECT t.file_name from #__v3_trade_fair as t, #__v3_trade_fair_circulation tfc
                         where tfc.id='".$_REQUEST['id']."' and tfc.circular_id=t.id ";
		else if($_REQUEST['type']=='3')
		$query = " SELECT d.dmfilename as file_name from #__docman as d, #__v3_trade_lead_circulation tlc
                         where tlc.id='".$_REQUEST['id']."' and tlc.circular_id=d.id ";
		$database->setQuery( $query );
		$rows = $database->loadObjectList();


		$field_name = "fax_number_id as member_id";
		$TITLE="Fax Circulation : \"".$_REQUEST['circular_name']."\"\nAttachment: ".$rows[0]->file_name;
	}
	else if($_REQUEST['report_for']=="2")
	{
		$field_name = "email_address_id as member_id";
		$TITLE="Email Circulation : \"".$_REQUEST['circular_name']."\"";
	}

	//Header
	if(strtolower(trim($mosConfig_owner))=="bkmea"){
		$NAME    =_CHAMBER_NAME_BKMEA;
		$ADDRESS =_ADDRESS_BKMEA;
		$CONTACT =_CONTACT_NUMBER_BKMEA;
		$EMAIL   =_EMAIL_BKMEA;
		ReportTitle($pdf, strtolower(trim($mosConfig_owner)),$NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center','','',false);
	}
	else if(strtolower(trim($mosConfig_owner))=="ccci"){
		$NAME    =_CHAMBER_NAME_CCCI;
		$ADDRESS =_ADDRESS_CCCI;
		$CONTACT =_CONTACT_NUMBER_CCCI;
		$EMAIL   =_EMAIL_CCCI;
		ReportTitle($pdf, strtolower(trim($mosConfig_owner)),$NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center','','',false);
	}
	else if(strtolower(trim($mosConfig_owner))=="scci"){
		$NAME    =_CHAMBER_NAME_SCCI;
		$ADDRESS =_ADDRESS_SCCI;
		$CONTACT =_CONTACT_NUMBER_SCCI;
		$EMAIL   =_EMAIL_SCCI;
		ReportTitle($pdf, strtolower(trim($mosConfig_owner)),$NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center','','',false);
	}else{
		$NAME    =_ORG_NAME;
		$ADDRESS =_ADDRESS_EPB;
		$CONTACT =_CONTACT_NUMBER_EPB;
		$EMAIL   =_EMAIL_EPB;
		ReportTitle($pdf, strtolower(trim($mosConfig_owner)), $NAME, $ADDRESS, $CONTACT, $EMAIL, $TITLE, 'center','','',false);
	}

	if($_REQUEST['type']=='1')
	$query="SELECT ".$field_name." from #__v3_circular_circulation where id='".$_REQUEST['id']."'";
	else if($_REQUEST['type']=='2')
	$query="SELECT ".$field_name." from #__v3_trade_fair_circulation where id='".$_REQUEST['id']."'";
	else if($_REQUEST['type']=='3')
	$query="SELECT ".$field_name." from #__v3_trade_lead_circulation where id='".$_REQUEST['id']."'";

	$database->setQuery( $query );
	$rows = $database->loadObjectList();
	$member_id = "'".str_replace(",","','",$rows[0]->member_id)."'";
	//$pdf->ezText($mosConfig_owner, 10);
	if(trim(strtolower($mosConfig_owner))=="epb")
	$query="SELECT name,contact_person,fax as fax1, email as email1,phone as phone1 from #__stakeholder where id IN(".$member_id.")";
	else if(trim(strtolower($mosConfig_owner))=="bkmea")
	{
		$query = " SELECT m.firm_name as name, m.member_reg_no, c.name as type, "
		." concat(m.applicant_title,' ',m.applicant_name,' ',m.applicant_last_name) "
		." as contact_person, m.applicant_fax as fax1,m.office_fax as fax2,"
		." m.applicant_email as email1,m.office_email as email2, "
		." m.applicant_office_phone as phone1,m.office_phone phone2"
		." from #__member as m, #__member_category as c "
		." where c.id=m.member_category_id and m.id IN(".$member_id.") order by m.member_reg_no ";
	}
	else if(trim(strtolower($mosConfig_owner))=="scci")
	{
		$query = " SELECT m.firm_name as name, m.member_reg_no, t.name as type, "
		." concat(m.applicant_title,' ',m.applicant_name,' ',m.applicant_last_name) "
		." as contact_person, m.firm_fax as fax1,m.head_office_fax as fax2,"
		." m.firm_email as email1,m.head_office_email as email2, "
		." m.firm_phone as phone1,m.head_office_phone as phone2"
		." from #__member as m, #__member_type as t "
		." where m.type_id=t.id and m.id IN(".$member_id.") order by m.member_reg_no ";
	}
	else if(trim(strtolower($mosConfig_owner))=="ccci")
	{
		$query = " SELECT m.firm_name as name, m.member_reg_no, t.name as type, "
		." concat(m.applicant_title,' ',m.applicant_name,' ',m.applicant_last_name) "
		." as contact_person, m.firm_fax as fax1,m.head_office_fax as fax2,"
		." m.firm_email as email1,m.head_office_email as email2, "
		." m.firm_phone as phone1,m.head_office_phone as phone2"
		." from #__member as m, #__member_type as t "
		." where m.type_id=t.id and m.id IN(".$member_id.") order by m.member_reg_no ";
	}
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$i=1;
	$data=array();

	foreach($rows as $row)
	{
		$SLNO  = $i;
		$phone = trim($row->phone1)!=""?($row->phone1.(trim($row->phone2)!=""?$row->phone2:"")):$row->phone2;
		$fax   = trim($row->fax1)!=""?($row->fax1.(trim($row->fax2)!=""?$row->fax2:"")):$row->fax2;
		$email = trim($row->email1)!=""?($row->email1.(trim($row->email2)!=""?$row->email2:"")):$row->email2;
		$typeName  = $row->type;
		$memberRegNo = $row->member_reg_no." - ".strtoupper($typeName[0]);

		if($_REQUEST['report_for']==1)
		{
			if(trim(strtolower($mosConfig_owner))!="epb")
			{
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'member_reg_no'=>$memberRegNo
				,'name'=>$row->name
				,'contact_person'=>$row->contact_person
				,'fax'=>$fax
				,'phone'=>$phone
				);
			}
			else
			{
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'name'=>$row->name
				,'contact_person'=>$row->contact_person
				,'fax'=>$fax
				,'phone'=>$phone
				);
			}
		}
		else if($_REQUEST['report_for']==2)
		{
			if(trim(strtolower($mosConfig_owner))!="epb")
			{
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'member_reg_no'=>$memberRegNo
				,'name'=>$row->name
				,'contact_person'=>$row->contact_person
				,'email'=>$email
				,'phone'=>$phone
				);
			}
			else
			{
				$arr=array( 'SLNO'=>stripslashes($SLNO)
				,'name'=>$row->name
				,'contact_person'=>$row->contact_person
				,'email'=>$email
				,'phone'=>$phone
				);
			}
		}
		array_push($data,$arr);
		$i++;
	}
	if($_REQUEST['report_for']==1)
	{
		if(trim(strtolower($mosConfig_owner))!="epb")
		{
			$cols = array( 'SLNO'=>'<b>Sl.</b>',
			'member_reg_no'=>'<b>Membership#</b>',
			'name'=>'<b>Name</b>',
			'contact_person'=>'<b>Contact Person</b>',
			'fax'=>'<b>Fax Number</b>',
			'phone'=>'<b>Phone</b>'
			);

			$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0,
			'lineCol'=>array(0.7,0.7,0.7),'xPos'=>580,'xOrientation'=>'left','width'=>560,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>40),
			'member_reg_no'=>array('justification'=>'left','width'=>70),
			'name'=>array('justification'=>'left','width'=>130),
			'contact_person'=>array('justification'=>'left','width'=>130),
			'fax'=>array('justification'=>'left','width'=>100),
			'phone'=>array('justification'=>'left','width'=>90)
			)), 9);
		}
		else
		{
			$cols = array( 'SLNO'=>'<b>Sl.</b>',
			'name'=>'<b>Name</b>',
			'contact_person'=>'<b>Contact Person</b>',
			'fax'=>'<b>Fax Number</b>',
			'phone'=>'<b>Phone</b>'
			);

			$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0,
			'lineCol'=>array(0.7,0.7,0.7),'xPos'=>580,'xOrientation'=>'left','width'=>560,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>40),
			'name'=>array('justification'=>'left','width'=>150),
			'contact_person'=>array('justification'=>'left','width'=>140),
			'fax'=>array('justification'=>'left','width'=>130),
			'phone'=>array('justification'=>'left','width'=>100)
			)), 9);
		}
	}
	else if($_REQUEST['report_for']==2)
	{
		if(trim(strtolower($mosConfig_owner))!="epb")
		{
			$cols = array( 'SLNO'=>'<b>Sl.</b>',
			'member_reg_no'=>'<b>Membership#</b>',
			'name'=>'<b>Name</b>',
			'contact_person'=>'<b>Contact Person</b>',
			'email'=>'<b>Email Address</b>',
			'phone'=>'<b>Phone</b>'
			);

			$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0,
			'lineCol'=>array(0.7,0.7,0.7),'xPos'=>580,'xOrientation'=>'left','width'=>560,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>40),
			'member_reg_no'=>array('justification'=>'left','width'=>70),
			'name'=>array('justification'=>'left','width'=>130),
			'contact_person'=>array('justification'=>'left','width'=>130),
			'email'=>array('justification'=>'left','width'=>100),
			'phone'=>array('justification'=>'left','width'=>90)
			)), 9);
		}
		else
		{
			$cols = array( 'SLNO'=>'<b>Sl.</b>',
			'name'=>'<b>Name</b>',
			'contact_person'=>'<b>Contact Person</b>',
			'email'=>'<b>Email Address</b>',
			'phone'=>'<b>Phone</b>'
			);

			$pdf->ezTable($data,$cols,'',array('showLines'=>2, 'showHeadings'=>1,'shaded'=> 0,
			'lineCol'=>array(0.7,0.7,0.7),'xPos'=>580,'xOrientation'=>'left','width'=>560,
			'cols'=>array(
			'SLNO'=>array('justification'=>'left','width'=>40),
			'name'=>array('justification'=>'left','width'=>150),
			'contact_person'=>array('justification'=>'left','width'=>140),
			'email'=>array('justification'=>'left','width'=>130),
			'phone'=>array('justification'=>'left','width'=>100)
			)), 9);
		}
	}



	ReportFooter($pdf);
	$pdf->ezSetDy( 30 );
	$pdf->ezStream();
}

if($option=="com_membership"){
	MemberDetail( $database );       //call detail membership report
}
else if ($option=="com_membership_certificate_scci" && $for=='ccs' && $off=='1'){
	MemberCertificite_office_copy_scci ( $database, $id,$working_reg_year_id,$for,$typeid);
}
else if ($option=="com_membership_certificate_scci" ){
	MemberCertificateScci ( $database, $id,$user_id,$working_reg_year_id,$typeid );
}
else if ($option=="com_membership_idcard_scci"){
	MemberIdcard( $database, $id , $user_id, $working_reg_year_id );
}
else if ($option=="com_membership_certificate_bkmea" && $off=='1'){
	MemberCertificite_office_copy ( $database, $id,$working_reg_year_id );
}
else if ($option=="com_membership_certificate_bkmea"){
	MemberCertificite ( $database, $id, $user_id, $working_reg_year_id );
}
else if ($option=="com_search_bkmea" && $pdf_type=="gen" ){
	AllMemberBkmea (  );
}
else if ($option=="com_search_bkmea"  && $pdf_type=="full" ){
	IndividualMemberBkmea ( );
}
else if ($option=="com_member_report_bkmea"){
	MemberReportBkmea();
}
else if ($option=="com_member_voterlist_scci" and $for==1){
	MemberVoterIDCardScci( 'scci', $database, $type_id, $last_reg_id );
}
else if ($option=="com_member_voterlist_scci"){
	MemberVoterlistScci( 'scci', $database, $type_id, $report_for, $last_reg_id );
}
else if ($option=="com_membership_scci" ){
	Memberprofile($id);
}
else if ($option=="com_accounts_transaction_report_scci" ){
	Accounts_Transaction_Report();
}
else if ($option=="com_member_report_scci" && $mailmerge==0 ){
	MemberReportScci('scci');
}
else if ($option=="com_member_report_scci" && $mailmerge==1 ){
	MailMergeScci('scci');
}
else if ($option=="com_search_scci" && $pdf_type=="gen" ){
	AllMemberScci (  );
}
else if ($option=="com_search_scci"  && $pdf_type=="full" ){
	IndividualMemberScci (  );
}
else if ($option=="com_search_ccci" && $pdf_type=="gen" ){
	AllMemberCcci (  );
}
else if ($option=="com_search_ccci"  && $pdf_type=="full" ){
	IndividualMemberCcci (  );
}
else if ($option=="com_membership_certificate_ccci" && $for=='ccc' && $off=='1'){
	MemberCertificite_office_copy_ccci ( $database, $id,$working_reg_year_id,$for);      //call detail membership report
}
else if ($option=="com_membership_certificate_ccci" && $for=='ccc'){
	MemberCertificite_ccc ( $database, $id , $user_id,$working_reg_year_id);
}
else if ($option=="com_member_report_ccci"  ){
	MemberReportCcci('ccci');
}
else if ($option=="com_member_voterlist_ccci" and $type_id!=5){
	MemberVoterlistCcci( 'ccci',$database, $type_id, $report_for, $last_reg_id );
}
else if ($option=="com_member_voterlist_ccci" and $type_id==5){
	DelegateVoterCCCI('ccci',$last_reg_id,1); // 1 for no. of valid voters
}
else if ($option=="com_delegate_voter_ccci" ){
	DelegateVoterCCCI('ccci',$last_reg_id);
}
else if ($option=="com_accounts_transaction_report_ccci" ){
	Accounts_Transaction_Report_CCCI();
}
else if ($option=="com_mail_merge_ccci"){
	MailMergeCCCI();
}
else if ($option=="com_mail_merge_bkmea"){
	MailMergeBkmea();
}
else if ($option=="com_all_mail_merge_bkmea"){
	AllMailMergeBkmea();
}
else if ($option=="com_docman" && $report_for=="coupon"){
	infoProductCoupon();
}
else if ($option=="com_accounts_transaction_report_bkmea" ){
	Accounts_Transaction_Report_BKMEA();
}
else if ($option=="com_info_product_sales_report" ){
	$for     = trim( mosGetParam( $_REQUEST, 'for' ));
	infoProductSalesReport($for);
}
else if ($option=="com_info_product_customer_report" ){
	$for     = trim( mosGetParam( $_REQUEST, 'for' ));
	infoProductCustomerReport($for);
}
else if ($option=="com_info_product_list_report" ){
	$for     = trim( mosGetParam( $_REQUEST, 'for' ));
	infoProductListReport($for);
}
else if ($option=="com_member_history_report" ){
	$for     = trim( mosGetParam( $_REQUEST, 'for' ));
	MemberHistoryReport($for);
}
else if ($option=="com_user_report" ){
	$for     = trim( mosGetParam( $_REQUEST, 'for' ));
	UserReport($for);
}
else if ($option=="com_all_member_report_bkmea"){
	AllMemberReportBkmea();
}
else if ($option=="com_member_report_scci_for_approval" ){
	MemberReportScci_forApproval();
}
else if ($option=="com_circulation"){
	circulationReportSentTo();
}
else if ($option == "com_top_member_report_bkmea") {
	TopMemberReportBkmea();
}
else
dofreePDF ( $database );

?>