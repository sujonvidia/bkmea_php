<?php
 include("../configuration.php");
 include("../administrator/components/com_docman/docman.config.php");

 function mosChmodRecursive($path, $filemode=NULL, $dirmode=NULL)
 {
        $ret = TRUE;
        if (is_dir($path)) {
            $dh = opendir($path);
            while ($file = readdir($dh)) {
                if ($file != '.' && $file != '..') {
                    $fullpath = $path.'/'.$file;
                    if (is_dir($fullpath)) {
                    if (!mosChmodRecursive($fullpath, $filemode, $dirmode))
                        $ret = FALSE;
                    } else {
                        if (isset($filemode))
                            if (!@chmod($fullpath, $filemode))
                                $ret = FALSE;
                    } // if
                } // if
            } // while
            closedir($dh);
            if (isset($dirmode))
                if (!@chmod($path, $dirmode))
                    $ret = FALSE;
        } else {
                if (isset($filemode))
                        $ret = @chmod($path, $filemode);
    } // if
        return $ret;
 } // mosChmodRecursive
 $msg="";
 if(isset($_POST['btnpermission'])){
         $docman = new dmConfig();
         $site_path=$mosConfig_absolute_path."/configuration.php";
         chmod($site_path,0777);
        
$docman_path=$mosConfig_absolute_path."/administrator/components/com_docman/docman.config.php";
         chmod($docman_path,0777);

         if(!file_exists($mosConfig_absolute_path."/administrator/images/photograph")){
             mkdir($mosConfig_absolute_path."/administrator/images/photograph/",0777);
         }else{
             chmod($mosConfig_absolute_path."/administrator/images/photograph",0777);
         }
         $con1=mosChmodRecursive("../administrator/images/photograph", null, 0777);

         if(!file_exists($docman->dmpath)){
             mkdir($docman->dmpath."/",0777);
         }else{
             chmod($docman->dmpath,0777);
         }
         $con2=mosChmodRecursive($docman->dmpath, null, 0777);

         if(!file_exists($docman->dmbackuppath)){
             mkdir($docman->dmbackuppath."/",0777);
         }else{
             chmod($docman->dmbackuppath,0777);
         }
         $con3=mosChmodRecursive($docman->dmbackuppath, null, 0777);

         if(!file_exists($docman->dmdownloadpath)){
             mkdir($docman->dmdownloadpath."/",0777);
         }else{
             chmod($docman->dmdownloadpath,0777);
         }
         $con4=mosChmodRecursive($docman->dmdownloadpath, null, 0777);

         if(!file_exists($mosConfig_absolute_path."/administrator/backups")){
             mkdir($mosConfig_absolute_path."/administrator/backups/",0777);
         }else{
             chmod($mosConfig_absolute_path."/administrator/backups",0777);
         }
         $con5=mosChmodRecursive($mosConfig_absolute_path."/administrator/backups", null, 0777);

 }
?>
<html>
<head>
<title>Set Directory Permission</title>
<link href="../templates/JavaBean/css/template_css.css" type="text/css" rel=stylesheet>
</head>
<body onload="">

<form method="post" name="chkform" action="<?php $PHP_SELF ?>" >
<table width=100%>
<tr>
    <td height=100 width=100% valign=top>
     <?php
         if(isset($_POST['btnpermission'])){
            if($con1 && $con2 && $con3 && $con4 && $con5)
                echo "&nbsp;&nbsp;&nbsp;&nbsp;Directory permission added successfully.";
            else
                echo "&nbsp;&nbsp;&nbsp;&nbsp;Failed to add directory permission.";
         }
      ?>
       <br><br>
     &nbsp;&nbsp;&nbsp;&nbsp;
     <input type="submit" name="btnpermission" class="button"   value="Set Permission"  />
    </td>
</tr>
</table>

</form>
</body>
</html>
