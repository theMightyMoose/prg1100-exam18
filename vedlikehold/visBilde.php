<?php 

include("../includes/db.inc.php");

$sql = "SELECT * FROM bilde ORDER BY hotellnavn;";
$resultat = mysqli_query($conn,$sql);
?>
<table id="romtyperT">
    <tr>
        <td colspan="4"><h2>Rom bilder for hotell</h2></td>
    </tr>
    <tr>
        <td><b>Hotellnavn</b></td>
        <td><b>Romtype</b></td>
        <td><b>Filnavn</b></td>
        <td><b>Bilde</b></td>
    </tr>
<?php
while($rad = mysqli_fetch_array($resultat)){
    echo("
    <tr>
    <td>".$rad["hotellnavn"]."</td>
    <td>".$rad["romtype"]."</td>
    <td>".$rad["filnavn"]."</td>
    <td><img width='150px' src='../uploads/".$rad["filnavn"]."'></td>
    <td class='visHotellerVtd remove' onclick='slett(`".$rad['filnavn']."`);'><img width='18px' src='../includes/files/remove.png'></td>
    </tr>
    ");
}

?>
</table>
<script>
    function slett(x){
        //alert();
        if(!confirm("Sikker på at du vil slette dette bildet('"+x+"')?"))
            return;
        var ajax = new XMLHttpRequest();
        ajax.open("POST","slettBilde.php?filnavn="+x,true);
        ajax.onreadystatechange = function(){
            if(this.status=="200" && this.readyState=="4"){
                document.getElementById("romtyperT").innerHTML = `<tr>
                    <td>Hotellnavn</td>
                    <td>Romtype</td>
                    <td>Filnavn</td>
                    <td>Bilde</td>
                </tr>`;
                document.getElementById("romtyperT").innerHTML += this.responseText;
            }
        }
        ajax.send();
    }
</script>