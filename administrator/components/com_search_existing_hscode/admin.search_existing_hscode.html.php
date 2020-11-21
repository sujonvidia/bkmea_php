<?php

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class SearchHSCode
{
      function show()
      {
                global $mosConfig_live_site, $database;
?>
                <script language="JavaScript" src="includes/js/showDataByAjax.js" type="text/javascript"></script>
                <script language="javascript">

                function conHsCode(){
                        var keyObj=document.getElementById('search_hscode');
                        var typeObj=document.getElementById('search_type');
                        var keyword=keyObj.value;
                        var type=typeObj.value;
                        if (keyword=='' && typeObj.selectedIndex!=0){
                                alert("Please enter a keyword.");
                                keyObj.focus();
                                return;
                        }

                        var url="components/com_search_existing_hscode/searchExistingHsCodeAjax.php?keyword=" + keyword + "&type=" + type;

                        showDataByAjax(url);
                }

                function aKeyWasPressed(e){

                        if (document.layers){
                                Key = e.which;
                        }
                        else
                        {
                                Key = window.event.keyCode;
                        }
                        if (Key == 13)
                        {
                                conHsCode();
                        }
                }
                </script>
                <table class="adminheading">
                <tr>
                <th class="categories" width=40%>
                    Search HSCode
                </th>
                <td width=60% align=right height=40 style="padding-right:10px;">
                   Keywoord:&nbsp;
                   <input type="text" name="search_hscode" id="search_hscode" onKeyPress="javascript: aKeyWasPressed();" class="inputbox"  size="25" maxlength="50" value= "" />
                   &nbsp;in&nbsp;
                   <select name="search_type" id="search_type">
                     <option value="all">All</option>
                     <option value="hscode" selected>HS Code</option>
                     <option value="name">Commercia Name</option>
                   </select>
                   &nbsp;
                   <input type="button" name="search" class="button"   value=" Search " onclick="javascript: conHsCode();" />
                </td>
                </tr>
                </table>

                <table class="adminlist">
                <tr>
                        <th width="5%" align="left">
                        #
                        </th>
                        <th class="title" width="30%">
                        HS Code
                        </th>
                        <th class="title" width="70%" align=left>
                        Commercia Name
                        </th>
                </tr>
                <tr>
                  <td width="100%" colspan="3">
                    <div id="txtHint" width="100%"></div>
                  </td>
                </tr>
                </table>
<?
      }
}
?>