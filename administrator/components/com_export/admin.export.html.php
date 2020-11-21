<?php

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class HTML_export {

  function showExportList( &$rows, $option, &$lists, $pageNav) {
    global $database, $exportPath, $downloadPath, $exportFor, $typeName;
    ?>
    <form action="index2.php" method="post" name="adminForm">
    <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminheading">
        <tr>
          <th>Export Trade Information Service (TIS) Data <?php trim($type)?" : ".$type:""; ?></th>
          <td align="right" ><b>Filter:</b> <?php echo $lists['filter_type']; ?></td>
        </tr>
    </table>
    <table class="adminlist">
        <tr>
            <th width="2%">#</th>
            <th align="center" width="3%">
            <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows ); ?>);" /></th>
            <th class="title">File Name</th>
            <th align="left" width="7%">Type</th>
            <th align="left" width="25%">Export For</th>
            <th align="center" width="8%">Download</th>
            <th align="left" width="8%">Size</th>
            <th align="left" width="20%">Date</th>
            <th align="left" width="5%">Action</th>
        </tr>
        <?php
        $k = 0;
        for ($i=0, $n=count( $rows ); $i < $n; $i++) {
                 $row    = &$rows[$i];
                 $date = date ("D jS F Y H:i:s", strtotime($row->process_datetime));
                 if(file_exists($exportPath."/".$row->filename)){
                     $link=$downloadPath."/".$row->filename;
                     $size = exportTools::getFileSizeText(filesize( $exportPath . "/" . $row->filename ));
                 }
                 else{
                   $size = "Empty!";
                   $link = "javascript:alert('File not exists!')";
                 }
         ?>
                 <tr class="<?php echo "row$k"; ?>">
                         <td>&nbsp;<?php echo $pageNav->rowNumber( $i ); ?> </td>
                         <td >
                         <input type="checkbox" id="cb<?php echo $i ?>" name="cid[]" value="<?php echo $i ?>" onclick="isChecked(this.checked);" />
                         </td>
                         <td ><a href="<?php echo $link; ?>">
                         <?php echo $row->filename; ?></a>
                         <input type="hidden" id="f<?php echo $i ?>" name="f<?php echo $i ?>" value="<?php echo $row->filename; ?>" >
                         </td>
                         <td><?php echo $typeName[$row->is_circular_fair_lead_stat]; ?></td>
                         <td><?php echo $row->export_for; ?></td>
                         <td align="center"><a href="<?php echo $link; ?>">
                         <img src="images/filesave.png" border="0" alt="Downlaod" title="Download"></a></td >
                         <td align="left"><?php echo $size; ?></td >
                         <td><?php echo $date; ?></td>
                         <td><a href="index2.php?option=com_export&task=cancelExport&id=<?php echo $row->id;?>">Cancel</a></td>
                </tr>
         <?php
         $k=1-$k;
         }
         ?>
    </table>
    <?php echo $pageNav->getListFooter(); ?>
    <input type="hidden" name="option" value="<?php echo $option; ?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="hidemainmenu" value="0" />
    </form>
    <br/>&nbsp;
    <?php
  }


}
?>
