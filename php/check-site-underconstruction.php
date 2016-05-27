<?php

    //$check_direct_access = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
    //if($check_direct_access === false)die('Restricted access');

    //header('Content-Type: text/html; charset=utf-8');



    function get_site_construct_status(){

      $configs = require(realpath(dirname(__FILE__) . '/../php_db_config/config.php'));
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

      $sql = "SELECT site_underconstruction FROM global_setting";

      $result = $conn->query($sql);
      if ($result->num_rows > 0)
      {
        while($row = $result->fetch_assoc())
        {
          $cons_data['site_underconstruction'] = $row['site_underconstruction'];
        }
      }
      else
      {
        echo("Error description: " . mysqli_error($conn));
        echo "0 results";
      }

      mysqli_close($conn);

      if($cons_data['site_underconstruction'] == 'Yes'){
        return TRUE;
      }else {
        return FALSE;
      }

    }

 ?>
