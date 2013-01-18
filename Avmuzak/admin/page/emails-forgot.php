<?php include_once('settings.php'); ?>
<fieldset>
	<legend><?php _e('Account recovery emails'); ?></legend>
	<div class="control-group">
		<label class="control-label" for="email-forgot-subj"><?php _e('Recover request'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('The email a user receives when requesting their username / password.'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<label>
				<input type="text" class="input-xlarge" id="email-forgot-subj" name="email-forgot-subj" value="<?php echo $settings->getOption('email-forgot-subj'); ?>">
				<p class="help-inline"><?php _e('Subject'); ?></p>
			</label>
			<textarea class="input-xlarge" id="email-forgot-msg" name="email-forgot-msg" rows="10"><?php echo $settings->getOption('email-forgot-msg'); ?></textarea>
			<div class="help-inline">
				<p><?php _e('Message body'); ?></p><br>
				<p><strong><?php _e('Shortcodes:'); ?></strong></p>
				<p><?php _e('Site address:'); ?> <code>{{site_address}}</code></p>
				<p><?php _e('Full name:'); ?> <code>{{full_name}}</code></p>
				<p><?php _e('Username:'); ?> <code>{{username}}</code></p>
				<p><?php _e('Reset link:'); ?> <code>{{reset}}</code></p>
			</div>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="email-forgot-success-subj"><?php _e('Recovered'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('The email a user receives after successfully resetting their password.'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<label>
				<input type="text" class="input-xlarge" id="email-forgot-success-subj" name="email-forgot-success-subj" value="<?php echo $settings->getOption('email-forgot-success-subj'); ?>">
				<p class="help-inline"><?php _e('Subject'); ?></p>
			</label>
			<textarea class="input-xlarge" id="email-forgot-success-msg" name="email-forgot-success-msg" rows="10"><?php echo $settings->getOption('email-forgot-success-msg'); ?></textarea>
			<div class="help-inline">
				<p><?php _e('Message body'); ?></p><br>
				<p><strong><?php _e('Shortcodes:'); ?></strong></p>
				<p><?php _e('Site address:'); ?> <code>{{site_address}}</code></p>
				<p><?php _e('Full name:'); ?> <code>{{full_name}}</code></p>
				<p><?php _e('Username:'); ?> <code>{{username}}</code></p>
			</div>
		</div>
	</div>
</fieldset>