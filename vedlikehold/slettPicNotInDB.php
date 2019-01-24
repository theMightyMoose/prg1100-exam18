<?php include("../includes/db.inc.php"); ?>
<?php

$sql = "SELECT filnavn f FROM bilde;";
$sql2 = "SELECT filnavn f FROM lokasjoner;";

$result = mysqli_query($conn, $sql);
$result2 = mysqli_query($conn, $sql2);

$bildenavn = array();

while($rad = mysqli_fetch_array($result)){
    array_push($bildenavn,$rad["f"]);
}
while($rad = mysqli_fetch_array($result2)){
    array_push($bildenavn,$rad["f"]);
}

foreach(scandir("../uploads/") as $file){
    if($file == "." || $file==".."){
        
    } else {
        $filEKS = false;
        foreach($bildenavn as $navn){
            if($navn == $file){
                $filEKS = true;
            }
        }
        if($filEKS){
            
        } else {
            unlink("../uploads/".$file);
        }
    }
}
?>