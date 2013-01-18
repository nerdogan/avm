<?php
include_once( dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1");

include_once('header.php');
?>

<div class="row">

		<form method="post" class="form-horizontal">

		<?php include_once('classes/edit_level.class.php'); ?>

		<fieldset>
			<legend><?php echo $Edit_level->getValue('level_name'); ?> <small><?php _e('level control'); ?></small></legend>
			<div class="control-group">
				<label class="control-label" for="guest-redirect"><?php _e('Name'); ?></label>
				<div class="controls">
					<input id="level_name" name="level_name" type="text" value="<?php echo $Edit_level->getValue('level_name'); ?>"/>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="guest-redirect"><?php _e('Level'); ?></label>
				<div class="controls">
					<input id="level_level" class="input-mini" name="level_level" type="number" min="0" <?php if (!empty($Edit_level->isAdmin)) echo 'disabled'; ?> value="<?php echo $Edit_level->getValue('level_level'); ?>"/>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="guest-redirect"><?php _e('Redirect'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('When logging in, this user will be redirected to the URL you specify. Leave blank to redirect to the referring page.'); ?>"><i class="icon-question-sign"></i></a></label>
				<div class="controls">
					<input id="redirect" name="redirect" type="url" placeholder="eg, http://google.com" value="<?php echo $Edit_level->getValue('redirect'); ?>"/>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php _e('Welcome email'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('When a user is manually added to this level, that user will receive the standard welcome email automatically.'); ?>"><i class="icon-question-sign"></i></a></label>
				<div class="controls">
					<label class="checkbox">
					<input id="welcome_email" name="welcome_email" type="checkbox" <?php echo $Edit_level->getValue('welcome_email'); ?>/>
					<?php _e('Send welcome email when users join this level'); ?>
					</label>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php _e('Disable'); ?></label>
				<div class="controls">
					<label class="checkbox">
					<input id="disable" name="disable" type="checkbox" <?php if (!empty($Edit_level->isAdmin)) echo ' disabled '; ?> <?php echo $Edit_level->getValue('level_disabled'); ?>/>
					<?php _e('Prevent this level from accessing any secure content'); ?>
					</label>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php _e('Delete'); ?></label>
				<div class="controls">
					<label class="checkbox">
					<input id="delete" name="delete" type="checkbox" <?php if (!empty($Edit_level->isAdmin)) echo ' disabled '; ?>/>
					<?php _e('Remove this level from the database'); ?>
					</label>
				</div>
			</div>

		</fieldset>

			<div class="form-actions">
				<button type="submit" name="do_edit" class="btn btn-primary"><?php _e('Update'); ?></button>
			</div>

		</form>

</div>

<?php if(!empty($_GET['lid'])) :?>
<div class="row">
	<div class="span12">
		<legend><?php echo $Edit_level->getValue('level_name'); ?> <small><?php _e('existing users'); ?></small></legend>
		<?php in_level(); ?>
	</div>
</div>
<?php endif; ?>

<?php include_once('footer.php'); ?>