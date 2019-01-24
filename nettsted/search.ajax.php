<?php
include("../includes/db.inc.php");
include("function.php");
$selected;
if(isset($_GET["location"])){
    $selected=$_GET["location"];
    $sql = "SELECT * FROM hotell WHERE sted='$selected'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck){
        while($row = mysqli_fetch_assoc($result)){
            echo "<option value='".$row['hotellnavn']."'>".$row['hotellnavn']."</option>";
        }
    }
    else {
        echo "<option value=''>--</option>";
    }
}

if(isset($_GET["hotel"])){
    $selected=$_GET["hotel"];
    $selected_hotel=$_GET["hotel"];
    $selected_hotel_sql="SELECT * FROM hotellromtype WHERE hotellnavn='$selected_hotel'";
    $selected_hotel_result = mysqli_query($conn, $selected_hotel_sql);
    $selected_hotel_result_check = mysqli_num_rows($selected_hotel_result);
    if($selected_hotel_result_check){
        while($selected_hotel_row=mysqli_fetch_assoc($selected_hotel_result)){
            echo "<option value='".$selected_hotel_row['romtype']."'>".$selected_hotel_row['romtype']."</option>";
        }
    } else {
        echo "<option value=''>--</option>";
    }
}

if(isset($_GET["new_booking"])){
    $e = $_GET["e"];
    $u = $_GET["u"];
    $l = $_GET["l"];
    $h = $_GET["h"];
    $r = $_GET["r"];
    $i = $_GET["i"];
    $o = $_GET["o"];
    $p = $_GET["p"];
    $rn = $_GET["rn"];
    $od = $_GET["od"];
    $check_in = date('Y-m-d-H-i-s', strtotime('+12 hours',strtotime($i)));
    $check_out = date('Y-m-d-H-i-s', strtotime('+11 hours 59 minutes',strtotime($o)));
    $price = str_replace(' ', '',$p);
    $sql = "INSERT INTO bestillinger (brukernavn, hotellnavn, romtype, fradato, tildato, betpris, romnr, dato) VALUES ('$u','$h','$r','$check_in','$check_out','$price','$rn','$od');";
    mysqli_query($conn,$sql) or die ($sql);
    ?>
    <div class="modal-content">
        <span class="close" onclick="closeModal('-confirm')">&times;</span>
        <h3 class="modal-title">Bestilling registrert</h3>
        <div class="modal-entries">
            <div class="modal-center">
                <p>Din hotellrombooking er fullført! Ditt romnummer er <?php echo $rn;?>.</p>
                <input class="confirm-button" type="button" name="order-edit-confirm" value="Lukk" onclick="closeModal('-confirm');">
                <div id="loader<?php echo $e;?>"></div>
            </div>
        </div>
    </div>
    <?php
    echo"|$|";
    searchResult($u,$l,$h,$i,$o);
}

if(isset($_GET["login"])){
    if(isset($_SESSION["sess_userM"])){
        $username = $_SESSION["sess_userM"];
    }
    if(isset($_GET["username"])){
        $username = $_GET["username"];
    }
    $password = $_GET["password"];
    $selected_location = $_GET["selected_location"];
    $selected_hotel = $_GET["selected_hotel"];
    $check_in = $_GET["check_in"];
    $check_out = $_GET["check_out"];
    $sql = "SELECT passord FROM minside WHERE brukernavn='$username';";
    $sqlResult=mysqli_query($conn,$sql) or die ("Ikke tilgang til database!<br>");
    $rows=mysqli_num_rows($sqlResult);
    ?>
    <h3 class="modal-title">Logg inn</h3>
    <div class="modal-entries" id="modal-entries"><?php
    if($rows <= 1){
        if($password==mysqli_fetch_array($sqlResult)[0]){
            $_SESSION["sess_userM"] = $username;
            $user = $_SESSION["sess_userM"];
            echo "<p class='modal-left'>Du er logget inn.</p><div class='modal-right'></div>";
            ?>
            <form method="get" action="searchResults.php">
                <input type="hidden" name="user" value="<?php echo$user;?>">
                <input type="hidden" name="selected-location" value="<?php echo$selected_location;?>">
                <input type="hidden" name="selected-hotel" value="<?php echo$selected_hotel;?>">
                <input type="hidden" name="check-in" value="<?php echo$check_in;?>">
                <input type="hidden" name="check-out" value="<?php echo$check_out;?>">
                <input class="search-button" type="submit" name="search" value="Gå til søk">
            </form>
            <?php
        } else {
            ?>
            <div class="modal-left">
                <input type="text" readonly value="Brukernavn: ">
                <hr>
                <input type="text" readonly value="Passord: ">
            </div>
            <div class="modal-right">
                <input type="text" id="username">
                <hr>
                <input type="password" id="password" placeholder="***">
            </div>
            <div class="modal-center">
                <input class="confirm-button" type="button" name="order-confirm" value="Logg inn" onclick="confirmLogin(document.getElementById('username').value, document.getElementById('password').value, document.getElementById('selected-location').value, document.getElementById('selected-hotel').value,document.getElementById('check-in').value,document.getElementById('check-out').value);">
                <input class="confirm-button" type="button" name="order-confirm" value="Registrer" onclick="sessionSearch(0,0,document.getElementById('selected-location').value, document.getElementById('selected-hotel').value,document.getElementById('check-in').value,document.getElementById('check-out').value);">
                <p>Feil brukernavn eller passord</p>
            </div>
            <?php
        }
    } else {
        echo "Fant ikke bruker!";
    }
    ?>
    </div><?php
}

