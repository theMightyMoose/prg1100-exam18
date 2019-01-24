<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">
<form action="" method="POST">
    
<table class="formV">
    <tr>
        <td><h3>Rediger Hotell</h3></td>
    </tr>
</table>
    
<table class="formV">
    <tr>
        <td><input type="hidden" value="<?php echo($_GET['hotell']); ?>" name="hotName" ></td>
    </tr>
    <tr>
        <td>Nytt hotellnavn</td><td><input id="name" type="text" placeholder="Navn på hotell" name="hotNameNew" required></td>
    </tr>
    <tr>
        <td>Nytt sted</td><td><input id="loc" type="text" placeholder="Byen til hotell" name="hotLoc" required></td>
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

    function getHotellet(x){
        var response = new XMLHttpRequest();
        response.open("POST","getHotellByName.php?hotell="+x,true);
        response.onreadystatechange = function(){
        if(this.status == 200 && this.readyState == 4){
            document.getElementById("loc").value = this.responseText;
            document.getElementById("name").value = x;
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
    $hotName = $_POST["hotName"];
    $hotNameNew = $_POST["hotNameNew"];
    $hotLoc = $_POST["hotLoc"];
    
    $input = true;
    
    if(!$hotName || !$hotNameNew || !$hotLoc){
        $input = false;
        echo("Du må fylle ut alle feltene!<br>");
    }
    
    if($hotName && $hotNameNew && $hotLoc){
        $sql = "SELECT * FROM hotell WHERE hotellnavn='$hotName';";
        $sqlRes = mysqli_query($conn,$sql) or die ("Ikke tilgang til databasen!<br>");
        
        $item=mysqli_num_rows($sqlRes);
        for($r=1;$r<=$item;$r++){
            $fetch = mysqli_fetch_array($sqlRes);
            $oldLoc = $fetch["sted"];
        }
        
        $rows = mysqli_num_rows($sqlRes);
        if($rows == 1 && $input){
            $sqlUpdate = "UPDATE hotell SET hotellnavn='$hotNameNew', sted='$hotLoc' WHERE hotellnavn='$hotName';";
            mysqli_query($conn,$sqlUpdate) or die ("Får ikke registrert i databasen");
            echo("Hotell <b>$hotName</b> har endret navn til <b>$hotNameNew</b> og sted fra <b>$oldLoc</b> til <b>$hotLoc</b>");
            ?>
<script>
    updateMainWindow("<?php echo($hotName);?> har endret navn til <?php echo($hotNameNew);?> og sted fra <?php echo($oldLoc);?> til <?php echo($hotLoc);?>");
</script>
<?php
        }
        else{
            echo("Det har oppstått en feil!");
        }
    }
}
?>
<script>getHotellet('<?php echo($_GET["hotell"]); ?>');</script>