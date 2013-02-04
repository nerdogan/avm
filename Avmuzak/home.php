<?php include_once('classes/check.class.php'); ?>
<?php include_once('header.php'); ?>


<div class="page secondary">
     
        <div class="page-header">
            <div class="page-header-content">
            ...
            </div>
        </div>
 
        <div class="page-region">
            <div class="page-region-content">
      <div class="span12">      
        <p><?php if( protectThis(1) ) : ?>
		<a href="#" target="_self" class="btn btn-info btn-large"><?php _e('Sistem Kontrol Paneli'); ?> &raquo;</a>
	<?php else : ?>
		<a href="http://onlinearge.com/avm/login.php" target="_self" class="btn btn-info btn-large"><?php _e('Sisteme Giriş Yapın'); ?> &raquo;</a>
		<?php endif; ?>

               <a data-toggle="modal" href="#hakk" class="btn btn-large btn-primary " id="forgotlink" tabindex=-1 > <?php _e('AVM Erp Hakkında'); ?></a>
	</p>
	

<div id="hakk" class="modal hide fade">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		
	</div>
	<div class="modal-body">
		<div id="message"><h2>Hakkında...</h2></div>
		<form action="home.php" method="post" name="hakknda" id="forgotform" class="form-stacked forgotform normal-label">
			<div class="controlgroup forgotcenter">
			<label for="usernamemail"><?php _e('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consectetur ornare scelerisque. Aliquam purus felis, molestie quis ullamcorper vel, accumsan a magna. Etiam venenatis ullamcorper tortor eget semper. Duis purus neque, fermentum eu porttitor nec, luctus pharetra nibh. Maecenas at ligula nulla, eget pellentesque eros. Donec quis enim et massa ultrices vehicula. Praesent porta blandit nibh ut scelerisque.

Pellentesque condimentum, arcu eget posuere tristique, leo urna malesuada felis, nec posuere lacus velit eu nunc. Morbi dui libero, accumsan in consectetur mollis, porttitor vitae ligula. Mauris luctus, velit sit amet fringilla scelerisque, enim elit laoreet ante, at mattis velit massa id arcu. Proin dolor velit, commodo quis mattis a, porta lobortis nunc. Phasellus eleifend venenatis tempor. Nunc euismod lacus sagittis turpis ornare ac elementum sem molestie. Aliquam suscipit mattis sem quis mollis.'); ?></label>
				
			</div>
			
		</form>
	</div>
	<div class="modal-footer">
		
		<p class="pull-left"><?php _e(''); ?></p>
	</div>
</div>
             
       
               
               
             
                    <a href="fatura.php?do=liste" >
                        
                          <div class="tile double bg-color-orange">
                                    <div class="tile-content">
                                        <img src="./assets/img/fatura.jpg" class="place-right"/>
                                        <h3 style="margin-bottom: 5px;">FATURA</h3>
                                        <p>
                                           Fatura işlemleri
                                        <h5>neen</h5>
                                        </p>
                                    </div>
                                    <div class="brand">
                                        <span class="name">Vadesi Gelen :</span>
                                          <div class="badge bg-color-orange">12</div>
                                    </div>
                                </div></a>
                   
        <a href="cari.php?do=arama" >
                        
                          <div class="tile double bg-color-purple">
                                    <div class="tile-content">
                                        <img src="./assets/img/shop.png" class="place-right"/>
                                        <h3 style="margin-bottom: 5px;">CARİ</h3>
                                        <p>
                                          Cari işlemleri
                                        <h5></h5>
                                        </p>
                                    </div>
                                    <div class="brand">
                                        <span class="name">Ödenmesi Gereken : 58.350</span>
                                          <div class="badge bg-color-purple">TL</div>
                                    </div>
                                </div></a>      
 
                     

	     </div>       
     
       
    

<div class="features">
	<div class="row">
		
                
                <div  class="span6"><a href="#" class="btn btn-warning btn-large">
			<h2><?php _e('Finans'); ?></h2>
		Mağazalarınızın tüm finansal bilgilerini kontrol altında tutabilirsiniz.
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
                    <br>
		<a href="#" class="btn btn-info btn-large">	
                    <h2><?php _e('Güvenlik'); ?></h2>
			<p><?php _e('Mağaza bilgileriniz 256 bit "Rapid SSL" güvenlik sistemi ile koruma altında.'); ?></p>
                </a></div>
	</div>
</div>

   </div>    
            </div>
        </div>
 
                <br><br><hr>



<?php include_once('footer.php'); ?>