<?php
/**
* Used for final presentation
* Written By: Morshed Alam
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class HTML_Circulation{

        function showCirculationList( &$rows, $pageNav, $option, $type, $circular_name, $circular_id ) { 
                global $mosconfig_show_date_format_short, $mosConfig_live_site, $mosConfig_absolute_path, $mosConfig_owner;
                ?>
                <script language="javascript" type="text/javascript">
                function createPdfLink(id, report_for)
                {
                      var form;
                      var circular_name = '<?php echo addslashes($circular_name); ?>';
                      var type = '<?php echo $type; ?>';
                      form = document.adminForm;
                      status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                      link = '<?php echo $mosConfig_live_site; ?>'+'/index2.php?option=com_circulation&amp;id='+id+'&amp;do_pdf=1&amp;circular_name='+circular_name+'&amp;type='+type+'&report_for='+report_for;
                      void window.open(link, 'win2', status);
                }
                function newwindow_others(id,type,title){
                     page='<?php echo $mosConfig_live_site; ?>/popup/email_list.php?id='+id+'&type='+type+'&title='+title;
                     newWin=window.open(page,'','width=550,height=400,scrollbars=yes,resizable=yes,top=40,left=100,status=no,menubar=no,directories=no,location=no,toolbar=no');
                     newWin.focus();
                }
                function newwindow_director(id,type,title){
                     page='<?php echo $mosConfig_live_site; ?>/popup/director_list.php?id='+id+'&type='+type+'&title='+title;
                     newWin=window.open(page,'','width=550,height=400,scrollbars=yes,resizable=yes,top=40,left=100,status=no,menubar=no,directories=no,location=no,toolbar=no');
                     newWin.focus();
                }
                </script>
                <form action="index2.php" method="post" name="adminForm">
                <table class="adminheading">
                <tr>
                  <th class="categories" width="80%">
                    Circulation Information: <?php echo $circular_name; ?>
                  </th>
                </tr>
                </table>
                <table class="adminlist" >
                <tr>
                        <th width="2%" class="title">
                        &nbsp;#
                        </th>
                        <th width="3%" class="title" align="center">
                        <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
                        </th>
                        <th class="title">
                        Date
                        </th>
                        <th align="center">
                        Fax to Member
                        </th>
                        <th class="title">
                        Cover Page
                        </th>
                        <th align="center">
                        Email to Member
                        </th>
                        <?php if(strtolower($mosConfig_owner)=="bkmea"){ ?>
                        <th align="center">
                        Email to Director
                        </th>
                        <?php } ?>
                        <th align="center">
                        Email to Others
                        </th>

                </tr>
                <?php
                $k = 0;

                for ($i=0, $n=count( $rows ); $i < $n; $i++) { 
                        $row    = &$rows[$i];
                        $img1 = $row->email_to_member ? 'tick.png'  : 'publish_x.png';
                        $alt1 = $row->email_to_member ? 'Yes' : 'No' ;
                        $img2 = $row->email_to_board_or_director ? 'tick.png'  : 'publish_x.png';
                        $alt2 = $row->email_to_board_or_director ? 'Yes' : 'No' ;
                        $img3 = $row->email_to_others ? 'tick.png'  : 'publish_x.png';
                        $alt3 = $row->email_to_others ? 'Yes' : 'No' ;
                        $link   = 'index2.php?option='.$option.'&amp;type='.$type.'&amp;circular_id='.$circular_id.'&amp;task=edit&amp;id='. $row->id;
                        $checked= mosCommonHTML::CheckedOutProcessing( $row, $i );

                ?>
                        <tr class="<?php echo "row$k"; ?>">
                                <td>&nbsp;<?php echo $pageNav->rowNumber( $i ); ?> </td>
                                <td align="center"><?php echo $checked; ?></td>
                                <td><?php echo mosFormatDate($row->date); ?></td>
                                <td align="center">
                                <?php
                                if(trim($row->fax_number_id)){
                                     echo '<a href="javascript:createPdfLink('.$row->id.',1);" title="PDF">View</a>';
                                }
                                else
                                  echo "<img src=images/publish_x.png order=0 alt=No />";
                                ?>
                                </td>
                                <td>
                                <?php
                                if($type==3 && file_exists($mosConfig_absolute_path."/dmdocuments/-1/".$row->filename) && trim($row->filename)!=""){
                                    echo "&nbsp;<A href=\"".$mosConfig_live_site."/dmdocuments/-1/".$row->filename."\" target=\"_blank\"><u>".$row->filename."</u></a>";
                                }
                                else if($type==2 && file_exists($mosConfig_absolute_path."/administrator/images/trade_fair/".$row->filename) && trim($row->filename)!=""){
                                    echo "&nbsp;<A href=\"".$mosConfig_live_site."/administrator/images/trade_fair/".$row->filename."\" target=\"_blank\"><u>".$row->filename."</u></a>";
                                }
                                else if($type==1 && file_exists($mosConfig_absolute_path."/administrator/images/circular/".$row->filename) && trim($row->filename)!=""){
                                    echo "&nbsp;<A href=\"".$mosConfig_live_site."/administrator/images/circular/".$row->filename."\" target=\"_blank\"><u>".$row->filename."</u></a>";
                                }
                                ?>
                                </td>
                                <td align="center">
                                <?php
                                if($row->email_to_member){
                                     echo '<a href="javascript:createPdfLink('.$row->id.',2);" title="PDF">View</a>';
                                }
                                else
                                  echo "<img src=images/publish_x.png order=0 alt=No />";
                                ?>
                                </td>
                                <?php if(strtolower($mosConfig_owner)=="bkmea"){ ?>
                                <td align="center">
                                <?php
                                if(trim($row->email_to_board_or_director)){
                                     echo '<a href="javascript:newwindow_director('.$row->id.','.$type.',\''.$circular_name.'\');">View</a>';
                                }
                                else
                                  echo "<img src=images/publish_x.png order=0 alt=No />";
                                ?>
                                </td>
                                <?php } ?>
                                <td align="center">
                                <?php
                                if(trim($row->email_to_others)){
                                     echo '<a href="javascript:newwindow_others('.$row->id.','.$type.',\''.$circular_name.'\');">View</a>';
                                }
                                else
                                  echo "<img src=images/publish_x.png order=0 alt=No />";
                                ?>
                                </td>
                       </tr>
                <?php
                $k=1-$k;
                }
                ?>
                </table>
                <?php echo $pageNav->getListFooter(); ?>
                <input type="hidden" name="option" value="<?php echo $option;?>" />
                <input type="hidden" name="type" value="<?php echo $type; ?>" />
                <input type="hidden" name="circular_id" value="<?php echo $circular_id; ?>" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="hidemainmenu" value="0" />
                </form>
                <?php
        }

          function editCirculation( &$row, $othersEmail, $option, $circular_id, $type, $circular_name )
          {
                global $mosConfig_live_site, $mosConfig_absolute_path;
                global $mosconfig_calender_date_format, $mosConfig_owner;
                if(trim($row->other_email_address)!="") $chkemail_checked = "checked";
                if($row->email_to_member==1) $chkmember_checked = "checked";
                if($row->email_to_board_or_director) $chkboard = "checked";
                ?>
                <script language="javascript" type="text/javascript">

                function submitbutton(pressbutton) {
                        var submit=0;
                        var form = document.adminForm;
                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }
                        var chk="<?php echo strtolower($mosConfig_owner)=='bkmea'?1:0; ?>";
                        if( form.chkmember.checked == false && form.chkemail.checked==false && ( chk==1 && form.chkboard.checked==false)){
                           alert("You must select circulation receiver.");
                           return;
                        }
                        else if( form.chkemail.checked==true && trim(form.other_email_address.value)==""){
                                alert("You must enter email address.");
                                return;
                        }
                        else{
                                submitform( pressbutton );
                        }
                }

              </script>
              <form action="index2.php" method="post" name="adminForm" enctype="multipart/form-data">
              <table class="adminheading">
                <tr>
                  <th class="categories">
                    Circulation Information: <?php echo $circular_name; ?>
                  </th>
                </tr>
                </table>
                <table width="100%" class="adminform">
                <tr>
                  <th align="center">
                  Circulation <small>( Fields marked with an asterisk * are required )</small>
                  </th>
                </tr>
                <tr>
                  <td width="100%" valign="top" height="400">
                    <table border="0" width="100%" >
                       <tr width="100%">
                               <td width="20%" align="right">
                               </td>
                               <td width="80%" align ="left" >
                               <input type="checkbox" name="chkmember" value="1" <?php echo $chkmember_checked; ?>>
                               &nbsp;Send To Related Member
                               </td>
                       </tr>
                       <?php if(strtolower($mosConfig_owner)=="bkmea"){ ?>
                       <tr width="100%">
                               <td width="20%" align="right">
                               </td>
                               <td width="80%" align ="left" >
                               <input type="checkbox" name="chkboard" value="1" <?php echo $chkboard; ?>>
                               &nbsp;Send To Board Of Director
                               </td>
                       </tr>
                       <?php } ?>
                       <tr width="100%">
                               <td align="right">
                               </td>
                               <td align ="left" >
                               <input type="checkbox" name="chkemail" value="1" <?php echo $chkemail_checked; ?>>
                               &nbsp;Send To Specific Email Address <br/>
                               <?php
                               if($row->id){
                                  echo '<p style="padding-left:10px;">'.$row->other_email_address.'</p>';
                               }
                               else{
                                  editorArea( 'other_email_address',  $othersEmail , 'other_email_address', '470px;', '100px', '60', '20' ) ;
                                  echo "Ex. abc@yahoo.com, xyz@gmail.com <br>";
                               }
                               ?>
                               <br>
                               </td>
                       </tr>
                       <!--tr width="100%">
                               <td align="right">
                               </td>
                               <td align ="left" >
                               <b>Body of Email * </b> <br/>
                               <?php editorArea( 'email_body',  '' , 'email_body', '470px;', '140px', '60', '20' ) ; ?>
                               </td>
                       </tr-->
                    </table>
                  </td>
                </tr>
                </table>
                <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
                <input type="hidden" name="option" value="<?php echo $option; ?>" />
                <input type="hidden" name="type" value="<?php echo $type; ?>" />
                <input type="hidden" name="file_name" value="<?php echo $type; ?>" />
                <input type="hidden" name="circular_id" value="<?php echo $circular_id; ?>" />
                <input type="hidden" name="task" value="" />
                </form>
                <?php


        }
}
?>