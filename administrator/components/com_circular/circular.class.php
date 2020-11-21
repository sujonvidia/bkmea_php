<?php

/**
* mos_circular database table class
* This class is used to enter, update circular information;
* Validate information;
* Written by: Morshed Alam
*/

class mosCircular extends mosDBTable {
        /** @var int Unique id*/
        var $id                = null;
        var $title             = null;
        var $file_name         = null;  
        var $issue_date        = null;
        var $issue_by          = null;
        var $country_id        = null;
        var $search_keyword    = null;
        var $abstract          = null;
        var $date             = null;
        var $update_date      = null;

        /**
        * @param database A database connector object
        */
        function mosCircular( &$database ) {
                $this->mosDBTable( '#__v3_circular', 'id', $database );
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
* mos_v3_circular_hscode database table class
* This class is used to enter, update stakeholder information;
* Validate information;
* Written by: Morshed Alam
*/

class mosCircularHscode extends mosDBTable {
        /** @var int Unique id*/
        var $id          = null;
        var $circular_id = null;
        var $hscode      = null;

        /**
        * @param database A database connector object
        */
        function mosCircularHscode( &$database ) {
                $this->mosDBTable( '#__v3_circular_hscode', 'id', $database );
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

                $query = "Select count(id) from #__v3_circular_hscode where circular_id='"
                        .$this->circular_id."' and hscode='".$this->hscode."' ";

                $this->_db->setQuery( $query );
                if ($this->_db->loadResult()!=0 ) {
                        $this->_error = "duplicate";
                        return false;
                }
                return true;
        }

}

?>
