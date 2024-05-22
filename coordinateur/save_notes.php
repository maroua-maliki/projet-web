<?php
include("../connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['module_id']) && isset($_POST['notes']) && isset($_POST['action'])) {
        $module_id = $_POST['module_id'];
        $stmt = $con->prepare("DELETE FROM note WHERE module_id = ?");
        $stmt->bind_param('i', $module_id);
        if ($stmt->execute()) {
            echo "Table 'note' cleared successfully.";
        } else {
            echo "Error clearing table: " . $stmt->error;
        }
        $notes = $_POST['notes'];
        $action = $_POST['action'];

        foreach ($notes as $student_id => $note) {
            $query = "INSERT INTO note (module_id, etudiant_id, note, action) 
                      VALUES (?, ?, ?, ?) 
                      ON DUPLICATE KEY UPDATE note=?, action=?";
            $stmt = $con->prepare($query);
            if ($stmt === false) {
                echo "Error preparing statement: " . $con->error;
                continue;
            }
            $stmt->bind_param('iiisis', $module_id, $student_id, $note, $action, $note, $action);
            if (!$stmt->execute()) {
                echo "Error executing statement: " . $stmt->error;
            }
        }

        echo "Les notes ont été enregistrées avec succès.";
        header("Location: indexnote.php");
        exit;
    } else {
        echo "Error: Module ID, notes, or action not set.";
    }
} else {
    echo "Error: Invalid request method.";
}
?>
