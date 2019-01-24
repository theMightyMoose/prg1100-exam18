<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">


<form action="" method="POST">
<table class="formV">
    <tr>
        <td><h3>Registrer Etage</h3></td>
    </tr>
</table>
    
<table class="formV">
    <tr>
        <td>
            <input type="hidden" value="<?php echo($_GET["hotell"]); ?>" name="hotName">
        </td>
    </tr>
    <tr>
        <td>Etg nummer</td>
        <td><input name="etgNr" placeholder="eks. 1, 2" type="number" required></td>
    </tr>
    <tr>
        <td>Prefix</td>
        <td><input type="text" placeholder="eks. A1" name="prefix" required></td>
    </tr>
    <tr>
        <td>Anntall rom</td>
        <td><input name="roomNr" placeholder="eks. 101, 202" type="number" required></td>
    </tr>
</table>
    
<table class="formV">
    <tr>
        <td><input type="submit" value="Fortsett" name="continue" class="confirm">
        <input type="reset" value="Nullstill" name="reset" class="deny">
        </td>
    </tr>
</table>    
<script>
    function updateMainWindow(x){
        parent.document.getElementById("ob1").data = parent.document.getElementById("ob1").data;
        alert(x);
        parent.document.getElementById("ob2").data = "";
    }
    </script>
</form>
<?php 
if(isset($_POST["continue"])){
    $etgNr = $_POST["etgNr"];
    $hotell = $_POST["hotName"];
    $prefix = ucfirst($_POST["prefix"]);
    $roomNr = $_POST["roomNr"];
    
    $input = true;
    
    if(!$hotell || !$etgNr || !$prefix || !$roomNr){
        $input = false;
        echo("Vennligst fyll ut alle felt!");
    }
    if($roomNr <0 || $etgNr <0){
        $input = false;
        echo("Du kan ikke bruke et tall mindre enn 0!<br>");
    }
    
    if($hotell && $etgNr && $prefix && $roomNr){
        $sql = "SELECT * FROM etg WHERE hotellnavn ='$hotell' && etgnr ='$etgNr';";
        $sqlRes = mysqli_query($conn,$sql) or die ("Ikke tilgang til databasen!<br>");
        
        $rows = mysqli_num_rows($sqlRes);
        if($rows == 0 && $input){
            $sqlInsert = "INSERT INTO etg (etgnr, hotellnavn, prefix, antallrom) VALUES ('$etgNr', '$hotell', '$prefix', '$roomNr');";
            mysqli_query($conn, $sqlInsert) or die("Får ikke registrert i databasen!<br>");
            echo('<script>updateMainWindow("Du har nå registrert etage '.$etgNr.' på '.$hotell.' med prefix '.$prefix.' Antall rom: '.$roomNr.'");</script>');
        }
        else{
            echo("Etage eksisterer allerede på hotellet!");
        }
    }
}

?>