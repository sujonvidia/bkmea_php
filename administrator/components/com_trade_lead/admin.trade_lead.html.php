<?php
/**
* HTML class of stakeholder information
* Used for final presentation
* Written By: Morshed Alam
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class HTML_TradeLead{

        function showTradeLeadList( &$rows, $pageNav, $search, $option, $lists ) {
                global $mosconfig_show_date_format_short, $_DOCMAN;
                ?>
                <script language="javascript" type="text/javascript">
                </script>
                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                  <th class="categories">
                    Trade Lead Information
                  </th>
                  <td align="right">
                    Filter:
                    <input type="text" name="search" value="<?php echo stripslashes($search);?>" class="inputbox" />
                    <?php echo $lists['filter_type']; ?>
                  </td>
                </tr>
                </table>
                <table class="adminlist">
                <tr>
                        <th width="2%" class="title">
                        &nbsp;#
                        </th>
                        <th width="3%" class="title" align="center">
                        <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
                        </th>
                        <th class="title">
                        Name
                        </th>
                        <th width="5%"  align="center">
                        Published
                        </th>
                        <th width="10%"  align="center">
                        Size
                        </th>
                        <th width="10%"  align="center">
                        # Download
                        </th>
                        <th width="10%" class="title">
                        Update Date
                        </th>
                        <th width="10%" class="title">
Action
                        </th>
                </tr>
                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row    = &$rows[$i];
                        $img = $row->published ? 'tick.png'  : 'publish_x.png';
                        $alt = $row->published ? 'Published' : 'Unpublished' ;
                        $link   = 'index2.php?option='.$option.'&amp;task=edit&amp;id='. $row->id;
                        $checked= mosCommonHTML::CheckedOutProcessing( $row, $i );
                        $circulationLink = 'index2.php?option=com_circulation&amp;type=3&amp;circular_id='. $row->id;
                ?>
                        <tr class="<?php echo "row$k"; ?>">
                                <td>&nbsp;<?php echo $pageNav->rowNumber( $i ); ?> </td>
                                <td align="center"><?php echo $checked; ?></td>
                                <td> <a href="<?php echo $link; ?>"><?php echo $row->dmname; ?></a> </td>
                                <td align="center">
                                <img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt;?>" />
                                </td>
                                <td align="center">
                                <?php
                                  if (file_exists($_DOCMAN->dmpath."/".$row->catid."/".$row->dmfilename)) {
                                      echo filesize($_DOCMAN->dmpath."/".$row->catid."/".$row->dmfilename)." Byte";
                                  }
                                  else
                                      echo "Not Applicable";
                                ?>
                                </td>
                                <td align="center"><?php echo $row->dmcounter;?></td>
                                <td><?php echo date('dS M Y',strtotime($row->dmlastupdateon)); ?></td>
                                <td> <a href="<?php echo $circulationLink; ?>">Circulation</a>&nbsp;&nbsp; </td>
                       </tr>
                <?php
                $k=1-$k;
                }
                ?>
                </table>
                <?php echo $pageNav->getListFooter(); ?>
                <input type="hidden" name="option" value="<?php echo $option;?>" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>
                <?php
        }

          function editTradeLead( &$row, &$lists, $option, $task ) {
                global $mosConfig_live_site, $mosConfig_absolute_path;
                global $mosconfig_calender_date_format, $_DOCMAN;
                ?>
                <script language="javascript" type="text/javascript">

                function submitbutton(pressbutton) {
                        var submit=0, start, end;
                        var form = document.adminForm;
                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }

                        var file1=form.elements['up_file[]'].value;
                        start =trim(form.dmdate_published.value);
                        end   =trim(form.dmdate_expire.value);
                        start=new Date(start.split('-')[2],start.split('-')[1],start.split('-')[0]);
                        end=new Date(end.split('-')[2],end.split('-')[1],end.split('-')[0]);
                        var file2=form.elements['up_image[]'].value;

                        if( trim(form.dmname.value) == "" ){
                                alert("You must enter trade lead name.");
                                form.dmname.focus();
                                return;
                        }
                        else if(trim(form.original_dmfilename.value) == "" && file1 == ""){
                               alert("File cannot be blank.");
                               return;
                        }
                        else if(trim(file1)!="" && validate_file_extension(form,",doc,pdf,txt,ppt,xls,jpg,gif,png,",file1)==false){
                                alert("Invalid file format.");
                                return;
                        }
                        else if(trim(file2)!="" && validate_file_extension(form,",jpg,gif,png,",file2)==false){
                                alert("Invalid image format.");
                                return;
                        }
                        else if(form.dmdate_published.value=="" ){
                            alert("You must enter date of publication.");
                            form.dmdate_published.focus();
                            return;
                        }
                        else if(form.dmdate_expire.value!="" && start.getTime()>end.getTime()){
                            alert("Invalid expire date.");
                            form.dmdate_expire.focus();
                            return;
                        }
                        else if( trim(form.search_keyword.value) == "" ){
                                alert("You must enter search keyword.");
                                form.search_keyword.focus();
                                return;
                        }
                        else if( trim(form.dmdescription.value) == "" ){
                                alert("Abstract can not be blank.");
                                form.dmdescription.focus();
                                return;
                        }
                        else if( trim(form.email.value) != "" && !emailCheck(form.email.value)){
                                alert("Invalid email address.");
                                form.email.focus();
                                return;
                        }
                        else if( trim(form.hscode.value) == "" ){
                                if(confirm("You have missed to enter HS Code. Do you want to continue?"))
                                   submitform( pressbutton );
                                else
                                   return;
                        }
                        else{
                                submitform( pressbutton );
                        }
                }

              </script>
              <script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/js/epb.js" type="text/javascript"></script>
              <form action="index2.php" method="post" name="adminForm" enctype="multipart/form-data">
              <table class="adminheading">
                <tr>
                  <th class="categories">
                    Trade Lead Information / <small><?php echo $row->id?"Edit":"New"; ?></small>
                  </th>
                </tr>
                </table>
                <table width="100%" class="adminform">
                <tr>
                  <th align="center">
                    &nbsp;&nbsp;Trade Lead Information <small>( Fields marked with an asterisk * are required )</small>
                  </th>
                </tr>
                <tr>
                  <td width="100%" valign="top">
                    <table border="0" width="100%" >
                       <tr width="100%">
                               <td width="30%" align="right">
                               * Name :
                               </td>
                               <td width="70%" align ="left" >
                               <input class="inputbox" type="text" name="dmname" size="50" maxlength="100" value="<?php echo $row->dmname ?>" />
                               </td>
                       </tr>
                       <tr width="100%">
                               <td align="right" valign="top">
                               * File :
                               </td>
                               <td align ="left" >
                               <input name="up_file[]" type="file" id="upload" size="29">
                               <?php
                                 if(file_exists($_DOCMAN->dmpath."/".$row->catid."/".$row->dmfilename) && trim($row->dmfilename)!="")
                                    echo "&nbsp;<A href=\"".$mosConfig_live_site."/".array_pop(explode("/",$_DOCMAN->dmpath))."/".$row->catid."/".$row->dmfilename."\" target=\"_blank\"><u>".$row->dmfilename."</u></a>";

                               ?>
                               </td>
                       </tr>
                       <tr width="100%">
                               <td align="right" valign="top">
                               Image :
                               </td>
                               <td align ="left" >
                               <input name="up_image[]" type="file" id="upload" size="29">
                               <?php
                                 if(file_exists($_DOCMAN->dmpath."/".$row->catid."/".$row->dmimage) && trim($row->dmimage)!="")
                                    echo "&nbsp;<A href=\"".$mosConfig_live_site."/".array_pop(explode("/",$_DOCMAN->dmpath))."/".$row->catid."/".$row->dmimage."\" target=\"_blank\"><u>".$row->dmimage."</u></a>";

                               ?>
                               </td>
                       </tr>
                       <tr>
                               <td align=right>
                               Query Type :
                               </td>
                               <td >
                               <?php echo $lists['is_export_query']; ?>
                               </td>
                       </tr>
                       <tr width="100%">
                               <td width="30%" align="right">
                               Query By :
                               </td>
                               <td width="70%" align ="left" >
                               <input class="inputbox" type="text" name="query_by" size="50" maxlength="100" value="<?php echo $row->query_by ?>" />
                               </td>
                       </tr>
                       <tr width="100%">
                               <td align="right">
                               Contact Person :
                               </td>
                               <td align ="left" >
                               <input type="text" name="contact_person" class="inputbox" size="50" maxlength="50" value="<?php echo stripslashes($row->contact_person); ?>" />
                               </td>
                       </tr>
                       <tr width=100%>
                               <td align="right">
                               Address :
                               </td>
                               <td align ="left">
                               <input type="text" name="address" class="inputbox" size="50" maxlength="255" value="<?php echo stripslashes($row->address); ?>" />
                               </td>
                       </tr>
                       <tr>
                               <td align=right>
                               Country :
                               </td>
                               <td >
                               <?php echo $lists['country_id']; ?>
                               </td>
                       </tr>
                       <tr>
                               <td align=right>
                               Phone :
                               </td>
                               <td >
                               <input type="text" name="phone" class="inputbox" size="50" maxlength="50" value="<?php echo $row->phone; ?>" />
                               </td>
                       </tr>
                       <tr>
                               <td align=right>
                               Fax :
                               </td>
                               <td >
                               <input type="text" name="fax" class="inputbox" size="50" maxlength="35" value="<?php echo stripslashes($row->fax); ?>" />
                               </td>
                       </tr>
                       <tr>
                               <td align=right valign="top">
                               Email :
                               </td>
                               <td>
                               <input type="text" name="email" class="inputbox" size="50" maxlength="125" value="<?php echo stripslashes($row->email); ?>" />
                               &nbsp;(e.g. yourname@yourdomain.com )
                               </td>
                       </tr>
                       <tr>
                              <td align=right>
                              Website :
                              </td>
                              <td>
                              <input type="text" name="web" class="inputbox" size="50" maxlength="125" value="<?php echo stripslashes($row->web); ?>" />
                              </td>
                      </tr>
                       <tr>
                               <td align=right>
                               * Date of Publication :
                               </td>
                               <td>
                               <input class="text_area" type="text" name="dmdate_published" id="dmdate_published" value="<?php echo mosHTML::ConvertDateDisplayShort($row->dmdate_published); ?>" size="20"    onBlur="checkdate(this)"  />
                               <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0 class="calender_link">
                               (dd-mm-yyyy)
                               </td>
                       </tr>
                       <tr>
                               <td align=right>
                               Date of Expiry :
                               </td>
                               <td>
                               <input class="text_area" type="text" name="dmdate_expire" id="dmdate_expire" value="<?php echo mosHTML::ConvertDateDisplayShort($row->dmdate_expire); ?>" size="20"    onBlur="checkdate(this)"  />
                               <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img2" border=0 class="calender_link">
                               (dd-mm-yyyy)
                               </td>
                       </tr>
                       <tr>
                               <td align=right  valign="top" >
                               * Search Keyword :
                               </td>
                               <td >
                               <input type="text" name="search_keyword" class="inputbox" size="50" maxlength="200" value="<?php echo stripslashes($row->search_keyword); ?>" />
                               &nbsp;Anyone can search this trade by using search keyword.
                               </td>
                       </tr>
                       <tr width=100%>
                               <td align="right">
                               Number of Pages :
                               </td>
                               <td align ="left">
                               <input class="inputbox" type="text" name="dm_volume" size="20" maxlength="5" value="<?php echo $row->dm_volume; ?>"  onKeyUp="javascript:checkIntNumber(this,'Enter valid page member',document.adminForm,-1);" />
                               </td>
                       </tr>
                       <tr width=100%>
                               <td align="right">
                               Price for Member :
                               </td>
                               <td align ="left">
                               <input class="inputbox" type="text" name="price_for_member" size="20" maxlength="10" value="<?php echo $row->price_for_member; ?>"  onKeyUp="javascript:checkDoubleNumber(this,'Enter valid unit price for member.', document.adminForm);" />
                               Tk.
                               </td>
                       </tr>
                       <tr width=100%>
                               <td align="right">
                               Price for Non-Member :
                               </td>
                               <td align ="left">
                               <input class="inputbox" type="text" name="price_for_non_member" size="20" maxlength="10" value="<?php echo $row->price_for_non_member; ?>" onKeyUp="javascript:checkDoubleNumber(this,'Enter valid unit price for no-member.', document.adminForm);" />
                               Tk.
                               </td>
                       </tr>
                       <tr>
                               <td align=right valign="top">
                               * Abstract :
                               </td>
                               <td>
                               <?php editorArea( 'dmdescription',  stripslashes($row->dmdescription) , 'dmdescription', '410px;', '60px', '60', '20' ) ; ?>
                               </td>
                       </tr>
                       <tr>
                               <td align=right valign="middle">
                               HS Code :
                               </td>
                               <td>
                               <input type="text" name="hscode" class="inputbox" size="66" maxlength="255" value="<?php echo stripslashes($row->hscode); ?>" />
                               &nbsp;&nbsp;
                               <A href="index2.php?option=com_search_existing_hscode" target="_blank"><u>Search Existing HS Code</u></a>

                               </td>
                       </tr>
                       <!--tr>
                               <td align=right valign="middle">

                               </td>
                               <td>
                               [Ex. 6101,6102] &nbsp;&nbsp;
                               <A href="index2.php?option=com_search_existing_hscode" target="_blank"><u>Search Existing HS Code</u></a>
                               </td>
                       </tr-->
                       <tr>
                               <td align=right>
                               Published :
                               </td>
                               <td >
                               <?php echo $lists['published']; ?>
                               </td>
                       </tr>
                       <!--tr>
                               <td align=right>
                               Viewers :
                               </td>
                               <td >
                               <?php echo $lists['viewer']; ?>
                               </td>
                       </tr>
                       <tr width=100%>
                               <td align="right">
                               Created By :
                               </td>
                               <td align ="left">
                               [<?php echo $row->createdby;?>] <i>
                               <?php
                               if($row->date)
                                 echo " on ".mosFormatDate($row->date); ?>
                                </i>
                               </td>
                       </tr>
                       <tr width=100%>
                               <td align="right">
                               Last Updated By :
                               </td>
                               <td align ="left">
                               [<?php echo $row->updatedby; ?>]
                               <?php
                               if ($row->dmlastupdateon) {
                                  echo " <i>on " . mosFormatDate($row->dmlastupdateon);
                               }
                               ?>
                               </td>
                       </tr-->
                    </table>
                  </td>
                </tr>
                </table>
                <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
                <input type="hidden" name="tid" value="<?php echo $row->tid; ?>" />
                <input type="hidden" name="catid" value="-1" />
                <input type="hidden" name="original_dmfilename" value="<?php echo $row->dmfilename;?>" />
                <input type="hidden" name="original_dmimage" value="<?php echo $row->dmimage;?>" />
                <input type="hidden" name="option" value="<?php echo $option; ?>" />
                <input type="hidden" name="task" value="" />
                </form>
                <script type="text/javascript">
                        Calendar.setup({
                        inputField     :    "dmdate_published",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img1",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                        Calendar.setup({
                        inputField     :    "dmdate_expire",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img2",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                </script>

                <?php


        }
}
?>

