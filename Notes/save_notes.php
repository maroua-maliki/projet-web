<?php
include("../connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifiez si module_id est défini
    if (isset($_POST['module_id'])) {
        $module_id = $_POST['module_id'];

        // Efface les notes associées au module
        $stmt = $con->prepare("DELETE FROM note WHERE module_id = ?");
        $stmt->bind_param('i', $module_id);
        if ($stmt->execute()) {
            echo "Table 'note' cleared successfully.";
        } else {
            echo "Error clearing table: " . $stmt->error;
        }

        // Traiter la soumission du formulaire pour enregistrer les notes
        $notes = $_POST['notes'];
        $action = $_POST['action'];

        foreach ($notes as $student_id => $note) {
            $query = "INSERT INTO note (module_id, etudiant_id, note, action) 
                      VALUES (?, ?, ?, ?) 
                      ON DUPLICATE KEY UPDATE note=?, action=?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('iiisis', $module_id, $student_id, $note, $action, $note, $action);
            $stmt->execute();
        }

        echo "Les notes ont été enregistrées avec succès.";
        // Redirection après enregistrement
        header("Location: indexnote.php");
        exit;
    } else {
        // Gérer l'erreur si module_id n'est pas défini
        echo "Error: Module ID not set.";
    }
} else {
    // Gérer l'erreur si la méthode de requête n'est pas POST
    echo "Error: Invalid request method.";
}
?>
