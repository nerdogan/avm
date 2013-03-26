<?php include_once('classes/check.class.php'); ?>
<?php include_once('header.php'); ?>
<?php if( !protectThis("*") ) :header( 'Location: login.php' );
endif; 
 
?>

<div class="page secondary">
         <div class="page-region">
            <div class="page-region-content">
                <div class="row">
     
        <p><?php if( !protectThis(1) ) : ?>
	<a href="http://onlinearge.com/avm/login.php" target="_self" class="btn btn-info btn-large" style="position: fixed;top:250px;left: 40%;width:560px;margin-left:-100px;"><?php _e('Sisteme Giriş Yapın'); ?> &raquo;<img src="./assets/img/ofis.png" class="place-right"></a>
	        </p>		
  
	<?php else : ?>
        <a href="magaza.php?do=arama" >
                        
                          <div class="tile triple bg-color-red">
                                    <div class="tile-content">
                                      <img src="./assets/images/market.png" class="place-left" style="height: 96px;width: 96px;margin-top: 40px"/>
                                        <h2 style="margin-top: 20px;margin-bottom: 25px" >MAĞAZA KARTLARI</h2>
                                         <p > Mağaza ile ilgili tüm işlemleri buradan yapabilirsiniz.</p> 
                       </div>
                                    
                                </div></a>     
        
       
          <a href="magaza.php?do=arama" >
                        
                          <div class="tile triple bg-color-purple">
                                    <div class="tile-content">
                                         <img src="./assets/images/teknik.png" style="width: 96px;height: 96px;margin-top: 40px" class="place-left"/>
                                         <h2 style="margin-bottom: 25px;margin-top: 20px" >TEKNİK</h2>
                                        <p>Demirbaş bilgileri,bakım zamanları işlemleri<br /> Mağazaların tamir ve tadilat talepleri</p>
                                    </div>
                                </div></a> 

         <a href="fatura.php?do=liste" >
                        
              <div class="tile triple bg-color-torq">
                                    <div class="tile-content">
                                      <img src="./assets/images/hesap.png" class="place-left" style="height: 100px;width: 96px;margin-top: 30px"/>
                                        <h2 style="margin-top: 20px;margin-bottom: 25px">HAREKETLER</h2>
                                        <p>Cari fatura, banka, ödeme, tahsilat ile ilgili tüm işlemleri buradan yapabilirsiniz.</p> 
                                     
                                    </div>
                                    
                                </div>            
         
         </a>
               
			   <div class="tile double bg-color-grey">
                                    <div class="tile-content">
									     <h2 style="margin-top:20px; margin-bottom: 25px; margin-left:120px">FİNANS</h2>
									     <img src="./assets/images/finans.png" style="height: 96px; width:96px;margin-top:-30px"/>
                                         <p style="margin-top:-70px; margin-left:120px">Mağazanızın Finansal Takibini yapabilirisniz.</p>
                                    </div>
										</div>
			   
        <a href="cari.php?do=arama" >
                        
                           <div class="tile triple bg-color-orangeDark">
                                    <div class="tile-content">
                                      <img src="./assets/images/liste.png" class="place-left" style="height: 166px; width:136px;margin-top:-13px"/>
                                        <h1 style="margin-top: 20px;margin-bottom: 25px" >LİSTELER</h1>
                                        <p >Cari fatura, banka, ödeme, tahsilat ile ilgili tüm raporlama işlemlerini buradan yapabilirsiniz.</p> 
                                     
                                    </div>
                                </div>      
        </a>     

           <div class="tile double bg-color-orange">
                                    <div class="tile-content">
									     <h1 style="margin-top:20px; margin-bottom: 25px" class="place-right">STOK TAKİP</h1>
									     <img src="./assets/images/stok.png" class="place-left" style="height: 96px; width:96px;margin-top:0px"/>
                                         <p style="margin-top:40px"> Mağazanızın stok takibini yapabilirsiniz.</p>
                                    </div>
										</div>
										
										<div class="tile triple bg-color-darken">
                                    <div class="tile-content">
                                      <img src="./assets/images/carihes.png" class="place-left" style="height: 100px;width: 96px;margin-top: 30px"/>
                                        <h1 style="margin-top: 20px;margin-bottom: 25px" class="place-right">CARİ HESAP</h1>
                                        <p>Fatura, banka, ödeme, tahsilat ile ilgili tüm işlemleri buradan yapabilirsiniz.</p> 
                                     
                                    </div>
                                    
                                </div>   
          
		   <div class="tile bg-color-pink">
                        <div class="tile-content ">
                            <h2>İstanbul</h2><br>
                            <?php
