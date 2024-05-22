<?php
include("../connect.php");

if (isset($_GET['module_id'])) {
    $module_id = $_GET['module_id'];

    // Fetch the level associated with the module and the students
    $module_query = "SELECT u.CNE, u.nom, u.prenom, u.email 
        FROM module m 
        INNER JOIN utilisateur u ON m.niveau_id = u.niveau
        WHERE m.id = '$module_id' AND u.role = 'etudiant'
        ORDER BY u.nom ASC";
     $module_result = mysqli_query($con, $module_query);
     if ($module_result) {
        echo '<table class="table text-start">';
        echo '<thead class="table-secondary">';
        echo '<tr>';
        echo '<th scope="col">CNE</th>';
        echo '<th scope="col">Nom</th>';
        echo '<th scope="col">Prénom</th>';
        echo '<th scope="col">Email</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while ($row = mysqli_fetch_assoc($module_result)) {
            echo '<tr>';
            echo '<td>' . $row["CNE"] . '</td>';
            echo '<td>' . $row["nom"] . '</td>';
            echo '<td>' . $row["prenom"] . '</td>';
            echo '<td>' . $row["email"] . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
