<?php

/**
 * Checks server for required PHP extensions.
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

/**
 * Controls showing the PHP Gettext warning message on every page.
 *
 * Set this to false to hide the warning.
 * Eg: $getTextError = false;
 */
$getTextError = true;

try {

	/** Gettext. */
	if ($getTextError)
		if ( !function_exists('gettext') )
			throw new Exception('
				<h4 class="alert-warning">Warning, PHP Gettext not enabled</h4>
				PHP Gettext is not required. If you would like to disable this message, open <code>prereqs.php</code> and set getTextError to false.');

	/** CURL. */
	if ( !function_exists('curl_init') )
		throw new Exception('This script requires the CURL PHP extension.');

	/** JSON. */
	if ( !function_exists('json_decode') )
		throw new Exception('This script requires the JSON PHP extension.');


} catch (Exception $e) {

	$error = sprintf("<div class='alert alert-warning'>%s</div>", $e->getMessage());

}