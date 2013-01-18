<?php

/**
 * Log the user out and optionally redirect to a page afterwards.
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

include_once('classes/generic.class.php');

/** Check if the browser set a referrer. */
$redirect = getenv('HTTP_REFERER') ? getenv('HTTP_REFERER') : 'home.php';

/** See if the admin wants to redirect to a specific page or not. */
$redirect = $generic->getOption('signout-redirect-referrer-enable')
			? $redirect
			: $generic->getOption('signout-redirect-url');

/**
 * Begin removing their existence.
 *
 * Good bye friend :(. Promise you'll come back?!
 */
if (isset($_SESSION['jigowatt']['username'])) :
	session_unset();
	session_destroy();
endif;

/** Voila! Here we shall gently nudge them somewhere else. */
header('Location: ' . $redirect);
exit();