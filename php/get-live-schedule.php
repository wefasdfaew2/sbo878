<?php

//$check_direct_access = strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'));
//if($check_direct_access === false)die('Restricted access');

header('Content-Type: text/html; charset=utf-8');

$configs = include('../php_db_config/config.php');

$servername = $configs['servername'];
$username = $configs['username'];
$password = $configs['password'];
$dbname = "sbobet878";

$postdata = file_get_contents('php://input');
$request = json_decode($postdata);


if(!empty($request->today))$today = $request->today;
//$today = '2016-04-20';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM live_schedule WHERE schedule_date = '$today'";

$result = $conn->query($sql);

if ($result->num_rows > 0)
{
  while($row = $result->fetch_assoc())
  {
    $data[] = $row;
  }

  for($x = 0; $x < $result->num_rows; $x++)
  {
    unset($data_channel);
    foreach (explode(",",$data[$x]['schedule_channel']) as $key => $value) {
      if($data[$x]['schedule_channel'] == ''){
        $data_channel[$value] = ' http://sbogroup.t-wifi.co.th/wordpress/wp-content/themes/point/images/noimage.jpg';
        continue;
      }
      $sql = "SELECT channel_logo FROM channel WHERE id = '$value'";
      $result_2 = $conn->query($sql);

      if ($result_2->num_rows > 0)
      {
        /**while($row = $result->fetch_assoc())
        {
          $data_channel[] = $row;
        }**/
        foreach ($result_2->fetch_assoc() as $channel_logo => $logo_url)
        {
          $data_channel[$value] = $logo_url;
        }

      }
      else
      {
        echo("Error description3: " . mysqli_error($conn));
        echo "0 results";
      }
    }
    $team_home = $data[$x]['schedule_home'];
    $team_away = $data[$x]['schedule_away'];
    $sql = "SELECT
            (SELECT team_logo FROM live_team WHERE team_name = '$team_home')as homelogo,
            (SELECT team_logo FROM live_team WHERE team_name = '$team_away') as awaylogo";
    $result_3 = $conn->query($sql);

    if ($result_3->num_rows > 0)
    {
      foreach ($result_3->fetch_assoc() as $team_logo => $team_logo_url)
      {
        $data_team_logo[$team_logo] = $team_logo_url;
      }

      if($data_team_logo['homelogo'] == ''){
        $data[$x]['home_logo'] = 'noimage.jpg';
      }else {
        $data[$x]['home_logo'] = $data_team_logo['homelogo'];
      }

      if($data_team_logo['awaylogo'] == ''){
        $data[$x]['away_logo'] = 'noimage.jpg';
      }else {
        $data[$x]['away_logo'] = $data_team_logo['awaylogo'];
      }

    }
    else
    {
      echo("Error description2: " . mysqli_error($conn));
      echo "0 results";
    }
    foreach ($data[$x] as $key => $value)
    {
      $data[$x]['schedule_channel'] = $data_channel;
      $data[$x]['schedule_time'] = substr($data[$x]['schedule_time'], 0, 5);
    }
  }

  //print "<pre>";
  //print_r($data);
  //print "</pre>";
  print json_encode($data);
}
else
{
  echo("Error description: " . mysqli_error($conn));
  echo "0 results";
}

mysqli_close($conn);
?>
