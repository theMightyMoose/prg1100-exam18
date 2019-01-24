<?php

function searchResult($user,$location,$hotel,$check_in,$check_out){
    include("../includes/db.inc.php");
    $in = new DateTime($check_in);
    $out = new DateTime($check_out);
    $count_days = $out->diff($in)->format("%a");
    $check_in_db = date('Y-m-d-H-i-s', strtotime('+12 hours',strtotime($check_in)));
    $check_out_db = date('Y-m-d-H-i-s', strtotime('+11 hours 59 minutes',strtotime($check_out)));
    $search_sql = "SELECT * FROM hotellromtype WHERE hotellnavn='$hotel'";
    $search_result = mysqli_query($conn, $search_sql);
    $search_resultCheck = mysqli_num_rows($search_result);
    if ($search_resultCheck){
        $entryCounter = 0;
        while($search_row = mysqli_fetch_assoc($search_result)){ //alle romtyper
            $search_hotel = $search_row["hotellnavn"];
            $search_room_type = $search_row["romtype"];
            $search_price = $search_row["pris"];
            $search_price = $search_price*$count_days;
            $search_price = strrev(chunk_split(strrev($search_price),3, ' '));
            if (strpos(substr($search_price, 0, 1), ' ') !== FALSE) {
                $search_price = substr($search_price,1);
            }
            $rooms_sql = "SELECT * FROM rom WHERE hotellnavn='$search_hotel' AND romtype='$search_room_type'";
            $rooms_result = mysqli_query($conn, $rooms_sql);
            $rooms_resultCheck = mysqli_num_rows($rooms_result);
            $entryCounter++;
            if($rooms_resultCheck){
                $orders_resultCheck = 0;
                $orders_sql = "SELECT * FROM bestillinger WHERE hotellnavn='$search_hotel' AND romtype='$search_room_type' AND (fradato <= '$check_out_db') AND (tildato >= '$check_in_db')"; //henter alle rom som er opptatt
                $orders_result = mysqli_query($conn, $orders_sql);
                $orders_resultCheck += mysqli_num_rows($orders_result);
                $vacant_rooms = $rooms_resultCheck-$orders_resultCheck;
                $selected_room_sql = "SELECT rom.romnr FROM rom WHERE hotellnavn='$search_hotel' AND romtype='$search_room_type' AND romnr NOT IN(SELECT romnr FROM bestillinger WHERE hotellnavn='$search_hotel' AND romtype='$search_room_type' AND (fradato <= '$check_out_db') AND (tildato >= '$check_in_db')) ORDER BY RAND() LIMIT 1;";
                /*
                finn alle romnummer som er booket i tidsperioden 
                    finn et romnummer som ikke er blant dem
                hvis ingen rom er booket i tidsperioden 
                    velg et hvilket som helst romnummer for romtypen
                */
                $selected_room_result = mysqli_query($conn,$selected_room_sql);
                $selected_room_row = mysqli_fetch_assoc($selected_room_result);
                $selected_room = $selected_room_row["romnr"];
                ?>
                <div class="result-entry">
                    <div class="result-entry-about">
                        <h3 class="title"><?php echo $search_hotel." - ".$search_room_type;?></h3>
                        <div class="thumbnail-container">
                            <div class="slideshow-container">
                            <?php
                            $img_sql = "SELECT filnavn FROM bilde WHERE hotellnavn='$search_hotel' AND romtype='$search_room_type'";
                            $img_result = mysqli_query($conn, $img_sql);
                            $img_resultCheck = mysqli_num_rows($img_result);
                            if($img_resultCheck){
                                $imgCounter=0;
                                while($img_row = mysqli_fetch_assoc($img_result)){ //alle registrerte bilder for hver romtype
                                    $imgCounter++;
                                    ?>
                                    <div class="imgSlider imgSlider<?php echo$entryCounter;?> fade">
                                        <div class="numbertext"><?php echo $imgCounter." / ".$img_resultCheck;?></div>
                                        <img src="../uploads/<?php echo $img_row["filnavn"];?>">
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <a class="prev" onclick="plusSlides(<?php echo$entryCounter;?>,-1)">&#10094;</a>
                                    <a class="next" onclick="plusSlides(<?php echo$entryCounter;?>,1)">&#10095;</a>
                                    <div style="text-align:center">
                                    <?php
                                    $imgs = 1;
                                    while ($imgs <= $imgCounter) {
                                        $imgs++;
                                        ?>
                                        <span class="dot dot<?php echo$entryCounter;?>"></span>
                                        <?php
                                    }
                                    ?>
                                    </div>
                                    <?php
                                } else { //no images available
                                    ?>
                                    <p>Ingen bilder tilgjengelig.</p>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                        <div class="result-entry-price">
                        <?php
                        if($vacant_rooms > 0){ //at least 1 vacant room
                            ?>
                            <p class="qntleft">Vi har <?php echo "$vacant_rooms";?> igjen til</p>
                            <p class="price"><?php echo $search_price;?> NOK</p>
                            <p class="small-text">for <?php echo $count_days; if($count_days==1){?> natt<?php } else { ?> netter<?php } ?></p>
                            <p class="small-text">inkludert skatter og avgifter</p>
                            <form method="post" action="">
                                <input name="user" type="hidden" value="<?php echo$user;?>">
                                <input name="hotel" type="hidden" value="<?php echo$search_hotel;?>">
                                <input name="room-type" type="hidden" value="<?php echo$search_room_type;?>">
                                <input name="check-in" type="hidden" value="<?php echo$check_in;?>">
                                <input name="check-out" type="hidden" value="<?php echo$check_out;?>">
                                <input name="price" type="hidden" value="<?php echo$search_price;?>">
                            </form>
                                <button class="search-button" id="modalBtn<?php echo$entryCounter;?>" onclick="openModal(<?php echo$entryCounter;?>)">Velg</button>
                                <div id="modal<?php echo$entryCounter;?>" class="modal">
                                    <div class="modal-content">
                                        <span class="close" onclick="closeModal(<?php echo$entryCounter;?>)">&times;</span>
                                        <h3 class="modal-title">Bekreft bestilling</h3>
                                        <div class="modal-entries" id="modal-entries">
                                            <div class="modal-left">
                                                <input type="text" readonly value="Hotell: ">
                                                <hr>
                                                <input type="text" readonly value="Rom: ">
                                                <hr>
                                                <input type="text" readonly value="Innsjekking: ">
                                                <hr>
                                                <input type="text" readonly value="Utsjekking: ">
                                                <hr>
                                                <input type="text" readonly value="Pris: ">
                                            </div>
                                            <div class="modal-right">
                                                <input type="text" readonly value="<?php echo$search_hotel?>">
                                                <hr>
                                                <input type="text" readonly value="<?php echo$search_room_type?>">
                                                <hr>
                                                <input type="text" readonly value="<?php echo$check_in?>">
                                                <hr>
                                                <input type="text" readonly value="<?php echo$check_out?>">
                                                <hr>
                                                <input type="text" readonly value="<?php echo$search_price?>,-">
                                                <input type="hidden" value="<?php echo$user;?>">
                                                <input type="hidden" value="<?php echo$location;?>">
                                                <?php $order_date = date('Y-m-d H:i:s');?>
                                            </div>
                                            <div class="modal-center">
                                                <input class="confirm-button" type="button" name="order-confirm" value="✔ Bekreft" onclick="confirmOrder(<?php echo "'".$entryCounter."','".$user."','".$location."','".$search_hotel."','".$search_room_type."','".$check_in."','".$check_out."','".$search_price."','".$selected_room."','".$order_date."'";?>)">
                                                <div id="loader<?php echo $entryCounter;?>"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="modal-confirm" class="modal">
                                </div>
                            <?php
                        } else {
                            ?>
                            <p class="sold-out">Helt fullt! Vi har ikke noe ledig på reisedatoene dine.</p>
                            <?php
                        }
                        ?>
                        </div>
                </div>
                <?php
            }
        }
    } else {
        echo "Det er ingen hotellrom registrert på dette hotellet. Vennligst prøv igjen senere.";
    }
}
function checkAvailability($n,$h,$r,$rn,$i,$o){
    $rn = trim($rn);
    include("../includes/db.inc.php");
    $orders_resultCheck = 0;
    $status = 1;
    $rooms_sql = "SELECT romnr FROM rom WHERE hotellnavn='$h' AND romtype='$r'"; //henter alle romnr
    $rooms_result = mysqli_query($conn, $rooms_sql);
    $rooms_resultCheck = mysqli_num_rows($rooms_result);
    while($rooms_row = mysqli_fetch_assoc($rooms_result)){
        $check_in_db = date('Y-m-d-H-i-s', strtotime('+12 hours',strtotime($i)));
        $check_out_db = date('Y-m-d-H-i-s', strtotime('+11 hours 59 minutes',strtotime($o)));
        $rooms_romnr = $rooms_row["romnr"];
        $status = 2;
    }
    // fradato (12:00) før eller samtidig som valgt check in (12:00) OG check out (11:59) etter eller samtidig som valgt check in (12:00)
    // tildato (11:59) før eller samtidig som valgt check out (11:59) OG check in (12:00) etter eller samtidig som valgt check out (11:59)
    $orders_sql = "SELECT * FROM bestillinger WHERE hotellnavn='$h' AND romtype='$r' AND romnr!='$rn' AND (fradato <= '$check_out_db') AND (tildato >= '$check_in_db')"; //henter alle rom som er opptatt og ikke er romnummeret til bestillingen man endrer
    $orders_result = mysqli_query($conn, $orders_sql);
    $orders_resultCheck += mysqli_num_rows($orders_result); 
    $status = 3;
    $selected_room_sql = "SELECT rom.romnr FROM rom WHERE hotellnavn='$h' AND romtype='$r' AND romnr NOT IN(SELECT romnr FROM bestillinger WHERE hotellnavn='$h' AND romtype='$r' AND romnr!='$rn' AND (fradato <= '$check_out_db') AND (tildato >= '$check_in_db')) ORDER BY RAND() LIMIT 1;";
    $vacant_rooms = $rooms_resultCheck-$orders_resultCheck;
    $selected_room_result = mysqli_query($conn,$selected_room_sql);
    $selected_room_resultCheck = mysqli_num_rows($orders_result); 
    $selected_room_row = mysqli_fetch_assoc($selected_room_result);
    $rn = $selected_room_row["romnr"];
    if($vacant_rooms > 0 && $rn){
        ?>
        <input type="hidden" id="new-room-number<?php echo $n;?>" value="<?php echo trim($rn);?>">
        <?php
    } else {
        return false;
    }
}