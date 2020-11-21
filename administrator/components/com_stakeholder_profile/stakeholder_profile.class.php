<?php

/**
* mos_stakeholder database table class
* This class is used to enter, update stakeholder information;
* Validate information;
* Written by: Morshed Alam
*/

class mosStakeHolder extends mosDBTable {
        /** @var int Unique id*/
        var $id                    = null;
        var $name                  = null;
        var $is_partner            = null;
        var $stk_type              = null;
        var $contact_person        = null;
        var $address               = null;
        var $phone                 = null;
        var $mobile                = null;
        var $email                 = null;
        var $fax                   = null;
        var $web                   = null;
        var $organization_type_id  = null;
        var $trade_licence_no      = null;
        var $issue_authority       = null;
        var $issue_date            = null;
        var $expire_date           = null;
        var $tin_no                = null;
        var $import_reg_no         = null;
        var $export_reg_no         = null;
        var $reg_date              = null;
        var $date                  = null;
        var $update_date           = null;
        var $is_delete             = null;

        /**
        * @param database A database connector object
        */
        function mosStakeHolder( &$database ) {
                $this->mosDBTable( '#__stakeholder', 'id', $database );
        }

        // overloaded check function
        function check() {
                // check stakeholder name
                if (trim( $this->name ) == '') {
                        $this->_error = "You must enter stakeholder name.";
                        return false;
                }
                return true;
        }

}


/**
* mos_stakeholder database table class
* This class is used to enter, update stakeholder information;
* Validate information;
* Written by: Morshed Alam
*/

class mosStakeHolderAssociation extends mosDBTable {
        /** @var int Unique id*/
        var $id             = null;
        var $stk_id         = null;
        var $association    = null;

        /**
        * @param database A database connector object
        */
        function mosStakeHolderAssociation( &$database ) {
                $this->mosDBTable( '#__stakeholder_association', 'id', $database );
        }

        // overloaded check function
        function check() {
                // check for existing yarn/fabric information
                $query = "Select count(id) from #__stakeholder_association where stk_id='"
                        .$this->stk_id."' and association_id='".$this->association_id."' ";
                $this->_db->setQuery( $query );
                if ($this->_db->loadResult()!=0 ) {
                        return false;
                }
                return true;
        }

}

?>
