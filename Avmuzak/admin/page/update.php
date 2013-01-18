<?php include_once('settings.php');
$newUpdate = $settings->newUpdate(); ?>
<fieldset>
	<legend><?php _e('Update'); ?></legend>
		<br><div class="row">
			<?php if (!$settings->newChangelog()) : ?>
				<div class="span8 alert alert-block alert-warning fade in"><a class="close" data-dismiss="alert" href="#">&times;</a><h4 class="alert-warning"><?php _e('Updates disabled'); ?></h4>
				<p><?php _e('Two thing may have happened:'); ?></p>
				<ol>
					<li><?php _e('Update checking is disabled'); ?></li>
					<li><?php _e('Could not connect to server to fetch latest update details. Please make sure the PHP setting `allow_url_fopen` is enabled.'); ?></li>
				</ol>
				</div>
				<?php elseif($newUpdate) : ?>
				<div class="span8 alert alert-block alert-info fade in"><a class="close" data-dismiss="alert" href="#">&times;</a><h4 class="alert-info"><?php _e('Update available!'); ?></h4>
				<?php _e('There\'s a new update available! Please visit your CodeCanyon profile to download the new version.'); ?></div>
				<?php else : ?>
				<div class="span8 alert alert-block alert-success fade in"><a class="close" data-dismiss="alert" href="#">&times;</a><h4 class="alert-success"><?php _e('You\'re up to date!'); ?></h4>
				<?php _e('There are no new updates available. When a new update is released this message will change accordingly.'); ?></div>
			<?php endif; ?>
		</div>

	<div class="control-group">
		<label class="control-label" for="update-check-enable"><?php _e('Check for updates'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('Disabling this may improve speed on the Settings page'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" id="update-check-enable" name="update-check-enable" <?php echo $settings->getOption('update-check-enable', true); ?>>
				<?php _e('Enable to automatically check for updates each time you load this page'); ?>
			</label>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php _e('Current version'); ?></label>
		<div class="controls">
			<span class="uneditable-input"><?php echo phplogin_version ?></span>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php _e('Latest version'); ?></label>
		<div class="controls">
			<span class="uneditable-input"><?php echo $newUpdate ? $settings->newVersion() : phplogin_version; ?></span>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php _e('Latest changelog'); ?></label>
		<div class="controls">
			<textarea rows="10" class="span5" disabled><?php echo $settings->newChangelog(); ?></textarea>
		</div>
	</div>
		<input type="hidden" name="update-form" value="1">
</fieldset>