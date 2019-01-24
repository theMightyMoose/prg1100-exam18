<?php include("../includes/header.php");
include("../includes/db.inc.php");
if(isset($_SESSION["sess_userM"])){
    header("Location: minside.php");
}
?>
<div id="modal1" class="modal open">
        <div class="modal-content" id="modal-content">
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
                    <input class="confirm-button" type="submit" name="order-confirm" value="Logg inn" onclick="login(document.getElementById('username').value,document.getElementById('password').value);">
                    <input class="confirm-button" type="submit" name="order-confirm" value="Registrer" onclick="register(0,0);">
                </div>
            </div>
        </div>
    </div>
<?php 
include("../includes/footer.php");
?>
</content>