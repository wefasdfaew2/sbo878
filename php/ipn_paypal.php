<?php

header('Content-Type: text/html; charset=utf-8');

//$configs = include('../php_db_config/config.php');

//$servername = $configs['servername'];
//$username = $configs['username'];
//$password = $configs['password'];
//$dbname = "sbobet878";

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

//error_log(print_r($_POST, TRUE));

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header = '';
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];			//จำนวนเงินที่ลุกค้าเติมมา
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];				// เมื่อเติมเครดิตเสร็จแล้วให้เอาค่า txn_id บันทึกลงในช่อง deposit_note ว่า "อ้างอิง txn=$txn_id"
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
$custom1 = $_POST['option_selection2'];			//username ของลูกค้า รูปแบบจะเป็น deposit_id-username (ตัดเอา ก่อนเครื่องหมาย - เป็นเลข deposit_id เพื่ออัพเดทลงที่ตาราง backend_deposit_money)
$custom2 = $_POST['custom'];

//ป้องกันการโดน injection
/**$custom1String=mysql_real_escape_string(addslashes($custom1));
$custom1String=htmlspecialchars($custom1String);

$custom2String=mysql_real_escape_string(addslashes($custom2));
$custom2String=htmlspecialchars($custom2String);

$txn_idString=mysql_real_escape_string(addslashes($txn_id));
$txn_idString=htmlspecialchars($txn_idString);

$payment_amountString=mysql_real_escape_string(addslashes($payment_amount));
$payment_amountString=htmlspecialchars($payment_amountString);**/


if (!$fp) {
// HTTP ERROR

} else {

fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
error_log($res);
if (strcmp ($res, "VERIFIED") == 0) {
  error_log( 'success');

// check the payment_status is Completed
// check that txn_id has not been previously processed
// check that receiver_email is your Primary PayPal email
// check that payment_amount/payment_currency are correct
// process payment

// Start Code here

 //ถ้ามาถึงบรรทัดนี้แล้วให้อัพเดทสถานะ deposit_status_id=2 ก่อนเลย
//ไม่แน่ใจมีอะไรต้องทำระหว่างนี้มั้ย
// ก่อนจะ call api เติมเครดิตให้อัพเดทสถานะ deposit_status_id=4
//เติมสำเร็จอัพเดท deposit_status_id=5
//ส่ง SMS + Email แจ้งลูกค้าว่า เติมเครดิเข้าบัญชี zkc8688000 จำนวน xxx บาท สำเร็จแล้ว


}
else if (strcmp ($res, "INVALID") == 0) {
// log for manual investigation
error_log( 'Error: Access Denied');
echo "Error: Access Denied";
}else {
  error_log('qwert');
}
}
fclose ($fp);
}
?>
