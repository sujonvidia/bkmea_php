<?php
/**
* HTML class of stakeholder information
* Used for final presentation
* Written By: Morshed Alam
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class HTML_TradeFair{

        function showTradeFairList( &$rows, $pageNav, $search, $option, $lists ) {
                global $mosconfig_show_date_format_short;
                ?>
                <script language="javascript" type="text/javascript">
                </script>
                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                  <th class="categories">
                    Trade Fair Information
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
                        Title
                        </th>
                        <th width="10%" class="title" >
                        Issue Date
                        </th>
                        <th width="20%" class="title">
                        Organizer
                        </th>
                        <th width="20%" class="title">
                        Contact Person
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
                        $link   = 'index2.php?option='.$option.'&amp;task=edit&amp;id='. $row->id;
                        $checked= mosCommonHTML::CheckedOutProcessing( $row, $i );
                        $circulationLink = 'index2.php?option=com_circulation&amp;type=2&amp;circular_id='. $row->id;
                ?>
                        <tr class="<?php echo "row$k"; ?>">
                                <td>&nbsp;<?php echo $pageNav->rowNumber( $i ); ?> </td>
                                <td align="center"><?php echo $checked; ?></td>
                                <td> <a href="<?php echo $link; ?>"><?php echo $row->title; ?></a> </td>
                                <td><?php echo (trim($row->issue_date)!='' && trim($row->issue_date)!='0000-00-00')?date('dS M Y',strtotime($row->issue_date)):""; ?></td>
                                <td><?php echo $row->issue_by; ?></td>
                                <td><?php echo $row->contact_person; ?></td>
                                <td><?php echo date('dS M Y',strtotime($row->update_date)); ?></td>
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

          function editTradeFair( &$row, &$lists, $option, $task ) {
                global $mosConfig_live_site, $mosConfig_absolute_path;
                global $mosconfig_calender_date_format;

                ?>
                <script language="javascript" type="text/javascript">

                function submitbutton(pressbutton) {
                        var submit=0;
                        var form = document.adminForm;
                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }
                       //  alert(trim(form.entry_restriction.value)); return;
                        var file1=form.elements['up_file[]'].value;

                        if( trim(form.title.value) == "" ){
                                alert("You must enter circular title.");
                                form.title.focus();
                                return;
                        }
                        else if(trim(form.original_file.value) == "" && file1 == ""){
                               alert("File cannot be blank.");
                               return;
                        }
                        else if(trim(file1)!="" && validate_file_extension(form,",doc,pdf,txt,ppt,xls,jpg,gif,png,",file1)==false){
                                alert("Invalid file format.");
                                return;
                        }
                        else if( trim(form.issue_date.value) == "" ){
                                alert("Please enter issue date.");
                                form.issue_date.focus();
                                return;
                        }
                        else if( trim(form.issue_by.value) == "" ){
                                alert("Organizer can not be blank.");
                                form.issue_by.focus();
                                return;
                        }
                        else if( trim(form.country_id.value) == "" ){
                                alert("You must select country.");
                                form.country_id.focus();
                                return;
                        }
                        else if( trim(form.start_date.value) == "" ){
                                alert("You must enter start date.");
                                form.start_date.focus();
                                return;
                        }
                        else if( trim(form.end_date.value) == "" ){
                                alert("Please enter end date.");
                                form.end_date.focus();
                                return;
                        }
                        else if( form.entry_restriction[1].checked && form.selector_organization.value == ""){
                                alert("You must enter selector organization name.");
                                form.selector_organization.focus();
                                return;
                        }
                        else if( trim(form.phone.value) == "" && trim(form.fax.value) == "" && trim(form.email.value) == "" ){
                                alert("You must enter at least one contact information of phone/fax/email.");
                                form.phone.focus();
                                return;
                        }
                        else if( trim(form.hscode.value) == "" ){
                                if(confirm("You have missed to enter HS Code. Do you want to continue?"))
                                   submitform( pressbutton );
                                else
                                   return;
                        }
                        /*else if(img1 == ""){
                               alert("Circular file cannot be blank");
                               form.elements['up_file[]'][0].focus();
                        }
                        else if(trim(img1)!="" && validate_file_extension(form,",doc,",img1)==false){
                                alert("Invalid file format.");
                        }*/
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
                    Trade Fair Information / <small><?php echo ucfirst($task); ?></small>
                  </th>
                </tr>
                </table>
                <table width="100%" class="adminform">
                <tr>
                  <th align="center">
                    &nbsp;&nbsp;Trade Fair Information <small>( Fields marked with an asterisk * are required )</small>
                  </th>
                </tr>
                <tr>
                  <td width="100%" valign="top">
                    <table border="0" width="100%" >
                       <tr width="100%">
                               <td width="30%" align="right">
                               * Title :
                               </td>
                               <td width="70%" align ="left" >
                               <input type="text" name="title" class="inputbox" size="40" maxlength="200" value="<?php echo stripslashes($row->title); ?>" />
                               </td>
                       </tr>
                       <tr width="100%">
                               <td align="right" valign="top">
                               * File :
                               </td>
                               <td align ="left" >
                               <input name="up_file[]" type="file" id="upload" size="29">
                               <?php
                                 if(file_exists($mosConfig_absolute_path."/administrator/images/trade_fair/".$row->file_name) && trim($row->file_name)!="")
                                    echo "&nbsp;<A href=\"".$mosConfig_live_site."/administrator/images/trade_fair/".$row->file_name."\" target=\"_blank\"><u>".$row->file_name."</u></a>";

                               ?>
                               </td>
                       </tr>
                       <tr>
                               <td align=right>
                               * Issue date :
                               </td>
                               <td>
                               <input class="text_area" type="text" name="issue_date" id="issue_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->issue_date); ?>" size="20"    onBlur="checkdate(this)"  />
                               <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0 class="calender_link">
                               (dd-mm-yyyy)
                               </td>
                       </tr>
                       <tr width=100%>
                               <td align="right">
                               * Organizer :
                               </td>
                               <td align ="left">
                               <input type="text" name="issue_by" class="inputbox" size="40" maxlength="255" value="<?php echo stripslashes($row->issue_by); ?>" />
                               </td>
                       </tr>
                       <tr>
                               <td align=right>
                               * Country :
                               </td>
                               <td >
                               <?php echo $lists['country_id']; ?>
                               </td>
                       </tr>
                       <tr>
                               <td align=right>
                               * Start date :
                               </td>
                               <td>
                               <input class="text_area" type="text" name="start_date" id="start_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->start_date); ?>" size="20"    onBlur="checkdate(this)"  />
                               <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img2" border=0 class="calender_link">
                               (dd-mm-yyyy)
                               </td>
                       </tr>
                       <tr>
                               <td align=right>
                               * End date :
                               </td>
                               <td>
                               <input class="text_area" type="text" name="end_date" id="end_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->end_date); ?>" size="20"    onBlur="checkdate(this)"  />
                               <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img3" border=0 class="calender_link">
                               (dd-mm-yyyy)
                               </td>
                       </tr>
                       <tr width=100%>
                               <td align="right">
                               Venue Address :
                               </td>
                               <td align ="left">
                               <input type="text" name="venue_address" class="inputbox" size="40" maxlength="255" value="<?php echo stripslashes($row->venue_address); ?>" />

                               </td>
                       </tr>
                       <tr width=100%>
                               <td align="right">
                               Entry Restriction :
                               </td>
                               <td align ="left">
                               <?php echo $lists['entry_restriction']; ?>
                               </td>
                       </tr>
                       <tr width="100%" >
                               <td align="right">
                               Selector Organization :
                               </td>
                               <td align ="left" >
                               <input type="text" name="selector_organization" class="inputbox" size="40" maxlength="150" value="<?php echo stripslashes($row->selector_organization); ?>" />
                               </td>
                       </tr>
                       <tr width="100%">
                               <td align="right">
                               Registration Fee :
                               </td>
                               <td align ="left" >
                               <input type="text" name="registration_fee" class="inputbox" size="40" maxlength="100" value="<?php echo stripslashes($row->registration_fee); ?>" />

                               </td>
                       </tr>
                       <tr width="100%">
                               <td align="right">
                               Contact Person :
                               </td>
                               <td align ="left" >
                               <input type="text" name="contact_person" class="inputbox" size="40" maxlength="50" value="<?php echo stripslashes($row->contact_person); ?>" />
                               </td>
                       </tr>
                       <tr>
                                <td align=right>
                                Phone :
                                </td>
                                <td >
                                <input type="text" name="phone" class="inputbox" size="40" maxlength="50" value="<?php echo $row->phone; ?>" />
                                </td>
                        </tr>
                        <tr>
                                <td align=right>
                                Fax :
                                </td>
                                <td >
                                <input type="text" name="fax" class="inputbox" size="40" maxlength="50" value="<?php echo stripslashes($row->fax); ?>" />
                                </td>
                        </tr>
                        <tr>
                                <td align=right valign="top">
                                Email :
                                </td>
                                <td>
                                <input type="text" name="email" class="inputbox" size="40" maxlength="125" value="<?php echo stripslashes($row->email); ?>" />
                                &nbsp;(e.g. yourname@yourdomain.com )
                                </td>
                        </tr>
                        <tr>
                                <td align=right>
                                Website :
                                </td>
                                <td>
                                <input type="text" name="web" class="inputbox" size="40" maxlength="200" value="<?php echo stripslashes($row->web); ?>" />
                                </td>
                        </tr>
                       <tr>
                               <td align=right  valign="top" >
                               Search Keyword :
                               </td>
                               <td >
                               <?php editorArea( 'search_keyword',  stripslashes($row->search_keyword) , 'search_keyword', '410px;', '30px', '60', '20' ) ; ?>
                               </td>
                       </tr>
                       <tr>
                               <td align=right valign="top">
                               Abstract :
                               </td>
                               <td>
                               <?php editorArea( 'abstract',  stripslashes($row->abstract) , 'abstract', '410px;', '60px', '60', '20' ) ; ?>
                               </td>
                       </tr>
                       <tr>
                               <td align=right valign="middle">
                               HS Code :
                               </td>
                               <td>
                               <input type="text" name="hscode" class="inputbox" size="66" maxlength="255" value="<?php echo stripslashes($row->hscode); ?>" />
                               </td>
                       </tr>
                       <tr>
                               <td align=right valign="middle">

                               </td>
                               <td>
                               <A href="index2.php?option=com_search_existing_hscode" target="_blank"><u>Search Existing HS Code</u></a>
                               </td>
                       </tr>
                    </table>
                  </td>
                </tr>
                </table>
                <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
                <input type="hidden" name="option" value="<?php echo $option; ?>" />
                <input type="hidden" name="original_file" value="<?php echo $row->file_name;?>" />
                <input type="hidden" name="task" value="" />
                </form>
                <script type="text/javascript">
                        Calendar.setup({
                        inputField     :    "issue_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img1",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                        Calendar.setup({
                        inputField     :    "start_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img2",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                        Calendar.setup({
                        inputField     :    "end_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img3",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                </script>

                <?php


        }
}
?>

