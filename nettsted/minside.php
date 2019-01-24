<?php include("../includes/header.php");
if(isset($_GET["user"])){
    $_SESSION["sess_userM"] = $_GET["user"];
}
if (!isset($_SESSION["sess_userM"])){
    header("location: login.php?notset");
    }
?>
<div class="main-content">
    <div class="minside-interface">
        <h1 class="padbot-10">Min-side</h1>
        <div class="front-image">
<div class="search-div">
<form class="hotel-search" method="get" action="searchResults.php">
    <div class="search-title">
        <h2 class="search-title-top">Hotellsøk</h2>
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
    <div class="search">
        <div class="loader-div">
            <img class="loader" src="../includes/files/loader-64.gif" alt="">
        </div>
        <div class="search-button-div">
            <input class="search-button" type="submit" name="search" value="Søk">
        </div>
    </div>
    <div class="ajax-messages">
        <div id="ajax-locations"></div>
        <div id="ajax-hotels"></div>
        <div id="ajax-date"></div>
    </div>
    </form>
</div>
</div>
    </div>
    <div class="minside-menu">
        <ul class="minside-menu-ul">
            <li>Hei, <?php echo$_SESSION["sess_userM"];?></li>
            <a href="minside.php" class="minside-menu-ul-a" href="#"><li>Bestill hotell</li></a>
            <a href="bookings.php" class="minside-menu-ul-a" href="#"><li>Mine bestillinger</li></a>
        </ul>
    </div>
</div> 
<?php
include("../includes/footer.php");
?>