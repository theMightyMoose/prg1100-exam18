<?php
include("../includes/db.inc.php");

$hotell = $_REQUEST["hotell"];

$sql = "SELECT * FROM romtype WHERE romtype NOT IN (SELECT romtype FROM hotellromtype WHERE hotellnavn='$hotell');";
$result = mysqli_query($conn, $sql);

while($rad = mysqli_fetch_array($result)){
    echo("<option value='".$rad["romtype"]."'>".$rad["romtype"]."</option>");
}
?>