<?php

/**
 * Edit an existing user.
 *
 * LICENSE:
 *
 * This source file is subject to the licensing terms that
 * is available through the world-wide-web at the following URI:
 * http://codecanyon.net/wiki/support/legal-terms/licensing-terms/.
 *
 * @author       Jigowatt <info@jigowatt.co.uk>
 * @author       Matt Gates <matt.gates@jigoshop.com>
 * @copyright    Copyright © 2009-2012 Jigowatt Ltd.
 * @license      http://codecanyon.net/wiki/support/legal-terms/licensing-terms/
 * @link         http://codecanyon.net/item/php-login-user-management/49008
 */

include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Edit_user extends Generic {

	private $options = array();

	function __construct() {

		// Make sure a user has been selected
		if(!empty($_GET['uid'])) $this->grabCurrentUser(); else parent::displayMessage("<div class='alert alert-error'>"._('No user selected!')."</div>");

		/* Keep track of the original level in case there's a change. We might want to send emails on new level changes. */
		$this->original_level = is_array($this->options['user_level']) ? serialize($this->options['user_level']) : $this->options['user_level'];

		// Once the form has been processed
		if(!empty($_POST)) {

			// Save all values
			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

			// Validate fields
			$this->validate();

			// Process the form
			echo empty($this->error) ? $this->process() : $this->error;

		}

	}

	private function grabCurrentUser() {

		$this->id = parent::secure($_GET['uid']);

		$params = array( ':user_id' => $this->id );
		$stmt   = parent::query("SELECT user_id, user_level, restricted, username, name, email FROM login_users WHERE user_id = :user_id;", $params);

		if( $stmt->rowCount() < 1 ) parent::displayMessage("<div class='alert alert-error'>"._('No such user!')."</div>");

		foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
			$this->options[$field] = $value;

	}

	public function getLevels() {

		$ids = is_array($this->options['user_level']) ? $this->options['user_level'] : unserialize($this->options['user_level']);
		$placeholder = array_fill(0, count($ids), '?');

		$sql   = "SELECT level_name, level_level FROM login_levels WHERE level_disabled != 1 AND level_level NOT IN (" . implode(',', $placeholder) . ")";
		$stmt2 = parent::query($sql, $ids);

		$sql = "SELECT level_name, level_level FROM login_levels WHERE level_level IN (" . implode(',', $placeholder) . ")";
		$stmt3 = parent::query($sql, $ids);

		?>
		<select class="medium chzn-select" multiple="multiple" id="user_level" name="user_level[]">
			<?php while($level = $stmt3->fetch()) : ?>
			<?php echo $level['level_level'];  ?>
			<option selected="selected" value="<?php echo $level['level_level']; ?>"><?php echo $level['level_name']; ?></option>
			<?php endwhile; ?>
			<?php while($level = $stmt2->fetch()) : ?>
			<option value="<?php echo $level['level_level']; ?>"><?php echo $level['level_name']; ?></option>
			<?php endwhile; ?>
		</select>
		<?php

	}

	private function validate() {

		$this->options['restricted'] = !empty($_POST['restricted']) ? 1 : 0;

		// Checkbox handling
		$fields = parent::getOption('profile-fields');
		if ($fields) :
			foreach(unserialize($fields) as $type => $label) :
				$name = 'p-'.$label;
				if(strstr($type, "checkbox"))
					$this->options[$name] = !empty($this->options[$name]) ? 1 :0;
			endforeach;
		endif;

		// Setting a default user_level if one wasn't selected
		$this->options['user_level'] = empty($_POST['user_level']) ? parent::getOption('default-level') : serialize($this->options['user_level']);

		if ( $this->options['user_level'] != $this->original_level ) {

			$new_level = unserialize($this->options['user_level']);
			$original_level = unserialize($this->original_level);

			$send_levels = array_diff($new_level, $original_level);

			$levels = implode(',' , $send_levels);
			$sql = 'SELECT * FROM `login_levels` WHERE `welcome_email` = "1" AND `level_level` IN ('.$levels.')';
			$stmt = parent::query($sql);

			$this->sendWelcome = ( $stmt->rowCount() > 0 ) ? true : false;

		}

		if(empty($this->options['name'])) {
			$this->error = '<div class="alert alert-error">'._('You must enter name.').'</div>';
		} else if(!parent::isEmail($this->options['email'])) {
			$this->error = '<div class="alert alert-error">'._('You have entered an invalid e-mail address, try again.').'</div>';
		} else if(!isset($this->options['user_level'])) {
			$this->error = '<div class="alert alert-error">'._('No user level has been selected.').'</div>';
		}

		// Password been entered? If so, validate
		if(!empty($this->options['password'])) :
			if($this->options['password'] != $this->options['password2'])
				$this->error = '<div class="alert alert-error">'._('Your passwords did not match.').'</div>';
			if(strlen($this->options['password']) < 5)
				$this->error = '<div class="alert alert-error">'._('Your password must be at least 5 characters.').'</div>';
		endif;
	}

	private function process() {

		if(!empty($this->error))
			return false;

		// Ticked the 'delete user' box?
		if(!empty($this->options['delete'])) {
			$params = array( ':id' => $this->id );
			$sql = "DELETE FROM login_users WHERE user_id = :id;";
			parent::query($sql, $params);

			$result = sprintf("<div class='alert alert-success'>"._('User removed from the database:')." <b>%s</b> (%s).</div>",$this->options['name'], $this->options['username']);
			parent::displayMessage($result);
		}

		if(!empty($this->options['password'])) {
			$params = array(
				':restrict' => $this->options['restricted'],
				':name'     => $this->options['name'],
				':email'    => $this->options['email'],
				':level'    => $this->options['user_level'],
				':password' => parent::hashPassword($this->options['password']),
				':id'       => $this->id
			);
			$sql = "UPDATE `login_users` SET `restricted` = :restrict, `name` = :name, `email` = :email, `user_level` = :level, `password` = :password WHERE `user_id` = :id;";

			parent::query($sql, $params);
			$result = sprintf("<div class='alert alert-success'>"._('User information (and password) updated for')." <b>%s</b> (%s).</div>",$this->options['name'], $this->options['username']);
		}

		// Password has not been entered don't update password fields.
		else {
			$params = array(
				':restrict' => $this->options['restricted'],
				':name'     => $this->options['name'],
				':email'    => $this->options['email'],
				':level'    => $this->options['user_level'],
				':id'       => $this->id
			);
			$sql = "UPDATE `login_users` SET `restricted` = :restrict, `name` = :name, `email` = :email, `user_level` = :level WHERE `user_id` = :id;";
			parent::query($sql, $params);
			$result = sprintf("<div class='alert alert-success'>"._('User information updated for')." <b>%s</b> (%s).</div>",$this->options['name'], $this->options['username']);
		}

		// Checkbox handling
		$sql  = "SELECT * FROM `login_profile_fields`;";
		$stmt = parent::query($sql);

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :

			$name = 'p-' . $row['id'];

			if($row['type'] == 'checkbox')
				$this->options[$name] = !empty($this->options[$name]) ? 1 :0;

		endwhile;

		// Update profile fields
		foreach($this->options as $field => $value) :

			if(strstr($field,'p-')) {
				$field = str_replace('p-', '', $field);
				parent::updateOption($field, $value, true, $this->options['user_id']);
			}

		endforeach;

		/* Time to send our welcome email! */
		if ( $this->sendWelcome ) :

			$msg  = parent::getOption('email-welcome-msg');
			$subj = parent::getOption('email-welcome-subj');

			$shortcodes = array(
				'site_address' => SITE_PATH,
				'full_name'    => $this->options['name'],
				'username'     => $this->options['username'],
				'email'        => $this->options['email'],
			);

			if(!parent::sendEmail($shortcodes['email'], $subj, $msg, $shortcodes))
				$this->error = _('ERROR. Mail not sent');

		endif;


		return $result;
	}

	// Return a form field
	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];

	}

}