<?php
include("../includes/db.inc.php");

$hotell = $_REQUEST["hotell"];

$sql="SELECT * FROM hotellromtype WHERE hotellnavn = '$hotell';";
$result = mysqli_query($conn,$sql);
echo("<option value=''>----</option>");

while($rad = mysqli_fetch_array($result)){
    echo("<option value='".$rad["romtype"]."'>".$rad["romtype"]."</option>");
}
?>