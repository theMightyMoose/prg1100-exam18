<?php 

include("../includes/db.inc.php");

$sql = "SELECT * FROM lokasjoner;";
$resultat = mysqli_query($conn,$sql);
?>
<table id="romtyperT">
    <tr>
        <td><h2>Bilder for sted</h2></td>
    </tr>
    <tr>
        <td><b>Sted</b></td>
        <td><b>Filnavn</b></td>
    </tr>
<?php
while($rad = mysqli_fetch_array($resultat)){
    echo("
    <tr>
    <td>".$rad["sted"]."</td>
    <td>".$rad["filnavn"]."</td>
    <td><img width='150px' src='../uploads/".$rad["filnavn"]."'></td>
    <td class='visHotellerVtd remove' onclick='slett(`".$rad['sted']."`,`".$rad['filnavn']."`);'><img width='18px' src='../includes/files/remove.png'></td>
    </tr>
    ");
}

?>
</table>
<script>
    function slett(x, y){
        //alert();
        if(!confirm("Sikker på at du vil slette dette bildet('"+x+"')?"))
            return;
        var ajax = new XMLHttpRequest();
        ajax.open("POST","slettBildePlace.php?filnavn="+y+"&sted="+x,true);
        ajax.onreadystatechange = function(){
            if(this.status=="200" && this.readyState=="4"){
                document.getElementById("romtyperT").innerHTML = `<tr>
                    <td>Sted</td>
                    <td>Filnavn</td>
                </tr>`;
                document.getElementById("romtyperT").innerHTML += this.responseText;
            }
        }
        ajax.send();
    }
</script>