if(isset($_GET["reg_ses"])){
    $_SESSION["reg_ses_u"] = $_GET["reg_ses_u"];
    $_SESSION["reg_ses_p"] = $_GET["reg_ses_p"];
    $_SESSION["reg_ses_l"] = $_GET["reg_ses_l"];
    $_SESSION["reg_ses_h"] = $_GET["reg_ses_h"];
    $_SESSION["reg_ses_i"] = $_GET["reg_ses_i"];
    $_SESSION["reg_ses_o"] = $_GET["reg_ses_o"];
    $u = $_GET["reg_ses_u"];
    $p = $_GET["reg_ses_p"];
    $l = $_GET["reg_ses_l"];
    $h = $_GET["reg_ses_h"];
    $i = $_GET["reg_ses_i"];
    $o = $_GET["reg_ses_o"];
    ?>
    <span class="close" onclick="closeModal(1)">&times;</span>
    <h3 class="modal-title">Registrer bruker</h3>
    <div class="modal-entries" id="modal-entries">
    <?php
    if($u!="0" && $p!="0"){
        $username=$u;
        $password=$p;
        $sql = "SELECT * FROM minside WHERE brukernavn = '$username';";
        $result = mysqli_query($conn,$sql) or die ("Får ikke koblet til databasen!<br>");
        $rows = mysqli_num_rows($result);
        if($rows > 0){?>
            <div class="modal-left">
                <input type="text" readonly value="Brukernavn: ">
                <hr>
                <input type="text" readonly value="Passord: ">
            </div>
            <div class="modal-right">
                <input type="text" placeholder="brukernavn" id="username" name="reguser">
                <hr>
                <input type="password" placeholder="passord" id="password" name="regpass">
                <input type="hidden" id="selected-location" name="selected-location" value="<?php echo$l;?>">
                <input type="hidden" id="selected-hotel" name="selected-hotel" value="<?php echo$h;?>">
                <input type="hidden" id="check-in" name="check-in" value="<?php echo$i;?>">
                <input type="hidden" id="check-out" name="check-out" value="<?php echo$o;?>">
            </div>
            <div class="modal-center">
                <input class="confirm-button" type="button" name="register-confirm" value="Registrer" onclick="confirmRegister(document.getElementById('username').value,document.getElementById('password').value,document.getElementById('selected-location').value, document.getElementById('selected-hotel').value,document.getElementById('check-in').value,document.getElementById('check-out').value);">
                <p>Brukeren er allerede registrert.</p>
            </div>
        </div><?php
        } else {
            $sql = "INSERT INTO minside (brukernavn, passord) VALUES ('$username','$password');";
            mysqli_query($conn,$sql) or die ("Får ikke registrert i databasen!<br>");
            ?>
            <div class="modal-left">
                <input type="text" readonly id="username" name="username" style="width: 100%;" value="<?php echo$u." er registrert.";?>">
            </div>
            <div class="modal-right">
                <input type="hidden" id="password" name="password" value="<?php echo$p;?>">
                <input type="hidden" id="selected-location" name="selected-location" value="<?php echo$l;?>">
                <input type="hidden" id="selected-hotel" name="selected-hotel" value="<?php echo$h;?>">
                <input type="hidden" id="check-in" name="check-in" value="<?php echo$i;?>">
                <input type="hidden" id="check-out" name="check-out" value="<?php echo$o;?>">
            </div>
            <input class="confirm-button" type="button" name="order-confirm" value="Logg inn" onclick="confirmLogin(document.getElementById('username').value, document.getElementById('password').value, document.getElementById('selected-location').value, document.getElementById('selected-hotel').value,document.getElementById('check-in').value,document.getElementById('check-out').value);">
            <?php
        }
    } else {
    ?>
        <div class="modal-left">
            <input type="text" readonly value="Brukernavn: ">
            <hr>
            <input type="text" readonly value="Passord: ">
        </div>
        <div class="modal-right">
            <input type="text" placeholder="brukernavn" id="1username" name="reguser">
            <hr>
            <input type="password" placeholder="passord" id="1password" name="regpass">
            <input type="hidden" id="1selected-location" name="selected-location" value="<?php echo$l;?>">
                <input type="hidden" id="1selected-hotel" name="selected-hotel" value="<?php echo$h;?>">
                <input type="hidden" id="1check-in" name="check-in" value="<?php echo$i;?>">
                <input type="hidden" id="1check-out" name="check-out" value="<?php echo$o;?>">
        </div>
        <div class="modal-center">
            <input class="confirm-button" type="button" name="register-confirm" value="Registrer" onclick="confirmRegister(document.getElementById('1username').value,document.getElementById('1password').value,document.getElementById('1selected-location').value, document.getElementById('1selected-hotel').value,document.getElementById('1check-in').value,document.getElementById('1check-out').value);">
        </div>
    </div>
    <?php
    }
}

