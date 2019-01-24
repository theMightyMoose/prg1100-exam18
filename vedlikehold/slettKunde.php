<?php include("../includes/db.inc.php"); ?>
<?php

$sql = "DELETE FROM minside WHERE brukernavn = '".$_REQUEST["brukernavn"]."';";
mysqli_query($conn,$sql);

$sql="SELECT * FROM minside;";
$result = mysqli_query($conn,$sql);
while($rad = mysqli_fetch_array($result)){
    echo("<tr>
    <td class='visHotellerVtd'>".$rad["brukernavn"]."</td>
    <td class='visHotellerVtd remove' onclick='slett(`".$rad['brukernavn']."`);'><img width='18px' src='../includes/files/remove.png'></td>
    </tr>");
}
?>