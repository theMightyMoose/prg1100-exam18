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
$_SESSION["sess_userM"] =  $user;
if(!isset($_SESSION["sess_userM"])){
  header("Location: login.php");
}
$location = $_GET["selected-location"];
$hotel = $_GET["selected-hotel"];
$check_in = $_GET["check-in"];
$check_out = $_GET["check-out"];
searchResult($user,$location,$hotel,$check_in,$check_out);
?>
</div>
</div>
</div>

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
<script>

</script>