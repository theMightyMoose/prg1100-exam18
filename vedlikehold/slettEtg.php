<?php include("../includes/db.inc.php"); ?>
<?php

$sql = "DELETE FROM etg WHERE etgnr= '".$_REQUEST["etgnr"]."' && hotellnavn = '".$_REQUEST["hotellnavn"]."';";
mysqli_query($conn,$sql);

$sql="SELECT * FROM etg ORDER BY hotellnavn;";
$result = mysqli_query($conn,$sql);
while($rad = mysqli_fetch_array($result)){
   echo("<tr>
    <td class='visHotellerVtd'>".$rad["hotellnavn"]."</td>
    <td class='visHotellerVtd'>".$rad["prefix"]."</td>
    <td class='visHotellerVtd'>".$rad["etgnr"]."</td>
    <td class='visHotellerVtd'>".$rad["antallrom"]."</td>
    <td class='visHotellerVtd' onclick='slett(`".$rad['hotellnavn']."`,`".$rad['etgnr']."`);'><img width='18px' src='../includes/files/remove.png'></td>
    </tr>");
}
?>