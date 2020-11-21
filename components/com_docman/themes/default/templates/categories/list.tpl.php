<?php
/*
* Default Theme for DOCMan 1.3.0
* @version $Id: list.tpl.php,v 1.6 2006/06/21 04:16:31 morshed Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.mambodocman.com/
*/

/*
* Display the category list (required)
*
* General variables  :
*        $this->theme->path (string) : template path
*         $this->theme->name (string) : template name
*         $this->theme->conf (object) : template configuartion parameters
*        $this->theme->icon (string) : template icon path
*
* Template variables :
*        $this->items (array)  : holds an array of dcoument items
*/
$itm=& $this->items[0];
if (intval($itm->data->upload_year)==1):
    $title="Upload Year";
else:
    $title=_DML_TPL_CATS;
endif;
?>

<div id="dm_cats">
<h5><b><?php echo $title;?></b><span><b>Information Products</b>&nbsp;&nbsp;</span></h5>
<dl >
<?php
         /*
     * Include the list_item template and pass the item to it
    */

        foreach($this->items as $item) :
                if($this->theme->conf->cat_empty || $item->data->files != 0) :
                        include $this->loadTemplate('categories/list_item.tpl.php');
                endif;
        endforeach;
?>
</dl>
</div>
