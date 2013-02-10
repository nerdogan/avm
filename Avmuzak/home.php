<?php include_once('classes/check.class.php'); ?>
<?php include_once('header.php'); ?>


<div class="page secondary">
     
        
 
        <div class="page-region">
            <div class="page-region-content">
                <div class="row">
      <div class="span12 text-center" >      
        <p><?php if( !protectThis(1) ) : ?>
	<a href="http://onlinearge.com/avm/login.php" target="_self" class="btn btn-info btn-large"><?php _e('Sisteme Giriş Yapın'); ?> &raquo;<img src="./assets/img/ofis.png" class="place-right"></a>
	        </p>		
     </div></div>
        <div class="features">
	<div class="row">
		
                
                <div  class="span6"><a href="#" class="btn btn-warning btn-large">
			<h2><?php _e('Finans'); ?></h2>
                        <p><?php _e('Mağazalarınızın tüm finansal bilgilerini kontrol altında tutabilirsiniz.'); ?></p>
		
		</a></div>

                <div class="span6" ><a href="#" class="btn btn-danger btn-large">
			<h2><?php _e('Cari'); ?></h2>
			<p><?php _e('Her bir mağaza için oluşturulan bilgi kartlarınıza kolayca erişim sağlayın.'); ?></p>
		</a></div>
	</div>

	<div class="row">
		<div class="span6" >
		<a href="#" class="btn btn-success btn-large">	
                    <h2><?php _e('Mağaza Hareketleri'); ?></h2>
			<p><?php _e('Mağazaların banka hareketleri, faturalar, ödemeler vb. tüm hareketlerini kayıt altında tutmanızı sağlayan kolay yönetim sistemi.'); ?></p>
                </a></div>

		<div class="span6">
                            
		<a href="#" class="btn btn-info btn-large">	
                    <h2><?php _e('Güvenlik'); ?></h2>
			<p>Güçlü kullanıcı kontrol altyapısı ile sınırsız sayıda yetkilendirilmiş kullanıcı tanımlayabilirsiniz.
                            <?php _e(' Avm bilgileriniz 256 bit "Rapid SSL" güvenlik sistemi ile koruma altında.'); ?>
                        </p>
                </a></div>
	</div>
</div>

	<?php else : ?>
		
      
	</p>
	

    
       
        <br><br>            
               
             
                    <a href="fatura.php?do=liste" >
                        
                          <div class="tile double bg-color-pinkDark outline-color-red">
                                    <div class="tile-content">
                                        <img src="./assets/img/fatura.jpg" class="place-left"/>
                                        <h3 style="margin-bottom: 5px;">FİNANS</h3>
                                        <p>
                                           Finansal  işlemler için 
                                        <h5></h5>
                                        </p>
                                    </div>
                                    <div class="brand">
                                        <span class="name">Vadesi Gelen :</span>
                                          <div class="badge bg-color-orange">12</div>
                                    </div>
                                </div></a>
                   
        <a href="cari.php?do=arama" >
                        
                          <div class="tile double bg-color-purple outline-color-orange">
                                    <div class="tile-content">
                                        <img src="./assets/img/atm.png" class="place-left"/>
                                        <h3 style="margin-bottom: 5px;">CARİ</h3>
                                        <p>
                                          Cari işlemleri
                                        <h5></h5>
                                        </p>
                                    </div>
                                    <div class="brand">
                                        <span class="name">Ödenmesi Gereken : 58.350</span>
                                        
                                    </div>
                                </div></a>     
        
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
        
         <div class="tile bg-color-blue ">
                      
                        <div class="tile-content ">
                            <h4 class="place-right">   <?php  echo tarihcevir (date("d.m.Y")); ?></h4>
                            <h3 class="place-right"> <span id=saat  class="fg-color-darken" ></span><br><br>Takvim</h3>
<SCRIPT language=JScript>
saatigoster();
window.setInterval("saatigoster();",60000);
</SCRIPT>
</FONT>
                        </div>
                        <div class="brand">
                            <span class="name"></span>
                            <span class="badge" ></span>
                        </div>
                    </div>
        
         <div class="tile double image">
                        <div class="tile-content">
                            <img src="./assets/images/4.jpg" alt="" />
                        </div>
                        
                    </div>

                    
        
        
        
         <a href="magaza.php?do=arama" >
                        
                          <div class="tile double bg-color-greenLight outline-color-blue">
                                    <div class="tile-content">
                                        <img src="./assets/img/shop.png" class="place-left"/>
                                        <h3 style="margin-bottom: 5px;">Mağaza</h3>
                                        <p>
                                          Mağaza işlemleri
                                        <h5></h5>
                                        </p>
                                    </div>
                                    <div class="brand">
                                        <span class="name">Talepte bulunan : 7 </span>
                                        
                                    </div>
                                </div></a>     
        
      

           
            
           <div class="tile double bg-color-green">
                                    <div class="tile-content">
                                        <h2>mattberg@live.com</h2>
                                        <h5>Re: Wedding Annoucement!</h5>
                                        <p>
                                            Congratulations! I'm really excited to celebrate with you all. Thanks for...
                                        </p>
                                    </div>
                                    <div class="brand">
                                        <div class="badge">12</div>
                                        <img class="icon" src="./assets/images/Mail128.png"/>
                                    </div>
           </div>
        
           <div class="tile double bg-color-yellow " data-role="tile-slider" data-param-period="3000">
                         
       <?php    $number=0;    
foreach($generic->query('SELECT magaza.kod,tarih,magaza.unvan,faturano,gtop,nott  FROM fatura INNER JOIN magaza ON  fatura.musno =  magaza.id') as $row) {
    $number++;
    echo '<div class="tile-content fg-color-red">';
    echo "<h4>",$row[2],"</h4><h4>",$row[4],"TL</h4><p>",$row[1]," tarih ",$row[3]," nolu fatura <a href='fatura.php?do=liste'></a></p></div>" ;
}
    
   ?>
        </div>
        
                    <div class="tile icon bg-color-red">
                        <div class="tile-content">
                            <img src="./assets/images/excel2013icon.png"/>
                        </div>
                        <div class="brand">
                            <span class="name">Excel 2013</span>
                        </div>
                    </div>
                 
            
         <a href="magaza.php?do=arama" >
                        
                          <div class="tile double bg-color-pink outline-color-blue">
                                    <div class="tile-content">
                                        <img src="./assets/images/teknik.png" class="place-right"/>
                                        <h3 style="margin-bottom: 5px;">TEKNİK</h3>
                                        <p>
                                         Demirbaş bilgileri,bakım zamanları işlemleri<br>
                                         Mağazaların tamir ve tadilat talepleri
                                        <h5></h5>
                                        </p>
                                    </div>
                                    <div class="brand">
                                        <span class="name">Talepte bulunan : 11 </span>
                                        
                                    </div>
                                </div></a>   
        
        
        
            

</div>       
</div>    
</div>
</div>
<?php  endif;  ?>




<?php include_once('footer.php'); ?>