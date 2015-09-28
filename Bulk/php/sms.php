<?php
// Configuration parameters
$url        = 'https://bulk.sms-online.com/';
$user       = 'hitfm';
$from       = 'HitFM';
$secret_key = 'test_key';
$phone      = '79031234567';
$txt        = 'Съешь еще этих французских булок';

// Calculate MD5 hash and escape text
$sign = md5( $user . $from . $phone . $txt . $secret_key );
$rtxt = rawurlencode( $txt );

// Prepare full url and call bulk script
$request = "$url?user=$user&from=$from&phone=$phone&txt=$rtxt&sign=$sign";
$response = file_get_contents( $request );
echo "$response";
?>