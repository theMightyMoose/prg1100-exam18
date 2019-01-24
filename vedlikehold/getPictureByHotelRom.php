<?php
include("../includes/db.inc.php");

$hotell = $_REQUEST["hotellNavn"];
$romType = $_REQUEST["romType"];
$sql="SELECT filnavn FROM bilde WHERE hotellnavn='$hotell' && romtype = '$romType';";
$result = mysqli_query($conn,$sql);
echo("<option value=''>----</option>");
while($rad = mysqli_fetch_array($result)){
    echo("<option value='".$rad["filnavn"]."'>".$rad["filnavn"]."</option>");
}
?>