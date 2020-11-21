<?php

/**
* mos_circulation database table class
*/

class mosCirculation extends mosDBTable {
        /** @var int Unique id*/
        var $id                  = null;
        var $circular_id         = null;
        var $email_to_member     = null;
        var $email_to_others     = null;
        var $fax_number_id       = null;
        var $email_address_id    = null;
        var $username            = null;
        var $date                = null;
        var $email_to_board_or_director = null;
        var $others_email_address       = null;
        var $board_of_director  = null;

        /**
        * @param database A database connector object
        */
        function mosCirculation( &$database, $table ) {
                $this->mosDBTable( $table, 'id', $database );
        }

        // overloaded check function
        function check() {
                return true;
        }

}
?>