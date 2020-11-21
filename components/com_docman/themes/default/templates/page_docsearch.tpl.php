<?php
/*
* Default Theme for DOCMan 1.3.0
* @version $Id: page_docsearch.tpl.php,v 1.8 2006/06/25 06:45:40 morshed Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.mambodocman.com/
*/

/* Display the documents overview (required)
*
* This template is called when u user preform browse the docman
*
* General variables  :
*        $this->theme->path (string) : template path
*         $this->theme->name (string) : template name
*         $this->theme->conf (object) : template configuartion parameters
*        $this->theme->icon (string) : template icon path
*
* Preformatted html variables :
*        $this->html->menu             (string)(fetched from : general/menu.tpl.php)
*        $this->html->searchform        (string)(hardcoded)
*
* Template variables :
*        $this->items (array)  : holds an array of dcoument items
*/
?>

<?php $this->splugin('pagetitle', _DML_TPL_TITLE_SEARCH ) ?>

<!--?php echo $this->plugin('stylesheet', $this->theme->path . "css/theme.css") ?-->

<?php
if ($this->theme->conf->item_tooltip) :
    echo $this->plugin('overlib');
endif;

?>

<?php echo $this->html->menu; ?>

<h5 id="dm_title">Search Info Product</h5>

<?php echo $this->html->searchform ?>

<?php
// If we have not items to show return
if (count($this->items) == 0) :
    return;
endif;

?>

<!--hr /-->
<dl id="dm_docs">
<table width=100%>
<?php
    echo "<tr bgcolor='#eheheh'>
             <td width=5%></td>
             <td width=45%><b>Name</b></td>
             <td width=22%><b>Published Date</b></td>
             <td width=15% align=center><b>#&nbsp;of&nbsp;Downloads</b></td>
             <td width=13%></td>
             </tr>";
/*
     * Include the list_item template and pass the item to it
    */
$category = '';
foreach($this->items as $item) :
    if ($category != $item->data->category) :
        $category = $item->data->category ;
        ?><!--dt class="dm_cat">Category: <?php echo $item->data->category   ?></dt--><?php
    endif;
    $this->doc = &$item; //add item to template variables
    include $this->loadTemplate('documents/list_item.tpl.php');
endforeach;

?>
</table>
</dl>
