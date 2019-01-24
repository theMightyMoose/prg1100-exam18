<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">
<form action="" method="POST">

<table class="formV">
    <tr>
        <td><h3>Rediger Hotellrom</h3></td>
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
            <select onchange="getRomNr(this);" id="romType" name="romType">
            </select>
        </td>
    </tr>
     <tr>
        <td>Romnr som skal endres</td>
         <td>
             <select onchange="getNrEtg(this);" id="romNr" name="romNrOld"></select>
         </td>
    </tr>
    <tr>
        <td>Nytt rom nr</td>
        <td>
            <input id="romNrOld" type="text" placeholder="Anngi rom nr" name="romNrNew" required>
        </td>
    </tr>
    <tr>
        <td>Ny etg</td>
        <td>
             <select id="etg" name="etg">
              <option value="">----</option>
          <?php
          $sql="SELECT * FROM etg WHERE hotellnavn = '".$_GET["hotell"]."';";
          $result = mysqli_query($conn,$sql);
          while($rad = mysqli_fetch_array($result)){
              echo("<option value='".$rad["etgnr"]."'>".$rad["prefix"]." (etg: ".$rad["etgnr"].")</option>");
          }
          ?>
          </select>
        </td>
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

function getRomNr(x){
    var response = new XMLHttpRequest();
    response.open("POST","getRomNr.php?romType="+x.value+"&hotell="+document.getElementById("hotellNavn").value,true);
    response.onreadystatechange = function(){
        if(this.status == 200 && this.readyState == 4){
            document.getElementById("romNr").innerHTML = this.responseText;
        }
    }
    response.send();
}

 function getNrEtg(x){
        var response = new XMLHttpRequest();
        response.open("POST","getHotRomNrEtg.php?romType="+document.getElementById("romType").value+"&romNrOld="+x.value,true);
        response.onreadystatechange = function(){
        if(this.status == 200 && this.readyState == 4){
            console.log(this.responseText);
            var jsonString = JSON.parse(this.responseText);
            console.log(jsonString);
            document.getElementById("romNrOld").value = jsonString[0];
            document.getElementById("etg").value = jsonString[1];
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
    if(!isset($_POST["romType"]) && !isset($_POST["romNrOld"])){
        echo("Vennligst fyll ut alle felt!");
    } else{

        $hotName = $_POST["hotName"];
        $romType = $_POST["romType"];
        $romNrOld = $_POST["romNrOld"];
        $romNrNew = $_POST["romNrNew"];
        $etgNew = $_POST["etg"];

        $input = true;
        
        if($romNrNew <0 || $etgNew <0){
        $input = false;
        echo("Du kan ikke bruke et tall mindre enn 0!<br>");
        }

        if(!$hotName || !$romType || !$romNrOld || !$romNrNew || !$etgNew){
            $input = false;
            echo("Du må fylle ut alle feltene!<br>");    
        }

        if($hotName && $romType && $romNrOld && $romNrNew && $etgNew){
    
            $sql = "SELECT * FROM rom WHERE hotellnavn='$hotName' && romnr='$romNrOld';";
            $sqlRes = mysqli_query($conn,$sql) or die ("Ikke tilgang til databasen!<br>");

            $item=mysqli_num_rows($sqlRes);
            for($r=1;$r<=$item;$r++){
                $fetch = mysqli_fetch_array($sqlRes);
                $etgOld = $fetch["etgnr"]; 
            }

            $rows = mysqli_num_rows($sqlRes);
            if($rows == 1 && $input){
                $sqlUpdate ="UPDATE rom SET romnr='$romNrNew', etgnr='$etgNew' WHERE hotellnavn='$hotName' && romnr='$romNrOld';";
                mysqli_query($conn,$sqlUpdate) or die ("Får ikke registrert i databasen");
                echo("<script>updateMainWindow('Romtype $romType hos hotell $hotName har endret romnr fra $romNrOld til $romNrNew og etg fra $etgOld til $etgNew');</script>");
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