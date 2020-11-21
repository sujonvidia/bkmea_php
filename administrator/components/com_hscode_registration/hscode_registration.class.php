<?php
/**
* Master_lc_info Table Class
*
* Provides access to the mos_templates table
* @package Mambo
*/
class mosHsCodeRegistrationUd extends mosDBTable {
        /** @var int Unique id*/
        var $id=null;
        var $name=null;
        var $description=null;
        var $hscode=null;
        var $parent_id=null;
        var $is_service=0;


        /**
        * @param database A database connector object
        */
        function mosHsCodeRegistrationUd( &$database ) {
                $this->mosDBTable( '#__product_line', 'id', $database );
        }


}
?>
