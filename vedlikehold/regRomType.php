<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">
<form action="" method="POST">
    
<table class="formV">
    <tr>
        <td><h3>Registrer Romtype</h3></td>
    </tr>
</table>
<table class="formV">
    <tr>
        <td>Romtype</td><td><input required type="text" placeholder="Suite, dobbeltrom etc." name="roomType"></td>
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
if (isset($_POST["continue"])){
    $room = $_POST["roomType"];
    
    $input = true;
    
    if(!$room){
        $input = false;
        echo("Vennligst fyll ut feltet!");
    }
    
    if($room){
        $sql = "SELECT * FROM romtype WHERE romtype ='$room';";
        $sqlRes = mysqli_query($conn,$sql) or die ("Ikke tilgang til databasen!<br>");
        
        $rows = mysqli_num_rows($sqlRes);
        if($rows == 0 && $input){
            $sqlInsert = "INSERT INTO romtype (romtype)
            VALUES ('$room');";
            mysqli_query($conn,$sqlInsert) or die ("Får ikke registrert i databasen!<br>");
            echo("Du har nå registrert ny romtype <b>$room</b>");
        }
        else{
            echo("Romtype eksisterer allerede!");
        }
    }    
}

?>