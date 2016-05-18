<?php
  //$directory = '/var/www/html/tded/temp/sportpool/';
  header('Content-Type: text/html; charset=utf-8');

  $configs = include('php_db_config/config.php');

  $servername = $configs['servername'];
  $username = $configs['username'];
  $password = $configs['password'];
  $dbname = "sbobet878";

  if(isset($_POST['newspaper_name'])){
    $newspaper_name = $_POST['newspaper_name'];
  }else {
    $newspaper_name = '';
    die('value not found');
  }


  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  $conn->set_charset("utf8");
  // Check connection
  if ($conn->connect_error)
  {
      die("Connection failed: " . $conn->connect_error);
  }

  $directory =  realpath(dirname(__FILE__) . "/temp/$newspaper_name");
  $real_directory =  realpath(dirname(__FILE__) . "/real/$newspaper_name");
  $files = glob($directory . '/*.PNG');
  //echo "<pre>";
  //print_r($files);
  //echo "</pre>";
  if ( $files !== false )
  {
    $filecount = count( $files ) - 1;

  }
  else
  {
    //echo 0;
  }

  if($filecount > 0){

    //echo "<center>รอก่อนจ้า....กำลังแปลงไฟล์...กิกิ</center>";
    $dt = date("Y-m-d H:i:s");
    $sql = "UPDATE newspaper SET max_page = '$filecount', last_update = '$dt' WHERE path_name = '$newspaper_name'";

    if ($conn->query($sql) === TRUE) {
        //echo "Record updated successfully";
    } else {
        //echo "Error updating record: " . $conn->error;
    }

    mysqli_close($conn);

    for($i = 1;$i <= $filecount;$i++){

      $png = escapeshellcmd($directory."/$i.PNG");
      $jpg = escapeshellcmd($directory."/$i.jpg");
      exec("mogrify -crop 1536x2048+0+40 $png");
      exec("convert '$png' '$jpg'");
      rename($directory."/$i.jpg", $real_directory."/$i.jpg");
    }

    $png = escapeshellcmd($directory."/cover.PNG");
    $jpg = escapeshellcmd($directory."/cover.jpg");
    exec("mogrify -crop 1536x2048+0+40 $png");
    exec("convert '$png' '$jpg'");
    rename($directory."/cover.jpg", $real_directory."/cover.jpg");
    echo "<center>เสร็จแล้วจ้า...กิกิ</center>";
  }else {
      //echo date("Y-m-d H:i:s");
      echo "<center>ไม่มีไฟล์ใน folder จ้าา</center>";
  }
 ?>
