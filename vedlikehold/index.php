<!doctype html>
<?php session_start(); ?>
<?php include("../includes/db.inc.php"); ?>
<html lang="no">

    <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/style.css">
    <link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">
    <title></title>
    <script></script>       
    </head>
<?php

if(isset($_POST["logout"])){
    session_destroy();
    header("location: login.php");
}

if(!isset($_SESSION["sess_userV"])){
    header("location: login.php");
}?>
<div class="mainV">
    <div  class="tLeftDiv"><a class="linkH2" href="index.php"><h2>Vedlikeholdsside</h2></a></div>
    <div class="userLoggOutV">
        
<?php
echo("Du er nå logget inn som <b>".$_SESSION["sess_userV"]."</b>");
?>
        <form action="" method="post">
            <input type="submit" value="LOGG UT" class="loggutbtn" name="logout">
        </form>
    </div>
    <div class="navBarV">
        <table>
            <tr class="navMtitle">
                <td colspan="2"><h4 class="menyV">Meny</h4></td>
            </tr>
            <tr>
                <td class="navbarKnappV1" onClick="loadPage('hotellRegEd.php')">Hoteller</td>
            </tr>
            <tr>
                <td class="navbarKnappV1" onClick="loadPage('hotellVisSlett.php')">Vis og slett</td>
            </tr>
            <tr>
                <td class="navbarKnappV1" onClick="loadPage('hotellPicReg.php')">Bildebehandler</td>
            </tr>
        </table>
    </div>
    <div class="mMidV">
        <h3 class="padding5LV h3V1">Vindu 1 <button class = "clearbtn" onclick="tømVindu('ob1');">Clear</button></h3>
        <hr class="hrV">
        <object id="ob1"></object>
    </div>
    <div class="rMidV">
        <h3 class="padding5LV h3V2">Vindu 2 <button class = "clearbtn" onclick="tømVindu('ob2');">Clear</button></h3>
        <hr class="hrV">
        <object id="ob2"></object>
        
    </div>
</div>
<script>
    function loadPage(x){
        document.getElementById("ob1").data = x;
    }
    
    function tømVindu(x){
        document.getElementById(x).data="";
    }
    
    
</script>

<?php include("../includes/footer.php");?>