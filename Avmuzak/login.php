<?php include_once('classes/login.class.php'); ?>
<?php include_once('header.php'); ?>
<div class="page">
           
            <div class="page-header-content">
               
                <div class="span12 text-center">
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

<div class="row">
    <div class="btn btn-large btn-primary">
	<div class="main login">
		<form method="post" class="form normal-label" action="login.php">
		<fieldset>
		<h4><?php _e('Sisteme Giriş Yapın'); ?></h4>
			<div class="control-group">
			<label for="username" class="login-label"><?php _e('Kullanıcı Adı'); ?></label>
				<div class="controls">
					<input class="xlarge" id="username" name="username" maxlength="15" type="text"/>
                                        <p>	<span class="forgot"><a data-toggle="modal" href="#forgot-form" id="forgotlink" tabindex=-1><?php _e('Parolanızı mı Unuttunuz'); ?></a>?</span></p>
				</div>
			</div>

			<div class="control-group">
			<label for="password" class="login-label"><?php _e('Parolanız'); ?></label>
				<div class="controls">
					<input class="xlarge" id="password" name="password" size="30" type="password"/>
				</div>
			</div>
		</fieldset>

		<input type="hidden" name="token" value="<?php echo $_SESSION['jigowatt']['token']; ?>"/>
		<input type="submit" value="<?php _e('Giriş Yap'); ?>" class="btn login-submit" id="login-submit" name="login"/>

		<label class="remember" for="remember">
			<input type="checkbox" id="remember" name="remember"/><span><?php _e('Beni Hatırla !'); ?></span>
		</label>

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

</div></div></div></div></div>

<?php include_once('footer.php'); ?>