<?php
/*
Template Name: point_adduserdata
*/
?>
<?php

$errors = array();
$data = array();
// Getting posted data and decodeing json
$_POST = json_decode(file_get_contents('php://input'), true);

// checking for blank values.
if (empty($_POST['ID']))
  $errors['ID'] = 'ID is required.';

  echo  $_POST['phone_number'];
/*
if (empty($_POST['bank_name']))
  $errors['bank_name'] = 'bank_name is required.';

if (empty($_POST['bank_number']))
  $errors['bank_number'] = 'bank_number is required.';

if (empty($_POST['member_type']))
  $errors['member_type'] = 'member_type is required.';

  if (empty($_POST['phone_number']))
  $errors['phone_number'] = 'phone_number is required.';
*/
  
if (!empty($errors)) {
  $data['errors']  = $errors;
} else {
  $data['message'] = 'Form data is going well';
}
// response back.
echo json_encode($data);
?>