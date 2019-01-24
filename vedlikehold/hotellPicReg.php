<?php include("../includes/db.inc.php"); ?>
<link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">


<table class="topNavHotRegEd">
        <tr>
            <td><h2>Bilderedigering</h2></td>
        </tr>
         <tr>
            <td><b>Bilde for hotell</b></td>
        </tr>
        <tr>
            <td><input class="tblBtnEd hoverGrinRegEd" type="button" value="Registrer"  onClick="loadPage('regPicture.php')"></td>
        </tr>
        <tr>
            <td><input class="tblBtnEd hoverGrinRegEd" type="button" value="Endre"  onClick="loadPage('editPicture.php')"></td>
        </tr>
        <tr>
            <td><input class="tblBtnEd hoverGrinRegEd" type="button" value="Vis og slett"  onClick="loadPage('visBilde.php')"></td>
        </tr>
        <tr>
            <td><b>Bilde for sted</b></td>
        </tr>
        <tr>
            <td><input class="tblBtnEd hoverGrinRegEd" type="button" value="Registrer"  onClick="loadPage('regPicturePlace.php')"></td>      
        </tr>
        <tr>
            <td><input class="tblBtnEd hoverGrinRegEd" type="button" value="Endre"  onClick="loadPage('editPicturePlace.php')"></td>      
        </tr>
         <tr>
            <td><input class="tblBtnEd hoverGrinRegEd" type="button" value="Vis og slett"  onClick="loadPage('visBildePlace.php')"></td>      
        </tr>
        
</table> 
       <script>
            
        function loadPage(x){
            parent.document.getElementById("ob2").data = x;
        }

        </script>