if(isset($_GET["minside_login"])){
    $username = $_GET["username"];
    $password = $_GET["password"];
    $sql = "SELECT passord FROM minside WHERE brukernavn='$username';";
    $sqlResult=mysqli_query($conn,$sql) or die ("Ikke tilgang til database!<br>");
    $rows=mysqli_num_rows($sqlResult);
    if($rows = 1){
        if($password==mysqli_fetch_array($sqlResult)[0]){
            $_SESSION["sess_userM"] = $username;
            $user = $_SESSION["sess_userM"];
            echo "<p class='modal-left'>Du er logget inn.</p><div class='modal-right'></div>";
            ?>
            <form method="get" action="minside.php">
                <input type="hidden" name="user" value="<?php echo$user;?>">
                <input class="search-button" type="submit" name="search" value="Min side">
            </form>
            <?php
        } else { //invalid password
            ?>
            <div class="modal-left">
                <input type="text" readonly value="Brukernavn: ">
                <hr>
                <input type="text" readonly value="Passord: ">
            </div>
            <div class="modal-right">
                <input type="text" id="username">
                <hr>
                <input type="password" id="password">
            </div>
            <div class="modal-center">
                <input class="confirm-button" type="button" name="order-confirm" value="Logg inn" onclick="login(document.getElementById('username').value,document.getElementById('password').value);">
            </div>
            <?php
        }
    }
}
if(isset($_GET["minside_register"])){
    $u = $_GET["u"];
    $p = $_GET["p"];
    ?>
    <h3 class="modal-title">Registrer bruker</h3>
    <div class="modal-entries" id="modal-entries">
    <?php
    if($u!="0" && $p!="0"){
        $username=$u;
        $password=$p;
        $sql = "SELECT * FROM minside WHERE brukernavn = '$username';";
        $result = mysqli_query($conn,$sql) or die ("Får ikke koblet til databasen!<br>");
        $rows = mysqli_num_rows($result);
        if($rows > 0){?>
            <div class="modal-left">
                <input type="text" readonly value="Brukernavn: ">
                <hr>
                <input type="text" readonly value="Passord: ">
            </div>
            <div class="modal-right">
                <input type="text" placeholder="brukernavn" id="username" name="reguser">
                <hr>
                <input type="password" placeholder="passord" id="password" name="regpass">
                <input type="hidden" id="selected-location" name="selected-location" value="<?php echo$l;?>">
                <input type="hidden" id="selected-hotel" name="selected-hotel" value="<?php echo$h;?>">
                <input type="hidden" id="check-in" name="check-in" value="<?php echo$i;?>">
                <input type="hidden" id="check-out" name="check-out" value="<?php echo$o;?>">
            </div>
            <div class="modal-center">
                <input class="confirm-button" type="button" name="register-confirm" value="Registrer" onclick="confirmRegister(document.getElementById('username').value,document.getElementById('password').value,document.getElementById('selected-location').value, document.getElementById('selected-hotel').value,document.getElementById('check-in').value,document.getElementById('check-out').value);">
            </div>
        </div><?php
        } else {
            $sql = "INSERT INTO minside (brukernavn, passord) VALUES ('$username','$password');";
            mysqli_query($conn,$sql) or die ("Får ikke registrert i databasen!<br>");
            ?>
            <div class="modal-left">
                <input type="text" readonly id="username" name="username" style="width: 100%;" value="<?php echo$u." er registrert.";?>">
            </div>
            <div class="modal-right">
                <input type="hidden" id="password" name="password" value="<?php echo$p;?>">
                <input type="hidden" id="selected-location" name="selected-location" value="<?php echo$l;?>">
                <input type="hidden" id="selected-hotel" name="selected-hotel" value="<?php echo$h;?>">
                <input type="hidden" id="check-in" name="check-in" value="<?php echo$i;?>">
                <input type="hidden" id="check-out" name="check-out" value="<?php echo$o;?>">
            </div>
            <input class="confirm-button" type="button" name="order-confirm" value="Logg inn" onclick="login(document.getElementById('username').value,document.getElementById('password').value);">
            <?php
        }
    } else {
        ?>
        <div class="modal-left">
            <input type="text" readonly value="Brukernavn: ">
            <hr>
            <input type="text" readonly value="Passord: ">
        </div>
        <div class="modal-right">
            <input type="text" placeholder="brukernavn" id="username" name="reguser">
            <hr>
            <input type="password" placeholder="passord" id="password" name="regpass">
        </div>
        <div class="modal-center">
            <input class="confirm-button" type="button" name="register-confirm" value="Registrer" onclick="register(document.getElementById('username').value,document.getElementById('password').value);">
        </div>
    </div>
    <?php
    }
}

