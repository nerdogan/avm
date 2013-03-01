<?php include_once('classes/login.class.php'); ?>
<?php include_once('header.php'); ?>
<div class="page">
           
            <div class="page-header-content">
               
               
<div id="forgot-form" class="modal hide fade">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3><?php _e('Parolamı Unuttum !'); ?></h3>
	</div>
	<div class="modal-body">
		<div id="message"></div>
		<form action="forgot.php" method="post" name="forgotform" id="forgotform" class="form-stacked forgotform normal-label">
			<div class="controlgroup forgotcenter">
			<label for="usernamemail"><?php _e('Kullanıcı Adı ya da Email Adresi'); ?></label>
				<div class="control">
					<input id="usernamemail" name="usernamemail" type="text"/>
				</div>
			</div>
			<input type="submit" class="hidden" name="forgotten">
		</form>
	</div>
	<div class="modal-footer">
		<button data-complete-text="<?php _e('Tamam'); ?>" class="btn btn-primary pull-right" id="forgotsubmit"><?php _e('Gönder'); ?></button>
		<p class="pull-left"><?php _e('Lütfen email adresinizi kontrol ediniz.'); ?></p>
	</div>
</div>
 <div class="span4" style="position: fixed;top:250px;left: 50%;width:500px;margin-left:-250px;">
<div class="row">
   
	
		<form method="post" class="form normal-label" action="login.php">
		<fieldset>
<p><span class="forgot place-right">
        <a data-toggle="modal" href="#forgot-form" id="forgotlink" tabindex=-1><?php _e('Parolamı Unuttum'); ?></a>?
    </span></p>
    
    <img class="place-left" src="assets/images/powerlock.png">
		<input  class="place-right" id="username" name="username" maxlength="15" type="text" style="height: 46px; -webkit-border-radius: 7px;width: 300px" placeholder="Kullanıcı adı"/><br><br>
               <input class="place-right" id="password" name="password" size="30" type="password"  style="height: 46px; -webkit-border-radius: 7px;width: 300px" placeholder="Parola"/>
				
		</fieldset>

		<input type="hidden" name="token" value="<?php echo $_SESSION['jigowatt']['token']; ?>"/>
                <div class="span4">
                <label class="remember  place-right" for="remember">
			<input type="checkbox" id="remember" name="remember"/><span ><?php _e(' Beni Hatırla !'); ?></span>
		</label>
                </div>
		<input type="submit" value="<?php _e(' Giriş '); ?>" class=" btn login-submit place-right" id="login-submit" name="login"/>
               
		

		<p class="signup"><a href="sign_up.php"><?php _e(''); ?></a></p>

		<?php if ( !empty($jigowatt_integration->enabledMethods) ) : ?>

		<div class="">
			<?php foreach ($jigowatt_integration->enabledMethods as $key ) : ?>
				<p><a href="login.php?login=<?php echo $key; ?>"><img src="assets/img/<?php echo $key; ?>_signin.png" alt="<?php echo $key; ?>"></a></p>
			<?php endforeach; ?>
		</div>

		<?php endif; ?>

		</form>
	</div>
     

</div></div></div></div>

 

<?php include_once('footer.php'); ?>