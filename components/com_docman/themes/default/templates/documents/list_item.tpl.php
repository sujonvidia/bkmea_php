<?php
/*
* Default Theme for DOCMan 1.3.0
* @version $Id: list_item.tpl.php,v 1.24 2006/06/21 04:16:31 morshed Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.mambodocman.com/
*/

/*
* Display a documents list item (called by document/list.tpl.php)
*
* This template is called when u user preform browse the docman
*
* General variables  :
*        $this->theme->path (string) : template path
*         $this->theme->name (string) : template name
*         $this->theme->conf (object) : template configuartion parameters
*        $this->theme->icon (string) : template icon path


* Template variables :
*   $this->doc->data  (object) : holds the document data
*   $this->doc->links (object) : holds the document operations
*   $this->doc->paths (object) : holds the document paths
*/

/** edited by mic */
 /*
if(!$this->doc->data->approved) :
        ?><dt class="dm_unapproved"><?php
elseif(!$this->doc->data->published) :
        ?><dt class="dm_unpublished"><?php
else :
        ?>
        <dt>
        <td>
<?php
endif;
 */
//output document image
global $_DOCMAN,$mosConfig_live_site;
if( ( file_exists($_DOCMAN->getCfg('dmdownloadpath')."/".$this->doc->data->catid."/".$this->doc->data->dmfilename) && trim($this->doc->data->dmfilename)!="" ) || ( intval($this->doc->data->dmlink)==1) ) :
$iamge_path_array=explode("/",$_DOCMAN->getCfg('dmpath'));
$iamge_path_array_length=count($iamge_path_array)-1;
$image_path=$mosConfig_live_site."/".$iamge_path_array[$iamge_path_array_length];
echo "<tr><td>";
switch($this->theme->conf->doc_image) :
         case 0 :  //none
                //do nothing
        break;

         case 1 :   //icon
                 if($this->doc->links->download) :
                 ?><a class="dm_icon" href="<?php echo $this->doc->links->download;?>"><?php
                 else :
                ?><a class="dm_icon"><?php
                endif;
                ?>
                        <!--img src="<?php echo $this->doc->paths->icon;?>" alt="file icon" /-->
                        <?php
                        if(file_exists($_DOCMAN->getCfg('dmpath')."/".$this->doc->data->catid."/".$this->doc->data->dmimage) && $this->doc->data->dmimage!="") :

                        ?>
                          <img src="<?php echo $image_path;?>/<?php echo $this->doc->data->catid?>/<?php echo $this->doc->data->dmimage?>" width="20" height="20" alt="file icon" />
                        <?php
                        else :
                        ?>
                              <img src="<?php echo $image_path;?>/img_na.jpg" width="20" height="20" alt="file icon" />
                        <?php
                        endif;
                        ?>
                </a>
                <?php
        break;

         case 2  :  //thumb
                 if($this->doc->data->dmthumbnail) :
                 if($this->doc->links->download)   :
                 ?><a class="dm_thumb" href="<?php echo $this->doc->links->download;?>"><?php
                 else :
                ?><a class="dm_thumb"><?php
                endif;
                ?>
                        <img src="<?php echo $this->doc->paths->thumb; ?>" alt="" />
                </a>
                 <?php
                 endif;
         break;
endswitch;
echo "</td><td>";

//output document link
if($this->doc->links->download) :
?>
  <a class="dm_name" href="<?php echo $this->doc->links->download;?>">
<?php
else :
?>
<!--popup window for product details-->
    <script language="javascript" type="text/javascript">
        var newWin;
        function newwindow(pid,cid){
           if (null != newWin && !newWin.closed)

              closeNewWindow();
              page='./popup/product_details.php?pid='+pid;
              newWin=window.open(page,'','width=450,height=300,scrollbars=yes,resizable=no,top=180,left=200,status=no,menubar=no,directories=no,location=no,toolbar=no');
              newWin.focus();

        }
    </script>
