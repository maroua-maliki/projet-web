<?php
include("../connect.php");
session_start();
if(isset($_GET["id"])) {
    $id = mysqli_real_escape_string($con, $_GET["id"]); 
    $sql = "DELETE FROM utilisateur WHERE role='etudiant' && CNE = '$id'"; 
    
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: gererEtudiant.php?msg=L'etudiant est supprimmer avec succès");
    } else {
        echo "Failed: " . mysqli_error($con);
    }
} else {
    echo "ID not provided.";
}
?>
