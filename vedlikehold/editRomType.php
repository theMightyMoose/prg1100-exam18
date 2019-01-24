<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">
<form action="" method="POST">
    
<table class="formV">
    <tr>
        <td><h3>Rediger Romtype</h3></td>
    </tr>
</table>
<table class="formV">
    <tr>
        <td>Velg romtype du vil endre</td>
        <td>
            <select name="romType">
                <option value="">----</option>
          <?php
          $sql="SELECT * FROM romtype;";
          $result = mysqli_query($conn,$sql);
          while($rad = mysqli_fetch_array($result)){
              echo("<option value='".$rad["romtype"]."'>".$rad["romtype"]."</option>");
          }
          ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Ny romtype</td><td><input type="text" placeholder="Suite, dobbeltrom etc." name="romTypeNew" required></td>
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
<?php
if(isset($_POST["continue"])){
    $romType = $_POST["romType"];
    $romTypeNew = $_POST["romTypeNew"];
    
    $input = true;
    
    if(!$romType || !$romTypeNew){
        $input = false;
        echo("Du må fylle ut alle feltene!<br>");
    }
    
    if($romType && $romTypeNew){
        $sql = "SELECT * FROM romtype WHERE romtype='$romType';";
        $sqlRes = mysqli_query($conn,$sql) or die ("Ikke tilgang til databasen!<br>");
        
        $rows = mysqli_num_rows($sqlRes);
        if($rows == 1 && $input){
            $sqlUpdate = "UPDATE romtype SET romtype='$romTypeNew' WHERE romtype='$romType';";
            mysqli_query($conn,$sqlUpdate) or die ("Får ikke registrert i databasen");
            echo("Romtype <b>$romType</b> har endret til romtype <b>$romTypeNew</b>");
        }
        else{
            echo("Det har oppstått en feil!");
        }
    }
}

?>