<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">
<?php

$sql="SELECT * FROM hotellromtype ORDER BY hotellnavn;";
$result = mysqli_query($conn,$sql);
?>
<table id="romtyperT" class="visHotellerV">
    <tr>
        <td><h2>Hotellromtyper</h2></td>
    </tr>
    <tr>
        <td><b>Hotellnavn</b></td>
        <td><b>Romtype</b></td>
        <td><b>Antallrom</b></td>
        <td><b>Pris</b></td>
        <td><b>Slett</b></td>
    </tr>
<?php
    $currHot = "";
while($rad = mysqli_fetch_array($result)){
        if($currHot == ""){
        $currHot = $rad["hotellnavn"];
    } else if($currHot != $rad["hotellnavn"]){
        $currHot = $rad["hotellnavn"];
        echo("<tr><td colspan='6'><hr class='lineHot'></td></tr>");
    }
    echo("<tr>
    <td class='visHotellerVtd'>".$rad["hotellnavn"]."</td>
    <td class='visHotellerVtd'>".$rad["romtype"]."</td>
    <td class='visHotellerVtd'>".$rad["antallrom"]."</td>
    <td class='visHotellerVtd'>".$rad["pris"]."</td>
    <td class='visHotellerVtd' onclick='slett(`".$rad['romtype']."`,`".$rad['hotellnavn']."`);'><img width='18px' src='../includes/files/remove.png'></td>
    </tr>");
}

?>
</table>
<script>
    function slett(x,y){
        if(!confirm("Sikker på at du vil slette alt som har med denne Hotellromtypen('"+x+"') å gjøre?"))
            return;
        var ajax = new XMLHttpRequest();
        ajax.open("POST","slettHotellromtype.php?romtype="+x+"&hotellnavn="+y,"true");
        ajax.onreadystatechange = function(){
            if(this.status=="200" && this.readyState=="4"){
                document.getElementById("romtyperT").innerHTML = "<tr><td><b>Hotellnavn</b></td><td><b>Romtype</b></td><td><b>Antallrom</b></td><td><b>Pris</b></td><td><b>Slett</b></td></tr>";
                document.getElementById("romtyperT").innerHTML += this.responseText;
                alert(x+" er nå slettet!");
            }
        }
        ajax.send();
    }
</script>