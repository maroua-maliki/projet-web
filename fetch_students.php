<?php
include("connect.php");

if (isset($_GET['module_id'])) {
    $module_id = $_GET['module_id'];

    // Fetch the level associated with the module
    $module_query = "SELECT niveau_id FROM module WHERE id = '$module_id'";
    $module_result = mysqli_query($con, $module_query);
    $module = mysqli_fetch_assoc($module_result);
    $niveau_id = $module['niveau_id'];

    // Fetch students enrolled in the level
    $students_query = "
        SELECT u.id, u.nom, u.prenom, u.email,u.CNE
        FROM utilisateur u
        WHERE u.role = 'etudiant' AND u.niveau = '$niveau_id'
        ORDER BY u.nom ASC
    ";
    $students_result = mysqli_query($con, $students_query);

    echo '<table class="table text-start">'; // Ajoutez la classe text-start à la table
    echo '<thead class="table-secondary">';
    echo '<tr>';
    echo '<th scope="col">CNE</th>';
    echo '<th scope="col">Nom</th>';
    echo '<th scope="col">Prénom</th>';
    echo '<th scope="col">Email</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = mysqli_fetch_assoc($students_result)) {
    echo '<tr>';
    echo '<td>' . $row["CNE"] . '</td>';
    echo '<td>' . $row["nom"] . '</td>';
    echo '<td>' . $row["prenom"] . '</td>';
    echo '<td>' . $row["email"] . '</td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';

}
?>
