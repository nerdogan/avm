<?php include_once('settings.php'); ?>
<fieldset>
	<legend><?php _e('Social login'); ?></legend><br>

	<p><?php _e('Enable any of these methods to permit your users logging in with them.'); ?></p>

	<div class="control-group">
		<label class="control-label" for="integration-twitter-enable"><?php _e('Twitter'); ?></label>
		<div class="controls">

			<label class="checkbox">
				<input type="checkbox" class="input-xlarge collapsed" id="integration-twitter-enable" name="integration-twitter-enable" <?php echo $settings->getOption('integration-twitter-enable', true); ?>>
				<?php _e('Enable'); ?>
			</label>

			<div class="hidden">

			<label>
				<input type="text" class="input-xlarge" id="twitter-key" name="twitter-key" value="<?php echo $settings->getOption('twitter-key'); ?>">
				<p class="help-inline"><?php _e('Consumer key'); ?></p>
			</label>

			<label>
				<input type="text" class="input-xlarge" id="twitter-secret" name="twitter-secret" value="<?php echo $settings->getOption('twitter-secret'); ?>">
				<p class="help-inline"><?php _e('Consumer secret'); ?></p>
			</label>

			<p><?php echo sprintf(_('You must first <a href="%s">setup a Twitter App</a>.'), 'https://dev.twitter.com/apps/new'); ?></p>
			<p><?php echo sprintf(_('When setting up your app, for <i>Callback URL</i>, use <code>%s</code>'), "http://".$_SERVER['HTTP_HOST']); ?></p>

			</div>

		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="integration-facebook-enable"><?php _e('Facebook'); ?></label>
		<div class="controls">

			<label class="checkbox">
				<input type="checkbox" class="input-xlarge collapsed" id="integration-facebook-enable" name="integration-facebook-enable" <?php echo $settings->getOption('integration-facebook-enable', true); ?>>
				<?php _e('Enable'); ?>
			</label>

			<div class="hidden">

			<label>
				<input type="text" class="input-xlarge" id="facebook-app-id" name="facebook-app-id" value="<?php echo $settings->getOption('facebook-app-id'); ?>">
				<p class="help-inline"><?php _e('App ID'); ?></p>
			</label>

			<label>
				<input type="text" class="input-xlarge" id="facebook-app-secret" name="facebook-app-secret" value="<?php echo $settings->getOption('facebook-app-secret'); ?>">
				<p class="help-inline"><?php _e('App Secret'); ?></p>
			</label>

			<p><?php echo sprintf(_('You must first <a href="%s">setup a Facebook App</a>.'), 'https://developers.facebook.com/apps'); ?></p>

			</div>

		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="integration-facebook-enable"><?php _e('OpenID Networks'); ?></label>
		<div class="controls">

			<label class="checkbox">
				<input type="checkbox" class="input-xlarge" id="integration-google-enable" name="integration-google-enable" <?php echo $settings->getOption('integration-google-enable', true); ?>>
				<?php _e('Google'); ?>
			</label>

			<label class="checkbox">
				<input type="checkbox" class="input-xlarge" id="integration-yahoo-enable" name="integration-yahoo-enable" <?php echo $settings->getOption('integration-yahoo-enable', true); ?>>
				<?php _e('Yahoo'); ?>
			</label>

		</div>

	</div>
</fieldset>

<fieldset>
	<legend><?php _e('Captcha signup'); ?></legend><br>
	<?php $selectedCaptcha = $settings->getOption('integration-captcha'); ?>

	<p><?php _e('Require human verification on the registration form.'); ?></p>

	<div class="control-group">
		<label class="control-label" for="integration-disableCaptcha-enable"><?php _e('Disable captcha'); ?></label>
		<div class="controls">


			<label class="radio">
				<input type="radio" class="input-xlarge collapsed" id="integration-disableCaptcha-enable" name="integration-captcha" value="disableCaptcha" <?php if ($selectedCaptcha == 'disableCaptcha') echo 'checked="checked"'; ?>>
			</label>

		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="integration-reCAPTCHA-enable"><a href="http://www.google.com/recaptcha"><?php _e('reCAPTCHA'); ?></a></label>
		<div class="controls">

			<label class="radio">
				<input type="radio" class="input-xlarge collapsed" id="integration-reCAPTCHA-enable" name="integration-captcha" value="reCAPTCHA" <?php if ($selectedCaptcha == 'reCAPTCHA') echo 'checked="checked"'; ?>>
				<?php _e('Enable'); ?>
			</label>

			<div class="hidden">

			<label>
				<input type="text" class="input-xlarge" id="reCAPTCHA-public-key" name="reCAPTCHA-public-key" value="<?php echo $settings->getOption('reCAPTCHA-public-key'); ?>">
				<p class="help-inline"><?php _e('Public key'); ?></p>
			</label>

			<label>
				<input type="text" class="input-xlarge" id="reCAPTCHA-private-key" name="reCAPTCHA-private-key" value="<?php echo $settings->getOption('reCAPTCHA-private-key'); ?>">
				<p class="help-inline"><?php _e('Private key'); ?></p>
			</label>

			<p><?php echo sprintf(_('You must first <a href="%s">create a reCAPTCHA key</a>.'), 'http://www.google.com/recaptcha/whyrecaptcha'); ?></p>

			</div>

		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="integration-playThru-enable"><a href="http://areyouahuman.com/?utm_source=Jigowatt&utm_medium=Jigowatt&utm_campaign=Jigowatt"><?php _e('PlayThru'); ?></a></label>
		<div class="controls">

			<label class="radio">
				<input type="radio" class="input-xlarge collapsed" id="integration-playThru-enable" name="integration-captcha" value="playThru" <?php if ($selectedCaptcha == 'playThru') echo 'checked="checked"'; ?>>
				<?php _e('Enable'); ?>
			</label>

			<div class="hidden">

			<label>
				<input type="text" class="input-xlarge" id="playThru-publisher-key" name="playThru-publisher-key" value="<?php echo $settings->getOption('playThru-publisher-key'); ?>">
				<p class="help-inline"><?php _e('Publisher key'); ?></p>
			</label>

			<label>
				<input type="text" class="input-xlarge" id="playThru-scoring-key" name="playThru-scoring-key" value="<?php echo $settings->getOption('playThru-scoring-key'); ?>">
				<p class="help-inline"><?php _e('Scoring key'); ?></p>
			</label>

			<p><?php echo sprintf(_('You must first <a href="%s">signup to get a site key</a>.'), 'http://portal.areyouahuman.com/signup?utm_source=Jigowatt&utm_medium=Jigowatt&utm_campaign=Jigowatt'); ?></p>

			</div>

		</div>
	</div>

	<input type="hidden" name="integration-form" value="1">
</fieldset>