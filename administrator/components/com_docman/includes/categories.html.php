<?php
/*
* DOCMan 1.3.0 for Mambo 4.5.1 CMS
* @version $Id: categories.html.php,v 1.16 2006/07/12 09:50:48 morshed Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.mambodocman.com/
*/

defined('_VALID_MOS') or die('Direct access to this location is not allowed.');

if (defined('_DOCMAN_HTML_CATEGORIES')) {
    return;
} else {
    define('_DOCMAN_HTML_CATEGORIES', 1);
}

class HTML_DMCategories
{
    function show(&$rows, $myid, &$pageNav, &$lists, $type)
    {
        global $my;

        $section = "com_docman";
        $section_name = "DOCMan";

        ?>
                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                        <th class="categories">
                        Info Product Categories
                        </th>
                </tr>
                </table>

                <table class="adminlist">
                <tr>
                        <th width="100">
                        Sl&nbsp;#
                        </th>
                        <th width="20">
                        <!--input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows);?>);" /-->
                        </th>
                        <th class="title" width="66%">
                        <?php echo _DML_CATNAME;?>
                        </th>
                        <th width="10%">
                        <?php echo _DML_PUBLISHED;?>
                        </th>
                        <!--th colspan="2" width="4%">
                        <?php echo _DML_REORDER;?>
                        </th-->
                        <th width="22%">
                        Number of Info Products
                        </th>
                  </tr>
                <?php
        $k = 0;
        $i = 0;
        $n = count($rows);
        foreach ($rows as $row) {
            $img = $row->published ? 'tick.png' : 'publish_x.png';
            $task = $row->published ? 'unpublish' : 'publish';
            $alt = $row->published ? 'Published' : 'Unpublished';
            if (!$row->access) {
                $color_access = 'style="color: green;"';
                $task_access = 'accessregistered';
            } else if ($row->access == 1) {
                $color_access = 'style="color: red;"';
                $task_access = 'accessspecial';
            } else {
                $color_access = 'style="color: black;"';
                $task_access = 'accesspublic';
            }



            ?>
                        <tr class="<?php echo "row$k";?>">
                                <td width="100" align="left">
                                <?php echo $pageNav->rowNumber($i);?>
                                </td>
                                <td width="20">
                                <?php
                                /* if ($row->checked_out_contact_category && ($row->checked_out_contact_category != $my->id)){

                                }
                                else{
                                     echo mosHTML::idBox($i, $row->id, ($row->checked_out_contact_category && $row->checked_out_contact_category != $my->id));
                                }
                                */
                                echo mosHTML::idBox($i, $row->id, 0);
                                ?>
                                </td>
                                <td width="35%">
                                <?php
                                /*
                                      if ($row->checked_out_contact_category && ($row->checked_out_contact_category != $my->id)) {
                                           echo $row->treename ;
                                      } else {
                                */
                                ?>
                                        <a href="#edit" onClick="return listItemTask('cb<?php echo $i;?>','edit')">
                                <?php echo $row->treename ;?>
                                        </a>
                                <?php
                                       // }

                                ?>
                                </td>
                                <td align="center">
                                <a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
                                <img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt;?>" />
                                </a>
                                </td>
                                <!--td>
                                <?php echo $pageNav->orderUpIcon($i);?>
                                </td>
                                <td>
                                <?php echo $pageNav->orderDownIcon($i, $n);?>
                                </td-->
                                <td align="center">
                                <?php echo $row->documents;?>
                                </td>
                                <?php
            $k = 1 - $k;

            ?>
                        </tr>
                        <?php
            $k = 1 - $k;
            $i++;
        }

        ?>
                </table>
                <?php echo $pageNav->getListFooter();?>

                <input type="hidden" name="option" value="com_docman" />
                <input type="hidden" name="section" value="categories" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="chosen" value="" />
                <input type="hidden" name="act" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="type" value="<?php echo $type;?>" />
                </form>
                <?php
    }

    /**
    * Writes the edit form for new and existing categories
    *
    * @param mosCategory $ The category object
    * @param string $
    * @param array $
    */
    function edit(&$row, $section, &$lists, $redirect)
    {
        global $mosConfig_live_site,$dmpath,$_DOCMAN;

        //Category image
        $iamge_path_array=explode("/",$_DOCMAN->getCfg('dmpath'));
        $iamge_path_array_length=count($iamge_path_array)-1;
        $image_path=$mosConfig_live_site."/".$iamge_path_array                [$iamge_path_array_length];

        if(trim($row->image)!=null and file_exists($_DOCMAN->getCfg('dmpath')."/".$row->id."/".$row->image))
           $category_image=$image_path."/".$row->id."/".$row->image;
        else
            $category_image=$image_path."/not_available.jpg";
        /*
        if ($row->image == "") {
            $row->image = 'blank.png';
        }
        */
        mosMakeHtmlSafe($row, ENT_QUOTES, 'description');

        ?>
           <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
            <script language="JavaScript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js" type="text/javascript"></script>
                <script language="javascript" type="text/javascript">
                function submitbutton(pressbutton, section) {
                        var form = document.adminForm;
                        var image='<?php echo $row->image; ?>';
                        var img=form.elements['upload'].value;
                        var len=img.length;
                        img1=img.substr(len-3,3);
                        img2=img.substr(len-4,4);

                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }

                        if ( form.name.value == "" ) {
                                alert('You must enter name of the info product category.');
                                form.name.focus();
                        }
                        else if(trim(image)=="" && form.elements['upload'].value == ""){
                               alert("Please select category image.");
                               form.elements['upload'].focus();
                        }
                        else if(form.elements['upload'].value != "" && img1.toLowerCase()!="jpg" && img2.toLowerCase()!="jpeg"){
                               alert("Enter valid image.");
                               form.elements['upload'].focus();
                        }else {
                                <?php getEditorContents('editor1', 'description') ;?>
                                submitform(pressbutton);
                        }
                }

                </script>

                <form action="index2.php" method="post" name="adminForm" enctype="multipart/form-data">
                <table class="adminheading">
                <tr>
                        <th class="categories">
                        Info Product Category :
                        <?php echo $row->id ? _DML_EDIT : _DML_ADD;?>
                        </th>
                </tr>
                </table>

                <table width="100%">
                <tr>
                        <td valign="top" width="100%">
                                <table class="adminform">
                                <tr>
                                        <th colspan="3">
                                        <?php echo _DML_CATDETAILS;?> <small>( Fields marked with an asterisk * are required )</small>
                                        </th>
                                <tr>
                                <tr>
                                        <td align="right" width="25%">
                                        * <?php echo _DML_CATNAME;?> :
                                        </td>
                                        <td colspan="2"  width="75%">
                                        <input class="text_area" type="text" name="name" value="<?php echo $row->name;?>" size="50" maxlength="255" title="<?php echo _DML_LONGNAME;?>" />
                                        <?php echo mosToolTip('Category name can not be duplicate.', 'Category Name','200');?>
                                        </td>
                                </tr>
                                <tr>
                                        <td valign="top" align="right" >
                                        Description :
                                        </td>
                                        <td>
                                        <?php
                                        // parameters : areaname, content, hidden field, width, height, rows, cols
                                        editorArea('editor1', $row->description , 'description', '450', '130', '30', '5') ;
                                        ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td height="25" valign="top" align="right">
                                         * <?php echo _DML_IMAGE;?> :
                                        </td>
                                        <td  valign="top">
                                        <input name="upload" type="file" id="upload" size="30">
                                        <?php echo mosToolTip('Select an image for your <b>info product category</b>.<br>Image format(.jpg or .jpeg) and size(90px X 90px)', 'Category Image','200');?>
                                        </td>
                                        <td rowspan="3" valign="top" align="left"  width="587">
                                        <img src="<?php echo $category_image; ?>" name="imagelib" width="90" height="90" border="2" alt=' Image '>
                                        <!--if(trim($row->image)!=null){
                                        <br><A href="index2.php?option=com_docman&section=categories&task=removeimage&id=<?php echo $row->id; ?>&image=<?php echo $row->image; ?>">Remove Image</a-->
                                        </td>
                                </tr>
                                <!--tr>
                                        <td height="27" valign="top" align="right">
                                        <?php echo _DML_ORDERING;?> :
                                        </td>
                                        <td valign="top">
                                        <?php echo $lists['ordering'];?>
                                        </td>
                                </tr-->
                                <tr>
                                        <td valign="top" align="right">
                                        </td>
                                        <td valign="top">
                                        Image Format (.jpg, .jpeg) & Image Size (90 x 90 Pixels)
                                        </td>
                                </tr>
                                <tr>
                                        <td height="33" valign="top" align="right">
                                        <?php echo _DML_PUBLISHED;?> :
                                        </td>
                                        <td valign="top">
                                        <?php echo $lists['published'];?>
                                        </td>
                                </tr>
                                </table>
                        </td>
                </tr>
                </table>

                <input type="hidden" name="option" value="com_docman" />
                <input type="hidden" name="section" value="categories" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="id" value="<?php echo $row->id;?>" />
                <input type="hidden" name="image" value="<?php echo $row->image;?>" />
                <input type="hidden" name="sectionid" value="com_docman" />
                <input type="hidden" name="redirect" value="<?php echo $redirect;?>" />
                </form>
                <?php
    }
}

?>
