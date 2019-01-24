<?php
include("../includes/header.php");
if (!isset($_SESSION["sess_userM"])){
    header("location: login.php");
}
?>
<div class="main-content">
    <div class="minside-interface">
        <h1 class="padbot-10">Min-side</h1>
        <div id="minebestillinger" class="minebestillinger">
            <h3>Mine bestillinger</h3>
            <?php
            $sql = "SELECT * FROM bestillinger WHERE brukernavn = '" . $_SESSION['sess_userM'] . "' ORDER BY bestillingsid DESC;";
            $sqlResult = mysqli_query($conn, $sql);
            $sqlResultCheck = mysqli_num_rows($sqlResult);
            $resultCounter = 0;
            if ($sqlResultCheck){
            ?>
            <p>(Det er kun mulig å redigere eller kansellere fremtidige bestillinger)</p>
            <table class="orders" id="bookings">
                <tr class="orders-th">
                    <th>#</td>
                        <th>Hotell</th>
                        <th>Romtype</th>
                        <th>Fra</th>
                        <th>Til</th>
                        <th>Total</th>
                        <th>Romnr.</th>
                </tr>
                <?php
                while($row = mysqli_fetch_assoc($sqlResult)){
                    $user = $_SESSION['sess_userM'];
                    $order_id = $row["bestillingsid"];
                    $hotel_name = $row["hotellnavn"];
                    $room_type = $row["romtype"];
                    $check_in = date("Y-m-d",strtotime($row["fradato"]));
                    $check_out = date("Y-m-d",strtotime($row["tildato"]));
                    $price = $row["betpris"];
                    $room_nr = $row["romnr"];
                    $resultCounter++;
                ?>
                    <tr id="order<?php echo$resultCounter;?>">
                        <td id="bestillingsid<?php echo$resultCounter;?>">
                            <?php echo $order_id;?>
                        </td>
                        <td id="hotel_name<?php echo$resultCounter;?>">
                            <?php echo $hotel_name;?>
                        </td>
                        <td id="room_type<?php echo$resultCounter;?>">
                            <?php echo $room_type;?>
                        </td>
                        <td id="check_in<?php echo$resultCounter;?>">
                            <input type="date" readonly value="<?php echo date("Y-m-d",strtotime($row["fradato"]));?>">
                        </td>
                        <td id="check_out<?php echo$resultCounter;?>">
                            <input type="date" readonly value="<?php echo date("Y-m-d",strtotime($row["tildato"]));?>">
                        </td>
                        <td id="price<?php echo$resultCounter;?>">
                            <?php echo trim(strrev(chunk_split(strrev($price),3, ' ')));?>,-
                        </td>
                        <td id="room_nr<?php echo$resultCounter;?>">
                            <?php echo $room_nr;?>
                        </td>
                        <?php
                        if($check_in > date("Y-m-d")){
                        ?>
                        <td>
                            <img class="cursor-pointer" width='16px' src='../includes/files/edit-property-16.png' alt='Rediger bestilling' onclick="editOrder('<?php echo$resultCounter;?>','<?php echo $_SESSION['sess_userM'];?>',document.getElementById('bestillingsid<?php echo$resultCounter;?>').innerHTML, document.getElementById('hotel_name<?php echo$resultCounter;?>').innerHTML, document.getElementById('room_type<?php echo$resultCounter;?>').innerHTML, '<?php echo$check_in;?>', '<?php echo$check_out;?>', document.getElementById('price<?php echo$resultCounter;?>').innerHTML, document.getElementById('room_nr<?php echo$resultCounter;?>').innerHTML);">
                        </td>
                        <td>
                            <img class='cursor-pointer' width='18px' src='../includes/files/cancel-16.png' alt='Kanseller bestilling' onclick="openModal('cancel<?php echo $resultCounter;?>')">
                        </td>
                        <td id="loader<?php echo$resultCounter;?>"></td>
                        <?php
                        }
                        ?>
                        <div id="modal">
                            <div id="modalcancel<?php echo $resultCounter;?>" class="modal">
                                <div class="modal-content" id="modal-content">
                                    <span class="close" onclick="closeModal('cancel<?php echo $resultCounter;?>')">&times;</span>
                                    <h3 class="modal-title">Bekreft kansellering</h3>
                                    <div class="modal-entries" id="modal-entries">
                                        <div class="modal-center">
                                            <p id="cancel">Bekreft kansellering av bestilling #<?php echo $order_id;?>.</p>
                                            <div id="loader"></div>
                                            <input class="confirm-button" type="button" name="order-edit-confirm" value="Bekreft" onclick="cancelOrder('<?php echo $order_id;?>','<?php echo $user;?>')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                <?php
                }
            } else {
            ?>
            <p>Du har ingen bestillinger.</p>
            <?php
            }
            ?>
            </table>
        </div>
    </div>
    <div class="minside-menu">
        <ul class="minside-menu-ul">
            <li>Hei,
                <?php echo$_SESSION["sess_userM"];?>
            </li>
            <a href="minside.php" class="minside-menu-ul-a" href="#">
                <li>Bestill hotell</li>
            </a>
            <a href="bookings.php" class="minside-menu-ul-a" href="#">
                <li>Mine bestillinger</li>
            </a>
        </ul>
    </div>
</div>
<div id="ajax"></div>
<?php include("../includes/footer.php");?>
