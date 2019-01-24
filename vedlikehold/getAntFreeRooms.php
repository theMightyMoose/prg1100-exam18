<?php
include("../includes/db.inc.php");

$hotell = $_REQUEST["hotell"];
$romtype = $_REQUEST["romtype"];

$sql="SELECT COUNT(romnr) ant FROM rom WHERE hotellnavn = '$hotell' && romtype = '$romtype';";
$sql2="SELECT antallrom a FROM hotellromtype WHERE hotellnavn = '$hotell' && romtype = '$romtype';";
$result = mysqli_query($conn,$sql);
$result2 = mysqli_query($conn,$sql2);

$rad = mysqli_fetch_array($result);
$rad2 = mysqli_fetch_array($result2);

echo("Registrert: ".$rad['ant']."/".$rad2['a']);
?>