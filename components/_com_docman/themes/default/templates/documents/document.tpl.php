<?php
/*
* Default Theme for DOCMan 1.3.0
* @version $Id: document.tpl.php,v 1.4 2006/03/23 09:58:44 nnabi Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.mambodocman.com/
*/

/*
* Display document details (required)
*
* General variables  :
*        $this->theme->path (string) : template path
*         $this->theme->name (string) : template name
*         $this->theme->conf (object) : template configuartion parameters
*        $this->theme->icon (string) : template icon path
*
* Template variables :
*        $this->data                (object) : holds the document data
*   $this->links         (object) : holds the document operations
*   $this->paths         (object) : holds the document paths
*/
global $_DOCMAN;
?>
<table width="100%" cellspacing="0" >
<tr>
<td ><font size=3><b>Product detail </b></font></td>
</tr>
</table>
<div id="dm_details" class="dm_doc1">
<?php
if ($this->data->dmthumbnail) :
        ?><img src="<?php echo $this->paths->thumb ?>" alt="<?php echo $this->data->dmname;?>" /><?php
endif;
?>

<table width="100%" summary="todo" cellspacing="0" >
<col id="prop" />
<col id="val" />
<!--thead>
        <tr>
                <td width="30%" align="left">Property</td>
                <td align="left" width="70%">Value</td>
        </tr>
</thead-->
<tbody>

        <tr>
                <td width="170" align="left"></td>
                <td width="280" align="left"  ></td>
                <TD width="120" align=left></TD>
        </tr>
<?php
if($this->theme->conf->details_name) :

   if(trim($product_image)!=""){
        $product_image=$_DOCMAN->getCfg('dmpath')."/".$row->catid."/".$row->product_image;
   }
   else
       $product_image=$_DOCMAN->getCfg('dmpath')."/category_na.jpg";
?>
        <tr>
                 <td>
                 <?php echo _DML_TPL_NAME ?></td>
                 <td><?php echo $this->data->dmname ?></td>
                 <TD rowspan="6" valign="top"  height="125" width="125" >
                 <table border=1 width=100% height=125>
                 <tr>
                 <td height="125" width="125" align="center" valign="middle">
                 <img src="<?php echo $_DOCMAN->getCfg('dmpath')?>/not_available.jpg" width="120" height="120" >
                 </td>
                 </tr>
                 </table>
                 &nbsp;</TD>
         </tr>
        <?php
endif;
?>

          <tr>
                 <td>Product Category</td><td> <?php echo $this->cat->name ?> </td>
         </tr>
<?php
?>
          <tr>
                 <td>Number of Pages</td><td><?php echo $this->data->dm_volume ?></td>
         </tr>
<?php
/*
if($this->theme->conf->details_filename) :
         ?>
         <tr>
                 <td><?php echo _DML_TPL_FNAME ?></td><td><?php echo $this->data->filename ?></td>
         </tr>
        <?php
endif;
*/
if($this->theme->conf->details_filesize) :
        ?>
         <tr>
                 <td><?php echo _DML_TPL_FSIZE ?></td><td><?php echo $this->data->filesize ?></td>
         </tr>
        <?php
