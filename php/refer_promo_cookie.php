<?php
/*
Template Name: set-refercode
*/
?>
<?php get_header();?>
<?php

$cookie_name = "refercode";

if(isset($_GET['refercode'])) {
    $refercode = $_GET['refercode'];


    $cookie_value = $refercode;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 7), "/"); // 86400 = 1 day
}

if(!isset($_COOKIE[$cookie_name])) {
    echo "Cookie named '" . $cookie_name . "' is not set!";
} else {
    echo "Cookie '" . $cookie_name . "' is set!<br>";
    echo "Value is: " . $_COOKIE[$cookie_name];
}

header("Location:".get_page_link(129));
die();
?>
<?php get_footer(); ?>
