<?php

class mosEmailBank extends mosDBTable {
        /** @var int Unique id*/
        var $id    = null;
        var $name  = null;
        var $email_address = null;

        /**
        * @param database A database connector object
        */
        function mosEmailBank( &$database ) {
                $this->mosDBTable( "#__email_bank", 'id', $database );
        }

        // overloaded check function
        function check() {
                // check for existing email
                $this->_db->setQuery( "SELECT count(id) FROM #__email_bank "
                . "\nWHERE email_address='".$this->email_address."' "
                );

                if (intval( $this->_db->loadResult())) {
                        return false;
                }
                else if (!ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $this->email_address)){
                        return false;
                }

                return true;
        }

}

?>
