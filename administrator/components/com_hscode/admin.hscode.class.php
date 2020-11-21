<?php
/*
 HSCode (Harmonized System Code) Class used for business line information
 i.e products & services are maintained by an orgnization
 In this class 2, 4 & 8 digits HS-Code are used
*/
  class HSCode
  {
        // Class constructor
        function HSCode(){
        }
        // find parent HS-Code
        // @params $hscodeType integer
        function parentHSCode($hscodeType=0){
            global $mosConfig_dbprefix,$database;

            // query for retrieving parent HS-Code
            $query="select parent_hscode from #__hscode_map where type=".$hscodeType;
            $database->setQuery( $query );
            $rows = $database->loadObjectList();
            $parentHSCode=$rows[0]->parent_hscode;
            return $parentHSCode;

        }
        // find ID of the parent HS-Code
        // @params $parentHSCode string
        function parentHSCodeID($parentHSCode=Null){
            global $mosConfig_dbprefix,$database;

            // query for retrieving parent HS-Code id
            $query="select id from #__product_line where hscode in (".$parentHSCode.")";
            $database->setQuery( $query );
            $rows = $database->loadObjectList();
            $parentHSCodeId=Array();$i=0;
            if (count($rows)>0){
               foreach ($rows as $row){
                 $parentHSCodeId[$i]=$row->id;
                 $i++;
               }
            }
            return $parentHSCodeId;
        }
        // prepare query for building HS-Code drop down list
        // @params $parentId array
        // @params $name string (name of the droup down list)
        //@params $active decimal (selected HS-Code)
        function hsCodeList(&$parentId,$name=Null,$active=0){
            global $database;
               if (is_array($parentId))
                   $parentId=implode(',',$parentId);
                // query for building HS-Code Drop down list
                $query = "SELECT id AS value, concat(hscode,', ',name) AS text"
                . "\n FROM #__product_line where parent_id in (".$parentId.")"
                ;
                $database->setQuery( $query );
                $rows = $database->loadObjectList();

                if ( $sel_cat ) {
                        $pl[] = HSCode::makeOption( '0', "Select a Product" );
                        if (count($rows)>0)
                            $pl   = array_merge( $pl, $rows );
                } else {
                        $pl[] = HSCode::makeOption( '0', "Select a Product" );
                        if (count($rows)>0)
                            $pl   = array_merge( $pl, $rows );
                }

                $pl = HSCode::selectList($pl, $name, 'class="inputbox" size="'. $size .'" '. $javascript, 'value', 'text', $active );

                return $pl;

        }
        // create HS-Code select list
        function selectList( &$arr, $tag_name, $tag_attribs, $key, $text, $selected=NULL,$section='' ) {

                if (is_array($arr))
                    reset( $arr );

                $html = "\n<select name=\"$tag_name\" $tag_attribs>";

                for ($i=0, $n=count( $arr ); $i < $n; $i++ ) {
                        $k = $arr[$i]->$key;
                        $t = $arr[$i]->$text;
                        $id = @$arr[$i]->id;

                        $extra = '';
                        $extra .= $id ? " id=\"" . $arr[$i]->id . "\"" : '';
                        if (is_array( $selected )) {
                                foreach ($selected as $obj) {
                                        $k2 = $obj->$key;
                                        if ($k == $k2) {
                                                $extra .= " selected=\"selected\"";
                                                break;
                                        }
                                }
                        } else {
                                $extra .= ($k == $selected ? " selected=\"selected\"" : '');
                        }
                        $html .= "\n\t<option value=\"".$k."\"$extra>" . $t . "</option>";
                }
                $html .= "\n</select>\n";
                return $html;
        }

       /*
        * Query for creating Multiple select Country List
        */
        function MultiCountryList( $name, &$selected) {
                global $database;
                $query = "SELECT country_id AS value, country_name AS text"
                . "\n FROM #__pshop_country"
                . "\n where published = 1"
                ;
                $database->setQuery( $query );
                $clist = $database->loadObjectList();
                if (count($clist)==0)
                   $clist[]   = HSCode::makeOption( '0', "Select a Country" );

                $clist = HSCode::multipleselectList( $clist, $name, 'class=inputbox size=3 multiple', 'value', 'text', $selected );

                return $clist;
        }
        /*
        * Create Multiple select Country List
        */
        function multipleselectList( &$arr, $tag_name, $tag_attribs, $key, $text, &$selected ) {
                reset( $arr );
                $html = "\n<select name=\"$tag_name\" $tag_attribs>";
                for ($i=0, $n=count( $arr ); $i < $n; $i++ ) {
                        $k = $arr[$i]->$key;
                        $t = $arr[$i]->$text;
                        $id = @$arr[$i]->id;

                        $extra = '';
                        $extra .= $id ? " id=\"" . $arr[$i]->id . "\"" : '';
                        if (is_array( $selected )) {
                             for($j=0; $j<count($selected); $j++){
                                        $k2 = $selected[$j];
                                        if ($k == $k2) {
                                                $extra .= " selected";
                                                break;
                                        }
                                }
                        } else {
                                $extra .= ($k == $selected ? " selected=\"selected\"" : '');
                        }
                        $html .= "\n\t<option value=\"".$k."\"$extra>" . $t . "</option>";
                }
                $html .= "\n</select>\n";
                return $html;
        }
        // Make an object from an array element
        function makeOption( $value, $text='' ) {
                $obj = new stdClass;
                $obj->value = $value;
                $obj->text = trim( $text ) ? $text : $value;
                return $obj;
        }
  }


?>
