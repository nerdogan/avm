<?php

/**
 * Generic functions used throughout the script.
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

date_default_timezone_set('UTC');

include_once( 'translate.class.php' );
include_once( 'connect.class.php' );

class Generic extends Connect {

	private $error;

	function __construct() {

		// Check to make sure install is complete
		$this->error = parent::checkInstall();

		// Start the session. Important.
		if (!isset($_SESSION)) session_start();

		include( 'prereqs.php' );
		$this->error = !empty($error) ? $error : $this->error;

		// Call the connection
		if(empty($this->error)) $this->error = parent::dbConn();

		$this->definePaths();

		// Check if an upgrade is required
		if(empty($this->error)) include_once( 'upgrade.class.php' );

		// Check for any errors and quit if there are
		$this->displayMessage($this->error);

	}

	/**
	 * Returns a mySQL query.
	 *
	 * @param     string      $query    An SQL statement.
	 * @param     array       $params   The binded variables to an SQL statement.
	 * @return    resource    Returns the query's execution.
	 */
	public function query($query, $params = array()) {

		if ( !is_array( $params ) ) return false;

		$dbh = parent::$dbh;

		if ( empty($dbh) ) return false;

		$stmt = $dbh->prepare($query);
		$stmt->execute($params);

		return $stmt;

	}

	/**
	 * Retrieves an option value based on option name.
	 *
	 * @param     string    $option    Name of option to retrieve.
	 * @param     bool      $check     Whether the option is a checkbox.
	 * @param     bool      $profile   Whether to return a profile field, or an admin setting.
	 * @param     int       $id        Required if profile is true; the user_id of a user.
	 * @return    string    The option value.
	 */
	public function getOption($option, $check = false, $profile = false, $id = '') {

		if (empty($option)) return false;

		$option = trim($option);

		if ( $profile ) {
			$params = array(
				':option' => $option,
				':id'     => $id
			);
			$sql = "SELECT `profile_value` FROM `login_profiles` WHERE `pfield_id` = :option AND `user_id` = :id LIMIT 1;";
		} else {
			$params = array( ':option' => $option );
			$sql = "SELECT `option_value` FROM `login_settings` WHERE `option_name` = :option LIMIT 1;";
		}

		$stmt = $this->query($sql, $params);

		if(!$stmt) return false;

		$result = $stmt->fetch(PDO::FETCH_NUM);
		$result = $result ? $result[0] : false;

		if($check)
			$result = !empty($result) ? 'checked="checked"' : '';

		return $result;

	}

	/**
	 * Updates an option in the database.
	 *
	 * If an option exists in the database, it will be updated. If it does not exist,
	 * the option will be created.
	 *
	 * @param     string    $option      Name of option to retrieve.
	 * @param     bool      $newvalue    Option's new value to set.
	 * @param     bool      $profile     Whether to update a profile field, or an admin setting.
	 * @param     int       $id          Required if profile is true; the user_id of a user.
	 * @return    bool      Whether the update was successful or not.
	 */
	public function updateOption($option, $newvalue, $profile = false, $id = '') {

		$option = trim($option);
		if ( empty($option) || !isset($newvalue) )
			return false;


		$oldvalue = $profile ? $this->getOption($option, false, true, $id)
							 : $this->getOption($option);

		if ( $newvalue === $oldvalue )
			return false;

		$params = array(
			':option' => $option,
			':newvalue' => is_array($newvalue) ? serialize($newvalue) : $newvalue
		);

		if ( false === $oldvalue ) :

			if ($profile) {
				$params[':id'] = $id;
				$sql = "INSERT INTO `login_profiles` (`user_id`, `pfield_id`, `profile_value`) VALUES (:id, :option, :newvalue);";
			} else $sql = "INSERT INTO `login_settings` (`option_name`, `option_value`) VALUES (:option, :newvalue)";

			return $this->query($sql, $params);
		endif;

		if ($profile) {
			$params[':id'] = $id;
			$sql = "UPDATE `login_profiles` SET `profile_value` = :newvalue WHERE `pfield_id` = :option AND `user_id` = :id";

		} else {
			$sql = "UPDATE `login_settings` SET `option_value` = :newvalue WHERE `option_name` = :option";
		}

		return $this->query($sql, $params);

	}

	/**
	 * Sanitizes titles intended for SQL queries.
	 *
	 * Specifically, HTML and PHP tag are stripped. The return value
	 * is not intended as a human-readable title.
	 *
	 * @param     string    $title    The string to be sanitized.
	 * @return    string    The sanitized title.
	 */
	public function sanitize_title($title) {

		$title = strtolower($title);
		$title = preg_replace('/&.+?;/', '', $title); // kill entities
		$title = str_replace('.', '-', $title);
		$title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
		$title = preg_replace('/\s+/', '-', $title);
		$title = preg_replace('|-+|', '-', $title);
		$title = trim($title, '-');

		return $title;

	}

	/**
	 * Sends HTML emails with optional shortcodes.
	 *
	 * @param     string    $to            Receiver of the mail.
	 * @param     string    $subj          Subject of the email.
	 * @param     string    $msg           Message to be sent.
	 * @param     array     $shortcodes    Shortcode values to replace.
	 * @param     bool      $bcc           Whether to send the email using Bcc: rather than To:
	 *                                     Useful when sending to multiple recepients.
	 * @return    bool      Whether the mail was sent or not.
	 */
	public function sendEmail($to, $subj, $msg, $shortcodes = '', $bcc = false) {

		if ( !empty($shortcodes) && is_array($shortcodes) ) :

			foreach ($shortcodes as $code => $value)
				$msg = str_replace('{{'.$code.'}}', $value, $msg);

		endif;

		/* Multiple recepients? */
		if ( is_array( $to ) )
			$to = implode(', ', $to);

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: ' . address . "\r\n";

		/* BCC address. */
		if ( $bcc ) {
			$headers .= 'Bcc: ' . $to . "\r\n";
			$to = null;
		}

		$headers .= 'Reply-To: ' . address . "\r\n";
		$headers .= 'Return-Path: ' . address . "\r\n";

		/*
		 * If running postfix, need a fifth parameter since Return-Path doesn't always work.
		 */
		// $optionalParams = '-r' . address;

		return mail($to, $subj, nl2br(html_entity_decode($msg)), $headers, $optionalParams);

	}

	/**
	 * Generate profile fields.
	 *
	 * Will populate the returned fields with data from the current user.
	 */
	public function generateProfile($section = '') {

		$params = array( ':section' => $section );
		$sql    = "SELECT * FROM `login_profile_fields` WHERE `section` = :section;";
		$stmt   = $this->query($sql, $params);

		$fields  = $this->getOption('profile-fields');
		$user_id = $this->getField('user_id');

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
			$option = array(
				'name' => $row['label'],
				'id' => $row['id'],
				'type' => $row['type'],
			);
			self::profileFieldTypes($option, false, $user_id);
		endwhile;

	}

	public function profileFieldTypes($option, $signup = false, $user_id = '') {

		extract($option);

		$p_id = 'p-' . $id;

		if ( empty($type) || empty($id) )
			return false;

		?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $p_id; ?>"><?php echo $name; ?></label>
			<div class="controls">
		<?php

		switch ($type) :
				case 'text_input' : ?>
					<input type="text"
						   class="input-xlarge <?php echo !empty($class) ? $class : ''; ?>"
						   id="<?php echo $p_id; ?>"
						   name="<?php echo $p_id; ?>"
						   value="<?php echo !empty($_POST[$p_id]) ? $_POST[$p_id] : ( $signup ? '' : $this->getOption($id, false, true, $user_id) ); ?>"
					>
				<?php break;
				case 'checkbox' : ?>
					<input type="checkbox"
						   class="input-xlarge <?php echo !empty($class) ? $class : ''; ?>"
						   id="<?php echo $p_id; ?>"
						   name="<?php echo $p_id; ?>"
						   <?php echo !empty($_POST[$p_id]) ? 'checked="checked"' : ( $signup ? '' : $this->getOption($id, true, true, $user_id) ); ?>
					>
				<?php break;
				case 'textarea' : ?>
					<textarea class="input-xlarge <?php echo !empty($class) ? $class : ''; ?>"
							  id="<?php echo $p_id; ?>"
							  name="<?php echo $p_id; ?>"
							  rows="5"><?php echo !empty($_POST[$p_id]) ? $_POST[$p_id] : ( $signup ? '' : $this->getOption($id, false, true, $user_id) ); ?></textarea>
				<?php break;
		endswitch;

		?>
			</div>
		</div>
		<?php

	}

	public function generateProfileTabs($edit = false) {

		$sql = "SELECT `section` FROM `login_profile_fields` GROUP BY `section`;";
		$stmt = $this->query($sql);
		$i = 0;

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
			?><li class="<?php if ( $i === 0 && $edit ) echo 'active'; ?>">
				<a href="#usr-<?php echo $this->sanitize_title($row['section']); ?>" data-toggle="tab">
					<i class="icon-user"></i> <?php echo $row['section']; ?></a>
			  </li><?php
			$i++;
		endwhile;

	}

	public function generateProfilePanels($edit = false) {

		$sql = "SELECT `section` FROM `login_profile_fields` GROUP BY `section`;";
		$stmt = $this->query($sql);

		$i = 0;

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :

			?><div class="tab-pane <?php if ( $i === 0 && $edit ) echo 'active'; else echo 'fade'; ?>" id="usr-<?php echo $this->sanitize_title($row['section']); ?>">
				<fieldset>
					<legend><?php echo $row['section']; ?></legend>
					<?php $this->generateProfile($row['section']); ?>
				</fieldset>
			</div><?php
			$i++;
		endwhile;

	}

	/**
	 * Checks if a user has access to view their own access log
	 *
	 * @return    bool    Whether the user can view access logs or not
	 */
	public function denyAccessLogs() {

		return ( ($this->getOption('profile-timestamps-admin-enable') && !in_array(1, $_SESSION['jigowatt']['user_level'])) || !$this->getOption('profile-timestamps-enable') );

	}

	/** Generates the access logs for a particular user in table format */
	public function generateAccessLogs() {

		$user_id = $this->getField('user_id');

		$params = array( ':user_id' => $user_id );
		$sql = "SELECT `ip`, `timestamp` FROM `login_timestamps` WHERE `user_id` = :user_id ORDER BY `timestamp` DESC LIMIT 0,10";
		$stmt = $this->query($sql, $params);

	?>
	<table class="table table-condensed span6">
		<thead>
			<tr>
				<th><?php _e('Last Login'); ?></th>
				<th><?php _e('Location'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php if($stmt->rowCount() > 0) : ?>
		<?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
			<tr>
				<td><?php echo date('M d, Y', strtotime($row['timestamp'])) . ' ' . _('at') . ' ' . date('h:i a', strtotime($row['timestamp'])); ?></td>
				<td><?php echo $row['ip']; ?></td>
			</tr>
		<?php endwhile; ?>
		<?php else : ?>
		<tr>
			<td><?php _e('Has not logged in yet'); ?></td>
		</tr>
		<?php endif; ?>
		</tbody>
	</table>
	<?php

	}

	/**
	 * Only allows guests to view page.
	 *
	 * A logged in user will be shown an error and denied from viewing the page.
	 */
	public function guestOnly() {

		if(!empty($_SESSION['jigowatt']['username'])) {
			$this->error =	"
							<div class='alert alert-error'>"._('You\'re already logged in.')."</div>
							<h5>"._('What to do now?')."</h5>
							<p>" . sprintf(_('Go <a href="%s">back</a> to the page you were viewing before this.'), 'javascript:history.go(-1)') . "</p>
							";
		}

		$this->displayMessage($this->error);

	}

	/**
	 * Generates a unique token.
	 *
	 * Intended for form validation to prevent exploit attempts.
	 */
	public function generateToken() {

		if(empty($_SESSION['jigowatt']['token']))
			$_SESSION['jigowatt']['token'] = md5(uniqid(mt_rand(),true));

	}

	/**
	 * Prevents invalid form submission attempts.
	 *
	 * @param     string    $token    The POST token with a form.
	 * @return    bool      Whether the token is valid.
	 */
	public function valid_token($token) {

		if (empty($_SESSION['jigowatt']['token']))
			return false;

		if ($_SESSION['jigowatt']['token'] != $token)
			return false;

		return true;

	}

	/**
	 * Secures any string intended for SQL execution.
	 *
	 * @param     string    $string
	 * @return    string    The secured value string.
	 */
	public function secure($string) {

		// Because some servers still use magic quotes
		if ( get_magic_quotes_gpc() ) :

			if ( ! is_array($string) ) :
				$string = htmlspecialchars(stripslashes(trim($string)));
			else :
				foreach ($string as $key => $value) :
					$string[$key] = htmlspecialchars(stripslashes(trim($value)));
				endforeach;
			endif;

			return $string;

		endif;


		if ( ! is_array($string) ) :
			$string = htmlspecialchars(trim($string));
		else :
			foreach ($string as $key => $value) :
				$string[$key] = htmlspecialchars(trim($value));
			endforeach;
		endif;

		return $string;

	}

	/**
	 * Validates an email address.
	 *
	 * @param     string    $email    The email address.
	 * @return    bool      Whether the email address is valid or not.
	 */
	public function isEmail($email) {

		if ( !empty($email) )
			$email = (string) $email;
		else
			return false;

		return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
	}

	/**
	 * Defines variables used throughout the script.
	 *
	 * Definitions:
	 * cINC                   The current directory, whether /admin/ or root.
	 * address                Administrator's email address.
	 * SITE_PATH              Should be set with a trailing slash, where activate.php is located.
	 * phplogin_db_version    The current script's database version.
	 *                        Used for keeping track of necessary db updates.
	 *                        Follows format - Year : Month : Day : Revision.
	 * phplogin_version       Core version of the script.
	 */
	public function definePaths() {

		if (!defined('cINC'))                   define( 'cINC',                dirname($_SERVER['SCRIPT_FILENAME']) . '/' );
		if (!defined('address'))                define( 'address',             $this->getOption('admin_email') );
		if (!defined('SITE_PATH'))              define( 'SITE_PATH',           $this->getOption('site_address') );
		if (!defined('phplogin_db_version'))    define( 'phplogin_db_version', 1206210);
		if (!defined('phplogin_version'))       define( 'phplogin_version',    3.02);

	}

	/**
	 * Hashes a password for either MD5 or SHA256.
	 *
	 * If hashing SHA256, a unique salt will be hashed with it.
	 *
	 * @param     string    $password    A plain-text password.
	 * @return    string    Hashed password.
	 */
	public function hashPassword($password) {

		$type = $this->getOption('pw-encryption');

		// Checks if the pw should be MD5, if so, don't continue
		if($type == 'MD5') return md5($password);

		$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
		$hash = hash($type, $salt . $password);
		$final = $salt . $hash;

		return $final;

	}

	/**
	 * Validates a password.
	 *
	 * A plain-text password is compared against the hashed version.
	 *
	 * @param     string    $password       A plain-text password.
	 * @param     string    $correctHash    The hashed version of a correct password.
	 * @return    bool      Whether or not the plain-text matches the correct hash.
	 */
	public function validatePassword($password, $correctHash) {

		$type = $this->getOption('pw-encryption');

		$password = (string) $password;

		// Checks if the password is MD5 and return
		if(strlen($correctHash) == 32)
			return md5($password) === $correctHash;
		else $type = 'SHA256';

		// Continue testing the hash against the salt
		$salt = substr($correctHash, 0, 64);
		$validHash = substr($correctHash, 64, 64);

		$testHash = hash($type, $salt . $password);

		return $testHash === $validHash;

	}

	/**
	 * Displays an error and optionally quits the script.
	 *
	 * @param     string    $error    The error message to display.
	 * @param     bool      $exit     Whether to exit after the error and prevent the
	 *                                page from loading any further.
	 */
	public function displayMessage($error, $exit = true) {

		if( !empty($error) ) :

			// Current headers
			include_once(cINC . 'header.php');

			// The error itself
			echo $error;

			// Shall we exit or not?
			if( $exit ) {
				include_once(cINC . 'footer.php');
				exit();
			}

		endif;

	}

	/**
	 * Ajax validation.
	 *
	 * Used on forms that check for duplicate email, username, or level.
	 */
	public function checkExists() {

		if(!empty($_POST['email']) && !empty($_POST['checkemail'])) {
			$params = array( ':email' => $_POST['email'] );
			$sql = "SELECT `email` FROM `login_users` WHERE `email` = :email";
		}

		else if(!empty($_POST['username']) && !empty($_POST['checkusername'])) {
			$params = array( ':username' => $_POST['username'] );
			$sql = "SELECT `username` FROM `login_users` WHERE `username` = :username";
		}

		else if(!empty($_POST['auth']) && !empty($_POST['checklevel'])) {
			$params = array( ':auth' => $_POST['auth'] );
			$sql = "SELECT `level_level` FROM `login_levels` WHERE `level_level` = :auth";
		}

		else return false;

		$stmt = $this->query($sql, $params);
		echo ( $stmt->rowCount() > 0 ) ? "false" : "true";
		exit();

	}

	/**
	 * Finds the current IP address of a visiting user.
	 *
	 * @return    string    The IP address
	 */
	public function getIPAddress() {

		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) :
			$ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
		else :
			$ipAddress = isset($_SERVER["HTTP_CLIENT_IP"]) ? $_SERVER["HTTP_CLIENT_IP"] : $_SERVER["REMOTE_ADDR"];
		endif;

		return $ipAddress;
	}

	/**
	 * Get either a Gravatar URL or complete image tag for a specified email address.
	 *
	 * @param string $email The email address
	 * @param string $s Size in pixels, defaults to 80px [ 1 - 512 ]
	 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
	 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
	 * @param boole $img True to return a complete IMG tag False for just the URL
	 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
	 * @return String containing either just a URL or a complete image tag
	 * @source http://gravatar.com/site/implement/images/php/
	 */
	public function get_gravatar( $email, $img = false, $s = 80, $d = 'mm', $r = 'g', $atts = array() ) {
		$url = 'http://www.gravatar.com/avatar/';
		$url .= md5( strtolower( trim( $email ) ) );
		$url .= "?s=$s&d=$d&r=$r";
		if ( $img ) {
			$url = '<img class="gravatar thumbnail" src="' . $url . '"';
			foreach ( $atts as $key => $val )
				$url .= ' ' . $key . '="' . $val . '"';
			$url .= ' />';
		}
		return $url;
	}


}

$generic = new Generic();