<?php include("headerVed.php"); ?>
<div class="loginVed">
    <form method="post" action="" id="loginFormV">
        <h3>Logg inn:</h3>
        <input type="text" placeholder="brukernavn" name="user"><br>
        <input type="password" placeholder="passord" name="password"><br>
        <input type="submit" name="login" value="Logg inn"><input type="reset" value="Nullstill">
</form>
</div>


<?php 
            
if (isset($_POST["login"])){
    print_r($_SESSION);
    $user = $_POST["user"];
    $pass = $_POST["password"];

    if($user && $pass){

        $SQL="SELECT passord FROM vedlikehold WHERE brukernavn='$user';";
        $sqlResult=mysqli_query($conn,$SQL) or die ("Ikke tilgang til database!<br>");

        $rows=mysqli_num_rows($sqlResult); 
        if($rows <= 1) 
        {
            //print_r(mysqli_fetch_array($sqlResult)[0]);
            if($pass==mysqli_fetch_array($sqlResult)[0]){
                $_SESSION["sess_userV"]=$user;
                header("Location: index.php");
            }
            else 
            {
                echo ("Vennligst sjekk om du har fylt ut riktig passord!");
            }

        }
        else
        {
            echo ("Fant ikke bruker!");
        }
    }
    else
    {
        echo ("Mangler brukernavn eller passord!");
    }
}
?>    





<?php include("../includes/footer.php"); ?>