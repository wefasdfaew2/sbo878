<?php

    $check_direct_access = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
    if($check_direct_access === false)die('Restricted access');

    header('Content-Type: text/html; charset=utf-8');

    $configs = include '../php_db_config/config.php';
    $servername = $configs['servername'];
    $username = $configs['username'];
    $password = $configs['password'];
    $dbname = 'sbobet878';

    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset('utf8');
    // Check connection
    if ($conn->connect_error) {
        die('Connection failed: '.$conn->connect_error);
    }

    $sql = 'SELECT auto_deposit_enable, withdraw_enable, manual_deposit_enable FROM global_setting';

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc())
        {
            $data['deposit_auto_enable'] = $row['auto_deposit_enable'];
            $data['withdraw_enable'] = $row['withdraw_enable'];
            $data['manual_deposit_enable'] = $row['manual_deposit_enable'];
        }

        print json_encode($data);

    } else {
        echo 'Error description: '.mysqli_error($conn);
        echo '0 results';
    }

    mysqli_close($conn);
