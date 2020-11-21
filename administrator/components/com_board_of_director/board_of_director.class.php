<?php
/**
* Master_lc_info Table Class
*
* Provides access to the mos_templates table
* @package Mambo
*/
class mosBoardOfDirector extends mosDBTable {
        /** @var int Unique id*/
        var $id = null;
        var $member_reg_no = NULL;
        var $member_category_id = 0;
        var $name = NULL;
        var $email_address = NULL;
        var $is_active = 0;

        /**
        * @param database A database connector object
        */
        function mosBoardOfDirector( &$database ) {
                $this->mosDBTable( '#__v3_board_of_director', 'id', $database );
        }

        function check(){
                if(trim($this->email_address)==""){
                        return false;
                }
                return true;
        }


}
?>
