<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">
<form action="" method="POST">
    
<table class="formV">
    <tr>
        <td><h3>Registrer Hotell</h3></td>
    </tr>
</table>
    
<table class="formV">
    <tr>
        <td>Hotellnavn</td><td><input type="text" placeholder="Navn på hotell" name="hotName" required></td>
    </tr>
    <tr>
        <td>Sted</td><td><input type="text" placeholder="Byen til hotell" name="hotLoc" required></td>
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
    $hotName = ucfirst($_POST["hotName"]);
    $hotLoc = ucfirst($_POST["hotLoc"]);
        
    $input = true;
    
    if(!$hotName || !$hotLoc){
        $input = false;
        echo("Vennligst fyll ut begge felt!<br>");
    }
    
    if($hotName && $hotLoc){
        $sql = "SELECT * FROM hotell WHERE hotellnavn ='$hotName';";
        $sqlRes = mysqli_query($conn,$sql) or die ("Ikke tilgang til databasen!<br>");
        
        $rows = mysqli_num_rows($sqlRes);
        if($rows == 0 && $input){
            $sqlInsert = "INSERT INTO hotell (hotellnavn,sted) VALUES('$hotName','$hotLoc');";
            mysqli_query($conn,$sqlInsert) or die ("Får ikke registrert i databasen!<br>");
            echo("Du har nå registrert hotellet <b>$hotName</b> på stedsnavn <b>$hotLoc</b>");
        }
        else{
            echo("Hotell eksisterer allerede!");
        } 
    }   
}

?>