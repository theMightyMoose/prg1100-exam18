<?php
include("../includes/db.inc.php");


$hotell = $_REQUEST["hotell"];
$sql="SELECT sted s FROM hotell WHERE hotellnavn='$hotell'";

$rad = mysqli_fetch_array(mysqli_query($conn, $sql));
echo($rad["s"]);

?>