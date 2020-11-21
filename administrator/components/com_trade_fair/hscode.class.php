<?php

/**
* mos_stakeholder database table class
* This class is used to enter, update stakeholder information;
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
