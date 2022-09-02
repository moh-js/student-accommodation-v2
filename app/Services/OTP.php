<?php
namespace App\Services;

use OTPHP\TOTP;

class OTP
{
    protected $student;

    public function sendOTP($student)
    {
        $secret = $this->getStudentSecret($student);

        // we generate otp with that secret
        $code = $this->generateOTP($secret);

        // constuct a message
        $message =  "Your verification code is $code";

        // TODO
        // fire event to send this message to student as sms or email

        return $code;
    }

    protected function getStudentSecret($student)
    {
        // if student has a secret
        if($student->secret) {
            return $student->secret;
        }

        // student doesn't we create one for the student
        $otp = TOTP::create(null, 60);
        $secret = $otp->getSecret();

        $student->update(['secret'=> $secret]);

        return $secret;
    }

    public function generateOTP($secret)
    {
        $timestamp = time();

        $otp = TOTP::create($secret, 60);

        $code = $otp->at($timestamp);

        return $code;
    }

    public function verifyOTP($student, $code)
    {
        $secret = $this->getStudentSecret($student);

       $timestamp = time();

       $otp = TOTP::create($secret, 60);

       return $otp->verify($code, $timestamp);

    }


}
