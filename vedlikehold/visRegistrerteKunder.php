<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">
<?php

$sql="SELECT * FROM minside;";
$result = mysqli_query($conn,$sql);
?>
<table id="romtyperT" class="visHotellerV">
    <tr>
        <td><h2>Registrerte kunder</h2></td>
    </tr>
    <tr>
        <td><b>Brukernavn</b></td>
    </tr>
<?php
while($rad = mysqli_fetch_array($result)){
    echo("<tr>
    <td class='visHotellerVtd'>".$rad["brukernavn"]."</td>
    <td class='visHotellerVtd remove' onclick='slett(`".$rad['brukernavn']."`);'><img width='18px' src='../includes/files/remove.png'></td>
    </tr>");
}

?>
</table>
<script>
    function slett(x){
        if(!confirm("Sikker på at du vil slette denne brukeren('"+x+"')?"))
            return;
        var ajax = new XMLHttpRequest();
        ajax.open("POST","slettKunde.php?brukernavn="+x,true);
        ajax.onreadystatechange = function(){
            if(this.status=="200" && this.readyState=="4"){
                document.getElementById("romtyperT").innerHTML = `<tr>
                    <td><b>Brukernavn</b></td>
                </tr>`;
                document.getElementById("romtyperT").innerHTML += this.responseText;
                alert(x+" er nå slettet!");
            }
        }
        ajax.send();
    }
</script>