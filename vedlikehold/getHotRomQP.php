<?php
include("../includes/db.inc.php");

$hotell = $_REQUEST["hotell"];
$romType = $_REQUEST["romType"];

$sql="SELECT antallrom a, pris p FROM hotellromtype WHERE hotellnavn='$hotell' && romtype='$romType';";
$rad = mysqli_fetch_array(mysqli_query($conn, $sql));
$out = json_encode(array($rad["a"], $rad["p"]));
echo($out);
?>