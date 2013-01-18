<?php include('settings.php'); ?>
<!-- - - - - - - - - - - - - - - - -

		Denied messages

- - - - - - - - - - - - - - - - - -->
<fieldset>
	<legend><?php _e('Denied'); ?></legend>
	<div class="control-group">
		<label class="control-label" for="block-msg-enable"><?php _e('Registered users'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('This controls the message a <strong>signed in</strong> user sees when accessing a protected page.'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" class="input-xlarge collapsed" id="block-msg-enable" name="block-msg-enable" <?php echo $settings->getOption('block-msg-enable', true); ?>>
				<?php _e('Display message'); ?>
			</label>
			<div class="hidden">
			<label class="textarea">
				<textarea class="input-xlarge" id="block-msg" name="block-msg" rows="5"><?php echo $settings->getOption('block-msg'); ?></textarea>
			</label>
			</div>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="block-msg-out-enable"><?php _e('Guests'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('Show this error after a user is redirected to the login page (user is <strong>logged out</strong>).'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" class="input-xlarge collapsed" id="block-msg-out-enable" name="block-msg-out-enable" <?php echo $settings->getOption('block-msg-out-enable', true); ?>>
				<?php _e('Display message'); ?>
			</label>
			<div class="hidden">
			<label class="textarea">
				<textarea class="input-xlarge" id="block-msg-out" name="block-msg-out" rows="5"><?php echo $settings->getOption('block-msg-out'); ?></textarea>
			</label>
			</div>
		</div>
	</div>
	<input type="hidden" name="denied-form" value="1">
</fieldset>