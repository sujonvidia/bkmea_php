<?php
/**
* HTML class of stakeholder information
* Used for final presentation
* Written By: Morshed Alam
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class HTML_StakeHolder {

        function showStakeHolderList( &$rows, $pageNav, $search, $option, $lists ) {
                global $mosconfig_show_date_format_short;
                ?>
                <script language="javascript" type="text/javascript">
                </script>
                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                  <th class="categories">
                    Stakeholder Information
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
                        <th width="3%" class="title" >
                        <div align="center"><input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" /></div>
                        </th>
                        <th class="title" NOWRAP>
                        Name
                        </th>
                        <th class="title">
                        Contact Person
                        </th>
                        <th class="title">
                        Organization type
                        </th>
                        <th class="title" width="27%">
                        Address
                        </th>
                        <th width="10%" class="title">
                        Update Date
                        </th>

                </tr>
                <?php
                $k = 0;
                for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                        $row    = &$rows[$i];
                        $link   = 'index2.php?option='.$option.'&amp;task=editA&amp;id='. $row->id;
                        $checked= mosCommonHTML::CheckedOutProcessing( $row, $i );
                ?>
                        <tr class="<?php echo "row$k"; ?>">
                                <td>&nbsp;<?php echo $pageNav->rowNumber( $i ); ?> </td>
                                <td align="center"><?php echo $checked; ?></td>
                                <td> <a href="<?php echo $link; ?>"><?php echo $row->name; ?></a> </td>
                                <td><?php echo $row->contact_person; ?></td>
                                <td><?php echo organizationTypeName($row->organization_type_id); ?></td>
                                <td><?php echo stripslashes($row->address); ?></td>
                                <td><?php echo date('dS M Y',strtotime($row->update_date)); ?></td>
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

          function editStakeHolder( &$row, &$lists, $option, $task ) {
                global $mosConfig_live_site;
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

                        var issue, expire;
                        issue =trim(form.issue_date.value);
                        expire =trim(form.expire_date.value);
                        issue=new Date(issue.split('-')[2],issue.split('-')[1],issue.split('-')[0]);
                        expire=new Date(expire.split('-')[2],expire.split('-')[1],expire.split('-')[0]);

                        if(form.name.value == ""){
                            alert("You must enter stakeholder name.");
                            form.name.focus();
                        }
                        else if(form.address.value == ""){
                            alert("You must enter stakeholder address.");
                            form.address.focus();
                        }
                        else if(form.organization_type_id.value == 0){
                            alert("You must select organization type.");
                            form.organization_type_id.focus();
                        }
                        else if((form.issue_date.value != "" && form.expire_date.value != "") && (issue.getTime()>=expire.getTime())){
                            alert("Trade license issue date '"+form.issue_date.value+"' must be less than expire date '"+form.expire_date.value+"'");
                            form.expire_date.focus();
                        }
                        else if((form.email.value!="") && (form.email.value.indexOf('@', 0) == -1 || form.email.value.indexOf('.', 0) == -1)){
                            alert("Enter valid e-mail address");
                            form.email.focus();
                        }else {
                            submitform( pressbutton );
                        }

                }
                function popupHSCode(task, member_id, id, hscodeType, businessType, country){

                               var status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                               var link = 'components/com_hscode_epb/admin.hscode.php?option=com_hscode&task='+task+'&member_id='+member_id+'&id='+id+'&hscodeType='+hscodeType+'&businessType='+businessType+'&country='+country;
                               void window.open(link, 'win2', status);
                }

              </script>
              <script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/js/epb.js" type="text/javascript"></script>
              <form action="index2.php" method="post" name="adminForm">
              <table class="adminheading">
                <tr>
                  <th class="categories">
                    Stakeholder Information / <small><?php echo ucfirst($task); ?></small>
                  </th>
                </tr>
                </table>
                <table width="100%" class="adminform">
                <tr>
                  <th align="center">
                    &nbsp;&nbsp;Stakeholder Information <small>( Fields marked with an asterisk * are required )</small>
                  </th>
                </tr>
                <tr>
                        <td width="100%" valign="top">
                        <table width="100%">
                         <tr>
                           <td width="50%"  valign="top">
                             <table border="0" width="100%" >
                                <tr width="100%">
                                        <td width="35%" align="right">
                                        * Name :
                                        </td>
                                        <td width="65%" align ="left" >
                                        <input type="text" name="name" class="inputbox" size="50" maxlength="150" value="<?php echo stripslashes($row->name); ?>" />
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
                                <tr>
                                        <td align=right>
                                        Registration date :
                                        </td>
                                        <td>
                                        <input class="text_area" type="text" name="reg_date" id="reg_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->reg_date); ?>" size="20"    onBlur="checkdate(this)"  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0 class="calender_link">
                                        (dd-mm-yyyy)
                                        </td>
                                </tr>
                                <tr width=100%>
                                        <td align="right">
                                        * Address :
                                        </td>
                                        <td align ="left">
                                        <input type="text" name="address" class="inputbox" size="50" maxlength="255" value="<?php echo stripslashes($row->address); ?>" />
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
                                        Mobile :
                                        </td>
                                        <td >
                                        <input type="text" name="mobile" class="inputbox" size="50" maxlength="50" value="<?php echo $row->mobile; ?>" />
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
                                        (e.g. yourname@yourdomain.com )
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
                             </table>
                           </td>
                           <td width="50%"  valign="top">
                             <table border="0" width="100%" >
                                <tr width=100%>
                                        <td align="right">
                                        * Organization Type :
                                        </td>
                                        <td align ="left" >
                                        <?php echo $lists['organization_type_id']; ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        Trade License Number :
                                        </td>
                                        <td>
                                        <input type="text" name="trade_licence_no" class="inputbox" size="40" maxlength="20" value="<?php echo stripslashes($row->trade_licence_no); ?>" />
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        Issued Authority :
                                        </td>
                                        <td>
                                        <input type="text" name="issue_authority" class="inputbox" size="40" maxlength="125" value="<?php echo stripslashes($row->issue_authority); ?>" />
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        Issue Date :
                                        </td>
                                        <td>

                                        <input class="text_area" type="text" name="issue_date" id="issue_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->issue_date); ?>" size="20"    onBlur="checkdate(this)"  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img2" border=0 class="calender_link">
                                        (dd-mm-yyyy)
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        Expire Date :
                                        </td>
                                        <td>

                                        <input class="text_area" type="text" name="expire_date" id="expire_date" value="<?php echo mosHTML::ConvertDateDisplayShort($row->expire_date); ?>" size="20"    onBlur="checkdate(this)"  />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img3" border=0 class="calender_link">
                                        (dd-mm-yyyy)
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        Tin Number :
                                        </td>
                                        <td>
                                        <input type="text" name="tin_no" class="inputbox" size="40" maxlength="20" value="<?php echo stripslashes($row->tin_no); ?>" />
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        Import Registration Number :
                                        </td>
                                        <td>
                                        <input type="text" name="import_reg_no" class="inputbox" size="40" maxlength="20" value="<?php echo stripslashes($row->import_reg_no); ?>" />
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        Export Registration Number :
                                        </td>
                                        <td>
                                        <input type="text" name="export_reg_no" class="inputbox" size="40" maxlength="125" value="<?php echo stripslashes($row->export_reg_no); ?>" />
                                        </td>
                                </tr>
                                <tr>
                                        <td align=right>
                                        Is Partner :
                                        </td>
                                        <td>
                                        <?php echo $lists['is_partner']; ?>
                                        </td>
                                </tr>
                             </table>
                           </td>
                         </tr>
                        </table>
                        <table border="0" width="100%" >
                          <tr>
                            <td align=right valign=top>
                                Member of Associations/ Chambers :
                            </td>
                            <td>
                                <?php echo $lists['association']; ?>
                                <br><br>
                            </td>
                          </tr>
                       </table>
                       <?php if($row->id){ ?>
                       <table width="100%" border="0" style="border-top:1px solid;">
                       <tr>
                        <td colspan="2" width="100%" height="30" valign="middle" align=center>
                         <b>Business Line Information</b> <br/>
                        </td>
                       </tr>
                       <tr>
                        <td width="50%" align="center" valign="top">
                         <table width="100%" cellspacing="3" >
                           <tr width=100%>
                             <td  align="right" valign="top">
                             Importer of :
                             </td>
                             <td align="left" valign="top" >

                             &nbsp;<a href="javascript:popupHSCode('new',<?php echo $row->id;?>,0,1,1,0);" style="text-decoration:none;"><b>Add New</b></a>
                             <br>
                             <?php
                             businessLineInformation($row->id,1,1,0,$option);
                             ?>
                             </td>
                           </tr>
                           <tr width=100%>
                             <td  align="right" valign="top" >
                             Exporter of :
                             </td>
                             <td align="left" valign="top" >

                             &nbsp;<a href="javascript:popupHSCode('new',<?php echo $row->id;?>,0,1,2,0);" style="text-decoration:none;"><b>Add New</b></a>
                             <br>
                             <?php
                             businessLineInformation($row->id,1,2,0,$option);
                             ?>
                             </td>
                           </tr>
                           <tr width=100%>
                             <td  align="right" valign="top" >
                             Manufacturer of :
                             </td>
                             <td align="left" valign="top" >

                             &nbsp;<a href="javascript:popupHSCode('new',<?php echo $row->id;?>,0,1,3,0);" style="text-decoration:none;"><b>Add New</b></a>
                             <br>
                             <?php
                             businessLineInformation($row->id,1,3,0,$option);
                             ?>
                             </td>
                           </tr>
                           <tr width=100%>
                             <td  align="right" valign="top" >
                             Trader of :
                             </td>
                             <td align="left" valign="top" >

                             &nbsp;<a href="javascript:popupHSCode('new',<?php echo $row->id;?>,0,1,4,0);" style="text-decoration:none;"><b>Add New</b></a>
                             <br>
                             <?php
                             businessLineInformation($row->id,1,4,0,$option);
                             ?>
                             </td>
                           </tr>
                         </table>
                        </td>
                        <td width="50%" align="center" valign="top">
                         <table width="100%">

                           <tr width=100%>
                             <td  align="right" valign="top" >
                             Dealer of
                             </td>
                             <td align="left" valign="top" >
                             &nbsp;<a href="javascript:popupHSCode('new',<?php echo $row->id;?>,0,1,5,0);" style="text-decoration:none;"><b>Add New</b></a>
                             <br>
                             <?php
                             businessLineInformation($row->id,1,5,0,$option);
                             ?>
                             </td>
                           </tr>
                           <tr width=100%>
                             <td  align="right" valign="top" >
                             Indenter of
                             </td>
                             <td align="left" valign="top" >
                             &nbsp;<a href="javascript:popupHSCode('new',<?php echo $row->id;?>,0,1,6,0);" style="text-decoration:none;"><b>Add New</b></a>
                             <br>
                             <?php
                             businessLineInformation($row->id,1,6,0,$option);
                             ?>
                             </td>
                           </tr>
                           <tr width=100%>
                             <td  align="right" valign="top">
                             Assemblers/Processor of :
                             </td>
                             <td align="left" valign="top">
                             &nbsp;<a href="javascript:popupHSCode('new',<?php echo $row->id;?>,0,1,7,0);" style="text-decoration:none;"><b>Add New</b></a>
                             <br>
                             <?php
                             businessLineInformation($row->id,1,7,0,$option);
                             ?>
                             </td>
                           </tr>
                         </table>
                        </td>
                       </tr>
                     </table>
                     <?php } ?>
                  </td>
              </tr>
          </table>

          <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
          <input type="hidden" name="option" value="<?php echo $option; ?>" />
          <input type="hidden" name="task" value="" />
          </form>
                <script type="text/javascript">
                        Calendar.setup({
                        inputField     :    "reg_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img1",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                        Calendar.setup({
                        inputField     :    "issue_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img2",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                        Calendar.setup({
                        inputField     :    "expire_date",      // id of the input field
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
