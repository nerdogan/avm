<?php include_once('admin.php'); ?>
<?php include_once(dirname(dirname(__FILE__)) . '/classes/add_user.class.php'); ?>
<fieldset>
	<form method="post" class="form form-horizontal" action="page/user-add.php" id="user-add-form">
		<div id="message"></div>
		<fieldset>
			<div class="control-group">
				<label class="control-label" for="name"><?php _e('Name'); ?></label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="name" name="name">
				</div>
			</div>

			<div class="control-group" id="usrCheck">
				<label class="control-label" for="username"><?php _e('Username'); ?></label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="username" name="username" maxlength="15">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="email"><?php _e('Email'); ?></label>
				<div class="controls">
					<input type="email" class="input-xlarge" id="email" name="email">
				</div>
			</div>
		<p class="help-block"><?php _e('<b>Note</b>: A random password will be generated and emailed to the user.'); ?></p>
		</fieldset>
		<div class="form-actions">
			<button type="submit" name="add_user" class="btn btn-primary" id="user-add-submit"><?php _e('Add user'); ?></button>
		</div>
	</form>
</fieldset>

<script>
$(document).ready(function() {
/** Admin add user form validation */
$("#user-add-form").validate({

	/** Admin add user form submit */
	submitHandler: function() {

		$('#user-add-submit').button('loading');

		var post = $('#user-add-form').serialize();
		var action = $('#user-add-form').attr('action');

		$("#message").slideUp(350, function () {

			$('#message').hide();

			$.post(action, post, function (data) {

				$('#message').html(data);
				$('#message').slideDown('slow');

				if (data.match('success') !== null) {
					$('#user-add-form input').val('');
					$('#user-add-submit').button('reset');
				} else {
					$('#user-add-submit').button('reset');
				}
			});
		});
	},
	rules: {
		name: "required",
		username: {
			required: true,
			minlength: 2,
			remote: {
				url: "classes/add_user.class.php",
				type: "post",
				data: { checkusername: "1" }
			}
		},
		email: {
			required: true,
			email: true,
			remote: {
				url: "classes/add_user.class.php",
				type: "post",
				data: { checkemail: "1" }
			}
		}
	},
	messages: {
		name: "Please enter a name.",
		username: {
			required: "Username is required.",
			minlength: $.format("Enter at least {0} characters"),
			remote: jQuery.format("Username has been taken.")
		},
		email: {
			required: "We need an email address too.",
			email: "Doesn't look like a valid email :(",
			remote: jQuery.format("Email address is in use.")
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