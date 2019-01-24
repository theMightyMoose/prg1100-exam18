<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">
<?php

$sql="SELECT * FROM etg ORDER BY hotellnavn, etgnr, prefix;";
$result = mysqli_query($conn,$sql);
?>
<table id="romtyperT" class="visHotellerV">
    <tr>
        <td><h2>Etager</h2></td>
    </tr>
    <tr>
        <td><b>Hotellnavn</b></td>
        <td><b>Prefix</b></td>
        <td><b>Etgnr</b></td>
        <td><b>Antall rom</b></td>
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
    <td class='visHotellerVtd'>".$rad["prefix"]."</td>
    <td class='visHotellerVtd'>".$rad["etgnr"]."</td>
    <td class='visHotellerVtd'>".$rad["antallrom"]."</td>
    <td class='visHotellerVtd' onclick='slett(`".$rad['hotellnavn']."`,`".$rad['etgnr']."`);'><img width='18px' src='../includes/files/remove.png'></td>
    </tr>");
}

?>
</table>
<script>
    function slett(x,y){
        if(!confirm("Sikker på at du vil slette alt som har med denne etg('"+x+"') å gjøre?"))
            return;
        var ajax = new XMLHttpRequest();
        ajax.open("POST","slettEtg.php?etgnr="+y+"&hotellnavn="+x,"true");
        ajax.onreadystatechange = function(){
            if(this.status=="200" && this.readyState=="4"){
                document.getElementById("romtyperT").innerHTML = "<tr><td><b>Hotellnavn</b></td><td><b>Prefix</b></td><td><b>Etgnr</b></td><td><b>Antall rom</b></td><td><b>Slett</b></td></tr>";
                document.getElementById("romtyperT").innerHTML += this.responseText;
                alert(y+" er nå slettet!");
            }
        }
        ajax.send();
    }
</script>