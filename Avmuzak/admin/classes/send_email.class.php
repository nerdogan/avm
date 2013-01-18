<?php

/**
 * Send an email to a group of users.
 *
 * A random password is generated and emailed to the user.
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

class Send_email extends Generic {

	private $message;

	function __construct() {

		if(!empty($_POST)) :

			$this->sendMail();

			if(!empty($this->message))
				echo $this->message;

			exit();

		endif;

	}

	private function sendMail() {

		/* No user group selected on form. */
		if ( empty($_POST['to-levels'] ) ) {
			$this->message = '<div class="alert alert-error">' . _('Please select a user group') . '</div>';
			return false;
		}

		/* Variable to store all the email addresses of each chosen group. */
		$emails = array();

		foreach ( $_POST['to-levels'] as $level_id ) :

			/* Grab all users within the user group. */
			$params = array( ':level_id' => '%:"' . $level_id . '";%' );
			$sql = "SELECT * FROM `login_users` WHERE `user_level` LIKE :level_id";
			$stmt = parent::query($sql, $params);

			/* Send email to each user in group. */
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
				$emails[] = $row['email'];
			endwhile;

		endforeach;

		/* Remove duplicates for users with multiple user groups. */
		$emails = array_unique($emails);

		if(!parent::sendEmail($emails, $_POST['subject'], $_POST['message'], '', true))
			$this->message = _('ERROR. Mail not sent');

		$this->message = '<div class="alert alert-success">' . _('Email sent!') . '</div>';

	}

	public function displayLevels() {

		$stmt = parent::query('SELECT level_name, level_level FROM login_levels');

		?>
		<select class="input-xlarge chzn-select" data-placeholder="<?php _e('Select your levels'); ?>" multiple="multiple" id="to-levels" name="to-levels[]">
			<?php while($level = $stmt->fetch()) : ?>
			<option value="<?php echo $level['level_level']; ?>"><?php echo $level['level_name']; ?></option>
			<?php endwhile; ?>
		</select>
		<?php

	}

}

$sendEmail = new Send_email();