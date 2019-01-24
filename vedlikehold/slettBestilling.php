<?php include("../includes/db.inc.php"); ?>
<?php

$sql = "DELETE FROM bestillinger WHERE bestillingsid = '".$_REQUEST["bestillingsid"]."';";
mysqli_query($conn,$sql);

$sql="SELECT * FROM bestillinger ORDER BY bestillingsid, hotellnavn;";
$result = mysqli_query($conn,$sql);
while($rad = mysqli_fetch_array($result)){
    echo("<tr>
    <td class='visHotellerVtd'>".$rad["bestillingsid"]."</td>
    <td class='visHotellerVtd'>".$rad["brukernavn"]."</td>
    <td class='visHotellerVtd'>".$rad["hotellnavn"]."</td>
    <td class='visHotellerVtd'>".$rad["romtype"]."</td>
    <td class='visHotellerVtd'>".$rad["fradato"]."</td>
    <td class='visHotellerVtd'>".$rad["tildato"]."</td>
    <td class='visHotellerVtd'>".$rad["betpris"]."</td>
    <td class='visHotellerVtd'>".$rad["romnr"]."</td>
    <td class='visHotellerVtd remove' onclick='slett(`".$rad['bestillingsid']."`);'><img width='18px' src='../includes/files/remove.png'></td>
    </tr>");
}
?>