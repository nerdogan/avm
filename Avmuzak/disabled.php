<?php

	include_once(dirname(__FILE__) . '/classes/generic.class.php');
	include_once(cINC . 'header.php');

	if(empty($_SESSION['jigowatt']['username'])) { header('Location: home.php'); exit(); }

	// Attention ! Please read the following.
	// It is important you do not edit pieces of code that aren't tagged as a configurable options identified by the following:

	// Configuration option.

	// Each option that is easily editable has a modified example given.

	$error = '';

	if(isset($_POST['contactus'])) {

	$name     = $generic->secure($_POST['name']);
	$email    = $generic->secure($_POST['email']);
	$subject  = $generic->secure($_POST['subject']);
	$comments = $generic->secure($_POST['comments']);
	$verify   = strtolower($generic->secure((string) $_POST['verify']));


	// Configuration option.
	// You may change the error messages below.
	// e.g. $error = 'Attention! This is a customised error message!';

	if(empty($name)) {
		$error = '<div class="alert alert-error">'._('You must enter your name.').'</div>';
	} else if(empty($email)) {
		$error = '<div class="alert alert-error">'._('Please enter a valid email address.').'</div>';
	} else if(!$generic->isEmail($email)) {
		$error = '<div class="alert alert-error">'._('You have enter an invalid e-mail address, try again.').'</div>';
	}

	if(empty($subject)) {
		$error = '<div class="alert alert-error">'._('Please enter a subject.').'</div>';
	} else if(empty($comments)) {
		$error = '<div class="alert alert-error">'._('Please enter your message.').'</div>';
	} else if(empty($verify)) {
		$error = '<div class="alert alert-error">'._('Please enter the verification code.').'</div>';
	} else if(trim($verify) != 'blue') {
		$error = '<div class="alert alert-error">'._('The verification code you entered is incorrect.').'</div>';
	}

	if(empty($error)) { if(get_magic_quotes_gpc()) { $comments = stripslashes($comments); }

	 // Configuration option.
	 // Enter the email address that you want to emails to be sent to.
	 // Example $address = "joe.doe@yourdomain.com";

	 if(!isset($address)) $address = "example@codecanyon.net";


	 // Configuration option.
	 // i.e. The standard subject will appear as, "You've been contacted by John Doe."

	 // Example, $e_subject = '$name . ' has contacted you via Your Website.';

	 $e_subject = ''._('You\'ve been contacted by').' ' . $name . '.';


	 // Configuration option.
	 // You can change this if you feel that you need to.
	 // Developers, you may wish to add more fields to the form, in which case you must be sure to add them here.

	 $e_body = _('You have been contacted by $name with regards to $subject, their additional message is as follows.')."\r\n\r\n";
	 $e_content = "\"$comments\"\r\n\r\n";
	 //$e_reply = "You can contact $name via email, $email or via phone $phone";
	 $e_reply = sprintf(_('You can contact %s via email, %s'), $name, $email) . "\r\n";

	 $msg = $e_body . $e_content . $e_reply;

	 mail($address, $e_subject, $msg, "From: $email\r\nReply-To: $email\r\nReturn-Path: $email\r\n");

	 // Email has sent successfully, echo a success page.

	 echo "<div class='alert alert-success'>"._('Email Sent Successfully')."</div>";
	 echo "<p>"._('Thank you')." <strong>$name</strong>," ._('your message has been submitted to us.')."</p>";

	}
	}

	if(!isset($_POST['contactus']) || !empty($error)) // Do not edit.
	{

	echo $error;
?>
	<h1><?php _e('Oops, Access Denied'); ?></h1>
	<h4><?php _e('Sorry, your username or user group has been disabled!'); ?></h4>
	<p><?php  _e('We have detected that your username or user group has been disabled; so you cannot view internal pages.'); ?></p>
	<p><?php  _e('Fill out this form if you feel this is in error'); ?></p>

		<br/>
		<fieldset>

		<form method="post" action="disabled.php">

		<div class="clearfix">
		<label for="name"><?php _e('Name'); ?></label>
			<div class="input">
				<input id="name" name="name" size="30" type="text" value="<?php if(isset($name)) echo $name;?>"/>
			</div>
		</div><!-- /clearfix -->

		<div class="clearfix">
		<label for="email"><?php _e('Email'); ?></label>
			<div class="input">
				<input id="email" name="email" size="30" type="text" value="<?php if(isset($email)) echo $email;?>"/>
			</div>
		</div><!-- /clearfix -->

		<div class="clearfix">
		<label for="subject"><?php _e('Subject'); ?></label>
			<div class="input">
			 <select name="subject" id="subject">
			  <option selected="selected" value="User / Group Disabled"><?php _e('Disabled Message'); ?></option>
			  <option value="a Bug fix"><?php _e('Report a bug'); ?></option>
			 </select>
			</div>
		</div><!-- /clearfix -->

		<div class="clearfix">
		<label for="comments" accesskey="C"><?php _e('Your comments'); ?></label>
			<div class="input">
				<textarea name="comments" cols="20" rows="3" class="xxlarge" /><?php if(isset($comments)) echo $comments; ?></textarea>
			</div>
		</div><!-- /clearfix -->

		<div class="clearfix">
		<label for="verify"><?php _e('What colour is the sky?'); ?></label>
			<div class="input">
				<input id="verify" name="verify" size="4" type="text" value="<?php if(isset($verify)) echo $verify;?>"/>
			</div>
		</div><!-- /clearfix -->

		<input name="contactus" type="submit" class="btn btn-primary" id="contactus" value="<?php _e('Submit'); ?>" />

		</form>

		</fieldset>


<?php } include_once(cINC . 'footer.php'); ?>