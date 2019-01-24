<?php include("../includes/header.php");
include("../includes/db.inc.php");?>
<div class="content">
    <div class="intro-text">
        <textstuff>
            <h1 class="website-h1">Velkommen til Bjarvin Hotels!</h1>
            <p>Hos oss finner du de beste hotelltilbudene og de aller beste prisene! Start din bestilling ved å bruke menyen! Vi kan tilby 100% fornøyd garanti. Om du ikke blir fornøyd, brenner vi ned hotellet du hadde problemer med, slik at ingen andre opplever det samme. Vi har alltid kunden i fokus.</p>
        </textstuff>
        <img class="bjarvin" src="../includes/files/bjarvinhotels.gif">
    </div>
    <div class="gridBilder">
        <h1>Våre hoteller</h1>
        <?php 
        if(isset($_GET["loggut"])){
            session_destroy();
            echo("du er logget ut!");
            header("Location: index.php");
        }
        $SQL = "SELECT * FROM lokasjoner ORDER BY date DESC LIMIT 6;";
        $SQLfeedback = mysqli_query($conn, $SQL);
            $count = 0;
            while($row = mysqli_fetch_assoc($SQLfeedback)){
                if($count % 2 != 0){
                    echo("<div class='big-left'>");
                } else {
                    echo("<div class='big-right'>");
                }
                for($i=0; $i<3; $i++){
                    if($i != 0){
                        $row = mysqli_fetch_assoc($SQLfeedback);
                    }
                    if($row){
                        echo("<a href='searchLocation.php?location=".$row['sted']."'><div class='lokasjonerDiv big-$i' ><img class='lokasjoner' id='".$row['sted']."' src='../uploads/".$row['filnavn']."'><a href='searchLocation.php?location=".$row['sted']."' class='lokasjonerText'>".$row['sted']."</a></div></a>");
                    }
                }
                echo("</div>");
                $count++;
            }
        ?>
    </div>
    <?php include("order.php"); ?>
</div>
</article>
<?php include("../includes/footer.php");?>
