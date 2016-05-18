<?php

    //$check_direct_access = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
    //if($check_direct_access === false)die('Restricted access');

    //header('Content-Type: text/html; charset=utf-8');



    function get_announce_data(){

      $configs = require_once(realpath(dirname(__FILE__) . '/../php_db_config/config.php'));
      //$configs = require_once('../php_db_config/config.php');
      $servername = $configs['servername'];
      $username = $configs['username'];
      $password = $configs['password'];
      $dbname = "sbobet878";

      $conn = new mysqli($servername, $username, $password, $dbname);
      $conn->set_charset("utf8");
      // Check connection
      if ($conn->connect_error)
      {
          die("Connection failed: " . $conn->connect_error);
      }

      $sql = "SELECT announce_enable, announce_text FROM global_setting";

      $result = $conn->query($sql);
      if ($result->num_rows > 0)
      {
        while($row = $result->fetch_assoc())
        {
          $announce_data['announce_enable'] = $row['announce_enable'];
          $announce_data['announce_text'] = $row['announce_text'];
        }
      }
      else
      {
        echo("Error description: " . mysqli_error($conn));
        echo "0 results";
      }

      mysqli_close($conn);

      return $announce_data;
    }

 ?>
