<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants</title>
    <style></style>
</head>
<body>
    <div class="container">
        <br><br>
        <?php
        include("../connect.php");
        if (isset($_GET['module_id'])) {
            $module_id = $_GET['module_id'];

            // Fetch the level associated with the module
            $module_query = "SELECT niveau_id FROM module WHERE id = ?";
            $stmt = $con->prepare($module_query);
            $stmt->bind_param('i', $module_id);
            $stmt->execute();
            $module_result = $stmt->get_result();
            $module = $module_result->fetch_assoc();
            $niveau_id = $module['niveau_id'];

            // Fetch students enrolled in the level
            $students_query = "
                SELECT u.id, u.nom, u.prenom, u.email, u.CNE, n.note
                FROM utilisateur u
                LEFT JOIN note n ON u.id = n.etudiant_id AND n.module_id = ?
                WHERE u.role = 'etudiant' AND u.niveau = ?
                ORDER BY u.nom ASC
            ";
            $stmt = $con->prepare($students_query);
            $stmt->bind_param('ii', $module_id, $niveau_id);
            $stmt->execute();
            $students_result = $stmt->get_result();
            echo '<section class="table__body">';
            echo '<form action="save_notes.php" method="POST">';
            echo '<input type="hidden" name="module_id" value="' . htmlspecialchars($module_id) . '">';
            echo '<table class="table text-start">';
            echo '<thead class="table-secondary">';
            echo '<tr>';
            echo '<th scope="col">CNE</th>';
            echo '<th scope="col">Nom</th>';
            echo '<th scope="col">Prénom</th>';
            echo '<th scope="col">Email</th>';
            echo '<th scope="col">Note</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody c>';
            while ($row = $students_result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row["CNE"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["nom"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["prenom"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["email"]) . '</td>';
                echo '<td><input type="text" name="notes[' . htmlspecialchars($row["id"]) . ']" class="form-control" value="' . htmlspecialchars($row["note"]) . '"></td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '<button type="submit" name="action" value="sauvegarde" class="btn btn-success">Sauvegarder </button>';
            echo '<button type="submit" name="action" value="ajouter" class="btn btn-danger">Terminer</button>';
            echo '</form>';
            echo '</section>';
        }
        ?>
    </div>
</body>
</html>
<style>
        .table-container {
            border: 2px solid #ffffff; /* White border for the table */
            border-radius: 8px; /* Rounded corners */
            padding: 20px; /* Padding around the table */
            background-color: #f8f9fa; /* Light background color */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Light shadow */
        }
        a.module-link {
            color: #007bff; /* Blue color for links */
            text-decoration: none; /* No underline */
        }
        a.module-link:hover {
            text-decoration: underline; /* Underline on hover */
        }
    </style>