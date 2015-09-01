#!/usr/bin/perl -w
use strict;
use utf8;
use Encode;
use CGI;
use LWP;
use HTTP::Request;
use Digest::MD5 qw(md5_hex );
 
# Configuration parameters
my $url        = 'https://bulk.sms-online.com/';
my $user       = 'hitfm';
my $from       = 'HitFM';
my $secret_key = 'test_key';
my $phone      = '79031234567';
my $txt        = encode( 'utf8', 'Съешь еще этих французских булок' );
 
# Calculate MD5 hash and escape text
my $sign = md5_hex( $user . $from . $phone . $txt . $secret_key );
my $rtxt = CGI::escape( $txt );
 
# Prepare full url
my $req_url = "$url?user=$user&from=$from&phone=$phone&txt=$rtxt&sign=$sign";
 
# Call bulk script
my $request = HTTP::Request->new( GET => $req_url );
my $ua = LWP::UserAgent->new( timeout => 60 );
my $response = $ua->request( $request );
 
if ( !$response->is_success ) {
  print "FAILED: " . $response->status_line . $/;
}
else {
  print "OK:$/" . $response->content;
}