endif;
if($this->theme->conf->details_filetype) :
        ?>
         <tr>
                 <td><?php echo _DML_TPL_FTYPE ?></td><td colspan="2"><?php echo strtoupper($this->data->filetype); ?>
                 <!--&nbsp;(<?php //echo _DML_TPL_MIME.":&nbsp;".$this->data->mime ?>) -->
                 </td>
        </tr>
        <?php
endif;
?>
        <tr>
                 <td>Keyword </td>
                 <td colspan="2"><?php echo $this->data->search_keyword ?></td>
         </tr>
<?php
if($this->theme->conf->details_description) :
        ?>
         <tr>
                 <td>
                 <?php echo _DML_TPL_ABSTRACT_DESCRIPTION
                 ?>
                 </td>
                 <td colspan="2"><?php echo $this->data->dmdescription ?></td>
         </tr>
        <?php
endif;
if($this->theme->conf->details_submitter) :
        ?>
        <tr>
                 <td><?php echo _DML_TPL_SUBBY ?></td>
                 <td colspan="2"><?php echo $this->data->submited_by ?></td>
         </tr>
        <?php
endif;
if($this->theme->conf->details_created) :
        ?>
         <tr>
                 <td><?php echo _DML_TPL_SUBDT ?></td>
                 <td colspan="2">
                          <?php  $this->plugin('dateformat', $this->data->dmdate_published , _DML_TPL_DATEFORMAT_LONG); ?>
                 </td>
         </tr>
        <?php
endif;

if($this->theme->conf->details_price_for_member) :
        ?>
        <tr>
                 <td><?php echo _DML_TPL_PRICE_FOR_MEMBER ?></td>
                 <td colspan="2"><?php echo $this->data->price_for_member ?>&nbsp;Taka</td>
         </tr>
        <?php
endif;

if($this->theme->conf->details_price_for_local_customer) :
        ?>
        <tr>
                 <td><?php echo _DML_TPL_PRICE_FOR_LOCAL_CLIENT ?></td>
                 <td colspan="2"><?php echo $this->data->price_for_local_client ?>&nbsp;Taka</td>
         </tr>
        <?php
endif;

if($this->theme->conf->details_price_for_foreign_customer) :
        ?>
        <tr>
                 <td><?php echo _DML_TPL_PRICE_FOR_FOREIGN_CLIENT ?></td>
                 <td colspan="2"><?php echo $this->data->price_for_foreign_client ?>&nbsp;Taka</td>
         </tr>
        <?php
endif;

?>


         <!--tr>
                 <td>Price for Local Customer </td>
                 <td colspan="2">1000 Taka</td>
         </tr>
         <tr>
                 <td>Price for Foreign Customer</td>
                 <td colspan="2">5000 Taka</td>
         </tr-->
<?php
/*
if($this->theme->conf->details_readers) :
        ?>
         <tr>
                 <td><?php echo _DML_TPL_OWNER ?></td><td><?php echo $this->data->owner ?></td>
         </tr>
        <?php
endif;
if($this->theme->conf->details_maintainers) :
        ?>
         <tr>
                 <td><?php echo _DML_TPL_MAINT ?></td><td><?php echo $this->data->maintainedby ?></td>
         </tr>
        <?php
endif;
*/
if($this->theme->conf->details_downloads) :
        ?>
         <tr>
                 <td>
                 <?php echo _DML_TPL_NO_DOWNLOADS ?></td>
                 <td colspan="2"><?php echo $this->data->dmcounter; ?></td>
         </tr>
        <?php
endif;
if($this->theme->conf->details_updated) :
        ?>
         <tr>
                 <td><?php echo _DML_TPL_LASTUP ?></td>
                 <td colspan="2">
                         <?php  $this->plugin('dateformat', $this->data->dmlastupdateon , _DML_TPL_DATEFORMAT_LONG); ?>
                 </td>
         </tr>
        <?php
endif;
/*
if($this->theme->conf->details_homepage) :
        ?>
         <tr>
                 <td><?php echo _DML_TPL_HOME ?></td><td><?php echo $this->data->dmurl ?></td>
         </tr>
        <?php
endif;
*/
if($this->theme->conf->details_crc_checksum) :
        ?>
         <tr>
                 <td><?php echo _DML_TPL_CRC_CHECKSUM ?></td>
                 <td colspan="2"><?php echo $this->data->params->get('crc_checksum'); ?></td>
         </tr>
        <?php
endif;
if($this->theme->conf->details_md5_checksum) :
        ?>
         <tr>
                 <td><?php echo _DML_TPL_MD5_CHECKSUM ?></td>
                 <td colspan="2"><?php echo $this->data->params->get('md5_checksum'); ?></td>
         </tr>
        <?php
endif;
?>
</tbody>
</table>
<div class="clr"></div>
</div>
<dl>
<dd class="dm_taskbar">
<ul>
<?php
        $this->links->details = 0;
        $this->doc = &$this;
        include $this->loadTemplate('documents/tasks.tpl.php');
?>
<li><a href="index.php?option=com_docman&task=doc_purchase&step=1&pid=<?php echo $this->data->id; ?>"><?php echo _DML_TPL_PURCHASE ?></a></li>
<li><a href="javascript: history.go(-1);"><?php echo _DML_TPL_BACK ?></a></li>
</ul>
</dd>
</dl>
