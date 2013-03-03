<?php

if(empty ($_POST['gonder']) ) { 
   ?> 
    <form action="<? echo $_SERVER['PHP_SELF']; ?>" 
   enctype="multipart/form-data" method="post"> 
    
    resim sec:<input type="file" name="photo"> 
   <input type="submit" name="gonder" value="gonder"> 
    </form> 
   <?php 
    
    }else{ 
   if(is_uploaded_file($_FILES['photo']['tmp_name'])) 
    { 
    if(move_uploaded_file($_FILES['photo']['tmp_name'], 
   "photo/".$_FILES['photo']['name'])) 
    { 
    $url="photo/".$_FILES['photo']['name'].""; 
    echo "secilen <b>".$url."</b> adli resim<br>\n"; 
    } 
    else 
    { 
    echo "hata oldu"; 
    } 
    } 
   $db=mysql_connect ("localhost","varitabanı ismi","veri tabanı şifresi"); 
    if(!$db) { 
    echo "mysqle baglanamadım".mysql_error($db).""; 
    } 
    $ds=mysql_select_db("secilecek veri tabanı ismi"); 
    if(!$ds) { echo "vt seçilemedi".mysql_error($ds)."";} 
   
   $veri[1]=trim($url); 
   
   $veri_kaydi="insert into resim values ('','$veri[1]')"; 
    $vsorgu=mysql_query($veri_kaydi); 
   if(isset($vsorgu) ) { 
    echo "<b>databaseye tasindi</b>"; 
    } 
    else{ 
    echo "hata oldu"; 
    } 
    } 
    ?>
?>
