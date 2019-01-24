<link rel="stylesheet" type="text/css" href="../includes/style.css">
<?php include("../includes/db.inc.php"); ?>
<script src="events.js"></script>
<div class="front-image">
<div class="search-div">
<form class="hotel-search" method="GET" action="searchResults.php">
    <div class="search-title">
        <h2 class="search-title-top">Søk her!</h2>
        <div class="locations">
            <select name="selected-location" id="selected-location" onchange="updateHotels(this.value);">
                <option value=''>--</option>
                <?php
                    $locations_sql = "SELECT DISTINCT sted FROM hotell";
                    $locations_result = mysqli_query($conn, $locations_sql);
                    $locations_resultCheck = mysqli_num_rows($locations_result);
                    if ($locations_resultCheck){
                        while($locations_row = mysqli_fetch_assoc($locations_result)){
                            echo "<option value='" . $locations_row['sted'] . "'>" . $locations_row['sted'] . "</option>";
                        }
                    }
                ?>
            </select>
            <p class="small-text">Velg ditt område</p>
        </div>
        <div class="hotels">
            <select name="selected-hotel" id="selected-hotel" onchange="updateRooms(this.value,true);">
                <option value="">--</option>
            </select>
            <p class="small-text">Velg ditt hotell</p>
        </div>
    </div>
    <hr>
    <div class="search-dates">
        <div class="check-in">
            <h4>Innsjekking</h4>
            <input type="date" name="check-in" id="check-in" onchange='updateCheckIn(this.value);' min="<?php echo date('Y-m-d',strtotime('+1 Day',strtotime(date('Y-m-d'))));?>" max="">
            <p class="small-text" id="check-in-day"></p>
        </div>
        <div class="check-out">
        <h4>Utsjekking</h4>
        <input type="date" name="check-out" id="check-out" onchange='updateCheckOut(this.value);' min="<?php echo date('Y-m-d',strtotime('+2 Day',strtotime(date('Y-m-d'))));?>">
        <p class="small-text" id="check-out-day"></p>
        </div>
        <div class="count-days">
            <div class="suitcase">
                <p id="count-days">0</p>
            </div>
            <p class="small-text" id="count-days-text">Netter</p>
        </div>
    </div>
    <hr>
    <?php if(isset($_SESSION["sess_userM"])){
    ?><div class="search">
        <div class="loader-div">
            <img class="loader" src="../includes/files/loader-64.gif" alt="">
        </div>
        <div class="search-button-div">
                <input class="search-button" type="submit" name="search" value="Søk" onclick="return validateSearch(document.getElementById('selected-location').value,document.getElementById('selected-hotel').value,document.getElementById('check-in').value,document.getElementById('check-out').value);">
            </div>
        </div></form>
    <?php } else {
            ?></form><div class="search">
            <div class="loader-div">
                <img class="loader" src="../includes/files/loader-64.gif" alt="">
            </div>
            <div class="search-button-div">
                <button class="search-button" id="modalBtn" onclick="return validateSearch(document.getElementById('selected-location').value,document.getElementById('selected-hotel').value,document.getElementById('check-in').value,document.getElementById('check-out').value,1);">Søk</button>
            </div>
        <?php }?>
        <div id="ajax"></div>
        </div>
    </div>
    <div id="modal1" class="modal">
        <div class="modal-content" id="modal-content">
            <span class="close" onclick="closeModal(1)">&times;</span>
            <h3 class="modal-title">Logg inn</h3>
            <div class="modal-entries" id="modal-entries">
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
                    <input class="confirm-button" type="button" name="order-confirm" value="Registrer" onclick="confirmRegister('0','0',document.getElementById('selected-location').value,document.getElementById('selected-hotel').value,document.getElementById('check-in').value,document.getElementById('check-out').value);">
                </div>
            </div>
        </div>
    </div>
    <div class="ajax-messages">
        <div id="ajax-locations"></div>
        <div id="ajax-hotels"></div>
        <div id="ajax-date"></div>
    </div>
</div>
