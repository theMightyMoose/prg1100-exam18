<?php
include("../includes/db.inc.php");

$etg = $_REQUEST["etg"];
$hotell = $_REQUEST["hotellnavn"];

$sql = "SELECT antallrom a FROM etg WHERE etgnr = '$etg' && hotellnavn = '$hotell'";
$result = mysqli_query($conn, $sql);
$sql = "SELECT COUNT(romnr) a FROM rom WHERE etgnr = '$etg' && hotellnavn = '$hotell'";
$result2 = mysqli_query($conn, $sql);

echo("Registrert: ".mysqli_fetch_array($result2)["a"]."/" . mysqli_fetch_array($result)["a"]);


?>