<?php

function is_captcha_set()
{
	global $global;
	return $global['core']['config']['recaptcha_pub'] != '' && $global['core']['config']['recaptcha_pri'] != '';
}

function display_captcha()
{
	if (!is_captcha_set()) return;
	global $global;
	require_once('recaptchalib.php');
	$publickey = $global['core']['config']['recaptcha_pub'];
	echo recaptcha_get_html($publickey);
}

function validate_captcha()
{
	if (!is_captcha_set()) return;
	global $global;
	require_once('recaptchalib.php');
	$privatekey = $global['core']['config']['recaptcha_pri'];
	$resp = recaptcha_check_answer ($privatekey,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);

	if (!$resp->is_valid) {
		return "The reCAPTCHA wasn't entered correctly. Go back and try it again." .
		   "(reCAPTCHA said: " . $resp->error . ")";
	}
	return TRUE;
}