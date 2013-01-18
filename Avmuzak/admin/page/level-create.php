<?php include_once('admin.php'); ?>
<?php include_once(dirname(dirname(__FILE__)) . '/classes/add_level.class.php'); ?>
<fieldset>
	<form method="post" class="form form-horizontal" id="level-add-form" action="page/level-create.php">
		<div id="level-message"></div>
		<fieldset>
			<div class="control-group">
				<label class="control-label" for="level"><?php _e('Name'); ?></label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="level" name="level" value="<?php echo $addLevel->getPost('level'); ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="auth"><?php _e('Level'); ?></label>
				<div class="controls">
					<input type="number" min="0" class="input-mini" id="auth" name="auth" value="<?php echo $addLevel->getPost('auth'); ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="auth"><?php _e('Redirect'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('When logging in, this user will be redirected to the URL you specify. Leave blank to redirect to the referring page.'); ?>"><i class="icon-question-sign"></i></a></label>
				<div class="controls">
					<input id="redirect" class="input-xlarge" name="redirect" type="url" placeholder="eg, http://google.com" value="<?php echo $addLevel->getPost('auth'); ?>"/>
				</div>
			</div>
		<div class="form-actions">
			<button type="submit" name="add_level" class="btn btn-primary" id="level-add-submit"><?php _e('Create level'); ?></button>
		</div>
		</fieldset>
	</form>
</fieldset>

<script>
$(document).ready(function() {
/** Create level form */
$("#level-add-form").validate({

	/** admin add level form */
	submitHandler: function() {

		$('#level-add-submit').button('loading');

		var post = $('#level-add-form').serialize();
		var action = $("#level-add-form").attr('action');

		$("#level-message").slideUp(350, function () {

			$('#level-message').hide();

			$.post(action, post, function (data) {

				$('#level-message').html(data);

				document.getElementById('level-message').innerHTML = data;
				$('#level-message').slideDown('slow');
				if (data.match('success') !== null) {
					$('#level-add-form input').val('');
					$('#level-add-submit').button('reset');
				} else {
					$('#level-add-submit').button('reset');
				}
			});
		});
	},
	rules: {
		level: "required",
		auth: {
			required: true,
			remote: {
				url: "classes/add_level.class.php",
				type: "post",
				data: { checklevel: "1" }
			}
		}
	},
	messages: {
		level: {
			required: "This needs to be filled out.",
			remote: jQuery.format("Username has been taken.")
		},
		auth: {
			required: "An auth level is required.",
			remote: jQuery.format("Auth level in use.")
		}
	},
	errorClass: 'error',
	validClass: 'success',
	errorElement: 'p',
	highlight: function(element, errorClass, validClass) {
		$(element).parent('div').parent('div').removeClass(validClass).addClass(errorClass);
	},
	unhighlight: function(element, errorClass, validClass) {
		$(element).parent('div').parent('div').removeClass(errorClass).addClass(validClass);
	},
});
});
</script>