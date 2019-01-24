<?php
include ("../includes/header.php");
?>
<div class="content">
<div class="front-image">
<div class="hotel-results" id="hotel-results">
    <div class="results-title">
        <h2 class="search-title-top">Søkeresultat</h2>
    </div>
    <hr>
<?php
include ("function.php");
if(isset($_GET["user"])){
    $user = $_GET["user"];
}
if(isset($_SESSION["sess_userM"])){
    $user = $_SESSION["sess_userM"];
}
if(isset($user)){
  $_SESSION["sess_userM"] =  $user;
}
$location = $_GET["location"];
locationResult($location);
?>
</div>
</div>
</div>
<?php
function locationResult($location){
    include("../includes/db.inc.php");
    $search_sql = "SELECT hotellnavn FROM hotell WHERE sted='$location'";
    $search_result = mysqli_query($conn, $search_sql);
    $search_resultCheck = mysqli_num_rows($search_result);
    if ($search_resultCheck){
        $entryCounter = 0;
        while($search_row = mysqli_fetch_assoc($search_result)){ //alle romtyper
          $entryCounter++;
            $search_hotel = $search_row["hotellnavn"];
              ?>
                <div class="result-entry">
                    <div class="result-entry-full">
                        <h3 class="title"><?php echo $search_hotel." ".$location;?></h3>
                        <div class="skrim">
                          <div class="thumbnail-container">
                              <div class="slideshow-container">
                              <?php
                              $img_sql = "SELECT filnavn FROM bilde WHERE hotellnavn='$search_hotel'";
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
                          <div class="location-hotel-rooms">
                            <h3>Tilgjengelige romtyper</h3>
                            <?php
                            $rt_sql = "SELECT romtype FROM hotellromtype WHERE hotellnavn = '$search_hotel'";
                            $rt_result = mysqli_query($conn, $rt_sql);
                            $rt_resultCheck = mysqli_num_rows($rt_result);
                            if($rt_resultCheck){
                              while($rt_row = mysqli_fetch_assoc($rt_result)){
                                ?>
                                <p><?php echo $rt_row["romtype"];?></p>
                                <?php
                              }
                            } else {
                              ?>
                              <p>Dette hotellet har ingen romtyper.</p>
                              <?php
                            }
                            ?>
                          </div>
                          <div class="location-booking">
                            <a class="nodecoration" href="../nettsted/login.php"><p class="search-button2 text-align-center margin-auto">Bestill</p></a>
                          </div>
                        </div>
                    </div>
                </div>
                <?php
        }
    }
}

?>
<script>
var slideIndex = 1;
function plusSlides(s,n) {
  showSlides(s,slideIndex += n);
}
function currentSlide(s,n) {
  showSlides(s,slideIndex = n);
}
function showSlides(s,n) {
  var i;
  var slides = document.getElementsByClassName("imgSlider"+s);
  var dots = document.getElementsByClassName("dot"+s);
  if (n > slides.length) {slideIndex = 1;}    
  if (n < 1) {slideIndex = slides.length;}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
function showSlideStart(){
    var slides = document.getElementsByClassName("slideshow-container");
    console.log(slides.length);
    for (i = 1; i <= slides.length; i++) {
        showSlides(i,1);
  }
}
showSlideStart();
</script>