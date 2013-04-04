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
 <script type="text/javascript" src="http://www.ohloh.net/p/633115/widgets/project_languages.js"></script>
  </div>
    
    <div id="tabs-2">
        <input type="text" name="id">
<?php
       //     $temp = array("a"=>1, "b"=>2);
// $postdata = http_build_query($temp);

$ch = curl_init();
//curl_setopt($ch, CURLOPT_POST, true); //POST Metodu kullanarak verileri gönder
curl_setopt($ch, CURLOPT_HEADER, false); //Serverdan gelen Header bilgilerini önemseme.
curl_setopt($ch, CURLOPT_URL, "http://www.google.com.tr"); //Bağlanacağı URL
//curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata); //POST verilerinin querystring hali. Gönderime hazır!
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //Transfer sonuçlarını return et. Onları kullanacağım!
curl_setopt($ch, CURLOPT_TIMEOUT, 20); //20 saniyede işini bitiremezsen timeout ol.
$data = curl_exec($ch);
curl_close($ch);

echo $data;
?>
    </div>
    <div id="tabs-3">
        <input type="text" name="idd">
<?php 

// http://www.tcmb.gov.tr/kurlar/201303/27032013.xml
$content = file_get_contents("http://www.tcmb.gov.tr/kurlar/today.xml"); 

$dolar_bul = explode('<Currency Kod="USD" CurrencyCode="USD">' ,$content); 

$dolar_bul = explode('</ForexBuying>',$dolar_bul[1]); 

$dolar_alis = explode('<ForexBuying>',$dolar_bul[0]); 

$dolar_bul = explode('</ForexSelling>',$dolar_bul[1]); 

$dolar_satis = explode('<ForexSelling>',$dolar_bul[0]); 

$dolar_alis = $dolar_alis[1]; 

$dolar_satis = $dolar_satis[1]; 



$euro_bul = explode('<Currency Kod="EUR" CurrencyCode="EUR">' ,$content); 

$euro_bul = explode('</ForexBuying>',$euro_bul[1]); 

$euro_alis = explode('<ForexBuying>',$euro_bul[0]); 

$euro_bul = explode('</ForexSelling>',$euro_bul[1]); 

$euro_satis = explode('<ForexSelling>',$euro_bul[0]); 

$euro_alis = $euro_alis[1]; 

$euro_satis = $euro_satis[1]; 

echo $dolar_alis,$dolar_satis;
echo $euro_alis,$euro_satis;

?>
       
   </div>
    </form>
</div>
 <input type="submit">
     
    
