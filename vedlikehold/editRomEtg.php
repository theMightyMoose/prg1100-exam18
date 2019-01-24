<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">

<form action="" method="POST">
  
<table class="formV">
    <tr>
        <td><h3>Rediger Etage</h3></td>
    </tr>
</table>
<table class="formV">
    <tr>
        <td>
            <input type="hidden" id="hotellNavn" name="hotName" value="<?php echo($_GET['hotell']);?>">
        </td>
    </tr>
    <tr>
        <td>Etg som skal endres</td>
        <td>
            <select onchange="getPrefixEtg(this);" id="etg" name="etg">
            </select>
        </td>
    </tr>
     <tr>
        <td>Ny prefix</td>
         <td>
             <input name="prefixNew" id="prefixOld" type="text" placeholder="Anngi ny prefix" required>
         </td>
    </tr>
    <tr>
        <td>Ny etg</td>
        <td>
            <input id="etgOld" type="text" placeholder="Anngi ny etg" name="etgNew" required>
        </td>
    </tr>
     <tr>
        <td>Nytt antall rom</td>
        <td>
            <input id="quantityOld" type="text" placeholder="Anngi nytt antall rom" name="quantity" required>
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
    response.open("POST","getEtgByHotell.php?hotell="+x,true);
    response.onreadystatechange = function(){
        if(this.status == 200 && this.readyState == 4){
            //console.log(this.responseText);
            document.getElementById("etg").innerHTML = this.responseText;
        }
    }
    response.send();
}

function getPrefixEtg(x){
        var response = new XMLHttpRequest();
        response.open("POST","getPrefixEtgQ.php?etg="+document.getElementById("etg").value+"&hotellnavn="+document.getElementById("hotellNavn").value,true);
        response.onreadystatechange = function(){
        if(this.status == 200 && this.readyState == 4){
            console.log(this.responseText);
            var jsonString = JSON.parse(this.responseText);
            console.log(jsonString);
            document.getElementById("prefixOld").value = jsonString[0];
            document.getElementById("etgOld").value = jsonString[1];
            document.getElementById("quantityOld").value = jsonString[2];
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
    if(!isset($_POST["etg"])){
        echo("Vennligst fyll ut alle felt!");
    } else{
        
        $hotName = $_POST["hotName"];
        $etgOld = $_POST["etg"];
        $etgNew = $_POST["etgNew"];
        $prefixNew = $_POST["prefixNew"];
        $quantityNew = $_POST["quantity"];

        $input = true;
        
        if(!$hotName || !$etgOld || !$etgNew || !$prefixNew || !$quantityNew){
            $input = false;
            echo("Du må fylle ut alle feltene!<br>");    
        }
        if($etgNew  <0 || $quantityNew <0){
        $input = false;
        echo("Du kan ikke bruke et tall mindre enn 0!<br>");
        }
        
        if($hotName && $etgOld && $etgNew && $prefixNew && $quantityNew){
            $sql = "SELECT * FROM etg WHERE hotellnavn='$hotName' && etgnr='$etgOld';";
            $sqlRes = mysqli_query($conn,$sql) or die ("Ikke tilgang til databasen!<br>");

            $item=mysqli_num_rows($sqlRes);
            for($r=1;$r<=$item;$r++){
                $fetch = mysqli_fetch_array($sqlRes);
                $prefixOld = $fetch["prefix"];
                $quantityOld = $fetch["antallrom"];
            }
            
            $rows = mysqli_num_rows($sqlRes);
            if($rows == 1 && $input){
                $sqlUpdate = "UPDATE etg SET prefix='$prefixNew', etgnr='$etgNew', antallrom='$quantityNew' WHERE hotellnavn='$hotName' && etgnr='$etgOld';";
                mysqli_query($conn,$sqlUpdate) or die ("Får ikke registrert i databasen");
                echo("Etage er endret fra <b>$etgOld</b> til <b>$etgNew</b> hos hotell <b>$hotName</b> prefix er endret fra <b>$prefixOld</b> til <b>$prefixNew</b> og antall rom fra <b>$quantityOld</b> til <b>$quantityNew</b> ");
                ?>
<script>updateMainWindow("Etage er endret fra <?php echo($etgOld); ?> til <?php echo($etgNew); ?> hos hotell <?php echo($hotName); ?> prefix er endret fra <?php echo($prefixOld); ?> til <?php echo($prefixNew); ?> og antall rom fra <?php echo($quantityOld); ?> til <?php echo($quantityNew); ?>");</script>
<?php 
            }
            else{
                echo("Det har oppstått en feil!<br>");
            }
        }   
    }
}

?>
<script>updateRomType('<?php echo($_GET["hotell"])?>');</script>