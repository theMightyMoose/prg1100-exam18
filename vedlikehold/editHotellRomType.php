<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">
<form action="" method="POST"> 
<table class="formV">
    <tr>
        <td><h3>Rediger Hotellromtype</h3></td>
    </tr>
</table>
    
<table class="formV">
    <tr>
        <td>
            <input type="hidden" id="hotellNavn" name="hotName" value="<?php echo($_GET['hotell']);?>">
        </td>
    </tr>
    <tr>
        <td>Romtype som skal endres</td>
        <td>
            <select onchange="getHotellet(this);" id="romType" name="romType">
            </select>
        </td>
    </tr>
    <tr>
        <td>Nytt antall rom</td><td><input id="quantity" type="text" placeholder="Antall rom" name="roomQ" required></td>
    </tr>
    <tr>
        <td>Ny pris</td><td><input id="price" type="text" size="6" pattern="\d*" maxlength="6" placeholder="Per rom" name="roomP" required> NOK</td>
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
    response.open("POST","getRomtypeByHotell.php?hotell="+x,true);
    response.onreadystatechange = function(){
        if(this.status == 200 && this.readyState == 4){
            document.getElementById("romType").innerHTML = this.responseText;
        }
    }
    response.send();
}
    
 function getHotellet(x){
        var response = new XMLHttpRequest();
        response.open("POST","getHotRomQP.php?hotell="+document.getElementById("hotellNavn").value+"&romType="+x.value,true);
        response.onreadystatechange = function(){
        if(this.status == 200 && this.readyState == 4){
            console.log(this.responseText);
            var jsonString = JSON.parse(this.responseText);
            console.log(jsonString);
            document.getElementById("quantity").value = jsonString[0];
            document.getElementById("price").value = jsonString[1];
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
    $roomQNew = $_POST["roomQ"];
    $roomPNew = $_POST["roomP"];
    
    $input = true;
    
    if(!$hotName || !$romType || !$roomQNew || !$roomPNew){
        $input = false;
        echo("Du må fylle ut alle feltene!<br>");    
    }
    
    if($roomQNew <0 || $roomPNew <0){
        $input = false;
        echo("Du kan ikke bruke et tall mindre enn 0!<br>");
    }
    
    if($hotName && $romType && $roomQNew && $roomPNew){
        $sql = "SELECT * FROM hotellromtype WHERE hotellnavn ='$hotName' && romtype='$romType';";
        $sqlRes = mysqli_query($conn,$sql) or die ("Ikke tilgang til databasen!<br>");
        
        $item=mysqli_num_rows($sqlRes);
        for($r=1;$r<=$item;$r++){
            $fetch = mysqli_fetch_array($sqlRes);
            $oldQ = $fetch["antallrom"];
            $oldP = $fetch["pris"];
        }
        
        $sql = "SELECT COUNT(romnr) r FROM rom WHERE hotellnavn = '$hotName' AND romtype='$romType'";
        $result = mysqli_fetch_array(mysqli_query($conn, $sql));
        
        
        if($result["r"] > $roomQNew){
            $input = false;
            echo("Du kan ikke sette antall rom av denne typen til mindre enn ".$result["r"]."<br>fordi det eksisterer allerede ".$result["r"]." rom av den typen.<br> Hvis du ønsker å fjerne alle rom, så må du på vis og slett<br>");
        }
        
        $rows = mysqli_num_rows($sqlRes);
        if($rows == 1 && $input){
            $sqlUpdate ="UPDATE hotellromtype SET antallrom='$roomQNew', pris='$roomPNew' WHERE hotellnavn='$hotName' && romtype='$romType';";
            mysqli_query($conn,$sqlUpdate) or die ("Får ikke registrert i databasen");
            echo('<script>updateMainWindow("Hotellromtype '.$romType.' hos hotell '.$hotName.' har endret pris fra '.$oldP.' til '.$roomPNew.' og antall rom fra '.$oldQ.' til '.$roomQNew.'");</script>');
        }
        else{
            echo("Det har oppstått en feil!<br>");
            }
        } 
    }
}

?>
<script>
updateRomType('<?php echo($_GET["hotell"]); ?>');
</script>