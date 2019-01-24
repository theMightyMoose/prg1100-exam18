<?php include("../includes/db.inc.php"); ?>
<?php

$sql = "DELETE FROM lokasjoner WHERE sted = '".$_REQUEST["sted"]."';";
if(unlink("../uploads/".$_REQUEST["filnavn"])){
    mysqli_query($conn,$sql);

    $sql="SELECT * FROM lokasjoner;";
    $result = mysqli_query($conn,$sql);
    while($rad = mysqli_fetch_array($result)){
        echo("
        <tr>
        <td>".$rad["sted"]."</td>
        <td>".$rad["filnavn"]."</td>
        <td><img width='150px' src='../uploads/".$rad["filnavn"]."'></td>
        <td class='visHotellerVtd remove' onclick='slett(`".$rad['sted']."`,`".$rad['filnavn']."`);'><img width='18px' src='../includes/files/remove.png'></td>
        </tr>
        ");
    }
}
?>