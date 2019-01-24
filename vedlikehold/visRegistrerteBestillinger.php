<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">
<?php

$sql="SELECT * FROM bestillinger ORDER BY bestillingsid, hotellnavn;";
$result = mysqli_query($conn,$sql);
?>
<table id="romtyperT" class="visHotellerV vishotellerBestillinger">
    <tr>
        <td colspan="4"><h2>Registrerte bestillinger</h2></td>
    </tr>
    <tr>
        <td><b>Bestillingsid</b></td>
        <td><b>Brukernavn</b></td>
        <td><b>Hotellnavn</b></td>
        <td><b>Romtype</b></td>
        <td><b>Fradato</b></td>
        <td><b>Tildato</b></td>
        <td><b>Pris</b></td>
        <td><b>Romnummer</b></td>
        <td><b>Dato</b></td>
    </tr>
<?php
while($rad = mysqli_fetch_array($result)){
    //print_r($rad);
    echo("<tr class='underline'>
    <td class='visHotellerVtd'>".$rad["bestillingsid"]."</td>
    <td class='visHotellerVtd'>".$rad["brukernavn"]."</td>
    <td class='visHotellerVtd'>".$rad["hotellnavn"]."</td>
    <td class='visHotellerVtd'>".$rad["romtype"]."</td>
    <td class='visHotellerVtd'>".$rad["fradato"]."</td>
    <td class='visHotellerVtd'>".$rad["tildato"]."</td>
    <td class='visHotellerVtd'>".$rad["betpris"]."</td>
    <td class='visHotellerVtd'>".$rad["romnr"]."</td>
    <td class='visHotellerVtd'>".$rad["dato"]."</td>
    <td class='visHotellerVtd remove' onclick='slett(`".$rad['bestillingsid']."`);'><img width='18px' src='../includes/files/remove.png'></td>
    </tr>");
}

?>
</table>
<script>
    function slett(x){
        if(!confirm("Sikker på at du vil slette denne bestillingen('"+x+"')?"))
            return;
        var ajax = new XMLHttpRequest();
        ajax.open("POST","slettBestilling.php?bestillingsid="+x,true);
        ajax.onreadystatechange = function(){
            if(this.status=="200" && this.readyState=="4"){
                document.getElementById("romtyperT").innerHTML = `<tr>
                    <td><b>Bestillingsid</b></td>
                    <td><b>Brukernavn</b></td>
                    <td><b>Hotellnavn</b></td>
                    <td><b>Romtype</b></td>
                    <td><b>Fradato</b></td>
                    <td><b>Tildato</b></td>
                    <td><b>Pris</b></td>
                    <td><b>Romnummer</b></td>
                </tr>`;
                document.getElementById("romtyperT").innerHTML += this.responseText;
                alert(x+" er nå slettet!");
            }
        }
        ajax.send();
    }
</script>