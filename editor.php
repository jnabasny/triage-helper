<html>
<head>
<link rel="stylesheet" type="text/css" href="style_ed.css">
</head>
<body>
<?php
session_start();

if ($_SESSION['auth'] == "") {
	header("Location: index.php");
	exit();
}

$file = $_GET['f'];
$command = $_GET['c'];

if ($command == "exit") {
	unlink($file . '.lock');
	header('Location: index.php');
	exit();
}

if (isset($_POST['text']))
{
    if (file_get_contents($file . '.lock') == $_SESSION['auth']) {
    file_put_contents($file, $_POST['text']);
    unlink($file . '.lock');
    header('Location: index.php');
    exit();
    } else {
    echo '<br />Someone has stolen your session. Please try again to make your edits.';
    exit();
    }
}

if ($file == 'schedule.csv' || $file == 'duties.csv') {
	$file = $_GET['f'];
} else {
	echo 'You cannot edit that file.';
	exit();
}

if ($command == "force") {
	unlink($file . '.lock');
}

if (!file_exists($file . '.lock')) {
	$text = file_get_contents($file);
	file_put_contents($file . '.lock', $_SESSION['auth']);
} else {
	echo "<br />This file is being edited by another user. <a href=\"?f=$file&c=force\">Click here</a> to edit anyway.<br /><br /><b>IMPORTANT:</b> Please only use the above option if absolutely necessary. Other users edits will be lost.";
	exit();
}

?>
<form action="" method="post">
<textarea name="text"><?php echo $text; ?></textarea>
<br />
<div id="buttons">
<p style="float:left;text-align:left;"><input type="reset" value="Reset" />
<input type="button" onclick="window.location.href='<?php echo $file ?>';" value="Download">
<input type="button" onclick="window.location.href='editor.php?f=<?php echo $file ?>&c=exit';" value="Exit"></p>
<p style="float:right;text-align:right"><input type="submit" value="Save" /></p>
</div>
<div style="clear: both;"></div>
</form>
</body>
</html>
