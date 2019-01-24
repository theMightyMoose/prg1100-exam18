<?php include("../includes/db.inc.php"); ?>
<?php

$sql = "DELETE FROM romtype WHERE romtype = '".$_REQUEST["romtype"]."';";
mysqli_query($conn,$sql);

$sql="SELECT * FROM romtype;";
$result = mysqli_query($conn,$sql);
while($rad = mysqli_fetch_array($result)){
    echo("<tr>
    <td class='visHotellerVtd'>".$rad["romtype"]."</td>
    <td class='visHotellerVtd' onclick='slett(`".$rad['romtype']."`);'> <img width='18px' src='../includes/files/remove.png'> </td>
    </tr>");
}
?>