if(isset($_GET["date"])){
    $selected=$_GET["date"];
    echo $selected;
}
if(isset($_GET["edit_order"])){
    $order_nr = $_GET["edit_order"];
    $user = $_GET["user"];
    $edit_order = $_GET["order"];
    $order_id = $_GET["order_id"];
    $hotel = trim($_GET["edit_hotel"]);
    $room_type = trim($_GET["edit_room_type"]);
    $check_in = $_GET["check_in"];
    $check_out = $_GET["check_out"];
    $price = $_GET["price"];
    $price_db = str_replace(str_split(" ,-"), "", $price);
    $room_nr = $_GET["room_nr"];
    
    $sql = "SELECT * FROM bestillinger WHERE brukernavn = '$user' ORDER BY bestillingsid DESC";
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck){
        $counter=1;
        ?>
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
        while($row = mysqli_fetch_array($result)){
            
            ?>
            <tr id="order<?php echo$counter;?>">
                <?php
                if($row["bestillingsid"]==trim($order_id)){
                    ?>
                    <td id="bestillingsid<?php echo$edit_order;?>"><?php echo$order_id;?></td>
                    <td id="hotel_name<?php echo$edit_order;?>"><?php echo$hotel;?></td>
                    <td id="room_type<?php echo$edit_order;?>">
                        <select name="new_room_type" id="new-room-type<?php echo$edit_order;?>" onchange="updatePrice('<?php echo$order_nr;?>','&user=<?php echo $user;?>','&order-id=<?php echo trim($order_id);?>','price<?php echo$edit_order;?>','&selected-hotel=<?php echo$hotel;?>','&new-room-type='+this.value,'&current-room-number=<?php echo trim($room_nr);?>','&current-check-in='+document.getElementById('new-check-in<?php echo$edit_order;?>').value,'&current-check-out='+document.getElementById('new-check-out<?php echo$edit_order;?>').value);">
                            <option value="<?php echo$room_type;?>"><?php echo$room_type;?></option>
                    <?php
                            $select_sql = "SELECT romtype FROM hotellromtype WHERE hotellnavn = '$hotel' && romtype NOT LIKE '$room_type'";
                            $select_result = mysqli_query($conn,$select_sql);
                            while($select_row = mysqli_fetch_array($select_result)){
                            ?>
                            <option value="<?php echo$select_row["romtype"];?>"><?php echo$select_row["romtype"];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                    <td id="check_in<?php echo$edit_order;?>">
                        <input type="date" class="order-date" name="check-in" id="new-check-in<?php echo$edit_order;?>" onchange='updatePrice("<?php echo$order_nr;?>","&user=<?php echo $user;?>","&order-id=<?php echo$order_id;?>","price<?php echo$edit_order;?>","&selected-hotel=<?php echo$hotel;?>","&current-room-type="+document.getElementById("new-room-type<?php echo$edit_order;?>").value,"&current-room-number=<?php echo$room_nr;?>","&new-check-in="+this.value,"&current-check-out="+document.getElementById("new-check-out<?php echo$edit_order;?>").value);' min="<?php echo date('Y-m-d',strtotime('+1 Day',strtotime(date('Y-m-d'))));?>" max="<?php echo date('Y-m-d',strtotime('-1 Day',strtotime($check_out)));?>" value="<?php echo$check_in;?>">
                    </td>
                    <td id="check_out<?php echo$edit_order;?>">
                        <input type="date" class="order-date" name="check-out" id="new-check-out<?php echo$edit_order;?>" onchange='updatePrice("<?php echo$order_nr;?>","&user=<?php echo $user;?>","&order-id=<?php echo$order_id;?>","price<?php echo$edit_order;?>","&selected-hotel=<?php echo$hotel;?>","&current-room-type="+document.getElementById("new-room-type<?php echo$edit_order;?>").value,"&current-room-number=<?php echo$room_nr;?>","&current-check-in="+document.getElementById("new-check-in<?php echo$edit_order;?>").value,"&new-check-out="+this.value);' min="<?php echo date('Y-m-d',strtotime('+1 Day',strtotime($check_in)));?>" value="<?php echo$check_out;?>">
                    </td>
                    <td id="price<?php echo$edit_order;?>"><input type="hidden" name="price<?php echo $edit_order;?>" value=""><?php echo$price;?></td>
                    <td id="room_nr<?php echo$edit_order;?>"><?php echo$room_nr;?></td>
                    <td id="confirm-edit"><img class='cursor-pointer' width='18px' src='../includes/files/ok-16.png' alt='Konfirmer endring' onclick="unedit('<?php echo$order_nr;?>','<?php echo $user;?>','<?php echo $hotel;?>','<?php echo $order_id;?>',document.getElementById('new-room-type<?php echo $edit_order;?>').value,document.getElementById('new-check-in<?php echo $edit_order;?>').value,document.getElementById('new-check-out<?php echo $edit_order;?>').value,'<?php echo $price_db;?>',document.getElementById('room_nrorder<?php echo $order_nr;?>').innerHTML);">
                    <!--onclick="openModal('<?php //echo$edit_order;?>');"--></td>
                    <td><img class='cursor-pointer' width='18px' src='../includes/files/cancel-16.png' alt='Kanseller bestilling' onclick="openModal('cancel<?php echo $order_nr;?>')"></td>
                    <td id="loader<?php echo$order_nr;?>"></td>
                    <div id="modal<?php echo$edit_order;?>" class="modal">
                        <div class="modal-content" id="modal-content">
                            <span class="close" onclick="closeModal('<?php echo$edit_order;?>')">&times;</span>
                            <h3 class="modal-title">Bekreft endring</h3>
                            <div class="modal-entries" id="modal-entries">
                                <div class="modal-center">
                                    <p id="no-edits">Du har ikke gjort noen endringer. </p>
                                    <input class="confirm-button" type="button" name="order-edit-confirm" value="Lukk" onclick="closeModal('<?php echo$edit_order;?>')">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="modalcancel<?php echo $order_nr;?>" class="modal">
                        <div class="modal-content" id="modal-content">
                            <span class="close" onclick="closeModal('cancel<?php echo $order_nr;?>')">&times;</span>
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
                    <td id="modalerror" class="modal">
                        <div class="modal-content" id="modal-content">
                            <span class="close" onclick="closeModal('error')">&times;</span>
                            <h3 class="modal-title">Bekreft endring</h3>
                            <div class="modal-entries" id="modal-entries">
                                <div class="modal-center">
                                    <p>Vi har ingen ledige rom av denne typen i den valgte tidsperioden!</p>
                                    <input class="confirm-button" type="button" name="order-edit-confirm" value="Lukk" onclick="closeModal('error')">
                                </div>
                            </div>
                        </div>
                    </td>
                    <?php
                } else {
                    ?>
                    <td id="bestillingsid<?php echo$counter;?>"><?php echo$row["bestillingsid"];?></td>
                    <td id="hotel_name<?php echo$counter;?>"><?php echo$row["hotellnavn"];?></td>
                    <td id="room_type<?php echo$counter;?>"><?php echo$row["romtype"];?></td>
                    <td id="check_in<?php echo$counter;?>"><input type="date" readonly value="<?php echo date("Y-m-d",strtotime($row["fradato"]));?>"></td>
                    <td id="check_out<?php echo$counter;?>"><input type="date" readonly value="<?php echo date("Y-m-d",strtotime($row["tildato"]));?>"></td>
                    <td id="price<?php echo$counter;?>"><?php echo strrev(chunk_split(strrev($row["betpris"]),3, ' '));?>,-</td>
                    <td id="room_nr<?php echo$counter;?>"><?php echo$row["romnr"];?></td>
                    <?php
                    if($check_in > date("Y-m-d")){
                    ?>
                    <td><img class="cursor-pointer" width='16px' src='../includes/files/edit-property-16.png' alt='Rediger bestilling' onclick="editOrder('<?php echo$counter;?>','<?php echo $user;?>',document.getElementById('bestillingsid<?php echo$counter;?>').innerHTML, document.getElementById('hotel_name<?php echo$counter;?>').innerHTML, document.getElementById('room_type<?php echo$counter;?>').innerHTML, '<?php echo date("Y-m-d",strtotime($row["fradato"]));?>', '<?php echo date("Y-m-d",strtotime($row["tildato"]));?>', <?php echo$row["betpris"];?>, document.getElementById('room_nr<?php echo$counter;?>').innerHTML);"></td>
                    <td><img class='cursor-pointer' width='18px' src='../includes/files/cancel-16.png' alt='Kanseller bestilling' onclick="openModal('cancel<?php echo $counter;?>')"></td>
                    <td id="loader<?php echo$counter;?>"></td>
                    <?php
                    }
                }
                ?>
            </tr>
            <?php
            $counter++;
        }
    }
}
if(isset($_GET["update_price"])){
    $order_nr = trim($_GET["update_price"]);
    $user = $_GET["user"];
    $edit_order = "order".$order_nr;
    $order_id = $_GET["order-id"];
    $hotel = $_GET["selected-hotel"];
    $room_number = $_GET["current-room-number"];
    if(isset($_GET["new-room-type"])){
        $edit_room_type = $_GET["new-room-type"];
    } else {
        $edit_room_type = $_GET["current-room-type"];
    }
    if(isset($_GET["new-check-in"])){
        $check_in = $_GET["new-check-in"];
    } else {
        $check_in = $_GET["current-check-in"];
    }
    if(isset($_GET["new-check-out"])){
        $check_out = $_GET["new-check-out"];
    } else {
        $check_out = $_GET["current-check-out"];
    }
    
    $in = new DateTime($check_in);
    $out = new DateTime($check_out);
    $count_days = $out->diff($in)->format("%a");
    $sql = "SELECT pris FROM hotellromtype WHERE hotellnavn='$hotel' AND romtype='$edit_room_type'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck){
        while($row = mysqli_fetch_array($result)){
            $price = $count_days*$row["pris"];
        }
    }
    ?>
    <input type="date" class="order-date" name="check-in" id="new-check-in<?php echo$edit_order;?>" onchange='updatePrice("<?php echo$order_nr;?>","&user=<?php echo $user;?>","&order-id=<?php echo$order_id;?>","price<?php echo$edit_order;?>","&selected-hotel=<?php echo$hotel;?>","&current-room-type="+document.getElementById("new-room-type<?php echo$edit_order;?>").value,"&current-room-number=<?php echo$room_number;?>","&new-check-in="+this.value,"&current-check-out="+document.getElementById("new-check-out<?php echo$edit_order;?>").value);'min="<?php echo date('Y-m-d',strtotime('+1 Day',strtotime(date('Y-m-d'))));?>" max="<?php echo date('Y-m-d',strtotime('-1 Day',strtotime($check_out)));?>" value="<?php echo$check_in;?>">
    <?php
    echo "|$|";
    ?>
    <input type="date" class="order-date" name="check-out" id="new-check-out<?php echo$edit_order;?>" onchange='updatePrice("<?php echo$order_nr;?>","&user=<?php echo $user;?>","&order-id=<?php echo$order_id;?>","price<?php echo$edit_order;?>","&selected-hotel=<?php echo$hotel;?>","&current-room-type="+document.getElementById("new-room-type<?php echo$edit_order;?>").value,"&current-room-number=<?php echo$room_number;?>","&current-check-in="+document.getElementById("new-check-in<?php echo$edit_order;?>").value,"&new-check-out="+this.value);' min="<?php echo date('Y-m-d',strtotime('+1 Day',strtotime($check_in)));?>" value="<?php echo$check_out;?>">
    <?php
    echo "|$|";
    ?>
    <input type="hidden" name="price<?php echo $edit_order;?>" value="<?php echo$price;?>"><?php echo strrev(chunk_split(strrev($price),3, ' ')).",-";?></td>
    <?php
    echo "|$|"; //skilletegn for responseText
    $availability = checkAvailability($order_nr,$hotel,$edit_room_type,$room_number,$check_in,$check_out);
    if($availability!==false){
        ?>
        <td><img class='cursor-pointer' width='18px' src='../includes/files/ok-16.png' alt='Konfirmer endring' onclick='openModal("order<?php echo$order_nr;?>");'></td>
        <?php
    } else {
        ?>
        <td><img class='cursor-pointer' width='18px' src='../includes/files/warning-16.png' alt='Konfirmer endring' onclick='openModal("error");'></td>
        <?php
    }
    echo "|$|";
    ?>
    <div class="modal-content" id="modal-content">
        <span class="close" onclick="closeModal('<?php echo$edit_order;?>')">&times;</span>
        <h3 class="modal-title">Bekreft endring</h3>
        <div class="modal-entries" id="modal-entries">
            <div class="modal-center">
                <p>Er du sikker på at du vil gjennomføre denne endringen?</p>
                <p id="new-edit-price">Ny pris: <?php echo strrev(chunk_split(strrev($price),3, ' ')).",-";?></p>
                <input class="confirm-button" type="button" name="order-edit-confirm" value="Bekreft" onclick="confirmEditOrder('<?php echo$order_nr;?>','<?php echo $user;?>','<?php echo $hotel;?>','<?php echo$order_id;?>',document.getElementById('new-room-type<?php echo$edit_order;?>').value,document.getElementById('new-check-in<?php echo$edit_order;?>').value,document.getElementById('new-check-out<?php echo$edit_order;?>').value,'<?php echo $price;?>',document.getElementById('new-room-number<?php echo$order_nr;?>').value);">
            </div>
        </div>
    </div>
