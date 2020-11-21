<?php
   include_once("../../../configuration.php");
   include_once("../../../includes/database.php");
   $database= new database($mosConfig_host,$mosConfig_user,$mosConfig_password,$mosConfig_db,$mosConfig_dbprefix);

   $keyword=strtolower($_REQUEST['keyword']);
   $type=strtolower($_REQUEST['type']);

   if ($type=='all' && empty($keyword)){
              $where=1;
   }else if ($type=='all' && !empty($keyword))
   {
       $where     = "m.name LIKE '%$keyword%' OR m.description LIKE '%$keyword%'  OR m.hscode LIKE '$keyword%' OR m.parent_id LIKE '%$keyword%'";
   }else if ($type=='hscode' && !empty($keyword)){
        $where    = "m.". $type ." LIKE '$keyword%'";
   }else{
        $where    = "m.". $type ." LIKE '%$keyword%'";
   }

      $query = "select m.* from #__product_line as m "
           ."\n WHERE m.hscode <> '0' and " .$where
           ."\n order by hscode" ;
      $database->setQuery($query);
      $res = $database->loadObjectList();

      if(count($res)>0){
?>
               <table  class="adminlist" align="center" width="98%" cellspacing="1" >
<?php
          $k=0;
          for($i=0; $i<count($res); $i++){
                    $row = $res[$i];
          ?>
                <tr class="row<?php echo $k; ?>">
                  <td width="5%"><?php echo $i+1;?></td>
                  <td width="30%"><?php echo $row->hscode;?></td>
                  <td width="70%"><?php echo $row->name;?></td>
                </tr>
          <?php
              $k = 1 - $k;
              }
          ?>
           </table>
    <?php
          }
          else{
          echo "<b>No Item Found.</b>";
          }
    ?>
