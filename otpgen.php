
<?php
    
global $_SESSION, $USERS; 

function getOTP($rnum)
{

$dig1 = rand(1,9);
$dig2 = rand(1,9);
$dig3 = rand(1,9);
$dig4 = rand(1,9);

$OTPgen = $dig1 . $dig2 . $dig3 . $dig4 ;


$message = "Hello OMitra User, Your OTP generated  is - " . $OTPgen . ".";
$out = exec("python sms.py 91$rnum '$message'");

$_SESSION['otpgen'] = 1 ;
$_SESSION['otpgenerated'] = $OTPgen;

return $out;

}

?>