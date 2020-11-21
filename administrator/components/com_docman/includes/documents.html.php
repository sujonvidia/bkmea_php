<?php
/*
* DOCMan 1.3.0 for Mambo 4.5.1 CMS
* @version $Id: documents.html.php,v 1.32 2006/07/12 09:50:48 morshed Exp $
* @package DOCMan 1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.mambodocman.com/
*/
/**
* * edited by mic
*/

defined('_VALID_MOS') or die('Direct access to this location is not allowed.');

if (defined('_DOCMAN_HTML_DOCUMENTS')) {
    return;
} else {
    define('_DOCMAN_HTML_DOCUMENTS', 1);
}

class HTML_DMDocuments
{
    function showDocuments($rows, $lists, $search, $pageNav, $number_pending, $number_unpublished, $view_type = 1,$dm_not_expire)
    {
        global $database, $my, $_DOCMAN;
        global $mosConfig_live_site;
        ?>
        <form action="index2.php" method="post" name="adminForm">
        <table class="adminheading">
            <tr>
                <th>
                Info Product Management
                </th>
                <td><?php echo _FILTER;?></td>
                <td><input class="text_area" type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" /></td>
                <td><?php echo $lists['catid'];?></td>
            </tr>
        </table>
        <table class="adminlist">

          <tr>
           <th width="1%">
               Sl&nbsp;#
            </th>
            <th width="2%" align="left" >
            <!--input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows);?>);" /-->
            </th>
            <th width="33%" align="left">
            <a href="index2.php?option=com_docman&section=documents&sort=name"><?php echo _DML_NAME;?></a>
            </th>
            <th width="20%" align="left">
            <a href="index2.php?option=com_docman&section=documents&sort=catsubcat"><?php echo _DML_CATEGORY;?></a>
            </th>
            <th width="4%">
            <?php echo _DML_PUBLISHED;?>
            </th>
            <th width="8%" nowrap="nowrap">
            <?php echo _DML_SIZE;?>
            </th>
            <th width="8%">
            #&nbsp;of&nbsp;Downloads
            </th>
            <th width="16%" align="center">
            <a href="index2.php?option=com_docman&section=documents&sort=date"><?php echo _DML_DATE;?></a>
            </th>
          </tr>
          <?php
        $k = 0;
        for ($i = 0, $n = count($rows);$i < $n;$i++) {
            $row = &$rows[$i];
            $task = $row->published ? 'unpublish' : 'publish';
            $img = $row->published ? 'tick.png' : 'publish_x.png';
            $alt = $row->published ? _DML_PUBLISHED : _DML_UNPUBLISH ;

            $file = new DOCMAN_File($row->dmfilename, $_DOCMAN->getCfg('dmpath'),$row->catid);
            $expire_id="";
            ?>
            <tr class="row <?php echo $k;?>">
            <td width="10">
                <?php
                echo $i+1;
                ?>
                </td>
                <td width="10">
                <?php
                //echo mosHTML::idBox($i, $row->id, ($row->checked_out && $row->checked_out != $my->id));
                echo mosHTML::idBox($i, $row->id, 0);
                ?>
                </td>
                <td width="15%">
                <a href="#edit" onclick="return listItemTask('cb<?php echo $i;?>','edit')">
                <?php echo $row->dmname;?>
                </a>
                <?php
                //}
                ?>
                </td>
                <td ><?php echo $row->treename ?></td>
                <td align="center">
                    <a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
                    <img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt;?>" />
                    </a>
                </td>
                <td align="center">
                <?php
                if ($file->exists($row->catid) && $row->dmlink==0) {
                    echo $file->getSize();
                }
                else
                  echo "Not Applicable";
                ?>
                </td>
                <td align="center"><?php echo $row->dmcounter;?></td>


                <td align="center">
                <?php
                echo mosHTML::ConvertDateDisplayLong($row->dmdate_published);
                ?>
                </td>
                </tr>
                <?php
                $k = 1 - $k;
        }
        ?>
      </table>
      <?php echo $pageNav->getListFooter();?>

      <input type="hidden" name="option" value="com_docman" />
      <input type="hidden" name="dm_not_expire" value="<?php echo $dm_not_expire;?>" />
      <input type="hidden" name="section" value="documents" />
      <input type="hidden" name="task" value="" />
      <input type="hidden" name="boxchecked" value="0" />
      <input type="hidden" name="hidemainmenu" value="0">
      </form>

             <?php
      //require_once ("../components/com_docman/footer.php");
    }

    function editDocument(&$row, &$lists, $last, $created, &$params)
    {
        global $database, $mosConfig_offset, $mosConfig_live_site, $mosConfig_locale;
        global $_DOCMAN,$mosconfig_directory_link, $mosconfig_calender_date_format;
        //prepare original file name
        $original_filename_arr=array();
        $original_filename_arr = explode("_",$row->dmfilename);
        $original_filename_arr = array_slice($original_filename_arr,2) ;
        $original_filename = implode("_",$original_filename_arr);

        //Category image
        $iamge_path_array=explode("/",$_DOCMAN->getCfg('dmpath'));
        $iamge_path_array_length=count($iamge_path_array)-1;
        $image_path=$mosConfig_live_site."/".$iamge_path_array                [$iamge_path_array_length];
        if(trim($row->dmimage)!=null and file_exists($_DOCMAN->getCfg('dmpath')."/".$row->catid."/".$row->dmimage))
           $product_image=$image_path."/".$row->catid."/".$row->dmimage;
        else
            $product_image=$image_path."/not_available.jpg";

        //$tabs = new mosTabs(0);
        mosMakeHtmlSafe($row);

        $tmp_locale = substr($mosConfig_locale, 0, 2);
        // now try to get the locale data
        if (file_exists('../includes/js/calendar/lang/calendar-' . $tmp_locale . '.js')) {
            $tmp_cal_source = $mosConfig_live_site . '/includes/js/calendar/lang/calendar-' . $tmp_locale . '.js';
        } else $tmp_cal_source = $mosConfig_live_site . '/includes/js/calendar/lang/calendar-en.js';

        ?>
            <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
            <script language="JavaScript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js" type="text/javascript"></script>
            <script language="JavaScript" type="text/javascript">
                    <!--


                var arr = new Array();
                   arr[27] ="0";
                   arr[28] ="1";
                   arr[29] ="2";
                   arr[30] = "3";
                   arr[31] = "4";
                   arr[32] = "5";
                   arr[33] = "6";
                   arr[34] = "7";
                   arr[35] = "8";
                   arr[36] = "9";
                   arr[37] = ".";

                function check_IntNumber(obj,mid)
                {
                   var i=0,j=0;
                   var str="";
                   var c=0;
                   var form = document.adminForm;
                   var msg=mid;

                   str=form.elements[obj].value;

                   for(i = 0 ; i < str.length; i++)
                   {
                      for(j = 27 ; j < 37; j++)
                      {
                        if(str.charAt(i) == arr[j])
                           break;
                      }
                      if(j>36)
                      {

                        alert(msg);
                        var temp = parseInt(str);
                        if(isNaN(temp))
                          form.elements[obj].value=0;
                        else
                          form.elements[obj].value=temp;
                        form.elements[obj].focus();
                        form.elements[obj].select();
                        break;
                      }
                   }
                }
                function check_FloatNumber(obj,mid)
                {
                   var i=0,j=0;
                   var str="";
                   var c=0;
                   var che=0;
                   var form = document.adminForm;
                   var msg=mid;

                   str=form.elements[obj].value;

                   for(i = 0 ; i < str.length; i++)
                   {
                      for(j = 27 ; j < 38; j++)
                      {
                         if(str.charAt(i) == arr[j]){
                          if ((str.charAt(i)==".")&& (che==0))
                          {
                                  che=1;
                          }
                          else if ((str.charAt(i)==".")&& (che==1))
                          {
                              alert(msg);
                              var temp = parseFloat(str);
                              form.elements[obj].value=temp;
                              form.elements[obj].focus();

                          }
                           break;
                        }

                      }
                      if(j>37)
                      {

                        alert(msg);
                        var temp = parseFloat(str);
                        if(isNaN(temp))
                          form.elements[obj].value=0;
                        else
                        form.elements[obj].value=temp;
                        form.elements[obj].focus();
                        break;
                      }
                   }
                }

                function submitbutton(pressbutton, section) {
                      var form = document.adminForm;

                      var id='<?php echo $row->id; ?>';
                      var file='<?php echo $row->dmfilename; ?>';
                      var image='<?php echo $row->dmimage; ?>';
                      var img=form.elements['dmimage'].value;
                      var len=img.length;
                      img1=img.substr(len-3,3);
                      img2=img.substr(len-4,4);

                      var fileData=form.elements['dmfilename'].value;
                      var filelen=fileData.length;
                      file_ext=fileData.substr(filelen-3,3);

                      if (pressbutton == 'cancel') {
                             submitform( pressbutton );
                             return;
                      }

                      if (trim(form.dmname.value) == ""){
                               alert("Name of the info product cannot be blank.");
                               form.dmname.focus();
                      }
                      else if (trim(file)=="" && form.dmfilename.value == "" && form.dmlink.checked==false) {
                               alert("You must select info product or info product link.");
                               form.dmfilename.focus();
                      }else if(form.elements['dmfilename'].value != "" && file_ext.toLowerCase()!="pdf"){
                               alert("Enter valid info product.");
                               form.elements['dmfilename'].focus();
                      }/*
                      else if ((trim(file)!="" || form.dmfilename.value != "") && form.dmlink.value!="") {
                               alert("You must select info product or info product link.");
                               form.dmfilename.focus();
                      }  */
                      else if(trim(image)=="" && form.elements['dmimage'].value == ""){
                               alert("You must select info product image.");
                               form.elements['dmimage'].focus();
                      }
                      else if(form.elements['dmimage'].value != "" && img1.toLowerCase()!="jpg" && img2.toLowerCase()!="jpeg"){
                               alert("Enter valid image.");
                               form.elements['dmimage'].focus();
                      }
                      else if (form.catid.value == "0") {
                               alert("You must select info product category.");
                               form.catid.focus();
                      }
                      else if(trim(form.search_keyword.value) == ""){
                               alert("You must enter search keyword.");
                               form.search_keyword.focus();
                      } /*
                      else if(form.price_for_local_client.value == ""){
                               alert("Please enter unit price for member.");
                               form.price_for_local_client.select();
                               form.price_for_local_client.focus();
                      }
                      else if(form.price_for_foreign_client.value == 0 || form.price_for_foreign_client.value == ""){
                               alert("You must enter unit price for foreign client");
                               form.price_for_foreign_client.select();
                               form.price_for_foreign_client.focus();
                      }
                      else if(form.price_for_member.value == ""){
                               alert("Please enter unit price for non-member.");
                               form.price_for_member.select();
                               form.price_for_member.focus();
                      } */
                      else if(trim(form.dmdescription.value) == ""){
                               alert("Please enter abstract.");
                               form.dmdescription.focus();
                      }
                      else {
                                <?php getEditorContents('editor1', 'description') ;?>
                                //if(form.dmdate_expire.value == '0000-00-00' || form.dmdate_expire.value == "" ){
                                   // form.dmdate_expire.value="2006-12-31";
                                //}
                                submitform(pressbutton);
                      }
                }
                        //--> end submitbutton
            </script>

            <link rel="stylesheet" type="text/css" media="all" href="<?php echo $mosConfig_live_site;?>/includes/js/calendar/calendar-mos.css" title="green" />

            <script type="text/javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/calendar/calendar.js"></script>
            <script type="text/javascript" src="<?php echo $tmp_cal_source;?>"></script>
            <form action="index2.php" method="post" name="adminForm" class="adminform" id="dm_formedit" enctype="multipart/form-data">

                <table class="adminheading">
                <tr>
                        <th >
                        Info Product Management :
                        <small>
                        <?php echo $row->id ? 'Edit' : 'New'; ?>
                        </small>
                        </th>
                </tr>
                </table>
                <table width="100%">
                <tr>
                        <td width="100%" valign="top">
                                <table class="adminform">
                                <tr>
                                        <th colspan="3">
                                        Details <small>( Fields marked with an asterisk * are required )</small>
                                        </th>
                                </tr>

                                <tr>
                                  <td width="25%" align="right">* Name of the Info Product : </td>
                                  <td  width="75%" >
                                  <input class="inputbox" type="text" name="dmname" size="50" maxlength="100" value="<?php echo $row->dmname ?>" />
                                  </td>
                                </tr>
                                <tr >
                                 <td align="right">
                                 * Info Product :
                                 </td>
                                 <td  align="left"  colspan="2">
                                 <input name="dmfilename" type="file" id="upload" size="35">
                                 <?php echo mosToolTip('Select info product to upload.<br>Info products file format (.pdf)', 'Info Product','220');?>

                                 </td>
                                </tr>
                                <tr >
                                 <td align="right">
                                 </td>
                                 <td  align="left"  colspan="2">
                                 <?php echo $original_filename;?>
                                 </td>
                                </tr>
                                <tr >
                                 <td align="right">
                                 Info Product Link :
                                 </td>
                                 <td  align="left"  colspan="2">
                                 <input <?php if($row->dmlink==1) echo "checked";?> type="checkbox" name="dmlink">
                                 <!--input <?php if($row->product_type==0) echo "checked";?> type="checkbox" value="1" name="link" onclick="javascript:if(document.adminForm.link.checked==true) document.adminForm.dmlink.value='<?php echo $mosconfig_directory_link;?>'; else document.adminForm.dmlink.value='';">
                                 <input class="inputbox" type="text" name="dmlink" size="46" maxlength="100" value="<?php echo $row->dmlink ?>" readonly /-->
                                 &nbsp;<?php echo mosToolTip('Click checkbox to enter info product link. ', 'Info Product Link','220');?>
                                 </td>
                                </tr>
                                <tr >
                                 <td align="right">
                                 * Info Product Image :
                                 </td>
                                 <td  align="left" >
                                 <input name="dmimage" type="file" id="upload" size="35">
                                 <?php echo mosToolTip('Select an image for your info product. You can upload only .jpg or .jpeg image  and recomended size is 120px X 120px', 'Info Product Image','260');?>
                                 </td>
                                 <td rowspan="4" align="left" width="30%">
                                 <img src='<?php echo $product_image; ?>' name="imagelib" width="120" height="120" border="2" alt="Preview" />
                                 <?php
                                 //if(trim($row->dmimage)!=null){  ?>
                                        <!--br><A href="index2.php?option=com_docman&section=documents&task=removeimage&cid=<?php echo $row->id; ?>&image=<?php echo $row->dmimage; ?>">Remove Image</a-->
                                 <?php
                                 //}
                                 ?>
                                 </td>
                                </tr>
                                 <tr>
                                        <td valign="top" align="right">
                                        </td>
                                        <td valign="top">
                                        Image Format (JPG, JPEG) & Image Size (120 x 120 Pixels)
                                        </td>
                                </tr>
                                <tr>

                                 <td align="right" >* Info Product Category :</td>
                                 <td ><?php echo $lists['catid'];?></td>
                                </tr>
                                <tr>
                                 <td align="right">Date of Publication :</td>
                                 <td> <input class="inputbox" type="text" name="dmdate_published" id="dmdate_published" size="25" maxlength="19" value="<?php echo mosHTML::ConvertDateDisplayShort($row->dmdate_published); ?>" readonly />
                                 <input type="reset" class="button" value="..." onclick="return showCalendar('dmdate_published', '%d-%m-%Y');" />
                                 <?php echo mosToolTip('By default the date of publication will be current system date', 'Date of Publication','250');?>
                                 </td>
                                </tr>
                                <tr>
                                 <td align="right">Date of Expiry :</td>
                                 <td>
                                 <input class="inputbox" type="text" name="dmdate_expire" id="dmdate_expire" size="25" maxlength="19" value="<?php echo mosHTML::ConvertDateDisplayShort($row->dmdate_expire); ?>" readonly />
                                 <input type="reset" class="button" value="..." onclick="return showCalendar('dmdate_expire', '<?php echo $mosconfig_calender_date_format; ?>');" />
                                 <?php echo mosToolTip('By default info product will expire after one year from the date of publication.', 'Date of Expiry','270');?>
                                 </td>
                                </tr>
                                <tr>
                                 <td valign="top"  align="right">* Search Keyword : </td>
                                 <td colspan="2">
                                 <input class="inputbox" type="text" name="search_keyword" size="50" maxlength="200" value="<?php echo $row->search_keyword; ?>" />
                                 <?php echo mosToolTip('Anyone can search this product by using search keyword', 'Search Keyword','250');?>
                                 </td>
                                </tr>
                                <tr>
                                 <td valign="top" align="right">Number of Pages : </td>
                                 <td colspan="2">
                                 <input class="inputbox" type="text" name="dm_volume" size="20" maxlength="5" value="<?php echo $row->dm_volume; ?>"  onKeyUp="javascript:check_IntNumber('dm_volume','Enter valid page member');" />
                                 <?php echo mosToolTip('Volume of Document', 'Number of pages');?>
                                 </td>
                                </tr>
                                <tr>
                                 <td valign="top" align="right">Price for Member Tk: </td>
                                 <td colspan="2">
                                 <input class="inputbox" type="text" name="price_for_member" size="20" maxlength="10" value="<?php echo $row->price_for_member; ?>"  onKeyUp="javascript:check_FloatNumber('price_for_member','Enter valid unit price for member');" />

                                 </td>
                                </tr>
                                <tr>
                                 <td valign="top" align="right">Price for Non Member Tk: </td>
                                 <td colspan="2">
                                 <input class="inputbox" type="text" name="price_for_non_member" size="20" maxlength="10" value="<?php echo $row->price_for_non_member; ?>" onKeyUp="javascript:check_FloatNumber('price_for_non_member','Enter valid unit price for non member');" />

                                 </td>
                                </tr>
                                <tr>
                                 <td valign="top" align="right">* Abstract :</td>
                                  <td  colspan="2">
                                  <?php
                                  // parameters : areaname, content, hidden field, width, height, rows, cols
                                  editorArea('editor1', $row->dmdescription , 'dmdescription', '500', '150', '50', '5') ;
                                  ?>
                                  </td>
                                  </tr>

                                  <tr>
                                   <td width="250" align="right"><?php echo _DML_OWNER;?> :</td>
                                    <td colspan="2">
                                     <?php
                                       echo $lists['viewer'];
                                       echo mosToolTip(_DML_OWNER_TOOLTIP . '</span>', _DML_TOOLTIP . _DML_OWNER,400);
                                     ?>
                                     </td>
                                   </tr>
                                  <?php if (!$row->approved) {?>
                                  <!--tr>
                                   <td valign="top" align="right"><?php echo _DML_APPROVED;?> : </td>
                                    <td colspan="2"><?php echo $lists['approved'];
                                    echo mosToolTip(_DML_APPROVED_TOOLTIP . '.</span>', _DML_TOOLTIP . '...<br />' . _DML_APPROVED);
                                    ?>
                                    </td>
                                    </tr-->
                                    <?php } ?>
                                    <tr>
                                    <td valign="top" align="right">
                                    <?php echo _DML_PUBLISHED; ?> : </td>
                                    <td colspan="2">
                                    <?php echo $lists['published'];
                                    // echo mosToolTip(_PUBLISHED_TOOLTIP.'.</span>',_DML_TOOLTIP.'...<br />'._DML_PUBLISHED);
                                    ?>
                                    </td>
                                   </tr>
                                   <tr>
                                    <td valign="top" align="right"><?php echo _DML_CREATED_BY;?> :</td>
                                    <td colspan="2">[<?php echo $created[0]->name;?>] <i>on
                                    <?php
                                    echo mosFormatDate($row->dmdate_published);
                                    ?>
                                    </i> </td>
                                   </tr>
                                   <tr>
                                    <td valign="top" align="right"><?php echo _DML_UPDATED_BY;?> :</td>
                                    <td colspan="2">[<?php echo $last[0]->name;?>]
                                    <?php
                                    if ($row->dmlastupdateon) {
                                        echo " <i>on " . mosFormatDate($row->dmlastupdateon);
                                    }
                                    ?> <?php echo $row->dmfilename;?>
                                    </i>
                                    </td>
                                   </tr>
                                  </table>
                            </td>
                </tr>
            </table>
            <input type="hidden" name="original_dmfilename" value="<?php echo $row->dmfilename;?>" />
            <input type="hidden" name="dmsubmitedby" value="<?php echo $row->dmsubmitedby;?>" />
            <input type="hidden" name="image" value="<?php echo $row->dmimage;?>" />
            <input type="hidden" name="id" value="<?php echo $row->id;?>" />
            <input type="hidden" name="cat_id" value="<?php echo $row->catid; ?>" />
            <input type="hidden" name="option" value="com_docman" />
            <input type="hidden" name="section" value="documents" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="hidemainmenu" value="0">
            </form>
<?php
    }
}
?>
