<?php

/**
* Document database table class
* @package DOCMan_1.3.0
*/

class mosDMDocument extends mosDBTable {
        var $id                      = null;
        var $catid                   = -1;
        var $dmname                  = null;
        var $dmfilename              = null;
        var $dmdescription           = null;
        var $dmdate_published        = null;
        var $dmowner                 = -1;
        var $published               = null;
        var $dmurl                   = null;
        var $dmcounter               = null;
        var $checked_out             = null;
        var $checked_out_time        = null;
        var $approved                = 1;
        var $dmthumbnail             = null;
        var $dmlastupdateon          = null;
        var $dmlastupdateby          = null;
        var $dmsubmitedby            = null;
        var $dmmantainedby           = null;
        var $dmlicense_id            = null;
        var $dmlicense_display       = null;
        var $access                  = null;
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

        function mosDMDocument(&$database)
        {
                $this->mosDBTable('#__docman', 'id', $database);
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
                        $this->_error .= "\\n" . "Name can not be blank";
                }
                if( $this->dmfilename == "" ){
                        $this->_error .= "\\n". "You must select file";
                }
                if( ! $this->catid ){
                        $this->_error .= "\\n" . "Please select category";
                }
                if( ! $this->search_keyword ){
                        $this->_error .= "\\n" . "You must enter search keyword";
                }
                if( ! $this->price_for_local_client ){
                        $this->_error .= "\\n" . "You must enter unit price for local client";
                }
                if( ! $this->dmdescription ){
                        $this->_error .= "\\n" . "You must enter abstract and description";
                }
                if( $this->dmowner == _DM_PERMIT_NOOWNER || $this->dmowner == "" ){
                        $this->_error .= "\\n" . "Owner can not be blank";
                }
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

}


/**
* mos_v3_trade_lead database table class
* This class is used to enter, update trade lead information;
* Validate information;
* Written by: Morshed Alam
*/

class mosTradeLead extends mosDBTable {
        /** @var int Unique id*/
        var $id              = null;
        var $doc_id          = null;
        var $query_by        = null;
        var $address         = null;
        var $phone           = null;
        var $email           = null;
        var $fax             = null;
        var $web             = null;
        var $contact_person  = null;
        var $country_id      = null;
        var $is_export_query = null;
        var $date            = null;

        /**
        * @param database A database connector object
        */
        function mosTradeLead( &$database ) {
                $this->mosDBTable( '#__v3_trade_lead', 'id', $database );
        }

        // overloaded check function
        function check() {
                return true;
        }

}


/**
* mos_v3_trade_lead_hscode database table class
*/

class mosTradeLeadHscode extends mosDBTable {
        /** @var int Unique id*/
        var $id          = null;
        var $doc_id      = null;
        var $hscode      = null;

        /**
        * @param database A database connector object
        */
        function mosTradeLeadHscode( &$database ) {
                $this->mosDBTable( '#__v3_trade_lead_hscode', 'id', $database );
        }

        // overloaded check function
        function check() {
                if(trim($this->hscode)==''){
                        $this->_error = "HS Code can not be blank.";
                        return false;
                }
                // check for existing yarn/fabric information
                $this->_db->setQuery( "SELECT id FROM #__product_line "
                . "\nWHERE hscode='".$this->hscode."' "
                );

                $hid = intval( $this->_db->loadResult() );
                if (!$hid ) {
                        $this->_error = "Invalid HS Code";
                        return false;
                }

                // check for existing yarn/fabric information
                $query = "Select count(id) from #__v3_trade_lead_hscode where doc_id='"
                        .$this->doc_id."' and hscode='".$this->hscode."' ";
                $this->_db->setQuery( $query );
                if ($this->_db->loadResult()!=0 ) {
                        $this->_error = "duplicate";
                        return false;
                }
                return true;
        }

}

?>
