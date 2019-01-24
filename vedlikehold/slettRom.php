<?php include("../includes/db.inc.php"); ?>
<?php

$sql = "DELETE FROM rom WHERE romnr = '".$_REQUEST["romnr"]."' && hotellnavn = '".$_REQUEST["hotellnavn"]."';";
mysqli_query($conn,$sql);

$sql="SELECT * FROM rom r LEFT JOIN etg e ON r.hotellnavn = e.hotellnavn && r.etgnr = e.etgnr ORDER BY r.hotellnavn, e.etgnr, r.romnr;";
$result = mysqli_query($conn,$sql);
while($rad = mysqli_fetch_array($result)){
    echo("<tr>
    <td class='visHotellerVtd'>".$rad["hotellnavn"]."</td>
    <td class='visHotellerVtd'>".$rad["etgnr"]."</td>
    <td class='visHotellerVtd'>".$rad["prefix"]."</td>
    <td class='visHotellerVtd'>".$rad["romnr"]."</td>
    <td class='visHotellerVtd'>".$rad["romtype"]."</td>
    <td class='visHotellerVtd' onclick='slett(`".$rad['romnr']."`,`".$rad['hotellnavn']."`);'><img width='18px' src='../includes/files/remove.png'></td>
    </tr>");
}
?>