<!--a class="dm_name" href="<?php echo $this->doc->links->details?>&cat_id=<?php echo $this->doc->data->catid?>"-->
    <a href="javascript:newwindow(<?php echo $this->doc->data->id?>,<?php echo $this->doc->data->catid?>);" title=" Info Product Details "  onMouseOver="javascript:window.status='Info Product';return true;">
<?php
endif;
        //$product_name=$this->doc->data->dmname." (";
        ////$product_name.=$this->doc->data->dmlink==0?$this->doc->data->filesize:"Not Applicable";
        //$product_name.=$this->doc->data->dm_volume>0?", ".$this->doc->data->dm_volume:"";
        //$product_name.=")";
        $product_name=$this->doc->data->dmname;
        echo $product_name;
        if($this->doc->data->state) :
           ?><!--span><?php echo $this->doc->data->state ?></span--><?php
        endif;
        if($this->theme->conf->item_tooltip) :
              $this->item = &$this->doc;
              $tooltip = $this->fetch('documents/tooltip.tpl.php');
               $icon    = $this->theme->path."images/icons/16x16/tooltip.png";
                 // inactive by camellia team
                 //echo $this->plugin('tooltip',  $this->doc->data->id, '&nbsp;Product Tooltip', $tooltip, $icon);
        endif;
?>
</a>
</td>

<?php
//output document date
if ( $this->theme->conf->item_date ) :
        ?>
        <!--dd class="dm_date"-->
        <td>
        <?php
        //$this->plugin('dateformat', $this->doc->data->dmdate_published, _DML_TPL_DATEFORMAT_SHORT);
        echo date('F j, Y',strtotime($this->doc->data->dmdate_published));
        ?>
        <!--/dd-->
        </td>
        <?php
endif;
//output document description
if ( $this->theme->conf->item_description  ) :
        ?>
        <!--dd class="dm_description"-->
                <?php
                  //echo $this->doc->data->dmdescription;
                ?>
        <!--/dd-->
        <?php
endif;
//output document url
/*
if ( $this->theme->conf->item_homepage && $this->doc->data->dmurl != '') :
        ?>
         <!--dd class="dm_homepage"-->
         <td>
                <?php
                echo _DML_TPL_HOMEPAGE;?>:
                <a href="<?php echo $this->doc->data->dmurl;?>">
                <?php echo $this->doc->data->dmurl;?></a>
        <!--/dd-->
        </td>
        <?php
endif;
*/
//output document counter
if ( $this->theme->conf->item_hits  ) :
        ?>
        <!--dd class="dm_counter"-->
        <td align=center>
                <?php echo $this->doc->data->dmcounter;?>
        <!--/dd-->
        </td>
        <?php
endif;
?>

<td>
<!--modified by camellia team-->
<!--dd class="dm_taskbar">
<ul>
<LI>
<?php include $this->loadTemplate('documents/tasks.tpl.php');  ?>
</LI>
</td>
</ul>
</dd-->


<dl>
<dd class="dm_taskbar">
<ul>
<?php
        $this->links->details = 0;
        //$this->doc = &$this;
        //include $this->loadTemplate('documents/tasks.tpl.php');
if (intval($this->doc->data->dmlink)==1):
global $mosconfig_directory_link;
?>
<li><a href="<?php echo $mosconfig_directory_link; ?>&pid=<?php echo $this->doc->data->id;?>" onMouseOver="javascript:window.status='Info Product';return true;"><?php echo _DML_TPL_PURCHASE ?></a></li>
<?php
else:
?>
<li><a href="index.php?option=com_docman&task=doc_purchase&step=1&pid=<?php echo $this->doc->data->id;?>&cat_id=<?php echo $this->doc->data->catid?>"><?php echo _DML_TPL_PURCHASE ?></a></li>
<?php
endif;
?>
</ul>
</dd>
</dl>

</tr>
<?php
endif;
?>
