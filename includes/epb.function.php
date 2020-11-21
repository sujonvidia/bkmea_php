<?php


/*
* To get country list with id and name from pshop_country
* Written by Morshed Alam
*/
function countryList( $name, $active=NULL, $javascript=NULL, $order='ordering', $size=1, $sel_cat=1 ) {
        global $database;

        $query = "SELECT country_id AS value, country_name AS text  "
                ."\n FROM #__pshop_country where published = 1 "
        ;
        $database->setQuery( $query );
        if ( $sel_cat ) {
                $country[] = mosHTML::makeOption( '0', "Select Country" );
                $country = array_merge( $country, $database->loadObjectList() );
        } else {
                $country = $database->loadObjectList();
        }

        if ( count( $country ) < 1 ) {
                mosRedirect( 'index2.php?option=com_country', 'You must create Country List first.' );
        }

        $country = mosHTML::selectList( $country, $name, 'class="inputbox" size="'. $size .'" '. $javascript, 'value', 'text', $active );

        return $country;
}


/**
* Author: Morshed
* process file upload
* Check file extension and upload to destination directory
* @params String file source
* @params String destination directory for file upload
* if $isUnique==false no need to check file exists or not; replace existing file
* else check file exists or not;
* if $validFileFormat=="" no need to check file extension
* for original filename $filename==""
*/
function uploadFile($file,$savePath, $filename, $validFileFormat="", $isUnique=false)
{

        if(trim($validFileFormat)!=""){
                $validFileFormatArray = array();
                $validFileFormatArray = explode(",",$validFileFormat);
                $isValid = false;
                for($i=0;$i<count($validFileFormatArray);$i++){
                        $ext       = trim($validFileFormatArray[$i]);
                        if ($ext!="" && eregi($ext."$", $filename))
                        {
                                $isValid = true;
                                break;
                        }
                }
                if(!$isValid)
                {
                        $msg = "Upload failed! try with valid file formats are ".$validFileFormat;
                        return $msg;
                }
        }

        if (file_exists($savePath.$file['name'][0]))
        {
                if($isUnique){
                        $msg = "File allready exists";
                        return $msg;
                }
                else
                unlink($savePath.$file['name'][0]);
        }
        if(trim($filename)=="")
        $filename = $file['name'][0];

        if (!move_uploaded_file($file['tmp_name'][0], $savePath.$filename)){
                $msg = "Failed to upload file" ;
                return $msg;
        }
        return "done";
}


//prepare export for radio list by Morshed
function exportTISForList( $name, $active=NULL, $javascript=NULL ) {
        global $database;

        $pmode=array();
        $pmode['1']='BKMEA';
        $pmode['2']='Association';

        foreach($pmode as $key=>$val){
                if(trim(strtolower($active))==strtolower($key))
                   $html.="<input type='radio' name='".$name."' value='".$key."' checked> $val";
                else
                   $html.="<input type='radio' name='".$name."' value='".$key."' > $val";
                $html.="&nbsp;&nbsp;&nbsp;";
        }

        return $html;
}

?>
