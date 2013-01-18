<?php include_once('settings.php'); ?>
<fieldset>
	<legend><?php _e('General Options'); ?></legend>
	<div class="control-group">
		<label class="control-label" for="admin_email"><?php _e('Admin email'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('This email will be used to send all emails.'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<input type="email" class="input-xlarge" id="admin_email" name="admin_email" value="<?php echo $settings->getOption('admin_email'); ?>">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="site_address"><?php _e('Site address'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('This path should be set to where activate.php is located.'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<input type="url" class="input-xlarge" id="site_address" name="site_address" value="<?php echo $settings->getOption('site_address'); ?>">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="default_session"><?php _e('Default session'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('Default time in minutes a user can be logged in. Enter 0 to log the user out when they close their browser.'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<input type="number" min=0 class="input-mini" id="default_session" name="default_session" value="<?php echo $settings->getOption('default_session'); ?>" placeholder="0">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="default-level"><?php _e('Default level'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('The default level a new user will have when signing up, or by being created through the admin panel.'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<?php $settings->returnLevels('default-level'); ?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="user-activation-enable"><?php _e('New users'); ?></label>
		<div class="controls">
		<label class="checkbox">
			<input type="checkbox" class="input-xlarge" id="disable-registrations-enable" name="disable-registrations-enable" <?php echo $settings->getOption('disable-registrations-enable', true); ?>>
			<?php _e('Disable registrations'); ?>
		</label>
		<label class="checkbox">
			<input type="checkbox" class="input-xlarge" id="user-activation-enable" name="user-activation-enable" <?php echo $settings->getOption('user-activation-enable', true); ?>>
			<?php _e('Require email activation for new users'); ?>
		</label>
		<label class="checkbox">
			<input type="checkbox" class="input-xlarge collapsed" id="notify-new-user-enable" name="notify-new-user-enable" <?php echo $settings->getOption('notify-new-user-enable', true); ?>>
			<?php _e('Notify on new registrations'); ?>
		</label>
		<div class="hidden">
			<label class="textarea">
				<?php $settings->returnLevels('notify-new-users'); ?>
			</label>
		</div>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="pw-encrypt-force-enable"><?php _e('Password encryption'); ?></label>
		<div class="controls">
		<label class="checkbox">
			<input type="checkbox" class="input-xlarge" id="pw-encrypt-force-enable" name="pw-encrypt-force-enable" <?php echo $settings->getOption('pw-encrypt-force-enable', true); ?>>
			<?php _e('Force user to update password if not using selected encryption method'); ?>
		</label>
		<?php $pw_encryption = $settings->getOption('pw-encryption'); ?>
		<?php $e = array('MD5', 'SHA256'); ?>
		<?php foreach ($e as $value) : ?>
			<label class="radio">
				<input type="radio" name="pw-encryption" id="<?php echo $value; ?>" value="<?php echo $value; ?>" <?php if ($pw_encryption == $value) echo 'checked'; ?> > <?php echo $value; ?>
			</label>
		<?php endforeach; ?>
		</div>
	</div>

	<legend><?php _e('Redirect Options'); ?></legend><br>

	<div class="control-group">
		<label class="control-label" for="guest-redirect"><?php _e('Guests'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('Where to redirect guests when attempting to access a secured page.'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<input type="url" class="input-xlarge" id="guest-redirect" name="guest-redirect" placeholder="<?php echo SITE_PATH . 'login.php'; ?>" value="<?php echo $settings->getOption('guest-redirect'); ?>">
			<p class="help-block"><?php _e('Default: <code>login.php?e=1</code>'); ?></p>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="new-user-redirect"><?php _e('New users'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('After a new user registers, where should the user be redirected to? By default the user is sent to the My Account page.'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<input type="url" class="input-xlarge" id="new-user-redirect" name="new-user-redirect" placeholder="<?php echo SITE_PATH . 'profile.php'; ?>" value="<?php echo $settings->getOption('new-user-redirect'); ?>">
			<p class="help-block"><?php _e('Default: <code>profile.php</code>'); ?></p>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="signout-redirect-referrer-enable"><?php _e('Sign out'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('When the user logs out of your site through logout.php.'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" class="uncollapsed input-xlarge" id="signout-redirect-referrer-enable" name="signout-redirect-referrer-enable" <?php echo $settings->getOption('signout-redirect-referrer-enable', true); ?>>
				<?php _e('Redirect to referring page'); ?>
			</label>
			<input type="url" class="input-xlarge" id="signout-redirect-url" name="signout-redirect-url" placeholder="<?php echo SITE_PATH; ?>" value="<?php echo $settings->getOption('signout-redirect-url'); ?>">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="signin-redirect-referrer-enable"><?php _e('Sign in'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('The default page to load when a user logs in.'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" class="uncollapsed input-xlarge" id="signin-redirect-referrer-enable" name="signin-redirect-referrer-enable" <?php echo $settings->getOption('signin-redirect-referrer-enable', true); ?>>
				<?php _e('Redirect to referring page'); ?>
			</label>
			<input type="url" class="input-xlarge" id="signin-redirect-url" name="signin-redirect-url" placeholder="<?php echo SITE_PATH; ?>" value="<?php echo $settings->getOption('signin-redirect-url'); ?>">
		</div>
	</div>

	<p class="help-block"><?php _e('<b>Note:</b> Level specific redirects can be set on their respective level edit page and will override the options configured above.'); ?></p>

	<input type="hidden" name="general-options-form" value="1">
</fieldset>