<?php
include("../includes/db.inc.php");

$hotell = $_REQUEST["hotell"];

$sql="SELECT * FROM etg WHERE hotellnavn = '$hotell';";
$result = mysqli_query($conn,$sql);
echo("<option value=''>----</option>");

while($rad = mysqli_fetch_array($result)){
    echo("<option value='".$rad["etgnr"]."'>".$rad["prefix"]." (etg. ".$rad["etgnr"].")</option>");
}
?>