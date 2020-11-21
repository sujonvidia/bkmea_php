<?php

/**
* mos_v3_trade_fair database table class
* This class is used to enter, update Trade fair information;
* Validate information;
* Written by: Morshed Alam
*/

class mosTradeFair extends mosDBTable {
        /** @var int Unique id*/
        var $id                = null;
        var $title             = null;
        var $file_name         = null;
        var $issue_date        = null;
        var $issue_by          = null;
        var $country_id        = null;
        var $venue_address     = null;
        var $contact_person    = null;
        var $phone             = null;
        var $email             = null;
        var $fax               = null;
        var $web               = null;
        var $start_date        = null;
        var $end_date          = null;
        var $search_keyword    = null;
        var $abstract          = null;
        var $date              = null;
        var $update_date       = null;
        var $entry_restriction = null;
        var $selector_organization = null;
        var $registration_fee  = null;

        /**
        * @param database A database connector object
        */
        function mosTradeFair( &$database ) {
                $this->mosDBTable( '#__v3_trade_fair', 'id', $database );
        }

        // overloaded check function
        function check() {
                // check circular title
                if (trim( $this->title ) == '') {
                        $this->_error = "You must enter circular title.";
                        return false;
                }
                return true;
        }

}

/**
* mos_v3_trade_fair_hscode database table class
* This class is used to enter, update trade fair information;
* Validate information;
* Written by: Morshed Alam
*/

class mosTradeFairHscode extends mosDBTable {
        /** @var int Unique id*/
        var $id            = null;
        var $trade_fair_id = null;
        var $hscode        = null;

        /**
        * @param database A database connector object
        */
        function mosTradeFairHscode( &$database ) {
                $this->mosDBTable( '#__v3_trade_fair_hscode', 'id', $database );
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
                $query = "Select count(id) from #__v3_trade_fair_hscode where trade_fair_id='"
                        .$this->trade_fair_id."' and hscode='".$this->hscode."' ";
                $this->_db->setQuery( $query );
                if ($this->_db->loadResult()!=0 ) {
                        $this->_error = "duplicate";
                        return false;
                }
                return true;
        }

}

?>
