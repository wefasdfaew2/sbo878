<?php

header('Content-Type: text/html; charset=utf-8');

if (isset($_GET['id']) && isset($_GET['server']) && isset($_GET['bitrate']) && isset($_GET['mode'])) {
    $id = $_GET['id']; //channel_id
    $server = $_GET['server'];
    $bitrate = $_GET['bitrate'];
    $mode = $_GET['mode'];

    $url = 'http://sbogroup.t-wifi.co.th/wordpress/index.php/sample-page?id=5';
    $data = array('id' => $id, 'server' => $server, 'bitrate' => $bitrate, 'mode' => $mode);

    header( "location: $url" );
    exit(0);
  /**  $url = 'http://sbogroup.t-wifi.co.th/wordpress/index.php/sample-page';
    $data = array('id' => $id, 'server' => $server, 'bitrate' => $bitrate, 'mode' => $mode);
    $options = array(
        'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data),
    ),
);
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    var_dump($result);**/
}

function do_post_request($url, $data, $optional_headers = null)
{
  echo "string";
  $params = array('http' => array(
              'method' => 'POST',
              'content' => $data
            ));
  if ($optional_headers !== null) {
    $params['http']['header'] = $optional_headers;
  }
  $ctx = stream_context_create($params);
  $fp = @fopen($url, 'rb', false, $ctx);
  if (!$fp) {
    throw new Exception("Problem with $url, $php_errormsg");
  }
  $response = @stream_get_contents($fp);
  if ($response === false) {
    throw new Exception("Problem reading data from $url, $php_errormsg");
  }
  return $response;
}

?>
