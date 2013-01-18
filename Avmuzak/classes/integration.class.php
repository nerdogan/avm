<?php

/**
 * Integrate a profile with various social networks.
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

include_once( 'generic.class.php' );

class Jigowatt_integration extends Generic {

	public $enabledMethods;
	public static $socialLogin = array(
		'twitter',
		'facebook',
		'google',
		'yahoo'
	);

	private $result;
	private $num;

	function __construct() {

		$this->enabledMethods = $this->findEnabledMethods();

		/**
		 * Twitter.
		 */
		if (in_array('twitter', $this->enabledMethods)) {
			require 'integration/twitter/EpiCurl.php';
			require 'integration/twitter/EpiOAuth.php';
			require 'integration/twitter/EpiTwitter.php';
		}


		/**
		 * Facebook.
		 */
		if (in_array('facebook', $this->enabledMethods)) {
			require 'integration/facebook/facebook.php';
		}


		/**
		 * OpenID Networks (Google, Yahoo).
		 */
		if (in_array('google', $this->enabledMethods) || in_array('yahoo', $this->enabledMethods)) {
			include_once( 'integration/openid/openid.php' );
		}

		/** If the user is logged out, we'll treat them as a guest. */
		if (empty($_SESSION['jigowatt']['user_id'])) {
			//$this->guestLogin();
			return false;
		}

		$this->retrieveInfo();

		/** User wants to unlink his account from a social method. */
		if ( !empty($_GET['unlink']) ) {
			$this->unlink($_GET['unlink']);
			$this->retrieveInfo();
		}

		if ( !empty($_GET['link']) ) {
			$this->link_account($_GET['link']);
			$this->retrieveInfo();
		}

	}

	/** Check if this method is already in linked or not. */
	public function isUsed($method) {

		return !empty($this->result[$method]);

	}

	private function retrieveInfo() {

		$params = array( ':user_id' => $_SESSION['jigowatt']['user_id'] );
		$sql = "SELECT * FROM `login_integration` WHERE `user_id` = :user_id;";
		$stmt = parent::query($sql, $params);

		$this->num = $stmt->rowCount();
		$this->result = $stmt->fetch(PDO::FETCH_ASSOC);

	}

	private function findEnabledMethods() {

		$methods = array();

		foreach ( self::$socialLogin as $method )
			if ( parent::getOption('integration-'.$method.'-enable') )
				$methods[] = $method;

		return $methods;

	}

	public function link_account($link, $login = false) {

		/** Make sure we only allow specific social links. */
		if ( !in_array($link, self::$socialLogin) )
			return false;

		/** Check if user is already linked. */
		if ( !empty($this->result[$link]) ) {
			parent::displayMessage(sprintf('<div class="alert alert-warning">' . _('Your account is already linked with %s!') . '</div>', ucwords($link)), false);
			return false;
		}

		/** See if the link was successful. */
		if ( !empty($_SESSION['jigowatt'][$link]) ) {
			if (!$login) $this->connect($link);
			return false;
		}

		switch ($link) :

			case 'facebook' :
					header( 'Location: ' . $this->facebook_url() );
					exit();
				break;

			case 'twitter' :
					header( 'Location: ' . $this->twitter_url() );
					exit();
				break;

			default :
					$this->openid_url($link);
				break;

		endswitch;

	}

	private function connect($link) {

		if ( empty($_SESSION['jigowatt']['user_id']) )
			return false;

		$params = array(
			':user_id'      => $_SESSION['jigowatt']['user_id'],
			':session_link' => $_SESSION['jigowatt'][$link]
		);

		if ($this->num < 1)
			$sql = "INSERT INTO `login_integration` (`user_id`, `$link`) VALUES (:user_id, :session_link);";
		else
			$sql = "UPDATE `login_integration` SET `$link` = :session_link WHERE `user_id` = :user_id;";

		parent::query($sql, $params);
		parent::displayMessage(sprintf('<div class="alert alert-success">%s</div>', _('Successfully linked with ' . ucwords($link))), false);

	}

	private function unlink($provider) {

		if ( !in_array($provider, self::$socialLogin) )
			return false;

		if ( empty($this->result[$provider]) ) {
			parent::displayMessage(sprintf('<div class="alert alert-warning">' . _('You are not yet linked with %s') . '</div>', ucwords($provider)), false);
			return false;
		}

		$params = array( ':user_id'  => $_SESSION['jigowatt']['user_id'] );
		$sql = "UPDATE `login_integration` SET $provider = null WHERE `user_id` = :user_id;";
		parent::query($sql, $params);

		unset($_SESSION['jigowatt'][$provider]);

		parent::displayMessage(sprintf('<div class="alert alert-success">' . _('Successfully unlinked from %s') . '</div>', ucwords($provider)), false);

	}

	private function openid_url($link) {

		$providers = array(
			'google' => 'https://www.google.com/accounts/o8/id',
			'yahoo'  => 'http://me.yahoo.com/',
			'aol'    => 'http://openid.aol.com/{username}',
			'openid' => ''
		);

		if ( !empty($_GET['link']) || !empty($_GET['login']) )
			$link = !empty($_GET['link']) ? $_GET['link'] : $_GET['login'];

		try {
			$openid = new LightOpenID(str_replace("www.","", $_SERVER['HTTP_HOST']));
			if(!$openid->mode) {
				if(!empty($link)) {

					$openid->identity = $providers[$link];

					$openid->returnUrl = str_replace("www.","", SITE_PATH) . basename($_SERVER['PHP_SELF']) . '?link=' . $link;
					$openid->required = array('contact/email', 'namePerson/first', 'namePerson/last');
					header('Location: ' . $openid->authUrl());
					exit();
				}

			} elseif($openid->mode == 'cancel') {
				echo 'User has canceled authentication!';
			} else {

				if ($openid->validate()) :

					if( !empty($providers[$link]) ) :

						$_SESSION['jigowatt'][$link] = $openid->identity;
						$this->connect($link);
						$_SESSION['jigowatt']['openIDMisc'] = $openid->getAttributes();
						$_SESSION['jigowatt']['openIDMisc']['type'] = $link;
						$_SESSION['jigowatt']['openIDMisc'][$link] = $openid->identity;

					endif;

				endif;

			}
		} catch(ErrorException $e) {
			echo $e->getMessage();
		}

	}

	public function facebook_url() {

		if( !empty($_SESSION['jigowatt']['facebook']) )
			return false;

		$facebook = new Facebook(array(
		  'appId'  => parent::getOption('facebook-app-id'),
		  'secret' => parent::getOption('facebook-app-secret'),
		));

		$this->fbUser = $facebook->getUser();

		if ($this->fbUser) :
			$user_profile = $facebook->api('/me');
		  try {
			$_SESSION['jigowatt']['facebookMisc'] = $user_profile;
			$_SESSION['jigowatt']['facebook'] = $this->fbUser;
		  } catch (FacebookApiException $e) {
			error_log($e);
			$this->fbUser = null;
		  }

		endif;

		$params = array(
		  'redirect_uri' => str_replace("www.","", SITE_PATH) . basename($_SERVER['PHP_SELF']) . '?link=facebook',
		  'scope' => 'email'
		);

		return $this->fbUser ? '#' : $facebook->getLoginUrl($params);

	}

	public function twitter_url() {

		if ( !empty($_SESSION['jigowatt']['twitter']) )
			return false;

		$consumer_key    = parent::getOption('twitter-key');
		$consumer_secret = parent::getOption('twitter-secret');

		$this->twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

		if( !empty($_GET['oauth_token']) ) {

			$this->twitterObj->setToken($_GET['oauth_token']);
			$token = $this->twitterObj->getAccessToken();
			$this->twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);
			$twitterInfo = $this->twitterObj->get_accountVerify_credentials();
			$twitterInfo = $twitterInfo->response;

			$_SESSION['jigowatt']['twitter'] = $twitterInfo['id'];
			$_SESSION['jigowatt']['twitterMisc']['username'] = $twitterInfo['screen_name'];
			$_SESSION['jigowatt']['twitterMisc']['id'] = $twitterInfo['id'];
			$_SESSION['jigowatt']['twitterMisc']['name'] = $twitterInfo['name'];

		}

		return !empty($_SESSION['jigowatt']['twitter']) ? '#' : $this->twitterObj->getAuthenticateUrl( null,array('oauth_callback' => str_replace("www.","", SITE_PATH) . basename($_SERVER['PHP_SELF']) . '?link=twitter' ));

	}


}

$jigowatt_integration = new Jigowatt_integration();