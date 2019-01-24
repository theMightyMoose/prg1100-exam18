<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">


    <table class="topNavHotRegEd">
        <tr>
            <td>
                <input class="btnRegHot btnTopNavRegEd" type="button" value="Registrer nytt hotell"  onClick="loadPage('regHotell.php')"></td>
            <td>
                <input class="btnUpdateChange btnTopNavRegEd" type="button" value="Oppdater endringer"  onClick="window.location.href=''">   
            </td>    
            
        </tr>
        <tr>
            <td>
                <input class="btnRegRomtype btnTopNavRegEd" type="button" value="Registrer ny romtype"  onClick="loadPage('regRomType.php')">    
            </td>
            <td><input class="btnRegRomtype btnTopNavRegEd" type="button" value="Endre romtype"  onClick="loadPage('editRomType.php')"> </td>
        </tr>
</table>        



<h2 class="h2Hot">Hoteller</h2>

   
  
<?php

$sql="SELECT * FROM hotell;";
$result = mysqli_query($conn,$sql);
while($rad = mysqli_fetch_array($result)){
    $hotell = $rad["hotellnavn"];
    $sted = $rad["sted"];
    ?>
    <table class='hotRegEd'>
    <tr>
    <td colspan ='3' class="colspan3width hotNavntxt"><b><?php echo($hotell);?></b></td>
    <td class='tblHotRegEd'><button onclick="loadPage('editHotell.php?hotell='+'<?php echo($hotell); ?>');" class='tblBtnReg hoverGrinRegEd'>Endre</button></td>
    </tr>
      <?php

    echo("<tr>
    <td><b>Sted:</b> ".$rad["sted"]."</td>
    </tr>");
    
    $sqlPic="SELECT * FROM lokasjoner WHERE sted='$sted';";
    $resultPic = mysqli_query($conn,$sqlPic);

    echo("<tr>
    <td colspan ='3' class='colspan3width'>");
    $radPic = mysqli_fetch_array($resultPic);
    if($sted = $radPic["sted"]){
        echo("<img class='tableImg' width='200px' src='../uploads/".$radPic["filnavn"]."'>");
    }     

    echo("</td>
    </tr>
    <tr>
    <td colspan ='3' class='colspan3width'><b>Etager:</b><br></td>
    <hr class='lineHot'>
    <td class='tblHotRegEd'>
    <button class='tblBtnEd hoverGrinRegEd' onclick='loadPage(`editRomEtg.php?hotell=`+`$hotell`);'>Endre</button></td><td>
    <button class='tblBtnReg hoverGrinRegEd' onclick='loadPage(`regEtg.php?hotell=`+`$hotell`);'>Registrer</button></td>
    </tr>");


    $sql2="SELECT * FROM etg WHERE hotellnavn='$hotell';";
    $result2 = mysqli_query($conn,$sql2);
    $countE = 0;
    while($rad2 = mysqli_fetch_array($result2)){
        $countE ++;
        if($hotell == $rad2["hotellnavn"]){
            if($countE == 1){
                echo("<tr><td>");
            }
            echo(" ".$rad2["prefix"]."-".$rad2["etgnr"]."(".$rad2["antallrom"]."), ");
            if($countE == 3){echo("</td></tr>");$countE = 0;}
        }     
    }

    echo("
    <tr>
    <td colspan ='3' class='colspan3width'><b>Romtyper:</b><br></td>
    <td class='tblHotRegEd'><button class='tblBtnEd hoverGrinRegEd' onclick='loadPage(`editHotellRomType.php?hotell=`+`$hotell`);'>Endre</button></td>
    <td><button class='tblBtnReg hoverGrinRegEd' onclick='loadPage(`regHotellRomType.php?hotell=`+`$hotell`);'>Registrer</button></td>
    </tr>");

    $sql3 ="SELECT * FROM hotellromtype WHERE hotellnavn='$hotell';";
    $result3 = mysqli_query($conn,$sql3);

    while($rad3 = mysqli_fetch_array($result3)){
        if($hotell = $rad3["hotellnavn"]){
            echo("<tr>
            <td colspan ='3' class='colspan3width'>".$rad3["romtype"]." (".$rad3["antallrom"].") Pris: ".$rad3["pris"]." NOK <br></td></tr>");
        }     
    }
    $antallrom = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(romnr) c FROM rom WHERE hotellnavn = '$hotell';"))["c"];
    echo("
    <tr><td colspan ='2' class='colspan3width'><b>Registrerte rom:</b> $antallrom<br></td>
    <td class='tblHotRegEd'>
    <button class='tblBtnVis hoverGrinRegEd' onclick='loadPage(`hotellvisRom.php?hotell=`+`$hotell`);'>Vis</button></td>
    <td><button class='tblBtnEd hoverGrinRegEd' onclick='loadPage(`editRom.php?hotell=`+`$hotell`);'>Endre</button></td>
    <td><button class='tblBtnReg hoverGrinRegEd' onclick='loadPage(`regRom.php?hotell=`+`$hotell`);'>Registrer</button></td>
    </tr>
    </table>");    
} 

 ?>
        <script>
            
        function loadPage(x){
            parent.document.getElementById("ob2").data = x;
        }

        </script>


        
        
        
        
        