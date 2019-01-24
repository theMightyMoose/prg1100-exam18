<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">

<table id="hotellerT" class="visHotellerV">
     <tr>
        <td><h2>Hoteller</h2></td>
    </tr>
    <tr>
        <td><b>Hotellnavn</b></td>
        <td><b>Sted</b></td>
        <td><b>Slett</b></td>
    </tr>
<?php
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
</table>

<script>
function slett(x){
    //alert();
    if(!confirm("Sikker på at du vil slette alt som har med dette hotellet('"+x+"') å gjøre?"))
        return;
    var ajax = new XMLHttpRequest();
    ajax.open("POST","slettHotell.php?hotellnavn="+x,"true");
    ajax.onreadystatechange = function(){
        if(this.status=="200" && this.readyState=="4"){
            document.getElementById("hotellerT").innerHTML = "<tr><td><b>Hotellnavn</b></td><td><b>Sted</b></td></tr>";
            document.getElementById("hotellerT").innerHTML += this.responseText;
            alert(x+" er nå slettet!");
        }
    }
    ajax.send();
}
</script>