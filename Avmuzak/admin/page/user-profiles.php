<?php include_once('settings.php'); ?>
<fieldset>
	<legend><?php _e('User profiles'); ?></legend>

	<div class="control-group">
		<label class="control-label" for="profile-public-enable"><?php _e('Profile Control'); ?></a></label>
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" id="profile-public-enable" name="profile-public-enable" <?php echo $settings->getOption('profile-public-enable', true); ?>>
				<?php _e('Make all profiles public'); ?>
			</label>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="profile-timestamps-enable"><?php _e('Access logs'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('Log a timestamp + IP address for when a user signs in.'); ?>"><i class="icon-question-sign"></i></a></label>
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox" id="profile-timestamps-enable" name="profile-timestamps-enable" <?php echo $settings->getOption('profile-timestamps-enable', true); ?>>
				<?php _e('Enable logging'); ?>
			</label>
			<label class="checkbox">
				<input type="checkbox" id="profile-timestamps-admin-enable" name="profile-timestamps-admin-enable" <?php echo $settings->getOption('profile-timestamps-admin-enable', true); ?>>
				<?php _e('Viewable to admin only'); ?>
			</label>
		</div>
	</div>

	<table class="table profile-field-rows">
	<thead>
		<tr>
			<th><?php _e('Section'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('Group your fields by assinging sections to them.'); ?>"><i class="icon-question-sign"></i></a></th>
			<th><?php _e('Input type'); ?></th>
			<th><?php _e('Input label'); ?></th>
			<th><?php _e('Sign Up'); ?></th>
			<th><?php _e('Public'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('Show this field on a user\'s public profile.'); ?>"><i class="icon-question-sign"></i></a></th>
			<th><?php _e('Delete'); ?></th>
		</tr>
	</thead>
	<?php echo $settings->profile_fields(); ?>
	</table>
	<input type="hidden" name="user-profiles-form" value="1">
</fieldset>

<script>
// Admin profile fields
$('button.add-field').live('click', function(e) {
	e.preventDefault();
	var size = $('table.profile-field-rows tbody .profile-field-row').size() + 1;
	// Make sure tbody exists
	var tbody_size = $('table.profile-field-rows tbody').size();
	if (tbody_size==0) $('table.profile-field-rows').append('<tbody></tbody>');
	// Add the row
	var addThis = $('<tr class="profile-field-row">\
		<td><input type="text" value="" placeholder="<?php _e('Section name'); ?>" name="profile-field_section[' + size + ']" class="input-medium" /></td>\
		<td><select name="profile-field_type[' + size + ']" class="input-medium">\
			<option value="text_input"><?php _e('Text input'); ?></option>\
			<option value="textarea"><?php _e('Textarea'); ?></option>\
			<option value="checkbox"><?php _e('Checkbox'); ?></option>\
		</select></td>\
		<td><input type="text" value="" placeholder="<?php _e('Field name'); ?>"  name="profile-field_name[' + size + ']" class="input-medium" /></td>\
		<td><select name="profile-field_signup[' + size + ']" class="input-medium">\
			<option value="hide"><?php _e('Hide'); ?></option>\
			<option value="require"><?php _e('Require'); ?></option>\
			<option value="optional"><?php _e('Optional'); ?></option>\
		</select></td>\
		<td><input type="checkbox" name="profile-field_public[' + size + ']"></td>\
		<td><input type="checkbox" name="profile-field_delete[' + size + ']"></td>\
		</tr>').fadeIn();
	$('table.profile-field-rows tr:last').before(addThis);
});
</script>