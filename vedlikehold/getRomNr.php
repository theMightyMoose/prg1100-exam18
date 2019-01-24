<?php
include("../includes/db.inc.php");

$romType = $_REQUEST["romType"];
$hotellnavn = $_REQUEST["hotell"];

$sql="SELECT * FROM rom WHERE romtype = '$romType' && hotellnavn = '$hotellnavn';";
$result = mysqli_query($conn,$sql);
echo("<option value=''>----</option>");

while($rad = mysqli_fetch_array($result)){
    echo("<option value='".$rad["romnr"]."'>".$rad["romnr"]."</option>");
}
?>