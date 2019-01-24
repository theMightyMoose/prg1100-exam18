<?php include("../includes/header.php");
include("../includes/db.inc.php");?>
<div class="content">
<div class="destinasjoner">
                <h1>Våre destinasjoner trykk på sted for å se hoteller vi tilbyr</h1>
            <?php 

            $SQL = "SELECT * FROM lokasjoner ORDER BY date;";
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
            </div></div>


<?php include("../includes/footer.php"); ?>