<?php
/*
* Default Theme for DOCMan 1.3.0
* @version $Id: list_order.tpl.php,v 1.5 2006/06/25 06:45:40 morshed Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.mambodocman.com/
*/
/** edited by mic */

/*
* Display the documents list ordering (called by document/list.tpl.php)
*
* General variables  :
*        $this->theme->path (string) : template path
*         $this->theme->name (string) : template name
*         $this->theme->conf (object) : template configuartion parameters
*        $this->theme->icon (string) : template icon path
*
* Template variables :
*        $this->order->links     (array)  : holds an array of order by task links
*  $this->order->orderby   (string) : current orderby setting
*  $this->order->direction (string) : current order direction
*/
if (intval($upload_year)>0):
        $upload_year="&upload_year=".$upload_year;
else:
        $upload_year="";
endif;
?>
<div class="dm_orderby"> <?php echo _DML_TPL_ORDER_BY ?> :
<?php
        if($this->order->orderby != 'name') :
                ?><a href="<?php echo $this->order->links['name'].$upload_year ?>"><?php echo _DML_TPL_ORDER_NAME ?></a> | <?php
        else :
                 ?><strong><?php echo _DML_TPL_ORDER_NAME ?> </strong> | <?php
         endif;

        if($this->order->orderby != 'date') :
                 ?><a href="<?php echo $this->order->links['date'].$upload_year ?>"><?php echo _DML_TPL_ORDER_DATE ?></a> | <?php
         else :
                 ?><strong><?php echo _DML_TPL_ORDER_DATE ?> </strong> | <?php
         endif;

         if($this->order->orderby != 'hits') :
                 ?><a href="<?php echo $this->order->links['hits'].$upload_year ?>">#&nbsp;of&nbsp;downloads</a> <?php
         else :
                 ?><strong>#&nbsp;of&nbsp;downloads</strong> | <?php
         endif;

        if ($this->order->direction == 'ASC') :
                ?>[ <a href="<?php echo $this->order->links['dir'].$upload_year ?>"><?php echo _DML_TPL_ORDER_DESCENT ?></a> ]<?php
           else :
                ?>[ <a href="<?php echo $this->order->links['dir'].$upload_year ?>"><?php echo _DML_TPL_ORDER_ASCENT ?></a> ]<?php
        endif;
?>
</div>
