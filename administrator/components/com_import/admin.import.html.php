<?php

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class HTML_Import {

        function TISData($option  ) {
                global $mosConfig_live_site;

                ?>

                <script language="javascript" type="text/javascript">

                function submitbutton(pressbutton)
                {
                        var submit=0;
                        var form = document.adminForm;

                        if (pressbutton == 'cancel')
                        {
                           submitformX( pressbutton,form );
                           return;
                        }
                        /*
                        var val = form.up_file.value;
                        val = val.substr((val.length-3),3);

                        if (form.up_file.value=="")
                           {
                                alert("Please select a file to import");
                                return;
                           }
                        else if (val !="zip")
                        {
                             alert("Please select a valid file to import");
                             return;
                        }     */
                        submitform( pressbutton );
                }

              </script>
              <table class="adminform" width="100%">
              <tr>
                <th align="left">
                 <b>Import Trade Information Service (TIS) Data</b>
                </th>
              </tr>
              <tr>
                <td align="center" width="100%">
                  <table  cellpadding="10" width="50%">
                       <tr>
                          <td align="center">
                              <b>Please select appropriate file to import</b>
                          </td>
                       </tr>
                      <tr>
                          <td width="30%" align="center" valign="top">
                           <form method="post" name="adminForm" enctype="multipart/form-data" action="index2.php">
                              <input class="text_area" type="file" name="up_file[]" size='50'  />
                              <input type="hidden" name="option" value="<?php echo $option;?>" />
                              <input type="hidden" name="task" value="" />
                              <input type="hidden" name="hidemainmenu" value="0" />
                           </form>
                          </td>
                       </tr>
                  </table>
                  <br /><br /><br /><br /><br /><br /><br /><br />
                </td>
              </tr>
              </table>

              <?php
        }


}
?>