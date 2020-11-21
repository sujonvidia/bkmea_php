<?php
/**
* @version $Id: frontend.html.php,v 1.17 2005/02/18 16:05:19 rhuk Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
*/

class modules_html {

        function homepage(&$rows_category,&$rows_product,&$lists){
                //global $dmpath;
                global $mosconfig_category_list_length, $mosConfig_live_site, $mosConfig_owner;
                global $mosconfig_directory_link, $mosConfig_owner, $mosconfig_hot_product_list_length;

                $text="Search Keyword...";
                $advanced_search_link="index.php?option=com_search";
                //$document_path=$dmpath;
                //echo $dmpath;
//                $document_path=$_DOCMAN->getCfg('dmpath');

        ?>
        <script language="javascript" type="text/javascript">
        var newWin;

                 function newwindow(pid,cid)
               {
                         if (null != newWin && !newWin.closed)

                         closeNewWindow();
                         page='./popup/product_details.php?pid='+pid;
                         newWin=window.open(page,'','width=450,height=300,scrollbars=yes,resizable=no,top=180,left=200,status=no,menubar=no,directories=no,location=no,toolbar=no');
                         //var form = document.adminForm;
                         //location.href=popup.php;
                         //newWin.document.forms[chkform].name.value="a";
                         //opener.document.forms[chkform].name.value=form.username.value;

                         newWin.focus();

               }
        </script>
        <?php if(trim(strtolower($mosConfig_owner))=="epb"){ ?>
                 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class=title height=25>
                        <div id="top">

                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" height="50" align="left" >
                        <p align="justify">
                        <b>Export Promotion Bureau, Bangladesh</b>    <br />
                           <ul>
                           <li align="left">A National Export Promotion Agency under the Ministry of Commerce        </li>
                           <li>Reorganized by the promulgation of a Presidential Ordinance in 1977 as a semi autonomous body</li>
                           <li>Promote export trade and improve plan & policies helpful to the private sector </li>
                           <li>Administered by a Board of Management (BOM) comprising members from both public & private sectors.</li>
                           <li>Honourable Minister for Commerce is the ex-officio Chairman  and</li>
                           <li>The Vice-Chairman is the chief executive of the Export Promotion Bureau.</li>
                           </ul>

                        </p>
                        </td>
                    </tr>
                </table>
           <?php } else{ ?>
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="mainpage" width="100%" height="50">
                           <p>
                           <?php if(trim(strtolower($mosConfig_owner))=="bkmea"){ ?>
                           Bangladesh Knitwear Manufacturers & Exporters Association
                           <?php } if(trim(strtolower($mosConfig_owner))=="scci"){ ?>
                            Sylhet Chamber of Commerce and Industries
                           <?php } if(trim(strtolower($mosConfig_owner))=="ccci"){ ?>
                           Chittagong Chamber of Commerce and Industries
                           <?php } ?>
                           </p>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" height="50" align="center">
                            <font size="3"><b></b></font>
                            <!--form action="<?php $PHPSELF;?>" method="post" name="adminForm" id="dm_frmsearch" class="dm_form"-->
                            <form action="index.php?option=com_docman&amp;task=search_result" method="post" name="adminForm" id="dm_frmsearch">
                                <table class="" align="right">
                                  <tr>
                                          <td nowrap="nowrap" align="right">
                                          <?php
                                          echo _PROMPT_KEYWORD; ?> :
                                          </td>
                                          <td nowrap="nowrap">
                                          <input type="text" id="search_phrase" name="search_phrase" size="15" class="inputbox" />
                                          <!--in <?php echo $lists['search_type']; ?> -->
                                          </td>
                                          <td nowrap="nowrap">
                                          <input type="hidden" name="search_type" value="all">
                                          <input type="submit" name="submit1" value="<?php echo _SEARCH_TITLE;?>" class="button" />
                                          </td>
                                  </tr>
                                  <tr>
                                          <td align="right" colspan="3">
                                          <a href="<?php echo $mosconfig_directory_link;?>"  onMouseOver="javascript:window.status='Advanced Search';return true;" title="Advanced Search"><b>
                                          <?php
                                          echo "Advanced Search";
                                          ?>
                                          </b></a>
                                          </td>

                                  </tr>
                                  <!--tr>
                                          <td nowrap="nowrap">
                                          Product/Services :
                                          </td>
                                          <td nowrap="nowrap">
                                          <?php echo $lists['product_list']; ?>

                                            Location : <?php echo $lists['location']; ?>
                                          </td>
                                          <td width="100%" nowrap="nowrap">
                                          <input type="submit" name="submit1" value="<?php echo _SEARCH_TITLE;?>" class="button" />
                                          </td>
                                  </tr-->
                                  <tr>
                                          <td colspan="3">
                                          <?php echo $lists['searchphrase']; ?>
                                          </td>
                                  </tr>
                                  <!--tr> update by morshed
                                          <td colspan="3"><?php echo _CMN_ORDERING;?>: <?php echo $lists['ordering'];?></td>
                                  </tr-->
                          </table>


                          <input type="hidden" name="option" value="com_docman" />
                          <input type="hidden" name="task" value="search_result" />
                          <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
                          </form>
                        </td>
                    </tr>
                    <tr>
                        <td class="mainpage" width="100%" height="10">&nbsp;

                        </td>
                    </tr>
                    <tr>
                        <td class="mainpage" width="100%">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                         <tr>
                             <td width="49%" class="mainpage" valign="top">
                             <b>Product Showcase</b>
                              <table  width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#C0C0F0">
                                      <!--DWLayoutTable-->
                              <?php

                              for ($i=0;$i<count($rows_category); $i++){
                                 $j=$i+1;

                                 if ($j<=$mosconfig_category_list_length){
                                      $row= $rows_category[$i];
                                   if( ( trim($row->dmfilename)!="" && file_exists("dmdocdownload/".$row->id."/".$row->dmfilename) ) || (intval($row->dmlink)==1) ){
                                      if(trim($row->category_image)!="" && file_exists("dmdocuments/".$row->id."/".$row->category_image)){
                                              $category_image="dmdocuments/".$row->id."/".$row->category_image;
                                      }
                                      else
                                          $category_image="dmdocuments/category_na.jpg";
                              ?>
                                <tr bgcolor="#F0F0F0">
                                  <td width="5%" align="center">
                                  <img border="0" src="<?php echo $category_image; ?>" width="30" height="30">
                                  </td>
                                  <td width="95%">&nbsp;
                                  <a href="index.php?option=com_docman&task=cat_view&gid=<?php echo $row->id?>"  onMouseOver="javascript:window.status='Info Product Category';return true;">
                                  <?php echo $row->category_name; ?>
                                  </a>
                                  </td>
                                </tr>
                              <?php
                                 }
                                }
                              }
                              if ($j>$mosconfig_category_list_length){
                              ?>
                              <tr bgcolor="#F0F0F0" height="20">

                                  <td width="100%" colspan="2" align="center">
                                  &nbsp;<a href="index.php?option=com_docman">More&nbsp;>></a>
                                  </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </table>
                             </td>
                             <td width="2%" align="center" valign="top">&nbsp;

                             </td>
                             <!--td width="32%" align="left" valign="top"  class="mainpage" >
                                 <font size="3"><b>Search in Product</font>
                                   <form name="form2" action="index.php" method="post">
                                   <?php
                                     echo "<br><br>".$lists['catid'] ;
                                     echo '<br><br><input alt="search" class="inputbox" type="text" name="search_phrase" size="20" value="'. $text .'"  onblur="if(this.value==\'\') this.value=\''. $text .'\';" onfocus="if(this.value==\''. $text .'\') this.value=\'\';" /><br><br>';
                                   ?>
                                   <input type="hidden" name="option" value="com_docman" />
                                   <input type="hidden" name="task" value="search_result" />
                                   <input type="submit" class="button" name="submit" value="Search" />
                                   </form>
                             </td-->
                             <!--td width="2%" align="center" valign="top">&nbsp;

                             </td-->

                             <td width="49%"  class="mainpage"  valign="top">

                              <b>Product in Demand</b>
                              <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C0C0F0">
                                      <!--DWLayoutTable-->
                               <?php
                               $total=0;
                              //foreach ($rows_product as $row_product){
                              for ($y=0;$y<count($rows_product); $y++){

                                   if($total==intval($mosconfig_hot_product_list_length))
                                      break;

                                  $row=& $rows_product[$y];
                                  $product_file="dmdocdownload/".$row->catid."/".$row->product_file;

                                  if(trim($row->product_image)!="" && file_exists("dmdocuments/".$row->catid."/".$row->product_image)){
                                      $product_image="dmdocuments/".$row->catid."/".$row->product_image;
                                  }
                                  else
                                      $product_image="dmdocuments/img_na.jpg";

                                  if ( (trim($row->product_file)!="" && file_exists($product_file) ) || (intval($row->dmlink)==1) ){
                                     //$docman=new DOCMAN_File($row->product_file,"dmdocuments",$row->catid);
                                     //$product= $row->product_name." (".$file_type.$file_size;
                                      //$file_size=filesize($product_file);
                                      //$file_type=filetype($product_file);

                              ?>
                                      <tr bgcolor="#F0F0F0">
                                        <td width="5%" align="center">
                                        <img border="0" src="<?php echo $product_image; ?>" width="30" height="30">
                                        </td>
                                        <td width="70%">
                                        &nbsp;
                                        <!--a href="index.php?option=com_docman&task=doc_details&gid=<?php echo $row->id?>&cat_id=<?php echo $row->catid?>"-->
                                        <a href="javascript:newwindow(<?php echo $row->id?>,<?php echo $row->catid?>);" title=" Details "  onMouseOver="javascript:window.status='Info Product';return true;">
                                        <?php    echo $row->product_name;    ?>
                                         </a>
                                        </td>
                                        <td width="25%" align="center">
                                        <dl>
                                        <dd class="dm_taskbar">
                                        <ul>
                                        <?php
                                        if ( intval($row->dmlink)==1){
                                        ?>
                                        <li><a href="<?php echo $mosconfig_directory_link; ?>&pid=<?php echo $row->id?>" onMouseOver="javascript:window.status='Info Product';return true;">Purchase</a></li>
                                        <?php
                                        }
                                        else{
                                        ?>
                                        <li><a href="index.php?option=com_docman&task=doc_purchase&step=1&pid=<?php echo $row->id?>&cat_id=<?php echo $row->catid?>"  onMouseOver="javascript:window.status='Info Product';return true;" >Purchase</a></li>
                                        <?php
                                        }

                                        ?>
                                        </ul>
                                        </dd>
                                        </dl>
                                        </td>
                                      </tr>
                                <?php
                                     $total=$total+1;
                                  }
                                }
                                ?>

                            </table>
                             </td>
                         </tr>
                         <tr>
                         <td height="10">&nbsp;

                         </td>
                         </tr>
                        </table>
                        </td>
                    </tr>
                </table>

        <?php
               }
        }

        function module( &$module, &$params, $Itemid, $style=0 ) {
                global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_lang, $mosConfig_absolute_path;

                // custom module params
                $rssurl                  = $params->get( 'rssurl' );
                $rssitems                = $params->get( 'rssitems', 5 );
                $rssdesc                 = $params->get( 'rssdesc', 1 );
                $rssimage                = $params->get( 'rssimage', 1 );
                $rssitemdesc             = $params->get( 'rssitemdesc', 1 );
                $moduleclass_sfx         = $params->get( 'moduleclass_sfx' );
                $words                                 = $params->def( 'word_count', 0 );

                if ($style == -1 && !$rssurl) {
                        echo $module->content;
                        return;
                } else {
                        ?>
                        <table cellpadding="0" cellspacing="0" class="moduletable<?php echo $moduleclass_sfx; ?>">
                        <?php
                        if ( $module->showtitle != 0 ) {
                                ?>
                                <tr>
                                        <th valign="top">
                                        <?php echo $module->title; ?>
                                        </th>
                                </tr>
                                <?php
                        }

                        if ( $module->content ) {
                                ?>
                                <tr>
                                        <td>
                                        <?php echo $module->content; ?>
                                        </td>
                                </tr>
                                <?php
                        }
                }
                // feed output
                if ( $rssurl ) {
                        $cacheDir                 = $mosConfig_absolute_path .'/cache/';
                        $LitePath                 = $mosConfig_absolute_path .'/includes/Cache/Lite.php';
                        require_once( $mosConfig_absolute_path .'/includes/domit/xml_domit_rss.php' );
                        $rssDoc =& new xml_domit_rss_document();
                        $rssDoc->useCacheLite(true, $LitePath, $cacheDir, 3600);
                        $rssDoc->loadRSS( $rssurl );
                        $totalChannels         = $rssDoc->getChannelCount();

                        for ( $i = 0; $i < $totalChannels; $i++ ) {
                                $currChannel =& $rssDoc->getChannel($i);
                                $elements         = $currChannel->getElementList();
                                $iUrl                = 0;
                                foreach ( $elements as $element ) {
                                        //image handling
                                        if ( $element == 'image' ) {
                                                $image =& $currChannel->getElement( DOMIT_RSS_ELEMENT_IMAGE );
                                                $iUrl        = $image->getUrl();
                                                $iTitle        = $image->getTitle();
                                        }
                                }

                                // feed title
                                ?>
                                <tr>
                                        <td>
                                        <strong>
                                        <a href="<?php echo $currChannel->getLink(); ?>" target="_blank">
                                        <?php echo $currChannel->getTitle(); ?>
                                        </a>
                                        </strong>
                                        </td>
                                </tr>
                                <?php
                                // feed description
                                if ( $rssdesc ) {
                                        ?>
                                        <tr>
                                                <td>
                                                <?php echo $currChannel->getDescription(); ?>
                                                </td>
                                        </tr>
                                        <?php
                                }
                                // feed image
                                if ( $rssimage ) {
                                        ?>
                                        <tr>
                                                <td align="center">
                                                <image src="<?php echo $iUrl; ?>" alt="<?php echo $iTitle; ?>"/>
                                                </td>
                                        </tr>
                                        <?php
                                }

                                $actualItems = $currChannel->getItemCount();
                                $setItems = $rssitems;

                                if ($setItems > $actualItems) {
                                        $totalItems = $actualItems;
                                } else {
                                        $totalItems = $setItems;
                                }

                                ?>
                                <tr>
                                        <td>
                                        <ul class="newsfeed<?php echo $moduleclass_sfx; ?>">
                                        <?php
                                        for ($j = 0; $j < $totalItems; $j++) {
                                                $currItem =& $currChannel->getItem($j);
                                                // item title
                                                ?>
                                                <li class="newsfeed<?php echo $moduleclass_sfx; ?>">
                                                <strong>
                                                <a href="<?php echo $currItem->getLink(); ?>" target="_blank">
                                                <?php echo $currItem->getTitle(); ?>
                                                </a>
                                                </strong>
                                                <?php
                                                // item description
                                                if ( $rssitemdesc ) {
                                                        // item description
                                                        $text         = html_entity_decode( $currItem->getDescription() );

                                                        // word limit check
                                                        if ( $words ) {
                                                                $texts = explode( ' ', $text );
                                                                $count = count( $texts );
                                                                if ( $count > $words ) {
                                                                        $text = '';
                                                                        for( $i=0; $i < $words; $i++ ) {
                                                                                $text .= ' '. $texts[$i];
                                                                        }
                                                                        $text .= '...';
                                                                }
                                                        }
                                                        ?>
                                                        <div>
                                                        <?php echo $text; ?>
                                                        </div>
                                                        <?php
                                                }
                                                ?>
                                                </li>
                                                <?php
                                        }
                                        ?>
                                        </ul>
                                        </td>
                                </tr>
                                <?php
                        }
                }
                ?>
                </table>
                <?php
        }

        /**
        * @param object
        * @param object
        * @param int The menu item ID
        * @param int -1=show without wrapper and title, -2=x-mambo style
        */
        function module2( &$module, &$params, $Itemid, $style=0, $count=0 ) {
                global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_lang, $mosConfig_absolute_path;
                global $mainframe, $database, $my;
                $moduleclass_sfx                 = $params->get( 'moduleclass_sfx' );

                // check for custom language file
                $path = $mosConfig_absolute_path . '/modules/' . $module->module.$mosConfig_lang . '.php';
                if (file_exists( $path )) {
                        include( $path );
                } else {
                        $path = $mosConfig_absolute_path .'/modules/'. $module->module .'.eng.php';
                        if (file_exists( $path )) {
                                include( $path );
                        }
                }

                $number = '';
                if ($count > 0) {
                        $number = '<span>' . $count . '</span> ';
                }
                if ($style == -3) {
                        // allows for rounded corners
                        echo "\n<div class=\"module$moduleclass_sfx\"><div><div><div>";
                        if ($module->showtitle != 0) {
                                echo "<h3>$module->title</h3>";
                        }
                         echo "\n";

                        include( $mosConfig_absolute_path .'/modules/'. $module->module .'.php' );
                        if (isset( $content)) {
                                echo $content;
                        }

                        echo "\n";
                        echo "\n</div></div></div></div>\n";
                } else if ($style == -2) {
                        // x-mambo (divs and font headder tags)
                        ?>
                        <div class="moduletable<?php echo $moduleclass_sfx; ?>">
                        <?php
                        if ($module->showtitle != 0) {
                                //echo $number;
                                ?>
                                <h3>
                                <?php echo $module->title; ?>
                                </h3>
                                <?php
                        }
                        include( $mosConfig_absolute_path .'/modules/'. $module->module .'.php' );

                        if (isset( $content)) {
                                echo $content;
                        }
                        ?>
                        </div>
                        <?php
                } else if ($style == -1) {
                        // show a naked module - no wrapper and no title
                        include( $mosConfig_absolute_path .'/modules/'. $module->module .'.php' );

                        if (isset( $content)) {
                                echo $content;
                        }
                } else {
                        ?>
                        <table cellpadding="0" cellspacing="0" class="moduletable<?php echo $moduleclass_sfx; ?>">
                        <?php
                        if ( $module->showtitle != 0 ) {
                                ?>
                                <tr>
                                        <th valign="top">
                                        <?php //echo $number; ?>
                                        <?php echo $module->title; ?>
                                        </th>
                                </tr>
                                <?php
                        }
                        ?>
                        <tr>
                                <td>
                                <?php
                                include( $mosConfig_absolute_path . '/modules/' . $module->module . '.php' );
                                if (isset( $content)) {
                                        echo $content;
                                }
                                ?>
                                </td>
                        </tr>
                        </table>
                        <?php
                }
        }
}
?>