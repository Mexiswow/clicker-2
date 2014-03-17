<?php
$link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
$db = mysql_select_db(DB_NAME);
if(!$db){
    die("halp i cant find the DB: ".mysql_error());
}

$sql = "select * from clicker_items where type = 1";

$res = mysql_query($sql);
$autoItems = array();
while($row = mysql_fetch_array($res)){
    $autoItems[] = $row;
}

mysql_close($link);

?>
