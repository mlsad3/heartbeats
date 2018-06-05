<?php
#print_r($_GET);
$serial  = $_GET['serial'];
$version = $_GET['version'];
$fw      = $_GET['fw'];
$int_ip  = $_GET['intip'];
$tag     = $_GET['tag'];
$event   = $_GET['event'];
$ext_ip  = $_SERVER['REMOTE_ADDR'];

// If not local, //serverName\instanceName and port (default 1433) needed,
// change "(local)" to "serverName\\sqlexpress, 1542"
$conn = sqlsrv_connect("(local)", 
          array(
		    "UID" => "REPLACE_USERNAME",
		    "PWD" => "REPLACE_PASSWORD",
		    "Database" => 'brightsign'));
if (!$conn){
    printf("Connect failed: %s\n", print_r( sqlsrv_errors(), true));
	exit();
}

$tsql = "DELETE FROM heartbeats WHERE snum = (?)";
$params = array($serial);

/* Prepare and execute the query. */
if (!sqlsrv_query($conn, $tsql, $params)){
	printf("Error deleting from dbo.heartbeats: %s\n", print_r( sqlsrv_errors(), true));
	/* close connection */
	sqlsrv_close($conn);
	exit();
}

if ($tag=="") $tag="none";
if ($event=="") $event="none";

$tsql = "INSERT INTO dbo.heartbeats (snum,version,fw,int_ip,ext_ip,tag,event) VALUES (?, ?, ?, ?, ?, ?, ?)";
$params = array($serial,$version,$fw,$int_ip,$ext_ip,$tag,$event);

/* Prepare and execute the query. */
$stmt = sqlsrv_query($conn, $tsql, $params);
if ($stmt){
	printf("Row inserted successfully.\n");
	header("Status: 200 OK");
	/* Free resource */
	sqlsrv_free_stmt($stmt);
} else {
	printf("Error deleting from heartbeats: %s\n", print_r( sqlsrv_errors(), true));
}

/* close connection */
sqlsrv_close($conn);
exit();

?>