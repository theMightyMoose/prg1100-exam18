<?php include("../includes/db.inc.php"); ?>
<?php

$sql = "DELETE FROM hotellromtype WHERE romtype = '".$_REQUEST["romtype"]."' && hotellnavn = '".$_REQUEST["hotellnavn"]."';";
mysqli_query($conn,$sql);

$sql="SELECT * FROM hotellromtype ORDER BY hotellnavn;";
$result = mysqli_query($conn,$sql);
while($rad = mysqli_fetch_array($result)){
    echo("<tr>
    <td class='visHotellerVtd'>".$rad["hotellnavn"]."</td>
    <td class='visHotellerVtd'>".$rad["romtype"]."</td>
    <td class='visHotellerVtd'>".$rad["antallrom"]."</td>
    <td class='visHotellerVtd'>".$rad["pris"]."</td>
    <td class='visHotellerVtd' onclick='slett(`".$rad['romtype']."`,`".$rad['hotellnavn']."`);'><img width='18px' src='../includes/files/remove.png'></td>
    </tr>");
}
?>