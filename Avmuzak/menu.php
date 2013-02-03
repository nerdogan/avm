<?php include_once('classes/translate.class.php'); ?>
<?php include_once('classes/check.class.php'); ?>
<?php

/*
 * Yan menu #sidebar ref deki değere göre otomatik
 * oluşturacak fonksiyon ...           
 */

class yanmenu
{
public $data=array();

public function goster()
{
 
 $a='<li><a href="home.php"> <img src="assets/img/logo1.png"></a> </li>';
 
return $a;
}
}

$menu= new yanmenu;
echo $menu->goster();
?>
