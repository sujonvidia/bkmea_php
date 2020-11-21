<?php
/**
* @version $Id: mod_search_scci.php,v 1.3 2006/05/22 06:16:57 nnabi Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$button                        = $params->get( 'button', '' );
$button_pos                = $params->get( 'button_pos', 'left' );
$button_text        = $params->get( 'button_text', _SEARCH_TITLE );
$width                         = intval( $params->get( 'width', 20 ) );
$text                         = $params->get( 'text', _SEARCH_BOX );
$moduleclass_sfx         = $params->get( 'moduleclass_sfx' );

$output = '<input alt="search" class="inputbox'. $moduleclass_sfx .'" type="text" name="searchword" size="'. $width .'" value="'. $text .'"  onblur="if(this.value==\'\') this.value=\''. $text .'\';" onfocus="if(this.value==\''. $text .'\') this.value=\'\';" />';

if ( $button ) {
        $button = '<input type="submit" value="'. $button_text .'" class="button'. $moduleclass_sfx .'"/>';
}

switch ( $button_pos ) {
        case 'top':
                $button = $button .'<br/>';
                $output = $button . $output;
                break;

        case 'bottom':
                $button =  '<br/>'. $button;
                $output = $output . $button;
                break;

        case 'right':
                $output = $output . $button;
                break;

        case 'left':
        default:
                $output = $button . $output;
                break;
}
?>

<form action="<?php echo sefRelToAbs("index.php"); ?>" method="post">

<div align="left" class="search<?php echo $moduleclass_sfx; ?>">
<input type="hidden" name="option" value="com_docman" />
<input type="hidden" name="task" value="search_result" />
<input type="hidden" name="search_type" value="all">
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="text" id="search_phrase" name="search_phrase" size="15" class="inputbox" />
</div>
</form>
