<?php
//echo SendMessage('0871348970', 'line1%0Aบันทัด2%0Aบันทัด3%0Aบันทัด4');
//if ( ! defined( 'ABSPATH' ) ) die( 'Error!' );
/**$pos = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
if($pos===false){

    die('Restricted access');

}**/
function SendMessage_daifaan($number, $message)
{
$host= '119.160.210.164';
$port= '9710';
$userName= 'admin';
$password= 's4722team24164';
    /* Create a TCP/IP socket. */
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket === false) {
        return "socket_create() failed: reason: " . socket_strerror(socket_last_error());
    }
    /* Make a connection to the Diafaan SMS Server host */
    $result = socket_connect($socket, $host, $port);
    if ($result === false) {
        return "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket));
    }
    /* Create the HTTP API query string */
    $query = '/http/send-message/';
    $query .= '?username='.urlencode($userName);
    $query .= '&password='.urlencode($password);
    $query .= '&to='.urlencode($number);
	$query .= '&message-type=sms.unicode';
    $query .= '&message='.$message;
    /* Send the HTTP GET request */
    $in = "GET ".$query." HTTP/1.1\r\n";
    $in .= "Host: 127.0.0.1\r\n";
    $in .= "Connection: Close\r\n\r\n";
    $out = '';
    socket_write($socket, $in, strlen($in));
    /* Get the HTTP response */
    $out = '';
    while ($buffer = socket_read($socket, 2048)) {
        $out = $out.$buffer;
    }
    socket_close($socket);
    /* Extract the last line of the HTTP response to filter out the HTTP header and get the send result*/
    $lines = explode("\n", $out);
    return end($lines);
}
?>
