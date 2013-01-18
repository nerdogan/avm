<?php

include_once( dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1");

include_once('header.php');

include_once('classes/edit_user.class.php');
$edituser = new Edit_user;

?>

<h1><?php echo $edituser->get_gravatar($edituser->getField('email'), true, 54); ?> <?php echo $edituser->getField('username') . ' (' . $edituser->getField('name') . ')'; ?></h1>

<br>

<div class="tabs-left">

	<ul class="nav nav-tabs">
		<li class="active"><a href="#usr-control" data-toggle="tab"><i class="icon-cog"></i> <?php _e('General'); ?></a></li>
		<?php $edituser->generateProfileTabs(); ?>
		<?php if (!$edituser->denyAccessLogs()) : ?>
		<li><a href="#usr-access-logs" data-toggle="tab"><i class="icon-list-alt"></i> <?php _e('Access logs'); ?></a></li>
		<?php endif; ?>
	</ul>

	<form method="post" class="form-horizontal">
		<div class="tab-content">
			<div class="tab-pane fade in active" id="usr-control">
					<fieldset>
						<legend><?php _e('General'); ?></legend>
						<div class="control-group">
							<label class="control-label" for="name"><?php _e('Name'); ?></label>
							<div class="controls">
								<input type="text" class="input-xlarge" id="name" name="name" value="<?php echo $edituser->getField('name'); ?>">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="password"><?php _e('Password'); ?></label>
							<div class="controls">
								<input type="password" autocomplete="off" class="input-xlarge" id="password" name="password">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="password2"><?php _e('Password again'); ?></label>
							<div class="controls">
								<input type="password" autocomplete="off" class="input-xlarge" id="password2" name="password2">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="email"><?php _e('Email'); ?></label>
							<div class="controls">
								<input type="email" class="input-xlarge" id="email" name="email" value="<?php echo $edituser->getField('email'); ?>">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="user_level"><?php _e('User levels'); ?></label>
							<div class="controls">
								<?php $edituser->getLevels(); ?>
							</div>
						</div>

						<?php if ( $edituser->getOption('profile-public-enable') ) : ?>
						<div class="control-group">
							<label class="control-label" for="confirm"><?php _e('Profile link'); ?></label>
							<div class="controls">
								<span class="uneditable-input"><?php echo SITE_PATH . 'profile.php?uid=' . $edituser->getField('user_id'); ?></span>
							</div>
						</div>
						<?php endif; ?>

						<div class="control-group">
							<div class="controls">
								<label class="checkbox">
									<input type="checkbox" class="input-xlarge" id="restricted" name="restricted" <?php if($edituser->getField('restricted') > 0) echo 'checked="checked"'; ?>>
									<?php _e('Restrict user?'); ?>
								</label>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<label class="checkbox">
									<input type="checkbox" class="input-xlarge" id="delete" name="delete">
									<?php _e('Delete user? (Can not be undone)'); ?>
								</label>
							</div>
						</div>
					</fieldset>
			</div>

			<?php $edituser->generateProfilePanels(); ?>

			<?php if (!$edituser->denyAccessLogs()) : ?>
			<div class="tab-pane fade" id="usr-access-logs">
				<fieldset>
					<legend><?php _e('Access Logs'); ?></legend>
					<?php $edituser->generateAccessLogs(); ?>
				</fieldset>
			</div>
			<?php endif; ?>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary" /><?php _e('Update user'); ?></button>
		</div>
	</form>
</div>

<?php include_once('footer.php'); ?>