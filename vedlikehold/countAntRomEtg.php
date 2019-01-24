<?php
include("../includes/db.inc.php");

$hotell = $_REQUEST["hotell"];

$sql = "SELECT SUM(antallrom) s FROM etg WHERE hotellnavn = '$hotell'";
$antRomTot = mysqli_fetch_array(mysqli_query($conn, $sql))["s"];

$sql = "SELECT SUM(antallrom) s FROM hotellromtype WHERE hotellnavn = '$hotell'";
$antRomBrukt = mysqli_fetch_array(mysqli_query($conn, $sql))["s"];

echo($antRomTot-$antRomBrukt);

?>