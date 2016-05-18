<?php

header('Content-Type: text/html; charset=utf-8');

    function add_credit($dp_id,$ac_name,$dest_account,$money,$tel){
        //include('../php_sms_class/sms_sbobet878.php');
        include(realpath(dirname(__FILE__) . '/../php_sms_class/sms_sbobet878.php'));
        //$configs = include_once('../php_db_config/config.php');
        $configs = include(realpath(dirname(__FILE__) . '/../php_db_config/config.php'));

        $servername = $configs['servername'];
        $username = $configs['username'];
        $password = $configs['password'];
        $dbname = "sbobet878";
        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn->set_charset("utf8");
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT deposit_status_id FROM backend_deposit_money WHERE deposit_id = '$dp_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
          while($row = $result->fetch_assoc())
          {
            $deposit_data['deposit_status_id'] = $row['deposit_status_id'];
          }

          if($deposit_data['deposit_status_id'] == 1 || $deposit_data['deposit_status_id'] == 4){
            if($deposit_data['deposit_status_id'] == 4){
              $res = file_get_contents("http://zkc8688_add_value.service/".$dp_id."/".$ac_name."/".$dest_account."/".$money."");
              $add_result = json_decode($res, true);
              $result = $add_result["status"];
              //$result = '200';
              if($result == '200'){
                $message = 'เติมเครดิเข้าบัญชี '.$ac_name.' จำนวน '.$money.' บาท สำเร็จแล้ว';
                sendsms($message, $tel, 1);
              }
              mysqli_close($conn);
              return $result;
            }else {
              $sql = "UPDATE backend_deposit_money SET deposit_status_id = '2' WHERE deposit_id = '$dp_id'";
              if ($conn->query($sql) === TRUE) {
                  $res = file_get_contents("http://zkc8688_add_value.service/".$dp_id."/".$ac_name."/".$dest_account."/".$money."");
                  $add_result = json_decode($res, true);
                  $result = $add_result["status"];
                  //$result = '200';
                  if($result == '200'){
                    $message = 'เติมเครดิเข้าบัญชี '.$ac_name.' จำนวน '.$money.' บาท สำเร็จแล้ว';
                    sendsms($message, $tel, 1);
                  }
                  mysqli_close($conn);
                  return $result;
              } else {
                  echo "Error updating record: " . $conn->error;
              }
            }


          }else {
                echo 'deposit_status_id not valid';
          }
        }
        else
        {
          echo("Error description: " . mysqli_error($conn));
          echo "0 results";
        }

    }
 ?>
