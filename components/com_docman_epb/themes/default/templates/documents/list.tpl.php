<?php
/*
* Default Theme for DOCMan 1.3.0
* @version $Id: list.tpl.php,v 1.6 2006/06/25 06:45:40 morshed Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.mambodocman.com/
*/

/*
* Display the documents list (required)
*
* General variables  :
*        $this->theme->path (string) : template path
*         $this->theme->name (string) : template name
*         $this->theme->conf (object) : template configuartion parameters
*        $this->theme->icon (string) : template icon path
*
* Template variables :
*        $this->items (array)  : holds an array of dcoument items
*        $this->order (object) : holds the document list order information
*/
?>
<div id="dm_docs">
<h3>Trade Leads</h3>
<?php
$upload_year=$this->items[0]->data->upload_year;
/*
 * Include the documents list ordering template
*/
?>
<?php include $this->loadTemplate('documents/list_order.tpl.php'); ?>
<dl >
<?php
    /*
     * Include the list_item template and pass the item to it
    */
        echo "<table>";

    echo "<tr bgcolor='#eheheh'>
             <td width=5%></td>
             <td width=45%><b>Name</b></td>
             <td width=22%><b>Published Date</b></td>
             <td width=15% align=center><b>#&nbsp;of&nbsp;Downloads</b></td>
             <td width=13%></td>
             </tr>";
        foreach($this->items as $item) :
                $this->doc = &$item; //add item to template variables
                include $this->loadTemplate('documents/list_item.tpl.php');
        endforeach;
        echo "</table>";
?>
</dl>
</div>