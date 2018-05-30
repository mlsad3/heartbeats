<?php
#print_r($_GET);
$serial  = $_GET['serial'];
$version = $_GET['version'];
$fw      = $_GET['fw'];
$int_ip  = $_GET['intip'];
$tag     = $_GET['tag'];
$event   = $_GET['event'];
$ext_ip  = $_SERVER['REMOTE_ADDR'];

$mysqli = new mysqli('localhost', 'REPLACE_USERNAME', 'REPLACE_PASSWORD', 'brightsign');

/* Check Connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
	exit();
}
	
$sql1 = "DELETE FROM heartbeats WHERE snum='$serial';";
if (!$mysqli->query($sql1)){
	printf("Error deleting from heartbeats: %s\n", $mysqli->error);
	/* close connection */
	$mysqli->close();
	exit();
}

if ($tag=="") $tag="none";
if ($event=="") $event="none";


$sql2 = "INSERT INTO heartbeats (snum,version,fw,int_ip,ext_ip,tag,event) VALUES ('$serial','$version','$fw','$int_ip','$ext_ip','$tag','$event');";
if (!$mysqli->query($sql2)){
	printf("Error inserting into heartbeats: %s\n", $mysqli->error);
	/* close connection */
	$mysqli->close();
	exit();
}

/* close connection */
$mysqli->close();

exit(header("Status: 200 OK"));
	
?>