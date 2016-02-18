<?php

header('Content-Type: text/html; charset=utf-8');

$configs = include('../php_db_config/config.php');

$servername = $configs['servername'];
$username = $configs['username'];
$password = $configs['password'];
$dbname = "sbobet878";

if(isset($_GET['option'])) {
    $option = $_GET['option'];
}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

$money = rand(10,3000);
if($option == 'set'){

  $sql = "SELECT * FROM sbo_money WHERE id = 1";
  //$sql = "SELECT channel_group FROM channel_category";
  $result = $conn->query($sql);

  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      //$data[] = $row;
      $money = $money + $row["user_money"];
    }
  }
  
  $sql = "UPDATE sbo_money SET user_money = $money WHERE id = 1";

  if ($conn->query($sql) === TRUE) {
      echo "Record updated successfully";
  } else {
      echo "Error updating record: " . $conn->error;
  }

}elseif ($option == 'get') {

  $sql = "SELECT * FROM sbo_money WHERE id = 1";
  //$sql = "SELECT channel_group FROM channel_category";
  $result = $conn->query($sql);

  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      $data[] = $row;
      //echo  $row["channel"];
    }
    print json_encode($data);
  }
  else
  {
    echo("Error description: " . mysqli_error($conn));
    echo "0 results";
  }

}



mysqli_close($conn);
?>
