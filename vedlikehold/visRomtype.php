<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">

<?php

$sql="SELECT * FROM romtype;";
$result = mysqli_query($conn,$sql);
?>
<table id="romtyperT" class="visHotellerV">
    <tr>
        <td><h2>Romtyper</h2></td>
    </tr>
    <tr>
        <td><b>Romtype</b></td>
        <td><b>Slett</b></td>
    </tr>
<?php
while($rad = mysqli_fetch_array($result)){
    echo("<tr><td class='visHotellerVtd'>".$rad["romtype"]."</td><td class='visHotellerVtd' onclick='slett(`".$rad['romtype']."`);'><img width='18px' src='../includes/files/remove.png'></td></tr>");
}

?>
</table>
<script>
function slett(x){
    if(!confirm("Sikker på at du vil slette alt som har med denne romtypen('"+x+"') å gjøre?"))
        return;
    var ajax = new XMLHttpRequest();
    ajax.open("POST","slettRomtype.php?romtype="+x,"true");
    ajax.onreadystatechange = function(){
        if(this.status=="200" && this.readyState=="4"){
            document.getElementById("romtyperT").innerHTML = "<tr><td><b>Hotellnavn</b></td><td><b>Sted</b></td></tr>";
            document.getElementById("romtyperT").innerHTML += this.responseText;
            alert(x+" er nå slettet!");
        }
    }
    ajax.send();
}
</script>