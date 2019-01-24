<!doctype html>
<?php
//session_save_path("../includes/");
session_start(); ?>
    <?php include("db.inc.php"); ?>
    <?php include("../vedlikehold/slettPicNotInDB.php"); ?>
    <html lang="no">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/style.css">
        <link rel="stylesheet" type="text/css" href="https://home.usn.no/web-prg2-2018-01/includes/styleV.css">
        <title></title>
        <script src="events.js"></script>
        <script></script>
    </head>

    <body>
        <header>

        </header>
        <article class="grid" id="grid">
            <hero><a href="../nettsted/"><img id="hero" src="../includes/files/hero.png"></a></hero>
            <nav class="website-nav">
                <ul class="website-nav-ul" id="header-minside">
                    <?php
            if(isset($_SESSION["sess_userM"])){
                ?>      
                    <a href="index.php?loggut" class="website-nav-ul-a">
                            <li style="margin:-5px;margin-left:15px;padding:5px;background-color:#2d9cf0;border:1px solid #1f7bc1;" class="website-nav-ul-a-li">Logg ut</li>
                        </a>
                        <a href="minside.php" class="website-nav-ul-a">
                            <li class="website-nav-ul-a-li">Min-side</li>
                        </a>
                        
                        <a href="destinasjoner.php" class="website-nav-ul-a">
                            <li class="website-nav-ul-a-li">Destinasjoner</li>
                        </a>
                        <a href="../dokumentasjon/ekstra.txt" target="_blank" class="website-nav-ul-a">
                            <li class="website-nav-ul-a-li">Ekstrafunksjoner</li>
                        </a>

                        <?php
            } else {
            ?>
                            <a href="login.php" class="website-nav-ul-a">
                                <li class="website-nav-ul-a-li">Min side</li>
                            </a>
                            <a href="destinasjoner.php" class="website-nav-ul-a">
                                <li class="website-nav-ul-a-li">Destinasjoner</li>
                            </a>
                            <a href="ekstra.txt" target="_blank" class="website-nav-ul-a">
                                <li class="website-nav-ul-a-li">Ekstrafunksjoner</li>
                            </a>

                            <?php
            }
            ?>
                </ul>
            </nav>
