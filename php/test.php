<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="Free Web tutorials">
<meta name="keywords" content="HTML,CSS,XML,JavaScript">
<meta name="author" content="Hege Refsnes">
<meta name="referrer" content="origin">
</head>
<body>

<p>All meta information goes in the head section...</p>



<?php

$deposit_time = strtotime('2016-05-15 22:25:00');
$current_time = strtotime(date('Y-m-d H:i:s'));
echo $deposit_time;
echo '<br>';
echo $current_time;
echo '<br>';
echo round(abs($deposit_time - $current_time) / 60). " minute";
 ?>
</body>
</html>
