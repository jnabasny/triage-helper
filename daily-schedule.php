<?php
session_start();

if ($_SESSION['auth'] == "") {
	header("Location: index.php");
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<title>Triage Helper</title>
</head>

<body>
<div id="agents" style="float:right;">
<?php

// DEFINE VARIABLES
$row = 1;
$names = "";
$phones = "";
$triage = "";
$chat = "";
$sweeper = "";

// DEFINE TIMES
$weekday = date( 'N' );  // Mon (1) - Sun (7)

// LOAD THE CURRENT LINE UP
if (($handle = fopen('lineups/' . date('M-j-Y') . '.csv', "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        $row++;

	//phones
	if ($data[0] == $weekday && $data[2] == 1) {
		$names = $data[3];
		$names = rtrim($names, " "); // remove trailing comma
		$names = rtrim($names, ","); // remove trailing comma
		$names = str_replace(",", ", ", $names);
		$names = rtrim($names, ","); // remove trailing comma
		$phones = $phones . '<td>' . $names . '</td>';
	//triage
	} elseif ($data[0] == $weekday && $data[2] == 2) {
		$names = $data[3];
		$names = rtrim($names, " "); // remove trailing comma
		$names = rtrim($names, ","); // remove trailing comma
		$names = str_replace(",", ", ", $names);
		$triage = $triage . '<td>' . $names . '</td>';
	//chats
	} elseif ($data[0] == $weekday && $data[2] == 3) {
		$names = $data[3];
		$names = rtrim($names, " "); // remove trailing comma
		$names = rtrim($names, ","); // remove trailing comma
		$names = str_replace(",", ", ", $names);
		$chat = $chat . '<td>' . $names . '</td>';
	//sweeper
	} elseif ($data[0] == $weekday && $data[2] == 4) {
		$names = $data[3];
		$names = rtrim($names, " "); // remove trailing comma
		$names = rtrim($names, ","); // remove trailing comma
		$names = str_replace(",", ", ", $names);
		$sweeper = $sweeper . '<td>' . $names . '</td>';
	}
   }
   fclose($handle);
}
?>
<h1>Duties for <?php echo date('F j, Y'); ?></h1>
<center>

<table>
<caption>Phones</caption>
<tr>
<th></th>
<th>6am - 10am</th>
<th>8am - 12pm</th>
<th>10am - 2pm</th>
<th>12pm - 4pm</th>
<th>2pm - 6pm</th>
<th>4pm - 8pm</th>
</tr>
<tr>
<th>Agents</th>
<?php echo $phones; ?>
</tr>
</table>

<br />

<table style="float:left;width:45%;">
<caption>Chat</caption>
<tr>
<th></th>
<th>8am - 2pm</th>
<th>10am - 4pm</th>
<th>2pm - 8pm</th>
</tr>
<tr>
<th>Agents</th>
<?php echo $chat; ?>
</tr>
</table>

<table style="width:45%;float:right;">
<caption>Triage</caption>
<tr>
<th></th>
<th>6am - 2:30pm</th>
<th>8am - 4:30pm</th>
<th>11:30am - 8pm</th>
</tr>
<tr>
<th>Agents</th>
<?php echo $triage; ?>
</tr>
</table>

<br /><br />

<table>
<caption>Sweeper</caption>
<tr>
<th></th>
<th>8am - 4:30pm</th>
<th>10am - 6:30pm</th>
<th>11:30am - 8pm</th>
</tr>
<tr>
<th>Agents</th>
<?php echo $sweeper; ?>
</tr>
</table>

</center>

<br />
<a href="index.php" style="font-size:16px;">☚ back to live view</a>

</div>
</body>
</html>
