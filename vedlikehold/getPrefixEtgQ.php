<?php
include("../includes/db.inc.php");


$etg = $_REQUEST["etg"];
$hotell = $_REQUEST["hotellnavn"];
$sql="SELECT prefix p, etgnr e, antallrom a FROM etg WHERE etgnr='$etg' && hotellnavn='$hotell';";
$rad = mysqli_fetch_array(mysqli_query($conn, $sql));
$out = json_encode(array($rad["p"], $rad["e"], $rad["a"]));
echo($out);
?>