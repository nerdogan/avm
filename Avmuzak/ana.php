<?php include_once('classes/check.class.php'); ?>
<?php include_once('header.php');
// yan menu başlangıç?>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="tabs">
  <ul>
    <li><a href="#tabs-1" title="iyimiş bu ajghdjhdghg dhjgdhjg dhj dhg">Anasayfa</a></li>
    <li><a href="#tabs-2">Fatura</a></li>
    <li><a href="#tabs-3">Tab 2</a></li>
    <li><a href="ajax/content3-slow.php">Tab 3 (slow)</a></li>
    <li><a href="ajax/content4-broken.php">Tab 4 (broken)</a></li>
  </ul>
    
  <div id="tabs-1">
      <?php echo $_POST['id']; ?>
      <form action="ana.php" name="formmm" method="post">
   </div>
    
    <div id="tabs-2">
        <input type="text" name="id"></input>
   </div>
    <div id="tabs-3">
        <input type="text" name="idd"></input>
       
   </div>
    </form>
</div>
 <input type="submit">