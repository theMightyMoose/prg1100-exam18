<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">
<form action="" method="POST">
<table class="formV">
    <tr>
        <td><h3>Registrer Rom </h3></td>
    </tr>
</table>
    
<table class="formV">
      <tr>
          <td>
            <input type="hidden" id="hotellNavn" name="hotellNavn" value="<?php echo($_GET['hotell']);?>">
        </td>
    </tr>
    <tr>
        <td>Romtype</td>
        <td><select onchange="getAntFreeRooms(this);" id="romType" name="romType">
            </select></td>
        <td id="ledigRNummer"></td>
    </tr>
    <tr>
        <td>Etg</td>
        <td><select onchange="getAntFreeRoomsInEtg(this);" id="etg" name="etg">
            </select></td>
        <td id="ledigeIEtage"></td>
    </tr>
    <tr>
        <td>Rom nr</td>
        <td><input required type="text" placeholder="Anngi rom nr" name="romNr"></td>
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

        var response2 = new XMLHttpRequest();
        response2.open("POST","getEtgByHotell.php?hotell="+x,true);
        response2.onreadystatechange = function(){
            if(this.status == 200 && this.readyState == 4){
                document.getElementById("etg").innerHTML = this.responseText;
            }
        }
        response2.send(); 
    }
    
    function getAntFreeRooms(x){
        var response = new XMLHttpRequest();
        response.open("POST","getAntFreeRooms.php?romtype="+x.value+"&hotell="+document.getElementById("hotellNavn").value,true);
        response.onreadystatechange = function(){
            if(this.status == 200 && this.readyState == 4){
                document.getElementById("ledigRNummer").innerHTML = this.responseText;
            }
        }
        response.send();
    }
    function getAntFreeRoomsInEtg(x){
        var response = new XMLHttpRequest();
        response.open("POST","getAntFreeRoomsEtg.php?etg="+x.value+"&hotellnavn="+document.getElementById("hotellNavn").value,true);
        response.onreadystatechange = function(){
            if(this.status == 200 && this.readyState == 4){
                document.getElementById("ledigeIEtage").innerHTML = this.responseText;
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

if (isset($_POST["continue"])) {
    if(!isset($_POST["hotellNavn"])||!isset($_POST["romType"])||!isset($_POST["etg"])||!isset($_POST["romNr"])){
        echo("Alle feltene må fylles ut!");
    } else {
        
        $etg = $_POST["etg"];
        $hotell = $_POST["hotellNavn"];
        $romtype = $_POST["romType"];
        $romnr = $_POST["romNr"];
        
        if($etg <0 || $romnr <0){
        $input = false;
        echo("Du kan ikke bruke et tall mindre enn 0!<br>");
        }
        
        $sql="SELECT COUNT(romnr) a FROM rom WHERE hotellnavn = '$hotell' && romtype = '$romtype';";
        $sql2="SELECT antallrom a FROM hotellromtype WHERE hotellnavn = '$hotell' && romtype = '$romtype';";
        $result = mysqli_query($conn,$sql);
        $result2 = mysqli_query($conn,$sql2);
        $ledigeRomType = mysqli_fetch_array($result2)["a"] - mysqli_fetch_array($result)["a"];
        
        $sql = "SELECT antallrom a FROM etg WHERE etgnr = '$etg' && hotellnavn='$hotell'";
        $result = mysqli_query($conn, $sql);
        $sql = "SELECT COUNT(romnr) a FROM rom WHERE etgnr = '$etg' && hotellnavn='$hotell'";
        $result2 = mysqli_query($conn, $sql);
        
        $ledigeRomEtg = mysqli_fetch_array($result)["a"]-mysqli_fetch_array($result2)["a"];
        
        if ($ledigeRomEtg <=0) {
            echo("Etasjen er full!");
        } else if($ledigeRomType <= 0) {
            echo("Du har nådd maks antall registrerte hotellrom av den romtypen!");
        } else {
            $sql="INSERT INTO rom VALUES('$hotell','$romtype','$etg','$romnr')";
            if($result = mysqli_query($conn,$sql)){
                echo('<script> updateMainWindow("Rommet er registrert!");</script>');
            } else{
                echo("Det oppsto en feil i registreringen! ". mysqli_error($conn));
            }
        }
    }
}


?>
<script>
updateRomType('<?php echo($_GET["hotell"]); ?>');
</script>