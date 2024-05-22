<?php
include("../connect.php");
session_start();
if(isset($_GET["id"])) {
    $id = mysqli_real_escape_string($con, $_GET["id"]); 
    $sql_delete_affectations = "DELETE FROM affectation_module_professeur WHERE professeur_id = '$id'";
    $result_delete_affectations = mysqli_query($con, $sql_delete_affectations);
    if ($result_delete_affectations) {
        $sql_delete_utilisateur = "DELETE FROM utilisateur WHERE role <> 'etudiant' AND id = '$id'"; 
        $result_delete_utilisateur = mysqli_query($con, $sql_delete_utilisateur);
        
        if ($result_delete_utilisateur) {
            header("Location: gererProf.php?msg=L'utilisateur a été supprimé avec succès");
        } else {
            echo "Failed to delete user: " . mysqli_error($con);
        }
    } else {
        echo "Failed to delete user's assignments: " . mysqli_error($con);
    }
} else {
    echo "ID not provided.";
}
?>