<?php
}

if(isset($_GET["confirm_edit_order"])){
    $order_nr = $_GET["confirm_edit_order"];
    $user = $_GET["user"];
    $edit_hotel = $_GET["edit_hotel"];
    $order_id = $_GET["order_id"];
    $edit_room_type = $_GET["edit_room_type"];
    $check_in = $_GET["check_in"];
    $check_out = $_GET["check_out"];
    $check_in_db = date('Y-m-d-H-i-s', strtotime('+12 hours',strtotime($check_in)));
    $check_out_db = date('Y-m-d-H-i-s', strtotime('+11 hours 59 minutes',strtotime($check_out)));
    $price = $_GET["price"];
    $room_number = $_GET["room_number"];
    //update database table
    $sql = "UPDATE bestillinger SET romtype ='" . $edit_room_type . "', fradato = '" . $check_in_db . "', tildato ='" . $check_out_db . "', betpris = '" . $price . "', romnr = '" . $room_number . "' WHERE bestillingsid = '$order_id';";
    mysqli_query($conn,$sql) or die (mysqli_error($conn));
    //echo table row
    ?>
    <td id="bestillingsid<?php echo$order_nr;?>"><?php echo$order_id;?></td>
    <td id="hotel_name<?php echo$order_nr;?>"><?php echo$edit_hotel;?></td>
    <td id="room_type<?php echo$order_nr;?>"><?php echo$edit_room_type;?></td>
    <!--<td id="check_in<?php echo$order_nr;?>"><?php //echo date("d-m-Y",strtotime($check_in));?></td>
    <td id="check_out<?php echo$order_nr;?>"><?php //echo date("d-m-Y",strtotime($check_out));?></td>-->
    <td id="check_in<?php echo$resultCounter;?>"><input type="date" readonly value="<?php echo date('Y-m-d',strtotime('+12 hours',strtotime($check_in)));?>"></td>
    <td id="check_out<?php echo$resultCounter;?>"><input type="date" readonly value="<?php echo date('Y-m-d',strtotime('+11 hours 59 minutes',strtotime($check_out)));?>"></td>
    <td id="price<?php echo$order_nr;?>"><?php echo strrev(chunk_split(strrev($price),3, ' ')).",-";?></td>
    <td id="room_nr<?php echo$order_nr;?>"><?php echo$room_number;?></td>
    <?php
    if($check_in > date("Y-m-d")){
        ?>
        <td><img  class="cursor-pointer" width='16px' src='../includes/files/edit-property-16.png' alt='Rediger bestilling' onclick="editOrder('<?php echo$order_nr;?>','<?php echo $user;?>',document.getElementById('bestillingsid<?php echo$order_nr;?>').innerHTML, document.getElementById('hotel_name<?php echo$order_nr;?>').innerHTML, document.getElementById('room_type<?php echo$order_nr;?>').innerHTML, '<?php echo$check_in;?>', '<?php echo$check_out;?>', document.getElementById('price<?php echo$order_nr;?>').innerHTML, document.getElementById('room_nr<?php echo$order_nr;?>').innerHTML);"></td>
        <!--<td><img width='16px' src='../includes/files/edit.png' alt='Rediger bestilling' onclick="editOrder('order<?php echo$order_nr;?>','8600080','Scandic Park','Dobbeltrom','2018-09-03','2018-09-04','1085','102');"></td>-->
        <td><img class='cursor-pointer' width='18px' src='../includes/files/cancel-16.png' alt='Kanseller bestilling' onclick="openModal('cancel<?php echo $order_nr;?>')"></td>
        <td id="loader<?php echo$order_nr;?>"></td>
        <div id="modal<?php echo $order_nr;?>">
            <div id="modalcancel<?php echo $order_nr;?>" class="modal">
                <div class="modal-content" id="modal-content">
                    <span class="close" onclick="closeModal('cancel<?php echo $order_nr;?>')">&times;</span>
                    <h3 class="modal-title">Bekreft kansellering</h3>
                    <div class="modal-entries" id="modal-entries">
                        <div class="modal-center">
                            <p id="new-edit-price">Bekreft kansellering av bestilling #<?php echo $order_id;?>.</p>
                            <div id="loader"></div>
                            <input class="confirm-button" type="button" name="order-edit-confirm" value="Bekreft" onclick="cancelOrder('<?php echo $order_id;?>','<?php echo $user;?>')">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <?php
    echo "|$|";
    //echo modal confirmation
    ?>
    <div id="modalsc" class="modal open">
        <div class="modal-content" id="modal-content">
            <span class="close" onclick="closeModal('sc')">&times;</span>
            <h3 class="modal-title">Endring utført</h3>
            <div class="modal-entries" id="modal-entries">
                <div class="modal-center">
                    <p>Du endret bestilling #<?php echo $order_id;?>!</p>
                    <p id="new-edit-price">Ditt nye romnummer er <?php echo $room_number;?>.</p>
                    <input class="confirm-button" type="button" name="order-edit-confirm" value="Lukk" onclick="closeModal('sc');">
                </div>
            </div>
        </div>
    </div>
    <?php
}

if(isset($_GET["cancel_order"])){
    $order_id = $_GET["cancel_order"];
    $user = $_GET["user"];
    //delete from table
    $sql = "DELETE FROM bestillinger WHERE bestillingsid='$order_id'";
    mysqli_query($conn,$sql) or die (mysqli_error($conn));
    //print out minebestillinger
    ?>
    <h3>Mine bestillinger</h3>
    <?php
    $sql = "SELECT * FROM bestillinger WHERE brukernavn = '" . $user . "' ORDER BY bestillingsid DESC;";
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
            $bestillingsid = $row["bestillingsid"];
            $hotel_name = $row["hotellnavn"];
            $room_type = $row["romtype"];
            $check_in = date("Y-m-d",strtotime($row["fradato"]));
            $check_out = date("Y-m-d",strtotime($row["tildato"]));
            $price = $row["betpris"];
            $room_nr = $row["romnr"];
            $resultCounter++;
            ?>
            <tr id="order<?php echo$resultCounter;?>">
                <td id="bestillingsid<?php echo$resultCounter;?>"><?php echo$bestillingsid;?></td>
                <td id="hotel_name<?php echo$resultCounter;?>"><?php echo$hotel_name;?></td>
                <td id="room_type<?php echo$resultCounter;?>"><?php echo$room_type;?></td>
                <td id="check_in<?php echo$resultCounter;?>"><input type="date" readonly value="<?php echo date("Y-m-d",strtotime($row["fradato"]));?>"></td>
                <td id="check_out<?php echo$resultCounter;?>"><input type="date" readonly value="<?php echo date("Y-m-d",strtotime($row["tildato"]));?>"></td>
                <td id="price<?php echo$resultCounter;?>"><?php echo strrev(chunk_split(strrev($price),3, ' '));?>,-</td>
                <td id="room_nr<?php echo$resultCounter;?>"><?php echo$room_nr;?></td>
                <?php
                if($check_in > date("Y-m-d")){
                    ?>
                    <td><img class="cursor-pointer" width='16px' src='../includes/files/edit-property-16.png' alt='Rediger bestilling' onclick="editOrder('<?php echo$resultCounter;?>','<?php echo$user;?>',document.getElementById('bestillingsid<?php echo$resultCounter;?>').innerHTML, document.getElementById('hotel_name<?php echo$resultCounter;?>').innerHTML, document.getElementById('room_type<?php echo$resultCounter;?>').innerHTML, '<?php echo$check_in;?>', '<?php echo$check_out;?>', document.getElementById('price<?php echo$resultCounter;?>').innerHTML, document.getElementById('room_nr<?php echo$resultCounter;?>').innerHTML);"></td>
                    <td><img class='cursor-pointer' width='18px' src='../includes/files/cancel-16.png' alt='Kanseller bestilling' onclick="openModal('cancel<?php echo $resultCounter;?>')"></td>
                    <td id="loader<?php echo$resultCounter;?>"></td>
                    <?php
                }
                ?>
                <div id="modal<?php echo $resultCounter;?>">
                    <div id="modalcancel<?php echo $resultCounter;?>" class="modal">
                        <div class="modal-content" id="modal-content">
                            <span class="close" onclick="closeModal('cancel<?php echo $resultCounter;?>')">&times;</span>
                            <h3 class="modal-title">Bekreft kansellering</h3>
                            <div class="modal-entries" id="modal-entries">
                                <div class="modal-center">
                                    <p id="new-edit-price">Bekreft kansellering av bestilling #<?php echo $bestillingsid;?>.</p>
                                    <div id="loader"></div>
                                    <input class="confirm-button" type="button" name="order-edit-confirm" value="Bekreft" onclick="cancelOrder('<?php echo $bestillingsid;?>','<?php echo $user;?>')">
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
    <p>Ingen bestillinger registrert.</p>
    <?php
    }
    ?>
    </table>
    <?php
    echo "|$|";
    //print modal content
    ?>
    <div id="modalcancelconfirm" class="modal open">
        <div class="modal-content" id="modal-content">
            <span class="close" onclick="closeModal('cancelconfirm')">&times;</span>
            <h3 class="modal-title">Bekreft kansellering</h3>
            <div class="modal-entries" id="modal-entries">
                <div class="modal-center">
                    <p id="new-edit-price">Din bestilling er kansellert!</p>
                    <input class="confirm-button" type="button" name="order-edit-confirm" value="Lukk" onclick="closeModal('cancelconfirm');">
                </div>
            </div>
        </div>
    </div>
    <?php
}
if(isset($_GET["unedit"])){
    $resultCounter = $_GET["unedit"];
    $u = $_GET["u"];
    $oid = $_GET["oid"];
    $h = $_GET["h"];
    $rt = $_GET["rt"];
    $i = $_GET["i"];
    $o = $_GET["o"];
    $p = $_GET["p"];
    $rn = $_GET["rn"];
    ?>
    <td id="bestillingsid<?php echo$resultCounter;?>">
        <?php echo $oid;?>
    </td>
    <td id="hotel_name<?php echo$resultCounter;?>">
        <?php echo $h;?>
    </td>
    <td id="room_type<?php echo$resultCounter;?>">
        <?php echo $rt;?>
    </td>
    <td id="check_in<?php echo$resultCounter;?>"><input type="date" readonly value="<?php echo date("Y-m-d",strtotime($i));?>"></td>
    <td id="check_out<?php echo$resultCounter;?>"><input type="date" readonly value="<?php echo date("Y-m-d",strtotime($o));?>"></td>
    <td id="price<?php echo$resultCounter;?>">
        <?php echo trim(strrev(chunk_split(strrev($p),3, ' ')));?>,-
    </td>
    <td id="room_nr<?php echo$resultCounter;?>">
        <?php echo $rn;?>
    </td>
    <?php
if($i > date("Y-m-d")){
?>
    <td><img class="cursor-pointer" width='16px' src='../includes/files/edit-property-16.png' alt='Rediger bestilling' onclick="editOrder('<?php echo$resultCounter;?>','<?php echo $u;?>',document.getElementById('bestillingsid<?php echo$resultCounter;?>').innerHTML, document.getElementById('hotel_name<?php echo$resultCounter;?>').innerHTML, document.getElementById('room_type<?php echo$resultCounter;?>').innerHTML, '<?php echo$i;?>', '<?php echo$o;?>', document.getElementById('price<?php echo$resultCounter;?>').innerHTML, document.getElementById('room_nr<?php echo$resultCounter;?>').innerHTML);"></td>
    <td><img class='cursor-pointer' width='18px' src='../includes/files/cancel-16.png' alt='Kanseller bestilling' onclick="openModal('cancel<?php echo $resultCounter;?>')"></td>
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
                        <p id="cancel">Bekreft kansellering av bestilling #
                            <?php echo $oid;?>.</p>
                        <div id="loader"></div>
                        <input class="confirm-button" type="button" name="order-edit-confirm" value="Bekreft" onclick="cancelOrder('<?php echo $oid;?>','<?php echo $u;?>')">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>