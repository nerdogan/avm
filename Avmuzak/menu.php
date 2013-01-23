<?php include_once('classes/translate.class.php'); ?>
<?php include_once('classes/check.class.php'); ?>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<ul class="nav">
<li><a href="home.php"> <img src="assets/img/batmanpark.png"></a> </li>
<?php if( protectThis(1) ) : ?>
<li><a href="magaza.php?do=ekle"><?php _e('Ekle kardeş'); ?></a></li>
<li><a href="magaza.php?do=duzenle"><?php _e('Düzenle'); ?></a></li>
<li><a href="#"><?php _e('Sil'); ?></a></li>
<li><a href="#"><?php _e('Tam Liste'); ?></a></li>
<li><a href="magaza.php?do=arama"><?php _e('Arama'); ?></a></li>
<li><a href="#"><?php _e(''); ?></a></li>
<li><a href="protected.php"><?php _e(''); ?></a></li>
</ul>
<?php endif; ?>