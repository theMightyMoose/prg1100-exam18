<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">


<table class="topNavHotRegEd">
        <tr>
            <td><h2>Vis og Slett</h2></td>
        </tr>
        <tr>
            <td><input class="tblBtnEd hoverGrinRegEd" type="button" value="Hotell"  onClick="loadPage('visHotell.php')"></td>
        </tr>
        <tr>
            <td><input class="tblBtnEd hoverGrinRegEd" type="button" value="Romtype"  onClick="loadPage('visRomtype.php')"></td>
        </tr>
        <tr>
            <td><input class="tblBtnEd hoverGrinRegEd" type="button" value="Etage"  onClick="loadPage('visEtg.php')"></td>
        </tr>
        <tr>
            <td><input class="tblBtnEd hoverGrinRegEd" type="button" value="Hotellromtype"  onClick="loadPage('visHotellromtype.php')"></td>      
        </tr>
        <tr>
            <td><input class="tblBtnEd hoverGrinRegEd" type="button" value="Rom nr (registrerte rom)"  onClick="loadPage('visRom.php')"></td>      
        </tr>
        <tr>
            <td><input class="tblBtnEd hoverGrinRegEd" type="button" value="Registrerte kunder"  onClick="loadPage('visRegistrerteKunder.php')"></td>      
        </tr>
        <tr>
            <td><input class="tblBtnEd hoverGrinRegEd" type="button" value="Registrerte hotellbestillinger"  onClick="loadPage('visRegistrerteBestillinger.php')"></td>      
        </tr>
        
</table> 
       <script>
            
        function loadPage(x){
            parent.document.getElementById("ob2").data = x;
        }

        </script>


