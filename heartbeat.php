<?php
#print_r($_GET);
$serial  = $_GET['serial'];
$version = $_GET['version'];
$fw      = $_GET['fw'];
$int_ip  = $_GET['intip'];
$tag     = $_GET['tag'];
$event   = $_GET['event'];
$ext_ip  = $_SERVER['REMOTE_ADDR'];

$link = mysql_connect('localhost', 'web', 'qwe123');
if (!$link) {
    die('Not connected : ' . mysql_error());
}

$db_selected = mysql_select_db('brightsign', $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
	
$sql1 = "DELETE FROM heartbeats WHERE snum='$serial';";
$result1 = mysql_query($sql1) or die(mysql_error());

if ($tag=="") $tag="none";
if ($event=="") $event="none";


$sql2 = "INSERT INTO heartbeats (snum,version,fw,int_ip,ext_ip,tag,event) VALUES ('$serial','$version','$fw','$int_ip','$ext_ip','$tag','$event');";
$result2 = mysql_query($sql2) or die(mysql_error());

exit(header("Status: 200 OK"));
	
?>