$site="http://weather.yahooapis.com/forecastrss?w=29391294&u=c";
$ssite=  file_get_contents($site);
$site1=  explode('</pubDate>', $ssite);
$site1= explode('temp="', $site1[1]);
$site1= explode('"', $site1[1]);

echo "<h2 class='place-right'>",$site1[0],"&deg;</h2>";
?>
                                            
                        </div>
                        <div class="brand">
                            <span class="image"><img src="<?php echo $site1[4]; ?>" class='place-left'  > </span>
                        </div>
                    </div>
        
         <div class="tile bg-color-green ">
                      
                        <div class="tile-content ">
                            <h4 class="place-right">   <?php  echo tarihcevir (date("d.m.Y")); ?></h4><br><br><br><br>
                            <h3 class="place-right"> <span id=saat  class="fg-color-darken place-right" ></span><br><br>Takvim</h3>
<SCRIPT language=JScript>
saatigoster();
window.setInterval("saatigoster();",60000);
</SCRIPT>
</FONT>
                        </div>
                        <div class="brand">
                            <img class="icon" src="./assets/images/saat.png" style="width: 46px;height: 46px;"/>
                            <span class="name"></span>
                            <span class="badge" ></span>
                        </div>
                    </div>
        
    
       
 
          <div class="tile bg-color-blueDark ">
                      
                        <div class="tile-content ">
                           <img src="./assets/images/ev.png" class="place-left" style="height: 166px;width: 166px;margin-top:10px"/>  
                     </div>
                      
                    </div>
    <div class="tile bg-color-blue ">
                      
                        <div class="tile-content ">
                            
                            
                           <img src="./assets/images/pdf.png" class="place-left" style="height: 166px;width: 166px;margin-top:10px"/>  
                            
                            
                     </div>
                        
                    </div>
    <div class="tile bg-color-blueDark ">
                      
                        <div class="tile-content ">
                       <img src="./assets/images/okey.png" class="place-left" style="height: 166px;width: 166px;margin-top:10px"/>  
                          
                     </div>
                        
                    </div>
        
        <div class="tile bg-color-blue ">
                      
                        <div class="tile-content ">
                        <img src="./assets/images/live.png" class="place-left" style="height: 166px;width: 166px;margin-top:10px"/>  
     
                     </div>
                        
                    </div>
    </div>
                               
        
        <!---        
           <div class="tile double bg-color-yellow " data-role="tile-slider" data-param-period="3000">
                         
       <?php    $number=0;    
  //  foreach($generic->query('SELECT magaza.kod,tarih,magaza.unvan,faturano,gtop,nott  FROM hareket INNER JOIN magaza ON  hareket.musno =  magaza.id') as $row) {
  //  $number++;
  //  echo '<div class="tile-content fg-color-red">';
   // echo "<h4>",$row[2],"</h4><h4>",$row[4],"TL</h4><p>",$row[1]," tarih ",$row[3]," nolu fatura <a href='fatura.php?do=liste'></a></p></div>" ;
// }
       ?>
        </div>
        --->

</div>       
</div>    

<?php  endif; 
//$date = new DateTime('2012-05-17');
//echo  date("d-m-Y h:i:s", $date->getTimestamp());
//$saatfarki = "2"; //server ile aradaki saat farkı
//$tarih_arr = getdate((time()+3600*$saatfarki));

//print_r($tarih_arr);

?>

<?php include_once('footer.php'); ?>