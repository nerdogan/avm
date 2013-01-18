<?php include_once('admin.php'); ?>
<?php include_once('../classes/send_email.class.php'); ?>
<fieldset>
	<form method="post" class="form form-horizontal" action="page/send-email.php" id="send-email-form">
		<legend><?php _e('Send email'); ?></legend>
		<div id="send-email-message"></div>
		<fieldset>

			<div class="control-group">
				<label class="control-label" for="to"><?php _e('To'); ?> <a href="#" data-rel="tooltip" tabindex="99" title="<?php _e('Select the user groups that will receive your email. (This will send as BCC)'); ?>"><i class="icon-question-sign"></i></a></label>
				<div class="controls">
				<?php $sendEmail->displayLevels(); ?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="subject"><?php _e('Subject'); ?></label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="subject" name="subject">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="message"><?php _e('Message'); ?></label>
				<div class="controls">
					<textarea class="input-xlarge" id="message" name="message" rows="5"></textarea>
				</div>
			</div>

		</fieldset>

		<div class="form-actions">
			<button type="submit" name="send_email" class="btn btn-primary" id="send-email-submit" data-loading-text="sending"><?php _e('Send now!'); ?></button>
		</div>

	</form>
</fieldset>

<script>
$('#send-email-form').submit(function (e) {
	"use strict";

    e.preventDefault();
	$('#send-email-submit').button('loading');

	var post = $('#send-email-form').serialize();
	var action = $('#send-email-form').attr('action');

	$("#send-email-message").slideUp(350, function () {

		$('#send-email-message').hide();

		$.post(action, post, function (data) {

			$('#send-email-message').html(data);
			$('#send-email-message').slideDown('slow');

			if (data.match('success') !== null) {
				$('#send-email-form input').val('');
				$('#send-email-submit').button('reset');
			} else {
				$('#send-email-submit').button('reset');
			}
		});
	});
});
</script>