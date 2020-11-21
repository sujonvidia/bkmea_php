<?php
/*
* Default Theme for DOCMan 1.3.0
* @version $Id: list_item.tpl.php,v 1.14 2006/08/22 04:44:01 morshed Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.mambodocman.com/
*/

/*
* Display a category list item (called by categories/list.tpl.php)
*
* General variables  :
*        $this->theme->path (string) : template path
*         $this->theme->name (string) : template name
*         $this->theme->conf (object) : template configuartion parameters
*        $this->theme->icon (string) : template icon path
*
* Template variables :
*        $item->data                (object) : holds the category data
*  $item->links         (object) : holds the category operations
*  $item->paths         (object) : holds the category paths
*/
global $_DOCMAN,$mosConfig_live_site;
//if( (file_exists($_DOCMAN->getCfg('dmdownloadpath')."/".$item->data->id."/".$item->data->dmfilename) && trim($item->data->dmfilename)!="" ) || ( intval($item->data->dmlink)==1) ) :
// for category image
$iamge_path_array=explode("/",$_DOCMAN->getCfg('dmpath'));
$iamge_path_array_length=count($iamge_path_array)-1;
$image_path=$mosConfig_live_site."/".$iamge_path_array[$iamge_path_array_length];
// for category list by upload year
$upload_year=explode("-",$item->data->dmdate_published);
if ($item->data->upload_year):
$name=$upload_year[0];
$upload_year=$upload_year[0];

else:
$name=$item->data->name;
$upload_year=0;
endif;
?>
<dt class="dm_row">
<?php
switch ($this->theme->conf->cat_image) :
        case 0 : //none

                //do nothing
        break;

        case 1 : //icon
                if(file_exists($_DOCMAN->getCfg('dmpath')."/".$item->data->id."/".$item->data->image) && !empty($item->data->image)) :
                ?>
<a class="dm_icon" href="<?php echo $item->links->view;?>">
<img src="<?php echo $image_path;?>/<?php echo $item->data->id;?>/<?php echo $item->data->image;?>" width="20" height="20" alt="folder icon" />
</a>
                <?php
                else:
                ?>
    <a class="dm_icon" href="<?php echo $item->links->view;?>" >
<img src="<?php echo $image_path;?>/category_na.jpg" width="20" height="20" alt="folder icon" />
</a>
                <?php
                endif;
        break;

        case 2 : //thumb
                if($item->data->image) :
                ?><a class="dm_thumb" href="<?php echo $item->links->view;?>"><img src="<?php echo $item->paths->thumb;?>" alt="<?php echo $item->data->name;?>" /></a><?php
                endif;
        break;
endswitch;

?>
        <a class="dm_name" href="<?php echo $item->links->view."&upload_year=$upload_year";?>"  onMouseOver="javascript:window.status='Info Product Category';return true;"><?php echo $name;?></a>
</dt>

<dd class="dm_files"><?php echo $item->data->no_products?></dd>
<?php
/* blocked by camellia team shows the category description below the category name
if($item->data->description != '') :
        ?><dd class="dm_description"><?php echo $item->data->description;?></dd><?php
endif;
*/
//endif;
?>
