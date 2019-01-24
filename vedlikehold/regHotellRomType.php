<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">
<form action="" method="POST">
    
<table class="formV">
    <tr>
        <td><h3>Registrer Hotellromtype</h3></td>
    </tr>
</table>
    
<table class="formV">
    <tr>
        <td>
            <input type="hidden" id="hotellNavn" name="hotName" value="<?php echo($_GET['hotell']);?>">
        </td>
    </tr>
    <tr>
        <td>Romtype</td>
        <td><select id="romType" name="romType">
            </select></td>
    </tr>
    <tr>
        <td>Antall rom</td><td><input required type="text" placeholder="Antall rom" name="roomQ"></td>
        <td id="antRomTOT"></td>
    </tr>
    <tr>
        <td>Pris</td><td><input required type="text" size="6" pattern="\d*" maxlength="6" placeholder="Per rom" name="roomPrice"> NOK</td>
    </tr>
    <tr>
        <td colspan="3">Obs! Vises ikke romtype, så er alle romtyper for dette hotellet registrert.</td>
    </tr>
</table> 
    
<table class="formV">
    <tr>
        <td><input type="submit" value="Fortsett" name="continue" class="confirm">
        <input type="reset" value="Nullstill" name="reset" class="deny">
        </td>
    </tr>
</table> 

</form>
<script>
function updateRomType(x){
    var response = new XMLHttpRequest();
    response.open("POST","getRomtypeByNotHotell.php?hotell="+x,true);
    response.onreadystatechange = function(){
        if(this.status == 200 && this.readyState == 4){
            document.getElementById("romType").innerHTML = this.responseText;
        }
    }
    response.send();
}
    
    function updateMainWindow(x){
        parent.document.getElementById("ob1").data = parent.document.getElementById("ob1").data;
        alert(x);
        parent.document.getElementById("ob2").data = "";
    }
    
</script>
<?php 
if(isset($_POST["continue"])){
    if(!isset($_POST["romType"])){
        echo("Vennligst fyll ut alle felt!");
    } else{

        $hotName = $_POST["hotName"];
        $romType = $_POST["romType"];
        $roomQ = $_POST["roomQ"];
        $roomPrice = $_POST["roomPrice"];

        $input = true;

        if(!$hotName || !$romType || !$roomQ || !$roomPrice){
            $input = false;
            echo("Vennligst fyll ut alle felt!");
        }
        
        if($roomQ <0 || $roomPrice <0){
        $input = false;
        echo("Du kan ikke bruke et tall mindre enn 0!<br>");
        }

        if($hotName && $romType && $roomQ && $roomPrice){
            $sql = "SELECT * FROM hotellromtype WHERE hotellnavn='$hotName' && romtype ='$romType';";
            $sqlRes = mysqli_query($conn,$sql) or die ("Ikke tilgang til databasen!<br>");

            $rows = mysqli_num_rows($sqlRes);
            if($rows == 0 && $input){
                $sqlInsert = "INSERT INTO hotellromtype (hotellnavn, romtype, antallrom, pris) VALUES ('$hotName', '$romType', '$roomQ', '$roomPrice');";
                mysqli_query($conn, $sqlInsert) or die("Får ikke registrert i databasen!<br>");
                echo("<script>updateMainWindow('Du har nå registrert $roomQ rom med romtype $romType hos $hotName med pris $roomPrice');</script>");
            }
            else{
                echo("Romtype eksisterer allerede på hotellet!");
            }
        }
    }
}









?>
<script>
updateRomType('<?php echo($_GET["hotell"]); ?>');
</script>