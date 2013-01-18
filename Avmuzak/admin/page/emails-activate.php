<?php include_once('settings.php'); ?>
<fieldset>
	<legend><?php _e('Activation emails'); ?></legend>
	<div class="control-group">
		<label class="control-label" for="email-activate-resend-subj"><?php _e('Resend link'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('The email a user receives when requesting an activation link.'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<label>
				<input type="text" class="input-xlarge" id="email-activate-resend-subj" name="email-activate-resend-subj" value="<?php echo $settings->getOption('email-activate-resend-subj'); ?>">
				<p class="help-inline"><?php _e('Subject'); ?></p>
			</label>
			<textarea class="input-xlarge" id="email-activate-resend-msg" name="email-activate-resend-msg" rows="10"><?php echo $settings->getOption('email-activate-resend-msg'); ?></textarea>
			<div class="help-inline">
				<p><?php _e('Message body'); ?></p><br>
				<p><strong><?php _e('Shortcodes:'); ?></strong></p>
				<p><?php _e('Site address:'); ?> <code>{{site_address}}</code></p>
				<p><?php _e('Full name:'); ?> <code>{{full_name}}</code></p>
				<p><?php _e('Username:'); ?> <code>{{username}}</code></p>
				<p><?php _e('Activation link:'); ?> <code>{{activate}}</code></p>
			</div>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="email-activate-subj"><?php _e('Activated'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('The email a user receives after activating their account.'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<label>
				<input type="text" class="input-xlarge" id="email-activate-subj" name="email-activate-subj" value="<?php echo $settings->getOption('email-activate-subj'); ?>">
				<p class="help-inline"><?php _e('Subject'); ?></p>
			</label>
			<textarea class="input-xlarge" id="email-activate-msg" name="email-activate-msg" rows="10"><?php echo $settings->getOption('email-activate-msg'); ?></textarea>
			<div class="help-inline">
				<p><?php _e('Message body'); ?></p><br>
				<p><strong><?php _e('Shortcodes:'); ?></strong></p>
				<p><?php _e('Site address:'); ?> <code>{{site_address}}</code></p>
				<p><?php _e('Full name:')?> <code>{{full_name}}</code></p>
				<p><?php _e('Username:'); ?> <code>{{username}}</code></p>
			</div>
		</div>
	</div>
</fieldset>