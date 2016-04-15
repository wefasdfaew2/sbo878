<?php
//recrive user data from angularjs
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

@$name = $request->name;
@$phone = $request->phone;
@$email = $request->email;
@$facebook = $request->facebook;
@$line = $request->line;
@$message = $request->message;
@$sbolive = $request->sbolive;
@$sboapp = $request->sboapp;
@$sbopay = $request->sbopay;
@$sbovpn = $request->sbovpn;
@$sboweb = $request->sboweb;

require("email/class.phpmailer.php"); // path to the PHPMailer class.

if($sbolive == false){
  $sbolive = '';
}else{
  $sbolive = 'SboLive';
}

if($sboapp == false){
  $sboapp = '';
}else{
  $sboapp = 'SboApp';
}

if($sbopay == false){
  $sbopay = '';
}else{
  $sbopay = 'SboPay';
}

if($sbovpn == false){
  $sbovpn = '';
}else{
  $sbovpn = 'SboVPN';
}

if($sboweb == false){
  $sboweb = '';
}else{
  $sboweb = 'SboWeb';
}

$service = $sbolive." ".$sboapp." ".$sbopay." ".$sbovpn." ".$sboweb;
//must valid sender email
$fm = "admin@sbogroup.net";
$to = "admin@sbogroup.net";
//$cc = ";
//$bcc = "";
$subj = "สนใจระบบ"; //<------ subject from user
$mesg = "Customer Name : " . $name . "\xA" .
        "Customer Phone : " . $phone . "\xA" .
        "Customer Email : " . $email . "\xA" .
        "Customer Facebook : " . $facebook . "\xA" .
        "Customer Line : " . $line . "\xA" .
        "Service : " . $service . "\xA" .
        "Customer Message : " . "\xA" .$message;//<------ message from user + email + lineid + facebook
$mail = new PHPMailer();
$mail->CharSet = "utf-8";
$mail->IsSMTP();
$mail->Mailer = "smtp";
$mail->SMTPAuth = true;
//$mail->SMTPSecure = 'ssl'; // Uncomment this line if you want to use SSL.
/*
กรอกรายละเอียด Account SMTP ของ Mail Server ตรงนี้
*/
$mail->Host = "in.mailjet.com"; //Enter your SMTPJET account's SMTP server.
$mail->Port = "587"; // 8025, 587 and 25 can also be used. Use Port 465 for SSL.
$mail->Username = "1698e84d690b09ba76ee8c7e8e0d4370";
$mail->Password = "f5e260597d8fb810a0ae7a4eede545dd";
//
$mail->From = $fm;
$mail->AddAddress($to);
$mail->AddReplyTo($fm);
//$mail->AddCC($cc);
//$mail->AddBCC($bcc);
$mail->Subject = $subj;
$mail->Body = $mesg;
$mail->WordWrap = 50;
//
if(!$mail->Send()) {
echo 'Message was not sent.';
echo 'ยังไม่สามารถส่งเมลล์ได้ในขณะนี้ ' . $mail->ErrorInfo;
exit;
} else {
echo 'ส่งเมลล์สำเร็จ';
}
?>
