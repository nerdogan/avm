<?php include_once('settings.php'); ?>
<fieldset>
	<legend><?php _e('Add user'); ?></legend>
	<div class="control-group">
		<label class="control-label" for="email-add-user-subj"><?php _e('Add user'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('When the admin creates a new user through the admin panel, the user will receive this email.'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<label>
				<input type="text" class="input-xlarge" id="email-add-user-subj" name="email-add-user-subj" value="<?php echo $settings->getOption('email-add-user-subj'); ?>">
				<p class="help-inline"><?php _e('Subject'); ?></p>
			</label>
			<textarea class="input-xlarge" id="email-add-user-msg" name="email-add-user-msg" rows="10"><?php echo $settings->getOption('email-add-user-msg'); ?></textarea>
			<div class="help-inline">
				<p><?php _e('Message body'); ?></p><br>
				<p><strong><?php _e('Shortcodes:'); ?></strong></p>
				<p><?php _e('Site address:'); ?> <code>{{site_address}}</code></p>
				<p><?php _e('Full name:'); ?> <code>{{full_name}}</code></p>
				<p><?php _e('Username:'); ?> <code>{{username}}</code></p>
				<p><?php _e('Password:'); ?> <code>{{password}}</code></p>
			</div>
			<p class="help-block"><strong><?php _e('Note:'); ?></strong> <?php _e('The password is randomly generated and should be included in the email'); ?></p>
		</div>
	</div>
</fieldset>