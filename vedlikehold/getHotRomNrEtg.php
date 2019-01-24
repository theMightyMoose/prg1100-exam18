<?php
include("../includes/db.inc.php");

$romType = $_REQUEST["romType"];
$romNrOld = $_REQUEST["romNrOld"];

$sql="SELECT romnr r, etgnr e FROM rom WHERE romtype='$romType' && romnr='$romNrOld';";
$rad = mysqli_fetch_array(mysqli_query($conn, $sql));
$out = json_encode(array($rad["r"], $rad["e"]));
echo($out);
?>