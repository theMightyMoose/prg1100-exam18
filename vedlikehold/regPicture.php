<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">
<form action="" method="POST" enctype="multipart/form-data">
    
<table class="formV">
    <tr>
        <td><h3>Last opp bilde</h3></td>
    </tr>
</table>
    
<table class="formV">
    <tr>
        <td>Hotellnavn</td>
          <td><select onchange="updateRomType(this);" name="hotName">
              <option value="">----</option>
          <?php
          $sql="SELECT * FROM hotell;";
          $result = mysqli_query($conn,$sql);
          while($rad = mysqli_fetch_array($result)){
              echo("<option value='".$rad["hotellnavn"]."'>".$rad["hotellnavn"]."</option>");
          }
          ?>
          </select></td> 
    </tr>
    <tr>
        <td>Romtype</td>
        <td><select id="romType" name="romType">
            </select></td>
    </tr>
    <tr>
        <td>Bilde fil</td><td><input required name="file" type="file"></td>
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
    response.open("POST","getRomtypeByHotell.php?hotell="+x.value,true);
    response.onreadystatechange = function(){
        if(this.status == 200 && this.readyState == 4){
            document.getElementById("romType").innerHTML = this.responseText;
        }
    }
    response.send();
}
</script>
<?php 
if(isset($_POST["continue"])){
    $upFolder ="../uploads/";
    $picFile = $upFolder . basename($_FILES["file"]["name"]);
    $picFile = str_replace(" ","_","$picFile");
    $fileName = $_FILES["file"]["name"];
    $fileName = str_replace(" ","_","$fileName");
    $fileType = strtolower(pathinfo($picFile,PATHINFO_EXTENSION));
    $hotName = $_POST["hotName"];
    $romType = $_POST["romType"];
    
    $input = true;
    
    if(!$fileName){
        $input = false;
        echo("Du har ikke valgt fil til opplastning!<br>");
    }

    
    if(!$hotName || !$romType){
        $input = false;
        echo("Du må velge hotell og romtype!");
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
        echo ("Du kan ikke ha tegn i filnavn!<br>");   
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
    
    if(file_exists($picFile)){
        $input = false;
        echo("Filen eksisterer allerede <br>");
    }
    if($_FILES["file"]["size"] > 500000000){
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
        $sqlInsert = "INSERT INTO bilde (hotellnavn, romtype, filnavn) VALUES ('$hotName', '$romType', '$fileName');";
        mysqli_query($conn,$sqlInsert) or die ("Får ikke registrert i database!<br>");
        echo("Bilde med filnavn <b>" .basename($_FILES["file"]["name"]). "</b>, for romtype:<b>$romType</b> hos <b>$hotName</b>");
    }
    else {
        echo("Beklager noe gikk galt under opplastning!<br>");
    }
}
}




?>