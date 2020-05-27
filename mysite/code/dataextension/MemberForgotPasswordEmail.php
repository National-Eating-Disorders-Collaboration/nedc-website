<?php

class MemberForgotPasswordEmail extends Member_ForgotPasswordEmail {
    public function __construct() {
        parent::__construct();
        $this->from = 'no-reply@nedc.com.au';
        $this->subject = "Reset link for your NEDC password";
    }
}