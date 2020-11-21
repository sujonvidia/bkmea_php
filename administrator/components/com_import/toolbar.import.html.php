<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class TOOLBAR_Import {  
        function _DEFAULT() {
                global $id;

                mosMenuBar::startTable();
                mosMenuBar::save('import','Import');
                mosMenuBar::spacer();
                mosMenuBar::cancel();
                mosMenuBar::endTable();
        }
}
?>
