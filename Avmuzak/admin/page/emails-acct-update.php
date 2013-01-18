<?php include_once('settings.php'); ?>
<fieldset>
	<legend><?php _e("'My Account' changes"); ?></legend>
	<p><?php _e('<b>Note:</b> Only sent when a user changes his or her Email / Password.'); ?></p>
	<div class="control-group">
		<label class="control-label" for="email-acct-update-subj"><?php _e('Verify change'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('The email a user receives when updating an email or password.'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<label>
				<input type="text" class="input-xlarge" id="email-acct-update-subj" name="email-acct-update-subj" value="<?php echo $settings->getOption('email-acct-update-subj'); ?>">
				<p class="help-inline"><?php _e('Subject'); ?></p>
			</label>
			<textarea class="input-xlarge" id="email-acct-update-msg" name="email-acct-update-msg" rows="10"><?php echo $settings->getOption('email-acct-update-msg'); ?></textarea>
			<div class="help-inline">
				<p><?php _e('Message body'); ?></p><br>
				<p><strong><?php _e('Shortcodes:'); ?></strong></p>
				<p><?php _e('Site address:'); ?> <code>{{site_address}}</code></p>
				<p><?php _e('Full name:')?> <code>{{full_name}}</code></p>
				<p><?php _e('Username:'); ?> <code>{{username}}</code></p>
				<p><?php _e('Confirmation link:'); ?> <code>{{confirm}}</code></p>
			</div>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="email-acct-update-success-subj"><?php _e('Updated'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('The email a user receives after confirming the account change.'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<label>
				<input type="text" class="input-xlarge" id="email-acct-update-success-subj" name="email-acct-update-success-subj" value="<?php echo $settings->getOption('email-acct-update-success-subj'); ?>">
				<p class="help-inline"><?php _e('Subject'); ?></p>
			</label>
			<textarea class="input-xlarge" id="email-acct-update-success-msg" name="email-acct-update-success-msg" rows="10"><?php echo $settings->getOption('email-acct-update-success-msg'); ?></textarea>
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