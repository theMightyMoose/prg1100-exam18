<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">
<form action="" method="POST" enctype="multipart/form-data">
    
<table class="formV">
    <tr>
        <td><h3>Endre bilde for sted</h3></td>
    </tr>
</table>
    
<table class="formV">
    <tr>
        <td>Sted</td>
          <td><select onchange="getPicOld(this);" id="locName"  name="locName">
              <option value="">----</option>
          <?php
          $sql="SELECT DISTINCT(sted) FROM lokasjoner;";
          $result = mysqli_query($conn,$sql);
          while($rad = mysqli_fetch_array($result)){
              echo("<option value='".$rad["sted"]."'>".$rad["sted"]."</option>");
          }
          ?>
          </select></td> 
    </tr>
     <tr>
        <td>Bildefil som skal endres</td>
        <td>
            <select onchange="displayPic(this)" id="fileOld" name="fileOld">
            </select>
        </td>
    </tr>
    <tr>
        <td>Bilde fil</td><td><input name="file" type="file" required></td>
    </tr>
</table>
    
<table class="formV">
    <tr>
        <td><input type="submit" value="Fortsett" name="continue" class="confirm">
        <input type="reset" value="Nullstill" name="reset" class="deny">
        </td>
    </tr>
    <tr>
    <td id="dispPic">
        </td>
    </tr>
</table> 

</form>
<script>
function getPicOld(x){
    //console.log(x.value);
    var response = new XMLHttpRequest();
    response.open("POST","getPicPlace.php?locName="+document.getElementById("locName").value,true);
    response.onreadystatechange = function(){
        if(this.status == 200 && this.readyState == 4){
            document.getElementById("fileOld").innerHTML = this.responseText;
        }
    }
    response.send();
}

function displayPic(x){
    //console.log(x.value);
    document.getElementById("dispPic").innerHTML="<img width='300px' src='../uploads/"+x.value+"'>";
}
</script>
<?php 
if(isset($_POST["continue"])){
    if(!isset($_POST["fileOld"])){
        echo("Vennligst fyll ut alle felt!");
    } else{
        
    $upFolder ="../uploads/";
    $picFile = $upFolder . basename($_FILES["file"]["name"]);
    $picFile = str_replace(" ","_","$picFile");    
    $fileName = $_FILES["file"]["name"];
    $fileName = str_replace(" ","_","$fileName");    
    $fileType = strtolower(pathinfo($picFile,PATHINFO_EXTENSION));
    $locName = $_POST["locName"];
    $fileOld = $_POST["fileOld"];
    
    $input = true;
    
        if(!$fileName){
            $input = false;
            echo("Du har ikke valgt fil til opplastning!<br>");
        }
        

        $strTest = 'æ';
        $invalidStr = stripos(strtolower($fileName), $strTest);
        if($invalidStr !== false){
            $input = false;
            echo ("Du kan ikke ha æ i filnavn!<br>");   
        }

        $strTest = 'ø';
        $invalidStr = stripos($fileName, $strTest);
        if($invalidStr !== false){
            $input = false;
            echo ("Du kan ikke ha ø i filnavn!<br>");   
        }

        $strTest = 'å';
        $invalidStr = stripos($fileName, $strTest);
        if($invalidStr !== false){
            $input = false;
            echo ("Du kan ikke ha å i filnavn!<br>");   
        }
        
        $strTest = '"';
        $invalidStr = stripos($fileName, $strTest);
        if($invalidStr !== false){
            $input = false;
            echo ("Du kan ikke ha tegn i filnavn!<br>");   
        }
        $strTest = '<';
        $invalidStr = stripos($fileName, $strTest);
        if($invalidStr !== false){
            $input = false;
            echo ("Du kan ikke ha tegn i filnavn!<br>");   
        }
        $strTest = '>';
        $invalidStr = stripos($fileName, $strTest);
        if($invalidStr !== false){
            $input = false;
            echo ("Du kan ikke ha tegn i filnavn!<br>");   
        }
        $strTest = '/';
        $invalidStr = stripos($fileName, $strTest);
        if($invalidStr !== false){
            $input = false;
            echo ("Du kan ikke ha tegn i filnavn!<br>");   
        }

        $strTest = "'";
        $invalidStr = stripos($fileName, $strTest);
        if($invalidStr !== false){
            $input = false;
            echo ("Du kan ikke ha tegn i filnavn!<br>");   
        }
        $strTest = '`';
        $invalidStr = stripos($fileName, $strTest);
        if($invalidStr !== false){
            $input = false;
            echo ("Du kan ikke ha tegn i filnavn!<br>");   
        }


        
         $sql="SELECT * FROM lokasjoner WHERE sted='$locName';";
         $sqlRes=mysqli_query($conn,$sql) or die ("Ikke tilgang til database!<br>");

        if(!$locName || !$fileOld || !$fileName){
            $input = false;
            echo("Du må velge sted og fil for endring!<br>");
        }


        if($_FILES["file"]["size"] > 5000000){
            $input = false;
            echo("Beklager størrelsen på bildet er for stor <br>");
        }
        if($fileType != "jpg" && $fileType != "jpeg" && $fileType != "png" && $fileType != "gif"){
            $input = false;
            echo("kun filformat JPG, JPEG, PNG og GIF er tillat!<br>");
        }
        if($input == false){
            echo("Beklager, filen ble ikke lastet opp!<br>");
        }


        else{
            if($input == true){
                move_uploaded_file($_FILES["file"]["tmp_name"], $picFile);
                $sqlInsert = "UPDATE lokasjoner SET filnavn='$fileName' WHERE sted='$locName' && filnavn='$fileOld';";
                mysqli_query($conn,$sqlInsert) or die ("Får ikke registrert i database!<br>");
                echo("Bilde med filnavn <b>$fileOld</b> har endret til <b>" .basename($_FILES["file"]["name"]). "</b> for sted <b>$locName</b>");
            }
            else {
                echo("Beklager noe gikk galt under opplastning!<br>");
            }
        }   
    }
}



?>