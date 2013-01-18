<?php

/**
 * Set a sitewide language (optional).
 *
 * Note: You must set both variables, $lang.
 *
 * Want to update or create translation files? There's a guide here:
 * http://jigowatt.co.uk/themeforest/login/install.php#/install-languages
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

class Translate {

	function __construct() {

		if (!isset($_SESSION)) session_start();

		/**
		 * Specify the language locale.
		 *
		 * Full list of locales ("abbreviations") can be found here:
		 * http://www.roseindia.net/tutorials/I18N/locales-list.shtml
		 */
		$this->lang = "tr_TR";

		/* The directory to the languages folder. Do not touch. */
		$this->langDirectory = dirname(dirname(__FILE__)) . '/languages';

		include( 'prereqs.php' );

		$this->setLang();

	}

	/**
	 * Sets the specified language across the script.
	 *
	 * Specifies the language folder to be /languages/en_US/ by default.
	 */
	private function setLang() {

		if ( !function_exists('gettext') )
			return false;

		if ( !empty($_GET['lang']) ) :

			$lang = $_GET['lang'];
			if ( $this->displayName($lang) ) :
				$this->lang = $lang;
				$_SESSION['jigowatt']['language'] = $lang;
			endif;

		endif;

		$this->lang = !empty($_SESSION['jigowatt']['language']) ? $_SESSION['jigowatt']['language'] : $this->lang;

		putenv('LC_ALL=' . $this->lang . '.UTF8');
		setlocale(LC_ALL,  $this->lang . '.utf8',
                           $this->lang . '.UTF8',
                           $this->lang . '.utf-8',
                           $this->lang . '.UTF-8',
                           $this->lang);

		bindtextdomain('phplogin', $this->langDirectory );
		textdomain('phplogin');

	}

	public function languageSelector() {

		$options = array();

		foreach(glob($this->langDirectory . '/*', GLOB_ONLYDIR) as $folder) :

			$folder = pathinfo($folder);
			$code = $folder['basename'];
			$displayName = $this->displayName($code);

			if ( $displayName )
				$options[$code] = $displayName;

		endforeach;

		/* Sort languages by display name. */
		asort($options);

		echo '<select name="languageSelect" id="languageSelect" class="languageSelect" ONCHANGE="location=\'?lang=\'+this.options[this.selectedIndex].value;">';

		foreach ( $options as $code => $language ) {

			$selected = ( !empty($_SESSION['jigowatt']['language']) && $_SESSION['jigowatt']['language'] == $code ) ? 'selected="selected"' : '';
			echo "<option name={$code} id={$code} class={$code} value={$code} {$selected}>{$language}</option>";

		}

		echo '</select>';

	}

	/* Return the pretty name of a language. */
	private function displayName($lang) {

		$languages = array(
			'sq_AL'   =>  'Albanian (Albania)',
			'sq'      =>  'Albanian',
			'ar_DZ'   =>  'Arabic (Algeria)',
			'ar_BH'   =>  'Arabic (Bahrain)',
			'ar_EG'   =>  'Arabic (Egypt)',
			'ar_IQ'   =>  'Arabic (Iraq)',
			'ar_JO'   =>  'Arabic (Jordan)',
			'ar_KW'   =>  'Arabic (Kuwait)',
			'ar_LB'   =>  'Arabic (Lebanon)',
			'ar_LY'   =>  'Arabic (Libya)',
			'ar_MA'   =>  'Arabic (Morocco)',
			'ar_OM'   =>  'Arabic (Oman)',
			'ar_QA'   =>  'Arabic (Qatar)',
			'ar_SA'   =>  'Arabic (Saudi Arabia)',
			'ar_SD'   =>  'Arabic (Sudan)',
			'ar_SY'   =>  'Arabic (Syria)',
			'ar_TN'   =>  'Arabic (Tunisia)',
			'ar_AE'   =>  'Arabic (United Arab Emirates)',
			'ar_YE'   =>  'Arabic (Yemen)',
			'ar'      =>  'Arabic',
			'be_BY'   =>  'Belarusian (Belarus)',
			'be'      =>  'Belarusian',
			'bg_BG'   =>  'Bulgarian (Bulgaria)',
			'bg'      =>  'Bulgarian',
			'ca_ES'   =>  'Catalan (Spain)',
			'ca'      =>  'Catalan',
			'zh_CN'   =>  'Chinese (China)',
			'zh_HK'   =>  'Chinese (Hong Kong)',
			'zh_SG'   =>  'Chinese (Singapore)',
			'zh_TW'   =>  'Chinese (Taiwan)',
			'zh'      =>  'Chinese',
			'hr_HR'   =>  'Croatian (Croatia)',
			'hr'      =>  'Croatian',
			'cs_CZ'   =>  'Czech (Czech Republic)',
			'cs'      =>  'Czech',
			'da_DK'   =>  'Danish (Denmark)',
			'da'      =>  'Danish',
			'nl_BE'   =>  'Dutch (Belgium)',
			'nl_NL'   =>  'Dutch (Netherlands)',
			'nl'      =>  'Dutch',
			'en_AU'   =>  'English (Australia)',
			'en_CA'   =>  'English (Canada)',
			'en_IN'   =>  'English (India)',
			'en_IE'   =>  'English (Ireland)',
			'en_MT'   =>  'English (Malta)',
			'en_NZ'   =>  'English (New Zealand)',
			'en_PH'   =>  'English (Philippines)',
			'en_SG'   =>  'English (Singapore)',
			'en_ZA'   =>  'English (South Africa)',
			'en_GB'   =>  'English (United Kingdom)',
			'en_US'   =>  'English (United States)',
			'en'      =>  'English',
			'et_EE'   =>  'Estonian (Estonia)',
			'et'      =>  'Estonian',
			'fi_FI'   =>  'Finnish (Finland)',
			'fi'      =>  'Finnish',
			'fr_BE'   =>  'French (Belgium)',
			'fr_CA'   =>  'French (Canada)',
			'fr_FR'   =>  'French (France)',
			'fr_LU'   =>  'French (Luxembourg)',
			'fr_CH'   =>  'French (Switzerland)',
			'fr'      =>  'French',
			'de_AT'   =>  'German (Austria)',
			'de_DE'   =>  'German (Germany)',
			'de_LU'   =>  'German (Luxembourg)',
			'de_CH'   =>  'German (Switzerland)',
			'de'      =>  'German',
			'el_CY'   =>  'Greek (Cyprus)',
			'el_GR'   =>  'Greek (Greece)',
			'el'      =>  'Greek',
			'iw_IL'   =>  'Hebrew (Israel)',
			'iw'      =>  'Hebrew',
			'hi_IN'   =>  'Hindi (India)',
			'hu_HU'   =>  'Hungarian (Hungary)',
			'hu'      =>  'Hungarian',
			'is_IS'   =>  'Icelandic (Iceland)',
			'is'      =>  'Icelandic',
			'in_ID'   =>  'Indonesian (Indonesia)',
			'in'      =>  'Indonesian',
			'ga_IE'   =>  'Irish (Ireland)',
			'ga'      =>  'Irish',
			'it_IT'   =>  'Italian (Italy)',
			'it_CH'   =>  'Italian (Switzerland)',
			'it'      =>  'Italian',
			'ja_JP'   =>  'Japanese (Japan)',
			'ja_JP_JP'=>  'Japanese (Japan,JP)',
			'ja'      =>  'Japanese',
			'ko_KR'   =>  'Korean (South Korea)',
			'ko'      =>  'Korean',
			'lv_LV'   =>  'Latvian (Latvia)',
			'lv'      =>  'Latvian',
			'lt_LT'   =>  'Lithuanian (Lithuania)',
			'lt'      =>  'Lithuanian',
			'mk_MK'   =>  'Macedonian (Macedonia)',
			'mk'      =>  'Macedonian',
			'ms_MY'   =>  'Malay (Malaysia)',
			'ms'      =>  'Malay',
			'mt_MT'   =>  'Maltese (Malta)',
			'mt'      =>  'Maltese',
			'no_NO'   =>  'Norwegian (Norway)',
			'no_NO_NY'=>  'Norwegian (Norway,Nynorsk)',
			'no'      =>  'Norwegian',
			'pl_PL'   =>  'Polish (Poland)',
			'pl'      =>  'Polish',
			'pt_BR'   =>  'Portuguese (Brazil)',
			'pt_PT'   =>  'Portuguese (Portugal)',
			'pt'      =>  'Portuguese',
			'ro_RO'   =>  'Romanian (Romania)',
			'ro'      =>  'Romanian',
			'ru_RU'   =>  'Russian (Russia)',
			'ru'      =>  'Russian',
			'sr_BA'   =>  'Serbian (Bosnia and Herzegovina)',
			'sr_ME'   =>  'Serbian (Montenegro)',
			'sr_CS'   =>  'Serbian (Serbia and Montenegro)',
			'sr_RS'   =>  'Serbian (Serbia)',
			'sr'      =>  'Serbian',
			'sk_SK'   =>  'Slovak (Slovakia)',
			'sk'      =>  'Slovak',
			'sl_SI'   =>  'Slovenian (Slovenia)',
			'sl'      =>  'Slovenian',
			'es_AR'   =>  'Spanish (Argentina)',
			'es_BO'   =>  'Spanish (Bolivia)',
			'es_CL'   =>  'Spanish (Chile)',
			'es_CO'   =>  'Spanish (Colombia)',
			'es_CR'   =>  'Spanish (Costa Rica)',
			'es_DO'   =>  'Spanish (Dominican Republic)',
			'es_EC'   =>  'Spanish (Ecuador)',
			'es_SV'   =>  'Spanish (El Salvador)',
			'es_GT'   =>  'Spanish (Guatemala)',
			'es_HN'   =>  'Spanish (Honduras)',
			'es_MX'   =>  'Spanish (Mexico)',
			'es_NI'   =>  'Spanish (Nicaragua)',
			'es_PA'   =>  'Spanish (Panama)',
			'es_PY'   =>  'Spanish (Paraguay)',
			'es_PE'   =>  'Spanish (Peru)',
			'es_PR'   =>  'Spanish (Puerto Rico)',
			'es_ES'   =>  'Spanish (Spain)',
			'es_US'   =>  'Spanish (United States)',
			'es_UY'   =>  'Spanish (Uruguay)',
			'es_VE'   =>  'Spanish (Venezuela)',
			'es'      =>  'Spanish',
			'sv_SE'   =>  'Swedish (Sweden)',
			'sv'      =>  'Swedish',
			'th_TH'   =>  'Thai (Thailand)',
			'th_TH_TH'=>  'Thai (Thailand,TH)',
			'th'      =>  'Thai',
			'tr_TR'   =>  'Turkish (Turkey)',
			'tr'      =>  'Turkish',
			'uk_UA'   =>  'Ukrainian (Ukraine)',
			'uk'      =>  'Ukrainian',
			'vi_VN'   =>  'Vietnamese (Vietnam)',
			'vi'      =>  'Vietnamese',
		);

		if ( !empty($languages[$lang]) )
			return $languages[$lang];

		return false;

	}

}


/** If PHP Gettext isn't enabled, we'll still want to display content. */
if ( !function_exists("_") ) {
	function _($text) {
		return $text;
	}
}

/** Used to echo a Gettext string. */
if ( !function_exists("_e") ) {
	function _e( $text ) {
		echo _( $text );
	}
}

$setTranslate = new Translate();