<?php

class Captcha {
    public final static function display()
    {
        if (LPRMS::recaptcha_pub() == '' || LPRMS::recaptcha_pri() == '') return;
        return recaptcha_get_html(LPRMS::recaptcha_pub());
    }

    public final static function validate($challenge, $response)
    {
        if (LPRMS::recaptcha_pub() == '' || LPRMS::recaptcha_pri() == '') return 'No recaptcha variables set';
        $resp = recaptcha_check_answer (LPRMS::recaptcha_pri(), $_SERVER["REMOTE_ADDR"], $challenge, $response);

	if (!$resp->is_valid) {
		return "The reCAPTCHA wasn't entered correctly. Go back and try it again." .
		   "(reCAPTCHA said: " . $resp->error . ")";
	}
	return TRUE;
    }
}

?>