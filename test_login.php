<?php

require_once '../../../../wp-blog-header.php';
$postdata = file_get_contents('php://input');
$request = json_decode($postdata);
$username = $request->username;//$_POST['username'];
$password = $request->password;//['password'];

$creds = array(
  'user_login' => $username,
  'user_password' => $password,
  'rememember' => true,
);

$user = wp_signon($creds, false);

if (is_wp_error($user)) {
    echo $user->get_error_message();
} else {
    echo 'success';
}
/**if(is_user_logged_in()){
  print $user;
}else{
  print $user;
}**/;
