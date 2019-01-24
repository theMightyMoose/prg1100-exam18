<?php include("../includes/db.inc.php"); ?>
<?php

$sql = "DELETE FROM hotell WHERE hotellnavn = '".$_REQUEST["hotellnavn"]."';";
mysqli_query($conn,$sql);

$sql="SELECT * FROM hotell ORDER BY sted;";
$result = mysqli_query($conn,$sql);
while($rad = mysqli_fetch_array($result)){
    echo("<tr>
    <td class='visHotellerVtd'>".$rad["hotellnavn"]."</td>
    <td class='visHotellerVtd'>".$rad["sted"]."</td>
    <td class='visHotellerVtd' onclick='slett(`".$rad['hotellnavn']."`);'> <img width='18px' src='../includes/files/remove.png'> </td>
    </tr>");
}
?>