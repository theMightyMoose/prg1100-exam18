<?php
include("../includes/db.inc.php");

$locName = $_REQUEST["locName"];

$sql="SELECT filnavn FROM lokasjoner WHERE sted='$locName';";
$result = mysqli_query($conn,$sql);
echo("<option value=''>----</option>");

while($rad = mysqli_fetch_array($result)){
    echo("<option value='".$rad["filnavn"]."'>".$rad["filnavn"]."</option>");
}
?>